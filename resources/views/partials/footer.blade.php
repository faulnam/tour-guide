<footer class="bg-primary-dark text-white border-t border-primary/40">
    <div class="max-w-7xl mx-auto px-6 md:px-12 py-16">
        
        <!-- Top Row: Brand & Social Icons -->
        <div class="flex flex-col md:flex-row md:items-center justify-between pb-12 border-b border-primary/40 gap-6">
            <div class="flex items-center space-x-3.5">
                <div class="w-10 h-10 rounded-xl bg-accent flex items-center justify-center text-primary-dark shadow-md">
                    <i class="fa-solid fa-compass text-lg"></i>
                </div>
                <div>
                    <a href="{{ url('/') }}" class="font-bold text-xl tracking-wider uppercase text-white font-sans inline-block">
                        {{ \App\Models\SiteSetting::get('company_name', 'NUSANTARA TOUR GUIDE') }}
                    </a>
                    <p class="text-accent text-[10px] uppercase tracking-widest font-semibold">
                        {{ \App\Models\SiteSetting::get('company_tagline', 'Pemandu Wisata Resmi Berlisensi HPI & Ekspedisi Indonesia') }}
                    </p>
                </div>
            </div>

            <!-- Social Links -->
            <div class="flex items-center space-x-4 text-gray-300 text-sm">
                @if($ig = \App\Models\SiteSetting::get('social_instagram', 'https://instagram.com'))
                    <a href="{{ $ig }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center hover:bg-accent hover:text-primary-dark transition-all" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                @endif
                @if($yt = \App\Models\SiteSetting::get('social_youtube', 'https://youtube.com'))
                    <a href="{{ $yt }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center hover:bg-accent hover:text-primary-dark transition-all" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                @endif
                @if($tt = \App\Models\SiteSetting::get('social_tiktok', 'https://tiktok.com'))
                    <a href="{{ $tt }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center hover:bg-accent hover:text-primary-dark transition-all" aria-label="TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                @endif
                @if($fb = \App\Models\SiteSetting::get('social_facebook', 'https://facebook.com'))
                    <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center hover:bg-accent hover:text-primary-dark transition-all" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Middle Row: 4 Columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 py-12 border-b border-primary/40 text-xs">
            
            <!-- Column 1: Newsletter -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-wider font-bold text-xs flex items-center gap-2">
                    <i class="fa-regular fa-paper-plane text-accent"></i>
                    <span>Newsletter Wisata</span>
                </h4>
                <p class="text-gray-300 text-[11px] leading-relaxed">
                    Dapatkan rekomendasi itinerary rahasia, info promo open trip, musim liburan terbaik, dan tips wisata alam Nusantara.
                </p>
                <form action="{{ url('/newsletter/subscribe') }}" method="POST" class="space-y-2">
                    @csrf
                    <div class="flex flex-col space-y-2">
                        <input type="email" 
                               name="email" 
                               required 
                               placeholder="Email Anda..." 
                               class="w-full bg-primary/70 border border-primary text-white text-xs px-4 py-2.5 rounded-lg focus:outline-none focus:border-accent transition-colors placeholder:text-gray-400">
                        <button type="submit" 
                                class="w-full bg-accent hover:bg-accent-dark text-primary-dark hover:text-white text-xs uppercase tracking-wider py-2.5 rounded-lg font-bold transition-all shadow-sm">
                            Berlangganan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Column 2: Tourism Hub & Address -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-wider font-bold text-xs flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-accent"></i>
                    <span>Kantor Pusat &amp; Hub</span>
                </h4>
                <p class="text-gray-300 text-[11px] leading-relaxed whitespace-pre-line">
                    {{ \App\Models\SiteSetting::get('contact_address', "Nusantara Tourism Hub\nJl. Danau Tamblingan No. 88, Sanur, Bali 80228\nCabang: Jakarta, Labuan Bajo, Sorong, Malang") }}
                </p>
                <div class="text-[11px] text-gray-300">
                    <span class="text-accent font-semibold">Jam Operasional:</span><br>
                    {{ \App\Models\SiteSetting::get('working_hours', 'Setiap Hari: 07.00 - 22.00 WITA | Layanan Guide 24/7') }}
                </div>
            </div>

            <!-- Column 3: Contact & Hotline -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-wider font-bold text-xs flex items-center gap-2">
                    <i class="fa-solid fa-headset text-accent"></i>
                    <span>Kontak &amp; Layanan 24 Jam</span>
                </h4>
                <ul class="space-y-2 text-gray-300 text-[11px]">
                    @php
                        $phone = \App\Models\SiteSetting::get('contact_phone', '+62 361 890 5678');
                        $wa = \App\Models\SiteSetting::get('contact_whatsapp', '081288889999');
                        $towing = \App\Models\SiteSetting::get('emergency_towing', '081199998888 (24 Jam Tourist Support & SAR Rescue)');
                        $email = \App\Models\SiteSetting::get('contact_email', 'halo@tourguide.id');
                    @endphp

                    @if($phone)
                        <li>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="hover:text-white transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-phone text-accent text-xs"></i>
                                <span>{{ $phone }}</span>
                            </a>
                        </li>
                    @endif

                    @if($wa)
                        <li>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wa) }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i>
                                <span>WA: {{ $wa }} (Konsultasi Cepat)</span>
                            </a>
                        </li>
                    @endif

                    @if($towing)
                        <li class="text-gray-300 flex items-start gap-2">
                            <i class="fa-solid fa-kit-medical text-rose-400 text-xs mt-0.5"></i>
                            <span>{{ $towing }}</span>
                        </li>
                    @endif

                    @if($email)
                        <li class="pt-1">
                            <a href="mailto:{{ $email }}" class="text-accent hover:underline flex items-center gap-2">
                                <i class="fa-regular fa-envelope text-accent text-xs"></i>
                                <span>{{ $email }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Column 4: Quick Links -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-wider font-bold text-xs flex items-center gap-2">
                    <i class="fa-solid fa-link text-accent"></i>
                    <span>Menu Cepat</span>
                </h4>
                <ul class="space-y-2 text-[11px] uppercase tracking-wider text-gray-300">
                    <li><a href="{{ url('/about-us') }}" class="hover:text-accent transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-accent transition-colors">Paket Pemandu Wisata</a></li>
                    <li><a href="{{ url('/portfolio') }}" class="hover:text-accent transition-colors">Destinasi Wisata Unggulan</a></li>
                    <li><a href="{{ url('/booking') }}" class="text-accent font-bold hover:underline">Booking Guide Online</a></li>
                    <li><a href="{{ url('/awards-publications') }}" class="hover:text-accent transition-colors">Sertifikasi &amp; Penghargaan</a></li>
                    <li><a href="{{ url('/clients') }}" class="hover:text-accent transition-colors">Mitra Pariwisata</a></li>
                    <li><a href="{{ url('/our-blog') }}" class="hover:text-accent transition-colors">Travel Blog Indonesia</a></li>
                    <li><a href="{{ url('/cek-garansi') }}" class="hover:text-accent transition-colors">Cek Status Voucher/Tiket</a></li>
                    <li><a href="{{ url('/contact-us') }}" class="hover:text-accent transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom Row: Copyright & Portals -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-[11px] text-gray-400 gap-4">
            <p>Copyright &copy; {{ date('Y') }} <strong>{{ \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') }}</strong>. Seluruh Hak Cipta Dilindungi.</p>
            <div class="flex items-center space-x-4 text-[11px] uppercase tracking-wider">
                <a href="{{ url('/login?role=customer') }}" class="text-gray-300 hover:text-accent transition-colors">Portal Traveler</a>
                <span>•</span>
                <a href="{{ url('/login?role=karyawan') }}" class="text-gray-300 hover:text-accent transition-colors">Portal Pemandu (Guide)</a>
                <span>•</span>
                <a href="{{ url('/admin/login') }}" class="text-gray-300 hover:text-accent transition-colors">Admin CMS</a>
            </div>
        </div>

    </div>
</footer>
