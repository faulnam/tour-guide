@extends('layouts.app')

@section('meta_title', \App\Models\SiteSetting::get('site_title', 'Nusantara Tour Guide — Pemandu Wisata Resmi Berlisensi HPI Indonesia'))
@section('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Pemandu wisata terpercaya dan berlisensi resmi HPI di seluruh Indonesia.'))

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-primary-dark text-white min-h-[70vh] flex items-center justify-center pt-24 pb-16 px-6">
        <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1920&auto=format&fit=crop');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-primary-dark via-primary-dark/50 to-transparent"></div>

        <div class="relative z-10 max-w-4xl mx-auto text-center space-y-4">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-snug uppercase font-sans max-w-3xl mx-auto">
                {{ \App\Models\PageContent::get('home_hero_title', 'Jelajahi Keajaiban Nusantara Bersama Pemandu Resmi') }}
            </h1>
            <p class="text-gray-200 max-w-xl mx-auto text-xs sm:text-sm leading-relaxed">
                {{ \App\Models\PageContent::get('home_hero_subtitle', 'Layanan pemandu wisata privat & ekspedisi alam terbaik di seluruh Indonesia.') }}
            </p>
            <div class="pt-3 flex items-center justify-center gap-4">
                <a href="{{ url('/booking') }}" class="px-6 py-2.5 rounded-lg bg-accent hover:bg-accent-dark text-primary-dark hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-xs"></i>
                    <span>Booking Pemandu Sekarang &rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Bar (Animated Count-Up) -->
    <div class="border-b border-gray-100 bg-[#F8FAF9] py-12 px-6"
         x-data="{
             started: false,
             c1: 0, c2: 0, c3: 0, c4: '0.0',
             init() {
                 let observer = new IntersectionObserver((entries) => {
                     if (entries[0].isIntersecting && !this.started) {
                         this.runCounter();
                         observer.disconnect();
                     }
                 }, { threshold: 0.25 });
                 observer.observe(this.$el);
             },
             runCounter() {
                 this.started = true;
                 const duration = 2200;
                 const start = performance.now();
                 const tick = (now) => {
                     const t = Math.min((now - start) / duration, 1);
                     const ease = 1 - Math.pow(1 - t, 4);
                     this.c1 = Math.floor(ease * 2850);
                     this.c2 = Math.floor(ease * 120);
                     this.c3 = Math.floor(ease * 34);
                     this.c4 = (ease * 99.8).toFixed(1);
                     if (t < 1) requestAnimationFrame(tick);
                     else { this.c1 = 2850; this.c2 = 120; this.c3 = 34; this.c4 = '99.8'; }
                 };
                 requestAnimationFrame(tick);
             }
         }">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="stat-number text-primary"><span x-text="Number(c1).toLocaleString('id-ID')">0</span>+</div>
                <div class="eyebrow text-gray-500 mt-2">Wisatawan Dipandu</div>
            </div>
            <div>
                <div class="stat-number text-primary"><span x-text="Number(c2).toLocaleString('id-ID')">0</span>+</div>
                <div class="eyebrow text-gray-500 mt-2">Pemandu Berlisensi HPI</div>
            </div>
            <div>
                <div class="stat-number text-primary"><span x-text="c3">0</span></div>
                <div class="eyebrow text-gray-500 mt-2">Provinsi Indonesia</div>
            </div>
            <div>
                <div class="stat-number text-primary"><span x-text="c4">0.0</span>%</div>
                <div class="eyebrow text-gray-500 mt-2">Tingkat Kepuasan</div>
            </div>
        </div>
    </div>
@endsection
