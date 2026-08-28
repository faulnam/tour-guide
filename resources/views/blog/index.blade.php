@extends('layouts.app')

@section('meta_title', 'Blog Otomotif & Tips Tuning — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', 'Artikel wawasan modifikasi performa mobil dan motor, dyno tuning, custom builder, dan tips perawatan mesin.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Automotive Journal &amp; Dyno Insights</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Our Blog
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Wawasan teknis modifikasi motor &amp; mobil, ulasan dyno run, dan tips perawatan dari master tuner BENGKEL.
            </p>
        </div>
    </section>

    <!-- Blog Articles Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">
                        Latest Articles &amp; Build Stories
                    </h2>
                    <p class="text-neutral-body text-xs mt-1">
                        Menampilkan {{ $posts->total() }} artikel edukasi &amp; tuning
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
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
                                <span class="group-hover:text-black font-semibold transition-colors">Baca Artikel &rarr;</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-16 text-neutral-400 text-sm">
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
