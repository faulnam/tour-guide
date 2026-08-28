<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-neutral-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') — Apex Garage CMS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Quill Rich Text Editor CSS (via CDN) -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <!-- Compiled CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-racing { font-family: 'Orbitron', sans-serif; }
        .glow-red { box-shadow: 0 0 25px -5px rgba(239, 68, 68, 0.3); }
    </style>

    @stack('styles')
</head>
<body class="h-full font-sans bg-neutral-950 text-neutral-100 antialiased" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black/80 lg:hidden" x-cloak></div>

    <div class="flex h-full">
        
        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0f0f14] border-r border-neutral-800 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto">
            
            <!-- Logo / Brand Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-neutral-800">
                <a href="{{ url('/admin') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-gradient-to-br from-red-600 to-red-800 text-white font-racing font-black flex items-center justify-center text-xs rounded-xl shadow-lg shadow-red-600/30">
                        <i class="fa-solid fa-gauge-high"></i>
                    </div>
                    <div>
                        <span class="font-racing font-extrabold text-sm text-white tracking-wider">APEX<span class="text-red-500">CMS</span></span>
                        <span class="text-[8px] uppercase tracking-widest text-neutral-400 block -mt-0.5">Workshop System</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-neutral-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto text-xs font-semibold">
                
                <div class="px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-bold">Workshop Operations</div>
                
                <a href="{{ url('/admin') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line text-sm w-4 text-center"></i>
                    <span>Dashboard Bengkel</span>
                </a>

                <a href="{{ url('/admin/bookings') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/bookings*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-car-side text-sm w-4 text-center"></i>
                        <span>Kelola Booking & Antrean</span>
                    </div>
                    @php $pendingCount = \App\Models\Booking::where('status', 'pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>

                <a href="{{ url('/admin/attendances') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/attendances*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-camera text-sm w-4 text-center text-amber-400"></i>
                    <span>Rekap Absensi Kamera</span>
                </a>

                <a href="{{ url('/admin/employees') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/employees*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-wrench text-sm w-4 text-center"></i>
                    <span>Karyawan & Mekanik</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-bold">Katalog & Portofolio</div>

                <a href="{{ url('/admin/services') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/services*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-spray-can-sparkles text-sm w-4 text-center"></i>
                    <span>Layanan Modifikasi</span>
                </a>

                <a href="{{ url('/admin/projects') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/projects*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-fire text-sm w-4 text-center"></i>
                    <span>Portofolio & Dyno Builds</span>
                </a>

                <a href="{{ url('/admin/clients') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/clients*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-handshake text-sm w-4 text-center"></i>
                    <span>Partner Brand & Parts</span>
                </a>

                <a href="{{ url('/admin/awards') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/awards*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-trophy text-sm w-4 text-center"></i>
                    <span>Penghargaan & Kontes</span>
                </a>

                <a href="{{ url('/admin/blog-posts') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/blog*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-newspaper text-sm w-4 text-center"></i>
                    <span>Blog Otomotif</span>
                </a>

                <a href="{{ url('/admin/hero-slides') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/hero-slides*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-images text-sm w-4 text-center"></i>
                    <span>Hero Slides</span>
                </a>

                <a href="{{ url('/admin/testimonials') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/testimonials*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-comment-dots text-sm w-4 text-center"></i>
                    <span>Testimoni Customer</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-bold">Sistem & Konfigurasi</div>

                <a href="{{ url('/admin/settings') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/settings*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-gears text-sm w-4 text-center"></i>
                    <span>Pengaturan Workshop & Gateway</span>
                </a>

                <a href="{{ url('/admin/page-contents') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/page-contents*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-file-lines text-sm w-4 text-center"></i>
                    <span>Copywriting Halaman</span>
                </a>

                <a href="{{ url('/admin/messages') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/messages*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-inbox text-sm w-4 text-center"></i>
                        <span>Pesan Masuk</span>
                    </div>
                    @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>

                <a href="{{ url('/admin/users') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/users*') ? 'bg-red-600/15 text-red-400 border border-red-500/30 font-bold' : 'text-neutral-300 hover:bg-neutral-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-users text-sm w-4 text-center"></i>
                    <span>Kelola Pengguna (3 Role)</span>
                </a>

            </nav>

            <!-- User Info & Logout -->
            <div class="p-4 border-t border-neutral-800 flex items-center justify-between text-xs">
                <div class="truncate">
                    <div class="font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-red-400 capitalize font-mono">{{ auth()->user()->role ?? 'super_admin' }}</div>
                </div>
                <form action="{{ url('/admin/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2 text-neutral-400 hover:text-red-400 transition-colors" title="Sign Out">
                        <i class="fa-solid fa-right-from-bracket text-sm"></i>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-neutral-950">
            
            <!-- Top Bar -->
            <header class="h-16 bg-[#0f0f14] border-b border-neutral-800 flex items-center justify-between px-6">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-neutral-400 hover:text-white">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <span class="font-bold text-sm text-white">@yield('title', 'Admin Panel')</span>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" target="_blank" class="px-3 py-1.5 bg-neutral-900 hover:bg-neutral-800 text-neutral-300 hover:text-white text-xs font-semibold rounded-xl border border-neutral-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        <span>Lihat Website</span>
                    </a>
                </div>
            </header>

            <!-- Page Body Content -->
            <main class="flex-1 overflow-y-auto p-6 sm:p-8">
                
                @if(session('success'))
                    <div class="mb-6 bg-emerald-500/15 border border-emerald-500/40 text-emerald-400 px-4 py-3 rounded-2xl text-xs flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-500/15 border border-red-500/40 text-red-400 px-4 py-3 rounded-2xl text-xs flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')

            </main>

        </div>

    </div>

    <!-- Quill Rich Text JS -->
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    @stack('scripts')
</body>
</html>
