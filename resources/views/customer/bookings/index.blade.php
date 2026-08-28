@extends('layouts.customer')

@section('title', 'Riwayat Booking & Modifikasi')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight">
                RIWAYAT BOOKING & SERVIS SAYA
            </h1>
            <p class="text-xs text-neutral-400">Daftar seluruh pesanan modifikasi dan servis kendaraan Anda:</p>
        </div>

        <a href="{{ url('/booking') }}" 
           class="px-5 py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all inline-flex items-center gap-2 shadow-lg shadow-red-600/30">
            <i class="fa-solid fa-plus"></i>
            <span>Booking Baru</span>
        </a>
    </div>

    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 space-y-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#0a0a0e] text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Kode & Unit</th>
                        <th class="p-3.5">Layanan</th>
                        <th class="p-3.5">Jadwal</th>
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
                                <div class="text-[11px] text-neutral-400">{{ $b->vehicle_type_label }} {{ $b->vehicle_brand }} {{ $b->vehicle_model }} ({{ $b->license_plate }})</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-white">{{ $b->service->title ?? 'Custom Tuning' }}</div>
                                <div class="text-[10px] text-red-400">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="p-3.5">
                                <div>{{ \Carbon\Carbon::parse($b->booking_date)->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-neutral-500">{{ $b->booking_time_slot }}</div>
                            </td>
                            <td class="p-3.5">
                                {!! $b->status_badge !!}
                                <div class="text-[10px] text-neutral-400 font-mono mt-1">{{ $b->progress_percentage }}% Selesai</div>
                            </td>
                            <td class="p-3.5">
                                {!! $b->payment_badge !!}
                                <div class="text-[10px] text-emerald-400 font-mono mt-1">Paid: Rp {{ number_format($b->paid_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="p-3.5 text-right space-x-2">
                                @if($b->payment_status === 'unpaid')
                                    <a href="{{ route('booking.checkout', $b->booking_code) }}" 
                                       class="px-3 py-1.5 bg-red-600 hover:bg-red-500 text-white rounded-lg font-bold text-[11px] transition-colors">
                                        Bayar DP
                                    </a>
                                @endif
                                <a href="{{ route('customer.bookings.show', $b->id) }}" 
                                   class="px-3 py-1.5 bg-neutral-800 hover:bg-neutral-700 text-white rounded-lg font-bold text-[11px] transition-colors inline-flex items-center gap-1">
                                    <i class="fa-solid fa-satellite-dish text-red-500"></i>
                                    <span>Detail Tracker</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-neutral-500">
                                Belum ada riwayat booking.
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
