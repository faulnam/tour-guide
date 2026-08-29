@extends('layouts.customer')

@section('meta_title', 'Detail Reservasi ' . $booking->booking_code . ' — Nusantara Tour Guide')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 gap-4">
        <div>
            <div class="eyebrow text-sage font-bold">Detail Reservasi &amp; Pemandu Wisata</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-primary font-sans">
                {{ $booking->booking_code }}
            </h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="px-5 py-2.5 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-receipt text-xs text-accent"></i>
                <span>Lihat Digital Pass &amp; Invoice &rarr;</span>
            </a>
            <a href="{{ route('customer.bookings.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-300 hover:border-primary text-primary font-bold text-xs uppercase tracking-wider transition-all">
                &larr; Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Details & Log (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <div class="tour-card p-6 md:p-8 space-y-6 bg-white">
                <h3 class="text-xs uppercase tracking-wider font-bold text-primary border-b border-gray-100 pb-3">
                    Informasi Destinasi &amp; Paket Pemandu
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-gray-700">
                    <div class="space-y-1">
                        <div class="text-[10px] uppercase font-bold text-gray-400">Destinasi Wisata:</div>
                        <div class="text-base font-bold text-primary">{{ $booking->vehicle_brand }}</div>
                        <div>Meeting Point: <span class="font-bold text-gray-800">{{ $booking->vehicle_model }}</span></div>
                        <div class="text-sage font-semibold">Tamu: {{ $booking->license_plate }}</div>
                    </div>

                    <div class="space-y-1">
                        <div class="text-[10px] uppercase font-bold text-gray-400">Jadwal Perjalanan:</div>
                        <div class="font-bold text-primary">{{ $booking->booking_date ? $booking->booking_date->translatedFormat('l, d F Y') : '-' }}</div>
                        <div>Slot Waktu: <strong>{{ $booking->booking_time_slot }}</strong></div>
                        <div>Pemandu: <strong class="text-primary">{{ $booking->guide ? $booking->guide->name : 'Pemandu Resmi Ditugaskan' }}</strong></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                    <div class="text-[10px] uppercase font-bold text-gray-400">Paket Wisata Terpilih:</div>
                    <div class="font-bold text-primary text-sm">{{ $booking->service->title ?? 'Private Guided Tour' }}</div>
                    @if($booking->custom_request)
                        <div class="p-3.5 bg-[#F8FAF9] rounded-xl border border-gray-100 text-gray-600 mt-2">
                            <span class="font-bold text-primary block text-[10px] uppercase">Catatan / Permintaan Khusus Anda:</span>
                            &ldquo;{{ $booking->custom_request }}&rdquo;
                        </div>
                    @endif

                    @if($booking->mechanic_notes)
                        <div class="p-3.5 bg-[#F8FAF9] rounded-xl border border-gray-100 text-gray-800 mt-2">
                            <span class="font-bold text-primary block text-[10px] uppercase">Catatan Langsung dari Pemandu Lapangan:</span>
                            {{ $booking->mechanic_notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Logs Timeline -->
            <div class="tour-card p-6 md:p-8 space-y-4 bg-white">
                <h3 class="text-xs uppercase tracking-wider font-bold text-primary border-b border-gray-100 pb-3">
                    Linimasa &amp; Dokumentasi Ekspedisi Lapangan
                </h3>

                <div class="space-y-4 text-xs">
                    @forelse($booking->logs as $log)
                        <div class="flex items-start gap-3 border-l-2 border-accent pl-4 py-1">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-primary text-xs">{{ $log->title }}</span>
                                    <span class="text-[10px] text-gray-400 font-mono">{{ $log->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-gray-600 text-[11px] leading-relaxed">{{ $log->description }}</p>
                                @if($log->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Dokumentasi Trip" class="w-48 h-32 object-cover rounded-xl border border-gray-200 shadow-sm">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-xs italic">Menunggu update progres rute awal dari pemandu wisata lapangan.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Status Tracker & Payment (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="tour-card p-6 md:p-8 space-y-6 bg-white">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="text-xs uppercase tracking-wider font-bold text-primary">Status Ekspedisi</span>
                    {!! $booking->status_badge !!}
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between text-xs text-gray-500">
            <div class="tour-card p-6 space-y-4 bg-[#F8FAF9]">
                <h2 class="text-sm font-bold uppercase tracking-wider text-primary border-b border-gray-200/80 pb-2">
                    Rincian Pembayaran
                </h2>

                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total Biaya Paket:</span>
                        <span class="font-bold text-primary">Rp {{ number_format($booking->estimated_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Uang Muka (DP):</span>
                        <span class="font-bold text-emerald-700">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status DP:</span>
                        <span class="font-bold capitalize">{{ $booking->dp_status }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-2 font-bold">
                        <span class="text-gray-700">Sisa Pelunasan:</span>
                        <span class="text-primary">Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('contact_whatsapp', '081288889999')) }}?text={{ urlencode('Halo ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') . ', saya ingin konsultasi reservasi ' . $booking->booking_code . ' destinasi ' . $booking->vehicle_brand) }}"
                       target="_blank"
                       class="w-full py-3 px-6 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2 text-center">
                        <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i>
                        <span>Chat WhatsApp Konsultan Wisata</span>
                    </a>
                </div>
            </div>

            <!-- Drop-off / Penyerahan Pasca Tur -->
            <div class="tour-card p-6 space-y-3 text-xs bg-white">
                <div class="flex items-center gap-2 text-primary font-bold">
                    <i class="fa-solid fa-location-dot text-accent"></i>
                    <span class="uppercase tracking-wider text-[10px]">Titik Penjemputan / Drop-Off</span>
                </div>
                <p class="text-gray-600 text-[11px] leading-relaxed">
                    Lokasi Titik Kumpul: <strong class="text-primary">{{ $booking->vehicle_model }}</strong>.<br>
                    Pemandu wisata kami akan menghubungi Anda 1 jam sebelum jadwal keberangkatan.
                </p>
            </div>

        </div>

    </div>

</div>
@endsection
