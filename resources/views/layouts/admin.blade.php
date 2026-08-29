<!DOCTYPE html>
<html lang="en" class="h-full bg-neutral-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Admin Panel') — Nusantara Tour Guide CMS</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ["'Plus Jakarta Sans'", 'Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0F2F24',
                        'primary-dark': '#0A1E17',
                        secondary: '#1B4D3E',
                        accent: '#C5A880',
                        'accent-dark': '#9E8159',
                        sage: '#407B64',
                        'sage-light': '#E9F2EE',
                    },
                    letterSpacing: {
                        'widest2': '0.15em',
                        'widest3': '0.25em',
                    }
                }
            }
        }
    </script>

    <!-- Quill Editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .ql-toolbar.ql-snow {
            background-color: #171717;
            border-color: #262626 !important;
        }
        .ql-container.ql-snow {
            background-color: #0a0a0a;
            border-color: #262626 !important;
            color: #e5e5e5;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            min-height: 200px;
        }
        .ql-stroke { stroke: #a3a3a3 !important; }
        .ql-fill { fill: #a3a3a3 !important; }
        .ql-picker-label { color: #a3a3a3 !important; }
        .ql-picker-options { background-color: #171717 !important; border-color: #262626 !important; color: #fff !important; }
    </style>
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-neutral-200 bg-neutral-950 flex flex-col" x-data="{ sidebarOpen: false }">

    <div class="flex h-full min-h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             x-cloak 
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/80 lg:hidden">
        </div>

        <!-- Sidebar Navigation Drawer -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-neutral-900 border-r border-neutral-800 flex flex-col justify-between transition-transform duration-300 lg:static lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Brand Logo -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-neutral-800">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-2 font-bold text-lg tracking-wider uppercase text-white font-sans">
                    <i class="fa-solid fa-compass text-accent"></i>
                    <span>NUSANTARA <span class="text-accent text-xs font-normal">ADMIN</span></span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-neutral-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 text-xs">
                
                <a href="{{ url('/admin/dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/dashboard') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-chart-pie w-4 text-center text-accent"></i>
                    <span>Dashboard Utama</span>
                </a>

                <!-- Tour & Booking Modules -->
                <div class="pt-4 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-bold">Operasional &amp; Reservasi</div>

                <a href="{{ route('admin.bookings.index') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/bookings*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-calendar-check w-4 text-center text-accent"></i>
                        <span>Reservasi Traveler</span>
                    </div>
                    @php $pendingB = \App\Models\Booking::where('status', 'pending')->count(); @endphp
                    @if($pendingB > 0)
                        <span class="bg-amber-500 text-black text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingB }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.attendances.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/attendances*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-camera w-4 text-center text-accent"></i>
                    <span>Absensi Kamera Pemandu</span>
                </a>

                <a href="{{ route('admin.employees.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/employees*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-id-badge w-4 text-center text-accent"></i>
                    <span>Pemandu Wisata (Guides)</span>
                </a>

                <!-- Content Management -->
                <div class="pt-4 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-bold">Katalog Wisata &amp; CMS</div>

                <a href="{{ url('/admin/services') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/services*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-map-location-dot w-4 text-center text-accent"></i>
                    <span>Paket &amp; Layanan Guide</span>
                </a>

                <a href="{{ url('/admin/projects') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/projects*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-images w-4 text-center text-accent"></i>
                    <span>Destinasi &amp; Ekspedisi</span>
                </a>

                <a href="{{ url('/admin/posts') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/posts*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-regular fa-newspaper w-4 text-center text-accent"></i>
                    <span>Travel Blog Posts</span>
                </a>

                <a href="{{ url('/admin/clients') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/clients*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-handshake w-4 text-center text-accent"></i>
                    <span>Mitra &amp; Maskapai</span>
                </a>

                <a href="{{ url('/admin/awards') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/awards*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-award w-4 text-center text-accent"></i>
                    <span>Sertifikasi &amp; Lisensi HPI</span>
                </a>

                <a href="{{ url('/admin/testimonials') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/testimonials*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-star w-4 text-center text-accent"></i>
                    <span>Ulasan Wisatawan</span>
                </a>

                <a href="{{ url('/admin/hero-slides') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/hero-slides*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-panorama w-4 text-center text-accent"></i>
                    <span>Hero Slideshow</span>
                </a>

                <!-- Settings & Inquiries -->
                <div class="pt-4 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-bold">Pengaturan &amp; Pesan</div>

                <a href="{{ url('/admin/settings') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/settings*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-sliders w-4 text-center text-accent"></i>
                    <span>Pengaturan Website</span>
                </a>

                <a href="{{ url('/admin/messages') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/messages*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-regular fa-envelope w-4 text-center text-accent"></i>
                        <span>Pesan Masuk (Inbox)</span>
                    </div>
                </a>

                <a href="{{ url('/admin/users') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/users*') ? 'bg-primary text-white font-semibold' : '' }}">
                    <i class="fa-solid fa-users-gear w-4 text-center text-accent"></i>
                    <span>Semua Akun &amp; Role</span>
                </a>

            </nav>

            <!-- User Info / Bottom Section -->
            <div class="p-4 border-t border-neutral-800 flex items-center justify-between text-xs">
                <div class="truncate">
                    <div class="font-medium text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-accent capitalize">{{ auth()->user()->role ?? 'super_admin' }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-1.5 text-neutral-400 hover:text-rose-400 transition-colors" title="Sign Out">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-neutral-950">
            
            <!-- Topbar Header -->
            <header class="h-16 bg-neutral-900 border-b border-neutral-800 flex items-center justify-between px-6 z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-neutral-400 hover:text-white p-2">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="text-sm font-semibold tracking-wider text-white uppercase">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4 text-xs">
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-700 text-neutral-300 hover:border-accent hover:text-white transition-colors text-[11px] uppercase tracking-wider">
                        <span>Lihat Website Live</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </header>

            @if(auth()->check() && (auth()->user()->isDemo() || str_contains(auth()->user()->email, 'demo')))
                <div class="bg-amber-950/80 border-b border-amber-600/50 text-amber-200 px-6 py-2 text-xs flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        <span><strong>Mode Demo Aktif:</strong> Anda login dengan akun demo administrator. Simulasi perubahan dan aksi kelola operasional tur aktif penuh.</span>
                    </div>
                </div>
            @endif

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                
                @if(session('success'))
                    <div class="mb-6 bg-emerald-950/60 border border-emerald-800 text-emerald-300 px-4 py-3 rounded-xl text-xs uppercase tracking-wider flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-rose-950/60 border border-rose-800 text-rose-300 px-4 py-3 rounded-xl text-xs uppercase tracking-wider flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

        </div>

    </div>

    @stack('scripts')
</body>
</html>
