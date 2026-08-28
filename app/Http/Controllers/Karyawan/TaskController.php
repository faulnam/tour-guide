<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display list of assigned tasks.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $status = $request->query('status');

        $query = Booking::where('karyawan_id', $user->id)
            ->with(['service', 'customer']);

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->latest()->paginate(10);

        return view('karyawan.tasks.index', compact('tasks', 'status'));
    }

    /**
     * Show task details & update progress form.
     */
    public function show(int $id): View
    {
        $user = Auth::user();
        $task = Booking::where('id', $id)
            ->where('karyawan_id', $user->id)
            ->with(['service', 'customer', 'logs.user'])
            ->firstOrFail();

        return view('karyawan.tasks.show', compact('task'));
    }

    /**
     * Update progress stage, percentage, notes, and photos.
     */
    public function updateProgress(Request $request, int $id): RedirectResponse
    {
        $user = Auth::user();
        $task = Booking::where('id', $id)
            ->where('karyawan_id', $user->id)
            ->firstOrFail();

        $notes = $request->input('mechanic_notes', $request->input('admin_notes', $task->mechanic_notes));

        $validated = $request->validate([
            'status' => ['required', 'in:in_progress,qc,completed'],
            'progress_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'stage' => ['nullable', 'string'],
            'stage_title' => ['nullable', 'string', 'max:255'],
            'mechanic_notes' => ['nullable', 'string'],
            'admin_notes' => ['nullable', 'string'],
            'progress_photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('progress_photo')) {
            $photoPath = $request->file('progress_photo')->store('bookings', 'public');
            
            // Append to progress_photos array on booking
            $existingPhotos = $task->progress_photos ?? [];
            $existingPhotos[] = asset('storage/' . $photoPath);
            $task->progress_photos = $existingPhotos;
        }

        $task->status = $validated['status'];
        $task->progress_percentage = $validated['progress_percentage'];
        $task->mechanic_notes = $notes;
        $task->save();

        $stageTitle = $validated['stage_title'] ?? ('Progres ' . $validated['progress_percentage'] . '% — ' . match($validated['status']) {
            'qc' => 'QC & Dyno Test Selesai Dikalibrasi',
            'completed' => 'Pengerjaan Unit Rampung / Siap Diambil',
            default => 'Pembaruan Progres oleh Teknisi'
        });

        // Create log entry
        BookingLog::create([
            'booking_id' => $task->id,
            'user_id' => $user->id,
            'stage' => $validated['stage'] ?? $validated['status'],
            'title' => $stageTitle,
            'description' => $notes ?? ('Progres pengerjaan mencapai ' . $validated['progress_percentage'] . '% (' . ucfirst($validated['status']) . ').'),
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('karyawan.tasks.show', $task->id)
                         ->with('success', 'Status progres modifikasi berhasil diperbarui!');
    }
}
