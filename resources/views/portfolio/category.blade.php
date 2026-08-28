@extends('layouts.app')

@section('meta_title', $service->title . ' Portfolio — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', 'Koleksi hasil modifikasi dan dyno test kategori ' . $service->title . ' oleh BENGKEL.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $service->image ? (str_starts_with($service->image, 'http') ? $service->image : asset('storage/' . $service->image)) : 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Portfolio Category</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $service->title }}
            </h1>
            @if($service->excerpt)
                <p class="text-neutral-300 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                    {{ $service->excerpt }}
                </p>
            @endif
        </div>
    </section>

    <!-- Category Pill Filter Tabs -->
    @if(isset($allCategories) && $allCategories->count())
        <section class="bg-neutral-bg border-b border-neutral-200 sticky top-16 z-30">
            <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center gap-2 md:gap-3 overflow-x-auto py-4 text-xs uppercase tracking-wider font-semibold whitespace-nowrap scrollbar-none">
                <a href="{{ url('/services') }}" 
                   class="px-4 py-2 border border-neutral-300 text-neutral-600 hover:border-black hover:text-black transition-colors">
                    All Services
                </a>
                @foreach($allCategories as $cat)
                    <a href="{{ url('/portfolio-cat/' . $cat->slug) }}" 
                       class="px-4 py-2 border transition-colors {{ $cat->id === $service->id ? 'border-black bg-black text-white' : 'border-neutral-300 text-neutral-600 hover:border-black hover:text-black' }}">
                        {{ $cat->title }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Portfolio Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">
                        {{ $service->title }} Projects
                    </h2>
                    <p class="text-neutral-body text-xs mt-1">
                        Menampilkan {{ $projects->total() }} unit modifikasi selesai
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @empty
                    <div class="col-span-3 text-center py-16 text-neutral-400 text-sm">
                        Belum ada proyek modifikasi di kategori "{{ $service->title }}".
                    </div>
                @endforelse
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
