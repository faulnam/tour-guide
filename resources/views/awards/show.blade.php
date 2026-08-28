@extends('layouts.app')

@section('meta_title', $award->title . ' — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', strip_tags(Str::limit($award->description, 160)))

@section('content')

    <!-- Hero Header -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-50 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $award->image ? (str_starts_with($award->image, 'http') ? $award->image : asset('storage/' . $award->image)) : 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">
                <a href="{{ url('/awards-publications') }}" class="hover:underline">Awards &amp; Media</a> &bull; {{ $award->organization ?? 'Achievement' }}
            </div>

            <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $award->title }}
            </h1>

            @if($award->year || $award->published_date)
                <div class="text-xs uppercase tracking-wider text-neutral-400 pt-2">
                    {{ $award->year ?? $award->published_date->format('Y') }}
                </div>
            @endif
        </div>
    </section>

    <!-- Main Award Content Section -->
    <section class="py-12 md:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 space-y-10">
            
            <!-- Award Image -->
            @if($award->image)
                <div class="aspect-[16/10] overflow-hidden bg-neutral-900 border border-neutral-200">
                    <img src="{{ str_starts_with($award->image, 'http') ? $award->image : asset('storage/' . $award->image) }}" 
                         alt="{{ $award->title }}" 
                         class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Description -->
            <div class="text-neutral-800 text-sm md:text-base leading-relaxed space-y-6 prose max-w-none">
                {!! $award->description !!}
            </div>

            <!-- External Link Button -->
            @if($award->external_link)
                <div class="pt-4">
                    <a href="{{ $award->external_link }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-dark">
                        Visit Official Publication &rarr;
                    </a>
                </div>
            @endif

            <!-- Prev / Next Navigation -->
            <div class="pt-12 border-t border-neutral-200 grid grid-cols-1 sm:grid-cols-2 gap-6">
                @if($prevAward)
                    <a href="{{ url('/awards-publications/' . $prevAward->slug) }}" class="group p-6 border border-neutral-200 hover:border-black transition-colors space-y-1 block">
                        <div class="text-[10px] uppercase tracking-widest text-neutral-400 flex items-center gap-1">
                            <span>&larr;</span>
                            <span>Previous Award</span>
                        </div>
                        <div class="text-xs md:text-sm font-bold text-black group-hover:text-accent transition-colors line-clamp-2">
                            {{ $prevAward->title }}
                        </div>
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextAward)
                    <a href="{{ url('/awards-publications/' . $nextAward->slug) }}" class="group p-6 border border-neutral-200 hover:border-black transition-colors space-y-1 block text-right">
                        <div class="text-[10px] uppercase tracking-widest text-neutral-400 flex items-center justify-end gap-1">
                            <span>Next Award</span>
                            <span>&rarr;</span>
                        </div>
                        <div class="text-xs md:text-sm font-bold text-black group-hover:text-accent transition-colors line-clamp-2">
                            {{ $nextAward->title }}
                        </div>
                    </a>
                @endif
            </div>

        </div>
    </section>

    <!-- Other Recognitions (3 Cards) -->
    @if(isset($otherAwards) && $otherAwards->count())
        <section class="py-20 md:py-28 bg-neutral-bg border-t border-neutral-200">
            <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
                <div class="space-y-2">
                    <div class="eyebrow text-accent font-semibold">More Accolades</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">Other Recognitions</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($otherAwards as $other)
                        <article class="bg-white p-6 border border-neutral-200 space-y-3 flex flex-col justify-between hover:border-black transition-colors">
                            <div class="space-y-2">
                                <div class="eyebrow text-accent text-[10px]">
                                    {{ $other->year ?? ($other->published_date ? $other->published_date->format('Y') : 'Award') }}
                                </div>
                                <h3 class="text-sm font-bold text-black hover:text-accent transition-colors leading-snug">
                                    <a href="{{ url('/awards-publications/' . $other->slug) }}">
                                        {{ $other->title }}
                                    </a>
                                </h3>
                                @if($other->description)
                                    <p class="text-xs text-neutral-body line-clamp-2 leading-relaxed">
                                        {{ $other->description }}
                                    </p>
                                @endif
                            </div>
                            <div class="pt-4 border-t border-neutral-100">
                                <a href="{{ url('/awards-publications/' . $other->slug) }}" class="text-[10px] uppercase tracking-widest font-semibold text-black hover:text-accent">
                                    Read Story &rarr;
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
