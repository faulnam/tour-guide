@extends('layouts.app')

@section('meta_title', 'Portofolio Modifikasi & Dyno Tuning — Apex Garage')
@section('meta_description', 'Galeri hasil modifikasi mobil dan motor, dyno sheet power run, widebody kit, dan custom bike karya Apex Garage.')

@section('content')

<!-- Header Banner -->
<section class="py-16 bg-[#0c0c10] border-b border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-500/30 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-red-400">
            <i class="fa-solid fa-fire"></i>
            <span>Masterpiece Builds Gallery</span>
        </div>
        <h1 class="font-racing font-black text-3xl sm:text-5xl text-white uppercase tracking-tight">
            PORTOFOLIO BUILD & HASIL MODIFIKASI
        </h1>
        <p class="text-xs sm:text-sm text-neutral-400 max-w-2xl mx-auto">
            Kumpulan karya tuning performa, dyno power chart, dan custom motorcycle yang telah teruji di jalan raya dan sirkuit.
        </p>
    </div>
</section>

<!-- Portfolio Grid -->
<section class="py-16 bg-[#09090b]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $proj)
                <div class="bg-[#121218] border border-neutral-800 rounded-3xl overflow-hidden hover:border-red-500/50 transition-all duration-300 flex flex-col justify-between group shadow-xl hover:-translate-y-1">
                    
                    <div>
                        <!-- Project Image -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $proj->cover_image }}" alt="{{ $proj->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121218] via-transparent to-transparent"></div>
                            
                            <div class="absolute top-3 left-3 bg-red-600 text-white px-2.5 py-0.5 rounded text-[10px] uppercase font-bold tracking-wider shadow">
                                {{ $proj->vehicle_type === 'motor' ? '🏍️ Motor Custom' : '🚗 Mobil Performance' }}
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="p-6 space-y-3">
                            <div class="text-[10px] uppercase font-bold text-red-400 font-racing">
                                {{ $proj->vehicle_model ?? 'Custom Build' }} • {{ $proj->year }}
                            </div>
                            <h3 class="font-racing font-bold text-lg text-white group-hover:text-red-400 transition-colors">
                                <a href="{{ url('/portfolio/' . $proj->slug) }}">{{ $proj->title }}</a>
                            </h3>
                            <p class="text-xs text-neutral-400 line-clamp-2 leading-relaxed">
                                {{ $proj->description }}
                            </p>

                            <!-- Dyno Badge if available -->
                            @if($proj->dyno_hp_after)
                                <div class="bg-neutral-900/90 p-3 rounded-xl border border-neutral-800 flex items-center justify-between text-xs font-mono">
                                    <span class="text-neutral-400">Dyno Power:</span>
                                    <span class="font-bold text-emerald-400">{{ $proj->dyno_hp_after }} HP <span class="text-[10px] text-neutral-500">(+{{ $proj->hp_gain }} WHP)</span></span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 pt-0 border-t border-neutral-800/60 mt-2 flex items-center justify-between">
                        <span class="text-xs text-neutral-500 font-mono">{{ $proj->client }}</span>
                        <a href="{{ url('/portfolio/' . $proj->slug) }}" 
                           class="text-xs font-bold text-red-400 group-hover:text-red-300 inline-flex items-center gap-1">
                            <span>Detail Modif</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="pt-6">
            {{ $projects->links() }}
        </div>

    </div>
</section>

@endsection
