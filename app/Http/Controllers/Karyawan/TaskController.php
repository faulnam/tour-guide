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
    public function index(): View
    {
        $user = Auth::user();
        $tasks = Booking::where('karyawan_id', $user->id)
            ->with(['service', 'customer'])
            ->latest()
            ->paginate(10);

        return view('karyawan.tasks.index', compact('tasks'));
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

        $validated = $request->validate([
            'status' => ['required', 'in:in_progress,qc,completed'],
            'progress_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'stage' => ['required', 'string'],
            'stage_title' => ['required', 'string', 'max:255'],
            'mechanic_notes' => ['nullable', 'string'],
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
        if (!empty($validated['mechanic_notes'])) {
            $task->mechanic_notes = $validated['mechanic_notes'];
        }
        $task->save();

        // Create log entry
        BookingLog::create([
            'booking_id' => $task->id,
            'user_id' => $user->id,
            'stage' => $validated['stage'],
            'title' => $validated['stage_title'],
            'description' => $validated['mechanic_notes'] ?? 'Progres pengerjaan diperbarui oleh mekanik.',
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('karyawan.tasks.show', $task->id)
                         ->with('success', 'Status progres modifikasi berhasil diperbarui!');
    }
}
