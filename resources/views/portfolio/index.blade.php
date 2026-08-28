@extends('layouts.app')

@section('meta_title', 'Portfolio & Modification Builds — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', 'Galeri hasil modifikasi motor dan mobil, pengujian dyno jet power run, custom bike builder, dan widebody di BENGKEL.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Selected Works &amp; Masterpiece Builds</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Our Portfolio
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Koleksi kendaraan modifikasi performa tinggi, hasil uji dyno jet, dan motor kustom berstandar kontes.
            </p>
        </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">
                        All Completed Builds
                    </h2>
                    <p class="text-neutral-body text-xs mt-1">
                        Showing {{ $projects->total() }} projects
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="pt-8 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
