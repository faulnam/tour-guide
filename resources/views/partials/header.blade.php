@php
    $isLightPage = request()->is('login*') || request()->is('register*') || request()->is('admin/login*');
@endphp

<header x-data="{ 
            scrolled: false, 
            mobileMenuOpen: false, 
            servicesDropdown: false
        }" 
        x-init="
            scrolled = window.pageYOffset > 20; 
            window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 20 });
        "
        :class="{
            'bg-white/95 backdrop-blur-md text-[#1A2E26] shadow-sm border-b border-gray-100 py-2.5': scrolled || {{ $isLightPage ? 'true' : 'false' }},
            'bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-transparent text-white py-3.5': !scrolled && !{{ $isLightPage ? 'true' : 'false' }}
        }"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-2 lg:gap-4">
        
        <!-- Brand / Logo -->
        <a href="{{ url('/') }}" class="group flex items-center space-x-2.5 shrink-0 transition-opacity hover:opacity-90">
            <div class="w-8 h-8 rounded-lg bg-accent flex items-center justify-center text-primary-dark shadow-sm shrink-0">
                <i class="fa-solid fa-compass text-sm"></i>
            </div>
            <div class="flex flex-col shrink-0">
                <span class="font-bold text-sm sm:text-base tracking-wider uppercase font-sans leading-tight whitespace-nowrap"
                      :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) ? 'text-primary' : 'text-white'">
                    {{ \App\Models\SiteSetting::get('company_name', 'NUSANTARA') }}
                </span>
                <span class="text-[8px] sm:text-[9px] uppercase tracking-widest text-accent font-semibold leading-none whitespace-nowrap">TOUR GUIDE INDONESIA</span>
            </div>
        </a>

        <!-- Desktop Navigation Menu (Strictly 1 Single Line) -->
        <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-[11px] xl:text-xs uppercase tracking-wider font-semibold flex-nowrap shrink-0">
            
            <!-- Home -->
            <a href="{{ url('/') }}" 
               class="whitespace-nowrap px-2 xl:px-2.5 py-1.5 rounded-md transition-colors hover:text-accent {{ request()->is('/') ? 'text-accent font-bold' : '' }}">
                Beranda
            </a>

            <!-- About Us -->
            <a href="{{ url('/about-us') }}" 
               class="whitespace-nowrap px-2 xl:px-2.5 py-1.5 rounded-md transition-colors hover:text-accent {{ request()->is('about-us*') ? 'text-accent font-bold' : '' }}">
                Tentang Kami
            </a>

            <!-- Services Dropdown (Paket Pemandu) -->
            <div class="relative shrink-0" 
                 @mouseenter="servicesDropdown = true" 
                 @mouseleave="servicesDropdown = false">
                
                <a href="{{ url('/services') }}" 
                   class="whitespace-nowrap inline-flex items-center gap-1 px-2 xl:px-2.5 py-1.5 rounded-md transition-colors hover:text-accent {{ request()->is('services*') ? 'text-accent font-bold' : '' }}">
                    <span>Layanan Guide</span>
                    <i class="fa-solid fa-chevron-down text-[8px] transition-transform duration-200" :class="servicesDropdown ? 'rotate-180' : ''"></i>
                </a>

                <!-- Desktop Dropdown Box -->
                <div x-show="servicesDropdown" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-1"
                     x-cloak
                     class="absolute top-full left-0 mt-1 w-64 bg-white text-[#1A2E26] shadow-xl rounded-xl border border-gray-100 py-2 z-50 overflow-hidden text-left">
                    
                    <a href="{{ url('/services') }}" 
                       class="block px-4 py-2 text-[10px] uppercase tracking-widest font-bold text-primary hover:bg-sage-light hover:text-primary transition-colors border-b border-gray-100 mb-1">
                        Semua Paket Pemandu &rarr;
                    </a>

                    @if(isset($navServices) && $navServices->count())
                        @foreach($navServices as $parentService)
                            @if($parentService->children->count())
                                <div class="relative group/sub" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                    <a href="{{ url('/services/' . $parentService->slug) }}" 
                                       class="flex items-center justify-between px-4 py-1.5 text-xs text-gray-700 hover:bg-sage-light hover:text-primary transition-colors">
                                        <span>{{ $parentService->title }}</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-gray-400"></i>
                                    </a>

                                    <div x-show="subOpen" 
                                         x-transition
                                         x-cloak
                                         class="absolute left-full top-0 w-60 bg-white text-[#1A2E26] shadow-xl rounded-xl border border-gray-100 py-2">
                                        @foreach($parentService->children as $childService)
                                            <a href="{{ url('/services/' . $parentService->slug . '/' . $childService->slug) }}" 
                                               class="block px-4 py-1.5 text-xs text-gray-600 hover:bg-sage-light hover:text-primary transition-colors">
                                                {{ $childService->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ url('/services/' . $parentService->slug) }}" 
                                   class="block px-4 py-1.5 text-xs text-gray-700 hover:bg-sage-light hover:text-primary transition-colors">
                                    {{ $parentService->title }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Destinations / Portfolio -->
            <a href="{{ url('/portfolio') }}" 
               class="whitespace-nowrap px-2 xl:px-2.5 py-1.5 rounded-md transition-colors hover:text-accent {{ request()->is('portfolio*') ? 'text-accent font-bold' : '' }}">
                Destinasi Wisata
            </a>

            <!-- Awards / Certifications -->
            <a href="{{ url('/awards-publications') }}" 
               class="whitespace-nowrap px-2 xl:px-2.5 py-1.5 rounded-md transition-colors hover:text-accent {{ request()->is('awards-publications*') || request()->is('awards*') ? 'text-accent font-bold' : '' }}">
                Sertifikasi HPI
            </a>

            <!-- Partners -->
            <a href="{{ url('/clients') }}" 
               class="whitespace-nowrap px-2 xl:px-2.5 py-1.5 rounded-md transition-colors hover:text-accent {{ request()->is('clients*') ? 'text-accent font-bold' : '' }}">
                Mitra
            </a>

            <!-- Blog -->
            <a href="{{ url('/our-blog') }}" 
               class="whitespace-nowrap px-2 xl:px-2.5 py-1.5 rounded-md transition-colors hover:text-accent {{ request()->is('our-blog*') || request()->is('blog*') ? 'text-accent font-bold' : '' }}">
                Travel Blog
            </a>

            <!-- Contact -->
            <a href="{{ url('/contact-us') }}" 
               class="whitespace-nowrap px-2 xl:px-2.5 py-1.5 rounded-md transition-colors hover:text-accent {{ request()->is('contact-us*') ? 'text-accent font-bold' : '' }}">
                Kontak
            </a>

        </nav>

        <!-- Right Side: Booking Button & User Portal -->
        <div class="hidden lg:flex items-center space-x-2 xl:space-x-3 shrink-0">
            <!-- Booking Online CTA Button -->
            <a href="{{ url('/booking') }}" 
               class="whitespace-nowrap px-3.5 py-2 bg-accent hover:bg-accent-dark text-neutral-dark hover:text-white rounded-lg transition-all text-xs uppercase tracking-wider font-bold shadow-sm inline-flex items-center gap-1.5">
                <i class="fa-solid fa-calendar-check text-xs"></i>
                <span>Booking Guide</span>
            </a>

            @if(auth()->check())
                @php $user = auth()->user(); @endphp
                <div class="flex items-center space-x-2 text-xs pl-2 border-l border-gray-200/50 shrink-0">
                    <span class="text-xs uppercase tracking-wider font-semibold truncate max-w-[110px]"
                          :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) ? 'text-gray-700' : 'text-gray-200'">
                        {{ $user->name }}
                    </span>

                    @if($user->isAdmin())
                        <a href="{{ url('/admin') }}" 
                           class="whitespace-nowrap px-2.5 py-1.5 rounded-lg border transition-all text-[10px] uppercase tracking-wider font-bold bg-primary text-white hover:bg-secondary border-primary">
                            Admin CMS
                        </a>
                    @elseif($user->isKaryawan())
                        <a href="{{ url('/karyawan/absensi') }}" 
                           class="whitespace-nowrap px-2.5 py-1.5 rounded-lg border transition-all text-[10px] uppercase tracking-wider font-bold bg-sage text-white hover:bg-primary border-sage">
                            Portal Guide
                        </a>
                    @else
                        <a href="{{ url('/customer/profile') }}" 
                           class="whitespace-nowrap px-2.5 py-1.5 rounded-lg border transition-all text-[10px] uppercase tracking-wider font-bold bg-primary text-white hover:bg-secondary border-primary">
                            Akun Saya
                        </a>
                    @endif

                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="text-xs transition-colors p-1.5 text-gray-400 hover:text-rose-500" 
                                title="Sign Out">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   class="whitespace-nowrap px-3 py-2 rounded-lg border transition-all text-xs uppercase tracking-wider font-semibold inline-flex items-center gap-1"
                   :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) 
                       ? 'border-gray-300 text-gray-800 hover:border-primary hover:bg-primary hover:text-white' 
                       : 'border-white/50 text-white hover:bg-white hover:text-primary'">
                    <i class="fa-regular fa-user"></i> <span>Login</span>
                </a>
            @endif
        </div>

        <!-- Mobile Menu Hamburger Button -->
        <div class="lg:hidden flex items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    type="button" 
                    class="p-2 rounded-lg transition-colors focus:outline-none"
                    :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) ? 'text-primary bg-gray-100' : 'text-white bg-white/10 backdrop-blur-sm'"
                    aria-label="Toggle Navigation Menu">
                <i x-show="!mobileMenuOpen" class="fa-solid fa-bars text-base"></i>
                <i x-show="mobileMenuOpen" x-cloak class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

    </div>

    <!-- Mobile Drawer Overlay & Nav -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-cloak
         class="lg:hidden bg-primary-dark text-white px-6 py-6 border-t border-primary/50 space-y-3 max-h-[85vh] overflow-y-auto">
        
        <a href="{{ url('/') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-2 border-b border-primary/40 hover:text-accent {{ request()->is('/') ? 'text-accent font-bold' : '' }}">Beranda</a>
        <a href="{{ url('/about-us') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-2 border-b border-primary/40 hover:text-accent {{ request()->is('about-us*') ? 'text-accent font-bold' : '' }}">Tentang Kami</a>

        <!-- Mobile Services Accordion -->
        <div x-data="{ mobileServicesOpen: false }" class="border-b border-primary/40 py-2">
            <button @click="mobileServicesOpen = !mobileServicesOpen" class="w-full flex items-center justify-between text-xs uppercase tracking-wider hover:text-accent {{ request()->is('services*') ? 'text-accent font-bold' : '' }}">
                <span>Layanan Guide</span>
                <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="mobileServicesOpen ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="mobileServicesOpen" x-cloak class="pl-4 pt-2 space-y-2">
                <a href="{{ url('/services') }}" @click="mobileMenuOpen = false" class="block text-[10px] uppercase tracking-wider text-accent font-bold">Semua Paket &rarr;</a>
                @if(isset($navServices) && $navServices->count())
                    @foreach($navServices as $pService)
                        <div x-data="{ subOpen: false }" class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <a href="{{ url('/services/' . $pService->slug) }}" @click="mobileMenuOpen = false" class="text-[10px] tracking-wide text-gray-300 hover:text-white font-medium">
                                    {{ $pService->title }}
                                </a>
                                @if($pService->children->count())
                                    <button @click="subOpen = !subOpen" class="p-1 text-gray-400">
                                        <i class="fa-solid fa-chevron-down text-[8px] transition-transform" :class="subOpen ? 'rotate-180' : ''"></i>
                                    </button>
                                @endif
                            </div>
                            @if($pService->children->count())
                                <div x-show="subOpen" x-cloak class="pl-3 space-y-1.5 border-l border-primary/40">
                                    @foreach($pService->children as $cService)
                                        <a href="{{ url('/services/' . $pService->slug . '/' . $cService->slug) }}" @click="mobileMenuOpen = false" class="block text-[9px] tracking-wide text-gray-400 hover:text-accent">
                                            {{ $cService->title }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <a href="{{ url('/portfolio') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-2 border-b border-primary/40 hover:text-accent {{ request()->is('portfolio*') ? 'text-accent font-bold' : '' }}">Destinasi Wisata</a>
        <a href="{{ url('/awards-publications') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-2 border-b border-primary/40 hover:text-accent {{ request()->is('awards*') ? 'text-accent font-bold' : '' }}">Sertifikasi HPI</a>
        <a href="{{ url('/clients') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-2 border-b border-primary/40 hover:text-accent {{ request()->is('clients*') ? 'text-accent font-bold' : '' }}">Mitra Pariwisata</a>
        <a href="{{ url('/booking') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-2 border-b border-primary/40 text-accent font-bold">Booking Pemandu</a>
        <a href="{{ url('/our-blog') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-2 border-b border-primary/40 hover:text-accent {{ request()->is('our-blog*') || request()->is('blog*') ? 'text-accent font-bold' : '' }}">Travel Blog</a>
        <a href="{{ url('/contact-us') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-2 border-b border-primary/40 hover:text-accent {{ request()->is('contact-us*') ? 'text-accent font-bold' : '' }}">Kontak Kami</a>

        <div class="pt-3 border-t border-primary/40 space-y-2">
            @if(auth()->check())
                <div class="text-[10px] text-gray-400">Signed in as <strong class="text-white">{{ auth()->user()->name }}</strong></div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ url('/admin') }}" class="block text-center py-2.5 bg-primary rounded-lg border border-primary text-white text-xs uppercase tracking-wider font-semibold">Admin CMS</a>
                @elseif(auth()->user()->isKaryawan())
                    <a href="{{ url('/karyawan/absensi') }}" class="block text-center py-2.5 bg-sage rounded-lg border border-sage text-white text-xs uppercase tracking-wider font-semibold">Portal Guide &amp; Absensi</a>
                @else
                    <a href="{{ url('/customer/profile') }}" class="block text-center py-2.5 bg-primary rounded-lg border border-primary text-white text-xs uppercase tracking-wider font-semibold">Portal Traveler</a>
                @endif
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-center py-2 text-gray-400 hover:text-rose-400 text-xs uppercase tracking-wider">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-center py-2.5 rounded-lg border border-accent bg-accent text-neutral-dark text-xs uppercase tracking-wider font-bold">Portal Login</a>
            @endif
        </div>
    </div>

</header>
