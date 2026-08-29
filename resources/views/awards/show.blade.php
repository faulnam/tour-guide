@extends('layouts.app')

@section('meta_title', $award->title . ' — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', strip_tags(Str::limit($award->description, 160)))

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $award->image ? (str_starts_with($award->image, 'http') ? $award->image : asset('storage/' . $award->image)) : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $award->title }}
            </h1>

            @if($award->year || $award->published_date)
                <div class="text-xs uppercase tracking-wider text-accent pt-1 font-bold">
                    Tahun {{ $award->year ?? $award->published_date->format('Y') }}
                </div>
            @endif
        </div>
    </section>

    <!-- Main Award Content Section -->
    <section class="py-12 md:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 space-y-10">
            
            <!-- Award Image -->
            @if($award->image)
                <div class="aspect-[16/10] overflow-hidden rounded-2xl bg-neutral-900 border border-gray-100 shadow-soft">
                    <img src="{{ str_starts_with($award->image, 'http') ? $award->image : asset('storage/' . $award->image) }}" 
                         alt="{{ $award->title }}" 
                         class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Description -->
            <div class="text-gray-700 text-sm md:text-base leading-relaxed space-y-6 prose max-w-none">
                {!! $award->description !!}
            </div>

            <!-- External Link Button -->
            @if($award->external_link)
                <div class="pt-4">
                    <a href="{{ $award->external_link }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-primary inline-flex items-center gap-2">
                        <span>Verifikasi Dokumen Resmi</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                </div>
            @endif

            <!-- Prev / Next Navigation -->
            <div class="pt-12 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-6">
                @if($prevAward)
                    <a href="{{ url('/awards-publications/' . $prevAward->slug) }}" class="tour-card p-6 space-y-1 block group">
                        <div class="text-[10px] uppercase tracking-wider text-sage font-bold flex items-center gap-1">
                            <span>&larr;</span>
                            <span>Sertifikasi Sebelumnya</span>
                        </div>
                        <div class="text-xs md:text-sm font-bold text-primary group-hover:text-sage transition-colors line-clamp-2">
                            {{ $prevAward->title }}
                        </div>
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextAward)
                    <a href="{{ url('/awards-publications/' . $nextAward->slug) }}" class="tour-card p-6 space-y-1 block text-right group">
                        <div class="text-[10px] uppercase tracking-wider text-sage font-bold flex items-center justify-end gap-1">
                            <span>Sertifikasi Berikutnya</span>
                            <span>&rarr;</span>
                        </div>
                        <div class="text-xs md:text-sm font-bold text-primary group-hover:text-sage transition-colors line-clamp-2">
                            {{ $nextAward->title }}
                        </div>
                    </a>
                @endif
            </div>

        </div>
    </section>

    <!-- Other Recognitions (3 Cards) -->
    @if(isset($otherAwards) && $otherAwards->count())
        <section class="py-20 md:py-28 bg-[#F8FAF9] border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
                <div class="space-y-2">
                    <div class="eyebrow text-sage font-bold">Penghargaan Terkait</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">Sertifikasi &amp; Lisensi Lainnya</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($otherAwards as $other)
                        <article class="tour-card p-6 space-y-3 flex flex-col justify-between group">
                            <div class="space-y-2">
                                <div class="eyebrow text-sage text-[10px] font-bold">
                                    {{ $other->year ?? ($other->published_date ? $other->published_date->format('Y') : 'Lisensi') }}
                                </div>
                                <h3 class="text-sm font-bold text-primary group-hover:text-sage transition-colors leading-snug">
                                    <a href="{{ url('/awards-publications/' . $other->slug) }}">
                                        {{ $other->title }}
                                    </a>
                                </h3>
                                @if($other->description)
                                    <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                                        {{ $other->description }}
                                    </p>
                                @endif
                            </div>
                            <div class="pt-4 border-t border-gray-100">
                                <a href="{{ url('/awards-publications/' . $other->slug) }}" class="text-[10px] uppercase tracking-wider font-bold text-primary group-hover:text-sage flex items-center gap-1">
                                    <span>Lihat Rincian</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
