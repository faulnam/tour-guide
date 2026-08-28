@extends('layouts.admin')

@section('page_title', 'Customer Bookings')

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">
                Daftar Booking &amp; Antrean Workshop
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Kelola pemesanan servis, modifikasi, penugasan mekanik, dan verifikasi pembayaran down payment.
            </p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-neutral-900 border border-neutral-800 p-5">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Pencarian</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Kode / Nama / Plat..."
                       class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2 text-xs text-white focus:outline-none focus:border-white">
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Status Pengerjaan</label>
                <select name="status" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2 text-xs text-white focus:outline-none focus:border-white">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="qc" {{ $status === 'qc' ? 'selected' : '' }}>QC &amp; Dyno Test</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Tipe Kendaraan</label>
                <select name="vehicle_type" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2 text-xs text-white focus:outline-none focus:border-white">
                    <option value="">Semua Tipe</option>
                    <option value="mobil" {{ $vehicleType === 'mobil' ? 'selected' : '' }}>Mobil</option>
                    <option value="motor" {{ $vehicleType === 'motor' ? 'selected' : '' }}>Motor</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-semibold uppercase tracking-wider transition-colors">
                    Filter Data &rarr;
                </button>
            </div>
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Kode &amp; Unit</th>
                        <th class="p-3.5">Customer</th>
                        <th class="p-3.5">Layanan</th>
                        <th class="p-3.5">Mekanik</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5">Pembayaran DP</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($bookings as $b)
                        <tr class="hover:bg-neutral-950/50 transition-colors">
                            <td class="p-3.5">
                                <div class="font-mono font-bold text-white">{{ $b->booking_code }}</div>
                                <div class="text-[11px] text-neutral-400">{{ $b->vehicle_brand }} {{ $b->vehicle_model }} ({{ $b->license_plate }})</div>
                                <div class="text-[10px] uppercase text-neutral-500">{{ $b->vehicle_type }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-semibold text-white">{{ $b->customer_name }}</div>
                                <div class="text-[10px] text-neutral-400">{{ $b->customer_phone }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-semibold text-white">{{ $b->service->title ?? 'Custom Service' }}</div>
                                <div class="text-[10px] text-neutral-400">{{ $b->booking_date->format('d M Y') }} • {{ $b->booking_time_slot }}</div>
                            </td>
                            <td class="p-3.5">
                                @if($b->mechanic)
                                    <span class="text-accent font-semibold">{{ $b->mechanic->name }}</span>
                                @else
                                    <span class="text-neutral-500 italic">Belum Ditugaskan</span>
                                @endif
                            </td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-wider {{ $b->status === 'completed' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-amber-950 text-amber-300 border border-amber-800' }}">
                                    {{ $b->status }}
                                </span>
                                <div class="text-[10px] text-neutral-400 mt-1">{{ $b->progress_percentage }}% Selesai</div>
                            </td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-wider {{ $b->payment_status === 'paid' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-amber-950 text-amber-300 border border-amber-800' }}">
                                    {{ $b->payment_status === 'paid' ? 'DP LUNAS' : 'PENDING' }}
                                </span>
                                @if($b->payment)
                                    <div class="text-[10px] text-neutral-400 mt-1">Rp {{ number_format($b->payment->amount, 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td class="p-3.5 text-right space-x-2">
                                <a href="{{ route('admin.bookings.show', $b->id) }}" class="text-white hover:text-accent font-semibold">
                                    Detail
                                </a>
                                <a href="{{ route('admin.bookings.edit', $b->id) }}" class="text-neutral-400 hover:text-white">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-neutral-500">
                                Tidak ada data booking yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="pt-4 border-t border-neutral-800 flex justify-center">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
