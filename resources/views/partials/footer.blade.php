<footer class="bg-black text-white border-t border-neutral-900">
    <div class="max-w-7xl mx-auto px-6 md:px-12 py-16">
        
        <!-- Top Row: Minimal Brand & Social Icons -->
        <div class="flex flex-col md:flex-row md:items-center justify-between pb-12 border-b border-neutral-900 gap-6">
            <div>
                <a href="{{ url('/') }}" class="font-extrabold text-2xl tracking-widest3 uppercase text-white font-sans inline-block">
                    {{ \App\Models\SiteSetting::get('company_name', 'BENGKEL') }}
                </a>
                <p class="text-neutral-400 text-xs mt-1 uppercase tracking-widest">
                    {{ \App\Models\SiteSetting::get('company_tagline', 'Workshop & Studio Modifikasi Motor dan Mobil') }}
                </p>
            </div>

            <!-- Social Links -->
            <div class="flex items-center space-x-5 text-neutral-400 text-sm">
                @if($ig = \App\Models\SiteSetting::get('social_instagram', 'https://instagram.com'))
                    <a href="{{ $ig }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors p-1" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif
                @if($fb = \App\Models\SiteSetting::get('social_facebook', 'https://facebook.com'))
                    <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors p-1" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.688 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
                    </a>
                @endif
                @if($yt = \App\Models\SiteSetting::get('social_youtube', 'https://youtube.com'))
                    <a href="{{ $yt }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors p-1" aria-label="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                @endif
                @if($tt = \App\Models\SiteSetting::get('social_tiktok', 'https://tiktok.com'))
                    <a href="{{ $tt }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors p-1" aria-label="TikTok">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-1.01v8.14c0 1.9-.4 3.79-1.42 5.37-1.12 1.75-2.87 3.08-4.88 3.65-1.95.55-4.08.36-5.91-.53-1.89-.92-3.4-2.54-4.2-4.52-.81-2.02-.73-4.32.22-6.27.94-1.94 2.6-3.46 4.62-4.24 1.25-.49 2.62-.64 3.96-.46v4.11c-.75-.24-1.57-.25-2.34-.05-.8.2-1.5.67-1.99 1.34-.51.7-.76 1.57-.7 2.44.06.88.48 1.71 1.16 2.29.68.58 1.57.87 2.46.82.91-.05 1.77-.48 2.37-1.17.48-.56.76-1.28.76-2.03V.02z"/></svg>
                    </a>
                @endif
            </div>
        </div>

        <!-- Middle Row: 4 Column Navigation & Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 py-14 border-b border-neutral-900 text-xs">
            
            <!-- Column 1: Newsletter -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-widest2 font-semibold text-xs">Stay Connected</h4>
                <p class="text-neutral-400 text-[11px] leading-relaxed">
                    Dapatkan kabar terkini seputar proyek modifikasi, jadwal dyno battle, event komunitas, dan promo servis berkala.
                </p>
                <form action="{{ url('/newsletter/subscribe') }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="flex flex-col space-y-2">
                        <input type="email" 
                               name="email" 
                               required 
                               placeholder="Email Address" 
                               class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors placeholder:text-neutral-600">
                        <button type="submit" 
                                class="w-full bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 py-3 font-semibold transition-colors">
                            Subscribe
                        </button>
                    </div>
                </form>
            </div>

            <!-- Column 2: Workshop Location -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-widest2 font-semibold text-xs">Workshop Studio</h4>
                <p class="text-neutral-400 text-[11px] leading-relaxed whitespace-pre-line">
                    {{ \App\Models\SiteSetting::get('company_address', \App\Models\SiteSetting::get('contact_address', "BENGKEL Modifikasi Motor & Mobil\nJl. TB Simatupang No. 88\nCilandak, Jakarta Selatan 12430")) }}
                </p>
                <div class="text-[11px] text-neutral-400">
                    <span class="text-neutral-300 font-medium">Jam Buka:</span><br>
                    {{ \App\Models\SiteSetting::get('working_hours', 'Senin - Sabtu: 08.30 - 18.00 WIB | Minggu: Dyno & Booking Only') }}
                </div>
                <a href="{{ \App\Models\SiteSetting::get('company_directions_url', 'https://maps.google.com/?q=-6.3,106.8') }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="inline-block text-[11px] uppercase tracking-widest font-semibold text-white border-b border-white hover:text-accent hover:border-accent transition-colors pb-0.5">
                    Petunjuk Arah &rarr;
                </a>
            </div>

            <!-- Column 3: Contact & Hotline Details -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-widest2 font-semibold text-xs">Contact &amp; Hotline</h4>
                <ul class="space-y-2.5 text-neutral-400 text-[11px]">
                    @php
                        $phone = \App\Models\SiteSetting::get('company_phone_1', \App\Models\SiteSetting::get('contact_phone', '+62 21 7890 1234'));
                        $wa = \App\Models\SiteSetting::get('company_whatsapp', \App\Models\SiteSetting::get('contact_whatsapp', '+6281288889999'));
                        $towing = \App\Models\SiteSetting::get('emergency_towing', '0811-9999-8888 (24 Jam Towing)');
                        $email = \App\Models\SiteSetting::get('company_email_info', \App\Models\SiteSetting::get('contact_email', 'info@bengkelmodifikasi.id'));
                    @endphp

                    @if($phone)
                        <li>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="hover:text-white transition-colors flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>{{ $phone }}</span>
                            </a>
                        </li>
                    @endif

                    @if($wa)
                        <li>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wa) }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                <span>WA: {{ $wa }} (Konsultasi Fast Response)</span>
                            </a>
                        </li>
                    @endif

                    @if($towing)
                        <li class="text-neutral-400">
                            <span class="text-neutral-300 font-medium">Towing:</span> {{ $towing }}
                        </li>
                    @endif

                    @if($email)
                        <li class="pt-1">
                            <a href="mailto:{{ $email }}" class="text-white hover:text-accent transition-colors underline">
                                {{ $email }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Column 4: Quick Links -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-widest2 font-semibold text-xs">Quick Links</h4>
                <ul class="space-y-2 text-[11px] uppercase tracking-wider text-neutral-400">
                    <li><a href="{{ url('/about-us') }}" class="hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-white transition-colors">Services &amp; Packages</a></li>
                    <li><a href="{{ url('/portfolio') }}" class="hover:text-white transition-colors">Portfolio &amp; Dyno</a></li>
                    <li><a href="{{ url('/booking') }}" class="hover:text-white transition-colors text-white font-semibold">Booking Online</a></li>
                    <li><a href="{{ url('/awards-publications') }}" class="hover:text-white transition-colors">Awards &amp; Kontes</a></li>
                    <li><a href="{{ url('/clients') }}" class="hover:text-white transition-colors">Partners &amp; Brands</a></li>
                    <li><a href="{{ url('/our-blog') }}" class="hover:text-white transition-colors">Blog Otomotif</a></li>
                    <li><a href="{{ url('/cek-garansi') }}" class="hover:text-white transition-colors text-accent">Cek Garansi</a></li>
                    <li><a href="{{ url('/contact-us') }}" class="hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom Row: Copyright & Portals -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-[11px] text-neutral-500 gap-4">
            <p>{{ \App\Models\SiteSetting::get('footer_copyright', 'Copyright © ' . date('Y') . ' BENGKEL Modifikasi Motor & Mobil. All rights reserved.') }}</p>
            <div class="flex items-center space-x-4 text-[10px] uppercase tracking-widest">
                <a href="{{ url('/login?role=customer') }}" class="text-neutral-400 hover:text-white transition-colors">Garasi Customer</a>
                <span>•</span>
                <a href="{{ url('/login?role=karyawan') }}" class="text-neutral-400 hover:text-white transition-colors">Portal Karyawan</a>
                <span>•</span>
                <a href="{{ url('/admin/login') }}" class="text-neutral-400 hover:text-white transition-colors">Admin CMS</a>
            </div>
        </div>

    </div>
</footer>
