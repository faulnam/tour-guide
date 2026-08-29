@extends('layouts.app')

@section('meta_title', ($post->meta_title ?: $post->title) . ' — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', $post->meta_description ?: strip_tags(\Illuminate\Support\Str::limit($post->excerpt ?: $post->content, 160)))

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-primary-dark text-white pt-36 pb-20 md:pt-48 md:pb-24 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $post->cover_image ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/20 text-accent text-xs font-semibold uppercase tracking-wider">
                <a href="{{ url('/our-blog') }}" class="hover:underline">Travel Blog</a> &bull; {{ $post->category->title ?? 'Tips Wisata Indonesia' }}
            </div>
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $post->title }}
            </h1>
            <p class="text-gray-200 text-xs md:text-sm">
                Ditulis oleh {{ $post->author ?: 'Tim Pemandu Wisata Nusantara' }} &bull; {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}
            </p>
        </div>
    </section>

    <!-- Article Content -->
    <article class="py-16 md:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-12 space-y-8">
            
            @if($post->excerpt)
                <div class="p-6 bg-[#F8FAF9] border-l-4 border-accent text-gray-700 text-sm italic leading-relaxed rounded-r-xl">
                    {{ $post->excerpt }}
                </div>
            @endif

            <div class="prose max-w-none text-gray-800 text-sm sm:text-base leading-relaxed space-y-6">
                {!! $post->content !!}
            </div>

            <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ url('/our-blog') }}" class="text-xs uppercase tracking-wider font-bold text-primary hover:text-sage flex items-center gap-1">
                    <span>&larr;</span>
                    <span>Kembali ke Semua Artikel</span>
                </a>

                <a href="{{ url('/booking') }}" class="px-6 py-2.5 rounded-xl bg-accent hover:bg-accent-dark text-primary-dark hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-xs"></i>
                    <span>Booking Pemandu Wisata &rarr;</span>
                </a>
            </div>

        </div>
    </article>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
