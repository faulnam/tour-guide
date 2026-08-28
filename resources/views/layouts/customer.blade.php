<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', 'Customer Portal & Garage — Metrix Garage')</title>
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'neutral-bg': '#f8f9fa',
                        'neutral-body': '#6b7280',
                        'accent': '#b08d57',
                    },
                    letterSpacing: {
                        'widest2': '0.15em',
                        'widest3': '0.25em',
                    }
                }
            }
        }
    </script>

    <!-- Base Metrix CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-neutral-bg text-black font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Top Clean Navbar -->
    <header class="bg-white border-b border-neutral-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <a href="{{ route('customer.dashboard') }}" class="font-bold text-xl tracking-widest3 uppercase text-black font-sans">
                    METRIX <span class="text-xs text-neutral-400 font-normal">CUSTOMER</span>
                </a>
                <nav class="hidden md:flex items-center space-x-6 text-xs uppercase tracking-wider font-semibold">
                    <a href="{{ route('customer.dashboard') }}" class="hover:text-accent transition-colors {{ request()->routeIs('customer.dashboard') ? 'text-black border-b-2 border-black pb-1' : 'text-neutral-500' }}">Overview</a>
                    <a href="{{ route('customer.bookings.index') }}" class="hover:text-accent transition-colors {{ request()->routeIs('customer.bookings*') ? 'text-black border-b-2 border-black pb-1' : 'text-neutral-500' }}">Riwayat Booking</a>
                    <a href="{{ route('customer.vehicles.index') }}" class="hover:text-accent transition-colors {{ request()->routeIs('customer.vehicles*') ? 'text-black border-b-2 border-black pb-1' : 'text-neutral-500' }}">Garasi Saya</a>
                    <a href="{{ url('/booking') }}" class="text-accent hover:underline font-bold">+ Booking Baru</a>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-bold text-black">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-neutral-400">{{ auth()->user()->email }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs uppercase tracking-wider font-semibold px-3 py-1.5 border border-neutral-300 hover:border-black transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-10">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 text-xs flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-800">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-neutral-200 py-6 text-center text-xs text-neutral-400">
        <p>&copy; {{ date('Y') }} Metrix Garage Customer Portal. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>
