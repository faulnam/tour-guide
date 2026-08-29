@extends('layouts.app')

@section('meta_title', 'Kontak & Kantor Pusat — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Hubungi kami untuk konsultasi itinerary wisata Indonesia, penawaran rombongan korporat, dan reservasi pemandu resmi.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                Hubungi Kami
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm max-w-lg mx-auto leading-relaxed">
                Konsultasikan rencana liburan, kustomisasi rute tersembunyi, atau kebutuhan tur grup korporat Anda dengan konsultan wisata resmi kami.
            </p>
        </div>
    </section>

    <!-- Main Contact Information & Form -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                <!-- Left Details (5 cols) -->
                <div class="lg:col-span-5 space-y-8">
                    <div class="space-y-3">
                        <div class="eyebrow text-sage font-bold">Kantor Pusat &amp; Hub Pariwisata</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                            Bali &amp; Jakarta Tourism Hub
                        </h2>
                    </div>

                    <div class="space-y-6 text-xs text-gray-700 divide-y divide-gray-100">
                        <div class="pt-2 space-y-1">
                            <div class="font-bold text-primary uppercase tracking-wider text-[11px] flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-accent"></i>
                                <span>Alamat Utama:</span>
                            </div>
                            <p class="text-gray-600 whitespace-pre-line leading-relaxed pl-5">
                                {{ \App\Models\SiteSetting::get('contact_address', "Nusantara Tourism Hub\nJl. Danau Tamblingan No. 88, Sanur, Bali 80228\nCabang: Jakarta, Labuan Bajo, Sorong, Malang") }}
                            </p>
                        </div>

                        <div class="pt-4 space-y-1">
                            <div class="font-bold text-primary uppercase tracking-wider text-[11px] flex items-center gap-2">
                                <i class="fa-solid fa-phone text-accent"></i>
                                <span>Hotline &amp; WhatsApp 24 Jam:</span>
                            </div>
                            <p class="text-gray-600 pl-5 leading-relaxed">
                                Telepon: {{ \App\Models\SiteSetting::get('contact_phone', '+62 361 890 5678') }}<br>
                                WhatsApp: {{ \App\Models\SiteSetting::get('contact_whatsapp', '081288889999') }} (Konsultasi Fast Response)
                            </p>
                        </div>

                        <div class="pt-4 space-y-1">
                            <div class="font-bold text-primary uppercase tracking-wider text-[11px] flex items-center gap-2">
                                <i class="fa-solid fa-clock text-accent"></i>
                                <span>Jam Layanan Kantor:</span>
                            </div>
                            <p class="text-gray-600 pl-5">
                                Setiap Hari: 07:00 – 22:00 WITA<br>
                                Layanan Guide Lapangan &amp; Emergency SAR: 24 Jam Nonstop
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ url('/booking') }}" class="w-full py-3.5 px-6 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2 text-center">
                            <i class="fa-solid fa-calendar-check text-xs text-accent"></i>
                            <span>Booking Pemandu Wisata Online &rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Right Form (7 cols) -->
                <div class="lg:col-span-7 tour-card p-8 md:p-12 bg-[#F8FAF9]">
                    <div class="space-y-2 mb-8">
                        <div class="eyebrow text-sage font-bold">Kirim Pertanyaan / Pesan</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                            Konsultasikan Liburan Anda
                        </h2>
                    </div>

                    <form action="{{ url('/contact-us') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1.5">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" required placeholder="Nama Lengkap Anda"
                                   class="w-full bg-white border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1.5">
                                    Alamat Email <span class="text-rose-500">*</span>
                                </label>
                                <input type="email" name="email" required placeholder="email@domain.com"
                                       class="w-full bg-white border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1.5">
                                    Kota Domisili / Instansi
                                </label>
                                <input type="text" name="company" placeholder="Jakarta / Perusahaan"
                                       class="w-full bg-white border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1.5">
                                Pesan / Rencana Destinasi <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="message" rows="4" required placeholder="Ceritakan destinasi yang ingin dikunjungi, jumlah orang, perkiraan tanggal, dan preferensi wisata..."
                                      class="w-full bg-white border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2">
                            <i class="fa-regular fa-paper-plane text-xs"></i>
                            <span>Kirim Pesan Sekarang</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
