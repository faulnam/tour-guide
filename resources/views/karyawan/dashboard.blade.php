@extends('layouts.karyawan')

@section('meta_title', 'Dashboard Karyawan — Metrix Garage')

@section('content')
<div class="space-y-8">
    
    <div class="border-b border-neutral-200 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">Staff Dashboard</div>
            <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tight text-black font-sans">
                Halo, {{ auth()->user()->name }}
            </h1>
            <p class="text-xs text-neutral-500 mt-1">
                Spesialisasi: <span class="font-bold text-black">{{ auth()->user()->specialty ?? 'Teknisi & Master Modifikator' }}</span>
            </p>
        </div>
        <div>
            <a href="{{ route('karyawan.absensi.index') }}" class="btn-dark">
                📷 Absensi Kamera Sekarang
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white border border-neutral-200 p-6 space-y-2">
            <div class="eyebrow text-neutral-400 text-[10px]">Tugas Aktif Ditugaskan</div>
            <div class="text-3xl font-bold text-black">{{ $activeTasks }}</div>
            <div class="text-[11px] text-neutral-500">Unit kendaraan dalam pengerjaan Anda</div>
        </div>

        <div class="bg-white border border-neutral-200 p-6 space-y-2">
            <div class="eyebrow text-neutral-400 text-[10px]">Tugas Selesai</div>
            <div class="text-3xl font-bold text-emerald-600">{{ $completedTasks }}</div>
            <div class="text-[11px] text-neutral-500">Pengerjaan telah lulus QC</div>
        </div>

        <div class="bg-white border border-neutral-200 p-6 space-y-2">
            <div class="eyebrow text-neutral-400 text-[10px]">Total Kehadiran Bulan Ini</div>
            <div class="text-3xl font-bold text-black">{{ $monthlyAttendances }}</div>
            <div class="text-[11px] text-neutral-500">Hari kerja tercatat via kamera</div>
        </div>
    </div>

    <!-- Today Attendance & Tasks (2 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Assigned Tasks (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-neutral-100 pb-3">
                <div class="eyebrow text-black font-semibold">Tugas Pengerjaan Bengkel</div>
                <a href="{{ route('karyawan.tasks.index') }}" class="text-[11px] uppercase tracking-wider font-semibold text-black hover:text-accent">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="space-y-4">
                @forelse($recentTasks as $task)
                    <div class="p-4 bg-neutral-bg border border-neutral-200 space-y-3">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs font-bold text-black">{{ $task->service->title ?? 'Custom Package' }}</div>
                                <div class="text-[11px] text-neutral-500">{{ $task->vehicle_brand }} {{ $task->vehicle_model }} ({{ $task->license_plate }})</div>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] uppercase font-bold bg-white border border-neutral-300">
                                {{ $task->status }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-xs text-neutral-600 pt-2 border-t border-neutral-200">
                            <span>Progress: {{ $task->progress_percentage }}%</span>
                            <a href="{{ route('karyawan.tasks.show', $task->id) }}" class="font-bold text-black hover:underline">
                                Update Pengerjaan &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-neutral-400 text-xs">
                        Tidak ada tugas pekerjaan aktif yang ditugaskan ke Anda saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Attendance Summary (5 cols) -->
        <div class="lg:col-span-5 bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-neutral-100 pb-3">
                <div class="eyebrow text-black font-semibold">Status Presensi Hari Ini</div>
                <span class="text-[10px] text-neutral-400 font-mono">{{ date('d/m/Y') }}</span>
            </div>

            @if($todayAttendance)
                <div class="space-y-4 text-xs">
                    <div class="p-4 bg-neutral-bg border border-neutral-200 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-neutral-500">Jam Masuk (Clock In):</span>
                            <span class="font-bold text-emerald-700">{{ $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i:s') . ' WIB' : '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-neutral-500">Jam Pulang (Clock Out):</span>
                            <span class="font-bold text-amber-700">{{ $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i:s') . ' WIB' : 'Belum Absen Pulang' }}</span>
                        </div>
                    </div>

                    @if(!$todayAttendance->clock_out)
                        <a href="{{ route('karyawan.absensi.index') }}" class="btn-dark w-full text-center block">
                            Absen Pulang (Clock Out) &rarr;
                        </a>
                    @endif
                </div>
            @else
                <div class="space-y-4">
                    <p class="text-xs text-neutral-500">Anda belum melakukan absensi masuk shift hari ini.</p>
                    <a href="{{ route('karyawan.absensi.index') }}" class="btn-dark w-full text-center block">
                        Ambil Foto Absen Masuk &rarr;
                    </a>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
