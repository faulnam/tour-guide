@extends('layouts.app')

@section('meta_title', $project->title . ' — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', $project->description ?: 'Detail modifikasi dan dyno test untuk ' . $project->title)

@section('content')

    <!-- 1. Hero Cover Header -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $project->cover_image ? (str_starts_with($project->cover_image, 'http') ? $project->cover_image : asset('storage/' . $project->cover_image)) : 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">
                <a href="{{ url('/portfolio') }}" class="hover:underline">Portfolio</a> &bull; {{ $project->vehicle_type === 'motor' ? 'Custom Motorcycle' : 'Performance Car' }}
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $project->title }}
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-2xl mx-auto leading-relaxed">
                {{ $project->location ?? 'Jakarta' }} ({{ $project->year ?? '2024' }})
            </p>
        </div>
    </section>

    <!-- 2. Project Specifications & Dyno Data -->
    <section class="py-16 md:py-24 bg-white border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                <!-- Left Story Column -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="space-y-4">
                        <div class="eyebrow text-accent font-semibold">The Build Story</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">
                            Modification &amp; Tuning Overview
                        </h2>
                        <div class="text-neutral-700 text-sm md:text-base leading-relaxed space-y-4">
                            <p>{{ $project->description }}</p>
                        </div>
                    </div>

                    <!-- Dyno Result Box if available -->
                    @if($project->dyno_hp_after)
                        <div class="bg-neutral-bg border border-neutral-200 p-6 space-y-4">
                            <div class="eyebrow text-black font-bold">Dyno Jet 224xLC Calibration Results</div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                                <div class="p-3 bg-white border border-neutral-200">
                                    <div class="text-[10px] text-neutral-400 uppercase">Stock HP</div>
                                    <div class="text-base font-bold text-neutral-700">{{ $project->dyno_hp_before }} HP</div>
                                </div>
                                <div class="p-3 bg-black text-white">
                                    <div class="text-[10px] text-neutral-300 uppercase">Tuned HP</div>
                                    <div class="text-base font-bold text-white">{{ $project->dyno_hp_after }} HP</div>
                                    <div class="text-[9px] text-emerald-400 font-bold">+{{ $project->hp_gain }} WHP</div>
                                </div>
                                <div class="p-3 bg-white border border-neutral-200">
                                    <div class="text-[10px] text-neutral-400 uppercase">Stock Torsi</div>
                                    <div class="text-base font-bold text-neutral-700">{{ $project->dyno_torque_before }} Nm</div>
                                </div>
                                <div class="p-3 bg-white border border-neutral-200">
                                    <div class="text-[10px] text-neutral-400 uppercase">Tuned Torsi</div>
                                    <div class="text-base font-bold text-black">{{ $project->dyno_torque_after }} Nm</div>
                                    <div class="text-[9px] text-accent font-bold">+{{ $project->torque_gain }} Nm</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Detailed Specs List -->
                    @if(!empty($project->modification_specs))
                        <div class="space-y-4 pt-4 border-t border-neutral-200">
                            <h3 class="text-xs uppercase tracking-widest2 font-bold text-black">Spesifikasi Modifikasi Terpasang</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($project->modification_specs as $category => $items)
                                    <div class="p-4 bg-neutral-bg border border-neutral-200 space-y-2">
                                        <div class="eyebrow text-accent text-[10px]">{{ $category }}</div>
                                        <ul class="text-xs text-neutral-800 space-y-1">
                                            @if(is_array($items))
                                                @foreach($items as $it)
                                                    <li class="flex items-center gap-2">
                                                        <span class="w-1 h-1 bg-black inline-block"></span>
                                                        <span>{{ $it }}</span>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li>{{ $items }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Metadata Column -->
                <div class="lg:col-span-5 bg-neutral-bg border border-neutral-200 p-8 space-y-6">
                    <h3 class="text-xs uppercase tracking-widest2 font-bold text-black border-b border-neutral-200 pb-3">
                        Vehicle &amp; Build Metadata
                    </h3>

                    <div class="space-y-3 text-xs divide-y divide-neutral-200">
                        <div class="pt-2 flex justify-between">
                            <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Tipe:</span>
                            <span class="font-medium text-black uppercase">{{ $project->vehicle_type }}</span>
                        </div>
                        <div class="pt-3 flex justify-between">
                            <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Model:</span>
                            <span class="font-medium text-black">{{ $project->vehicle_model ?? 'Custom' }}</span>
                        </div>
                        <div class="pt-3 flex justify-between">
                            <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Tahun:</span>
                            <span class="font-medium text-black">{{ $project->year ?? '2024' }}</span>
                        </div>
                        <div class="pt-3 flex justify-between">
                            <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Client / Owner:</span>
                            <span class="font-medium text-black">{{ $project->client ?? 'Private Owner' }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-neutral-200">
                        <a href="{{ route('contact.index') }}" class="btn-dark w-full text-center block">
                            Konsultasi Modif Serupa &rarr;
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Photo Gallery Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="space-y-2">
                <div class="eyebrow">Visual Documentation</div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Project Gallery</h2>
            </div>

            <div class="space-y-6">
                @if($project->cover_image)
                    <div class="overflow-hidden bg-neutral-900 aspect-[16/9] border border-neutral-200">
                        <img src="{{ str_starts_with($project->cover_image, 'http') ? $project->cover_image : asset('storage/' . $project->cover_image) }}" 
                             alt="{{ $project->title }} Main View" 
                             loading="lazy"
                             class="w-full h-full object-cover">
                    </div>
                @endif

                @if(!empty($project->gallery_images))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($project->gallery_images as $img)
                            <div class="overflow-hidden bg-neutral-900 aspect-[4/3] border border-neutral-200 group">
                                <img src="{{ $img }}" 
                                     alt="{{ $project->title }} Detail Photo" 
                                     loading="lazy"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
