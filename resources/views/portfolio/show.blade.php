@extends('layouts.app')

@section('meta_title', $project->title . ' — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', $project->description ?: 'Detail ekspedisi dan rute wisata untuk ' . $project->title)

@section('content')

    <!-- 1. Hero Cover Header -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $project->cover_image ? (str_starts_with($project->cover_image, 'http') ? $project->cover_image : asset('storage/' . $project->cover_image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $project->title }}
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                Dipandu oleh pemandu lokal berlisensi HPI &bull; {{ $project->client ?? 'Traveler Nusantara' }}
            </p>
        </div>
    </section>

    <!-- 2. Project Specifications & Details -->
    <section class="py-16 md:py-24 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                <!-- Left Story Column -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="space-y-4">
                        <div class="eyebrow text-sage font-bold flex items-center gap-2">
                            <i class="fa-solid fa-book-open text-accent"></i>
                            <span>Catatan &amp; Ulasan Ekspedisi</span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                            Eksplorasi Destinasi &amp; Pengalaman Lapangan
                        </h2>
                        <div class="text-gray-700 text-sm md:text-base leading-relaxed space-y-4">
                            <p>{{ $project->description }}</p>
                        </div>
                    </div>

                    <!-- Detailed Itinerary & Facilities Specs -->
                    @if(!empty($project->modification_specs))
                        <div class="space-y-4 pt-4 border-t border-gray-100">
                            <h3 class="text-xs uppercase tracking-wider font-bold text-primary">Rincian Fasilitas &amp; Aktivitas Tur</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($project->modification_specs as $category => $items)
                                    <div class="p-4 bg-[#F8FAF9] rounded-xl border border-gray-100 space-y-2 shadow-sm">
                                        <div class="eyebrow text-sage text-[10px] font-bold">{{ $category }}</div>
                                        <ul class="text-xs text-gray-700 space-y-1">
                                            @if(is_array($items))
                                                @foreach($items as $it)
                                                    <li class="flex items-center gap-2">
                                                        <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                                        <span>{{ $it }}</span>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="leading-relaxed">{{ $items }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Metadata Column -->
                <div class="lg:col-span-5 tour-card p-8 space-y-6 bg-[#F8FAF9] sticky top-28">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-primary border-b border-gray-200 pb-3">Informasi Trip &amp; Pemandu</h3>
                    
                    <div class="space-y-3 text-xs text-gray-600">
                        <div class="flex justify-between"><span>Lokasi Destinasi:</span> <span class="font-bold text-primary">{{ $project->location ?? 'Indonesia' }}</span></div>
                        <div class="flex justify-between"><span>Armada / Transportasi:</span> <span class="font-bold text-primary">{{ $project->vehicle_model ?? 'Private Transport' }}</span></div>
                        <div class="flex justify-between"><span>Kategori Paket:</span> <span class="font-bold text-primary">{{ $project->service?->title ?? 'Ekspedisi Privat' }}</span></div>
                        <div class="flex justify-between"><span>Wisatawan:</span> <span class="font-bold text-primary">{{ $project->client ?? 'Traveler' }}</span></div>
                        <div class="flex justify-between"><span>Tahun Trip:</span> <span class="font-bold text-primary">{{ $project->year ?? '2025' }}</span></div>
                    </div>

                    @if($project->service)
                        <div class="pt-2">
                            <a href="{{ url('/booking?service_id=' . $project->service_id) }}" class="w-full py-3 px-6 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2">
                                <i class="fa-solid fa-calendar-check text-xs"></i>
                                <span>Booking Rute Ini</span>
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
