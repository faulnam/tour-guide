@extends('layouts.app')

@section('meta_title', 'Booking Pemandu Wisata Online — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))
@section('meta_description', 'Reservasi pemandu wisata resmi HPI secara online untuk destinasi Bali, Raja Ampat, Labuan Bajo, Bromo, Yogyakarta, dan seluruh Indonesia.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight uppercase font-sans">
                Booking Pemandu Wisata
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm max-w-lg mx-auto leading-relaxed">
                Tentukan destinasi, pilih tanggal keberangkatan, dan amankan slot pemandu lokal terbaik dengan DP terjangkau via payment gateway instan.
            </p>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section class="py-20 md:py-28 bg-white" x-data="{
        step: 1,
        isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},
        loginUrl: '{{ route('login', ['role' => 'customer', 'redirect' => route('booking.index')]) }}',
        vehicleType: '{{ $selectedVehicleType !== 'all' ? $selectedVehicleType : 'mobil' }}',
        selectedService: {{ $selectedServiceId ?? 'null' }},
        servicePrice: 0,
        dpAmount: 300000,
        serviceTitle: '',
        paymentMethod: 'qris',

        setService(id, title, price) {
            this.selectedService = id;
            this.serviceTitle = title;
            this.servicePrice = price;
            this.dpAmount = price > 0 ? Math.max(300000, Math.round(price * 0.3)) : 300000;
        },
        formatRupiah(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
        },
        goToStep(targetStep) {
            if (targetStep > 1 && !this.isLoggedIn) {
                window.location.href = this.loginUrl;
                return;
            }
            this.step = targetStep;
        }
    }" x-init="
        @if($selectedServiceId)
            @php $initSrv = $services->firstWhere('id', $selectedServiceId); @endphp
            @if($initSrv)
                setService({{ $initSrv->id }}, '{{ $initSrv->title }}', {{ (float)$initSrv->base_price }});
            @endif
        @endif
    ">
        <div class="max-w-4xl mx-auto px-6 md:px-12 space-y-10">
            
            <!-- Step Indicators -->
            <div class="grid grid-cols-3 rounded-2xl border border-gray-200 bg-[#F8FAF9] text-xs overflow-hidden shadow-sm">
                <div class="p-4 border-r border-gray-200 flex items-center gap-3"
                     :class="step >= 1 ? 'bg-primary text-white font-bold' : 'text-gray-400'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs" :class="step >= 1 ? 'bg-accent text-primary-dark font-bold' : 'bg-gray-200 text-gray-600'">1</span>
                    <span class="uppercase tracking-wider text-[11px] hidden sm:inline">Destinasi &amp; Paket</span>
                    <span class="uppercase tracking-wider text-[11px] sm:hidden">Langkah 1</span>
                </div>

                <div class="p-4 border-r border-gray-200 flex items-center justify-between gap-2"
                     :class="step >= 2 ? 'bg-primary text-white font-bold' : 'text-gray-400'">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs" :class="step >= 2 ? 'bg-accent text-primary-dark font-bold' : 'bg-gray-200 text-gray-600'">2</span>
                        <span class="uppercase tracking-wider text-[11px] hidden sm:inline">Jadwal &amp; Data Tamu</span>
                        <span class="uppercase tracking-wider text-[11px] sm:hidden">Langkah 2</span>
                    </div>
                    @guest
                        <span class="text-[9px] uppercase px-2 py-0.5 rounded bg-gray-200 text-gray-700 font-bold hidden sm:flex items-center gap-1">
                            <i class="fa-solid fa-lock text-[8px]"></i> Login
                        </span>
                    @endguest
                </div>

                <div class="p-4 flex items-center justify-between gap-2"
                     :class="step >= 3 ? 'bg-primary text-white font-bold' : 'text-gray-400'">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs" :class="step >= 3 ? 'bg-accent text-primary-dark font-bold' : 'bg-gray-200 text-gray-600'">3</span>
                        <span class="uppercase tracking-wider text-[11px] hidden sm:inline">Konfirmasi &amp; DP</span>
                        <span class="uppercase tracking-wider text-[11px] sm:hidden">Langkah 3</span>
                    </div>
                    @guest
                        <span class="text-[9px] uppercase px-2 py-0.5 rounded bg-gray-200 text-gray-700 font-bold hidden sm:flex items-center gap-1">
                            <i class="fa-solid fa-lock text-[8px]"></i> Login
                        </span>
                    @endguest
                </div>
            </div>

            <!-- Booking Form Card -->
            <form action="{{ route('booking.store') }}" method="POST" class="tour-card p-8 md:p-12 space-y-8 bg-white">
                @csrf

                <!-- STEP 1: Pilih Tipe Wisata & Destinasi -->
                <div x-show="step === 1" class="space-y-6">
                    <div class="space-y-2 border-b border-gray-100 pb-4">
                        <div class="eyebrow text-sage font-bold">Langkah 1</div>
                        <h2 class="text-xl md:text-2xl font-bold tracking-tight text-primary uppercase">Pilihan Kategori &amp; Detail Perjalanan</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-center justify-between"
                               :class="vehicleType === 'mobil' ? 'border-primary bg-sage-light/50 ring-2 ring-primary' : 'border-gray-200 text-gray-500 hover:border-gray-300'">
                            <input type="radio" name="vehicle_type" value="mobil" x-model="vehicleType" class="sr-only">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-primary text-white flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-car-side"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-xs uppercase tracking-wider text-primary">Private Guided Tour</div>
                                    <div class="text-[10px] text-gray-500 mt-0.5">Mobil Privat Ber-AC &amp; Pemandu Khusus</div>
                                </div>
                            </div>
                            <span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center" :class="vehicleType === 'mobil' ? 'bg-primary border-primary' : ''"></span>
                        </label>

                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-center justify-between"
                               :class="vehicleType === 'motor' ? 'border-primary bg-sage-light/50 ring-2 ring-primary' : 'border-gray-200 text-gray-500 hover:border-gray-300'">
                            <input type="radio" name="vehicle_type" value="motor" x-model="vehicleType" class="sr-only">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-primary text-white flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-xs uppercase tracking-wider text-primary">Group &amp; Open Trip</div>
                                    <div class="text-[10px] text-gray-500 mt-0.5">Tur Bersama, Minivan / Phinisi Sharing</div>
                                </div>
                            </div>
                            <span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center" :class="vehicleType === 'motor' ? 'bg-primary border-primary' : ''"></span>
                        </label>
                    </div>

                    <!-- Destination Details -->
                    <div class="space-y-4 pt-2">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Destinasi Utama *</label>
                                <input type="text" name="vehicle_brand" x-ref="vBrand" required placeholder="Bali / Raja Ampat / Bromo / Labuan Bajo"
                                       class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Titik Penjemputan *</label>
                                <input type="text" name="vehicle_model" x-ref="vModel" required placeholder="Bandara Ngurah Rai / Hotel Kuta"
                                       class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Jumlah Peserta / Tamu *</label>
                                <input type="text" name="license_plate" x-ref="vPlate" required placeholder="2 Orang / 4 Peserta Dewasa"
                                       class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Durasi Hari Tur</label>
                                <input type="text" name="vehicle_year" x-ref="vYear" placeholder="Contoh: 3 Hari 2 Malam / 1 Full Day"
                                       class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Preferensi Bahasa Pemandu</label>
                                <input type="text" name="vehicle_color" x-ref="vColor" placeholder="Bahasa Indonesia / English / Mandarin"
                                       class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- Service Selection -->
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <div class="eyebrow text-primary font-bold">Pilih Paket Layanan Pemandu:</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto pr-1">
                            @foreach($services as $s)
                                <div @click="setService({{ $s->id }}, '{{ addslashes($s->title) }}', {{ (float)$s->base_price }})"
                                     class="p-4 rounded-xl border bg-[#F8FAF9] cursor-pointer transition-all flex flex-col justify-between"
                                     :class="selectedService === {{ $s->id }} ? 'border-primary bg-white shadow-soft ring-2 ring-primary' : 'border-gray-200 hover:border-gray-300'">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <div class="font-bold text-xs text-primary">{{ $s->title }}</div>
                                            <div class="text-[10px] text-gray-500 mt-1 line-clamp-1">{{ $s->excerpt }}</div>
                                        </div>
                                        <input type="radio" name="service_id" value="{{ $s->id }}" :checked="selectedService === {{ $s->id }}" class="mt-1 accent-primary">
                                    </div>
                                    <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px]">
                                        <span class="text-sage font-bold uppercase text-[10px]">{{ $s->estimated_duration ?? '1 Hari' }}</span>
                                        <span class="font-bold text-primary">{{ $s->formatted_price }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4 flex justify-between items-center flex-wrap gap-4 border-t border-gray-100">
                        @guest
                            <div class="text-xs text-amber-800 bg-amber-50 rounded-xl border border-amber-300/80 px-4 py-3 flex items-center gap-2.5 flex-1 min-w-[260px]">
                                <i class="fa-solid fa-circle-info text-amber-600 flex-shrink-0 text-sm"></i>
                                <span class="text-[11px]">Anda wajib <strong>login akun traveler</strong> terlebih dahulu untuk melanjutkan ke Langkah 2 & booking slot pemandu.</span>
                            </div>
                            <button type="button" @click="goToStep(2)" class="px-6 py-3 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                                <span>Login &amp; Lanjut Langkah 2</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        @else
                            <div></div>
                            <button type="button" @click="goToStep(2)" class="px-6 py-3 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                                <span>Lanjut ke Langkah 2</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        @endguest
                    </div>
                </div>

                <!-- STEP 2: Jadwal & Data Tamu -->
                <div x-show="step === 2" class="space-y-6" x-cloak>
                    <div class="space-y-2 border-b border-gray-100 pb-4">
                        <div class="eyebrow text-sage font-bold">Langkah 2</div>
                        <h2 class="text-xl md:text-2xl font-bold tracking-tight text-primary uppercase">Jadwal Keberangkatan &amp; Kontak Traveler</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Tanggal Mulai Tur *</label>
                            <input type="date" name="booking_date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+2 day')) }}"
                                   class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Pilihan Jam Penjemputan *</label>
                            <select name="booking_time_slot" required class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                                <option value="06:00 WITA">06:00 (Slot Pagi Sunrise / Ekspedisi Awal)</option>
                                <option value="08:30 WITA">08:30 (Slot Pagi Standar Wisata)</option>
                                <option value="11:00 WITA">11:00 (Slot Siang / Check-in Hotel)</option>
                                <option value="14:00 WITA">14:00 (Slot Sunset &amp; Cultural Tour)</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4 pt-2 border-t border-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Nama Lengkap Traveler *</label>
                                <input type="text" name="customer_name" required value="{{ auth()->user()->name ?? old('customer_name') }}" placeholder="Nama Lengkap"
                                       class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Email Aktif *</label>
                                <input type="email" name="customer_email" required value="{{ auth()->user()->email ?? old('customer_email') }}" placeholder="email@domain.com"
                                       class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Nomor WhatsApp Aktif *</label>
                                <input type="text" name="customer_phone" required value="{{ auth()->user()->phone ?? old('customer_phone') }}" placeholder="0812xxxxxxxx"
                                       class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Catatan Khusus / Permintaan Rute / Alergi Makanan</label>
                            <textarea name="custom_request" rows="3" placeholder="Sebutkan jika ada lansia/anak-anak, kebutuhan kursi roda, menu vegetarian, atau spot foto khusus..."
                                      class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors"></textarea>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-between items-center">
                        <button type="button" @click="goToStep(1)" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-xs uppercase tracking-wider hover:bg-gray-100 transition-all">
                            &larr; Kembali
                        </button>
                        <button type="button" @click="goToStep(3)" class="px-6 py-3 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                            <span>Lanjut ke Pembayaran DP</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: Pembayaran DP & Konfirmasi -->
                <div x-show="step === 3" class="space-y-6" x-cloak>
                    <div class="space-y-2 border-b border-gray-100 pb-4">
                        <div class="eyebrow text-sage font-bold">Langkah 3</div>
                        <h2 class="text-xl md:text-2xl font-bold tracking-tight text-primary uppercase">Ringkasan Biaya &amp; Uang Muka (DP)</h2>
                    </div>

                    <div class="bg-[#F8FAF9] rounded-2xl border border-gray-200 p-6 space-y-3 shadow-soft">
                        <div class="flex justify-between text-xs text-gray-700">
                            <span>Paket Pemandu Wisata:</span>
                            <span class="font-bold text-primary" x-text="serviceTitle || 'Custom Private Tour & Guide'"></span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-700">
                            <span>Total Estimasi Paket:</span>
                            <span class="font-bold text-primary" x-text="servicePrice > 0 ? formatRupiah(servicePrice) : 'Sesuai Kesepakatan Itinerary'"></span>
                        </div>
                        <div class="pt-3 border-t border-gray-200 flex justify-between items-center">
                            <div>
                                <div class="text-xs font-bold uppercase text-primary">Uang Muka Booking (DP 30%):</div>
                                <div class="text-[10px] text-gray-500">Dipotong dari total pelunasan saat bertemu pemandu di lokasi</div>
                            </div>
                            <div class="text-2xl font-bold text-accent-dark" x-text="formatRupiah(dpAmount)"></div>
                        </div>
                    </div>

                    <!-- Payment Gateway Option -->
                    <div class="space-y-3 pt-2">
                        <div class="eyebrow text-primary font-bold">Metode Pembayaran DP:</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            
                            <label class="p-4 rounded-xl border bg-white cursor-pointer transition-all flex items-center justify-between"
                                   :class="paymentMethod === 'qris' ? 'border-primary ring-2 ring-primary bg-sage-light/30' : 'border-gray-200'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="accent-primary">
                                    <div>
                                        <div class="font-bold text-xs text-primary flex items-center gap-1.5">
                                            <i class="fa-solid fa-qrcode text-accent"></i>
                                            <span>QRIS Instant (GoPay / OVO / Dana / BCA)</span>
                                        </div>
                                        <div class="text-[10px] text-gray-500">Verifikasi barcode otomatis dalam hitungan detik</div>
                                    </div>
                                </div>
                            </label>

                            <label class="p-4 rounded-xl border bg-white cursor-pointer transition-all flex items-center justify-between"
                                   :class="paymentMethod === 'virtual_account' ? 'border-primary ring-2 ring-primary bg-sage-light/30' : 'border-gray-200'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="virtual_account" x-model="paymentMethod" class="accent-primary">
                                    <div>
                                        <div class="font-bold text-xs text-primary flex items-center gap-1.5">
                                            <i class="fa-solid fa-building-columns text-accent"></i>
                                            <span>Virtual Account Bank</span>
                                        </div>
                                        <div class="text-[10px] text-gray-500">BCA / Mandiri / BRI / BNI Instant Transfer</div>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <div class="pt-6 flex justify-between items-center border-t border-gray-100">
                        <button type="button" @click="goToStep(2)" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-xs uppercase tracking-wider hover:bg-gray-100 transition-all">
                            &larr; Kembali
                        </button>

                        <button type="submit" class="px-6 py-3 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                            <i class="fa-solid fa-shield-check"></i>
                            <span>Konfirmasi &amp; Bayar DP &rarr;</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
