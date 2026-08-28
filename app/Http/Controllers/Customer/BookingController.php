<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * List all customer bookings.
     */
    public function index(): View
    {
        $user = Auth::user();
        $bookings = Booking::where('customer_id', $user->id)
            ->with(['service', 'mechanic'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Show detailed booking view with real-time build progress tracker & digital invoice.
     */
    public function show(int $id): View
    {
        $user = Auth::user();
        $booking = Booking::where('id', $id)
            ->where('customer_id', $user->id)
            ->with(['service', 'mechanic', 'payments', 'logs.user'])
            ->firstOrFail();

        return view('customer.bookings.show', compact('booking'));
    }
}
