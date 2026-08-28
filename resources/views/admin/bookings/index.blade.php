@extends('layouts.admin')

@section('title', 'Kelola Booking & Antrean Modifikasi')

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-car-side text-red-500"></i>
                <span>DAFTAR BOOKING & ANTREAN BENGKEL</span>
            </h1>
            <p class="text-xs text-neutral-400">Kelola seluruh pemesanan servis & modifikasi, penugasan mekanik, dan status pembayaran:</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-[#121218] border border-neutral-800 p-5 rounded-2xl">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[11px] font-bold text-neutral-400 uppercase mb-1">Cari Booking</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Kode / Nama / Plat Nomor..."
                       class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-neutral-400 uppercase mb-1">Status Pengerjaan</label>
                <select name="status" class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed (Terkonfirmasi)</option>
                    <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress (Dikerjakan)</option>
                    <option value="qc" {{ $status === 'qc' ? 'selected' : '' }}>QC & Dyno Test</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-neutral-400 uppercase mb-1">Tipe Kendaraan</label>
                <select name="vehicle_type" class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    <option value="">Semua (Motor & Mobil)</option>
                    <option value="mobil" {{ $vehicleType === 'mobil' ? 'selected' : '' }}>🚗 Mobil</option>
                    <option value="motor" {{ $vehicleType === 'motor' ? 'selected' : '' }}>🏍️ Motor</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase transition-colors flex items-center justify-center gap-1.5 shadow-md shadow-red-600/20">
                    <i class="fa-solid fa-magnifying-glass"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-4 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#0a0a0e] text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Kode & Unit</th>
                        <th class="p-3.5">Customer</th>
                        <th class="p-3.5">Layanan</th>
                        <th class="p-3.5">Mekanik</th>
                        <th class="p-3.5">Status Pengerjaan</th>
                        <th class="p-3.5">Pembayaran</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($bookings as $b)
                        <tr class="hover:bg-neutral-900/50 transition-colors">
                            <td class="p-3.5">
                                <div class="font-mono font-bold text-white">{{ $b->booking_code }}</div>
                                <div class="text-[11px] text-neutral-400">{{ $b->vehicle_type_label }} {{ $b->vehicle_brand }} {{ $b->vehicle_model }}</div>
                                <div class="font-mono text-[10px] text-red-400 font-bold">{{ $b->license_plate }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-white">{{ $b->customer_name }}</div>
                                <div class="text-[10px] text-neutral-400">{{ $b->customer_phone }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-white">{{ $b->service->title ?? 'Custom Tuning' }}</div>
                                <div class="text-[10px] text-neutral-400">{{ \Carbon\Carbon::parse($b->booking_date)->translatedFormat('d M Y') }} ({{ $b->booking_time_slot }})</div>
                            </td>
                            <td class="p-3.5">
                                @if($b->mechanic)
                                    <span class="text-amber-400 font-bold">{{ $b->mechanic->name }}</span>
                                @else
                                    <span class="text-neutral-500 italic">Belum Ditugaskan</span>
                                @endif
                            </td>
                            <td class="p-3.5">
                                {!! $b->status_badge !!}
                                <div class="text-[10px] font-mono text-neutral-400 mt-1">{{ $b->progress_percentage }}% Selesai</div>
                            </td>
                            <td class="p-3.5">
                                {!! $b->payment_badge !!}
                                <div class="text-[10px] font-mono text-emerald-400 mt-1">Rp {{ number_format($b->paid_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="p-3.5 text-right space-x-2">
                                <a href="{{ route('admin.bookings.show', $b->id) }}" 
                                   class="px-2.5 py-1.5 bg-neutral-800 hover:bg-red-600 text-white rounded-lg font-bold text-[11px] transition-colors">
                                    Detail
                                </a>
                                <a href="{{ route('admin.bookings.edit', $b->id) }}" 
                                   class="px-2.5 py-1.5 bg-neutral-800 hover:bg-amber-600 hover:text-black text-white rounded-lg font-bold text-[11px] transition-colors">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-neutral-500">
                                Tidak ada data booking untuk filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $bookings->links() }}
        </div>
    </div>

</div>
@endsection
