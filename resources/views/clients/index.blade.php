@extends('layouts.app')

@section('meta_title', 'Performance Partners & Clients — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))
@section('meta_description', 'Official partners and aftermarket performance brands supporting BENGKEL tuning and custom builds.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Official Aftermarket &amp; Racing Partners</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Our Partners
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Bekerja sama dengan produsen part motorsport & aftermarket dunia.',
                        'Dukungan teknologi Dyno Jet, ECU Standalone, dan Cat Oven Spies Hecker.',
                        'Mitra resmi komponen remap, suspensi udara, turbocharger & titanium exhaust.',
                        'Dipercaya oleh komunitas dan antusias modifikasi mobil & motor di Indonesia.'
                    ],
                    phraseIndex: 0,
                    charIndex: 0,
                    isDeleting: false,
                    typeSpeed: 50,
                    deleteSpeed: 25,
                    pauseTime: 2000,
                    init() { this.type(); },
                    type() {
                        const current = this.phrases[this.phraseIndex];
                        if (this.isDeleting) {
                            this.text = current.substring(0, this.charIndex - 1);
                            this.charIndex--;
                        } else {
                            this.text = current.substring(0, this.charIndex + 1);
                            this.charIndex++;
                        }
                        let speed = this.isDeleting ? this.deleteSpeed : this.typeSpeed;
                        if (!this.isDeleting && this.charIndex === current.length) {
                            speed = this.pauseTime;
                            this.isDeleting = true;
                        } else if (this.isDeleting && this.charIndex === 0) {
                            this.isDeleting = false;
                            this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
                            speed = 350;
                        }
                        setTimeout(() => this.type(), speed);
                    }
                 }">
                <p class="leading-relaxed">
                    <span x-text="text">Didukung oleh brand aftermarket performa tinggi dunia untuk menghadirkan modifikasi presisi dan bergaransi resmi.</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Clients / Brand Partners Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <div class="eyebrow text-accent font-semibold">Official Performance Network</div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">
                    Partner &amp; Brand Resmi
                </h2>
                <div class="w-12 h-0.5 bg-black mx-auto mt-2"></div>
            </div>

            <!-- Grid of Logos -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @forelse($clients as $client)
                    <div class="group border border-neutral-200 p-8 h-36 flex flex-col items-center justify-center hover:border-black transition-all bg-white text-center">
                        @if($client->logo)
                            <img src="{{ str_starts_with($client->logo, 'http') ? $client->logo : asset('storage/' . $client->logo) }}" 
                                 alt="{{ $client->name }}" 
                                 title="{{ $client->name }}"
                                 loading="lazy"
                                 class="max-h-12 max-w-full object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                        @endif
                        <div class="mt-2 text-[11px] font-semibold uppercase tracking-wider text-neutral-600 group-hover:text-black transition-colors">
                            {{ $client->name }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-6 text-center py-12 text-neutral-400 text-sm">
                        Daftar partner brand akan tampil di sini.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
