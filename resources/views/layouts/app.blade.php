<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Primary Meta Tags -->
    <title>@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'Nusantara Tour Guide — Pemandu Wisata Resmi Berlisensi HPI Indonesia'))</title>
    <meta name="title" content="@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'Nusantara Tour Guide — Pemandu Wisata Resmi Berlisensi HPI Indonesia'))">
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Layanan pemandu wisata berlisensi resmi HPI & ekspedisi privat di destinasi terindah Indonesia: Bali, Raja Ampat, Labuan Bajo, Bromo, Yogyakarta, dan Tana Toraja.'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') }}">
    <meta property="og:title" content="@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'Nusantara Tour Guide'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Pemandu Wisata Resmi Berlisensi HPI & Ekspedisi Indonesia'))">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-cover.jpg'))">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'Nusantara Tour Guide'))">
    <meta name="twitter:description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Pemandu Wisata Resmi Berlisensi HPI & Ekspedisi Indonesia'))">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/og-cover.jpg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230F2F24'/><path d='M30 70 L50 25 L70 70 Z' fill='none' stroke='%23C5A880' stroke-width='8'/><circle cx='50' cy='52' r='8' fill='%23C5A880'/></svg>">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Swiper.js CSS (via CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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
                        'neutral-body': '#4B5563',
                        'neutral-dark': '#0B1713',
                    },
                    letterSpacing: {
                        'widest2': '0.15em',
                        'widest3': '0.25em',
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(15, 47, 36, 0.06), 0 2px 6px -1px rgba(15, 47, 36, 0.04)',
                        'elevated': '0 20px 25px -5px rgba(15, 47, 36, 0.08), 0 10px 10px -5px rgba(15, 47, 36, 0.04)',
                    }
                }
            }
        }
    </script>

    <!-- Compiled CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">

    <!-- Alpine.js (via CDN) -->
    <script defer src="https://unpkg.com/alpinejs@3.14.3/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-[#F8FAF9] text-[#1A2E26] font-sans antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen">
    
    <!-- Flash Messages / Notification Banner -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed bottom-6 right-6 z-50 bg-primary-dark text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 text-xs tracking-wider uppercase border border-sage/40 transition-all">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-neutral-400 hover:text-white ml-2 text-sm">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" 
             class="fixed bottom-6 right-6 z-50 bg-rose-900 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 text-xs tracking-wider uppercase border border-rose-700 transition-all">
            <svg class="w-4 h-4 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="text-rose-300 hover:text-white ml-2 text-sm">&times;</button>
        </div>
    @endif

    <!-- Global Header -->
    @include('partials.header')

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Footer -->
    @include('partials.footer')

    <!-- AI Indonesian Tour Guide Consultant Chatbot -->
    @include('partials.chatbot')

    <!-- Swiper.js JS (via CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
