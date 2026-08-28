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
            'bg-white/95 backdrop-blur-md text-black shadow-sm border-b border-neutral-200 py-2.5': scrolled || {{ $isLightPage ? 'true' : 'false' }},
            'bg-gradient-to-b from-black/85 via-black/35 to-transparent text-white py-3.5': !scrolled && !{{ $isLightPage ? 'true' : 'false' }}
        }"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
    
    <div class="max-w-7xl mx-auto px-5 md:px-10 flex items-center justify-between">
        
        <!-- Brand / Logo -->
        <a href="{{ url('/') }}" class="group flex items-center space-x-2.5 shrink-0 transition-opacity hover:opacity-85">
            <span class="font-extrabold text-xl tracking-widest3 uppercase font-sans"
                  :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) ? 'text-black' : 'text-white'">
                {{ \App\Models\SiteSetting::get('company_name', 'BENGKEL') }}
            </span>
        </a>

        <!-- Desktop Navigation Menu (Consistent Across All Pages) -->
        <nav class="hidden lg:flex items-center space-x-4 xl:space-x-6 text-[11px] uppercase tracking-wider font-medium">
            
            <!-- Home -->
            <a href="{{ url('/') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('/') ? 'text-accent font-bold' : '' }}">
                Home
            </a>

            <!-- About Us -->
            <a href="{{ url('/about-us') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('about-us*') ? 'text-accent font-bold' : '' }}">
                About Us
            </a>

            <!-- Services Dropdown (Hierarchical Menu with Sub-categories) -->
            <div class="relative" 
                 @mouseenter="servicesDropdown = true" 
                 @mouseleave="servicesDropdown = false">
                
                <a href="{{ url('/services') }}" 
                   class="inline-flex items-center space-x-1 transition-colors duration-200 hover:text-accent py-1.5 {{ request()->is('services*') ? 'text-accent font-bold' : '' }}">
                    <span>Services</span>
                    <svg class="w-3 h-3 transition-transform duration-200" 
                         :class="servicesDropdown ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
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
                     class="absolute top-full left-0 mt-0.5 w-64 bg-white text-black shadow-2xl border border-neutral-200 py-2 z-50">
                    
                    <a href="{{ url('/services') }}" 
                       class="block px-4 py-2.5 text-[10px] uppercase tracking-widest font-bold text-black hover:bg-neutral-100 hover:text-accent transition-colors border-b border-neutral-100 mb-1">
                        All Modification Packages &rarr;
                    </a>

                    @if(isset($navServices) && $navServices->count())
                        @foreach($navServices as $parentService)
                            @if($parentService->children->count())
                                <div class="relative group/sub" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                    <a href="{{ url('/services/' . $parentService->slug) }}" 
                                       class="flex items-center justify-between px-4 py-2 text-[11px] uppercase tracking-wider text-gray-800 hover:bg-neutral-50 hover:text-accent transition-colors">
                                        <span>{{ $parentService->title }}</span>
                                        <svg class="w-2.5 h-2.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>

                                    <div x-show="subOpen" 
                                         x-transition
                                         x-cloak
                                         class="absolute left-full top-0 w-60 bg-white text-black shadow-2xl border border-neutral-200 py-2">
                                        @foreach($parentService->children as $childService)
                                            <a href="{{ url('/services/' . $parentService->slug . '/' . $childService->slug) }}" 
                                               class="block px-4 py-2 text-[11px] uppercase tracking-wider text-gray-700 hover:bg-neutral-50 hover:text-accent transition-colors">
                                                {{ $childService->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ url('/services/' . $parentService->slug) }}" 
                                   class="block px-4 py-2 text-[11px] uppercase tracking-wider text-gray-800 hover:bg-neutral-50 hover:text-accent transition-colors">
                                    {{ $parentService->title }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Portfolio -->
            <a href="{{ url('/portfolio') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('portfolio*') ? 'text-accent font-bold' : '' }}">
                Portfolio
            </a>

            <!-- Awards -->
            <a href="{{ url('/awards-publications') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('awards-publications*') || request()->is('awards*') ? 'text-accent font-bold' : '' }}">
                Awards
            </a>

            <!-- Partners -->
            <a href="{{ url('/clients') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('clients*') ? 'text-accent font-bold' : '' }}">
                Partners
            </a>

            <!-- Booking Online -->
            <a href="{{ url('/booking') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('booking*') ? 'text-accent font-bold' : '' }}">
                Booking
            </a>

            <!-- Blog -->
            <a href="{{ url('/our-blog') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('our-blog*') || request()->is('blog*') ? 'text-accent font-bold' : '' }}">
                Blog
            </a>

            <!-- Contact -->
            <a href="{{ url('/contact-us') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('contact-us*') ? 'text-accent font-bold' : '' }}">
                Contact
            </a>

        </nav>

        <!-- Right Side: User Portal / Login Button -->
        <div class="hidden lg:flex items-center space-x-3 shrink-0">
            @if(auth()->check())
                @php $user = auth()->user(); @endphp
                <div class="flex items-center space-x-2.5 text-xs">
                    <span class="text-[11px] uppercase tracking-wider font-semibold"
                          :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) ? 'text-neutral-700' : 'text-neutral-200'">
                        {{ $user->name }}
                    </span>

                    @if($user->isAdmin())
                        <a href="{{ url('/admin') }}" 
                           class="px-3 py-1.5 border transition-all text-[10px] uppercase tracking-wider font-semibold"
                           :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) 
                               ? 'border-black bg-black text-white hover:bg-white hover:text-black' 
                               : 'border-white bg-white text-black hover:bg-transparent hover:text-white'">
                            Admin CMS
                        </a>
                    @elseif($user->isKaryawan())
                        <a href="{{ url('/karyawan/absensi') }}" 
                           class="px-3 py-1.5 border transition-all text-[10px] uppercase tracking-wider font-semibold"
                           :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) 
                               ? 'border-black bg-black text-white hover:bg-white hover:text-black' 
                               : 'border-white bg-white text-black hover:bg-transparent hover:text-white'">
                            Absensi &amp; Tasks
                        </a>
                    @else
                        <a href="{{ url('/customer/profile') }}" 
                           class="px-3 py-1.5 border transition-all text-[10px] uppercase tracking-wider font-semibold"
                           :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) 
                               ? 'border-black bg-black text-white hover:bg-white hover:text-black' 
                               : 'border-white bg-white text-black hover:bg-transparent hover:text-white'">
                            Garasi Saya
                        </a>
                    @endif

                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="text-xs transition-colors p-1" 
                                :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) ? 'text-neutral-400 hover:text-red-500' : 'text-neutral-400 hover:text-red-400'"
                                title="Sign Out">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   class="px-3.5 py-1.5 border transition-all text-[10px] uppercase tracking-wider font-semibold"
                   :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) 
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
                    class="p-1.5 transition-colors focus:outline-none"
                    :class="(scrolled || {{ $isLightPage ? 'true' : 'false' }}) ? 'text-black' : 'text-white'"
                    aria-label="Toggle Navigation Menu">
                <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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
         class="lg:hidden bg-black text-white px-6 py-6 border-t border-neutral-800 space-y-3 max-h-[85vh] overflow-y-auto">
        
        <a href="{{ url('/') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-1.5 border-b border-neutral-800 hover:text-accent {{ request()->is('/') ? 'text-accent font-bold' : '' }}">Home</a>
        <a href="{{ url('/about-us') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-1.5 border-b border-neutral-800 hover:text-accent {{ request()->is('about-us*') ? 'text-accent font-bold' : '' }}">About Us</a>

        <!-- Mobile Services Accordion -->
        <div x-data="{ mobileServicesOpen: false }" class="border-b border-neutral-800 py-1.5">
            <button @click="mobileServicesOpen = !mobileServicesOpen" class="w-full flex items-center justify-between text-xs uppercase tracking-wider hover:text-accent {{ request()->is('services*') ? 'text-accent font-bold' : '' }}">
                <span>Services</span>
                <svg class="w-3.5 h-3.5 transition-transform" :class="mobileServicesOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="mobileServicesOpen" x-cloak class="pl-4 pt-2 space-y-2">
                <a href="{{ url('/services') }}" @click="mobileMenuOpen = false" class="block text-[10px] uppercase tracking-wider text-neutral-400 hover:text-white font-bold">All Services &rarr;</a>
                @if(isset($navServices) && $navServices->count())
                    @foreach($navServices as $pService)
                        <div x-data="{ subOpen: false }" class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <a href="{{ url('/services/' . $pService->slug) }}" @click="mobileMenuOpen = false" class="text-[10px] uppercase tracking-wider text-neutral-300 hover:text-white font-medium">
                                    {{ $pService->title }}
                                </a>
                                @if($pService->children->count())
                                    <button @click="subOpen = !subOpen" class="p-1 text-neutral-400">
                                        <svg class="w-2.5 h-2.5 transition-transform" :class="subOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                @endif
                            </div>
                            @if($pService->children->count())
                                <div x-show="subOpen" x-cloak class="pl-3 space-y-1.5 border-l border-neutral-800">
                                    @foreach($pService->children as $cService)
                                        <a href="{{ url('/services/' . $pService->slug . '/' . $cService->slug) }}" @click="mobileMenuOpen = false" class="block text-[9px] uppercase tracking-wider text-neutral-400 hover:text-accent">
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

        <a href="{{ url('/portfolio') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-1.5 border-b border-neutral-800 hover:text-accent {{ request()->is('portfolio*') ? 'text-accent font-bold' : '' }}">Portfolio</a>
        <a href="{{ url('/awards-publications') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-1.5 border-b border-neutral-800 hover:text-accent {{ request()->is('awards*') ? 'text-accent font-bold' : '' }}">Awards</a>
        <a href="{{ url('/clients') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-1.5 border-b border-neutral-800 hover:text-accent {{ request()->is('clients*') ? 'text-accent font-bold' : '' }}">Partners</a>
        <a href="{{ url('/booking') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-1.5 border-b border-neutral-800 text-accent font-semibold">Booking Online</a>
        <a href="{{ url('/our-blog') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-1.5 border-b border-neutral-800 hover:text-accent {{ request()->is('our-blog*') || request()->is('blog*') ? 'text-accent font-bold' : '' }}">Blog</a>
        <a href="{{ url('/contact-us') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-wider py-1.5 border-b border-neutral-800 hover:text-accent {{ request()->is('contact-us*') ? 'text-accent font-bold' : '' }}">Contact Us</a>

        <div class="pt-3 border-t border-neutral-800 space-y-2">
            @if(auth()->check())
                <div class="text-[10px] text-neutral-400">Signed in as <strong class="text-white">{{ auth()->user()->name }}</strong></div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ url('/admin') }}" class="block text-center py-2 bg-neutral-900 border border-neutral-700 text-white text-xs uppercase tracking-wider font-semibold">Admin CMS</a>
                @elseif(auth()->user()->isKaryawan())
                    <a href="{{ url('/karyawan/absensi') }}" class="block text-center py-2 bg-neutral-900 border border-neutral-700 text-white text-xs uppercase tracking-wider font-semibold">Absensi &amp; Tasks</a>
                @else
                    <a href="{{ url('/customer/profile') }}" class="block text-center py-2 bg-neutral-900 border border-neutral-700 text-white text-xs uppercase tracking-wider font-semibold">Garasi Saya</a>
                @endif
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-center py-1.5 text-neutral-400 hover:text-red-400 text-xs uppercase tracking-wider">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-center py-2 border border-white text-white text-xs uppercase tracking-wider font-semibold">Portal Login</a>
            @endif
        </div>
    </div>

</header>
