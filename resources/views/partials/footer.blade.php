<footer class="bg-[#0b0b0f] border-t border-neutral-800/80 text-neutral-400 text-xs">
    
    <!-- Top Highlights Banner -->
    <div class="border-b border-neutral-800/60 py-10 bg-gradient-to-r from-red-950/20 via-[#0e0e14] to-neutral-900/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <div class="flex items-center gap-4 p-4 rounded-xl bg-neutral-900/50 border border-neutral-800">
                <div class="w-12 h-12 rounded-xl bg-red-600/20 text-red-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <div>
                    <div class="font-bold text-white uppercase text-sm">Dyno Jet 224xLC</div>
                    <div class="text-[11px] text-neutral-400">Kalibrasi Tenaga Akurat & Real-Time</div>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-xl bg-neutral-900/50 border border-neutral-800">
                <div class="w-12 h-12 rounded-xl bg-amber-600/20 text-amber-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-spray-can-sparkles"></i>
                </div>
                <div>
                    <div class="font-bold text-white uppercase text-sm">Cat Oven Spies Hecker</div>
                    <div class="text-[11px] text-neutral-400">Garansi Cat 2 Tahun Bebas Pudar</div>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-xl bg-neutral-900/50 border border-neutral-800">
                <div class="w-12 h-12 rounded-xl bg-cyan-600/20 text-cyan-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <div class="font-bold text-white uppercase text-sm">Garansi Resmi Build</div>
                    <div class="text-[11px] text-neutral-400">Jaminan Kualitas Fabrikasi & Suku Cadang</div>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-xl bg-neutral-900/50 border border-neutral-800">
                <div class="w-12 h-12 rounded-xl bg-emerald-600/20 text-emerald-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div>
                    <div class="font-bold text-white uppercase text-sm">Payment Gateway</div>
                    <div class="text-[11px] text-neutral-400">Bayar DP & Pelunasan via QRIS / VA Instan</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            
            <!-- Column 1: Brand Info -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-800 rounded-xl flex items-center justify-center text-white font-racing font-black text-lg shadow-lg shadow-red-600/30">
                        <i class="fa-solid fa-gauge-high text-base"></i>
                    </div>
                    <div>
                        <span class="font-racing font-extrabold text-xl tracking-wider text-white block">APEX<span class="text-red-500">GARAGE</span></span>
                        <span class="text-[9px] tracking-[0.25em] uppercase text-neutral-400 font-bold block">Tuning & Custom Studio</span>
                    </div>
                </a>

                <p class="text-xs text-neutral-400 leading-relaxed max-w-sm">
                    Bengkel dan studio modifikasi performa tinggi spesialis Motor & Mobil di Jakarta. Layanan terpadu Dyno Jet ECU remap, custom motorcycle builder, bodykit widebody, cat oven Spies Hecker, dan suspensi udara.
                </p>

                <div class="flex items-center space-x-3 pt-2">
                    <a href="https://instagram.com" target="_blank" class="w-9 h-9 rounded-lg bg-neutral-900 border border-neutral-800 text-neutral-300 hover:text-white hover:bg-red-600 transition-colors flex items-center justify-center">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank" class="w-9 h-9 rounded-lg bg-neutral-900 border border-neutral-800 text-neutral-300 hover:text-white hover:bg-red-600 transition-colors flex items-center justify-center">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="https://tiktok.com" target="_blank" class="w-9 h-9 rounded-lg bg-neutral-900 border border-neutral-800 text-neutral-300 hover:text-white hover:bg-red-600 transition-colors flex items-center justify-center">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                    <a href="https://wa.me/6281288889999" target="_blank" class="w-9 h-9 rounded-lg bg-neutral-900 border border-neutral-800 text-neutral-300 hover:text-white hover:bg-emerald-600 transition-colors flex items-center justify-center">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Layanan Modifikasi -->
            <div class="space-y-3">
                <div class="text-xs font-bold text-white uppercase tracking-wider font-racing">Layanan Modif</div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ url('/services/ecu-remap-dyno-tuning') }}" class="hover:text-red-400 transition-colors">ECU Remap & Dyno Run</a></li>
                    <li><a href="{{ url('/services/custom-motorcycle-build') }}" class="hover:text-red-400 transition-colors">Custom Bike & Cafe Racer</a></li>
                    <li><a href="{{ url('/services/widebody-custom-aerokit') }}" class="hover:text-red-400 transition-colors">Widebody & Carbon Aero</a></li>
                    <li><a href="{{ url('/services/custom-paint-oven-airbrush') }}" class="hover:text-red-400 transition-colors">Cat Oven Spies Hecker</a></li>
                    <li><a href="{{ url('/services/air-suspension-big-brake-kit') }}" class="hover:text-red-400 transition-colors">Air Suspension & BBK</a></li>
                    <li><a href="{{ url('/services/ceramic-coating-detailing-9h') }}" class="hover:text-red-400 transition-colors">Nano Ceramic Coating 9H</a></li>
                </ul>
            </div>

            <!-- Column 3: Tautan Cepat -->
            <div class="space-y-3">
                <div class="text-xs font-bold text-white uppercase tracking-wider font-racing">Navigasi</div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ url('/booking') }}" class="text-red-400 font-bold hover:underline"><i class="fa-solid fa-calendar-plus mr-1"></i> Booking Online</a></li>
                    <li><a href="{{ url('/portfolio') }}" class="hover:text-red-400 transition-colors">Hasil Modifikasi & Dyno</a></li>
                    <li><a href="{{ url('/about-us') }}" class="hover:text-red-400 transition-colors">Fasilitas Workshop</a></li>
                    <li><a href="{{ url('/our-blog') }}" class="hover:text-red-400 transition-colors">Tips & Artikel Otomotif</a></li>
                    <li><a href="{{ url('/contact-us') }}" class="hover:text-red-400 transition-colors">Lokasi & Jam Buka</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-red-400 transition-colors">Login 3 Role Portal</a></li>
                </ul>
            </div>

            <!-- Column 4: Workshop & Kontak -->
            <div class="space-y-3">
                <div class="text-xs font-bold text-white uppercase tracking-wider font-racing">Workshop Info</div>
                <div class="space-y-2.5 text-xs text-neutral-400">
                    <div class="flex items-start gap-2.5">
                        <i class="fa-solid fa-location-dot text-red-500 mt-1"></i>
                        <span>Jl. TB Simatupang No. 88, Cilandak, Jakarta Selatan</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-phone text-red-500"></i>
                        <span>+62 21 7890 1234</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                        <span>0812-8888-9999 (Fast Response)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i class="fa-solid fa-clock text-amber-500 mt-1"></i>
                        <span>Senin - Sabtu: 08.30 - 18.00 WIB</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright -->
        <div class="pt-10 mt-10 border-t border-neutral-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500">
            <div>
                &copy; {{ date('Y') }} <span class="text-neutral-300 font-bold">Apex Garage Indonesia</span>. All rights reserved. Built with high precision.
            </div>
            <div class="flex items-center gap-4">
                <span>Bengkel Modifikasi Motor & Mobil</span>
                <span>•</span>
                <a href="{{ route('admin.login') }}" class="hover:text-neutral-300">Admin Login</a>
                <span>•</span>
                <a href="{{ route('login', ['role' => 'karyawan']) }}" class="hover:text-neutral-300">Absensi Karyawan</a>
            </div>
        </div>
    </div>

</footer>
