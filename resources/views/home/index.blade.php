@extends('layouts.app')

@section('meta_title', 'Apex Garage — Workshop & Bengkel Modifikasi Motor & Mobil Terkemuka')

@section('content')

<!-- 1. Hero Section with Automotive Swiper Slider & Fast Booking Bar -->
<section class="relative bg-black min-h-[90vh] flex flex-col justify-between overflow-hidden">
    
    <!-- Swiper Container for Background Hero Slides -->
    <div class="swiper heroSwiper absolute inset-0 w-full h-full z-0">
        <div class="swiper-wrapper">
            @forelse($heroSlides as $slide)
                <div class="swiper-slide relative">
                    <img src="{{ $slide->image }}" alt="{{ $slide->title }}" class="w-full h-full object-cover object-center filter brightness-[0.45]">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#09090b] via-black/40 to-black/70"></div>
                </div>
            @empty
                <div class="swiper-slide relative">
                    <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1920&auto=format&fit=crop" class="w-full h-full object-cover brightness-[0.45]">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#09090b] via-black/40 to-black/70"></div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Hero Content Overlay -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12 flex-1 flex flex-col justify-center">
        
        <div class="max-w-3xl space-y-6">
            
            <!-- Badges -->
            <div class="inline-flex items-center gap-2 bg-red-600/20 border border-red-500/40 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider text-red-400 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                <span>Dyno Jet 224xLC Certified & Custom Tuning Specialist</span>
            </div>

            <!-- Headline -->
            <h1 class="font-racing font-black text-4xl sm:text-5xl lg:text-7xl text-white tracking-tight leading-[1.05] uppercase">
                PRECISION <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-red-400 to-amber-500">TUNING</span> & CUSTOM GARAGE
            </h1>

            <p class="text-base sm:text-lg text-neutral-300 font-light leading-relaxed max-w-2xl">
                Tingkatkan performa dan tampilan kendaraan Anda ke level tertinggi. Spesialis ECU Remap Dyno Test, Custom Bike Builder, Widebody Kit, Cat Oven Spies Hecker, dan Air Suspension.
            </p>

            <!-- Call to Actions -->
            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="{{ url('/booking') }}" 
                   class="px-8 py-4 bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl font-bold uppercase tracking-wider text-xs shadow-xl shadow-red-600/40 hover:scale-105 transition-all flex items-center gap-2.5">
                    <i class="fa-solid fa-calendar-check text-sm"></i>
                    <span>Booking Antrean Servis</span>
                </a>

                <a href="{{ url('/portfolio') }}" 
                   class="px-7 py-4 bg-[#14141c]/90 hover:bg-neutral-800 text-white border border-neutral-700 rounded-xl font-bold uppercase tracking-wider text-xs transition-all flex items-center gap-2">
                    <i class="fa-solid fa-fire text-amber-500"></i>
                    <span>Lihat Portofolio Build</span>
                </a>
            </div>

        </div>

    </div>

    <!-- Fast Booking Interactive Bar -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-8">
        <div class="bg-[#121218]/95 backdrop-blur-xl border border-neutral-800 p-4 sm:p-6 rounded-2xl shadow-2xl glow-red">
            <form action="{{ route('booking.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                
                <div>
                    <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1.5">
                        <i class="fa-solid fa-car-side mr-1 text-red-500"></i> Jenis Kendaraan
                    </label>
                    <select name="vehicle_type" class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2.5 text-xs text-white focus:ring-1 focus:ring-red-500 focus:outline-none">
                        <option value="all">Semua (Motor & Mobil)</option>
                        <option value="mobil">🚗 Mobil (Sports, Sedan, SUV)</option>
                        <option value="motor">🏍️ Motor (Moge, Sport, Matic, Custom)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1.5">
                        <i class="fa-solid fa-wrench mr-1 text-red-500"></i> Paket Layanan
                    </label>
                    <select name="service_id" class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2.5 text-xs text-white focus:ring-1 focus:ring-red-500 focus:outline-none">
                        <option value="">Pilih Layanan Modifikasi</option>
                        @foreach($popularServices as $srv)
                            <option value="{{ $srv->id }}">{{ $srv->title }} ({{ $srv->formatted_price }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1.5">
                        <i class="fa-solid fa-calendar-day mr-1 text-red-500"></i> Rencana Tanggal
                    </label>
                    <input type="date" name="booking_date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2.5 text-xs text-white focus:ring-1 focus:ring-red-500 focus:outline-none">
                </div>

                <div>
                    <button type="submit" 
                            class="w-full py-2.5 px-4 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-lg shadow-red-600/30">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari Jadwal Booking</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

</section>


<!-- 2. Performance Stats / Dyno Counter Section -->
<section class="py-12 bg-[#0c0c10] border-y border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            
            <div class="p-4 rounded-xl bg-neutral-900/30 border border-neutral-800/60">
                <div class="font-racing font-black text-3xl sm:text-4xl lg:text-5xl text-red-500 mb-1">1,450+</div>
                <div class="text-xs uppercase font-bold text-neutral-300 tracking-wider">Mobil & Motor Dimodifikasi</div>
                <div class="text-[10px] text-neutral-500 mt-1">Project Finished & Tuned</div>
            </div>

            <div class="p-4 rounded-xl bg-neutral-900/30 border border-neutral-800/60">
                <div class="font-racing font-black text-3xl sm:text-4xl lg:text-5xl text-amber-400 mb-1">3,200+</div>
                <div class="text-xs uppercase font-bold text-neutral-300 tracking-wider">Dyno Jet Run Test</div>
                <div class="text-[10px] text-neutral-500 mt-1">Sertifikasi Tenaga & Torsi</div>
            </div>

            <div class="p-4 rounded-xl bg-neutral-900/30 border border-neutral-800/60">
                <div class="font-racing font-black text-3xl sm:text-4xl lg:text-5xl text-cyan-400 mb-1">28</div>
                <div class="text-xs uppercase font-bold text-neutral-300 tracking-wider">Piala Kontes Modifikasi</div>
                <div class="text-[10px] text-neutral-500 mt-1">IMX, Kustomfest, Intersport</div>
            </div>

            <div class="p-4 rounded-xl bg-neutral-900/30 border border-neutral-800/60">
                <div class="font-racing font-black text-3xl sm:text-4xl lg:text-5xl text-emerald-400 mb-1">99.4%</div>
                <div class="text-xs uppercase font-bold text-neutral-300 tracking-wider">Kepuasan Pelanggan</div>
                <div class="text-[10px] text-neutral-500 mt-1">Garansi Pengerjaan Terjamin</div>
            </div>

        </div>
    </div>
</section>


<!-- 3. Popular Modification & Workshop Services -->
<section class="py-20 bg-[#09090b] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <div class="text-xs uppercase tracking-widest font-bold text-red-500 mb-2">Layanan Unggulan</div>
                <h2 class="font-racing font-extrabold text-3xl sm:text-4xl text-white uppercase tracking-tight">
                    PAKET MODIFIKASI & PERAWATAN
                </h2>
            </div>
            <a href="{{ url('/services') }}" class="mt-4 md:mt-0 text-xs font-bold uppercase tracking-wider text-red-400 hover:text-red-300 inline-flex items-center gap-1.5">
                <span>Lihat Semua Layanan (Motor & Mobil)</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($popularServices as $service)
                <div class="bg-[#121218] border border-neutral-800 rounded-2xl overflow-hidden hover:border-red-500/50 transition-all duration-300 flex flex-col group hover:-translate-y-1 shadow-xl">
                    
                    <!-- Service Image -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $service->image }}" alt="{{ $service->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#121218] via-transparent to-transparent"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex gap-2">
                            {!! $service->vehicle_badge !!}
                            @if($service->is_popular)
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-red-600 text-white shadow">Populer</span>
                            @endif
                        </div>
                    </div>

                    <!-- Service Body -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center gap-2.5 text-xs text-neutral-400 mb-2 font-mono">
                                <i class="fa-solid fa-clock text-amber-500"></i>
                                <span>{{ $service->estimated_duration ?? 'Estimasi Menyesuaikan' }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-white group-hover:text-red-400 transition-colors">
                                <a href="{{ url('/services/' . $service->slug) }}">{{ $service->title }}</a>
                            </h3>
                            <p class="text-xs text-neutral-400 mt-2 line-clamp-2 leading-relaxed">
                                {{ $service->excerpt }}
                            </p>
                        </div>

                        <!-- Features Checklist -->
                        @if(!empty($service->features))
                            <ul class="space-y-1.5 border-t border-neutral-800/80 pt-3 text-[11px] text-neutral-300">
                                @foreach(array_slice($service->features, 0, 3) as $feat)
                                    <li class="flex items-center gap-2">
                                        <i class="fa-solid fa-check text-red-500 text-[10px]"></i>
                                        <span class="truncate">{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Price & Action -->
                        <div class="pt-4 border-t border-neutral-800 flex items-center justify-between">
                            <div>
                                <div class="text-[10px] text-neutral-500 uppercase">Mulai Dari</div>
                                <div class="font-racing font-bold text-sm text-red-400">{{ $service->formatted_price }}</div>
                            </div>
                            <a href="{{ url('/booking?service_id=' . $service->id) }}" 
                               class="px-4 py-2 bg-neutral-800 group-hover:bg-red-600 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-1.5">
                                <span>Booking</span>
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>


<!-- 4. Featured Tuning Projects / Before-After Showcase -->
<section class="py-20 bg-[#0c0c10] border-t border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-14 space-y-2">
            <div class="text-xs uppercase tracking-widest font-bold text-red-500">Hasil Modifikasi & Dyno</div>
            <h2 class="font-racing font-extrabold text-3xl sm:text-4xl text-white uppercase tracking-tight">
                FEATURED TUNING BUILDS
            </h2>
            <p class="text-xs sm:text-sm text-neutral-400">
                Peningkatan tenaga terukur di atas mesin Dyno Jet dan estetika kustomisasi berstandar kontes.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            @if($featuredProjects->count())
                @php $topProject = $featuredProjects->first(); @endphp
                
                <!-- Main Featured Project Card -->
                <div class="bg-[#121218] border border-neutral-800 rounded-2xl overflow-hidden shadow-2xl p-6 space-y-6">
                    <div class="relative h-64 sm:h-80 rounded-xl overflow-hidden">
                        <img src="{{ $topProject->cover_image }}" alt="{{ $topProject->title }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow">
                            Masterpiece Build
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-3 text-xs text-red-400 font-bold mb-1 uppercase font-racing">
                            <span>{{ $topProject->vehicle_type === 'motor' ? '🏍️ Motor Custom' : '🚗 Mobil Performance' }}</span>
                            <span>•</span>
                            <span>{{ $topProject->year }}</span>
                        </div>
                        <h3 class="font-racing font-bold text-2xl text-white">
                            {{ $topProject->title }}
                        </h3>
                        <p class="text-xs text-neutral-400 mt-2 leading-relaxed">
                            {{ $topProject->description }}
                        </p>
                    </div>

                    <!-- Dyno Stats Gain Badge Grid -->
                    @if($topProject->dyno_hp_after)
                        <div class="grid grid-cols-2 gap-4 bg-neutral-900/80 p-4 rounded-xl border border-neutral-800">
                            <div>
                                <div class="text-[10px] text-neutral-400 uppercase font-bold">Horsepower Boost</div>
                                <div class="font-racing font-black text-xl text-red-500">
                                    {{ $topProject->dyno_hp_before }} HP &rarr; <span class="text-emerald-400">{{ $topProject->dyno_hp_after }} HP</span>
                                </div>
                                <div class="text-[10px] text-emerald-400 font-bold mt-0.5">
                                    +{{ $topProject->hp_gain }} WHP Gain!
                                </div>
                            </div>
                            <div>
                                <div class="text-[10px] text-neutral-400 uppercase font-bold">Torque Gain</div>
                                <div class="font-racing font-black text-xl text-amber-400">
                                    {{ $topProject->dyno_torque_before }} Nm &rarr; <span class="text-cyan-400">{{ $topProject->dyno_torque_after }} Nm</span>
                                </div>
                                <div class="text-[10px] text-cyan-400 font-bold mt-0.5">
                                    +{{ $topProject->torque_gain }} Nm Gain!
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="pt-2 flex items-center justify-between">
                        <a href="{{ url('/portfolio/' . $topProject->slug) }}" class="text-xs font-bold text-red-400 hover:text-red-300 inline-flex items-center gap-1.5">
                            <span>Lihat Spesifikasi Lengkap Modifikasi</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="{{ url('/booking') }}" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold transition-all">
                            Konsultasi Modif Serupa
                        </a>
                    </div>
                </div>
            @endif

            <!-- Side Projects Grid (3 items) -->
            <div class="space-y-4">
                @foreach($recentProjects->take(3) as $proj)
                    <a href="{{ url('/portfolio/' . $proj->slug) }}" class="flex items-center gap-4 p-4 rounded-2xl bg-[#121218] border border-neutral-800 hover:border-red-500/50 transition-all group">
                        <div class="w-28 h-24 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="{{ $proj->cover_image }}" alt="{{ $proj->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[10px] uppercase font-bold text-red-400 mb-0.5">
                                {{ $proj->vehicle_type === 'motor' ? 'Motor' : 'Mobil' }} • {{ $proj->vehicle_model ?? 'Custom' }}
                            </div>
                            <h4 class="font-bold text-sm text-white group-hover:text-red-400 transition-colors truncate">
                                {{ $proj->title }}
                            </h4>
                            <p class="text-xs text-neutral-400 line-clamp-1 mt-1">
                                {{ $proj->client }} • {{ $proj->location }}
                            </p>
                            @if($proj->dyno_hp_after)
                                <div class="text-[10px] font-racing font-bold text-emerald-400 mt-1">
                                    Dyno Output: {{ $proj->dyno_hp_after }} HP (+{{ $proj->hp_gain }} HP)
                                </div>
                            @endif
                        </div>
                        <div class="text-neutral-600 group-hover:text-red-400 transition-colors pr-2">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </div>
                    </a>
                @endforeach

                <div class="pt-2 text-center">
                    <a href="{{ url('/portfolio') }}" class="w-full block py-3.5 bg-neutral-900 hover:bg-neutral-800 text-neutral-200 border border-neutral-800 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors">
                        Jelajahi Semua Portofolio Build &rarr;
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- 5. Certified Mechanics & Builders Team Section -->
<section class="py-20 bg-[#09090b] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-14 space-y-2">
            <div class="text-xs uppercase tracking-widest font-bold text-red-500">Mekanik & Builder Bersertifikasi</div>
            <h2 class="font-racing font-extrabold text-3xl sm:text-4xl text-white uppercase tracking-tight">
                OUR MASTER TUNERS
            </h2>
            <p class="text-xs sm:text-sm text-neutral-400">
                Didukung oleh teknisi berpengalaman puluhan tahun di ajang balap nasional dan kontes modifikasi internasional.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($mechanics as $mechanic)
                <div class="bg-[#121218] border border-neutral-800 rounded-2xl p-6 text-center space-y-4 hover:border-red-500/50 transition-all group">
                    <div class="relative w-24 h-24 mx-auto rounded-full overflow-hidden border-2 border-red-500/40 p-1 group-hover:border-red-500 transition-colors">
                        <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?q=80&w=300&auto=format&fit=crop" class="w-full h-full object-cover rounded-full">
                    </div>
                    <div>
                        <h4 class="font-bold text-base text-white group-hover:text-red-400 transition-colors">{{ $mechanic->name }}</h4>
                        <div class="text-xs text-red-400 font-semibold mt-0.5">{{ $mechanic->specialty ?? 'Lead Mechanic' }}</div>
                        <div class="text-[10px] text-neutral-500 mt-1">Apex Certified Tuner</div>
                    </div>
                    <div class="pt-3 border-t border-neutral-800 text-xs text-neutral-400 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i>
                        <span>Status: Aktif Bertugas</span>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center text-neutral-500 text-xs py-8">
                    Data mekanik workshop sedang diperbarui.
                </div>
            @endforelse
        </div>

    </div>
</section>


<!-- 6. Client Reviews & Testimonials -->
<section class="py-20 bg-[#0c0c10] border-t border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-14 space-y-2">
            <div class="text-xs uppercase tracking-widest font-bold text-red-500">Testimoni Pelanggan</div>
            <h2 class="font-racing font-extrabold text-3xl sm:text-4xl text-white uppercase tracking-tight">
                WHAT ENTHUSIASTS SAY
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($testimonials as $testi)
                <div class="bg-[#121218] border border-neutral-800 p-6 rounded-2xl flex flex-col justify-between space-y-4 hover:border-neutral-700 transition-colors">
                    <div class="space-y-3">
                        <div class="flex text-amber-400 text-xs space-x-1">
                            @for($i = 0; $i < $testi->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-xs text-neutral-300 leading-relaxed italic">
                            "{{ $testi->message }}"
                        </p>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-neutral-800">
                        <div class="w-10 h-10 rounded-full bg-neutral-800 overflow-hidden flex-shrink-0">
                            <img src="{{ $testi->photo ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&auto=format&fit=crop' }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="font-bold text-xs text-white">{{ $testi->client_name }}</div>
                            <div class="text-[10px] text-neutral-400">{{ $testi->client_company }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>


<!-- 7. Partner Performance Brands Ticker -->
<section class="py-12 bg-black border-t border-neutral-800 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-8">
        <div class="text-[11px] uppercase tracking-widest text-neutral-500 font-bold">Official Performance & Parts Partners</div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 flex flex-wrap items-center justify-center gap-8 sm:gap-12 opacity-75">
        @foreach($clients as $c)
            <div class="flex items-center gap-2 text-neutral-400 hover:text-white transition-colors font-racing font-bold text-sm tracking-wider">
                <i class="fa-solid fa-shield-halved text-red-500 text-xs"></i>
                <span>{{ strtoupper($c->name) }}</span>
            </div>
        @endforeach
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            speed: 1200,
        });
    });
</script>
@endpush
