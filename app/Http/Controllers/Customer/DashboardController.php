<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $activeBookings = Booking::where('customer_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'in_progress', 'qc'])
            ->with(['service', 'mechanic'])
            ->latest()
            ->get();

        $completedBookings = Booking::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $vehicles = Vehicle::where('user_id', $user->id)->get();

        $totalSpent = Booking::where('customer_id', $user->id)
            ->sum('paid_amount');

        return view('customer.dashboard', compact(
            'user',
            'activeBookings',
            'completedBookings',
            'vehicles',
            'totalSpent'
        ));
    }
}
