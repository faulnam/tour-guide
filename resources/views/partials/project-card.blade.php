@props(['project'])

<a href="{{ url('/portfolio/' . $project->slug) }}" 
   class="group relative block overflow-hidden rounded-2xl bg-neutral-900 aspect-[4/3] focus:outline-none shadow-soft hover:shadow-elevated transition-all duration-500">
    
    <!-- Image -->
    <img src="{{ $project->cover_image ? (str_starts_with($project->cover_image, 'http') ? $project->cover_image : asset('storage/' . $project->cover_image)) : 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=800&auto=format&fit=crop' }}" 
         alt="{{ $project->title }}" 
         loading="lazy"
         class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105">

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/95 via-primary-dark/30 to-transparent transition-opacity duration-300 group-hover:opacity-90"></div>

    <!-- Location Badge Top Right -->
    @if($project->location)
        <div class="absolute top-4 right-4">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-black/40 backdrop-blur-md text-[10px] text-white font-medium border border-white/10">
                <i class="fa-solid fa-location-dot text-accent text-[9px]"></i>
                <span>{{ $project->location }}</span>
            </span>
        </div>
    @endif

    <!-- Content at Bottom -->
    <div class="absolute inset-0 p-6 flex flex-col justify-end">
        @if($project->service)
            <div class="text-[10px] uppercase tracking-wider text-accent font-semibold mb-1.5 transition-transform duration-300 group-hover:-translate-y-1">
                {{ $project->service->title }}
            </div>
        @endif

        <h3 class="text-white text-sm md:text-base font-bold leading-snug tracking-wide transition-transform duration-300 group-hover:-translate-y-1">
            {{ $project->title }}
        </h3>

        @if($project->vehicle_model)
            <div class="text-[11px] text-gray-300 mt-1 flex items-center gap-1.5">
                <i class="fa-solid fa-route text-accent text-[10px]"></i>
                <span>{{ $project->vehicle_model }}</span>
            </div>
        @endif
    </div>
</a>
