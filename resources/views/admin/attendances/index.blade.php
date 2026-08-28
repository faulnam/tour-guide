@extends('layouts.admin')

@section('page_title', 'Absensi Kamera Karyawan')

@section('content')
<div class="space-y-6" x-data="{ selectedPhoto: null }">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">
                Log Absensi Kamera &amp; Geotag
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Monitoring presensi mekanik dan teknisi dengan verifikasi foto webcam dan koordinat GPS.
            </p>
        </div>
    </div>

    <!-- Summary Metrics Grid for Selected Date -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-neutral-900 border border-neutral-800 p-4 space-y-1">
            <div class="text-[10px] uppercase font-bold text-neutral-500 tracking-wider">Hadir Tepat Waktu</div>
            <div class="text-2xl font-bold text-emerald-400">{{ $summary['hadir'] }}</div>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-4 space-y-1">
            <div class="text-[10px] uppercase font-bold text-neutral-500 tracking-wider">Terlambat (> 08:30)</div>
            <div class="text-2xl font-bold text-amber-400">{{ $summary['terlambat'] }}</div>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-4 space-y-1">
            <div class="text-[10px] uppercase font-bold text-neutral-500 tracking-wider">Izin / Sakit</div>
            <div class="text-2xl font-bold text-blue-400">{{ $summary['izin'] + $summary['sakit'] }}</div>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-4 space-y-1">
            <div class="text-[10px] uppercase font-bold text-neutral-500 tracking-wider">Total Staf Aktif</div>
            <div class="text-2xl font-bold text-white">{{ $summary['total_karyawan'] }}</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-neutral-900 border border-neutral-800 p-5">
        <form action="{{ route('admin.attendances.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ $dateFilter }}" 
                       class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2 text-xs text-white focus:outline-none focus:border-white">
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Karyawan</label>
                <select name="user_id" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2 text-xs text-white focus:outline-none focus:border-white">
                    <option value="">Semua Karyawan</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $employeeFilter == $emp->id ? 'selected' : '' }}>{{ $emp->name }} ({{ $emp->specialty }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Status</label>
                <select name="status" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2 text-xs text-white focus:outline-none focus:border-white">
                    <option value="">Semua Status</option>
                    <option value="hadir" {{ $statusFilter === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="terlambat" {{ $statusFilter === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="izin" {{ $statusFilter === 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ $statusFilter === 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-semibold uppercase tracking-wider transition-colors">
                    Filter Data &rarr;
                </button>
            </div>
        </form>
    </div>

    <!-- Attendance Table -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Karyawan / Mekanik</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5">Foto Masuk</th>
                        <th class="p-3.5">Jam Masuk</th>
                        <th class="p-3.5">Foto Pulang</th>
                        <th class="p-3.5">Jam Pulang</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5">Catatan Pekerjaan</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($attendances as $att)
                        <tr class="hover:bg-neutral-950/50 transition-colors">
                            <td class="p-3.5 font-semibold text-white">
                                <div>{{ $att->user->name ?? 'Karyawan' }}</div>
                                <div class="text-[10px] text-neutral-500 font-normal">{{ $att->user->specialty ?? $att->user->position ?? 'Teknisi' }}</div>
                            </td>
                            <td class="p-3.5">{{ $att->date ? ($att->date instanceof \DateTimeInterface ? $att->date->format('d M Y') : date('d M Y', strtotime($att->date))) : '-' }}</td>
                            <td class="p-3.5">
                                @if($att->check_in_photo_url)
                                    <button @click="selectedPhoto = '{{ $att->check_in_photo_url }}'" type="button" class="group relative block w-10 h-10 border border-neutral-700 overflow-hidden">
                                        <img src="{{ $att->check_in_photo_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                    </button>
                                @else
                                    <span class="text-neutral-500">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono text-emerald-400">
                                {{ $att->clock_in ?? ($att->check_in_time ? substr($att->check_in_time, 0, 5) : '-') }}
                            </td>
                            <td class="p-3.5">
                                @if($att->check_out_photo_url)
                                    <button @click="selectedPhoto = '{{ $att->check_out_photo_url }}'" type="button" class="group relative block w-10 h-10 border border-neutral-700 overflow-hidden">
                                        <img src="{{ $att->check_out_photo_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                    </button>
                                @else
                                    <span class="text-neutral-500">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono text-amber-400">
                                {{ $att->clock_out ?? ($att->check_out_time ? substr($att->check_out_time, 0, 5) : '-') }}
                            </td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-wider {{ $att->status === 'hadir' || $att->status === 'present' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-amber-950 text-amber-300 border border-amber-800' }}">
                                    {{ $att->status }}
                                </span>
                            </td>
                            <td class="p-3.5 text-neutral-400 italic max-w-xs truncate">
                                {{ $att->notes ?? '-' }}
                            </td>
                            <td class="p-3.5 text-right">
                                <form action="{{ route('admin.attendances.destroy', $att->id) }}" method="POST" onsubmit="return confirm('Hapus data absensi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] uppercase tracking-wider font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-8 text-neutral-500">
                                Tidak ada rekaman data absensi untuk filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->hasPages())
            <div class="pt-4 border-t border-neutral-800 flex justify-center">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

    <!-- Photo Modal Preview -->
    <div x-show="selectedPhoto" x-cloak class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-6" @click.self="selectedPhoto = null">
        <div class="bg-neutral-900 border border-neutral-700 p-4 max-w-lg w-full space-y-4">
            <div class="flex justify-between items-center pb-2 border-b border-neutral-800 text-xs text-white">
                <span class="uppercase tracking-widest font-bold">Preview Bukti Kamera</span>
                <button @click="selectedPhoto = null" class="text-neutral-400 hover:text-white">&times;</button>
            </div>
            <img :src="selectedPhoto" alt="Snapshot Bukti Absensi" class="w-full aspect-[4/3] object-cover border border-neutral-800">
        </div>
    </div>

</div>
@endsection
