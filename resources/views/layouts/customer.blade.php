<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', 'Portal Traveler — Nusantara Tour Guide')</title>
    
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
                        'neutral-bg': '#F8FAF9',
                        'neutral-dark': '#0B1713',
                    },
                    letterSpacing: {
                        'widest2': '0.15em',
                        'widest3': '0.25em',
                    }
                }
            }
        }
    </script>

    <!-- Compiled CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-[#F8FAF9] text-[#1A2E26] font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Top Clean Navbar -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-30 shadow-soft">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-lg tracking-wider uppercase text-primary font-sans">
                    <div class="w-7 h-7 rounded-lg bg-accent flex items-center justify-center text-primary-dark">
                        <i class="fa-solid fa-compass text-xs"></i>
                    </div>
                    <span>NUSANTARA <span class="text-xs text-sage font-bold">TRAVELER</span></span>
                </a>
                <nav class="hidden md:flex items-center space-x-6 text-xs uppercase tracking-wider font-bold">
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-primary transition-colors">&larr; Beranda</a>
                    <a href="{{ route('customer.profile', ['tab' => 'identity']) }}" class="hover:text-primary transition-colors {{ request()->get('tab') === 'identity' ? 'text-primary border-b-2 border-primary pb-1' : 'text-gray-500' }}">👤 Profil Tamu</a>
                    <a href="{{ route('customer.profile', ['tab' => 'orders']) }}" class="hover:text-primary transition-colors {{ request()->get('tab') === 'orders' ? 'text-primary border-b-2 border-primary pb-1' : 'text-gray-500' }}">🎫 Riwayat Trip &amp; Pass</a>
                    <a href="{{ route('customer.profile', ['tab' => 'warranty']) }}" class="hover:text-primary transition-colors {{ request()->get('tab') === 'warranty' ? 'text-primary border-b-2 border-primary pb-1' : 'text-gray-500' }}">🛡️ Voucher &amp; Asuransi</a>
                    <a href="{{ route('customer.vehicles.index') }}" class="hover:text-primary transition-colors {{ request()->routeIs('customer.vehicles*') ? 'text-primary border-b-2 border-primary pb-1' : 'text-gray-500' }}">✈️ Preferensi Wisata</a>
                    <a href="{{ url('/booking') }}" class="text-accent-dark hover:text-primary font-bold">+ Booking Tur Baru</a>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-bold text-primary">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-sage font-medium">{{ auth()->user()->email }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs uppercase tracking-wider font-bold px-3 py-1.5 rounded-lg border border-gray-300 hover:border-primary hover:text-primary transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    @if(auth()->check() && (auth()->user()->isDemo() || str_contains(auth()->user()->email, 'demo')))
        <div class="bg-amber-500 text-black px-6 py-2 text-xs font-medium border-b border-amber-600 flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2 max-w-7xl mx-auto w-full">
                <span class="inline-block w-2 h-2 rounded-full bg-black animate-pulse"></span>
                <span><strong>Mode Demo Aktif:</strong> Anda login dengan akun demo traveler. Seluruh fitur pemesanan tur, cek invoice, dan riwayat perjalanan aktif penuh.</span>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-10">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 rounded-xl border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-sm">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 rounded-xl border border-rose-200 text-rose-800 text-xs flex items-center justify-between shadow-sm">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Portal Footer -->
    <footer class="bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-2">
            <div>Portal Traveler &bull; {{ \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') }}</div>
            <div class="text-[11px] text-gray-400">Pemandu Wisata Resmi Berlisensi HPI Indonesia</div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
