<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', 'Portal Traveler — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230F2F24'/><path d='M30 70 L50 25 L70 70 Z' fill='none' stroke='%23C5A880' stroke-width='8'/><circle cx='50' cy='52' r='8' fill='%23C5A880'/></svg>">

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
                        display: ["'Plus Jakarta Sans'", 'sans-serif'],
                    },
                    colors: {
                        primary: '#0F2F24',
                        'primary-dark': '#0A1E17',
                        secondary: '#1B4D3E',
                        accent: '#C5A880',
                        'accent-dark': '#9E8159',
                        'accent-light': '#F5EFE6',
                        sage: '#407B64',
                        'sage-light': '#E9F2EE',
                        'neutral-bg': '#F8FAF9',
                        'neutral-dark': '#0B1713',
                        'neutral-body': '#4A5568',
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(15, 47, 36, 0.06)',
                        'elevated': '0 12px 30px -4px rgba(15, 47, 36, 0.12)',
                    },
                    letterSpacing: {
                        'widest2': '0.12em',
                        'widest3': '0.2em',
                    }
                }
            }
        }
    </script>

    <!-- Compiled CSS & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-[#F8FAF9] text-[#1A2E26] font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-accent selection:text-neutral-dark">

    <!-- Universal Site Header Navbar -->
    @include('partials.header')

    @if(auth()->check() && (auth()->user()->isDemo() || str_contains(auth()->user()->email, 'demo')))
        <div class="bg-amber-500 text-black px-6 py-2 text-xs font-medium border-b border-amber-600 shadow-sm">
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
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 rounded-xl border border-rose-200 text-rose-800 text-xs flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Universal Site Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
