<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show Customer Profile Hub (Jatidiri, Informasi Pesanan, Cek Garansi).
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $activeTab = $request->query('tab', 'identity');

        // 1. Informasi Pesanan: Active and History Bookings
        $activeBookings = Booking::where('customer_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'in_progress', 'qc'])
            ->with(['service', 'mechanic', 'payments', 'logs.user'])
            ->latest()
            ->get();

        $historyBookings = Booking::where('customer_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->with(['service', 'mechanic', 'payments', 'logs.user'])
            ->latest()
            ->paginate(10, ['*'], 'history_page');

        $allBookingsCount = Booking::where('customer_id', $user->id)->count();
        $completedBookingsCount = Booking::where('customer_id', $user->id)->where('status', 'completed')->count();

        // 2. Cek Garansi: List of completed bookings with warranty information
        $warrantyBookings = Booking::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->with(['service', 'mechanic'])
            ->latest('updated_at')
            ->get();

        // 3. User Registered Vehicles
        $vehicles = Vehicle::where('user_id', $user->id)->latest()->get();

        // 4. Quick Warranty Search Result if requested via GET query
        $warrantySearchResult = null;
        if ($searchQuery = trim($request->query('warranty_code', ''))) {
            $warrantySearchResult = Booking::where(function ($q) use ($searchQuery) {
                $q->where('booking_code', $searchQuery)
                  ->orWhere('license_plate', strtoupper($searchQuery));
            })
            ->with(['service', 'mechanic'])
            ->first();
        }

        return view('customer.profile', compact(
            'user',
            'activeTab',
            'activeBookings',
            'historyBookings',
            'allBookingsCount',
            'completedBookingsCount',
            'warrantyBookings',
            'vehicles',
            'warrantySearchResult'
        ));
    }

    /**
     * Update customer profile information (Jatidiri).
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($validated);

        return redirect()->route('customer.profile', ['tab' => 'identity'])
                         ->with('success', 'Data diri Anda berhasil diperbarui!');
    }

    /**
     * Update customer account password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('customer.profile', ['tab' => 'identity'])
                         ->with('success', 'Kata sandi akun Anda berhasil diganti!');
    }

    /**
     * Search and check warranty status.
     */
    public function checkWarranty(Request $request): RedirectResponse|View
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        $query = strtoupper(trim($validated['code']));

        $booking = Booking::where('booking_code', $query)
            ->orWhere('license_plate', $query)
            ->with(['service', 'mechanic', 'customer'])
            ->first();

        if ($request->wantsJson()) {
            return response()->json([
                'found' => (bool) $booking,
                'booking' => $booking,
            ]);
        }

        if (!$booking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor booking atau plat nomor "' . $query . '" tidak ditemukan dalam catatan pengerjaan.');
        }

        if (Auth::check()) {
            return redirect()->route('customer.profile', [
                'tab' => 'warranty',
                'warranty_code' => $booking->booking_code
            ])->with('success', 'Data garansi berhasil ditemukan!');
        }

        return view('customer.warranty-check', compact('booking'));
    }
}
