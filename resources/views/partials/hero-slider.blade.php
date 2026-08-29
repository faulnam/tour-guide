@props(['slides' => [], 'page' => 'home'])

<section class="relative w-full bg-primary-dark text-white overflow-hidden">
    <!-- Swiper Container -->
    <div class="swiper heroSwiper w-full h-[75vh] md:h-[85vh] lg:h-[90vh]">
        <div class="swiper-wrapper">
            @forelse($slides as $slide)
                <div class="swiper-slide relative flex items-center justify-center">
                    <!-- Slide Background Image -->
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 scale-100" 
                         style="background-image: url('{{ $slide->image ? (str_starts_with($slide->image, 'http') ? $slide->image : asset('storage/' . $slide->image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1920&auto=format&fit=crop' }}');">
                    </div>
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/95 via-primary-dark/40 to-primary-dark/60"></div>

                    <!-- Slide Content -->
                    <div class="relative z-10 max-w-5xl mx-auto px-6 md:px-12 text-center space-y-6 pt-16">
                        @if($slide->subtitle)
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/20 text-accent text-xs font-semibold uppercase tracking-wider">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $slide->subtitle }}</span>
                            </div>
                        @endif

                        @if($slide->title)
                            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                                {{ $slide->title }}
                            </h2>
                        @endif

                        @if($slide->button_text && $slide->button_link)
                            <div class="pt-4 flex items-center justify-center gap-3">
                                <a href="{{ url($slide->button_link) }}" class="px-8 py-4 rounded-xl bg-accent hover:bg-accent-dark text-primary-dark hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-lg">
                                    {{ $slide->button_text }} &rarr;
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Fallback Default Slide -->
                <div class="swiper-slide relative flex items-center justify-center">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1920&auto=format&fit=crop');"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/90 via-primary-dark/40 to-primary-dark/60"></div>
                    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center space-y-6 pt-16">
                        <div class="text-accent tracking-widest text-xs uppercase font-bold">Licensed Indonesian Local Guides</div>
                        <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                            Jelajahi Keajaiban Nusantara
                        </h2>
                        <div class="pt-4">
                            <a href="{{ url('/booking') }}" class="px-8 py-4 rounded-xl bg-accent text-primary-dark font-bold text-xs uppercase tracking-wider">
                                Booking Pemandu Wisata &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Slider Pagination & Navigation Arrows -->
        <div class="swiper-pagination !bottom-8"></div>
        <div class="swiper-button-prev !text-white !hidden md:!flex !left-8 after:!text-lg"></div>
        <div class="swiper-button-next !text-white !hidden md:!flex !right-8 after:!text-lg"></div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== 'undefined') {
            new Swiper('.heroSwiper', {
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }
    });
</script>
@endpush
