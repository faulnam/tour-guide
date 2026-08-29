@extends('layouts.app')

@section('meta_title', $service->title . ' — Destinasi Wisata — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Koleksi dokumentasi ekspedisi dan destinasi wisata kategori ' . $service->title . ' oleh Nusantara Tour Guide.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ $service->image ? (str_starts_with($service->image, 'http') ? $service->image : asset('storage/' . $service->image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                {{ $service->title }}
            </h1>
            @if($service->excerpt)
                <p class="text-gray-200 text-xs sm:text-sm max-w-lg mx-auto leading-relaxed">
                    {{ $service->excerpt }}
                </p>
            @endif
        </div>
    </section>

    <!-- Category Pill Filter Tabs -->
    @if(isset($allCategories) && $allCategories->count())
        <section class="bg-[#F8FAF9] border-b border-gray-200 sticky top-16 z-30">
            <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center gap-2 md:gap-3 overflow-x-auto py-3 text-xs uppercase tracking-wider font-bold whitespace-nowrap scrollbar-none">
                <a href="{{ url('/services') }}" 
                   class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:border-primary hover:text-primary transition-colors">
                    Semua Layanan
                </a>
                @foreach($allCategories as $cat)
                    <a href="{{ url('/portfolio-cat/' . $cat->slug) }}" 
                       class="px-4 py-2 rounded-lg border transition-all {{ $cat->id === $service->id ? 'border-primary bg-primary text-white shadow-sm' : 'border-gray-300 text-gray-700 hover:border-primary hover:text-primary' }}">
                        {{ $cat->title }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Portfolio Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-100 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-primary uppercase font-sans">
                        Ekspedisi &amp; Destinasi {{ $service->title }}
                    </h2>
                    <p class="text-gray-500 text-xs mt-1">
                        Menampilkan {{ $projects->total() }} rute perjalanan aktif
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @empty
                    <div class="col-span-3 text-center py-16 text-gray-400 text-sm">
                        Belum ada dokumentasi destinasi di kategori "{{ $service->title }}".
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
