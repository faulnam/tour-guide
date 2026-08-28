<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Simulate or process instant payment for a booking (DP or Pelunasan Sisa Tagihan).
     */
    public function processSimulation(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $booking = Booking::findOrFail($id);

        $payType = $request->input('payment_type', 'dp'); // 'dp', 'remaining', 'settlement', 'full'
        $payMethod = $request->input('payment_method', $booking->payment_method ?? 'qris');
        
        $totalAmount = (float) ($booking->total_amount > 0 ? $booking->total_amount : ($booking->service->price ?? 0));
        $paidAmount = (float) $booking->paid_amount;
        $remainingAmount = max(0, $totalAmount - $paidAmount);

        if (in_array($payType, ['remaining', 'settlement', 'pelunasan'])) {
            $amount = $remainingAmount > 0 ? $remainingAmount : $totalAmount;
            $payTypeLabel = 'Pelunasan Sisa Tagihan';
        } elseif ($payType === 'full') {
            $amount = $totalAmount > 0 ? $totalAmount : ($booking->dp_amount > 0 ? $booking->dp_amount : 250000);
            $payTypeLabel = 'Pembayaran Penuh (Full Payment)';
        } else {
            $amount = $booking->dp_amount > 0 ? (float) $booking->dp_amount : 250000;
            $payTypeLabel = 'Pembayaran Down Payment (DP)';
        }

        $transactionCode = Payment::generateTransactionCode();

        // Create Payment record
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->customer_id ?? (Auth::check() ? Auth::id() : null),
            'transaction_code' => $transactionCode,
            'amount' => $amount,
            'payment_type' => in_array($payType, ['remaining', 'settlement', 'pelunasan', 'full']) ? 'full' : 'dp',
            'payment_method' => $payMethod,
            'payment_channel' => strtoupper($payMethod) . ' Simulator Gateway',
            'status' => 'settlement',
            'gateway_reference' => 'SIM-GW-' . strtoupper(substr(md5(uniqid()), 0, 10)),
            'raw_response' => [
                'status_code' => '200',
                'status_message' => 'Success simulated payment transaction',
                'transaction_id' => $transactionCode,
                'fraud_status' => 'accept',
            ],
            'paid_at' => Carbon::now(),
        ]);

        // Update booking payment status
        $newPaidAmount = $paidAmount + $amount;
        if ($totalAmount > 0 && $newPaidAmount >= $totalAmount) {
            $newPaidAmount = max($newPaidAmount, $totalAmount);
            $newPaymentStatus = 'paid';
        } else {
            $newPaymentStatus = ($newPaidAmount > 0) ? 'dp_paid' : 'unpaid';
        }

        $booking->update([
            'paid_amount' => $newPaidAmount,
            'payment_status' => $newPaymentStatus,
            'payment_method' => $payMethod,
            'payment_ref' => $payment->gateway_reference,
            'status' => ($booking->status === 'pending') ? 'confirmed' : $booking->status,
        ]);

        // Log payment
        BookingLog::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'stage' => $booking->status,
            'title' => $payTypeLabel . ' Berhasil Dikonfirmasi',
            'description' => $payTypeLabel . ' sebesar Rp ' . number_format($amount, 0, ',', '.') . ' via ' . strtoupper($payMethod) . ' berhasil terverifikasi. Transaksi: ' . $transactionCode,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $payTypeLabel . ' berhasil dikonfirmasi!',
                'redirect_url' => route('booking.checkout', $booking->booking_code),
            ]);
        }

        return redirect()->route('booking.checkout', $booking->booking_code)
                         ->with('success', $payTypeLabel . ' sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil dikonfirmasi!');
    }

    /**
     * Webhook endpoint for real Midtrans/Gateway notifications
     */
    public function webhook(Request $request): JsonResponse
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;

        if (!$orderId) {
            return response()->json(['status' => 'error', 'message' => 'Invalid order_id'], 400);
        }

        $booking = Booking::where('booking_code', $orderId)->first();
        if ($booking && in_array($transactionStatus, ['capture', 'settlement'])) {
            $booking->update([
                'payment_status' => 'dp_paid',
                'status' => ($booking->status === 'pending') ? 'confirmed' : $booking->status,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
