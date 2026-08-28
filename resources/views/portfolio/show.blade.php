@extends('layouts.app')

@section('meta_title', $project->title . ' — Portofolio Apex Garage')
@section('meta_description', $project->description ?? 'Detail modifikasi dan dyno test hasil karya Apex Garage.')

@section('content')

<div class="py-12 bg-[#09090b]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-neutral-400">
            <a href="{{ url('/') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ url('/portfolio') }}" class="hover:text-white">Portofolio</a>
            <span>/</span>
            <span class="text-red-400 font-bold truncate">{{ $project->title }}</span>
        </div>

        <!-- Main Card -->
        <div class="bg-[#121218] border border-neutral-800 rounded-3xl overflow-hidden shadow-2xl space-y-8">
            
            <div class="relative h-80 sm:h-[420px]">
                <img src="{{ $project->cover_image }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#121218] via-black/40 to-transparent"></div>

                <div class="absolute bottom-6 left-6 right-6">
                    <div class="flex items-center gap-2 mb-2 text-xs font-racing uppercase font-bold text-red-400">
                        <span>{{ $project->vehicle_type === 'motor' ? '🏍️ Custom Motorcycle' : '🚗 High-Performance Car' }}</span>
                        <span>•</span>
                        <span>{{ $project->year }}</span>
                    </div>
                    <h1 class="font-racing font-black text-2xl sm:text-4xl text-white uppercase tracking-tight">
                        {{ $project->title }}
                    </h1>
                </div>
            </div>

            <!-- Content Body -->
            <div class="p-6 sm:p-10 space-y-8">
                
                <!-- Dyno Chart Comparison Banner -->
                @if($project->dyno_hp_after)
                    <div class="bg-gradient-to-r from-red-950/30 via-neutral-900 to-amber-950/30 border border-neutral-800 p-6 rounded-2xl">
                        <div class="text-xs font-bold text-neutral-300 uppercase tracking-wider font-racing mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-gauge-high text-red-500"></i>
                            <span>HASIL PENGUJIAN DYNO JET 224XLC</span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                            <div class="p-3 bg-neutral-950/70 rounded-xl border border-neutral-800">
                                <div class="text-[10px] text-neutral-500 uppercase">HP Stock</div>
                                <div class="font-racing font-bold text-lg text-neutral-300">{{ $project->dyno_hp_before }} HP</div>
                            </div>

                            <div class="p-3 bg-neutral-950/70 rounded-xl border border-red-500/40">
                                <div class="text-[10px] text-red-400 uppercase font-bold">HP Dyno Tuned</div>
                                <div class="font-racing font-black text-xl text-emerald-400">{{ $project->dyno_hp_after }} HP</div>
                                <div class="text-[10px] text-emerald-400 font-bold">+{{ $project->hp_gain }} WHP</div>
                            </div>

                            <div class="p-3 bg-neutral-950/70 rounded-xl border border-neutral-800">
                                <div class="text-[10px] text-neutral-500 uppercase">Torsi Stock</div>
                                <div class="font-racing font-bold text-lg text-neutral-300">{{ $project->dyno_torque_before }} Nm</div>
                            </div>

                            <div class="p-3 bg-neutral-950/70 rounded-xl border border-amber-500/40">
                                <div class="text-[10px] text-amber-400 uppercase font-bold">Torsi Dyno Tuned</div>
                                <div class="font-racing font-black text-xl text-cyan-400">{{ $project->dyno_torque_after }} Nm</div>
                                <div class="text-[10px] text-cyan-400 font-bold">+{{ $project->torque_gain }} Nm</div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Story & Overview -->
                <div class="space-y-3">
                    <h3 class="font-racing font-bold text-base text-white uppercase">TENTANG PROJECT BUILD INI</h3>
                    <p class="text-xs sm:text-sm text-neutral-300 leading-relaxed">
                        {{ $project->description }}
                    </p>
                </div>

                <!-- Modification Specs Breakdown -->
                @if(!empty($project->modification_specs))
                    <div class="space-y-4 pt-4 border-t border-neutral-800">
                        <h3 class="font-racing font-bold text-base text-white uppercase">SPESIFIKASI MODIFIKASI LENGKAP</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($project->modification_specs as $category => $items)
                                <div class="bg-[#0a0a0e] border border-neutral-800 p-5 rounded-2xl space-y-2">
                                    <div class="text-xs font-racing font-bold text-red-400 uppercase">{{ $category }}</div>
                                    <ul class="text-xs text-neutral-300 space-y-1">
                                        @if(is_array($items))
                                            @foreach($items as $it)
                                                <li class="flex items-center gap-2">
                                                    <i class="fa-solid fa-angle-right text-red-500 text-[10px]"></i>
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

                <!-- Gallery Images -->
                @if(!empty($project->gallery_images))
                    <div class="space-y-4 pt-4 border-t border-neutral-800">
                        <h3 class="font-racing font-bold text-base text-white uppercase">GALERI FOTO DETAIL BUILD</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($project->gallery_images as $img)
                                <div class="rounded-2xl overflow-hidden h-60 border border-neutral-800">
                                    <img src="{{ $img }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- CTA -->
                <div class="p-6 bg-neutral-900 border border-neutral-800 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <div class="font-racing font-bold text-sm text-white uppercase">INGIN MEMBANGUN KENDARAAN SEPERTI INI?</div>
                        <div class="text-xs text-neutral-400">Konsultasikan konsep tuning Anda dengan master builder kami.</div>
                    </div>

                    <a href="{{ url('/booking') }}" 
                       class="px-6 py-3 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Booking Jadwal Modif</span>
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
