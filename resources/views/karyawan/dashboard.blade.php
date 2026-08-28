@extends('layouts.karyawan')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="space-y-8">
    
    <!-- Staff Welcome Header Banner -->
    <div class="bg-gradient-to-r from-neutral-900 via-[#181824] to-[#251b14] border border-neutral-800 rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl">
        <div class="space-y-2 text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase bg-amber-500/20 text-amber-400 border border-amber-500/30">
                <i class="fa-solid fa-id-card"></i>
                <span>Portal Mekanik & Karyawan Bengkel</span>
            </div>
            <h1 class="font-racing font-bold text-2xl sm:text-3xl text-white">
                Halo, {{ $user->name }}!
            </h1>
            <p class="text-xs text-neutral-400">
                Spesialisasi: <span class="text-amber-400 font-bold">{{ $user->specialty ?? 'Mekanik Workshop' }}</span> • Tanggal: <span class="text-white">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </p>
        </div>

        <!-- Quick Camera Attendance Action -->
        <div class="flex-shrink-0">
            @if(!$todayAttendance || !$todayAttendance->check_in_time)
                <a href="{{ route('karyawan.absensi') }}" 
                   class="px-6 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-black font-racing font-black text-xs uppercase tracking-wider rounded-2xl shadow-xl shadow-amber-600/30 hover:scale-105 transition-all flex items-center gap-2.5">
                    <i class="fa-solid fa-camera text-base"></i>
                    <span>AMBIL ABSENSI MASUK SEKARANG</span>
                </a>
            @elseif(!$todayAttendance->check_out_time)
                <a href="{{ route('karyawan.absensi') }}" 
                   class="px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-racing font-black text-xs uppercase tracking-wider rounded-2xl shadow-xl shadow-red-600/30 hover:scale-105 transition-all flex items-center gap-2.5">
                    <i class="fa-solid fa-camera text-base"></i>
                    <span>AMBIL ABSENSI PULANG</span>
                </a>
            @else
                <div class="px-5 py-3 bg-emerald-950/60 border border-emerald-500/40 rounded-2xl text-emerald-400 text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-base"></i>
                    <span>Absensi Hari Ini Lengkap</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <!-- Status Absensi Hari Ini -->
        <div class="bg-[#121218] border border-neutral-800 rounded-2xl p-6 space-y-3">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Status Kehadiran Hari Ini</span>
                <i class="fa-solid fa-camera text-amber-400"></i>
            </div>
            @if($todayAttendance && $todayAttendance->check_in_time)
                <div class="text-sm font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    <span>Masuk: {{ $todayAttendance->check_in_time }} WIB</span>
                </div>
                <div class="text-xs text-neutral-400">
                    Pulang: {{ $todayAttendance->check_out_time ? $todayAttendance->check_out_time . ' WIB' : 'Sedang Bertugas' }}
                </div>
            @else
                <div class="text-sm font-bold text-red-400 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                    <span>Belum Melakukan Absensi</span>
                </div>
                <div class="text-xs text-neutral-400">Silakan buka menu Absensi Kamera</div>
            @endif
        </div>

        <!-- Tugas Pengerjaan Aktif -->
        <div class="bg-[#121218] border border-neutral-800 rounded-2xl p-6 space-y-3">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Unit Sedang Dikerjakan</span>
                <i class="fa-solid fa-screwdriver-wrench text-red-400"></i>
            </div>
            <div class="font-racing font-black text-3xl text-white">
                {{ $activeTasks->count() }} <span class="text-xs text-neutral-400 font-sans font-normal">Kendaraan</span>
            </div>
            <div class="text-xs text-neutral-400">Tugas modifikasi dalam penanganan Anda</div>
        </div>

        <!-- Kehadiran Bulan Ini -->
        <div class="bg-[#121218] border border-neutral-800 rounded-2xl p-6 space-y-3">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Total Kehadiran Bulan Ini</span>
                <i class="fa-solid fa-calendar-check text-emerald-400"></i>
            </div>
            <div class="font-racing font-black text-3xl text-emerald-400">
                {{ $monthlyAttendances }} <span class="text-xs text-neutral-400 font-sans font-normal">Hari Kerja</span>
            </div>
            <div class="text-xs text-neutral-400">Rekap absensi kamera tercatat otomatis</div>
        </div>

    </div>

    <!-- Active Tasks Table -->
    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-racing font-bold text-lg text-white">TUGAS PENGERJAAN KENDARAAN</h3>
                <p class="text-xs text-neutral-400">Daftar booking modifikasi yang ditugaskan ke Anda:</p>
            </div>
            <a href="{{ route('karyawan.tasks.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300">Lihat Semua &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#0a0a0e] text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Kode & Unit</th>
                        <th class="p-3.5">Customer</th>
                        <th class="p-3.5">Layanan Modifikasi</th>
                        <th class="p-3.5">Status Pengerjaan</th>
                        <th class="p-3.5">Progres</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($activeTasks as $task)
                        <tr class="hover:bg-neutral-900/50 transition-colors">
                            <td class="p-3.5">
                                <div class="font-mono font-bold text-white">{{ $task->booking_code }}</div>
                                <div class="text-[11px] text-neutral-400">{{ $task->vehicle_type_label }} {{ $task->vehicle_brand }} {{ $task->vehicle_model }} ({{ $task->license_plate }})</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-white">{{ $task->customer_name }}</div>
                                <div class="text-[11px] text-neutral-500">{{ $task->customer_phone }}</div>
                            </td>
                            <td class="p-3.5">
                                <span class="text-amber-400 font-semibold">{{ $task->service->title ?? 'Custom Tuning' }}</span>
                            </td>
                            <td class="p-3.5">
                                {!! $task->status_badge !!}
                            </td>
                            <td class="p-3.5">
                                <div class="w-32 bg-neutral-800 rounded-full h-2 overflow-hidden mb-1">
                                    <div class="bg-gradient-to-r from-amber-500 to-red-500 h-2 rounded-full" style="width: {{ $task->progress_percentage }}%"></div>
                                </div>
                                <span class="text-[10px] font-mono text-neutral-400">{{ $task->progress_percentage }}% Selesai</span>
                            </td>
                            <td class="p-3.5 text-right">
                                <a href="{{ route('karyawan.tasks.show', $task->id) }}" 
                                   class="px-3 py-1.5 bg-neutral-800 hover:bg-amber-600 hover:text-black text-white rounded-lg font-bold text-[11px] transition-all inline-flex items-center gap-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Update Progres
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-neutral-500">
                                <i class="fa-solid fa-circle-check text-2xl text-neutral-700 mb-2 block"></i>
                                Tidak ada tugas modifikasi aktif saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
