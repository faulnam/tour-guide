@extends('layouts.app')

@section('meta_title', 'Career — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Interior Architecture'))
@section('meta_description', 'Join our creative studio in Jakarta. Explore career opportunities in interior design, architecture, and 3D visualization.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Join The Studio</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                Career
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        '{{ addslashes(\App\Models\PageContent::get('career_intro_subtitle', 'We are looking for passionate architects and designers to join our studio.')) }}',
                        'Shape the future of luxury interior architecture with us.',
                        'Cultivating curiosity, creativity, and bespoke craftsmanship.',
                        'Explore our open opportunities in design, 3D art, and management.'
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
                    <span x-text="text">{{ \App\Models\PageContent::get('career_intro_subtitle', 'We are always looking for passionate architects, designers, 3D visualizers, and project managers to join our dynamic studio in Jakarta.') }}</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Company Culture / Who We Are & Mission Section -->
    <section class="py-20 md:py-24 bg-white border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                
                <div class="space-y-4">
                    <div class="eyebrow text-accent font-semibold">Studio Life</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">
                        {{ \App\Models\PageContent::get('about_who_we_are_title', 'Who We Are') }}
                    </h2>
                    <p class="text-neutral-body text-xs md:text-sm leading-relaxed">
                        {{ \App\Models\PageContent::get('career_who_we_are', 'At Metrix, we cultivate a vibrant team culture fueled by curiosity, creativity, and dedication to excellence.') }}
                    </p>
                </div>

                <div class="space-y-4 lg:border-l lg:border-neutral-200 lg:pl-16">
                    <div class="eyebrow text-accent font-semibold">Our Culture</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">
                        {{ \App\Models\PageContent::get('about_mission_title', 'Our Mission') }}
                    </h2>
                    <p class="text-neutral-body text-xs md:text-sm leading-relaxed">
                        {{ \App\Models\PageContent::get('career_mission', 'We welcome passionate minds who seek to redefine boundaries in interior architecture and experiential design.') }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Job Openings Section (Accordion with Alpine.js) -->
    <section class="py-20 md:py-28 bg-neutral-bg">
        <div class="max-w-5xl mx-auto px-6 space-y-12">
            
            <div class="text-center space-y-3">
                <div class="eyebrow text-accent font-semibold">Open Positions</div>
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-black">
                    {{ \App\Models\PageContent::get('career_intro_title', 'Join The Crew') }}
                </h2>
                <p class="text-neutral-body text-xs md:text-sm max-w-xl mx-auto">
                    Explore our available roles below. Click on any opening to view details, responsibilities, and application requirements.
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
                                        <span>Posted {{ $vacancy->posted_at->format('M d, Y') }}</span>
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
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-black">Key Responsibilities:</h4>
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
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-black">Requirements &amp; Qualifications:</h4>
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
                                $hrEmail = \App\Models\SiteSetting::get('company_email_hr', 'hrd1@the-metrix.com');
                                $subject = urlencode($vacancy->email_subject ?: 'Application for ' . $vacancy->title . ' - [Your Name]');
                                $mailto = "mailto:{$hrEmail}?subject={$subject}&body=Dear%20Metrix%20Recruitment%20Team,%0A%0APlease%20find%20attached%20my%20CV%20and%20portfolio%20for%20the%20position%20of%20" . urlencode($vacancy->title) . ".";
                            @endphp

                            <div class="pt-4 flex items-center justify-between flex-wrap gap-4 border-t border-neutral-100">
                                <span class="text-xs text-neutral-400">Send your resume and portfolio (max 10MB PDF)</span>
                                <a href="{{ $mailto }}" class="btn-dark">
                                    Apply Now &rarr;
                                </a>
                            </div>

                        </div>

                    </div>
                @empty
                    <div class="bg-white p-12 text-center text-neutral-400 text-sm border border-neutral-200">
                        There are currently no active job vacancies. Feel free to send your open portfolio to 
                        <a href="mailto:{{ \App\Models\SiteSetting::get('company_email_hr', 'hrd1@the-metrix.com') }}" class="text-black font-semibold underline">
                            {{ \App\Models\SiteSetting::get('company_email_hr', 'hrd1@the-metrix.com') }}
                        </a>.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
