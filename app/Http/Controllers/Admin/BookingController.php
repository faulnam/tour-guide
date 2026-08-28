<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display all workshop bookings with filters.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $vehicleType = $request->query('vehicle_type');
        $paymentStatus = $request->query('payment_status');
        $search = $request->query('search');

        $query = Booking::with(['service', 'mechanic', 'customer']);

        if ($status) {
            $query->where('status', $status);
        }
        if ($vehicleType) {
            $query->where('vehicle_type', $vehicleType);
        }
        if ($paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%")
                  ->orWhere('vehicle_model', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings', 'status', 'vehicleType', 'paymentStatus', 'search'));
    }

    /**
     * Show detailed booking info, build progress, mechanic notes, logs, invoice.
     */
    public function show(int $id): View
    {
        $booking = Booking::with(['service', 'mechanic', 'customer', 'payments', 'logs.user'])->findOrFail($id);
        $mechanics = User::where('role', 'karyawan')->where('is_active', true)->get();

        return view('admin.bookings.show', compact('booking', 'mechanics'));
    }

    /**
     * Edit booking form.
     */
    public function edit(int $id): View
    {
        $booking = Booking::findOrFail($id);
        $services = Service::active()->get();
        $mechanics = User::where('role', 'karyawan')->where('is_active', true)->get();

        return view('admin.bookings.edit', compact('booking', 'services', 'mechanics'));
    }

    /**
     * Update booking details.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        // Normalize input keys if submitted from legacy names
        $karyawanId = $request->input('karyawan_id', $request->input('mechanic_id', $booking->karyawan_id));
        $mechanicNotes = $request->input('mechanic_notes', $request->input('admin_notes', $booking->mechanic_notes));

        $validated = $request->validate([
            'karyawan_id' => ['nullable', 'exists:users,id'],
            'mechanic_id' => ['nullable', 'exists:users,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'status' => ['required', 'in:pending,confirmed,in_progress,qc,completed,cancelled'],
            'progress_percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'dp_amount' => ['nullable', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_status' => ['nullable', 'in:unpaid,dp_paid,paid,refunded'],
            'mechanic_notes' => ['nullable', 'string'],
            'admin_notes' => ['nullable', 'string'],
            'delivery_method' => ['nullable', 'in:pickup_workshop,delivery_address'],
            'delivery_address' => ['nullable', 'string', 'max:1000'],
            'delivery_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $status = $validated['status'];
        $prevStatus = $booking->status;
        $prevMekanik = $booking->karyawan_id;

        // Auto assign & transition if mechanic is chosen
        if (!empty($karyawanId) && $karyawanId != $prevMekanik && in_array($status, ['pending', 'confirmed'])) {
            $status = 'in_progress';
        }

        // Auto calculate / maintain progress percentage
        $progress = $request->input('progress_percentage');
        if ($progress === null || $progress === '') {
            $progress = match ($status) {
                'pending' => 0,
                'confirmed' => 10,
                'in_progress' => max(25, (int) $booking->progress_percentage),
                'qc' => max(85, (int) $booking->progress_percentage),
                'completed' => 100,
                'cancelled' => 0,
                default => (int) $booking->progress_percentage,
            };
        } else {
            $progress = (int) $progress;
        }

        // Financials synchronization
        $totalAmount = $request->filled('total_amount') ? (float) $request->input('total_amount') : (float) $booking->total_amount;
        $dpAmount = $request->filled('dp_amount') ? (float) $request->input('dp_amount') : (float) $booking->dp_amount;
        $paymentStatus = $validated['payment_status'] ?? $booking->payment_status;

        $paidAmount = $request->filled('paid_amount') ? (float) $request->input('paid_amount') : (float) $booking->paid_amount;
        if ($paymentStatus === 'paid' && $paidAmount < $totalAmount) {
            $paidAmount = $totalAmount;
        } elseif ($paymentStatus === 'dp_paid' && $paidAmount == 0) {
            $paidAmount = $dpAmount;
        } elseif ($paymentStatus === 'unpaid') {
            $paidAmount = 0;
        }

        $bookingUpdateData = [
            'karyawan_id' => $karyawanId ?: null,
            'service_id' => $validated['service_id'] ?? $booking->service_id,
            'status' => $status,
            'progress_percentage' => $progress,
            'total_amount' => $totalAmount,
            'dp_amount' => $dpAmount,
            'paid_amount' => $paidAmount,
            'payment_status' => $paymentStatus,
            'mechanic_notes' => $mechanicNotes,
        ];

        if ($request->has('delivery_method')) {
            $bookingUpdateData['delivery_method'] = $validated['delivery_method'];
            $bookingUpdateData['delivery_address'] = $validated['delivery_address'] ?? null;
            $bookingUpdateData['delivery_notes'] = $validated['delivery_notes'] ?? null;
        }

        $booking->update($bookingUpdateData);

        // Auto create log if status changed or mechanic assigned
        if ($prevStatus !== $status) {
            BookingLog::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
                'stage' => $status,
                'title' => 'Status Booking: ' . $booking->status_label,
                'description' => 'Status pengerjaan diperbarui oleh Administrator.',
            ]);
        }

        if ($prevMekanik != $karyawanId && !empty($karyawanId)) {
            $mekanik = User::find($karyawanId);
            BookingLog::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
                'stage' => 'in_progress',
                'title' => 'Mekanik Ditugaskan: ' . ($mekanik?->name ?? '-'),
                'description' => 'Pengerjaan unit diserahkan kepada teknisi ' . ($mekanik?->name ?? '-') . ' (' . ($mekanik?->specialty ?? 'Workshop Specialist') . ').',
            ]);
        }

        return redirect()->route('admin.bookings.show', $booking->id)
                         ->with('success', 'Data booking modifikasi dan penugasan mekanik berhasil disimpan!');
    }

    /**
     * Delete booking.
     */
    public function destroy(int $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')
                         ->with('success', 'Data booking berhasil dihapus.');
    }
}
