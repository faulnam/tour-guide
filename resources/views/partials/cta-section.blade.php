<section class="py-20 md:py-28 bg-[#F8FAF9] text-center border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-6 space-y-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sage/10 text-sage text-xs font-bold uppercase tracking-wider">
            <i class="fa-solid fa-earth-asia"></i>
            <span>Jelajah Wisata Indonesia</span>
        </div>

        <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-primary leading-tight">
            {{ \App\Models\PageContent::get('home_cta_title', 'Siap Mewujudkan Liburan Impian Anda di Indonesia?') }}
        </h2>
        
        <div class="min-h-[40px] flex items-center justify-center text-gray-600 text-xs md:text-sm max-w-xl mx-auto"
             x-data="{
                text: '',
                phrases: [
                    'Jelajahi surga Raja Ampat, Labuan Bajo, Bromo, hingga Tana Toraja bersama pemandu lokal resmi HPI.',
                    'Rute kustom fleksibel, armada nyaman ber-AC, dan dokumentasi foto/drone sinematik.',
                    'Kunci jadwal keberangkatan Anda dengan sistem booking online praktis & DP terjangkau.'
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
            <p class="leading-relaxed font-medium">
                <span x-text="text">Rencanakan petualangan wisata tak terlupakan bersama Nusantara Tour Guide.</span><span class="inline-block w-0.5 h-3.5 bg-primary ml-1 align-middle animate-cursor"></span>
            </p>
        </div>

        <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ url('/booking') }}" class="px-7 py-3.5 rounded-xl bg-accent hover:bg-accent-dark text-primary-dark hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Booking Guide Sekarang</span>
            </a>
            <a href="{{ url('/contact-us') }}" class="px-7 py-3.5 rounded-xl border border-gray-300 hover:border-primary text-primary hover:bg-primary hover:text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-comments"></i>
                <span>Konsultasi Itinerary</span>
            </a>
        </div>
    </div>
</section>
