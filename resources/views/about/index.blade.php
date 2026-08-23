@extends('layouts.app')

@section('meta_title', 'About Us — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Interior Architecture'))
@section('meta_description', \App\Models\PageContent::get('about_who_we_are_text'))

@section('content')

    <!-- 1. Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-24 md:pt-48 md:pb-32 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">About Us</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                Metrix Interior Architecture
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-2xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        '{{ addslashes(\App\Models\PageContent::get('home_hero_title', 'We are an Award-Winning interior design firm')) }}',
                        'Over two decades of international architectural excellence.',
                        'Conceiving bespoke spatial narratives across the globe.',
                        'Elevating human experience through refined spatial geometry.'
                    ],
                    phraseIndex: 0,
                    charIndex: 0,
                    isDeleting: false,
                    typeSpeed: 50,
                    deleteSpeed: 25,
                    pauseTime: 2000,
                    init() {
                        this.type();
                    },
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
                    <span x-text="text">{{ \App\Models\PageContent::get('home_hero_title', 'We are an Award-Winning interior design firm') }}</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- 2. Who We Are & Our Mission Section -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                
                <!-- Who We Are -->
                <div class="space-y-6">
                    <div class="eyebrow text-accent font-semibold">About Company</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">
                        {{ \App\Models\PageContent::get('about_who_we_are_title', 'Who We Are') }}
                    </h2>
                    <div class="text-neutral-body text-xs md:text-sm leading-relaxed space-y-4">
                        <p>
                            {{ \App\Models\PageContent::get('about_who_we_are_text', 'Metrix Interior Architecture is an established Jakarta-based interior design consultant with over two decades of international experience.') }}
                        </p>
                        <p>
                            {{ \App\Models\PageContent::get('home_hero_description') }}
                        </p>
                    </div>
                </div>

                <!-- Our Mission -->
                <div class="space-y-6 lg:border-l lg:border-neutral-200 lg:pl-16">
                    <div class="eyebrow text-accent font-semibold">Our Philosophy</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">
                        {{ \App\Models\PageContent::get('about_mission_title', 'Our Mission') }}
                    </h2>
                    <div class="text-neutral-body text-xs md:text-sm leading-relaxed space-y-4">
                        <p>
                            {{ \App\Models\PageContent::get('about_mission_text', 'To conceive timeless, functional, and visually evocative architectural interiors that elevate human experience.') }}
                        </p>
                        <p>
                            We believe that architectural excellence thrives at the intersection of discipline, creativity, and deep understanding of human movement within physical spaces.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Skills & Competencies Progress Bars with Animated Fill -->
    <section class="py-16 md:py-20 bg-neutral-bg border-y border-neutral-200"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 200)">
        <div class="max-w-5xl mx-auto px-6 space-y-10">
            <div class="text-center space-y-2">
                <div class="eyebrow">Expertise</div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Core Competencies</h2>
            </div>

            <div class="space-y-6">
                @php
                    $skills = [
                        ['name' => 'Interior Design', 'percent' => 100],
                        ['name' => 'Furniture Design', 'percent' => 100],
                        ['name' => '3D Architectural Visualization', 'percent' => 100],
                        ['name' => 'Interior Styling & Material Curation', 'percent' => 100],
                        ['name' => 'Interior Construction Management', 'percent' => 100],
                    ];
                @endphp

                @foreach($skills as $skill)
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-semibold uppercase tracking-wider text-black">
                            <span>{{ $skill['name'] }}</span>
                            <span>{{ $skill['percent'] }}%</span>
                        </div>
                        <div class="w-full bg-neutral-200 h-2 rounded-none overflow-hidden">
                            <div class="bg-black h-2 transition-all duration-1000 ease-out" 
                                 :style="show ? 'width: {{ $skill['percent'] }}%' : 'width: 0%'"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. 5 Service Highlights / Icon Boxes -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <div class="eyebrow">What We Do</div>
                <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">Integrated Spatial Solutions</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @php
                    $highlights = [
                        ['title' => 'Retail Interior', 'desc' => 'High-impact retail flagship spaces that elevate luxury brand perception.'],
                        ['title' => 'Commercial', 'desc' => 'Modern office headquarters engineered for collaborative productivity.'],
                        ['title' => 'Restaurant & Bar', 'desc' => 'Immersive culinary atmospheres fusing acoustic, lighting, and layout harmony.'],
                        ['title' => 'Hospitality', 'desc' => 'Resort, hotel, and lounge destinations delivering five-star guest journeys.'],
                        ['title' => 'Residential', 'desc' => 'Bespoke private estates and penthouses reflecting personal elegance.'],
                    ];
                @endphp

                @foreach($highlights as $item)
                    <div class="p-8 bg-neutral-bg border border-neutral-200 hover:border-black transition-all space-y-4 flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="w-8 h-0.5 bg-black group-hover:w-16 transition-all duration-300"></div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-black">{{ $item['title'] }}</h3>
                            <p class="text-xs text-neutral-body leading-relaxed">{{ $item['desc'] }}</p>
                        </div>
                        <a href="{{ url('/services') }}" class="eyebrow text-[10px] text-black group-hover:text-accent font-semibold pt-4">
                            Learn More &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. 4 Dark Stat Blocks with Animated Counters -->
    <section class="py-16 md:py-24 bg-black text-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 text-center divide-y md:divide-y-0 md:divide-x divide-neutral-800">
                
                <!-- Stat 1 -->
                @php
                    $partRaw = \App\Models\SiteSetting::get('associate_partners', '5');
                    $partNum = (int) preg_replace('/[^0-9]/', '', $partRaw) ?: 5;
                    $partSuf = preg_replace('/[0-9,]/', '', $partRaw) ?: '';
                @endphp
                <div class="pt-4 md:pt-0 px-4 space-y-2"
                     x-data="{
                        count: 0,
                        target: {{ $partNum }},
                        suffix: '{{ $partSuf }}',
                        init() {
                            let duration = 1600;
                            let step = 25;
                            let inc = this.target / (duration / step);
                            let cur = 0;
                            let timer = setInterval(() => {
                                cur += inc;
                                if (cur >= this.target) {
                                    this.count = this.target;
                                    clearInterval(timer);
                                } else {
                                    this.count = Math.floor(cur);
                                }
                            }, step);
                        }
                     }">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        <span x-text="count.toLocaleString() + suffix">{{ $partRaw }}</span>
                    </div>
                    <div class="eyebrow-light text-[11px]">Associate Partners</div>
                </div>

                <!-- Stat 2 -->
                @php
                    $clRaw = \App\Models\SiteSetting::get('total_clients', '60+');
                    $clNum = (int) preg_replace('/[^0-9]/', '', $clRaw) ?: 60;
                    $clSuf = preg_replace('/[0-9,]/', '', $clRaw) ?: '+';
                @endphp
                <div class="pt-4 md:pt-0 px-4 space-y-2"
                     x-data="{
                        count: 0,
                        target: {{ $clNum }},
                        suffix: '{{ $clSuf }}',
                        init() {
                            let duration = 1600;
                            let step = 25;
                            let inc = this.target / (duration / step);
                            let cur = 0;
                            let timer = setInterval(() => {
                                cur += inc;
                                if (cur >= this.target) {
                                    this.count = this.target;
                                    clearInterval(timer);
                                } else {
                                    this.count = Math.floor(cur);
                                }
                            }, step);
                        }
                     }">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        <span x-text="count.toLocaleString() + suffix">{{ $clRaw }}</span>
                    </div>
                    <div class="eyebrow-light text-[11px]">Number of Clients</div>
                </div>

                <!-- Stat 3 -->
                @php
                    $tmRaw = \App\Models\SiteSetting::get('team_members_count', '60');
                    $tmNum = (int) preg_replace('/[^0-9]/', '', $tmRaw) ?: 60;
                    $tmSuf = preg_replace('/[0-9,]/', '', $tmRaw) ?: '';
                @endphp
                <div class="pt-4 md:pt-0 px-4 space-y-2"
                     x-data="{
                        count: 0,
                        target: {{ $tmNum }},
                        suffix: '{{ $tmSuf }}',
                        init() {
                            let duration = 1600;
                            let step = 25;
                            let inc = this.target / (duration / step);
                            let cur = 0;
                            let timer = setInterval(() => {
                                cur += inc;
                                if (cur >= this.target) {
                                    this.count = this.target;
                                    clearInterval(timer);
                                } else {
                                    this.count = Math.floor(cur);
                                }
                            }, step);
                        }
                     }">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        <span x-text="count.toLocaleString() + suffix">{{ $tmRaw }}</span>
                    </div>
                    <div class="eyebrow-light text-[11px]">Team Members</div>
                </div>

                <!-- Stat 4 -->
                @php
                    $dayRaw = \App\Models\SiteSetting::get('days_of_work', '9000+');
                    $dayNum = (int) preg_replace('/[^0-9]/', '', $dayRaw) ?: 9000;
                    $daySuf = preg_replace('/[0-9,]/', '', $dayRaw) ?: '+';
                @endphp
                <div class="pt-4 md:pt-0 px-4 space-y-2"
                     x-data="{
                        count: 0,
                        target: {{ $dayNum }},
                        suffix: '{{ $daySuf }}',
                        init() {
                            let duration = 1600;
                            let step = 25;
                            let inc = this.target / (duration / step);
                            let cur = 0;
                            let timer = setInterval(() => {
                                cur += inc;
                                if (cur >= this.target) {
                                    this.count = this.target;
                                    clearInterval(timer);
                                } else {
                                    this.count = Math.floor(cur);
                                }
                            }, step);
                        }
                     }">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        <span x-text="count.toLocaleString() + suffix">{{ $dayRaw }}</span>
                    </div>
                    <div class="eyebrow-light text-[11px]">Days of Dedicated Work</div>
                </div>

            </div>
        </div>
    </section>

    <!-- 6. Selected Projects (4 Cards) -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3">
                    <div class="eyebrow">Highlights</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">Selected Projects</h2>
                </div>
                <a href="{{ url('/services') }}" class="eyebrow text-black hover:text-accent font-semibold border-b border-black pb-1 inline-block">
                    View Full Portfolio &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($highlightProjects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>
        </div>
    </section>

    <!-- 7. CTA Section -->
    @include('partials.cta-section')

@endsection
