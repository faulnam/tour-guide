<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        // Financial & Booking stats
        $totalRevenue = Booking::whereIn('payment_status', ['dp_paid', 'paid'])->sum('paid_amount');
        $activeBookingsCount = Booking::whereIn('status', ['confirmed', 'in_progress', 'qc'])->count();
        $pendingBookingsCount = Booking::where('status', 'pending')->count();
        $completedBookingsCount = Booking::where('status', 'completed')->count();

        // Vehicle distribution
        $carBookingsCount = Booking::where('vehicle_type', 'mobil')->count();
        $motorBookingsCount = Booking::where('vehicle_type', 'motor')->count();

        // Mechanics attendance today
        $totalMechanics = User::where('role', 'karyawan')->count();
        $presentTodayCount = Attendance::whereDate('date', $today)->whereNotNull('check_in_time')->count();

        // Recent Bookings
        $recentBookings = Booking::with(['service', 'mechanic'])
            ->latest()
            ->take(6)
            ->get();

        // Today's Attendance Feed (with Camera Snapshots)
        $todayAttendances = Attendance::with('user')
            ->whereDate('date', $today)
            ->latest()
            ->take(5)
            ->get();

        // Total users & content
        $totalCustomers = User::where('role', 'customer')->count();
        $totalServices = Service::count();
        $totalProjects = Project::count();
        $unreadMessagesCount = ContactMessage::where('is_read', false)->count();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'activeBookingsCount',
            'pendingBookingsCount',
            'completedBookingsCount',
            'carBookingsCount',
            'motorBookingsCount',
            'totalMechanics',
            'presentTodayCount',
            'recentBookings',
            'todayAttendances',
            'totalCustomers',
            'totalServices',
            'totalProjects',
            'unreadMessagesCount'
        ));
    }
}
