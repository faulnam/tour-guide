@extends('layouts.admin')

@section('page_title', 'Detail Reservasi ' . $booking->booking_code)

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-wider text-accent font-bold">Manajemen Reservasi &amp; Dispatch Guide</div>
            <h2 class="text-xl font-bold uppercase tracking-wider text-white font-sans">
                {{ $booking->booking_code }}
            </h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="px-4 py-2 bg-primary text-white hover:bg-secondary rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
                Edit Status / Tugaskan Pemandu &rarr;
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 border border-neutral-700 rounded-lg text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Booking Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Customer, Destination & Timeline (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Customer & Destination Card -->
            <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-6">
                <h3 class="text-xs uppercase tracking-wider font-bold text-white border-b border-neutral-800 pb-3">
                    Informasi Wisatawan &amp; Rencana Destinasi
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-neutral-300">
                    <div class="space-y-2">
                        <div class="text-[10px] uppercase font-bold text-neutral-500">Traveler / Pemesan</div>
                        <div class="text-sm font-bold text-white">{{ $booking->customer_name }}</div>
                        <div>Email: {{ $booking->customer_email }}</div>
                        <div>Telepon / WA: <strong class="text-emerald-400">{{ $booking->customer_phone }}</strong></div>
                    </div>

                    <div class="space-y-2">
                        <div class="text-[10px] uppercase font-bold text-neutral-500">Destinasi &amp; Tamu</div>
                        <div class="text-sm font-bold text-white">{{ $booking->vehicle_brand }}</div>
                        <div>Meeting Point: <span class="text-accent font-bold">{{ $booking->vehicle_model }}</span></div>
                        <div>Peserta: <span class="font-mono text-white">{{ $booking->license_plate }}</span></div>
                        <div class="capitalize text-sage font-semibold">Mode: {{ $booking->vehicle_type === 'mobil' ? 'Private Guided Tour' : 'Group / Open Tour' }}</div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-800 space-y-2 text-xs text-neutral-300">
                    <div class="text-[10px] uppercase font-bold text-neutral-500">Jadwal &amp; Layanan Pemandu</div>
                    <div class="font-bold text-white text-sm">{{ $booking->service->title ?? 'Private Guided Tour' }}</div>
                    <div>Tanggal Trip: {{ $booking->booking_date ? $booking->booking_date->format('d F Y') : '-' }} &bull; Slot: {{ $booking->booking_time_slot }}</div>
                    
                    @if($booking->custom_request)
                        <div class="p-3 bg-neutral-950 border border-neutral-800 rounded-xl text-neutral-400 mt-2 italic">
                            <span class="font-bold text-neutral-300 not-italic block text-[10px] uppercase">Permintaan Khusus Tamu:</span>
                            &ldquo;{{ $booking->custom_request }}&rdquo;
                        </div>
                    @endif

                    @if($booking->mechanic_notes)
                        <div class="p-3 bg-neutral-950 border border-neutral-800 rounded-xl text-accent mt-2">
                            <span class="font-bold text-neutral-300 block text-[10px] uppercase">Catatan Pemandu Lapangan:</span>
                            {{ $booking->mechanic_notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Logs Timeline -->
            <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-wider font-bold text-white border-b border-neutral-800 pb-3">
                    Linimasa &amp; Log Perjalanan Lapangan
                </h3>

                <div class="space-y-4 text-xs">
                    @forelse($booking->logs as $log)
                        <div class="flex items-start gap-3 border-l-2 border-accent pl-4 py-1">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white text-xs">{{ $log->title }}</span>
                                    <span class="text-[10px] text-neutral-500">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-neutral-400 text-[11px]">{{ $log->description }}</p>
                                @if($log->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Foto Log" class="w-36 h-24 object-cover rounded-lg border border-neutral-700">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-neutral-500 text-xs italic">Belum ada log catatan aktivitas yang diunggah.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Status, Payment & Assigned Guide (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Status & Assigned Guide -->
            <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                    <span class="text-xs uppercase tracking-wider font-bold text-white">Status Ekspedisi</span>
                    {!! $booking->status_badge !!}
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between text-xs text-neutral-400">
                        <span>Progress Rute:</span>
                        <span class="font-bold text-white">{{ $booking->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-neutral-800 rounded-full h-2 overflow-hidden">
                        <div class="bg-accent h-2 rounded-full transition-all duration-300" style="width: {{ $booking->progress_percentage }}%"></div>
                    </div>
                </div>

                <div class="pt-2 border-t border-neutral-800 space-y-1 text-xs">
                    <div class="text-[10px] uppercase font-bold text-neutral-500">Pemandu Wisata Ditugaskan:</div>
                    @if($booking->guide)
                        <div class="font-bold text-white text-sm">{{ $booking->guide->name }}</div>
                        <div class="text-neutral-400 text-[11px]">{{ $booking->guide->specialty ?? 'Pemandu Berlisensi HPI' }} &bull; {{ $booking->guide->phone }}</div>
                    @else
                        <div class="text-amber-400 font-semibold italic">Belum ada pemandu yang ditugaskan</div>
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-accent hover:underline text-[11px] block mt-1">+ Tugaskan Pemandu Wisata Sekarang</a>
                    @endif
                </div>
            </div>

            <!-- Financials Card -->
            <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                    <span class="text-xs uppercase tracking-wider font-bold text-white">Rincian Pembayaran</span>
                    {!! $booking->payment_badge !!}
                </div>

                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-neutral-400">
                        <span>Total Biaya Trip:</span>
                        <span class="font-bold text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-400">
                        <span>Uang Muka DP (30%):</span>
                        <span class="font-bold text-emerald-400">Rp {{ number_format($booking->down_payment, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-400">
                        <span>Total Terbayar:</span>
                        <span class="font-bold text-white">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-t border-neutral-800 pt-2 font-bold">
                        <span class="text-neutral-300">Sisa Pelunasan:</span>
                        <span class="text-accent">Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Drop-off & Meeting Point Info -->
            <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-3">
                <h3 class="text-xs uppercase tracking-wider font-bold text-white border-b border-neutral-800 pb-2">
                    Lokasi Penjemputan / Drop-off
                </h3>
                <div class="text-xs text-neutral-300 space-y-1">
                    <div class="text-white font-semibold">{{ $booking->vehicle_model }}</div>
                    <div class="text-[11px] text-neutral-400">Pemandu lokal akan stand-by di lokasi penjemputan sesuai jadwal reservasi.</div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
