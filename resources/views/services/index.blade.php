@extends('layouts.app')

@section('meta_title', 'Layanan & Paket Modifikasi Motor & Mobil — Apex Garage')
@section('meta_description', 'Pilihan layanan modifikasi performa tinggi: ECU Remap Dyno Test, Custom Bike Builder, Widebody Kit, Cat Oven Spies Hecker, dan Air Suspension di Jakarta.')

@section('content')

<!-- Header Banner -->
<section class="py-16 bg-[#0c0c10] border-b border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-500/30 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-red-400">
            <i class="fa-solid fa-wrench"></i>
            <span>Performance & Custom Studio</span>
        </div>
        <h1 class="font-racing font-black text-3xl sm:text-5xl text-white uppercase tracking-tight">
            LAYANAN & PAKET MODIFIKASI
        </h1>
        <p class="text-xs sm:text-sm text-neutral-400 max-w-2xl mx-auto">
            Daftar paket tuning terpadu untuk Mobil dan Sepeda Motor berstandar motorsport dengan garansi pengerjaan.
        </p>
    </div>
</section>

<!-- Filter Tabs & Services Grid -->
<section class="py-16 bg-[#09090b]" x-data="{ filter: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filter Tabs -->
        <div class="flex items-center justify-center gap-3 mb-12">
            <button @click="filter = 'all'" 
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all"
                    :class="filter === 'all' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-neutral-900 border border-neutral-800 text-neutral-400 hover:text-white'">
                Semua Layanan
            </button>
            <button @click="filter = 'mobil'" 
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-1.5"
                    :class="filter === 'mobil' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-neutral-900 border border-neutral-800 text-neutral-400 hover:text-white'">
                <span>🚗 Modifikasi Mobil</span>
            </button>
            <button @click="filter = 'motor'" 
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-1.5"
                    :class="filter === 'motor' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-neutral-900 border border-neutral-800 text-neutral-400 hover:text-white'">
                <span>🏍️ Modifikasi Motor</span>
            </button>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div x-show="filter === 'all' || '{{ $service->vehicle_type }}' === filter || '{{ $service->vehicle_type }}' === 'both'"
                     x-transition
                     class="bg-[#121218] border border-neutral-800 rounded-3xl overflow-hidden hover:border-red-500/50 transition-all duration-300 flex flex-col justify-between group shadow-xl">
                    
                    <div>
                        <!-- Service Image -->
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $service->image }}" alt="{{ $service->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121218] via-transparent to-transparent"></div>
                            
                            <div class="absolute top-3 left-3 flex gap-2">
                                {!! $service->vehicle_badge !!}
                                @if($service->is_popular)
                                    <span class="px-2.5 py-0.5 rounded text-[10px] uppercase font-bold bg-red-600 text-white shadow">Populer</span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 space-y-4">
                            <div>
                                <div class="flex items-center gap-2 text-xs text-neutral-400 mb-1 font-mono">
                                    <i class="fa-solid fa-clock text-amber-500"></i>
                                    <span>{{ $service->estimated_duration ?? 'Estimasi Menyesuaikan' }}</span>
                                </div>
                                <h3 class="font-racing font-bold text-lg text-white group-hover:text-red-400 transition-colors">
                                    <a href="{{ url('/services/' . $service->slug) }}">{{ $service->title }}</a>
                                </h3>
                                <p class="text-xs text-neutral-400 mt-2 line-clamp-3 leading-relaxed">
                                    {{ $service->excerpt }}
                                </p>
                            </div>

                            @if(!empty($service->features))
                                <ul class="space-y-1.5 border-t border-neutral-800/80 pt-3 text-[11px] text-neutral-300">
                                    @foreach(array_slice($service->features, 0, 4) as $feat)
                                        <li class="flex items-center gap-2">
                                            <i class="fa-solid fa-check text-red-500 text-[10px]"></i>
                                            <span class="truncate">{{ $feat }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Bottom Bar -->
                    <div class="p-6 pt-0 border-t border-neutral-800/60 mt-4 flex items-center justify-between">
                        <div>
                            <div class="text-[10px] text-neutral-500 uppercase">Mulai Dari</div>
                            <div class="font-racing font-bold text-sm text-red-400">{{ $service->formatted_price }}</div>
                        </div>
                        <a href="{{ url('/booking?service_id=' . $service->id) }}" 
                           class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/30">
                            Booking Antrean &rarr;
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
