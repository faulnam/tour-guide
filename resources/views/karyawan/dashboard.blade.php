@extends('layouts.karyawan')

@section('meta_title', 'Dashboard Pemandu Wisata — Nusantara Tour Guide')

@section('content')
<div class="space-y-8">
    
    <div class="border-b border-gray-100 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="eyebrow text-sage font-bold">Portal Pemandu Wisata Resmi</div>
            <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tight text-primary font-sans">
                Selamat Bertugas, {{ auth()->user()->name }}
            </h1>
            <p class="text-xs text-gray-500 mt-1">
                Keahlian Wilayah: <span class="font-bold text-primary">{{ auth()->user()->specialty ?? 'Pemandu Budaya, Bahari & Alam Indonesia' }}</span>
            </p>
        </div>
        <div>
            <a href="{{ route('karyawan.absensi.index') }}" class="btn-primary shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-camera"></i>
                <span>Absensi Kamera GPS &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="tour-card p-6 space-y-2 bg-white">
            <div class="eyebrow text-sage font-bold text-[10px]">Trip Aktif Ditugaskan</div>
            <div class="text-3xl font-bold text-primary">{{ $activeTasks->count() }}</div>
            <div class="text-[11px] text-gray-500">Jadwal trip &amp; rombongan dalam pendampingan Anda</div>
        </div>

        <div class="tour-card p-6 space-y-2 bg-white">
            <div class="eyebrow text-sage font-bold text-[10px]">Trip Selesai Dipandu</div>
            <div class="text-3xl font-bold text-primary">{{ $completedTasksCount }}</div>
            <div class="text-[11px] text-gray-500">Ekspedisi wisata sukses terlaksana</div>
        </div>

        <div class="tour-card p-6 space-y-2 bg-white">
            <div class="eyebrow text-sage font-bold text-[10px]">Presensi Bulan Ini</div>
            <div class="text-3xl font-bold text-primary">{{ $monthlyAttendances }}</div>
            <div class="text-[11px] text-gray-500">Hari pendampingan tercatat via kamera selfie GPS</div>
        </div>
    </div>

    <!-- Today Attendance & Tasks (2 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Assigned Tasks (7 cols) -->
        <div class="lg:col-span-7 tour-card p-6 md:p-8 space-y-6 bg-white">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="eyebrow text-primary font-bold">Penugasan Trip Wisata</div>
                <a href="{{ route('karyawan.tasks.index') }}" class="text-[11px] uppercase tracking-wider font-bold text-primary hover:text-sage flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="space-y-4">
                @forelse($activeTasks as $task)
                    <div class="p-4 bg-[#F8FAF9] rounded-xl border border-gray-100 space-y-3 shadow-soft">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs font-bold text-primary">{{ $task->service->title ?? 'Private Guided Tour' }}</div>
                                <div class="text-[11px] text-gray-600 mt-0.5">Destinasi: <strong>{{ $task->vehicle_brand }}</strong> &bull; Tamu: <strong>{{ $task->customer_name }}</strong> ({{ $task->license_plate }})</div>
                            </div>
                            <span class="px-2.5 py-1 text-[9px] uppercase font-bold rounded-full bg-sage-light text-sage border border-sage/30">
                                {{ $task->status_label ?? $task->status }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-600 pt-2 border-t border-gray-200">
                            <span>Progress Ekspedisi: <strong>{{ $task->progress_percentage }}%</strong></span>
                            <a href="{{ route('karyawan.tasks.show', $task->id) }}" class="font-bold text-primary hover:text-sage flex items-center gap-1">
                                <span>Update Log &amp; Foto</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400 text-xs">
                        Tidak ada jadwal penugasan trip aktif yang ditugaskan ke Anda saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Attendance Summary (5 cols) -->
        <div class="lg:col-span-5 tour-card p-6 md:p-8 space-y-6 bg-white">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="eyebrow text-primary font-bold">Status Presensi Hari Ini</div>
                <span class="text-[10px] text-gray-500 font-mono">{{ date('d/m/Y') }}</span>
            </div>

            @if($todayAttendance)
                <div class="space-y-4 text-xs">
                    <div class="p-4 bg-[#F8FAF9] rounded-xl border border-gray-100 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Jam Mulai Tugas (Check-in):</span>
                            <span class="font-bold text-primary">{{ $todayAttendance->check_in_time ? substr($todayAttendance->check_in_time, 0, 5) . ' WITA' : '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Jam Selesai Tugas (Check-out):</span>
                            <span class="font-bold text-primary">{{ $todayAttendance->check_out_time ? substr($todayAttendance->check_out_time, 0, 5) . ' WITA' : 'Belum Check-out' }}</span>
                        </div>
                    </div>

                    @if(!$todayAttendance->check_out_time)
                        <a href="{{ route('karyawan.absensi.index') }}" class="btn-primary w-full text-center block shadow-sm">
                            Absen Selesai Tugas (Check Out) &rarr;
                        </a>
                    @endif
                </div>
            @else
                <div class="space-y-4">
                    <p class="text-xs text-gray-600">Anda belum melakukan absensi masuk penugasan hari ini.</p>
                    <a href="{{ route('karyawan.absensi.index') }}" class="btn-primary w-full text-center block shadow-sm">
                        Ambil Foto Absen Masuk &rarr;
                    </a>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
