<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-[#09090b]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Primary Meta Tags -->
    <title>@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'Apex Garage — Workshop & Bengkel Modifikasi Motor & Mobil Terkemuka'))</title>
    <meta name="title" content="@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'Apex Garage — Bengkel Modifikasi Motor & Mobil'))">
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Bengkel spesialis modifikasi performa tinggi mobil dan motor, dyno tuning ECU remap, custom bodykit, cat oven, air suspension di Jakarta.'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ \App\Models\SiteSetting::get('company_name', 'Apex Garage') }}">
    <meta property="og:title" content="@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'Apex Garage'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Bengkel Modifikasi Motor & Mobil Terkemuka'))">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-bengkel.jpg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%23ef4444'/><path d='M30 70 L50 25 L70 70 L55 70 L50 50 L45 70 Z' fill='%23fff'/></svg>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Compiled CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-racing { font-family: 'Orbitron', sans-serif; }
        .glow-red { box-shadow: 0 0 30px -5px rgba(239, 68, 68, 0.4); }
        .glow-amber { box-shadow: 0 0 30px -5px rgba(245, 158, 11, 0.4); }
        .glow-cyan { box-shadow: 0 0 30px -5px rgba(6, 182, 212, 0.4); }
        .carbon-texture {
            background-color: #0b0b0f;
            background-image: radial-gradient(#1e1e28 0.75px, transparent 0.75px), radial-gradient(#1e1e28 0.75px, #0b0b0f 0.75px);
            background-size: 16px 16px;
            background-position: 0 0, 8px 8px;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#09090b] text-neutral-100 font-sans antialiased selection:bg-red-600 selection:text-white flex flex-col min-h-screen">
    
    <!-- Flash Messages / Notification Banner -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" 
             class="fixed bottom-6 right-6 z-50 bg-[#121218]/95 backdrop-blur-md text-white px-5 py-4 rounded-xl shadow-2xl flex items-center gap-3 text-xs border border-emerald-500/40 glow-cyan transition-all">
            <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <div class="font-bold text-emerald-400">Berhasil!</div>
                <div class="text-neutral-300 text-[11px]">{{ session('success') }}</div>
            </div>
            <button @click="show = false" class="text-neutral-500 hover:text-white ml-3 text-sm">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" 
             class="fixed bottom-6 right-6 z-50 bg-[#121218]/95 backdrop-blur-md text-white px-5 py-4 rounded-xl shadow-2xl flex items-center gap-3 text-xs border border-red-500/40 glow-red transition-all">
            <div class="w-7 h-7 rounded-lg bg-red-500/20 text-red-400 flex items-center justify-center font-bold">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <div class="font-bold text-red-400">Perhatian</div>
                <div class="text-neutral-300 text-[11px]">{{ session('error') }}</div>
            </div>
            <button @click="show = false" class="text-neutral-500 hover:text-white ml-3 text-sm">&times;</button>
        </div>
    @endif

    <!-- Global Header -->
    @include('partials.header')

    <!-- Main Content Area -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Global Footer -->
    @include('partials.footer')

    <!-- AI Tuning Consultant Chatbot -->
    @include('partials.chatbot')

    <!-- Swiper.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
