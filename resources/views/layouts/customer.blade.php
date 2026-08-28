<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0a0a0e]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Garasi & Booking Saya') — Apex Garage</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome & CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-racing { font-family: 'Orbitron', sans-serif; }
        .glow-red { box-shadow: 0 0 30px -5px rgba(239, 68, 68, 0.3); }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-[#0a0a0e] text-neutral-100 antialiased flex flex-col selection:bg-red-600 selection:text-white" x-data="{ mobileMenu: false }">

    <!-- Top Navigation Bar -->
    <nav class="bg-[#121218] border-b border-neutral-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-red-600 to-red-800 text-white font-racing font-black flex items-center justify-center text-sm shadow-lg shadow-red-600/30">
                            <i class="fa-solid fa-gauge-high"></i>
                        </div>
                        <div>
                            <span class="font-racing font-bold text-base text-white tracking-wider">APEX<span class="text-red-500">CLIENT</span></span>
                            <span class="text-[9px] uppercase tracking-widest text-neutral-400 block -mt-1 font-semibold">Garasi & Booking Portal</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Links -->
                <div class="hidden md:flex items-center space-x-2 text-xs font-bold uppercase tracking-wider">
                    <a href="{{ route('customer.dashboard') }}" 
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('customer.dashboard*') ? 'bg-neutral-800 text-red-400 border border-neutral-700' : 'text-neutral-300 hover:text-white hover:bg-neutral-800/50' }}">
                        <i class="fa-solid fa-house mr-1.5"></i> Dashboard
                    </a>

                    <a href="{{ route('customer.bookings.index') }}" 
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('customer.bookings*') ? 'bg-neutral-800 text-red-400 border border-neutral-700' : 'text-neutral-300 hover:text-white hover:bg-neutral-800/50' }}">
                        <i class="fa-solid fa-clock-rotate-left mr-1.5"></i> Riwayat Booking
                    </a>

                    <a href="{{ route('customer.vehicles.index') }}" 
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('customer.vehicles*') ? 'bg-neutral-800 text-red-400 border border-neutral-700' : 'text-neutral-300 hover:text-white hover:bg-neutral-800/50' }}">
                        <i class="fa-solid fa-warehouse mr-1.5"></i> Garasi Saya
                    </a>

                    <a href="{{ url('/booking') }}" 
                       class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl shadow-lg shadow-red-600/30 transition-all flex items-center gap-1.5 font-bold">
                        <i class="fa-solid fa-plus"></i>
                        <span>Booking Baru</span>
                    </a>
                </div>

                <!-- Profile & Public Site -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ url('/') }}" class="text-xs text-neutral-400 hover:text-white flex items-center gap-1.5 px-3 py-1.5 bg-neutral-900 border border-neutral-800 rounded-xl">
                        <i class="fa-solid fa-globe"></i> Website
                    </a>

                    <div class="text-right">
                        <div class="text-xs font-bold text-white">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-red-400 font-semibold uppercase">Customer VIP</div>
                    </div>

                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 rounded-xl bg-neutral-900 border border-neutral-800 text-neutral-400 hover:text-red-400 transition-colors" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- Mobile Hamburger -->
                <div class="md:hidden">
                    <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-lg bg-neutral-900 border border-neutral-800 text-neutral-300">
                        <i class="fa-solid" :class="mobileMenu ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileMenu" x-cloak class="md:hidden bg-[#121218] border-b border-neutral-800 px-4 py-4 space-y-2 text-xs font-bold uppercase">
            <a href="{{ route('customer.dashboard') }}" class="block py-2 text-neutral-200">Dashboard</a>
            <a href="{{ route('customer.bookings.index') }}" class="block py-2 text-neutral-200">Riwayat Booking</a>
            <a href="{{ route('customer.vehicles.index') }}" class="block py-2 text-neutral-200">Garasi Saya</a>
            <a href="{{ url('/booking') }}" class="block py-2 text-red-400 font-bold">+ Buat Booking Baru</a>
            <form action="{{ url('/logout') }}" method="POST" class="pt-2 border-t border-neutral-800">
                @csrf
                <button type="submit" class="text-red-400 block py-1">Keluar</button>
            </form>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-500/15 border border-emerald-500/40 text-emerald-400 px-4 py-3 rounded-2xl text-xs flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/15 border border-red-500/40 text-red-400 px-4 py-3 rounded-2xl text-xs flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <footer class="bg-[#0c0c10] border-t border-neutral-800 py-4 text-center text-xs text-neutral-500">
        &copy; {{ date('Y') }} Apex Garage Customer Portal. All rights reserved.
    </footer>

    @stack('scripts')
</body>
</html>
