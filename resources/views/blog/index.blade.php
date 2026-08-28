@extends('layouts.app')

@section('meta_title', 'Blog Otomotif & Tips Tuning — Apex Garage')
@section('meta_description', 'Artikel terbaru seputar modifikasi mobil, ECU remap, setting dyno jet, custom motorcycle builder, dan tips perawatan mesin.')

@section('content')

<!-- Hero Banner -->
<section class="py-16 bg-[#0c0c10] border-b border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-500/30 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-red-400">
            <i class="fa-solid fa-newspaper"></i>
            <span>Apex Tuning Journal</span>
        </div>
        <h1 class="font-racing font-black text-3xl sm:text-5xl text-white uppercase tracking-tight">
            BLOG & ARTIKEL OTOMOTIF
        </h1>
        <p class="text-xs sm:text-sm text-neutral-400 max-w-2xl mx-auto">
            Wawasan teknis modifikasi motor & mobil, ulasan dyno run, dan tips perawatan dari master tuner.
        </p>
    </div>
</section>

<!-- Blog Articles Grid -->
<section class="py-16 bg-[#09090b]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article class="bg-[#121218] border border-neutral-800 rounded-3xl overflow-hidden hover:border-red-500/50 transition-all duration-300 flex flex-col justify-between group shadow-xl hover:-translate-y-1">
                    <a href="{{ url('/our-blog/' . $post->slug) }}" class="block overflow-hidden h-52 bg-neutral-900">
                        <img src="{{ $post->cover_image ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image)) : 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=800&auto=format&fit=crop' }}" 
                             alt="{{ $post->title }}" 
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </a>

                    <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            @if($post->category)
                                <div class="text-[10px] text-red-400 uppercase font-bold tracking-wider font-racing">
                                    {{ $post->category->title }}
                                </div>
                            @endif
                            <h3 class="font-racing font-bold text-base text-white group-hover:text-red-400 transition-colors line-clamp-2">
                                <a href="{{ url('/our-blog/' . $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            @if($post->excerpt)
                                <p class="text-xs text-neutral-400 line-clamp-3 leading-relaxed">
                                    {{ $post->excerpt }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-neutral-800/80 flex items-center justify-between text-[10px] uppercase tracking-wider text-neutral-500">
                            <span>{{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : $post->created_at->translatedFormat('d M Y') }}</span>
                            <span class="group-hover:text-red-400 font-bold transition-colors">Baca Artikel &rarr;</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16 text-neutral-500 text-xs">
                    Belum ada artikel yang dipublikasikan.
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="pt-6 flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</section>

@include('partials.cta-section')

@endsection
