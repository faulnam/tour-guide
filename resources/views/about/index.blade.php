@extends('layouts.app')

@section('meta_title', 'About Us & Workshop Studio — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Garage'))
@section('meta_description', 'About Metrix Garage, our engineering philosophy, dyno tuning equipment, and expert certified master technicians.')

@section('content')

    <!-- 1. Hero Header Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Precision Engineering &amp; Custom Studio</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                About Metrix
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Dedicated to exceptional automotive performance, custom bike craftsmanship, and state-of-the-art dyno tuning calibration.
            </p>
        </div>
    </section>

    <!-- 2. Heritage / Story Section -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <div class="lg:col-span-6 space-y-6">
                    <div class="eyebrow text-accent font-semibold">Our Philosophy</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black leading-tight uppercase font-sans">
                        Engineering Precision Without Compromise
                    </h2>
                    <div class="text-neutral-700 text-sm md:text-base space-y-4 leading-relaxed">
                        <p>
                            Metrix Garage lahir dari passion mendalam terhadap performa motorsport dan estetika kendaraan kustom. Kami percaya bahwa setiap motor dan mobil memiliki potensi maksimal yang dapat dieksplorasi melalui kalibrasi data akurat dan ketelitian craftsmanship.
                        </p>
                        <p>
                            Mulai dari dyno tuning ECU remap, custom motorcycle fabrication, widebody aerokit, hingga pengecatan oven Spies Hecker, seluruh proses dikerjakan oleh teknisi bersertifikasi dengan jaminan kualitas dan transparansi pengerjaan.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <div class="aspect-[4/3] bg-neutral-900 border border-neutral-200 overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?q=80&w=1000&auto=format&fit=crop" 
                             alt="Metrix Workshop" 
                             class="w-full h-full object-cover">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Facilities & Modern Equipment -->
    <section class="py-20 md:py-28 bg-neutral-bg border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-16">
            
            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <div class="eyebrow text-accent font-semibold">State-of-the-Art Facilities</div>
                <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black uppercase font-sans">
                    Workshop &amp; Testing Rig
                </h2>
                <div class="w-12 h-0.5 bg-black mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white border border-neutral-200 p-8 space-y-4 shadow-sm hover:border-black transition-colors">
                    <div class="eyebrow text-[10px] text-accent font-semibold">Testing Facility</div>
                    <h3 class="text-lg font-bold text-black uppercase">Dyno Jet 224xLC Chassis Dyno</h3>
                    <p class="text-xs text-neutral-body leading-relaxed">
                        Mampu menguji hingga 2,000 HP dengan dual high-velocity blower cooling untuk kalibrasi daya kuda, torsi, dan AFR secara akurat.
                    </p>
                </div>

                <div class="bg-white border border-neutral-200 p-8 space-y-4 shadow-sm hover:border-black transition-colors">
                    <div class="eyebrow text-[10px] text-accent font-semibold">Refinishing Booth</div>
                    <h3 class="text-lg font-bold text-black uppercase">Down-Draft Spray Oven</h3>
                    <p class="text-xs text-neutral-body leading-relaxed">
                        Ruang cat oven bertekanan positif dengan cat premium Spies Hecker bergaransi 2 tahun, bebas debu dan menghasilkan kilau wet-look sempurna.
                    </p>
                </div>

                <div class="bg-white border border-neutral-200 p-8 space-y-4 shadow-sm hover:border-black transition-colors">
                    <div class="eyebrow text-[10px] text-accent font-semibold">Custom Rig</div>
                    <h3 class="text-lg font-bold text-black uppercase">TIG &amp; Tube Bending Machine</h3>
                    <p class="text-xs text-neutral-body leading-relaxed">
                        Peralatan bending mandrel presisi untuk pembuatan rangka motor custom Cafe Racer, Bobber, dan knalpot titanium kustom.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. Stats Counter Bar -->
    <section class="py-16 md:py-24 bg-black text-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 text-center divide-y md:divide-y-0 md:divide-x divide-neutral-800">
                
                <div class="pt-4 md:pt-0 px-4 space-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">1,450+</div>
                    <div class="eyebrow-light text-[11px]">Vehicles Tuned</div>
                </div>

                <div class="pt-4 md:pt-0 px-4 space-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">3,200+</div>
                    <div class="eyebrow-light text-[11px]">Dyno Runs</div>
                </div>

                <div class="pt-4 md:pt-0 px-4 space-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">28</div>
                    <div class="eyebrow-light text-[11px]">Contest Trophies</div>
                </div>

                <div class="pt-4 md:pt-0 px-4 space-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">99.4%</div>
                    <div class="eyebrow-light text-[11px]">Client Satisfaction</div>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. CTA Section -->
    @include('partials.cta-section')

@endsection
