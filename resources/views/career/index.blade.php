@extends('layouts.app')

@section('meta_title', 'Karir & Tim Pemandu Wisata — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Bergabunglah bersama komunitas pemandu wisata berlisensi resmi HPI, trip leader ekspedisi alam, dan konsultan pariwisata Indonesia.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                Karir &amp; Pemandu Wisata
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-gray-200 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Kembangkan karir kepemanduan Anda bersama platform pemandu wisata resmi Indonesia.',
                        'Kami membuka peluang bagi Tour Guide HPI, Pendaki Gunung APGI, dan Dive Master.',
                        'Sistem penugasan fleksibel, perlindungan asuransi penuh, dan kompensasi kompetitif.',
                        'Eksplorasi lowongan pemandu dan staf pariwisata di bawah ini.'
                    ],
                    phraseIndex: 0,
                    charIndex: 0,
                    isDeleting: false,
                    typeSpeed: 50,
                    deleteSpeed: 25,
                    pauseTime: 2000,
                    init() { this.type(); },
                    type() {
                        const current = this.phrases[this.phraseIndex];
                        if (this.isDeleting) {
                            this.text = current.substring(0, this.charIndex - 1);
                            this.charIndex--;
                        } else {
                            this.text = current.substring(0, this.charIndex + 1);
                            this.charIndex++;
                        }
                        let speed = this.isDeleting ? this.deleteSpeed : this.typeSpeed;
                        if (!this.isDeleting && this.charIndex === current.length) {
                            speed = this.pauseTime;
                            this.isDeleting = true;
                        } else if (this.isDeleting && this.charIndex === 0) {
                            this.isDeleting = false;
                            this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
                            speed = 350;
                        }
                        setTimeout(() => this.type(), speed);
                    }
                 }">
                <p class="leading-relaxed">
                    <span x-text="text">Bergabunglah bersama komunitas pemandu wisata terbaik di Indonesia.</span><span class="inline-block w-0.5 h-4 bg-accent ml-1 align-middle animate-pulse"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Culture Section -->
    <section class="py-20 md:py-24 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                
                <div class="space-y-4">
                    <div class="eyebrow text-sage font-bold">Kultur &amp; Nilai Kami</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                        {{ \App\Models\PageContent::get('about_who_we_are_title', 'Komunitas Guide Profesional') }}
                    </h2>
                    <p class="text-gray-600 text-xs md:text-sm leading-relaxed">
                        {{ \App\Models\PageContent::get('career_who_we_are', 'Di Nusantara Tour Guide, kami mengedepankan keramahan budaya lokal, etika konservasi alam, dan keselamatan perjalanan berstandar internasional.') }}
                    </p>
                </div>

                <div class="space-y-4 lg:border-l lg:border-gray-100 lg:pl-16">
                    <div class="eyebrow text-sage font-bold">Misi Kebanggaan</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                        {{ \App\Models\PageContent::get('about_mission_title', 'Misi Edukasi Budaya') }}
                    </h2>
                    <p class="text-gray-600 text-xs md:text-sm leading-relaxed">
                        {{ \App\Models\PageContent::get('career_mission', 'Menjadi duta terbaik pariwisata Indonesia yang memperkenalkan kearifan lokal Nusantara kepada wisatawan nusantara maupun mancanegara.') }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Job Openings Section (Accordion with Alpine.js) -->
    <section class="py-20 md:py-28 bg-[#F8FAF9]">
        <div class="max-w-5xl mx-auto px-6 space-y-12">
            
            <div class="text-center space-y-3">
                <div class="eyebrow text-sage font-bold">Peluang Karir Terbuka</div>
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-primary uppercase font-sans">
                    {{ \App\Models\PageContent::get('career_intro_title', 'Posisi Yang Sedang Dibutuhkan') }}
                </h2>
                <p class="text-gray-600 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                    {{ \App\Models\PageContent::get('career_intro_description', 'Kirimkan profil lisensi kepemanduan dan portofolio perjalanan Anda ke tim rekrutmen kami.') }}
                </p>
            </div>

            <!-- Accordion List of Vacancies -->
            <div class="space-y-4" x-data="{ activeAccordion: null }">
                @forelse($vacancies as $index => $vacancy)
                    <div class="tour-card overflow-hidden bg-white">
                        <button type="button" 
                                @click="activeAccordion = (activeAccordion === {{ $index }} ? null : {{ $index }})"
                                class="w-full p-6 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="space-y-1">
                                <span class="text-[10px] uppercase tracking-wider font-bold text-sage">
                                    {{ $vacancy->department ?? 'Operasional Pemandu Wisata' }} &bull; {{ $vacancy->type ?? 'Full Time / Per Event' }}
                                </span>
                                <h3 class="text-lg font-bold text-primary uppercase">
                                    {{ $vacancy->title }}
                                </h3>
                                <div class="text-xs text-gray-500 flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-accent text-xs"></i>
                                    <span>{{ $vacancy->location ?? 'Bali / Seluruh Indonesia' }}</span>
                                </div>
                            </div>

                            <span class="text-primary text-sm transition-transform duration-300 ml-4"
                                  :class="activeAccordion === {{ $index }} ? 'rotate-180' : ''">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </button>

                        <div x-show="activeAccordion === {{ $index }}" x-collapse x-cloak class="p-6 pt-0 border-t border-gray-100 text-xs text-gray-700 space-y-6">
                            @if($vacancy->description)
                                <div class="space-y-2 pt-4">
                                    <h4 class="font-bold uppercase tracking-wider text-primary text-[11px]">Deskripsi Peran:</h4>
                                    <div class="leading-relaxed text-gray-600 space-y-2">
                                        {!! nl2br(e($vacancy->description)) !!}
                                    </div>
                                </div>
                            @endif

                            @if($vacancy->requirements)
                                <div class="space-y-2">
                                    <h4 class="font-bold uppercase tracking-wider text-primary text-[11px]">Kualifikasi &amp; Persyaratan:</h4>
                                    <div class="leading-relaxed text-gray-600 space-y-2">
                                        {!! nl2br(e($vacancy->requirements)) !!}
                                    </div>
                                </div>
                            @endif

                            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="text-[11px] text-gray-500">
                                    Kirim CV, salinan KTP, &amp; sertifikat HPI ke: 
                                    <a href="mailto:{{ \App\Models\SiteSetting::get('career_email', 'karir@tourguide.id') }}" class="font-bold text-primary underline">
                                        {{ \App\Models\SiteSetting::get('career_email', 'karir@tourguide.id') }}
                                    </a>
                                </div>
                                @php
                                    $hrEmail = \App\Models\SiteSetting::get('career_email', 'karir@tourguide.id');
                                    $subject = rawurlencode('Lamaran Pemandu Wisata: ' . $vacancy->title);
                                    $mailto = "mailto:{$hrEmail}?subject={$subject}&body=Halo%20Tim%20Rekrutmen%20Nusantara%20Tour%20Guide,%0A%0ASaya%20bermaksud%20mengajukan%20lamaran%20untuk%20posisi%20" . urlencode($vacancy->title) . ".%20Terlampir%20CV,%20Portofolio,%20dan%20Lisensi%20HPI%20saya.";
                                @endphp
                                <a href="{{ $mailto }}" class="btn-primary w-full sm:w-auto text-center shadow-sm">
                                    Lamar Posisi Ini &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Default vacancies if none seeded in DB -->
                    <div class="tour-card p-8 bg-white space-y-4 text-center">
                        <div class="text-2xl text-sage"><i class="fa-solid fa-id-card-clip"></i></div>
                        <h3 class="text-base font-bold uppercase tracking-wider text-primary">Pemandu Wisata Berlisensi HPI (Seluruh Indonesia)</h3>
                        <p class="text-xs text-gray-600 max-w-xl mx-auto leading-relaxed">
                            Kami selalu terbuka bagi pemandu wisata lokal berlisensi HPI/APGI di Bali, Yogyakarta, Labuan Bajo, Raja Ampat, Bromo-Ijen, Toraja, Derawan, dan Belitung.
                        </p>
                        <a href="mailto:{{ \App\Models\SiteSetting::get('career_email', 'karir@tourguide.id') }}" class="btn-primary inline-flex items-center gap-2 shadow-md">
                            <i class="fa-regular fa-envelope text-xs"></i>
                            <span>Kirimkan Profil Pemandu Anda &rarr;</span>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- General Application Note -->
            <div class="tour-card p-8 bg-white text-center space-y-4 border border-sage/30">
                <h3 class="text-lg font-bold uppercase tracking-wider text-primary">Tidak Menemukan Wilayah Pemanduan Anda?</h3>
                <p class="text-xs text-gray-600 max-w-xl mx-auto leading-relaxed">
                    Kami selalu membuka pintu kemitraan bagi pemandu wisata dan agen lokal di seluruh penjuru Indonesia. Kirimkan CV dan lisensi Anda ke 
                    <a href="mailto:{{ \App\Models\SiteSetting::get('career_email', 'karir@tourguide.id') }}" class="text-primary font-bold underline">
                        {{ \App\Models\SiteSetting::get('career_email', 'karir@tourguide.id') }}
                    </a>.
                </p>
            </div>

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
