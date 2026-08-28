<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Rekap Absensi Karyawan with camera snapshots.
     */
    public function index(Request $request): View
    {
        $dateFilter = $request->query('date', Carbon::today()->toDateString());
        $employeeFilter = $request->query('user_id');
        $statusFilter = $request->query('status');

        $query = Attendance::with('user');

        if ($dateFilter) {
            $query->whereDate('date', $dateFilter);
        }

        if ($employeeFilter) {
            $query->where('user_id', $employeeFilter);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $attendances = $query->orderBy('date', 'desc')->latest('check_in_time')->paginate(15);
        $employees = User::where('role', 'karyawan')->orderBy('name')->get();

        // Summary counts for selected date
        $summary = [
            'total_karyawan' => $employees->count(),
            'hadir' => Attendance::whereDate('date', $dateFilter)->where('status', 'hadir')->count(),
            'terlambat' => Attendance::whereDate('date', $dateFilter)->where('status', 'terlambat')->count(),
            'izin' => Attendance::whereDate('date', $dateFilter)->where('status', 'izin')->count(),
            'sakit' => Attendance::whereDate('date', $dateFilter)->where('status', 'sakit')->count(),
        ];

        return view('admin.attendances.index', compact('attendances', 'employees', 'dateFilter', 'employeeFilter', 'statusFilter', 'summary'));
    }

    /**
     * Delete attendance record.
     */
    public function destroy(int $id): RedirectResponse
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('admin.attendances.index')
                         ->with('success', 'Data absensi berhasil dihapus.');
    }
}
