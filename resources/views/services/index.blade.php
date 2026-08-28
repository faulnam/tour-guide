@extends('layouts.app')

@section('meta_title', 'Services & Modification Packages — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Garage'))
@section('meta_description', 'Layanan modifikasi performa tinggi: ECU Remap Dyno Run, Custom Motorcycle Builder, Widebody Kit, Cat Oven Spies Hecker, dan Air Suspension di Jakarta.')

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Performance Tuning &amp; Custom Fabrication</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Our Services
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Dari kalibrasi performa dyno run hingga fabrikasi kustom motor &amp; mobil, kami menyediakan layanan terpadu berstandar motorsport.
            </p>
        </div>
    </section>

    <!-- Services Overview & Categories List -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-20">
            
            @foreach($services as $index => $service)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start pt-12 {{ $index > 0 ? 'border-t border-neutral-200' : '' }}">
                    
                    <!-- Left Column: Service Title & Intro -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="text-3xl font-extrabold text-neutral-300">0{{ $index + 1 }}</div>
                        <div class="eyebrow text-accent font-semibold capitalize">{{ $service->vehicle_type }} • {{ $service->formatted_price }}</div>
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black uppercase font-sans">
                            {{ $service->title }}
                        </h2>
                        @if($service->excerpt)
                            <p class="text-neutral-body text-xs md:text-sm leading-relaxed">
                                {{ $service->excerpt }}
                            </p>
                        @endif

                        @if(!empty($service->features))
                            <ul class="space-y-2 text-xs text-neutral-700">
                                @foreach(array_slice($service->features, 0, 4) as $feat)
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 bg-black inline-block"></span>
                                        <span>{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="pt-4 flex flex-wrap items-center gap-3">
                            <a href="{{ url('/services/' . $service->slug) }}" class="btn-dark">
                                View Details &rarr;
                            </a>
                            <a href="{{ url('/booking?service_id=' . $service->id) }}" class="btn-outline-dark">
                                Book Package
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Image Preview -->
                    <div class="lg:col-span-7">
                        <div class="relative aspect-[16/10] bg-neutral-900 overflow-hidden border border-neutral-200 shadow-sm">
                            <img src="{{ $service->image ? (str_starts_with($service->image, 'http') ? $service->image : asset('storage/' . $service->image)) : 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1000&auto=format&fit=crop' }}" 
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
