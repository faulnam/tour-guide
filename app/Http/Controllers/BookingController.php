<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Show interactive booking form.
     */
    public function index(Request $request): View
    {
        $selectedServiceId = $request->query('service_id');
        $selectedVehicleType = $request->query('vehicle_type', 'all');

        $services = Service::active()->ordered()->get();
        $userVehicles = Auth::check() ? Auth::user()->vehicles : collect();

        return view('booking.index', compact('services', 'selectedServiceId', 'selectedVehicleType', 'userVehicles'));
    }

    /**
     * Store new booking request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:25'],
            'vehicle_type' => ['required', 'in:motor,mobil'],
            'vehicle_brand' => ['required', 'string', 'max:100'],
            'vehicle_model' => ['required', 'string', 'max:100'],
            'license_plate' => ['required', 'string', 'max:20'],
            'vehicle_year' => ['nullable', 'string', 'max:10'],
            'vehicle_color' => ['nullable', 'string', 'max:50'],
            'service_id' => ['nullable', 'exists:services,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time_slot' => ['required', 'string'],
            'custom_request' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:midtrans,qris,virtual_account,bank_transfer,cash_workshop'],
            'save_vehicle' => ['nullable', 'boolean'],
        ]);

        $service = null;
        $totalAmount = 0;
        $dpAmount = 250000; // Default base DP Rp 250.000

        if (!empty($validated['service_id'])) {
            $service = Service::find($validated['service_id']);
            if ($service && $service->base_price > 0) {
                $totalAmount = $service->base_price;
                $dpAmount = max(250000, $totalAmount * 0.25); // DP 25% or min 250k
            }
        }

        $bookingCode = Booking::generateBookingCode();

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'customer_id' => Auth::id(),
            'service_id' => $service?->id,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_brand' => $validated['vehicle_brand'],
            'vehicle_model' => $validated['vehicle_model'],
            'license_plate' => strtoupper(trim($validated['license_plate'])),
            'vehicle_year' => $validated['vehicle_year'] ?? null,
            'vehicle_color' => $validated['vehicle_color'] ?? null,
            'booking_date' => $validated['booking_date'],
            'booking_time_slot' => $validated['booking_time_slot'],
            'custom_request' => $validated['custom_request'] ?? null,
            'status' => 'pending',
            'progress_percentage' => 0,
            'total_amount' => $totalAmount,
            'dp_amount' => $dpAmount,
            'paid_amount' => 0,
            'payment_status' => 'unpaid',
            'payment_method' => $validated['payment_method'],
        ]);

        // Create initial log
        BookingLog::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'stage' => 'received',
            'title' => 'Booking Berhasil Dibuat',
            'description' => 'Permintaan booking telah diterima oleh sistem. Kode Booking: ' . $bookingCode,
        ]);

        // If authenticated customer checked "save vehicle", save to garage
        if (Auth::check() && $request->boolean('save_vehicle')) {
            Vehicle::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'license_plate' => strtoupper(trim($validated['license_plate'])),
                ],
                [
                    'type' => $validated['vehicle_type'],
                    'brand' => $validated['vehicle_brand'],
                    'model' => $validated['vehicle_model'],
                    'year' => $validated['vehicle_year'] ?? null,
                    'color' => $validated['vehicle_color'] ?? null,
                ]
            );
        }

        return redirect()->route('booking.checkout', $booking->booking_code)
                         ->with('success', 'Booking berhasil didaftarkan! Silakan selesaikan pembayaran DP.');
    }

    /**
     * Show Payment Checkout Page.
     */
    public function checkout(string $bookingCode): View|RedirectResponse
    {
        $booking = Booking::with(['service', 'payments'])->where('booking_code', $bookingCode)->firstOrFail();

        // Get existing payment or create initial pending payment record
        $payment = $booking->payments()->latest()->first();

        if (!$payment) {
            $dpAmount = $booking->dp_amount > 0 ? $booking->dp_amount : 250000;
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->customer_id ?? (Auth::check() ? Auth::id() : null),
                'transaction_code' => Payment::generateTransactionCode(),
                'amount' => $dpAmount,
                'payment_type' => 'dp',
                'payment_method' => $booking->payment_method ?? 'qris',
                'payment_channel' => strtoupper($booking->payment_method ?? 'qris') . ' Simulator Gateway',
                'status' => in_array($booking->payment_status, ['paid', 'dp_paid']) ? 'settlement' : 'pending',
                'gateway_reference' => 'SIM-GW-' . strtoupper(substr(md5(uniqid()), 0, 10)),
            ]);
        }

        return view('booking.checkout', compact('booking', 'payment'));
    }

    /**
     * Update delivery / handover preferences (Diambil Sendiri vs Diantar ke Alamat).
     */
    public function updateDeliveryMethod(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'delivery_method' => ['required', 'in:pickup_workshop,delivery_address'],
            'delivery_address' => ['nullable', 'string', 'max:1000'],
            'delivery_notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validated['delivery_method'] === 'delivery_address' && empty($validated['delivery_address'])) {
            $validated['delivery_address'] = $request->input('customer_address') ?? (Auth::check() ? Auth::user()->address : null);
        }

        $booking->update([
            'delivery_method' => $validated['delivery_method'],
            'delivery_address' => $validated['delivery_address'] ?? null,
            'delivery_notes' => $validated['delivery_notes'] ?? null,
        ]);

        // Log delivery preference
        $methodLabel = $validated['delivery_method'] === 'delivery_address' 
            ? 'Diantar ke Alamat Customer (' . ($validated['delivery_address'] ?? 'Alamat Terdaftar') . ')'
            : 'Diambil Sendiri ke Workshop BENGKEL';

        BookingLog::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'stage' => $booking->status,
            'title' => 'Metode Penyerahan Unit Diperbarui',
            'description' => 'Customer memilih: ' . $methodLabel . ($validated['delivery_notes'] ? '. Catatan: ' . $validated['delivery_notes'] : ''),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pilihan penyerahan kendaraan berhasil disimpan!',
                'delivery_method' => $booking->delivery_method,
                'delivery_method_label' => $booking->delivery_method_label,
            ]);
        }

        return redirect()->back()->with('success', 'Pilihan metode penyerahan kendaraan berhasil disimpan!');
    }
}
