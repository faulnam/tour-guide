@extends('layouts.app')

@section('meta_title', \App\Models\SiteSetting::get('site_title', 'Nusantara Tour Guide — Pemandu Wisata Resmi Berlisensi HPI'))
@section('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Layanan pemandu wisata privat berlisensi resmi HPI di seluruh destinasi Indonesia: Bali, Raja Ampat, Labuan Bajo, Bromo, Yogyakarta, dan Tana Toraja.'))

@section('content')

    <!-- 1. Hero Slider Section (Swiper Full-Screen Slides) -->
    <section class="relative bg-primary-dark text-white min-h-[68vh] lg:h-[76vh] flex items-center justify-center overflow-hidden">
        
        <!-- Swiper Container -->
        <div class="swiper heroSwiper absolute inset-0 w-full h-full z-0">
            <div class="swiper-wrapper">
                @forelse($heroSlides as $slide)
                    <div class="swiper-slide relative">
                        <img src="{{ str_starts_with($slide->image, 'http') ? $slide->image : asset('storage/' . $slide->image) }}" 
                             alt="{{ $slide->title }}" 
                             class="w-full h-full object-cover object-center filter brightness-[0.55] transition-transform duration-[7000ms] scale-100 ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/95 via-primary-dark/40 to-primary-dark/50"></div>
                    </div>
                @empty
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop" 
                             class="w-full h-full object-cover filter brightness-[0.55]">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/95 via-primary-dark/40 to-primary-dark/50"></div>
                    </div>
                @endforelse
            </div>
            
            <!-- Swiper Controls -->
            <div class="swiper-pagination !bottom-6"></div>
        </div>

        <!-- Hero Content Layer -->
        <div class="relative z-10 max-w-4xl mx-auto px-5 md:px-8 text-center space-y-4 pt-16">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight text-white uppercase leading-snug font-sans max-w-3xl mx-auto">
                {{ \App\Models\PageContent::get('home_hero_title', 'Jelajahi Keajaiban Nusantara Bersama Pemandu Resmi') }}
            </h1>

            <!-- Typing Animated Subtitle -->
            <div class="min-h-[36px] flex items-center justify-center text-neutral-200 text-xs sm:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Pemandu Lokal Berlisensi Resmi HPI di 34 Provinsi Indonesia.',
                        'Ekspedisi Bahari Raja Ampat, Komodo & Liveaboard Phinisi.',
                        'Petualangan Sunrise Gunung Bromo & Blue Fire Kawah Ijen.',
                        'Wisata Budaya Sakral Ubud Bali & Warisan Megalitik Tana Toraja.'
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
                <p class="leading-relaxed font-medium">
                    <span x-text="text">{{ \App\Models\PageContent::get('home_hero_subtitle', 'Layanan pemandu wisata privat & ekspedisi alam terbaik di seluruh Indonesia.') }}</span><span class="inline-block w-0.5 h-3.5 bg-accent ml-1 align-middle animate-cursor"></span>
                </p>
            </div>

            <!-- Call to Actions -->
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <a href="{{ url('/booking') }}" class="px-6 py-2.5 rounded-lg bg-accent hover:bg-accent-dark text-primary-dark hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-xs"></i>
                    <span>Booking Pemandu Wisata</span>
                </a>
                <a href="{{ url('/portfolio') }}" class="px-6 py-2.5 rounded-lg bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white font-semibold text-xs uppercase tracking-wider transition-all flex items-center gap-2">
                    <i class="fa-solid fa-compass text-xs"></i>
                    <span>Lihat Destinasi</span>
                </a>
            </div>
        </div>

    </section>


    <!-- 2. Stats Highlight Bar (Animated Count-Up) -->
    <section class="border-y border-gray-100 bg-white py-8 sm:py-10"
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
                         this.c1 = Math.floor(ease * 2850);
                         this.c2 = Math.floor(ease * 120);
                         this.c3 = Math.floor(ease * 34);
                         this.c4 = (ease * 99.8).toFixed(1);
                         if (t < 1) requestAnimationFrame(tick);
                         else { this.c1 = 2850; this.c2 = 120; this.c3 = 34; this.c4 = '99.8'; }
                     };
                     requestAnimationFrame(tick);
                 }
             }">
        <div class="max-w-7xl mx-auto px-5 md:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left divide-y md:divide-y-0 md:divide-x divide-gray-100">
                
                <div class="pt-3 md:pt-0 md:px-5 first:pt-0">
                    <div class="text-2xl sm:text-3xl font-bold text-primary"><span x-text="Number(c1).toLocaleString('id-ID')">0</span>+</div>
                    <div class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold mt-1">Wisatawan Dipandu</div>
                </div>

                <div class="pt-3 md:pt-0 md:px-5">
                    <div class="text-2xl sm:text-3xl font-bold text-primary"><span x-text="Number(c2).toLocaleString('id-ID')">0</span>+</div>
                    <div class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold mt-1">Pemandu Berlisensi HPI</div>
                </div>

                <div class="pt-3 md:pt-0 md:px-5">
                    <div class="text-2xl sm:text-3xl font-bold text-primary"><span x-text="c3">0</span></div>
                    <div class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold mt-1">Provinsi Terjangkau</div>
                </div>

                <div class="pt-3 md:pt-0 md:px-5">
                    <div class="text-2xl sm:text-3xl font-bold text-primary"><span x-text="c4">0.0</span>%</div>
                    <div class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold mt-1">Tingkat Kepuasan</div>
                </div>

            </div>
        </div>
    </section>


    <!-- 3. What We Do / About Teaser Section -->
    <section class="py-14 md:py-20 bg-[#F8FAF9]">
        <div class="max-w-7xl mx-auto px-5 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Story Column -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="text-xs uppercase tracking-wider text-sage font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-map-pin text-accent"></i>
                        <span>{{ \App\Models\PageContent::get('home_about_eyebrow', 'Tentang Nusantara Tour Guide') }}</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-primary leading-snug">
                        {{ \App\Models\PageContent::get('home_about_title', 'Menghubungkan Anda dengan Keindahan Autentik Nusantara') }}
                    </h2>
                    <div class="text-xs sm:text-sm space-y-3 text-gray-600 leading-relaxed">
                        <p>
                            {{ \App\Models\PageContent::get('home_about_desc_1', 'Nusantara Tour Guide adalah platform pemandu wisata privat dan ekspedisi alam nomor satu di Indonesia. Kami menghadirkan putra daerah asli bersertifikasi HPI (Himpunan Pramuwisata Indonesia) dan APGI untuk mendampingi liburan Anda dengan aman, nyaman, dan berwawasan luas.') }}
                        </p>
                        <p>
                            {{ \App\Models\PageContent::get('home_about_desc_2', 'Setiap ekspedisi dirancang dengan fleksibilitas tinggi, armada transportasi ber-AC terawat, perlengkapan keselamatan standar, serta kemudahan sistem booking online dengan down payment praktis.') }}
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ url('/about-us') }}" class="btn-primary flex items-center gap-2 inline-flex text-xs px-5 py-2.5">
                            <span>Pelajari Standar Layanan Kami</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Featured Image Column -->
                <div class="lg:col-span-5">
                    <div class="aspect-[4/3] rounded-2xl bg-neutral-900 border border-gray-100 overflow-hidden shadow-elevated">
                        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1000&auto=format&fit=crop" 
                             alt="Pemandu Wisata Bali & Indonesia" 
                             class="w-full h-full object-cover">
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- 4. Featured Services Section -->
    <section class="py-14 md:py-20 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-5 md:px-8 space-y-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-100 pb-5">
                <div>
                    <div class="text-xs uppercase tracking-wider text-sage font-bold">Layanan Pemandu Wisata</div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-primary mt-1 uppercase">
                        Paket Pemandu &amp; Ekspedisi Unggulan
                    </h2>
                </div>
                <a href="{{ url('/services') }}" class="text-xs uppercase tracking-wider text-primary hover:text-accent font-bold transition-colors flex items-center gap-1">
                    <span>Lihat Semua Paket</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularServices->take(6) as $service)
                    <div class="tour-card flex flex-col justify-between group">
                        <a href="{{ url('/services/' . $service->slug) }}" class="block overflow-hidden aspect-[16/10] bg-neutral-900 relative">
                            <img src="{{ str_starts_with($service->image, 'http') ? $service->image : asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @if($service->is_popular)
                                <div class="absolute top-3 right-3 bg-accent text-primary-dark font-bold text-[9px] px-2.5 py-1 rounded-md uppercase tracking-wider shadow-sm">
                                    Favorit Traveler
                                </div>
                            @endif
                        </a>

                        <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="text-[10px] uppercase tracking-wider text-sage font-bold">
                                    {{ $service->formatted_price }} &bull; {{ $service->estimated_duration ?? '1 Hari' }}
                                </div>
                                <h3 class="text-sm font-bold text-primary group-hover:text-sage transition-colors">
                                    <a href="{{ url('/services/' . $service->slug) }}">
                                        {{ $service->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed">
                                    {{ $service->excerpt }}
                                </p>
                            </div>

                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] uppercase tracking-wider text-gray-500">
                                <span class="font-medium text-xs">{{ $service->warranty ?? 'Berlisensi HPI' }}</span>
                                <span class="group-hover:text-primary font-bold text-primary transition-colors text-xs">Detail &rarr;</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    <!-- 5. Featured Destinations / Trips Showcase Section -->
    <section class="py-14 md:py-20 bg-[#F8FAF9] border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-5 md:px-8 space-y-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-200 pb-5">
                <div>
                    <div class="text-xs uppercase tracking-wider text-sage font-bold">Destinasi Pilihan Indonesia</div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-primary mt-1 uppercase">
                        Galeri Perjalanan &amp; Ekspedisi Nyata
                    </h2>
                </div>
                <a href="{{ url('/portfolio') }}" class="text-xs uppercase tracking-wider text-primary hover:text-accent font-bold transition-colors flex items-center gap-1">
                    <span>Jelajahi Semua Destinasi</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredProjects->take(6) as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>

        </div>
    </section>


    <!-- 6. Our Blog / Latest Travel Guides Section -->
    <section class="py-14 md:py-20 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-5 md:px-8 space-y-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-100 pb-5">
                <div>
                    <div class="text-xs uppercase tracking-wider text-sage font-bold">Tips &amp; Wawasan Wisata</div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-primary mt-1 uppercase">
                        Travel Blog &amp; Panduan Wisata Indonesia
                    </h2>
                </div>
                <a href="{{ url('/our-blog') }}" class="text-xs uppercase tracking-wider text-primary hover:text-accent font-bold transition-colors flex items-center gap-1">
                    <span>Baca Semua Artikel</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php $blogItems = $recentPosts ?? $latestPosts ?? collect(); @endphp
                @forelse($blogItems as $post)
                    <article class="tour-card flex flex-col justify-between group">
                        <a href="{{ url('/our-blog/' . $post->slug) }}" class="block overflow-hidden aspect-[16/10] bg-neutral-900">
                            <img src="{{ $post->cover_image ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=800&auto=format&fit=crop' }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>

                        <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                @if($post->category)
                                    <div class="text-[10px] uppercase tracking-wider text-sage font-bold">
                                        {{ $post->category->title }}
                                    </div>
                                @endif
                                <h3 class="text-sm font-bold text-primary group-hover:text-sage transition-colors line-clamp-2">
                                    <a href="{{ url('/our-blog/' . $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                @if($post->excerpt)
                                    <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed">
                                        {{ $post->excerpt }}
                                    </p>
                                @endif
                            </div>
                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-[10px] uppercase tracking-wider text-gray-500">
                                <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                <span class="group-hover:text-primary font-bold text-primary transition-colors text-xs">Baca Lengkap &rarr;</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-400 text-sm">
                        Belum ada artikel yang diterbitkan.
                    </div>
                @endforelse
            </div>

        </div>
    </section>


    <!-- 7. Tourism Partners & Airlines Running Marquee -->
    <section class="py-12 md:py-16 bg-[#F8FAF9] border-t border-gray-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-5 md:px-8 space-y-6">
            <div class="text-center space-y-1.5">
                <div class="text-xs uppercase tracking-wider text-sage font-bold">Kolaborasi &amp; Jaringan</div>
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-primary uppercase">
                    Mitra Resmi Pariwisata &amp; Maskapai
                </h2>
            </div>

            <!-- Running Marquee Track -->
            <div class="relative w-full overflow-hidden mask-marquee py-2">
                @if($clients->count() > 0)
                    <div class="animate-marquee flex items-center gap-6 md:gap-8">
                        
                        @foreach($clients as $client)
                            <div class="flex-shrink-0 flex items-center justify-center p-3 h-16 w-40 md:w-48 rounded-xl border border-gray-200/80 bg-white transition-all shadow-sm group">
                                @if($client->logo)
                                    <img src="{{ str_starts_with($client->logo, 'http') ? $client->logo : asset('storage/' . $client->logo) }}" 
                                         alt="{{ $client->name }}" 
                                         title="{{ $client->name }}"
                                         loading="lazy"
                                         class="max-h-9 max-w-full object-contain grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                                @else
                                    <span class="text-xs font-bold tracking-wider text-gray-700 uppercase group-hover:text-primary">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach

                        @foreach($clients as $client)
                            <div class="flex-shrink-0 flex items-center justify-center p-3 h-16 w-40 md:w-48 rounded-xl border border-gray-200/80 bg-white transition-all shadow-sm group">
                                @if($client->logo)
                                    <img src="{{ str_starts_with($client->logo, 'http') ? $client->logo : asset('storage/' . $client->logo) }}" 
                                         alt="{{ $client->name }}" 
                                         title="{{ $client->name }}"
                                         loading="lazy"
                                         class="max-h-9 max-w-full object-contain grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                                @else
                                    <span class="text-xs font-bold tracking-wider text-gray-700 uppercase group-hover:text-primary">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>

            <div class="text-center pt-2">
                <a href="{{ url('/clients') }}" class="text-xs uppercase tracking-wider text-primary hover:text-accent font-bold border-b border-primary pb-0.5 inline-block">
                    Lihat Seluruh Jaringan Mitra &rarr;
                </a>
            </div>

        </div>
    </section>


    <!-- 8. Testimonials Section -->
    @if(isset($testimonials) && $testimonials->count())
        <section class="py-14 md:py-20 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-5 md:px-8 space-y-10">
                
                <div class="text-center space-y-2 max-w-xl mx-auto">
                    <div class="text-xs uppercase tracking-wider text-sage font-bold">Ulasan Nyata Wisatawan</div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-primary uppercase">
                        Cerita &amp; Kesan Traveler
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($testimonials as $testi)
                        <div class="tour-card p-6 flex flex-col justify-between space-y-4 group">
                            <div class="space-y-3">
                                <div class="flex items-center gap-1 text-amber-500 text-xs">
                                    @for($i = 0; $i < ($testi->rating ?? 5); $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                                <p class="text-gray-700 text-xs sm:text-sm leading-relaxed italic">
                                    &ldquo;{{ $testi->message }}&rdquo;
                                </p>
                            </div>

                            <div class="pt-3 border-t border-gray-100 flex items-center gap-3">
                                @if($testi->photo)
                                    <img src="{{ str_starts_with($testi->photo, 'http') ? $testi->photo : asset('storage/' . $testi->photo) }}" 
                                         alt="{{ $testi->client_name }}" 
                                         class="w-9 h-9 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs">
                                        {{ substr($testi->client_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs font-bold text-primary uppercase tracking-wider">{{ $testi->client_name }}</div>
                                    @if($testi->client_company)
                                        <div class="text-[10px] text-gray-500">{{ $testi->client_company }}</div>
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
