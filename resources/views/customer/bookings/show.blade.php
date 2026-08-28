@extends('layouts.customer')

@section('meta_title', 'Detail Booking ' . $booking->booking_code . ' — BENGKEL')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-neutral-200 gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">Detail Pemesanan &amp; Pengerjaan</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-black font-sans">
                {{ $booking->booking_code }}
            </h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="btn-dark text-xs">
                Lihat Invoice / Pembayaran &rarr;
            </a>
            <a href="{{ route('customer.bookings.index') }}" class="btn-outline-dark text-xs">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Details & Log (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
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
                        <div class="font-bold text-black">{{ $booking->booking_date ? $booking->booking_date->translatedFormat('l, d F Y') : '-' }}</div>
                        <div>Pukul: {{ $booking->booking_time_slot }}</div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-200 space-y-2 text-xs">
                    <div class="text-[10px] uppercase font-bold text-neutral-400">Layanan:</div>
                    <div class="font-bold text-black text-sm">{{ $booking->service->title ?? 'Custom Tuning & Modifikasi' }}</div>
                    @if($booking->custom_request)
                        <div class="p-3 bg-neutral-bg border border-neutral-200 text-neutral-600 mt-2">
                            <span class="font-bold text-black block text-[10px] uppercase">Catatan Permintaan Anda:</span>
                            &ldquo;{{ $booking->custom_request }}&rdquo;
                        </div>
                    @endif

                    @if($booking->mechanic_notes)
                        <div class="p-3 bg-neutral-bg border border-neutral-200 text-neutral-800 mt-2">
                            <span class="font-bold text-black block text-[10px] uppercase">Catatan Langsung dari Teknisi:</span>
                            {{ $booking->mechanic_notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Logs Timeline -->
            <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Linimasa Pengerjaan Unit di Workshop
                </h3>

                <div class="space-y-4 text-xs">
                    @forelse($booking->logs as $log)
                        <div class="flex items-start gap-3 border-l-2 border-accent pl-4 py-1">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-black text-xs">{{ $log->title }}</span>
                                    <span class="text-[10px] text-neutral-400">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-neutral-600 text-[11px]">{{ $log->description }}</p>
                                @if($log->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Progres Foto" class="w-40 h-28 object-cover border border-neutral-200">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-neutral-400 text-xs italic">Menunggu update progres awal dari workshop.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Status Tracker & Payment (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white border border-neutral-200 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Status Pengerjaan Workshop
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Status Saat Ini:</span>
                        <div>{!! $booking->status_badge !!}</div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between text-neutral-500">
                            <span>Progress Pengerjaan:</span>
                            <span class="font-bold text-black">{{ $booking->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-neutral-200 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-black h-2.5 transition-all duration-500" style="width: {{ $booking->progress_percentage }}%"></div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-neutral-100">
                        <span class="text-neutral-500">Lead Mekanik:</span>
                        <span class="font-bold text-black">{{ $booking->mechanic->name ?? 'Dalam Penjadwalan Tim' }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Card -->
            <div class="bg-white border border-neutral-200 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Status Pembayaran
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Status Tagihan:</span>
                        <div>{!! $booking->payment_badge !!}</div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Estimasi Total Biaya:</span>
                        <span class="font-bold text-black">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Ketentuan DP Wajib:</span>
                        <span class="font-semibold text-neutral-700">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center border-t border-neutral-100 pt-2">
                        <span class="text-neutral-500">Total Terbayar:</span>
                        <span class="font-bold text-black">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Sisa Pelunasan:</span>
                        @php $sisa = $booking->remaining_amount; @endphp
                        <span class="font-bold text-black">
                            {{ $sisa > 0 ? 'Rp ' . number_format($sisa, 0, ',', '.') : 'Lunas Penuh' }}
                        </span>
                    </div>

                    @if($booking->status === 'completed' && $sisa > 0)
                        <div class="pt-3">
                            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="btn-dark w-full text-center block">
                                Lunasi Sisa Tagihan (Rp {{ number_format($sisa, 0, ',', '.') }}) &rarr;
                            </a>
                        </div>
                    @elseif(!in_array($booking->payment_status, ['paid', 'dp_paid']))
                        <div class="pt-3">
                            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="btn-dark w-full text-center block">
                                Bayar DP Sekarang &rarr;
                            </a>
                        </div>
                    @else
                        <div class="pt-3">
                            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="btn-outline-dark w-full text-center block text-xs">
                                Lihat Invoice &amp; Penyerahan Unit &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Handover Preference Card -->
            @if($booking->delivery_method)
                <div class="bg-white border border-neutral-200 p-6 space-y-3">
                    <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                        Opsi Penyerahan Unit
                    </h3>
                    <div class="text-xs space-y-1.5">
                        <div class="font-bold text-black">{{ $booking->delivery_method_label }}</div>
                        @if($booking->delivery_method === 'delivery_address' && $booking->delivery_address)
                            <div class="text-neutral-600 p-3 bg-neutral-bg border border-neutral-200 mt-1">
                                <span class="font-semibold text-black block text-[10px] uppercase">Alamat Tujuan:</span>
                                {{ $booking->delivery_address }}
                            </div>
                        @endif
                        @if($booking->delivery_notes)
                            <div class="text-neutral-500 text-[11px] italic">
                                Catatan: {{ $booking->delivery_notes }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection
