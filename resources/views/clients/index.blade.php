@extends('layouts.app')

@section('meta_title', 'Mitra Pariwisata & Kerjasama — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Jaringan mitra resmi pariwisata Indonesia, maskapai penerbangan, balai taman nasional, dan asosiasi perhotelan bersama Nusantara Tour Guide.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/20 text-accent text-xs font-semibold uppercase tracking-wider">
                <i class="fa-solid fa-handshake text-accent"></i>
                <span>Kolaborasi Pariwisata Berkelanjutan</span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Mitra Resmi Nusantara
            </h1>
            <p class="text-gray-200 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Bekerja sama erat dengan kementerian, maskapai penerbangan nasional, balai konservasi taman nasional, dan asosiasi perhotelan Indonesia.
            </p>
        </div>
    </section>

    <!-- Clients / Brand Partners Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <div class="eyebrow text-sage font-bold">Jaringan Ekosistem Wisata</div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                    Partner &amp; Kolaborasi Terpercaya
                </h2>
                <div class="w-12 h-0.5 bg-accent mx-auto mt-2"></div>
            </div>

            <!-- Grid of Logos -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @forelse($clients as $client)
                    <div class="tour-card p-6 h-36 flex flex-col items-center justify-center group text-center bg-white">
                        @if($client->logo)
                            <img src="{{ str_starts_with($client->logo, 'http') ? $client->logo : asset('storage/' . $client->logo) }}" 
                                 alt="{{ $client->name }}" 
                                 title="{{ $client->name }}"
                                 loading="lazy"
                                 class="max-h-12 max-w-full object-contain grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                        @endif
                        <div class="mt-2 text-[11px] font-bold uppercase tracking-wider text-gray-700 group-hover:text-primary transition-colors">
                            {{ $client->name }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-6 text-center py-12 text-gray-400 text-sm">
                        Daftar mitra pariwisata akan tampil di sini.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
