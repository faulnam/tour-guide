<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0a0a0e]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal Karyawan') — Apex Garage</title>

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
        .glow-amber { box-shadow: 0 0 30px -5px rgba(245, 158, 11, 0.3); }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-[#0a0a0e] text-neutral-100 antialiased flex flex-col selection:bg-amber-600 selection:text-white" x-data="{ mobileMenu: false }">

    <!-- Top Navigation Bar -->
    <nav class="bg-[#121218] border-b border-neutral-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Role Badge -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('karyawan.dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-amber-700 text-black font-racing font-black flex items-center justify-center text-sm shadow-lg shadow-amber-600/30">
                            <i class="fa-solid fa-wrench"></i>
                        </div>
                        <div>
                            <span class="font-racing font-bold text-base text-white tracking-wider">APEX<span class="text-amber-500">STAFF</span></span>
                            <span class="text-[9px] uppercase tracking-widest text-neutral-400 block -mt-1 font-semibold">Portal Karyawan & Mekanik</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Links -->
                <div class="hidden md:flex items-center space-x-2 text-xs font-bold uppercase tracking-wider">
                    <a href="{{ route('karyawan.dashboard') }}" 
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('karyawan.dashboard*') ? 'bg-neutral-800 text-amber-400 border border-neutral-700' : 'text-neutral-300 hover:text-white hover:bg-neutral-800/50' }}">
                        <i class="fa-solid fa-gauge-high mr-1.5"></i> Dashboard
                    </a>

                    <a href="{{ route('karyawan.absensi') }}" 
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('karyawan.absensi*') ? 'bg-amber-600 text-black font-black shadow-lg shadow-amber-600/30' : 'text-amber-400 bg-amber-500/10 border border-amber-500/30 hover:bg-amber-500/20' }}">
                        <i class="fa-solid fa-camera mr-1.5"></i> Absensi Kamera
                    </a>

                    <a href="{{ route('karyawan.tasks.index') }}" 
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('karyawan.tasks*') ? 'bg-neutral-800 text-amber-400 border border-neutral-700' : 'text-neutral-300 hover:text-white hover:bg-neutral-800/50' }}">
                        <i class="fa-solid fa-screwdriver-wrench mr-1.5"></i> Tugas Modifikasi
                    </a>
                </div>

                <!-- User Profile & Logout -->
                <div class="hidden md:flex items-center gap-3">
                    <div class="text-right">
                        <div class="text-xs font-bold text-white">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-amber-400 font-semibold">{{ auth()->user()->specialty ?? 'Teknisi Workshop' }}</div>
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
            <a href="{{ route('karyawan.dashboard') }}" class="block py-2 text-neutral-200">Dashboard</a>
            <a href="{{ route('karyawan.absensi') }}" class="block py-2 text-amber-400">Absensi Kamera</a>
            <a href="{{ route('karyawan.tasks.index') }}" class="block py-2 text-neutral-200">Tugas Modifikasi</a>
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
        &copy; {{ date('Y') }} Apex Garage Karyawan System. Internal Use Only.
    </footer>

    @stack('scripts')
</body>
</html>
