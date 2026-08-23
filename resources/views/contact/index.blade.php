@extends('layouts.app')

@section('meta_title', 'Contact Us — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Interior Architecture'))
@section('meta_description', 'Get in touch with Metrix Interior Architecture for project inquiries, collaborations, or consultations.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Inquiries</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                Contact Us
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        '{{ addslashes(\App\Models\PageContent::get('contact_intro_text', 'We would love to hear from you. Get in touch with our design team.')) }}',
                        'Let\'s collaborate on your next architectural vision.',
                        'Connect with our Jakarta studio for consultations & inquiries.',
                        'Transforming bespoke concepts into remarkable reality.'
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
                    <span x-text="text">{{ \App\Models\PageContent::get('contact_intro_text', 'We would love to hear from you. Whether you have a project in mind, a press inquiry, or simply want to say hello, get in touch with our team.') }}</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Main Contact Section (Grid: Left Details, Right Form) -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Details (5 cols) -->
                <div class="lg:col-span-5 space-y-10">
                    
                    <div>
                        <div class="eyebrow text-accent font-semibold mb-2">Our Studio</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Jakarta Headquarters</h2>
                        <p class="mt-4 text-neutral-body text-xs md:text-sm leading-relaxed whitespace-pre-line">
                            {{ \App\Models\SiteSetting::get('company_address', "PT. Metrix Indonesia\nJl. Puri Indah Raya Blok I\nKomp. Ruko Puri Blok A No. 18\nPuri Indah Kembangan\nJakarta Barat 11610") }}
                        </p>
                    </div>

                    <!-- Contact Details -->
                    <div class="space-y-4 pt-6 border-t border-neutral-200">
                        <div class="eyebrow text-[11px]">Direct Contact</div>
                        
                        <div class="space-y-3 text-xs">
                            @if($p1 = \App\Models\SiteSetting::get('company_phone_1'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-20">Phone 1:</span>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $p1) }}" class="hover:text-black transition-colors">{{ $p1 }}</a>
                                </div>
                            @endif

                            @if($p2 = \App\Models\SiteSetting::get('company_phone_2'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-20">Phone 2:</span>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $p2) }}" class="hover:text-black transition-colors">{{ $p2 }}</a>
                                </div>
                            @endif

                            @if($wa = \App\Models\SiteSetting::get('company_whatsapp'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-20">WhatsApp:</span>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wa) }}" target="_blank" class="text-emerald-700 font-semibold hover:underline">{{ $wa }}</a>
                                </div>
                            @endif

                            @if($e1 = \App\Models\SiteSetting::get('company_email_info'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-20">General:</span>
                                    <a href="mailto:{{ $e1 }}" class="hover:text-black transition-colors">{{ $e1 }}</a>
                                </div>
                            @endif

                            @if($e2 = \App\Models\SiteSetting::get('company_email_hr'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-20">Careers:</span>
                                    <a href="mailto:{{ $e2 }}" class="hover:text-black transition-colors">{{ $e2 }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Social Icons -->
                    <div class="pt-6 border-t border-neutral-200 space-y-3">
                        <div class="eyebrow text-[11px]">Follow Our Journey</div>
                        <div class="flex items-center space-x-4 text-black">
                            @if($ig = \App\Models\SiteSetting::get('social_instagram'))
                                <a href="{{ $ig }}" target="_blank" class="p-2 border border-neutral-300 hover:border-black transition-colors" title="Instagram">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($fb = \App\Models\SiteSetting::get('social_facebook'))
                                <a href="{{ $fb }}" target="_blank" class="p-2 border border-neutral-300 hover:border-black transition-colors" title="Facebook">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.688 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
                                </a>
                            @endif
                            @if($pin = \App\Models\SiteSetting::get('social_pinterest'))
                                <a href="{{ $pin }}" target="_blank" class="p-2 border border-neutral-300 hover:border-black transition-colors" title="Pinterest">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.357-.056.208-.182.253-.419.152-1.564-.728-2.541-3.014-2.541-4.853 0-3.955 2.874-7.587 8.286-7.587 4.349 0 7.73 3.099 7.73 7.242 0 4.322-2.724 7.801-6.507 7.801-1.271 0-2.466-.661-2.875-1.442l-.782 2.981c-.283 1.087-1.049 2.45-1.562 3.284C9.584 23.839 10.77 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Right Form (7 cols) -->
                <div class="lg:col-span-7 bg-neutral-bg p-8 md:p-12 border border-neutral-200">
                    <div class="space-y-2 mb-8">
                        <div class="eyebrow text-accent font-semibold">Start A Conversation</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Send Us A Message</h2>
                    </div>

                    <form action="{{ url('/contact-us') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   placeholder="e.g. Alexandra Sterling" 
                                   class="w-full bg-white border @error('name') border-red-500 @else border-neutral-300 @enderror text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                            @error('name')
                                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       placeholder="name@example.com" 
                                       class="w-full bg-white border @error('email') border-red-500 @else border-neutral-300 @enderror text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                                @error('email')
                                    <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company" class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                    Company / Project Name
                                </label>
                                <input type="text" 
                                       id="company" 
                                       name="company" 
                                       value="{{ old('company') }}" 
                                       placeholder="e.g. Artisan Hospitality Group" 
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                Message &amp; Project Scope <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required 
                                      placeholder="Tell us about your project, location, target timeframe, or design vision..." 
                                      class="w-full bg-white border @error('message') border-red-500 @else border-neutral-300 @enderror text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn-dark w-full md:w-auto">
                                Submit Message &rarr;
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Google Map Embed Section -->
    @if($mapUrl = \App\Models\SiteSetting::get('map_embed_url'))
        <section class="w-full h-96 bg-neutral-200 border-t border-neutral-300">
            <iframe src="{{ $mapUrl }}" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade" 
                    title="Office Location Map">
            </iframe>
        </section>
    @endif

@endsection
