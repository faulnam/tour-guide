@extends('layouts.customer')

@section('meta_title', 'Riwayat Booking Saya — BENGKEL')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-neutral-200 gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">Customer Portal</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-black font-sans">
                Riwayat Booking &amp; Servis
            </h1>
        </div>
        <a href="{{ url('/booking') }}" class="btn-dark">
            + Booking Baru
        </a>
    </div>

    <div class="bg-white border border-neutral-200 p-6 space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-bg text-neutral-500 uppercase tracking-wider font-semibold border-b border-neutral-200">
                    <tr>
                        <th class="p-3.5">Kode Booking</th>
                        <th class="p-3.5">Kendaraan</th>
                        <th class="p-3.5">Layanan</th>
                        <th class="p-3.5">Jadwal Masuk</th>
                        <th class="p-3.5">Status Pengerjaan</th>
                        <th class="p-3.5">DP Payment</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 text-neutral-700">
                    @forelse($bookings as $b)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="p-3.5 font-mono font-bold text-black">{{ $b->booking_code }}</td>
                            <td class="p-3.5">
                                <div class="font-bold text-black">{{ $b->vehicle_brand }} {{ $b->vehicle_model }}</div>
                                <div class="text-[10px] text-neutral-500">{{ $b->license_plate }} • {{ $b->vehicle_type }}</div>
                            </td>
                            <td class="p-3.5">{{ $b->service->title ?? 'Custom Package' }}</td>
                            <td class="p-3.5">{{ $b->booking_date->format('d M Y') }} • {{ $b->booking_time_slot }}</td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 text-[9px] uppercase font-bold {{ $b->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($b->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $b->status_label }}
                                </span>
                            </td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 text-[9px] uppercase font-bold {{ $b->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $b->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                </span>
                            </td>
                            <td class="p-3.5 text-right">
                                <a href="{{ route('customer.bookings.show', $b->id) }}" class="font-bold text-black hover:underline">
                                    Detail &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-neutral-400">Belum ada riwayat booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="pt-4 border-t border-neutral-200 flex justify-center">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
