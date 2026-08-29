@extends('layouts.admin')

@section('page_title', 'Reservasi Wisata')

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <h2 class="text-xl font-bold uppercase tracking-wider text-white font-sans">
                Daftar Reservasi &amp; Penjadwalan Guide
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Kelola pemesanan paket tur Indonesia, penugasan pemandu bersertifikasi, dan verifikasi pembayaran down payment.
            </p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-5">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Pencarian</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Kode / Nama / Destinasi..."
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-accent">
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Status Ekspedisi</label>
                <select name="status" class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-accent">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="qc" {{ $status === 'qc' ? 'selected' : '' }}>Tahap Akhir</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Status Pembayaran</label>
                <select name="payment_status" class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-accent">
                    <option value="">Semua Pembayaran</option>
                    <option value="unpaid" {{ $paymentStatus === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="dp_paid" {{ $paymentStatus === 'dp_paid' ? 'selected' : '' }}>DP Terbayar</option>
                    <option value="paid" {{ $paymentStatus === 'paid' ? 'selected' : '' }}>Lunas Penuh</option>
                    <option value="refunded" {{ $paymentStatus === 'refunded' ? 'selected' : '' }}>Refund</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Tipe Paket Tur</label>
                <select name="vehicle_type" class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-accent">
                    <option value="">Semua Tipe</option>
                    <option value="mobil" {{ $vehicleType === 'mobil' ? 'selected' : '' }}>Private Tour</option>
                    <option value="motor" {{ $vehicleType === 'motor' ? 'selected' : '' }}>Group Tour</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 bg-primary text-white hover:bg-secondary rounded-xl text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
                    Filter Data &rarr;
                </button>
            </div>
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider font-bold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Kode &amp; Destinasi</th>
                        <th class="p-3.5">Wisatawan</th>
                        <th class="p-3.5">Layanan</th>
                        <th class="p-3.5">Pemandu Ditugaskan</th>
                        <th class="p-3.5">Status Trip</th>
                        <th class="p-3.5">Pembayaran</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($bookings as $b)
                        <tr class="hover:bg-neutral-950/50 transition-colors">
                            <td class="p-3.5">
                                <div class="font-mono font-bold text-white">{{ $b->booking_code }}</div>
                                <div class="text-[11px] text-accent font-semibold">{{ $b->vehicle_brand }}</div>
                                <div class="text-[10px] text-neutral-500">{{ $b->vehicle_model }} &bull; {{ $b->license_plate }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-white">{{ $b->customer_name }}</div>
                                <div class="text-[10px] text-neutral-400">{{ $b->customer_phone }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-semibold text-white">{{ $b->service->title ?? 'Private Guided Tour' }}</div>
                                <div class="text-[10px] text-neutral-400">{{ $b->booking_date ? $b->booking_date->format('d M Y') : '-' }} &bull; {{ $b->booking_time_slot }}</div>
                            </td>
                            <td class="p-3.5">
                                @if($b->guide)
                                    <span class="text-accent font-semibold">{{ $b->guide->name }}</span>
                                @else
                                    <span class="text-amber-400 italic">Belum Ditugaskan</span>
                                @endif
                            </td>
                            <td class="p-3.5">
                                <div>{!! $b->status_badge !!}</div>
                                <div class="text-[10px] text-neutral-400 mt-1">{{ $b->progress_percentage }}% Rute</div>
                            </td>
                            <td class="p-3.5">
                                <div>{!! $b->payment_badge !!}</div>
                                <div class="text-[10px] text-neutral-400 mt-1">
                                    Terbayar: Rp {{ number_format($b->paid_amount, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="p-3.5 text-right space-x-2">
                                <a href="{{ route('admin.bookings.show', $b->id) }}" class="text-white hover:text-accent font-bold">
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
                                Tidak ada data reservasi yang sesuai dengan filter.
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
