@extends('layouts.app')

@section('meta_title', 'Destinasi Wisata & Ekspedisi — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Dokumentasi nyata ekspedisi wisata di seluruh Indonesia: Raja Ampat, Labuan Bajo Komodo, Gunung Bromo & Ijen, Bali, dan Tana Toraja.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/40 backdrop-blur-md border border-white/20 text-accent text-[11px] font-semibold uppercase tracking-wider">
                <i class="fa-solid fa-earth-asia text-accent text-xs"></i>
                <span>Galeri Perjalanan Nyata</span>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                Destinasi Wisata Nusantara
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm max-w-lg mx-auto leading-relaxed">
                Koleksi dokumentasi perjalanan eksklusif para traveler menjelajahi surga tersembunyi Indonesia bersama pemandu lokal berlisensi.
            </p>
        </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-100 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase">
                        Semua Ekspedisi &amp; Rute Wisata
                    </h2>
                    <p class="text-gray-500 text-xs mt-1">
                        Menampilkan {{ $projects->total() }} rute perjalanan aktif di Indonesia
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="pt-8 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
