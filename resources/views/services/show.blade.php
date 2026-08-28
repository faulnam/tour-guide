@extends('layouts.app')

@section('meta_title', $service->title . ' — Layanan Apex Garage')
@section('meta_description', $service->excerpt ?? 'Layanan modifikasi performa di Apex Garage.')

@section('content')

<div class="py-12 bg-[#09090b]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-neutral-400">
            <a href="{{ url('/') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ url('/services') }}" class="hover:text-white">Layanan</a>
            <span>/</span>
            <span class="text-red-400 font-bold truncate">{{ $service->title }}</span>
        </div>

        <!-- Main Service Detail -->
        <div class="bg-[#121218] border border-neutral-800 rounded-3xl overflow-hidden shadow-2xl">
            
            <div class="relative h-72 sm:h-96">
                <img src="{{ $service->image }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#121218] via-black/40 to-transparent"></div>

                <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            {!! $service->vehicle_badge !!}
                            @if($service->warranty)
                                <span class="px-2.5 py-0.5 rounded text-[10px] uppercase font-bold bg-neutral-900/80 border border-neutral-700 text-neutral-300">
                                    <i class="fa-solid fa-shield mr-1 text-cyan-400"></i> Garansi {{ $service->warranty }}
                                </span>
                            @endif
                        </div>
                        <h1 class="font-racing font-black text-2xl sm:text-4xl text-white uppercase tracking-tight">
                            {{ $service->title }}
                        </h1>
                    </div>

                    <div class="text-left sm:text-right bg-black/60 backdrop-blur-md p-3.5 rounded-2xl border border-neutral-800">
                        <div class="text-[10px] text-neutral-400 uppercase">Mulai Dari</div>
                        <div class="font-racing font-black text-2xl text-red-500">{{ $service->formatted_price }}</div>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Content (2 Cols) -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <h2 class="font-racing font-bold text-lg text-white uppercase mb-3">DESKRIPSI PENGERJAAN</h2>
                        <div class="prose prose-invert prose-xs sm:prose-sm text-neutral-300 leading-relaxed max-w-none">
                            {!! $service->description !!}
                        </div>
                    </div>

                    @if(!empty($service->features))
                        <div class="pt-4 border-t border-neutral-800">
                            <h3 class="font-racing font-bold text-sm text-white uppercase mb-3">FITUR & KEUNGGULAN PAKET</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-neutral-200">
                                @foreach($service->features as $feat)
                                    <div class="flex items-center gap-2.5 p-3 rounded-xl bg-[#0a0a0e] border border-neutral-800">
                                        <i class="fa-solid fa-check text-red-500"></i>
                                        <span>{{ $feat }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar CTA (1 Col) -->
                <div class="space-y-6">
                    <div class="bg-[#0a0a0e] border border-neutral-800 p-6 rounded-2xl space-y-4">
                        <h4 class="font-racing font-bold text-xs text-white uppercase tracking-wider">BOOKING LAYANAN INI</h4>
                        
                        <div class="space-y-2 text-xs text-neutral-300">
                            <div class="flex justify-between"><span class="text-neutral-500">Estimasi Durasi:</span> <span class="font-bold text-white">{{ $service->estimated_duration ?? 'Menyesuaikan' }}</span></div>
                            <div class="flex justify-between"><span class="text-neutral-500">Tipe Kendaraan:</span> <span class="font-bold uppercase text-amber-400">{{ $service->vehicle_type }}</span></div>
                            <div class="flex justify-between"><span class="text-neutral-500">Garansi:</span> <span class="text-emerald-400">{{ $service->warranty ?? 'Garansi Kepuasan' }}</span></div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ url('/booking?service_id=' . $service->id) }}" 
                               class="w-full py-3.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl text-xs font-racing font-bold uppercase tracking-wider block text-center shadow-lg shadow-red-600/30 transition-all">
                                <i class="fa-solid fa-calendar-check mr-1.5"></i>
                                <span>Booking Antrean Online</span>
                            </a>
                        </div>

                        <div class="text-[10px] text-neutral-500 text-center">
                            Pembayaran DP instan via QRIS / VA Gateway.
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
