@extends('layouts.app')

@section('meta_title', ($post->meta_title ?: $post->title) . ' — ' . \App\Models\SiteSetting::get('company_name', 'Apex Garage'))
@section('meta_description', $post->meta_description ?: strip_tags(\Illuminate\Support\Str::limit($post->excerpt ?: $post->content, 160)))

@section('content')

<div class="py-12 bg-[#09090b]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-neutral-400">
            <a href="{{ url('/') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ url('/our-blog') }}" class="hover:text-white">Blog</a>
            <span>/</span>
            <span class="text-red-400 font-bold truncate">{{ $post->title }}</span>
        </div>

        <!-- Article Container -->
        <article class="bg-[#121218] border border-neutral-800 rounded-3xl overflow-hidden shadow-2xl space-y-8 p-6 sm:p-10">
            
            <div class="space-y-4">
                @if($post->category)
                    <span class="px-3 py-1 bg-red-600/10 border border-red-500/30 text-red-400 text-xs uppercase font-racing font-bold rounded-full">
                        {{ $post->category->title }}
                    </span>
                @endif

                <h1 class="font-racing font-black text-2xl sm:text-4xl text-white uppercase tracking-tight leading-tight">
                    {{ $post->title }}
                </h1>

                <div class="flex items-center gap-3 text-xs text-neutral-400 font-mono pt-1">
                    <span>Oleh: <strong class="text-white">{{ $post->author ?: 'Apex Master Tuner' }}</strong></span>
                    <span>•</span>
                    <span>{{ $post->published_at ? $post->published_at->translatedFormat('d F Y') : $post->created_at->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            @if($post->cover_image)
                <div class="rounded-2xl overflow-hidden h-72 sm:h-96 border border-neutral-800">
                    <img src="{{ str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image) }}" 
                         alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            @if($post->excerpt)
                <div class="p-5 bg-[#0a0a0e] border-l-4 border-red-600 rounded-r-2xl text-neutral-300 text-sm italic leading-relaxed">
                    {{ $post->excerpt }}
                </div>
            @endif

            <div class="prose prose-invert prose-sm sm:prose-base text-neutral-300 leading-relaxed max-w-none">
                {!! $post->content !!}
            </div>

            <div class="pt-8 border-t border-neutral-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ url('/our-blog') }}" class="text-xs font-bold text-red-400 hover:text-red-300 inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Semua Artikel</span>
                </a>

                <a href="{{ url('/booking') }}" class="px-6 py-3 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all">
                    Booking Modifikasi Sekarang &rarr;
                </a>
            </div>

        </article>

    </div>
</div>

@include('partials.cta-section')

@endsection
