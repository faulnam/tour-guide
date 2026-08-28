<section class="py-24 md:py-32 bg-white text-center border-t border-neutral-100">
    <div class="max-w-4xl mx-auto px-6 space-y-6">
        <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-black leading-tight uppercase">
            {{ \App\Models\PageContent::get('home_cta_title', 'Want to build or tune your machine?') }}
        </h2>
        
        <div class="min-h-[40px] flex items-center justify-center text-neutral-body text-xs md:text-sm max-w-xl mx-auto"
             x-data="{
                text: '',
                phrases: [
                    'Diskusikan konsep modifikasi, target tenaga dyno, atau kebutuhan servis kendaraan Anda.',
                    'Kunci jadwal antrean teknisi kami dengan sistem booking online praktis.',
                    'Dapatkan hasil modifikasi bergaransi dan teruji di atas mesin Dyno Jet.'
                ],
                phraseIndex: 0,
                charIndex: 0,
                isDeleting: false,
                typeSpeed: 45,
                deleteSpeed: 20,
                pauseTime: 2200,
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
                <span x-text="text">Diskusikan rencana modifikasi motor &amp; mobil Anda dengan master tuner BENGKEL.</span><span class="inline-block w-0.5 h-3.5 bg-black ml-1 align-middle animate-cursor"></span>
            </p>
        </div>

        <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ url('/booking') }}" class="btn-dark">
                Booking Online
            </a>
            <a href="{{ url('/contact-us') }}" class="btn-outline-dark">
                Contact Us
            </a>
        </div>
    </div>
</section>
