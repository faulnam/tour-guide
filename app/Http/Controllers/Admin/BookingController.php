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

        $validated = $request->validate([
            'karyawan_id' => ['nullable', 'exists:users,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'status' => ['required', 'in:pending,confirmed,in_progress,qc,completed,cancelled'],
            'progress_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'dp_amount' => ['required', 'numeric', 'min:0'],
            'paid_amount' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:unpaid,dp_paid,paid,refunded'],
            'mechanic_notes' => ['nullable', 'string'],
        ]);

        $prevStatus = $booking->status;
        $prevMekanik = $booking->karyawan_id;

        $booking->update($validated);

        // Auto create log if status changed or mechanic assigned
        if ($prevStatus !== $validated['status']) {
            BookingLog::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
                'stage' => $validated['status'],
                'title' => 'Status Booking Diperbarui: ' . ucfirst($validated['status']),
                'description' => 'Status pengerjaan diperbarui oleh Administrator.',
            ]);
        }

        if ($prevMekanik != $validated['karyawan_id'] && !empty($validated['karyawan_id'])) {
            $mekanik = User::find($validated['karyawan_id']);
            BookingLog::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
                'stage' => 'in_progress',
                'title' => 'Mekanik Ditugaskan: ' . ($mekanik?->name ?? '-'),
                'description' => 'Pengerjaan unit diserahkan kepada teknisi ' . ($mekanik?->name ?? '-'),
            ]);
        }

        return redirect()->route('admin.bookings.show', $booking->id)
                         ->with('success', 'Data booking modifikasi berhasil diperbarui!');
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
