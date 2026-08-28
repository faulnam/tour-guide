@extends('layouts.app')

@section('meta_title', 'Tentang Workshop & Fasilitas Dyno — Apex Garage')
@section('meta_description', 'Mengenal Apex Garage, fasilitas Dyno Jet 224xLC, ruang cat oven Spies Hecker, dan rekam jejak sertifikasi teknisi modifikasi.')

@section('content')

<!-- Header Banner -->
<section class="py-16 bg-[#0c0c10] border-b border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-500/30 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-red-400">
            <i class="fa-solid fa-flag-checkered"></i>
            <span>Apex Heritage & Vision</span>
        </div>
        <h1 class="font-racing font-black text-3xl sm:text-5xl text-white uppercase tracking-tight">
            TENTANG APEX GARAGE
        </h1>
        <p class="text-xs sm:text-sm text-neutral-400 max-w-2xl mx-auto">
            Workshop modifikasi performa motor dan mobil berstandar motorsport di Jakarta sejak 2018.
        </p>
    </div>
</section>

<!-- Story & Vision -->
<section class="py-20 bg-[#09090b]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="space-y-6">
                <div class="text-xs uppercase font-bold text-red-500 tracking-widest font-racing">Our Philosophy</div>
                <h2 class="font-racing font-extrabold text-3xl sm:text-4xl text-white uppercase">
                    DEDIKASI PADA PRESISI & PERFORMA TINGGI
                </h2>
                <p class="text-xs sm:text-sm text-neutral-300 leading-relaxed">
                    Didirikan oleh para motorsport enthusiast dan certified tuner, Apex Garage hadir untuk menjawab kebutuhan para pemilik motor dan mobil yang menginginkan modifikasi tanpa kompromi antara performa buas dan keandalan harian (daily driveability).
                </p>
                <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed">
                    Setiap pengerjaan—mulai dari ECU remap, custom motorcycle fabrication, widebody kit, hingga cat oven Spies Hecker—dikerjakan menggunakan peralatan mutakhir dan diuji langsung di atas mesin Dyno Jet 224xLC berstandar internasional.
                </p>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-4 bg-[#121218] border border-neutral-800 rounded-2xl">
                        <div class="font-racing font-black text-2xl text-red-500">100%</div>
                        <div class="text-xs font-bold text-white mt-1">Data-Driven Tuning</div>
                        <div class="text-[10px] text-neutral-400">Hasil dyno real & teruji</div>
                    </div>

                    <div class="p-4 bg-[#121218] border border-neutral-800 rounded-2xl">
                        <div class="font-racing font-black text-2xl text-amber-400">2 Tahun</div>
                        <div class="text-xs font-bold text-white mt-1">Garansi Cat Oven</div>
                        <div class="text-[10px] text-neutral-400">Spies Hecker System</div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-2xl border border-neutral-800 aspect-[4/3]">
                    <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Workshop Equipment & Facilities -->
<section class="py-20 bg-[#0c0c10] border-t border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <div class="text-xs uppercase font-bold text-red-500 tracking-widest font-racing">Fasilitas Modern</div>
            <h2 class="font-racing font-extrabold text-3xl sm:text-4xl text-white uppercase">
                STATE-OF-THE-ART EQUIPMENT
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-[#121218] border border-neutral-800 p-8 rounded-3xl space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-red-600/20 text-red-500 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <h3 class="font-racing font-bold text-lg text-white">Dyno Jet 224xLC Chassis Dyno</h3>
                <p class="text-xs text-neutral-400 leading-relaxed">
                    Mampu menguji hingga 2,000 HP dengan sistem pendingin dual high-velocity blower untuk simulasi jalan raya dan sirkuit.
                </p>
            </div>

            <div class="bg-[#121218] border border-neutral-800 p-8 rounded-3xl space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-600/20 text-amber-500 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-spray-can-sparkles"></i>
                </div>
                <h3 class="font-racing font-bold text-lg text-white">Down-Draft Spray Booth Oven</h3>
                <p class="text-xs text-neutral-400 leading-relaxed">
                    Ruang cat oven bertekanan positif dengan filter mikro 5-tahap, bebas partikel debu demi hasil cat wet-look sempurna.
                </p>
            </div>

            <div class="bg-[#121218] border border-neutral-800 p-8 rounded-3xl space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-cyan-600/20 text-cyan-500 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-fire-burner"></i>
                </div>
                <h3 class="font-racing font-bold text-lg text-white">TIG & Tube Bending Custom Rig</h3>
                <p class="text-xs text-neutral-400 leading-relaxed">
                    Fabrikasi knalpot titanium dan rangka motor custom presisi tinggi dengan teknologi bending hidrolik mandrel.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- Awards / Contests Showcase -->
<section class="py-20 bg-[#09090b] border-t border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <div class="text-xs uppercase font-bold text-red-500 tracking-widest font-racing">Pencapaian & Kompetisi</div>
            <h2 class="font-racing font-extrabold text-3xl sm:text-4xl text-white uppercase">
                TROPHIES & RECOGNITION
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($awards as $aw)
                <div class="bg-[#121218] border border-neutral-800 p-6 rounded-2xl text-center space-y-2">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <div class="font-racing font-bold text-xs text-amber-400 uppercase mt-2">{{ $aw->year }}</div>
                    <h4 class="font-bold text-sm text-white">{{ $aw->title }}</h4>
                    <p class="text-[11px] text-neutral-400">{{ $aw->organization ?? $aw->category }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
