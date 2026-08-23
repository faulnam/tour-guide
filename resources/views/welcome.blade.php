@extends('layouts.app')

@section('meta_title', \App\Models\SiteSetting::get('site_title', 'Metrix Interior Architecture'))
@section('meta_description', \App\Models\SiteSetting::get('meta_description_default'))

@section('content')
    <!-- Hero / Test Section -->
    <div class="relative bg-neutral-950 text-white min-h-[70vh] flex items-center justify-center pt-24 pb-16 px-6">
        <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=1920&auto=format&fit=crop');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/40 to-transparent"></div>

        <div class="relative z-10 max-w-4xl mx-auto text-center space-y-6">
            <div class="eyebrow-light tracking-widest3">
                {{ \App\Models\PageContent::get('home_hero_title', 'We are an Award-Winning interior design firm') }}
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight">
                BURGER & LOBSTER — PLAZA INDONESIA
            </h1>
            <p class="section-desc text-neutral-300 max-w-2xl mx-auto text-xs md:text-sm">
                {{ \App\Models\PageContent::get('home_hero_description') }}
            </p>
            <div class="pt-4 flex items-center justify-center gap-4">
                <a href="{{ url('/services') }}" class="btn-outline">
                    View Project &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Bar -->
    <div class="border-b border-gray-200 bg-neutral-bg py-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="stat-number">{{ \App\Models\SiteSetting::get('total_projects', '3,000+') }}</div>
                <div class="eyebrow mt-2">Total Projects Worldwide</div>
            </div>
            <div>
                <div class="stat-number">{{ \App\Models\SiteSetting::get('years_experience', '20+') }}</div>
                <div class="eyebrow mt-2">Years Working Experience</div>
            </div>
            <div>
                <div class="stat-number">{{ \App\Models\SiteSetting::get('media_awards_count', '17+') }}</div>
                <div class="eyebrow mt-2">Media Published & Awards</div>
            </div>
            <div>
                <div class="stat-number">{{ \App\Models\SiteSetting::get('countries_served', '5') }}</div>
                <div class="eyebrow mt-2">Countries Served</div>
            </div>
        </div>
    </div>
@endsection
