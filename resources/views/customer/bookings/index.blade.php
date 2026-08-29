@extends('layouts.customer')

@section('meta_title', 'Riwayat Reservasi Trip — Nusantara Tour Guide')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 gap-4">
        <div>
            <div class="eyebrow text-sage font-bold">Portal Traveler</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-primary font-sans">
                Riwayat Reservasi &amp; Pemandu Wisata
            </h1>
        </div>
        <a href="{{ url('/booking') }}" class="btn-primary flex items-center gap-2 shadow-md">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Booking Tur Baru &rarr;</span>
        </a>
    </div>

    <div class="tour-card p-6 space-y-4 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAF9] text-gray-500 uppercase tracking-wider font-bold border-b border-gray-100">
                    <tr>
                        <th class="p-3.5">Kode Reservasi</th>
                        <th class="p-3.5">Destinasi &amp; Tamu</th>
                        <th class="p-3.5">Paket Wisata</th>
                        <th class="p-3.5">Jadwal Keberangkatan</th>
                        <th class="p-3.5">Status Trip</th>
                        <th class="p-3.5">Pembayaran</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($bookings as $b)
                        <tr class="hover:bg-[#F8FAF9] transition-colors">
                            <td class="p-3.5 font-mono font-bold text-primary">{{ $b->booking_code }}</td>
                            <td class="p-3.5">
                                <div class="font-bold text-primary">{{ $b->vehicle_brand }}</div>
                                <div class="text-[10px] text-gray-500">{{ $b->vehicle_model }} &bull; {{ $b->license_plate }}</div>
                            </td>
                            <td class="p-3.5">{{ $b->service->title ?? 'Private Guided Tour' }}</td>
                            <td class="p-3.5">{{ $b->booking_date ? $b->booking_date->format('d M Y') : '-' }} &bull; {{ $b->booking_time_slot }}</td>
                            <td class="p-3.5">
                                <div>{!! $b->status_badge !!}</div>
                                <div class="text-[10px] text-gray-500 mt-1 font-semibold">{{ $b->progress_percentage }}% Rute</div>
                            </td>
                            <td class="p-3.5">
                                <div>{!! $b->payment_badge !!}</div>
                                <div class="text-[10px] text-gray-500 mt-1">Terbayar: Rp {{ number_format($b->paid_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="p-3.5 text-right">
                                <a href="{{ route('customer.bookings.show', $b->id) }}" class="font-bold text-primary hover:text-sage flex items-center justify-end gap-1">
                                    <span>Detail Pass</span>
                                    <span>&rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">Belum ada riwayat reservasi trip pariwisata.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="pt-4 border-t border-gray-100 flex justify-center">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
