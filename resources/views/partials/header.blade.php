<header x-data="{ 
            scrolled: false, 
            mobileMenuOpen: false, 
            servicesDropdown: false
        }" 
        x-init="
            scrolled = window.pageYOffset > 50; 
            window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 50 });
        "
        :class="scrolled 
            ? 'bg-white/95 backdrop-blur-md text-black shadow-md border-b border-neutral-200 py-4' 
            : 'bg-gradient-to-b from-black/85 via-black/40 to-transparent text-white py-6'"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
    
    <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center justify-between">
        
        <!-- Brand / Logo -->
        <a href="{{ url('/') }}" class="group flex items-center space-x-3 transition-opacity duration-200 hover:opacity-90">
            <span class="font-bold text-xl md:text-2xl tracking-widest3 uppercase leading-none font-sans" :class="scrolled ? 'text-black' : 'text-white'">
                METRIX
            </span>
            <span class="hidden sm:inline-block text-[9px] uppercase tracking-widest border-l pl-3 py-0.5" :class="scrolled ? 'border-neutral-300 text-neutral-500' : 'border-white/30 text-neutral-300'">
                Garage &amp; Tuning
            </span>
        </a>

        <!-- Desktop Navigation Menu -->
        <nav class="hidden lg:flex items-center space-x-7 text-xs uppercase tracking-widest2 font-medium">
            <a href="{{ url('/') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('/') ? 'text-accent font-semibold' : '' }}">
                Home
            </a>

            <a href="{{ url('/about-us') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('about-us*') ? 'text-accent font-semibold' : '' }}">
                About Us
            </a>

            <a href="{{ url('/clients') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('clients*') ? 'text-accent font-semibold' : '' }}">
                Clients
            </a>

            <!-- Services Dropdown (Hierarchical Menu) -->
            <div class="relative" 
                 @mouseenter="servicesDropdown = true" 
                 @mouseleave="servicesDropdown = false">
                
                <a href="{{ url('/services') }}" 
                   class="inline-flex items-center space-x-1.5 transition-colors duration-200 hover:text-accent py-2 {{ request()->is('services*') ? 'text-accent font-semibold' : '' }}">
                    <span>Services</span>
                    <svg class="w-3 h-3 transition-transform duration-200" 
                         :class="servicesDropdown ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>

                <!-- Desktop Mega/Dropdown Box -->
                <div x-show="servicesDropdown" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     x-cloak
                     class="absolute top-full left-0 mt-0 w-64 bg-white text-black shadow-xl border border-neutral-200 py-3 z-50">
                    
                    <a href="{{ url('/services') }}" 
                       class="block px-5 py-2 text-[11px] uppercase tracking-widest font-bold text-black hover:bg-neutral-100 hover:text-accent transition-colors border-b border-neutral-100 mb-1">
                        All Services &rarr;
                    </a>

                    @if(isset($navServices) && $navServices->count())
                        @foreach($navServices as $parentService)
                            @if($parentService->children->count())
                                <!-- Parent with Children Nested Dropdown -->
                                <div class="relative group/sub" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                    <a href="{{ url('/services/' . $parentService->slug) }}" 
                                       class="flex items-center justify-between px-5 py-2.5 text-[11px] uppercase tracking-wider text-gray-800 hover:bg-neutral-50 hover:text-accent transition-colors">
                                        <span>{{ $parentService->title }}</span>
                                        <svg class="w-2.5 h-2.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>

                                    <!-- Subcategory Flyout Panel -->
                                    <div x-show="subOpen" 
                                         x-transition
                                         x-cloak
                                         class="absolute left-full top-0 w-64 bg-white text-black shadow-xl border border-neutral-200 py-2">
                                        @foreach($parentService->children as $childService)
                                            <a href="{{ url('/services/' . $parentService->slug . '/' . $childService->slug) }}" 
                                               class="block px-5 py-2.5 text-[11px] uppercase tracking-wider text-gray-700 hover:bg-neutral-50 hover:text-accent transition-colors">
                                                {{ $childService->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ url('/services/' . $parentService->slug) }}" 
                                   class="block px-5 py-2.5 text-[11px] uppercase tracking-wider text-gray-800 hover:bg-neutral-50 hover:text-accent transition-colors">
                                    {{ $parentService->title }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <a href="{{ url('/portfolio') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('portfolio*') ? 'text-accent font-semibold' : '' }}">
                Portfolio
            </a>

            <a href="{{ url('/awards-publications') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('awards-publications*') ? 'text-accent font-semibold' : '' }}">
                Awards & Publications
            </a>

            <!-- Online Booking Menu (Replaced Career) -->
            <a href="{{ url('/booking') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('booking*') ? 'text-accent font-bold' : '' }}">
                Booking
            </a>

            <a href="{{ url('/contact-us') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('contact-us*') ? 'text-accent font-semibold' : '' }}">
                Contact Us
            </a>

            <a href="{{ url('/our-blog') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('our-blog*') ? 'text-accent font-semibold' : '' }}">
                Our Blog
            </a>
        </nav>

        <!-- Right Side: User Portal / Login Button -->
        <div class="hidden lg:flex items-center space-x-4">
            @if(auth()->check())
                @php $user = auth()->user(); @endphp
                <div class="flex items-center space-x-3 text-xs">
                    <span class="text-[11px] uppercase tracking-wider font-semibold" :class="scrolled ? 'text-neutral-700' : 'text-neutral-200'">
                        {{ $user->name }}
                    </span>

                    @if($user->isAdmin())
                        <a href="{{ url('/admin') }}" class="px-3.5 py-1.5 border border-black bg-black text-white hover:bg-white hover:text-black transition-colors text-[10px] uppercase tracking-widest font-semibold">
                            Admin CMS
                        </a>
                    @elseif($user->isKaryawan())
                        <a href="{{ url('/karyawan/absensi') }}" class="px-3.5 py-1.5 border border-black bg-black text-white hover:bg-white hover:text-black transition-colors text-[10px] uppercase tracking-widest font-semibold">
                            Absensi
                        </a>
                    @else
                        <a href="{{ url('/customer/dashboard') }}" class="px-3.5 py-1.5 border border-black bg-black text-white hover:bg-white hover:text-black transition-colors text-[10px] uppercase tracking-widest font-semibold">
                            My Garage
                        </a>
                    @endif

                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-neutral-400 hover:text-red-500 text-xs transition-colors" title="Sign Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   class="px-4 py-2 border transition-all text-[11px] uppercase tracking-widest font-medium"
                   :class="scrolled 
                       ? 'border-black text-black hover:bg-black hover:text-white' 
                       : 'border-white text-white hover:bg-white hover:text-black'">
                    Portal Login
                </a>
            @endif
        </div>

        <!-- Mobile Menu Hamburger Button -->
        <div class="lg:hidden flex items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    type="button" 
                    class="p-2 transition-colors focus:outline-none"
                    :class="scrolled ? 'text-black' : 'text-white'"
                    aria-label="Toggle Navigation Menu">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

    </div>

    <!-- Mobile Drawer Overlay & Nav -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         x-cloak
         class="lg:hidden bg-black text-white px-6 py-8 border-t border-neutral-800 space-y-4 max-h-[85vh] overflow-y-auto">
        
        <a href="{{ url('/') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">Home</a>
        <a href="{{ url('/about-us') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">About Us</a>
        <a href="{{ url('/clients') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">Clients</a>

        <!-- Mobile Services Accordion -->
        <div x-data="{ mobileServicesOpen: false }" class="border-b border-neutral-800 py-2">
            <button @click="mobileServicesOpen = !mobileServicesOpen" class="w-full flex items-center justify-between text-xs uppercase tracking-widest2 hover:text-accent">
                <span>Services</span>
                <svg class="w-4 h-4 transition-transform" :class="mobileServicesOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="mobileServicesOpen" x-cloak class="pl-4 pt-3 space-y-3">
                <a href="{{ url('/services') }}" @click="mobileMenuOpen = false" class="block text-[11px] uppercase tracking-wider text-neutral-400 hover:text-white">All Services</a>
                @if(isset($navServices) && $navServices->count())
                    @foreach($navServices as $pService)
                        <div x-data="{ subOpen: false }" class="space-y-2">
                            <div class="flex items-center justify-between">
                                <a href="{{ url('/services/' . $pService->slug) }}" @click="mobileMenuOpen = false" class="text-[11px] uppercase tracking-wider text-neutral-300 hover:text-white font-medium">
                                    {{ $pService->title }}
                                </a>
                                @if($pService->children->count())
                                    <button @click="subOpen = !subOpen" class="p-1 text-neutral-400">
                                        <svg class="w-3 h-3 transition-transform" :class="subOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                @endif
                            </div>
                            @if($pService->children->count())
                                <div x-show="subOpen" x-cloak class="pl-4 space-y-2 border-l border-neutral-800">
                                    @foreach($pService->children as $cService)
                                        <a href="{{ url('/services/' . $pService->slug . '/' . $cService->slug) }}" @click="mobileMenuOpen = false" class="block text-[10px] uppercase tracking-wider text-neutral-400 hover:text-accent">
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

        <a href="{{ url('/portfolio') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">Portfolio</a>
        <a href="{{ url('/awards-publications') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">Awards & Publications</a>
        <a href="{{ url('/booking') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 text-accent font-semibold">Booking Online</a>
        <a href="{{ url('/contact-us') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">Contact Us</a>
        <a href="{{ url('/our-blog') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 hover:text-accent">Our Blog</a>

        <div class="pt-4 border-t border-neutral-800 space-y-2">
            @if(auth()->check())
                <div class="text-[11px] text-neutral-400">Signed in as <strong class="text-white">{{ auth()->user()->name }}</strong></div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ url('/admin') }}" class="block text-center py-2.5 bg-neutral-900 border border-neutral-700 text-white text-xs uppercase tracking-widest font-semibold">Admin CMS</a>
                @elseif(auth()->user()->isKaryawan())
                    <a href="{{ url('/karyawan/absensi') }}" class="block text-center py-2.5 bg-neutral-900 border border-neutral-700 text-white text-xs uppercase tracking-widest font-semibold">Absensi Kamera</a>
                @else
                    <a href="{{ url('/customer/dashboard') }}" class="block text-center py-2.5 bg-neutral-900 border border-neutral-700 text-white text-xs uppercase tracking-widest font-semibold">My Garage</a>
                @endif
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-center py-2 text-neutral-400 hover:text-red-400 text-xs uppercase tracking-widest">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-center py-2.5 border border-white text-white text-xs uppercase tracking-widest font-semibold">Portal Login</a>
            @endif
        </div>
    </div>

</header>
