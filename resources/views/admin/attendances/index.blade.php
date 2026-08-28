@extends('layouts.admin')

@section('title', 'Rekap Absensi Kamera Karyawan')

@section('content')
<div class="space-y-6" x-data="{ selectedPhoto: null }">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-camera text-amber-400"></i>
                <span>REKAP ABSENSI KAMERA KARYAWAN</span>
            </h1>
            <p class="text-xs text-neutral-400">Monitoring kehadiran mekanik dengan bukti foto selfie kamera webcam dan geotag:</p>
        </div>
    </div>

    <!-- Summary Metrics Grid for Selected Date -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-[#121218] border border-neutral-800 p-4 rounded-2xl">
            <div class="text-[10px] uppercase font-bold text-neutral-400">Total Hadir Tepat Waktu</div>
            <div class="font-racing font-black text-2xl text-emerald-400 mt-1">{{ $summary['hadir'] }}</div>
        </div>

        <div class="bg-[#121218] border border-neutral-800 p-4 rounded-2xl">
            <div class="text-[10px] uppercase font-bold text-neutral-400">Terlambat (> 08:30)</div>
            <div class="font-racing font-black text-2xl text-amber-400 mt-1">{{ $summary['terlambat'] }}</div>
        </div>

        <div class="bg-[#121218] border border-neutral-800 p-4 rounded-2xl">
            <div class="text-[10px] uppercase font-bold text-neutral-400">Izin / Sakit</div>
            <div class="font-racing font-black text-2xl text-blue-400 mt-1">{{ $summary['izin'] + $summary['sakit'] }}</div>
        </div>

        <div class="bg-[#121218] border border-neutral-800 p-4 rounded-2xl">
            <div class="text-[10px] uppercase font-bold text-neutral-400">Total Karyawan Aktif</div>
            <div class="font-racing font-black text-2xl text-white mt-1">{{ $summary['total_karyawan'] }}</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-[#121218] border border-neutral-800 p-5 rounded-2xl">
        <form action="{{ route('admin.attendances.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[11px] font-bold text-neutral-400 uppercase mb-1">Tanggal Absensi</label>
                <input type="date" name="date" value="{{ $dateFilter }}" 
                       class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-neutral-400 uppercase mb-1">Pilih Karyawan</label>
                <select name="user_id" class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    <option value="">Semua Karyawan</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $employeeFilter == $emp->id ? 'selected' : '' }}>{{ $emp->name }} ({{ $emp->specialty }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-neutral-400 uppercase mb-1">Status Kehadiran</label>
                <select name="status" class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    <option value="">Semua Status</option>
                    <option value="hadir" {{ $statusFilter === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="terlambat" {{ $statusFilter === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="izin" {{ $statusFilter === 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ $statusFilter === 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase transition-colors flex items-center justify-center gap-1.5 shadow-md shadow-red-600/20">
                    <i class="fa-solid fa-filter"></i> Filter Data
                </button>
            </div>
        </form>
    </div>

    <!-- Attendance Table -->
    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-4 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#0a0a0e] text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Karyawan / Mekanik</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5">Foto Masuk (Kamera)</th>
                        <th class="p-3.5">Jam Masuk</th>
                        <th class="p-3.5">Foto Pulang</th>
                        <th class="p-3.5">Jam Pulang</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5">Ringkasan Kerja</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($attendances as $att)
                        <tr class="hover:bg-neutral-900/50 transition-colors">
                            <td class="p-3.5">
                                <div class="font-bold text-white">{{ $att->user->name ?? 'Mekanik' }}</div>
                                <div class="text-[10px] text-amber-400">{{ $att->user->specialty ?? 'Staff' }}</div>
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ \Carbon\Carbon::parse($att->date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="p-3.5">
                                @if($att->check_in_photo)
                                    <button type="button" @click="selectedPhoto = '{{ $att->check_in_photo_url }}'" class="w-12 h-12 rounded-xl overflow-hidden bg-black border border-neutral-700 hover:scale-105 transition-transform">
                                        <img src="{{ $att->check_in_photo_url }}" class="w-full h-full object-cover">
                                    </button>
                                @else
                                    <span class="text-neutral-500">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $att->check_in_time ? substr($att->check_in_time, 0, 5) . ' WIB' : '-' }}
                            </td>
                            <td class="p-3.5">
                                @if($att->check_out_photo)
                                    <button type="button" @click="selectedPhoto = '{{ $att->check_out_photo_url }}'" class="w-12 h-12 rounded-xl overflow-hidden bg-black border border-neutral-700 hover:scale-105 transition-transform">
                                        <img src="{{ $att->check_out_photo_url }}" class="w-full h-full object-cover">
                                    </button>
                                @else
                                    <span class="text-neutral-500">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $att->check_out_time ? substr($att->check_out_time, 0, 5) . ' WIB' : '-' }}
                            </td>
                            <td class="p-3.5">
                                {!! $att->status_badge !!}
                            </td>
                            <td class="p-3.5 text-neutral-400 max-w-xs truncate">
                                {{ $att->work_summary ?? $att->notes ?? '-' }}
                            </td>
                            <td class="p-3.5 text-right">
                                <form action="{{ route('admin.attendances.destroy', $att->id) }}" method="POST" onsubmit="return confirm('Hapus data absensi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-neutral-500 hover:text-red-400 p-1" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-neutral-500">
                                Tidak ada data absensi untuk filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $attendances->links() }}
        </div>
    </div>

    <!-- Photo Preview Modal -->
    <div x-show="selectedPhoto" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         x-cloak
         class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md flex items-center justify-center p-4"
         @click.self="selectedPhoto = null">
        <div class="bg-[#121218] border border-neutral-700 rounded-3xl p-4 max-w-lg w-full shadow-2xl space-y-3">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-2">
                <span class="text-xs font-bold uppercase font-racing text-amber-400">Bukti Foto Absensi Kamera Karyawan</span>
                <button @click="selectedPhoto = null" class="text-neutral-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="rounded-2xl overflow-hidden bg-black aspect-[4/3]">
                <img :src="selectedPhoto" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

</div>
@endsection
