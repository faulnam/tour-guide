@props(['project'])

<a href="{{ url('/portfolio/' . $project->slug) }}" 
   class="group relative block overflow-hidden bg-neutral-900 aspect-[4/3] focus:outline-none">
    
    <!-- Image -->
    <img src="{{ $project->cover_image ? (str_starts_with($project->cover_image, 'http') ? $project->cover_image : asset('storage/' . $project->cover_image)) : 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=800&auto=format&fit=crop' }}" 
         alt="{{ $project->title }}" 
         loading="lazy"
         class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105">

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent transition-opacity duration-300 group-hover:opacity-90"></div>

    <!-- Content at Bottom -->
    <div class="absolute inset-0 p-6 flex flex-col justify-end">
        @if($project->service)
            <div class="text-[10px] uppercase tracking-widest2 text-neutral-300 font-medium mb-1.5 transition-transform duration-300 group-hover:-translate-y-1">
                {{ $project->service->title }}
            </div>
        @endif

        <h3 class="text-white text-sm md:text-base font-semibold leading-snug tracking-wide transition-transform duration-300 group-hover:-translate-y-1">
            {{ $project->title }}
        </h3>
    </div>
</a>
