@extends('layouts.app')

@section('meta_title', 'Hasil Cek Status Voucher & Asuransi — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))

@section('content')

    <section class="bg-primary-dark text-white pt-32 pb-14 border-b border-primary/50">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-3">
            <span class="text-accent text-xs uppercase tracking-wider font-bold">Verifikasi Resmi Nusantara Tour Guide</span>
            <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-wider font-sans">
                Status Voucher &amp; Jaminan Layanan Trip
            </h1>
            <p class="text-xs text-gray-300">
                Pemeriksaan keabsahan travel pass, sertifikasi pemandu resmi, dan asuransi wisata.
            </p>
        </div>
    </section>

    <section class="py-16 bg-[#F8FAF9] min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-6">
            
            <div class="tour-card p-8 md:p-10 space-y-6 shadow-elevated bg-white">
                
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-6">
                    <div>
                        <div class="text-[10px] uppercase tracking-wider text-gray-500 font-bold">Kode Reservasi Trip</div>
                        <div class="text-2xl font-bold font-mono text-primary">{{ $booking->booking_code }}</div>
                        <div class="text-xs text-gray-500">
                            Traveler: <strong>{{ $booking->customer_name }}</strong>
                        </div>
                    </div>

                    <div>
                        {!! $booking->warranty_status_badge !!}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-[#F8FAF9] p-6 rounded-2xl border border-gray-100 text-xs">
                    <div>
                        <span class="text-gray-500 block text-[10px] uppercase tracking-wider font-bold">Destinasi &amp; Armada:</span>
                        <span class="font-bold text-primary text-sm">{{ $booking->vehicle_brand }}</span>
                        <div class="text-gray-600 font-mono">{{ $booking->vehicle_model }}</div>
                    </div>

                    <div>
                        <span class="text-gray-500 block text-[10px] uppercase tracking-wider font-bold">Paket Pemandu:</span>
                        <span class="font-bold text-primary text-sm">{{ $booking->service ? $booking->service->title : 'Private Guided Tour' }}</span>
                        <div class="text-sage text-[11px] mt-0.5 font-semibold">Lisensi HPI / APGI Resmi</div>
                    </div>

                    <div>
                        <span class="text-gray-500 block text-[10px] uppercase tracking-wider font-bold">Masa Berlaku Voucher:</span>
                        <span class="font-bold text-primary text-sm">
                            s/d {{ $booking->warranty_end_date ? $booking->warranty_end_date->translatedFormat('d F Y') : '-' }}
                        </span>
                        @if($booking->is_warranty_active)
                            <div class="text-emerald-700 font-bold text-[11px] mt-0.5">
                                Aktif (Sisa {{ $booking->warranty_remaining_days }} hari)
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Warranty Terms & Conditions -->
                <div class="p-5 bg-white rounded-xl border border-gray-100 text-xs space-y-2">
                    <h4 class="font-bold uppercase tracking-wider text-primary text-[11px]">Jaminan Layanan &amp; Asuransi Wisata:</h4>
                    <ul class="list-disc list-inside text-gray-600 text-[11px] space-y-1">
                        <li>Jaminan pendampingan oleh pemandu lokal berlisensi resmi HPI yang telah lolos verifikasi standar kompetensi.</li>
                        <li>Perlindungan asuransi kecelakaan diri dan santunan medis selama aktivitas tur berlangsung di lokasi wisata.</li>
                        <li>Kebijakan reschedule fleksibel apabila terjadi penutupan objek wisata akibat cuaca ekstrem atau erupsi vulkanik.</li>
                    </ul>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ url('/') }}" class="text-xs uppercase tracking-wider text-gray-500 hover:text-primary font-bold">
                        &larr; Kembali ke Beranda
                    </a>

                    @if($booking->is_warranty_active)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('contact_whatsapp', '081288889999')) }}?text={{ urlencode('Halo ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') . ', saya ingin konsultasi bantuan layanan untuk Booking ' . $booking->booking_code . ' destinasi ' . $booking->vehicle_brand) }}"
                           target="_blank"
                           class="px-6 py-2.5 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                            <span>🛡️ Hubungi Support Wisata via WhatsApp &rarr;</span>
                        </a>
                    @endif
                </div>

            </div>

        </div>
    </section>

@endsection
