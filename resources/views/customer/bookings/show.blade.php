@extends('layouts.customer')

@section('meta_title', 'Detail Booking ' . $booking->booking_code . ' — BENGKEL')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-neutral-200 gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">Detail Pemesanan</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-black font-sans">
                {{ $booking->booking_code }}
            </h1>
        </div>
        <div>
            <a href="{{ route('customer.bookings.index') }}" class="btn-outline-dark">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Details (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
            <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                Informasi Kendaraan &amp; Paket Servis
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-neutral-700">
                <div class="space-y-1">
                    <div class="text-[10px] uppercase font-bold text-neutral-400">Kendaraan:</div>
                    <div class="text-base font-bold text-black">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</div>
                    <div>Plat: <span class="font-mono font-bold">{{ $booking->license_plate }}</span></div>
                    <div class="capitalize text-neutral-500">Tipe: {{ $booking->vehicle_type }}</div>
                </div>

                <div class="space-y-1">
                    <div class="text-[10px] uppercase font-bold text-neutral-400">Jadwal Kedatangan:</div>
                    <div class="font-bold text-black">{{ $booking->booking_date->format('l, d F Y') }}</div>
                    <div>Pukul: {{ $booking->booking_time_slot }}</div>
                </div>
            </div>

            <div class="pt-4 border-t border-neutral-200 space-y-2 text-xs">
                <div class="text-[10px] uppercase font-bold text-neutral-400">Layanan:</div>
                <div class="font-bold text-black text-sm">{{ $booking->service->title ?? 'Custom Tuning & Modifikasi' }}</div>
                @if($booking->custom_request)
                    <div class="p-3 bg-neutral-bg border border-neutral-200 text-neutral-600 mt-2">
                        <span class="font-bold">Catatan Anda:</span> {{ $booking->custom_request }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Status Tracker (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white border border-neutral-200 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Status Pengerjaan Workshop
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Status Saat Ini:</span>
                        <span class="px-2 py-0.5 text-[9px] uppercase font-bold bg-neutral-100 text-black border border-neutral-300">
                            {{ $booking->status_label }}
                        </span>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between text-neutral-500">
                            <span>Progress Pengerjaan:</span>
                            <span class="font-bold text-black">{{ $booking->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-neutral-200 h-2">
                            <div class="bg-black h-2 transition-all duration-500" style="width: {{ $booking->progress_percentage }}%"></div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <span class="text-neutral-500">Lead Mekanik:</span>
                        <span class="font-bold text-black">{{ $booking->mechanic->name ?? 'Dalam Penjadwalan' }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Card -->
            <div class="bg-white border border-neutral-200 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Status Down Payment
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Status Pembayaran:</span>
                        <span class="px-2 py-0.5 text-[9px] uppercase font-bold {{ $booking->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $booking->payment_status === 'paid' ? 'LUNAS' : 'MENUNGGU PEMBAYARAN' }}
                        </span>
                    </div>

                    @if($booking->payment)
                        <div class="flex justify-between items-center">
                            <span class="text-neutral-500">Jumlah DP:</span>
                            <span class="font-bold text-black text-sm">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</span>
                        </div>

                        @if($booking->payment_status !== 'paid')
                            <div class="pt-2">
                                <a href="{{ route('booking.checkout', $booking->id) }}" class="btn-dark w-full text-center block">
                                    Bayar Tagihan DP &rarr;
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
