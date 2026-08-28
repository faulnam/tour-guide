<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    /**
     * Show live camera absensi page & monthly records.
     */
    public function index(): View
    {
        $user = Auth::user();
        $today = Carbon::today();

        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('karyawan.absensi.index', compact('todayAttendance', 'attendances'));
    }

    /**
     * Handle Camera Check-in snapshot.
     */
    public function checkIn(Request $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $today = Carbon::today();

        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing && $existing->check_in_time) {
            return $this->responseFeedback($request, false, 'Anda sudah melakukan absensi masuk hari ini.');
        }

        $imageData = $request->input('image_data', $request->input('photo'));
        if (!$imageData) {
            return $this->responseFeedback($request, false, 'Foto snapshot absensi kamera wajib diambil.');
        }

        $photoPath = $this->saveBase64Image($imageData, 'checkin_' . $user->id);

        $now = Carbon::now();
        // Jam masuk standar 08:30
        $status = ($now->format('H:i') > '08:30') ? 'terlambat' : 'hadir';

        Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $today->toDateString()],
            [
                'check_in_time' => $now->toTimeString(),
                'check_in_photo' => $photoPath,
                'check_in_lat' => $request->input('latitude'),
                'check_in_lng' => $request->input('longitude'),
                'status' => $status,
                'notes' => $request->input('notes'),
            ]
        );

        $msg = 'Absensi Masuk berhasil dicatat! Status: ' . ($status === 'terlambat' ? 'Terlambat' : 'Hadir Tepat Waktu');
        return $this->responseFeedback($request, true, $msg);
    }

    /**
     * Handle Camera Check-out snapshot.
     */
    public function checkOut(Request $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in_time) {
            return $this->responseFeedback($request, false, 'Anda belum melakukan absensi masuk hari ini.');
        }

        if ($attendance->check_out_time) {
            return $this->responseFeedback($request, false, 'Anda sudah melakukan absensi pulang hari ini.');
        }

        $imageData = $request->input('image_data', $request->input('photo'));
        if (!$imageData) {
            return $this->responseFeedback($request, false, 'Foto snapshot absensi kamera wajib diambil.');
        }

        $photoPath = $this->saveBase64Image($imageData, 'checkout_' . $user->id);
        $now = Carbon::now();

        $attendance->update([
            'check_out_time' => $now->toTimeString(),
            'check_out_photo' => $photoPath,
            'check_out_lat' => $request->input('latitude'),
            'check_out_lng' => $request->input('longitude'),
            'work_summary' => $request->input('work_summary', $request->input('notes')),
        ]);

        return $this->responseFeedback($request, true, 'Absensi Pulang berhasil dicatat! Terima kasih atas dedikasi Anda hari ini.');
    }

    /**
     * Helper to save base64 image data to public storage.
     */
    protected function saveBase64Image(string $base64String, string $prefix): string
    {
        // Extract raw data from base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'webp'])) {
                $type = 'jpg';
            }
        } else {
            $type = 'jpg';
        }

        $data = base64_decode($base64String);
        if ($data === false) {
            return '';
        }

        $filename = 'absensi/' . $prefix . '_' . time() . '_' . Str::random(6) . '.' . $type;
        Storage::disk('public')->put($filename, $data);

        return $filename;
    }

    /**
     * Response helper for JSON or regular redirect.
     */
    protected function responseFeedback(Request $request, bool $success, string $message): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => $success,
                'message' => $message,
            ], $success ? 200 : 422);
        }

        return redirect()->route('karyawan.absensi.index')
                         ->with($success ? 'success' : 'error', $message);
    }
}
