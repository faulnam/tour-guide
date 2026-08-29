@props(['slides' => [], 'page' => 'home'])

<section class="relative w-full bg-primary-dark text-white overflow-hidden">
    <!-- Swiper Container -->
    <div class="swiper heroSwiper w-full h-[60vh] md:h-[70vh] lg:h-[75vh]">
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
                    <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3 pt-14">
                        @if($slide->title)
                            <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold tracking-tight text-white leading-snug uppercase font-sans max-w-2xl mx-auto">
                                {{ $slide->title }}
                            </h2>
                        @endif

                        @if($slide->description)
                            <p class="text-gray-200 text-xs sm:text-sm max-w-lg mx-auto leading-relaxed">
                                {{ $slide->description }}
                            </p>
                        @endif

                        @if($slide->link_url && $slide->link_label)
                            <div class="pt-2">
                                <a href="{{ $slide->link_url }}" class="px-6 py-2.5 rounded-lg bg-accent hover:bg-accent-dark text-primary-dark hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md inline-flex items-center gap-2">
                                    <span>{{ $slide->link_label }}</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Fallback Slide 1 -->
                <div class="swiper-slide relative bg-primary-dark text-white min-h-[500px] md:min-h-[580px] flex items-center justify-center">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1920&auto=format&fit=crop');"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/90 via-primary-dark/40 to-primary-dark/60"></div>
                    <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3 pt-14">
                        <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold tracking-tight text-white leading-snug uppercase font-sans max-w-2xl mx-auto">
                            Jelajahi Keajaiban Nusantara Bersama Pemandu Lokal Berlisensi Resmi
                        </h2>
                        <div class="pt-3">
                            <a href="{{ url('/booking') }}" class="px-6 py-2.5 rounded-lg bg-accent text-primary-dark font-bold text-xs uppercase tracking-wider">
                                Booking Pemandu Wisata &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Slider Pagination & Navigation Arrows -->
        <div class="swiper-pagination !bottom-6"></div>
        <div class="swiper-button-prev !text-white !hidden md:!flex !left-6 after:!text-base"></div>
        <div class="swiper-button-next !text-white !hidden md:!flex !right-6 after:!text-base"></div>
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
