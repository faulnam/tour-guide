<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Absensi hari ini
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // Tugas pengerjaan aktif (assigned to this mechanic)
        $activeTasks = Booking::where('karyawan_id', $user->id)
            ->whereIn('status', ['confirmed', 'in_progress', 'qc'])
            ->with('service')
            ->latest()
            ->get();

        // Tugas selesai
        $completedTasksCount = Booking::where('karyawan_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Rekap kehadiran bulan ini
        $monthlyAttendances = Attendance::where('user_id', $user->id)
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->count();

        return view('karyawan.dashboard', compact(
            'user',
            'todayAttendance',
            'activeTasks',
            'completedTasksCount',
            'monthlyAttendances'
        ));
    }
}
