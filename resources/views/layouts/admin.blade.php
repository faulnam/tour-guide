<!DOCTYPE html>
<html lang="en" class="h-full bg-neutral-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Admin Panel') — BENGKEL CMS</title>

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
                        'accent': '#b08d57',
                        'accent-dark': '#8c6d3b',
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
            font-family: 'Inter', sans-serif;
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
                <a href="{{ url('/admin/dashboard') }}" class="font-bold text-xl tracking-widest3 uppercase text-white font-sans">
                    BENGKEL <span class="text-accent text-xs font-normal">ADMIN</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-neutral-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 text-xs">
                
                <a href="{{ url('/admin/dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/dashboard') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>

                <!-- Bengkel & Booking Modules -->
                <div class="pt-4 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-semibold">Workshop &amp; Bookings</div>

                <a href="{{ route('admin.bookings.index') }}" 
                   class="flex items-center justify-between px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/bookings*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Customer Bookings</span>
                    </div>
                    @php $pendingB = \App\Models\Booking::where('status', 'pending')->count(); @endphp
                    @if($pendingB > 0)
                        <span class="bg-amber-500 text-black text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingB }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.attendances.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/attendances*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Absensi Kamera Karyawan</span>
                </a>

                <a href="{{ route('admin.employees.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/employees*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Karyawan &amp; Mekanik</span>
                </a>

                <!-- Core Management -->
                <div class="pt-4 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-semibold">Content Management</div>

                <a href="{{ url('/admin/services') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/services*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Services &amp; Packages</span>
                </a>

                <a href="{{ url('/admin/projects') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/projects*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Projects &amp; Dyno Runs</span>
                </a>

                <a href="{{ url('/admin/posts') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/posts*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span>Blog Posts</span>
                </a>

                <a href="{{ url('/admin/clients') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/clients*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Clients &amp; Partners</span>
                </a>

                <a href="{{ url('/admin/awards') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/awards*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <span>Awards &amp; Publications</span>
                </a>

                <a href="{{ url('/admin/testimonials') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/testimonials*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <span>Testimonials</span>
                </a>

                <a href="{{ url('/admin/hero-slides') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/hero-slides*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <span>Hero Slider</span>
                </a>

                <!-- Settings & Inquiries -->
                <div class="pt-4 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-semibold">Settings &amp; Communications</div>

                <a href="{{ url('/admin/settings') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/settings*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Site Settings (Stats &amp; Info)</span>
                </a>

                <a href="{{ url('/admin/messages') }}" 
                   class="flex items-center justify-between px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/messages*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Inbox Messages</span>
                    </div>
                </a>

                <a href="{{ url('/admin/users') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/users*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>All Users &amp; Roles</span>
                </a>

            </nav>

            <!-- User Info / Bottom Section -->
            <div class="p-4 border-t border-neutral-800 flex items-center justify-between text-xs">
                <div class="truncate">
                    <div class="font-medium text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-neutral-400 capitalize">{{ auth()->user()->role ?? 'super_admin' }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-1.5 text-neutral-400 hover:text-red-400 transition-colors" title="Sign Out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
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
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h1 class="text-sm font-semibold tracking-wider text-white uppercase">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4 text-xs">
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-neutral-700 text-neutral-300 hover:border-neutral-500 hover:text-white transition-colors text-[11px] uppercase tracking-wider">
                        <span>View Live Site</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </header>

            @if(auth()->check() && (auth()->user()->isDemo() || str_contains(auth()->user()->email, 'demo')))
                <div class="bg-amber-950/80 border-b border-amber-600/50 text-amber-200 px-6 py-2 text-xs flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        <span><strong>Mode Demo Aktif:</strong> Anda login dengan akun demo. Setiap data baru atau perubahan yang Anda lakukan akan otomatis dihapus/kembali semula setiap 5 menit.</span>
                    </div>
                    <span class="text-[10px] uppercase font-mono px-2 py-0.5 bg-amber-900/60 border border-amber-700/60 text-amber-300">Auto Reset 5 Min</span>
                </div>
            @endif

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                
                @if(session('success'))
                    <div class="mb-6 bg-emerald-950/60 border border-emerald-800 text-emerald-300 px-4 py-3 text-xs uppercase tracking-wider flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-950/60 border border-red-800 text-red-300 px-4 py-3 text-xs uppercase tracking-wider flex items-center justify-between">
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
