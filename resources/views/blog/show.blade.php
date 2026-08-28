@extends('layouts.app')

@section('meta_title', ($post->meta_title ?: $post->title) . ' — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', $post->meta_description ?: strip_tags(\Illuminate\Support\Str::limit($post->excerpt ?: $post->content, 160)))

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-24 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $post->cover_image ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image)) : 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">
                <a href="{{ url('/our-blog') }}" class="hover:underline">Blog</a> &bull; {{ $post->category->title ?? 'Tuning & Modif' }}
            </div>
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $post->title }}
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm">
                Ditulis oleh {{ $post->author ?: 'Master Tuner BENGKEL' }} • {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}
            </p>
        </div>
    </section>

    <!-- Article Content -->
    <article class="py-16 md:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-12 space-y-8">
            
            @if($post->excerpt)
                <div class="p-6 bg-neutral-bg border-l-4 border-black text-neutral-700 text-sm italic leading-relaxed">
                    {{ $post->excerpt }}
                </div>
            @endif

            <div class="prose max-w-none text-neutral-800 text-sm sm:text-base leading-relaxed space-y-6">
                {!! $post->content !!}
            </div>

            <div class="pt-8 border-t border-neutral-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ url('/our-blog') }}" class="text-xs uppercase tracking-wider font-semibold text-black hover:text-accent">
                    &larr; Kembali ke Semua Artikel
                </a>

                <a href="{{ url('/booking') }}" class="btn-dark">
                    Booking Modifikasi Sekarang &rarr;
                </a>
            </div>

        </div>
    </article>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
