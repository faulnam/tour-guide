@extends('layouts.app')

@section('meta_title', 'Paket Pemandu Wisata & Ekspedisi — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Pilihan paket pemandu wisata berlisensi resmi HPI: Privat Tour Bali & Jogja, Island Hopping Labuan Bajo & Raja Ampat, Volcano Trekking Bromo-Ijen, dan Ecotourism Safari.')

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                Paket Pemandu &amp; Ekspedisi
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm max-w-lg mx-auto leading-relaxed">
                Dari tur privat budaya hingga penjelajahan alam liar dan bahari, kami menyediakan pemandu berlisensi resmi HPI dengan standar terbaik.
            </p>
        </div>
    </section>

    <!-- Services Overview & Categories List -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-20">
            
            @foreach($services as $index => $service)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center pt-12 {{ $index > 0 ? 'border-t border-gray-100' : '' }}">
                    
                    <!-- Left Column: Service Title & Intro -->
                    <div class="lg:col-span-5 space-y-5">
                        <div class="text-4xl font-extrabold text-sage/20">0{{ $index + 1 }}</div>
                        <div class="eyebrow text-sage font-bold">{{ $service->formatted_price }} • {{ $service->estimated_duration ?? '1 Hari' }}</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                            {{ $service->title }}
                        </h2>
                        @if($service->excerpt)
                            <p class="text-gray-600 text-xs md:text-sm leading-relaxed">
                                {{ $service->excerpt }}
                            </p>
                        @endif

                        @if(!empty($service->features))
                            <ul class="space-y-2 text-xs text-gray-700">
                                @foreach(array_slice($service->features, 0, 4) as $feat)
                                    <li class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-check text-emerald-600 text-xs"></i>
                                        <span>{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="pt-4 flex flex-wrap items-center gap-3">
                            <a href="{{ url('/services/' . $service->slug) }}" class="btn-primary flex items-center gap-2">
                                <span>Rincian Paket</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <a href="{{ url('/booking?service_id=' . $service->id) }}" class="px-6 py-3 rounded-lg border border-gray-300 hover:border-primary text-primary hover:bg-primary hover:text-white font-bold text-xs uppercase tracking-wider transition-all">
                                Booking Paket Ini
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Image Preview -->
                    <div class="lg:col-span-7">
                        <div class="relative aspect-[16/10] bg-neutral-900 overflow-hidden rounded-2xl border border-gray-100 shadow-soft">
                            <img src="{{ $service->image ? (str_starts_with($service->image, 'http') ? $service->image : asset('storage/' . $service->image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1000&auto=format&fit=crop' }}" 
                                 alt="{{ $service->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
