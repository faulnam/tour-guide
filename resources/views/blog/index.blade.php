@extends('layouts.app')

@section('meta_title', 'Travel Blog & Panduan Wisata Indonesia — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Artikel wawasan wisata Indonesia, itinerary tersembunyi, tips mendaki gunung, diving dan snorkeling, serta cerita budaya lokal.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/20 text-accent text-xs font-semibold uppercase tracking-wider">
                <i class="fa-regular fa-newspaper text-accent"></i>
                <span>Jurnal Perjalanan &amp; Tips Wisata</span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Travel Blog Nusantara
            </h1>
            <p class="text-gray-200 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Panduan praktis, rekomendasi musim terbaik, etika berkunjung, dan kisah seru dari para pemandu wisata lokal Indonesia.
            </p>
        </div>
    </section>

    <!-- Blog Articles Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-100 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                        Artikel &amp; Cerita Terbaru
                    </h2>
                    <p class="text-gray-500 text-xs mt-1">
                        Menampilkan {{ $posts->total() }} artikel panduan perjalanan
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <article class="tour-card flex flex-col justify-between group">
                        <a href="{{ url('/our-blog/' . $post->slug) }}" class="block overflow-hidden aspect-[16/10] bg-neutral-900">
                            <img src="{{ $post->cover_image ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=800&auto=format&fit=crop' }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>

                        <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                @if($post->category)
                                    <div class="eyebrow text-[10px] text-sage font-bold">
                                        {{ $post->category->title }}
                                    </div>
                                @endif
                                <h3 class="text-base font-bold text-primary group-hover:text-sage transition-colors line-clamp-2">
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

                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-[10px] uppercase tracking-wider text-gray-500">
                                <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                <span class="group-hover:text-primary font-bold text-primary transition-colors">Baca Lengkap &rarr;</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-16 text-gray-400 text-sm">
                        Belum ada artikel yang dipublikasikan.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="pt-8 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
