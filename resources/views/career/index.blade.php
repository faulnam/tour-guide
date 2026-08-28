@extends('layouts.app')

@section('meta_title', 'Career & Team — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', 'Bergabunglah bersama tim bengkel modifikasi, master tuner, custom motorcycle builder, dan teknisi cat profesional di Jakarta.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Join The Tuning &amp; Custom Crew</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Karir &amp; Tim
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Kembangkan potensi Anda bersama tim modifikasi performa terdepan.',
                        'Kami mencari Master Tuner, Mekanik Balap, dan Custom Fabricator berbakat.',
                        'Fasilitas dyno modern, spray booth oven, dan standar motorsport internasional.',
                        'Eksplorasi lowongan kerja teknisi dan workshop engineer di bawah ini.'
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
                    <span x-text="text">Bergabunglah bersama workshop modifikasi motor & mobil terkemuka di Jakarta.</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Workshop Culture Section -->
    <section class="py-20 md:py-24 bg-white border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                
                <div class="space-y-4">
                    <div class="eyebrow text-accent font-semibold">Workshop Life</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">
                        {{ \App\Models\PageContent::get('about_who_we_are_title', 'Siapa Kami') }}
                    </h2>
                    <p class="text-neutral-body text-xs md:text-sm leading-relaxed">
                        {{ \App\Models\PageContent::get('career_who_we_are', 'Di BENGKEL, kami mengedepankan lingkungan kerja yang profesional, presisi tinggi, dan budaya continuous learning dalam teknologi otomotif terkini.') }}
                    </p>
                </div>

                <div class="space-y-4 lg:border-l lg:border-neutral-200 lg:pl-16">
                    <div class="eyebrow text-accent font-semibold">Our Culture</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">
                        {{ \App\Models\PageContent::get('about_mission_title', 'Misi Tim Kami') }}
                    </h2>
                    <p class="text-neutral-body text-xs md:text-sm leading-relaxed">
                        {{ \App\Models\PageContent::get('career_mission', 'Mencetak mahakarya modifikasi motor & mobil dengan standar keselamatan prima dan lonjakan performa yang teruji secara transparan.') }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Job Openings Section (Accordion with Alpine.js) -->
    <section class="py-20 md:py-28 bg-neutral-bg">
        <div class="max-w-5xl mx-auto px-6 space-y-12">
            
            <div class="text-center space-y-3">
                <div class="eyebrow text-accent font-semibold">Lowongan Tersedia</div>
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-black uppercase font-sans">
                    {{ \App\Models\PageContent::get('career_intro_title', 'Posisi Yang Dibutuhkan') }}
                </h2>
                <p class="text-neutral-body text-xs md:text-sm max-w-xl mx-auto">
                    Klik pada posisi di bawah untuk melihat rincian tanggung jawab, kualifikasi, dan cara pengiriman portofolio/CV.
                </p>
            </div>

            <!-- Vacancies Accordion List -->
            <div class="space-y-4" x-data="{ activeAccordion: 0 }">
                @forelse($vacancies as $index => $vacancy)
                    <div class="bg-white border border-neutral-200 overflow-hidden transition-all duration-200 hover:border-black">
                        
                        <!-- Accordion Header -->
                        <button @click="activeAccordion = (activeAccordion === {{ $index }} ? null : {{ $index }})" 
                                class="w-full p-6 md:p-8 flex items-center justify-between text-left focus:outline-none">
                            <div>
                                <h3 class="text-base md:text-lg font-bold text-black uppercase tracking-wide">
                                    {{ $vacancy->title }}
                                </h3>
                                <div class="flex items-center gap-4 mt-2 text-[11px] uppercase tracking-wider text-neutral-400">
                                    <span>Jakarta, Indonesia</span>
                                    <span>&bull;</span>
                                    <span>Full Time</span>
                                    @if($vacancy->posted_at)
                                        <span>&bull;</span>
                                        <span>Diposting {{ $vacancy->posted_at->format('d M Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-8 h-8 rounded-full border border-neutral-300 flex items-center justify-center text-black ml-4 shrink-0 transition-transform duration-300"
                                 :class="activeAccordion === {{ $index }} ? 'rotate-180 bg-black text-white border-black' : ''">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>

                        <!-- Accordion Content Body -->
                        <div x-show="activeAccordion === {{ $index }}" 
                             x-collapse 
                             x-cloak 
                             class="px-6 md:px-8 pb-8 pt-2 border-t border-neutral-100 space-y-6">
                            
                            @if($vacancy->responsibilities)
                                <div class="space-y-3">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-black">Tanggung Jawab Utama:</h4>
                                    <ul class="list-disc list-inside space-y-1.5 text-xs text-neutral-body leading-relaxed">
                                        @foreach(explode("\n", $vacancy->responsibilities) as $resp)
                                            @if(trim($resp))
                                                <li>{{ trim($resp) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if($vacancy->requirements)
                                <div class="space-y-3">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-black">Persyaratan &amp; Kualifikasi:</h4>
                                    <ul class="list-disc list-inside space-y-1.5 text-xs text-neutral-body leading-relaxed">
                                        @foreach(explode("\n", $vacancy->requirements) as $req)
                                            @if(trim($req))
                                                <li>{{ trim($req) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @php
                                $hrEmail = \App\Models\SiteSetting::get('company_email_hr', 'hrd@bengkelmodifikasi.id');
                                $subject = urlencode($vacancy->email_subject ?: 'Lamaran Posisi ' . $vacancy->title . ' - [Nama Anda]');
                                $mailto = "mailto:{$hrEmail}?subject={$subject}&body=Halo%20Tim%20HRD%20BENGKEL,%0A%0ASaya%20bermaksud%20mengajukan%20lamaran%20untuk%20posisi%20" . urlencode($vacancy->title) . ".%20Terlampir%20CV%20dan%20Portofolio%20saya.";
                            @endphp

                            <div class="pt-4 flex items-center justify-between flex-wrap gap-4 border-t border-neutral-100">
                                <span class="text-xs text-neutral-400">Kirim CV &amp; portofolio pengerjaan Anda (PDF max 10MB)</span>
                                <a href="{{ $mailto }}" class="btn-dark">
                                    Kirim Lamaran &rarr;
                                </a>
                            </div>

                        </div>

                    </div>
                @empty
                    <div class="bg-white p-12 text-center text-neutral-400 text-sm border border-neutral-200">
                        Saat ini belum ada lowongan terbuka. Silakan kirimkan CV dan portofolio Anda ke 
                        <a href="mailto:{{ \App\Models\SiteSetting::get('company_email_hr', 'hrd@bengkelmodifikasi.id') }}" class="text-black font-semibold underline">
                            {{ \App\Models\SiteSetting::get('company_email_hr', 'hrd@bengkelmodifikasi.id') }}
                        </a>.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
