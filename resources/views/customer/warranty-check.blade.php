@extends('layouts.app')

@section('meta_title', 'Hasil Cek Garansi — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))

@section('content')

    <section class="bg-neutral-900 text-white pt-32 pb-14 border-b border-neutral-800">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-3">
            <span class="text-accent text-xs uppercase tracking-widest font-bold">Verifikasi Bengkel Resmi</span>
            <h1 class="text-3xl md:text-4xl font-extrabold uppercase tracking-wider font-sans">
                Status Garansi Pengerjaan
            </h1>
            <p class="text-xs text-neutral-400">
                Pemeriksaan keabsahan garansi instalasi, dyno tune, dan komponen modifikasi.
            </p>
        </div>
    </section>

    <section class="py-16 bg-neutral-bg min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-6">
            
            <div class="bg-white border border-neutral-200 p-8 md:p-10 space-y-6 shadow-sm">
                
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-neutral-200 pb-6">
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Nomor Booking</div>
                        <div class="text-2xl font-bold font-mono text-black">{{ $booking->booking_code }}</div>
                        <div class="text-xs text-neutral-500">
                            Pemilik: <strong>{{ $booking->customer_name }}</strong>
                        </div>
                    </div>

                    <div>
                        {!! $booking->warranty_status_badge !!}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-neutral-50 p-6 border border-neutral-200 text-xs">
                    <div>
                        <span class="text-neutral-500 block text-[10px] uppercase tracking-wider font-semibold">Kendaraan:</span>
                        <span class="font-bold text-black text-sm">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</span>
                        <div class="font-mono text-neutral-600">{{ $booking->license_plate }}</div>
                    </div>

                    <div>
                        <span class="text-neutral-500 block text-[10px] uppercase tracking-wider font-semibold">Layanan / Modifikasi:</span>
                        <span class="font-bold text-black text-sm">{{ $booking->service ? $booking->service->title : 'Custom Modification' }}</span>
                        <div class="text-neutral-500 text-[11px] mt-0.5">Durasi garansi: {{ $booking->warranty_days }} Hari</div>
                    </div>

                    <div>
                        <span class="text-neutral-500 block text-[10px] uppercase tracking-wider font-semibold">Masa Garansi:</span>
                        <span class="font-bold text-black text-sm">
                            s/d {{ $booking->warranty_end_date ? $booking->warranty_end_date->translatedFormat('d F Y') : '-' }}
                        </span>
                        @if($booking->is_warranty_active)
                            <div class="text-emerald-600 font-semibold text-[11px] mt-0.5">
                                Sisa {{ $booking->warranty_remaining_days }} hari aktif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Warranty Terms & Conditions -->
                <div class="p-5 bg-white border border-neutral-200 text-xs space-y-2">
                    <h4 class="font-bold uppercase tracking-wider text-black text-[11px]">Syarat dan Ketentuan Klaim Garansi:</h4>
                    <ul class="list-disc list-inside text-neutral-600 text-[11px] space-y-1">
                        <li>Garansi berlaku hanya untuk kendaraan dan komponen yang tercantum pada nota pengerjaan resmi.</li>
                        <li>Klaim garansi mencakup setting ulang dyno, pemeriksaan kebocoran pipa / exhaust, dan torsi baut.</li>
                        <li>Garansi gugur jika kendaraan dimodifikasi kembali di bengkel lain atau mengalami benturan / kecelakaan fisik.</li>
                    </ul>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-neutral-200">
                    <a href="{{ url('/') }}" class="text-xs uppercase tracking-wider text-neutral-500 hover:text-black font-semibold">
                        &larr; Kembali ke Beranda
                    </a>

                    @if($booking->is_warranty_active)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('company_whatsapp', '+6281288889999')) }}?text={{ urlencode('Halo ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL') . ', saya ingin mengajukan KLAIM GARANSI untuk Booking ' . $booking->booking_code . ' kendaraan ' . $booking->vehicle_model . ' (' . $booking->license_plate . ')') }}"
                           target="_blank"
                           class="px-6 py-3 bg-emerald-600 text-white text-xs uppercase tracking-wider font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2">
                            <span>🛡️ Ajukan Klaim Garansi via WhatsApp &rarr;</span>
                        </a>
                    @endif
                </div>

            </div>

        </div>
    </section>

@endsection
