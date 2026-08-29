@extends('layouts.app')

@section('meta_title', 'Tentang Kami — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Mengenal Nusantara Tour Guide, filosofi eco-tourism berkelanjutan, sertifikasi resmi HPI, armada transportasi wisata, dan jaringan pemandu profesional se-Indonesia.')

@section('content')

    <!-- 1. Hero Header Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/40 backdrop-blur-md border border-white/20 text-accent text-[11px] font-semibold uppercase tracking-wider">
                <i class="fa-solid fa-leaf text-accent text-xs"></i>
                <span>Pemandu Wisata Resmi HPI &amp; Eco-Tourism Indonesia</span>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                Tentang Nusantara Tour Guide
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm max-w-lg mx-auto leading-relaxed">
                Mendedikasikan pelayanan kepramuwisataan terbaik untuk menghadirkan pengalaman liburan autentik, aman, dan berkesan di seluruh penjuru Indonesia.
            </p>
        </div>
    </section>

    <!-- 2. Heritage / Story Section -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <div class="lg:col-span-6 space-y-6">
                    <div class="eyebrow text-sage font-bold flex items-center gap-2">
                        <i class="fa-solid fa-heart text-accent"></i>
                        <span>Filosofi &amp; Komitmen Kami</span>
                    </div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-primary leading-tight">
                        Menjelajah dengan Rasa Hormat, Keselamatan &amp; Cerita Berharga
                    </h2>
                    <div class="text-gray-700 text-sm md:text-base space-y-4 leading-relaxed">
                        <p>
                            Nusantara Tour Guide didirikan atas kecintaan mendalam terhadap kekayaan alam dan keragaman budaya Indonesia. Kami percaya bahwa liburan yang luar biasa bukan hanya tentang berpindah lokasi, melainkan menyelami kearifan lokal, sejarah, serta menjalin koneksi hangat dengan masyarakat setempat.
                        </p>
                        <p>
                            Seluruh pemandu kami adalah putra daerah berlisensi resmi HPI (Himpunan Pramuwisata Indonesia) dan APGI (Asosiasi Pemandu Gunung Indonesia) yang dibekali pelatihan pertolongan pertama, etika konservasi alam, dan kemampuan komunikasi multibahasa.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <div class="aspect-[4/3] rounded-2xl bg-neutral-900 border border-gray-100 overflow-hidden shadow-elevated">
                        <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1000&auto=format&fit=crop" 
                             alt="Pemandu Wisata Nusantara" 
                             class="w-full h-full object-cover">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Standards & Safety Facilities -->
    <section class="py-20 md:py-28 bg-[#F8FAF9] border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-16">
            
            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <div class="eyebrow text-sage font-bold">Standar Kualitas &amp; Keselamatan</div>
                <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-primary uppercase font-sans">
                    Fasilitas &amp; Lisensi Operasional
                </h2>
                <div class="w-12 h-0.5 bg-accent mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="tour-card p-8 space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-sage-light flex items-center justify-center text-sage text-xl">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <div class="eyebrow text-[10px] text-sage font-bold">100% Legal &amp; Resmi</div>
                    <h3 class="text-lg font-bold text-primary">Lisensi HPI &amp; BNSP</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Seluruh pemandu mengantongi sertifikat kompetensi resmi Badan Nasional Sertifikasi Profesi (BNSP) dan terdaftar di DPD HPI terkait.
                    </p>
                </div>

                <div class="tour-card p-8 space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-sage-light flex items-center justify-center text-sage text-xl">
                        <i class="fa-solid fa-kit-medical"></i>
                    </div>
                    <div class="eyebrow text-[10px] text-sage font-bold">First-Aid &amp; Safety</div>
                    <h3 class="text-lg font-bold text-primary">P3K &amp; Standar Maritim/Gunung</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Dilengkapi kotak P3K lengkap, masker gas respirator standar kimia untuk Kawah Ijen, life-jacket bersertifikasi, serta radio komunikasi.
                    </p>
                </div>

                <div class="tour-card p-8 space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-sage-light flex items-center justify-center text-sage text-xl">
                        <i class="fa-solid fa-van-shuttle"></i>
                    </div>
                    <div class="eyebrow text-[10px] text-sage font-bold">Fleet &amp; Equipment</div>
                    <h3 class="text-lg font-bold text-primary">Armada Bersih &amp; Terawat</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Pilihan mobil MPV/Van pariwisata ber-AC dingin, Jeep 4x4 khusus Bromo, dan kapal Phinisi berizin kelaiklautan resmi Syahbandar.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. Stats Animated Counter Bar -->
    <section class="py-16 md:py-24 bg-primary-dark text-white" 
             x-data="{
                 started: false,
                 c1: 0, c2: 0, c3: 0, c4: '0.0',
                 init() {
                     let observer = new IntersectionObserver((entries) => {
                         if (entries[0].isIntersecting && !this.started) {
                             this.runCounter();
                             observer.disconnect();
                         }
                     }, { threshold: 0.25 });
                     observer.observe(this.$el);
                 },
                 runCounter() {
                     this.started = true;
                     const duration = 2200;
                     const start = performance.now();
                     const tick = (now) => {
                         const t = Math.min((now - start) / duration, 1);
                         const ease = 1 - Math.pow(1 - t, 4);
                         this.c1 = Math.floor(ease * 2850);
                         this.c2 = Math.floor(ease * 120);
                         this.c3 = Math.floor(ease * 34);
                         this.c4 = (ease * 99.8).toFixed(1);
                         if (t < 1) requestAnimationFrame(tick);
                         else { this.c1 = 2850; this.c2 = 120; this.c3 = 34; this.c4 = '99.8'; }
                     };
                     requestAnimationFrame(tick);
                 }
             }">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center md:text-left divide-y md:divide-y-0 md:divide-x divide-white/10">
                <div class="pt-4 md:pt-0 md:px-6 first:pt-0">
                    <div class="text-3xl md:text-5xl font-bold text-accent"><span x-text="Number(c1).toLocaleString('id-ID')">0</span>+</div>
                    <div class="text-xs uppercase tracking-wider text-gray-300 mt-1 font-semibold">Wisatawan Terlayani</div>
                </div>
                <div class="pt-4 md:pt-0 md:px-6">
                    <div class="text-3xl md:text-5xl font-bold text-accent"><span x-text="Number(c2).toLocaleString('id-ID')">0</span>+</div>
                    <div class="text-xs uppercase tracking-wider text-gray-300 mt-1 font-semibold">Pemandu Berlisensi HPI</div>
                </div>
                <div class="pt-4 md:pt-0 md:px-6">
                    <div class="text-3xl md:text-5xl font-bold text-accent"><span x-text="c3">0</span></div>
                    <div class="text-xs uppercase tracking-wider text-gray-300 mt-1 font-semibold">Provinsi di Indonesia</div>
                </div>
                <div class="pt-4 md:pt-0 md:px-6">
                    <div class="text-3xl md:text-5xl font-bold text-accent"><span x-text="c4">0.0</span>%</div>
                    <div class="text-xs uppercase tracking-wider text-gray-300 mt-1 font-semibold">Kepuasan Pelanggan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Certified Guides Team -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <div class="eyebrow text-sage font-bold">Tim Pemandu Utama</div>
                <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-primary uppercase">
                    Pemandu Berlisensi HPI Pilihan
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="tour-card p-6 text-center space-y-4">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=400&auto=format&fit=crop" 
                         alt="I Wayan Arta" 
                         class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-accent">
                    <div>
                        <h3 class="text-base font-bold text-primary">I Wayan Arta</h3>
                        <div class="text-xs text-sage font-semibold">Lead Cultural Guide — Bali &amp; Nusa Penida</div>
                        <div class="text-[11px] text-gray-500 mt-1">Sertifikasi HPI Bali #BALI-2018-0921</div>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Spesialis pemandu filosofi pura, tradisi melukat, sejarah kerajaan Bali kuno, dan rute trekking tebing tersembunyi.
                    </p>
                </div>

                <div class="tour-card p-6 text-center space-y-4">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400&auto=format&fit=crop" 
                         alt="Bagas Pratama" 
                         class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-accent">
                    <div>
                        <h3 class="text-base font-bold text-primary">Bagas Pratama</h3>
                        <div class="text-xs text-sage font-semibold">Mountain &amp; Volcano Specialist — Bromo &amp; Ijen</div>
                        <div class="text-[11px] text-gray-500 mt-1">Sertifikasi APGI Jawa Timur #APGI-2020-0412</div>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Berpengalaman lebih dari 8 tahun memandu pendakian golden sunrise Bromo, geologi kawah aktif, dan ekspedisi api biru Ijen.
                    </p>
                </div>

                <div class="tour-card p-6 text-center space-y-4">
                    <img src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=400&auto=format&fit=crop" 
                         alt="La Ode Rizal" 
                         class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-accent">
                    <div>
                        <h3 class="text-base font-bold text-primary">La Ode Rizal</h3>
                        <div class="text-xs text-sage font-semibold">Marine &amp; Liveaboard Guide — Komodo &amp; Raja Ampat</div>
                        <div class="text-[11px] text-gray-500 mt-1">PADI Divemaster #DM-482910 &amp; TNK Naturalist</div>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Ahli navigasi perairan karang Flores &amp; Papua, pemandu pengamatan satwa Komodo, dan instruktur snorkeling Manta Ray.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CTA Section -->
    @include('partials.cta-section')

@endsection
