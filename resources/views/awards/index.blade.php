@extends('layouts.app')

@section('meta_title', 'Sertifikasi & Penghargaan — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Prestasi, lisensi resmi Himpunan Pramuwisata Indonesia (HPI), sertifikasi APGI, dan penghargaan keunggulan layanan wisata Nusantara.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/20 text-accent text-xs font-semibold uppercase tracking-wider">
                <i class="fa-solid fa-award text-accent"></i>
                <span>Sertifikasi &amp; Rekognisi Resmi</span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Sertifikasi &amp; Penghargaan
            </h1>
            <p class="text-gray-200 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Bukti dedikasi dan komitmen kami dalam menghadirkan standar keselamatan tertinggi, wawasan budaya mendalam, dan kepuasan tamu di seluruh Indonesia.
            </p>
        </div>
    </section>

    <!-- Awards Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-100 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                        Lisensi &amp; Rekognisi Pariwisata
                    </h2>
                    <p class="text-gray-500 text-xs mt-1">
                        Menampilkan {{ $awards->total() }} penghargaan &amp; sertifikasi resmi
                    </p>
                </div>
            </div>

            <!-- Awards Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($awards as $award)
                    <article class="tour-card flex flex-col justify-between group">
                        <a href="{{ url('/awards-publications/' . $award->slug) }}" class="block overflow-hidden aspect-[16/11] bg-neutral-900">
                            <img src="{{ $award->image ? (str_starts_with($award->image, 'http') ? $award->image : asset('storage/' . $award->image)) : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800&auto=format&fit=crop' }}" 
                                 alt="{{ $award->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>

                        <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="eyebrow text-[10px] text-sage font-bold">
                                    {{ $award->published_date ? $award->published_date->format('F Y') : 'Sertifikasi Resmi' }}
                                </div>
                                <h3 class="text-base font-bold text-primary group-hover:text-sage transition-colors leading-snug">
                                    <a href="{{ url('/awards-publications/' . $award->slug) }}">
                                        {{ $award->title }}
                                    </a>
                                </h3>
                                @if($award->description)
                                    <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed">
                                        {{ $award->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-[10px] uppercase tracking-wider text-gray-500">
                                <span>{{ $award->organization ?? 'Kemenparekraf & HPI' }}</span>
                                <span class="group-hover:text-primary font-bold text-primary transition-colors">Detail &rarr;</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-16 text-gray-400 text-sm">
                        Belum ada data sertifikasi yang ditampilkan.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($awards->hasPages())
                <div class="pt-8 flex justify-center">
                    {{ $awards->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
