@extends('layouts.app')

@section('meta_title', $service->title . ' — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', $service->excerpt ?: 'Explore tuning projects and modification packages for ' . $service->title)

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $service->image ? (str_starts_with($service->image, 'http') ? $service->image : asset('storage/' . $service->image)) : 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">
                <a href="{{ url('/services') }}" class="hover:underline">Services</a> &bull; {{ $service->title }}
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $service->title }}
            </h1>
            @if($service->excerpt)
                <p class="text-neutral-300 text-xs md:text-sm max-w-2xl mx-auto leading-relaxed">
                    {{ $service->excerpt }}
                </p>
            @endif
        </div>
    </section>

    <!-- Service Details & Booking Action -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <div class="lg:col-span-8 space-y-6">
                    <h2 class="text-2xl font-bold uppercase tracking-tight text-black">Package Overview</h2>
                    <div class="prose max-w-none text-neutral-700 text-sm leading-relaxed space-y-4">
                        {!! $service->description !!}
                    </div>

                    @if(!empty($service->features))
                        <div class="pt-6 border-t border-neutral-200">
                            <h3 class="text-xs uppercase tracking-widest2 font-bold text-black mb-4">Fitur &amp; Keunggulan Layanan</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-neutral-800">
                                @foreach($service->features as $feat)
                                    <div class="p-3 bg-neutral-bg border border-neutral-200 flex items-center gap-2.5">
                                        <span class="w-1.5 h-1.5 bg-black inline-block"></span>
                                        <span>{{ $feat }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-4 bg-neutral-bg border border-neutral-200 p-8 space-y-6">
                    <div class="space-y-1">
                        <div class="eyebrow text-neutral-400 text-[10px]">Starting From</div>
                        <div class="text-2xl font-bold text-black">{{ $service->formatted_price }}</div>
                    </div>

                    <div class="space-y-2 text-xs text-neutral-600 border-t border-neutral-200 pt-4">
                        <div class="flex justify-between"><span>Tipe Kendaraan:</span> <span class="font-bold text-black uppercase">{{ $service->vehicle_type }}</span></div>
                        <div class="flex justify-between"><span>Estimasi Durasi:</span> <span class="font-bold text-black">{{ $service->estimated_duration ?? 'Menyesuaikan' }}</span></div>
                        <div class="flex justify-between"><span>Garansi:</span> <span class="font-bold text-black">{{ $service->warranty ?? 'Garansi Resmi' }}</span></div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ url('/booking?service_id=' . $service->id) }}" class="btn-dark w-full text-center block">
                            Booking Layanan Ini &rarr;
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
