@extends('layouts.app')

@section('meta_title', \App\Models\SiteSetting::get('site_title', 'BENGKEL — Workshop Modifikasi Motor & Mobil'))
@section('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Bengkel spesialis modifikasi performa motor dan mobil, dyno tuning ECU remap, custom builder, widebody kit, cat oven Spies Hecker di Jakarta.'))

@section('content')

    <!-- 1. Hero Slider Section (Swiper Full-Screen Slides) -->
    <section class="relative bg-black text-white min-h-[85vh] lg:h-[90vh] flex items-center justify-center overflow-hidden">
        
        <!-- Swiper Container -->
        <div class="swiper heroSwiper absolute inset-0 w-full h-full z-0">
            <div class="swiper-wrapper">
                @forelse($heroSlides as $slide)
                    <div class="swiper-slide relative">
                        <img src="{{ str_starts_with($slide->image, 'http') ? $slide->image : asset('storage/' . $slide->image) }}" 
                             alt="{{ $slide->title }}" 
                             class="w-full h-full object-cover object-center filter brightness-[0.55] transition-transform duration-[7000ms] scale-100 ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/60"></div>
                    </div>
                @empty
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop" 
                             class="w-full h-full object-cover filter brightness-[0.55]">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/60"></div>
                    </div>
                @endforelse
            </div>
            
            <!-- Swiper Controls -->
            <div class="swiper-pagination !bottom-8"></div>
        </div>

        <!-- Hero Content Layer -->
        <div class="relative z-10 max-w-5xl mx-auto px-6 md:px-12 text-center space-y-6 pt-20">
            <div class="eyebrow-light tracking-widest3">
                {{ \App\Models\PageContent::get('home_hero_eyebrow', 'Performance Tuning & Custom Studio') }}
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-7xl font-bold tracking-tight text-white uppercase leading-tight font-sans">
                {{ \App\Models\PageContent::get('home_hero_title', 'Crafting High-Performance Machines') }}
            </h1>

            <!-- Typing Animated Subtitle -->
            <div class="min-h-[40px] flex items-center justify-center text-neutral-200 text-xs sm:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Spesialis ECU Remap & Dyno Run Kalibrasi Tenaga Akurat.',
                        'Custom Motorcycle Builder: Cafe Racer, Bobber & Tracker.',
                        'Widebody Kit, Carbon Aerodynamics & Cat Oven Spies Hecker.',
                        'Sistem Booking Online Terintegrasi dengan Payment Gateway.'
                    ],
                    phraseIndex: 0,
                    charIndex: 0,
                    isDeleting: false,
                    typeSpeed: 45,
                    deleteSpeed: 20,
                    pauseTime: 2200,
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
                    <span x-text="text">{{ \App\Models\PageContent::get('home_hero_subtitle', 'Spesialis modifikasi performa motor dan mobil di Jakarta.') }}</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>

            <!-- Call to Actions -->
            <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                <a href="{{ url('/booking') }}" class="btn-dark">
                    Booking Servis &amp; Modif
                </a>
                <a href="{{ url('/portfolio') }}" class="btn-outline">
                    View Portfolio
                </a>
            </div>
        </div>

    </section>


    <!-- 2. Stats Highlight Bar (Animated Count-Up) -->
    <section class="border-y border-neutral-200 bg-white py-12"
             x-data="{
                 started: false,
                 c1: 0, c2: 0, c3: 0, c4: '0.0',
                 init() {
                     let observer = new IntersectionObserver((entries) => {
                         if (entries[0].isIntersecting && !this.started) {
                             this.runCounter();
                             observer.disconnect();
                         }
                     }, { threshold: 0.25 });
                     observer.observe(this.$el);
                 },
                 runCounter() {
                     this.started = true;
                     const duration = 2200;
                     const start = performance.now();
                     const tick = (now) => {
                         const t = Math.min((now - start) / duration, 1);
                         const ease = 1 - Math.pow(1 - t, 4);
                         this.c1 = Math.floor(ease * 1450);
                         this.c2 = Math.floor(ease * 3200);
                         this.c3 = Math.floor(ease * 28);
                         this.c4 = (ease * 99.4).toFixed(1);
                         if (t < 1) requestAnimationFrame(tick);
                         else { this.c1 = 1450; this.c2 = 3200; this.c3 = 28; this.c4 = '99.4'; }
                     };
                     requestAnimationFrame(tick);
                 }
             }">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center md:text-left divide-y md:divide-y-0 md:divide-x divide-neutral-200">
                
                <div class="pt-4 md:pt-0 md:px-6 first:pt-0">
                    <div class="stat-number"><span x-text="Number(c1).toLocaleString('id-ID')">0</span>+</div>
                    <div class="eyebrow text-neutral-500 mt-1">Vehicles Tuned</div>
                </div>

                <div class="pt-4 md:pt-0 md:px-6">
                    <div class="stat-number"><span x-text="Number(c2).toLocaleString('id-ID')">0</span>+</div>
                    <div class="eyebrow text-neutral-500 mt-1">Dyno Run Tests</div>
                </div>

                <div class="pt-4 md:pt-0 md:px-6">
                    <div class="stat-number"><span x-text="c3">0</span></div>
                    <div class="eyebrow text-neutral-500 mt-1">Contest Awards</div>
                </div>

                <div class="pt-4 md:pt-0 md:px-6">
                    <div class="stat-number"><span x-text="c4">0.0</span>%</div>
                    <div class="eyebrow text-neutral-500 mt-1">Client Satisfaction</div>
                </div>

            </div>
        </div>
    </section>


    <!-- 3. What We Do / About Teaser Section -->
    <section class="py-20 md:py-28 bg-neutral-bg">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- Left Story Column -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="eyebrow text-accent font-semibold">
                        {{ \App\Models\PageContent::get('home_about_eyebrow', 'What We Do') }}
                    </div>
                    <h2 class="section-title">
                        {{ \App\Models\PageContent::get('home_about_title', 'Engineered for Performance. Crafted for Distinction.') }}
                    </h2>
                    <div class="section-desc space-y-4">
                        <p>
                            {{ \App\Models\PageContent::get('home_about_desc_1', 'BENGKEL adalah workshop modifikasi performa motor dan mobil berstandar motorsport di Jakarta. Kami menggabungkan kalibrasi data akurat mesin Dyno Jet dengan seni fabrikasi kustom tingkat tinggi.') }}
                        </p>
                        <p>
                            {{ \App\Models\PageContent::get('home_about_desc_2', 'Didukung oleh teknisi bersertifikasi dan peralatan modern, setiap proyek modifikasi dikerjakan dengan standar presisi tinggi, garansi pengerjaan, dan kemudahan booking online.') }}
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ url('/about-us') }}" class="btn-dark">
                            Discover Our Studio &rarr;
                        </a>
                    </div>
                </div>

                <!-- Right Featured Image Column -->
                <div class="lg:col-span-5">
                    <div class="aspect-[4/3] bg-neutral-900 border border-neutral-200 overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1000&auto=format&fit=crop" 
                             alt="Workshop BENGKEL" 
                             class="w-full h-full object-cover">
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- 4. Featured Services Section -->
    <section class="py-20 md:py-28 bg-white border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <div class="eyebrow text-accent font-semibold">Tuning &amp; Workshop Services</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black mt-1 uppercase">
                        Our Modification Packages
                    </h2>
                </div>
                <a href="{{ url('/services') }}" class="eyebrow text-black hover:text-accent font-semibold transition-colors">
                    View All Services &rarr;
                </a>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($popularServices->take(6) as $service)
                    <div class="group bg-white border border-neutral-200 hover:border-black transition-all flex flex-col justify-between overflow-hidden">
                        <a href="{{ url('/services/' . $service->slug) }}" class="block overflow-hidden aspect-[16/10] bg-neutral-900">
                            <img src="{{ str_starts_with($service->image, 'http') ? $service->image : asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>

                        <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="eyebrow text-[10px] text-neutral-400 capitalize">
                                    {{ $service->vehicle_type }} • {{ $service->formatted_price }}
                                </div>
                                <h3 class="text-base font-bold text-black group-hover:text-accent transition-colors">
                                    <a href="{{ url('/services/' . $service->slug) }}">
                                        {{ $service->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-neutral-body line-clamp-3 leading-relaxed">
                                    {{ $service->excerpt }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-neutral-100 flex items-center justify-between text-[10px] uppercase tracking-wider text-neutral-400">
                                <span>{{ $service->estimated_duration ?? 'Tuning Package' }}</span>
                                <span class="group-hover:text-black font-semibold transition-colors">Learn More &rarr;</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    <!-- 5. Featured Projects & Dyno Builds Section -->
    <section class="py-20 md:py-28 bg-neutral-bg border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <div class="eyebrow text-accent font-semibold">Selected Works</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black mt-1 uppercase">
                        Featured Builds &amp; Dyno Runs
                    </h2>
                </div>
                <a href="{{ url('/portfolio') }}" class="eyebrow text-black hover:text-accent font-semibold transition-colors">
                    Explore All Works &rarr;
                </a>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProjects->take(6) as $project)
                    <div class="group bg-white border border-neutral-200 hover:border-black transition-all flex flex-col justify-between overflow-hidden">
                        <a href="{{ url('/portfolio/' . $project->slug) }}" class="block overflow-hidden aspect-[16/10] bg-neutral-900">
                            <img src="{{ str_starts_with($project->cover_image, 'http') ? $project->cover_image : asset('storage/' . $project->cover_image) }}" 
                                 alt="{{ $project->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>

                        <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="eyebrow text-[10px] text-neutral-400">
                                    {{ $project->vehicle_type === 'motor' ? 'Motor Custom' : 'Mobil Performance' }} • {{ $project->year }}
                                </div>
                                <h3 class="text-base font-bold text-black group-hover:text-accent transition-colors line-clamp-2">
                                    <a href="{{ url('/portfolio/' . $project->slug) }}">
                                        {{ $project->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-neutral-body line-clamp-2 leading-relaxed">
                                    {{ $project->description }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-neutral-100 flex items-center justify-between text-[10px] uppercase tracking-wider text-neutral-400">
                                <span>{{ $project->client ?? 'Custom Build' }}</span>
                                @if($project->dyno_hp_after)
                                    <span class="font-bold text-black">{{ $project->dyno_hp_after }} HP (+{{ $project->hp_gain }} WHP)</span>
                                @else
                                    <span class="group-hover:text-black font-semibold transition-colors">View Details &rarr;</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    <!-- 6. Our Blog / Latest Articles Section -->
    <section class="py-20 md:py-28 bg-white border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <div class="eyebrow text-accent font-semibold">News &amp; Perspectives</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black mt-1 uppercase">
                        From Our Blog
                    </h2>
                </div>
                <a href="{{ url('/our-blog') }}" class="eyebrow text-black hover:text-accent font-semibold transition-colors">
                    Read All Articles &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php $blogItems = $recentPosts ?? $latestPosts ?? collect(); @endphp
                @forelse($blogItems as $post)
                    <article class="group bg-white border border-neutral-200 flex flex-col justify-between overflow-hidden hover:border-black transition-all">
                        <a href="{{ url('/our-blog/' . $post->slug) }}" class="block overflow-hidden aspect-[16/10] bg-neutral-900">
                            <img src="{{ $post->cover_image ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image)) : 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=800&auto=format&fit=crop' }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>

                        <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                @if($post->category)
                                    <div class="eyebrow text-[10px] text-accent font-semibold">
                                        {{ $post->category->title }}
                                    </div>
                                @endif
                                <h3 class="text-base font-bold text-black group-hover:text-accent transition-colors line-clamp-2">
                                    <a href="{{ url('/our-blog/' . $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                @if($post->excerpt)
                                    <p class="text-xs text-neutral-body line-clamp-3 leading-relaxed">
                                        {{ $post->excerpt }}
                                    </p>
                                @endif
                            </div>
                            <div class="pt-4 border-t border-neutral-100 flex items-center justify-between text-[10px] uppercase tracking-wider text-neutral-400">
                                <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                <span class="group-hover:text-black font-semibold transition-colors">Read Article &rarr;</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-12 text-neutral-400 text-sm">
                        No articles published yet.
                    </div>
                @endforelse
            </div>

        </div>
    </section>


    <!-- 7. Partner & Client Brands Running Marquee -->
    <section class="py-20 md:py-28 bg-white border-t border-neutral-200 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase">
                    {{ \App\Models\PageContent::get('home_clients_eyebrow', 'Official Performance Partners') }}
                </h2>
                <div class="w-12 h-0.5 bg-black mx-auto"></div>
            </div>

            <!-- Running Marquee Track -->
            <div class="relative w-full overflow-hidden mask-marquee py-4">
                @if($clients->count() > 0)
                    <div class="animate-marquee flex items-center gap-8 md:gap-12">
                        
                        @foreach($clients as $client)
                            <div class="flex-shrink-0 flex items-center justify-center p-4 h-20 w-44 md:w-52 border border-neutral-100 hover:border-neutral-400 bg-white transition-all shadow-sm group">
                                @if($client->logo)
                                    <img src="{{ str_starts_with($client->logo, 'http') ? $client->logo : asset('storage/' . $client->logo) }}" 
                                         alt="{{ $client->name }}" 
                                         title="{{ $client->name }}"
                                         loading="lazy"
                                         class="max-h-10 max-w-full object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                                @else
                                    <span class="text-xs font-bold tracking-wider text-neutral-600 uppercase group-hover:text-black">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach

                        @foreach($clients as $client)
                            <div class="flex-shrink-0 flex items-center justify-center p-4 h-20 w-44 md:w-52 border border-neutral-100 hover:border-neutral-400 bg-white transition-all shadow-sm group">
                                @if($client->logo)
                                    <img src="{{ str_starts_with($client->logo, 'http') ? $client->logo : asset('storage/' . $client->logo) }}" 
                                         alt="{{ $client->name }}" 
                                         title="{{ $client->name }}"
                                         loading="lazy"
                                         class="max-h-10 max-w-full object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                                @else
                                    <span class="text-xs font-bold tracking-wider text-neutral-600 uppercase group-hover:text-black">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>

            <div class="text-center pt-4">
                <a href="{{ url('/clients') }}" class="eyebrow text-black hover:text-accent font-semibold border-b border-black pb-1 inline-block">
                    View Complete Partner Roster &rarr;
                </a>
            </div>

        </div>
    </section>


    <!-- 8. Testimonials Section -->
    @if(isset($testimonials) && $testimonials->count())
        <section class="py-20 md:py-28 bg-neutral-bg border-t border-neutral-200">
            <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-16">
                
                <div class="text-center space-y-3 max-w-2xl mx-auto">
                    <div class="eyebrow text-accent font-semibold">Client Endorsements</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black uppercase">
                        What Enthusiasts Say
                    </h2>
                    <div class="w-12 h-0.5 bg-black mx-auto"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($testimonials as $testi)
                        <div class="bg-white border border-neutral-200 p-8 flex flex-col justify-between space-y-6 hover:border-black transition-all group shadow-sm">
                            <div class="space-y-4">
                                <div class="flex items-center gap-1 text-amber-500 text-xs">
                                    @for($i = 0; $i < ($testi->rating ?? 5); $i++)
                                        <span>&#9733;</span>
                                    @endfor
                                </div>
                                <p class="text-neutral-700 text-xs md:text-sm leading-relaxed italic">
                                    &ldquo;{{ $testi->message }}&rdquo;
                                </p>
                            </div>

                            <div class="pt-4 border-t border-neutral-100 flex items-center gap-4">
                                @if($testi->photo)
                                    <img src="{{ str_starts_with($testi->photo, 'http') ? $testi->photo : asset('storage/' . $testi->photo) }}" 
                                         alt="{{ $testi->client_name }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-neutral-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center font-bold text-xs">
                                        {{ substr($testi->client_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs font-bold text-black uppercase tracking-wider">{{ $testi->client_name }}</div>
                                    @if($testi->client_company)
                                        <div class="text-[11px] text-neutral-500">{{ $testi->client_company }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    <!-- 9. CTA Section -->
    @include('partials.cta-section')

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
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            speed: 1000,
        });
    });
</script>
@endpush
