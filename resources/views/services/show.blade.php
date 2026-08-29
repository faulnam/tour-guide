@extends('layouts.app')

@section('meta_title', $service->title . ' — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', $service->excerpt ?: 'Paket pemandu wisata resmi HPI untuk ' . $service->title)

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $service->image ? (str_starts_with($service->image, 'http') ? $service->image : asset('storage/' . $service->image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $service->title }}
            </h1>
            @if($service->excerpt)
                <p class="text-gray-200 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
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
                    <h2 class="text-2xl font-bold uppercase tracking-tight text-primary">Rincian Paket &amp; Itinerary Eksklusif</h2>
                    <div class="prose max-w-none text-gray-700 text-sm leading-relaxed space-y-4">
                        {!! $service->description !!}
                    </div>

                    @if(!empty($service->features))
                        <div class="pt-6 border-t border-gray-100">
                            <h3 class="text-xs uppercase tracking-wider font-bold text-primary mb-4">Fasilitas &amp; Keunggulan Paket</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-800">
                                @foreach($service->features as $feat)
                                    <div class="p-3.5 bg-[#F8FAF9] rounded-xl border border-gray-100 flex items-center gap-2.5 shadow-sm">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                                        <span class="font-medium">{{ $feat }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-4 tour-card p-8 space-y-6 bg-[#F8FAF9] sticky top-28">
                    <div class="space-y-1">
                        <div class="eyebrow text-gray-500 text-[10px]">Mulai Dari</div>
                        <div class="text-3xl font-bold text-primary">{{ $service->formatted_price }}</div>
                        <div class="text-[11px] text-gray-500">Kunci jadwal dengan DP 30%</div>
                    </div>

                    <div class="space-y-3 text-xs text-gray-600 border-t border-gray-200/80 pt-4">
                        <div class="flex justify-between"><span>Tipe Tur:</span> <span class="font-bold text-primary capitalize">{{ $service->vehicle_type }}</span></div>
                        <div class="flex justify-between"><span>Estimasi Durasi:</span> <span class="font-bold text-primary">{{ $service->estimated_duration ?? '1 Hari' }}</span></div>
                        <div class="flex justify-between"><span>Lisensi:</span> <span class="font-bold text-primary">{{ $service->warranty ?? 'Resmi HPI / APGI' }}</span></div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ url('/booking?service_id=' . $service->id) }}" class="w-full py-3 px-6 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-calendar-check text-xs"></i>
                            <span>Booking Pemandu Ini</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
