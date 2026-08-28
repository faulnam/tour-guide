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
     * Simulate or process instant payment for a booking.
     */
    public function processSimulation(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $booking = Booking::findOrFail($id);

        $payType = $request->input('payment_type', 'dp'); // 'dp' or 'full'
        $payMethod = $request->input('payment_method', $booking->payment_method ?? 'qris');
        
        $amount = ($payType === 'full') 
            ? ($booking->total_amount > 0 ? $booking->total_amount : $booking->dp_amount)
            : $booking->dp_amount;

        $transactionCode = Payment::generateTransactionCode();

        // Create Payment record
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->customer_id ?? Auth::id(),
            'transaction_code' => $transactionCode,
            'amount' => $amount,
            'payment_type' => $payType,
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
        $newPaidAmount = $booking->paid_amount + $amount;
        $newPaymentStatus = ($newPaidAmount >= $booking->total_amount && $booking->total_amount > 0) ? 'paid' : 'dp_paid';

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
            'stage' => 'received',
            'title' => 'Pembayaran ' . strtoupper($payType) . ' Berhasil Dikonfirmasi',
            'description' => 'Pembayaran sebesar Rp ' . number_format($amount, 0, ',', '.') . ' via ' . strtoupper($payMethod) . ' berhasil terverifikasi. Transaksi: ' . $transactionCode,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikonfirmasi!',
                'redirect_url' => route('booking.checkout', $booking->booking_code),
            ]);
        }

        return redirect()->route('booking.checkout', $booking->booking_code)
                         ->with('success', 'Pembayaran sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil dikonfirmasi!');
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
