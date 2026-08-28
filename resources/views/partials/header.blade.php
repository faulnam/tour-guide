<header x-data="{ 
            scrolled: false, 
            mobileMenuOpen: false, 
            servicesDropdown: false
        }" 
        x-init="
            scrolled = window.pageYOffset > 30; 
            window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 30 });
        "
        :class="scrolled 
            ? 'bg-[#0b0b10]/95 backdrop-blur-md text-white shadow-xl border-b border-neutral-800 py-3.5' 
            : 'bg-gradient-to-b from-black/90 via-black/50 to-transparent text-white py-5'"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="group flex items-center gap-3 transition-colors">
            <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-800 rounded-xl flex items-center justify-center text-white font-racing font-black text-lg shadow-lg shadow-red-600/30 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-gauge-high text-base"></i>
            </div>
            <div>
                <span class="font-racing font-extrabold text-xl tracking-wider text-white block">APEX<span class="text-red-500">GARAGE</span></span>
                <span class="text-[9px] tracking-[0.25em] uppercase text-neutral-400 font-bold block">Tuning & Custom Studio</span>
            </div>
        </a>

        <!-- Desktop Navigation Menu -->
        <nav class="hidden lg:flex items-center space-x-6 text-xs uppercase tracking-wider font-semibold">
            <a href="{{ url('/') }}" 
               class="transition-colors hover:text-red-400 py-2 {{ request()->is('/') ? 'text-red-500 font-bold' : 'text-neutral-300' }}">
                Beranda
            </a>

            <!-- Services Dropdown -->
            <div class="relative" 
                 @mouseenter="servicesDropdown = true" 
                 @mouseleave="servicesDropdown = false">
                
                <a href="{{ url('/services') }}" 
                   class="inline-flex items-center gap-1.5 transition-colors hover:text-red-400 py-2 {{ request()->is('services*') ? 'text-red-500 font-bold' : 'text-neutral-300' }}">
                    <span>Layanan Modif</span>
                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform" :class="servicesDropdown ? 'rotate-180' : ''"></i>
                </a>

                <!-- Dropdown Menu -->
                <div x-show="servicesDropdown" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     x-cloak
                     class="absolute top-full left-0 mt-1 w-72 bg-[#121218] border border-neutral-800 rounded-xl shadow-2xl p-2 z-50">
                    
                    <div class="px-3 py-2 text-[10px] uppercase font-bold text-neutral-500 tracking-widest border-b border-neutral-800 mb-1">
                        Paket Modifikasi Motor & Mobil
                    </div>

                    @if(isset($navServices) && $navServices->count())
                        @foreach($navServices as $srv)
                            <a href="{{ url('/services/' . $srv->slug) }}" 
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors">
                                <span class="text-sm text-red-500">
                                    <i class="fa-solid fa-{{ $srv->icon ?? 'wrench' }}"></i>
                                </span>
                                <div class="truncate">
                                    <div class="font-bold text-white truncate">{{ $srv->title }}</div>
                                    <div class="text-[10px] text-neutral-400 capitalize">{{ $srv->vehicle_type }} • {{ $srv->formatted_price }}</div>
                                </div>
                            </a>
                        @endforeach
                    @endif

                    <div class="pt-2 border-t border-neutral-800 mt-1">
                        <a href="{{ url('/services') }}" class="block text-center py-2 text-[11px] font-bold text-red-400 hover:text-red-300">
                            Lihat Semua Layanan &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ url('/portfolio') }}" 
               class="transition-colors hover:text-red-400 py-2 {{ request()->is('portfolio*') ? 'text-red-500 font-bold' : 'text-neutral-300' }}">
                Portofolio Build
            </a>

            <a href="{{ url('/booking') }}" 
               class="inline-flex items-center gap-1.5 text-red-400 font-bold bg-red-500/10 border border-red-500/30 px-3.5 py-1.5 rounded-lg hover:bg-red-500/20 transition-all">
                <i class="fa-solid fa-calendar-check text-red-500"></i>
                <span>Booking Online</span>
            </a>

            <a href="{{ url('/about-us') }}" 
               class="transition-colors hover:text-red-400 py-2 {{ request()->is('about-us*') ? 'text-red-500 font-bold' : 'text-neutral-300' }}">
                Tentang Kami
            </a>

            <a href="{{ url('/our-blog') }}" 
               class="transition-colors hover:text-red-400 py-2 {{ request()->is('our-blog*') ? 'text-red-500 font-bold' : 'text-neutral-300' }}">
                Blog
            </a>

            <a href="{{ url('/contact-us') }}" 
               class="transition-colors hover:text-red-400 py-2 {{ request()->is('contact*') ? 'text-red-500 font-bold' : 'text-neutral-300' }}">
                Kontak
            </a>
        </nav>

        <!-- Right Side: User Authentication Portal or Login Button -->
        <div class="hidden lg:flex items-center gap-3">
            @if(auth()->check())
                @php $user = auth()->user(); @endphp
                <div class="flex items-center gap-3 bg-neutral-900/90 border border-neutral-800 rounded-xl px-3 py-1.5">
                    <div class="text-right">
                        <div class="text-xs font-bold text-white truncate max-w-[130px]">{{ $user->name }}</div>
                        <div class="text-[10px] uppercase font-mono font-semibold text-red-400">{{ $user->role }}</div>
                    </div>

                    @if($user->isAdmin())
                        <a href="{{ url('/admin') }}" class="px-3 py-1.5 bg-neutral-800 hover:bg-neutral-700 text-white rounded-lg text-xs font-bold transition-colors">
                            <i class="fa-solid fa-gauge-high mr-1"></i> Admin CMS
                        </a>
                    @elseif($user->isKaryawan())
                        <a href="{{ url('/karyawan/absensi') }}" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-500 text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5 shadow-md shadow-amber-600/30">
                            <i class="fa-solid fa-camera"></i> Absensi
                        </a>
                    @else
                        <a href="{{ url('/customer/dashboard') }}" class="px-3 py-1.5 bg-red-600 hover:bg-red-500 text-white rounded-lg text-xs font-bold transition-colors">
                            <i class="fa-solid fa-car mr-1"></i> Garasi & Booking
                        </a>
                    @endif

                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-1.5 text-neutral-400 hover:text-red-400 transition-colors" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   class="px-4 py-2 bg-neutral-900 hover:bg-neutral-800 text-white border border-neutral-700 rounded-xl text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-2">
                    <i class="fa-solid fa-right-to-bracket text-red-500"></i>
                    <span>Masuk Portal</span>
                </a>
                <a href="{{ route('register') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Daftar</span>
                </a>
            @endif
        </div>

        <!-- Mobile Hamburger Button -->
        <div class="lg:hidden flex items-center gap-2">
            @if(auth()->check())
                <a href="{{ auth()->user()->isAdmin() ? url('/admin') : (auth()->user()->isKaryawan() ? url('/karyawan/absensi') : url('/customer/dashboard')) }}"
                   class="p-2 bg-red-600 text-white rounded-lg text-xs">
                    <i class="fa-solid fa-user"></i>
                </a>
            @endif
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg bg-neutral-900 text-neutral-300 hover:text-white border border-neutral-800">
                <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
            </button>
        </div>

    </div>

    <!-- Mobile Drawer Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         x-cloak
         class="lg:hidden bg-[#101016] border-b border-neutral-800 px-6 py-5 mt-3 space-y-3 text-xs uppercase tracking-wider font-semibold">
        
        <a href="{{ url('/') }}" class="block py-2 text-neutral-200 hover:text-red-400">Beranda</a>
        <a href="{{ url('/services') }}" class="block py-2 text-neutral-200 hover:text-red-400">Layanan & Modifikasi</a>
        <a href="{{ url('/portfolio') }}" class="block py-2 text-neutral-200 hover:text-red-400">Portofolio Build</a>
        <a href="{{ url('/booking') }}" class="block py-2 text-red-400 font-bold">Booking Online & Antrean</a>
        <a href="{{ url('/about-us') }}" class="block py-2 text-neutral-200 hover:text-red-400">Tentang Kami</a>
        <a href="{{ url('/our-blog') }}" class="block py-2 text-neutral-200 hover:text-red-400">Blog Otomotif</a>
        <a href="{{ url('/contact-us') }}" class="block py-2 text-neutral-200 hover:text-red-400">Kontak Workshop</a>

        <div class="pt-4 border-t border-neutral-800 flex flex-col gap-2">
            @if(auth()->check())
                <div class="text-neutral-400 text-[11px] mb-1">Masuk sebagai: <span class="text-white font-bold">{{ auth()->user()->name }}</span> ({{ auth()->user()->role }})</div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ url('/admin') }}" class="w-full text-center py-2.5 bg-neutral-800 text-white rounded-lg font-bold">Admin CMS</a>
                @elseif(auth()->user()->isKaryawan())
                    <a href="{{ url('/karyawan/absensi') }}" class="w-full text-center py-2.5 bg-amber-600 text-white rounded-lg font-bold">Absensi Kamera</a>
                    <a href="{{ url('/karyawan/tasks') }}" class="w-full text-center py-2.5 bg-neutral-800 text-white rounded-lg font-bold">Tugas Modifikasi</a>
                @else
                    <a href="{{ url('/customer/dashboard') }}" class="w-full text-center py-2.5 bg-red-600 text-white rounded-lg font-bold">Garasi & Booking Saya</a>
                @endif
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-center py-2 bg-neutral-900 border border-neutral-800 text-red-400 rounded-lg font-bold">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full text-center py-2.5 bg-neutral-800 text-white rounded-lg font-bold">Masuk Portal</a>
                <a href="{{ route('register') }}" class="w-full text-center py-2.5 bg-red-600 text-white rounded-lg font-bold">Daftar Akun Customer</a>
            @endif
        </div>
    </div>

</header>
