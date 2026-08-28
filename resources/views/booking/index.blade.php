@extends('layouts.app')

@section('meta_title', 'Online Booking & Consultation — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Garage'))
@section('meta_description', 'Booking antrean servis & modifikasi motor dan mobil online dengan payment gateway.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Integrated Workshop Appointment System</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Online Booking
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Pilih paket modifikasi atau servis, tentukan jadwal kedatangan unit Anda, dan bayar aman via Payment Gateway instan.
            </p>
        </div>
    </section>

    <!-- Booking Form Section (Clean Metrix Style) -->
    <section class="py-20 md:py-28 bg-white" x-data="{
        step: 1,
        vehicleType: '{{ $selectedVehicleType !== 'all' ? $selectedVehicleType : 'mobil' }}',
        selectedService: {{ $selectedServiceId ?? 'null' }},
        servicePrice: 0,
        dpAmount: 250000,
        serviceTitle: '',
        paymentMethod: 'qris',

        setService(id, title, price) {
            this.selectedService = id;
            this.serviceTitle = title;
            this.servicePrice = price;
            this.dpAmount = price > 0 ? Math.max(250000, price * 0.25) : 250000;
        },
        formatRupiah(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
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
            <div class="grid grid-cols-3 border border-neutral-200 bg-neutral-bg text-xs">
                <div class="p-4 border-r border-neutral-200 flex items-center gap-3"
                     :class="step >= 1 ? 'bg-white text-black font-bold' : 'text-neutral-400'">
                    <span class="w-5 h-5 bg-black text-white flex items-center justify-center text-[10px]" :class="step >= 1 ? 'bg-black text-white' : 'bg-neutral-300 text-neutral-600'">1</span>
                    <span class="uppercase tracking-wider text-[11px]">Kendaraan &amp; Layanan</span>
                </div>

                <div class="p-4 border-r border-neutral-200 flex items-center gap-3"
                     :class="step >= 2 ? 'bg-white text-black font-bold' : 'text-neutral-400'">
                    <span class="w-5 h-5 flex items-center justify-center text-[10px]" :class="step >= 2 ? 'bg-black text-white' : 'bg-neutral-300 text-neutral-600'">2</span>
                    <span class="uppercase tracking-wider text-[11px]">Jadwal &amp; Data Diri</span>
                </div>

                <div class="p-4 flex items-center gap-3"
                     :class="step >= 3 ? 'bg-white text-black font-bold' : 'text-neutral-400'">
                    <span class="w-5 h-5 flex items-center justify-center text-[10px]" :class="step >= 3 ? 'bg-black text-white' : 'bg-neutral-300 text-neutral-600'">3</span>
                    <span class="uppercase tracking-wider text-[11px]">Konfirmasi &amp; Bayar DP</span>
                </div>
            </div>

            <!-- Booking Form Card -->
            <form action="{{ route('booking.store') }}" method="POST" class="bg-neutral-bg p-8 md:p-12 border border-neutral-200 space-y-8">
                @csrf

                <!-- STEP 1: Pilih Kendaraan & Layanan -->
                <div x-show="step === 1" class="space-y-6">
                    <div class="space-y-2 border-b border-neutral-200 pb-4">
                        <div class="eyebrow text-accent font-semibold">Langkah 1</div>
                        <h2 class="text-xl md:text-2xl font-bold tracking-tight text-black uppercase">Pilih Tipe Kendaraan &amp; Spesifikasi</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="p-5 border bg-white cursor-pointer transition-all flex items-center gap-4"
                               :class="vehicleType === 'mobil' ? 'border-black shadow-sm' : 'border-neutral-200 text-neutral-500 hover:border-neutral-400'">
                            <input type="radio" name="vehicle_type" value="mobil" x-model="vehicleType" class="sr-only">
                            <span class="text-2xl">🚗</span>
                            <div>
                                <div class="font-bold text-xs uppercase tracking-wider text-black">Mobil / Supercar</div>
                                <div class="text-[11px] text-neutral-500">ECU Remap, Widebody, Air Suspension</div>
                            </div>
                        </label>

                        <label class="p-5 border bg-white cursor-pointer transition-all flex items-center gap-4"
                               :class="vehicleType === 'motor' ? 'border-black shadow-sm' : 'border-neutral-200 text-neutral-500 hover:border-neutral-400'">
                            <input type="radio" name="vehicle_type" value="motor" x-model="vehicleType" class="sr-only">
                            <span class="text-2xl">🏍️</span>
                            <div>
                                <div class="font-bold text-xs uppercase tracking-wider text-black">Motor / Moge</div>
                                <div class="text-[11px] text-neutral-500">Cafe Racer, Dyno, Knalpot Titanium</div>
                            </div>
                        </label>
                    </div>

                    <!-- Saved Vehicles (if logged in) -->
                    @if(auth()->check() && $userVehicles->count())
                        <div class="p-4 bg-white border border-neutral-200 space-y-2">
                            <div class="eyebrow text-black font-semibold text-[10px]">Pilih dari Garasi Tersimpan:</div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach($userVehicles as $v)
                                    <button type="button" 
                                            @click="
                                                vehicleType = '{{ $v->type }}';
                                                $refs.vBrand.value = '{{ $v->brand }}';
                                                $refs.vModel.value = '{{ $v->model }}';
                                                $refs.vPlate.value = '{{ $v->license_plate }}';
                                                $refs.vYear.value = '{{ $v->year }}';
                                                $refs.vColor.value = '{{ $v->color }}';
                                            "
                                            class="p-2.5 bg-neutral-bg hover:bg-white border border-neutral-200 text-left text-xs flex items-center justify-between">
                                        <div>
                                            <div class="font-bold text-black">{{ $v->brand }} {{ $v->model }}</div>
                                            <div class="text-[10px] text-neutral-500">{{ $v->license_plate }} • {{ $v->type }}</div>
                                        </div>
                                        <span class="text-black font-bold">&rarr;</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Vehicle Details -->
                    <div class="space-y-4 pt-2">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Merk Kendaraan *</label>
                                <input type="text" name="vehicle_brand" x-ref="vBrand" required placeholder="Honda / Toyota / BMW"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Model / Tipe *</label>
                                <input type="text" name="vehicle_model" x-ref="vModel" required placeholder="Civic Turbo / ZX-25R"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Plat Nomor *</label>
                                <input type="text" name="license_plate" x-ref="vPlate" required placeholder="B 1234 ABC"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 uppercase focus:outline-none focus:border-black transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Tahun (Opsional)</label>
                                <input type="text" name="vehicle_year" x-ref="vYear" placeholder="2024"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Warna Bodi (Opsional)</label>
                                <input type="text" name="vehicle_color" x-ref="vColor" placeholder="Hitam / Putih"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- Service Selection -->
                    <div class="space-y-3 pt-4 border-t border-neutral-200">
                        <div class="eyebrow text-black font-semibold">Pilih Paket Layanan:</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto pr-1">
                            @foreach($services as $s)
                                <div @click="setService({{ $s->id }}, '{{ addslashes($s->title) }}', {{ (float)$s->base_price }})"
                                     class="p-4 border bg-white cursor-pointer transition-all flex flex-col justify-between"
                                     :class="selectedService === {{ $s->id }} ? 'border-black bg-white shadow-sm ring-1 ring-black' : 'border-neutral-200 hover:border-neutral-400'">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <div class="font-bold text-xs text-black">{{ $s->title }}</div>
                                            <div class="text-[10px] text-neutral-500 mt-1 line-clamp-1">{{ $s->excerpt }}</div>
                                        </div>
                                        <input type="radio" name="service_id" value="{{ $s->id }}" :checked="selectedService === {{ $s->id }}" class="mt-1 accent-black">
                                    </div>
                                    <div class="mt-3 pt-2 border-t border-neutral-100 flex items-center justify-between text-[11px]">
                                        <span class="text-neutral-500 uppercase text-[10px]">{{ $s->vehicle_type }}</span>
                                        <span class="font-bold text-black">{{ $s->formatted_price }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="button" @click="step = 2" class="btn-dark">
                            Lanjut ke Langkah 2 &rarr;
                        </button>
                    </div>
                </div>

                <!-- STEP 2: Jadwal Kedatangan & Data Diri -->
                <div x-show="step === 2" class="space-y-6" x-cloak>
                    <div class="space-y-2 border-b border-neutral-200 pb-4">
                        <div class="eyebrow text-accent font-semibold">Langkah 2</div>
                        <h2 class="text-xl md:text-2xl font-bold tracking-tight text-black uppercase">Jadwal Kedatangan &amp; Kontak</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Tanggal Booking *</label>
                            <input type="date" name="booking_date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Pilihan Jam Slot Kedatangan *</label>
                            <select name="booking_time_slot" required class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                                <option value="09:00 WIB">09:00 WIB (Slot Pagi)</option>
                                <option value="11:00 WIB">11:00 WIB (Slot Siang 1)</option>
                                <option value="13:30 WIB">13:30 WIB (Slot Siang 2)</option>
                                <option value="15:30 WIB">15:30 WIB (Slot Sore)</option>
                                <option value="17:00 WIB">17:00 WIB (Slot Drop-Off Unit)</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4 pt-2 border-t border-neutral-200">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Nama Lengkap *</label>
                                <input type="text" name="customer_name" required value="{{ auth()->user()->name ?? old('customer_name') }}" placeholder="Nama Anda"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Email Aktif *</label>
                                <input type="email" name="customer_email" required value="{{ auth()->user()->email ?? old('customer_email') }}" placeholder="nama@email.com"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">No. WhatsApp *</label>
                                <input type="text" name="customer_phone" required value="{{ auth()->user()->phone ?? old('customer_phone') }}" placeholder="0812xxxxxxxx"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Permintaan Khusus / Catatan Modifikasi</label>
                            <textarea name="custom_request" rows="3" placeholder="Target HP dyno, keluhan mesin, atau part kustom yang ingin dipasang..."
                                      class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors"></textarea>
                        </div>

                        @if(auth()->check())
                            <div class="flex items-center text-xs text-neutral-700">
                                <input type="checkbox" name="save_vehicle" value="1" checked class="accent-black mr-2">
                                <span>Simpan kendaraan ini otomatis ke Garasi Akun saya</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 flex justify-between items-center">
                        <button type="button" @click="step = 1" class="btn-outline-dark">
                            &larr; Kembali
                        </button>
                        <button type="button" @click="step = 3" class="btn-dark">
                            Lanjut ke Langkah 3 &rarr;
                        </button>
                    </div>
                </div>

                <!-- STEP 3: Pembayaran DP & Konfirmasi -->
                <div x-show="step === 3" class="space-y-6" x-cloak>
                    <div class="space-y-2 border-b border-neutral-200 pb-4">
                        <div class="eyebrow text-accent font-semibold">Langkah 3</div>
                        <h2 class="text-xl md:text-2xl font-bold tracking-tight text-black uppercase">Ringkasan Biaya &amp; Payment Gateway</h2>
                    </div>

                    <div class="bg-white border border-neutral-200 p-6 space-y-3">
                        <div class="flex justify-between text-xs text-neutral-700">
                            <span>Layanan yang Dipilih:</span>
                            <span class="font-bold text-black" x-text="serviceTitle || 'Custom Modifikasi & Konsultasi'"></span>
                        </div>
                        <div class="flex justify-between text-xs text-neutral-700">
                            <span>Estimasi Total Biaya Paket:</span>
                            <span class="font-bold text-black" x-text="servicePrice > 0 ? formatRupiah(servicePrice) : 'Sesuai Estimasi Parts'"></span>
                        </div>
                        <div class="pt-3 border-t border-neutral-200 flex justify-between items-center">
                            <div>
                                <div class="text-xs font-bold uppercase text-black">Down Payment (DP Wajib):</div>
                                <div class="text-[10px] text-neutral-500">Dipotong dari total tagihan akhir saat unit selesai</div>
                            </div>
                            <div class="text-xl font-bold text-black" x-text="formatRupiah(dpAmount)"></div>
                        </div>
                    </div>

                    <!-- Payment Gateway Option -->
                    <div class="space-y-3 pt-2">
                        <div class="eyebrow text-black font-semibold">Metode Pembayaran:</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            
                            <label class="p-4 border bg-white cursor-pointer transition-all flex items-center justify-between"
                                   :class="paymentMethod === 'qris' ? 'border-black ring-1 ring-black' : 'border-neutral-200'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="accent-black">
                                    <div>
                                        <div class="font-bold text-xs text-black">QRIS Instant (Gopay / OVO / Dana / BCA)</div>
                                        <div class="text-[10px] text-neutral-500">Verifikasi instan via barcode QRIS</div>
                                    </div>
                                </div>
                            </label>

                            <label class="p-4 border bg-white cursor-pointer transition-all flex items-center justify-between"
                                   :class="paymentMethod === 'virtual_account' ? 'border-black ring-1 ring-black' : 'border-neutral-200'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="virtual_account" x-model="paymentMethod" class="accent-black">
                                    <div>
                                        <div class="font-bold text-xs text-black">Transfer Virtual Account Bank</div>
                                        <div class="text-[10px] text-neutral-500">BCA / Mandiri / BRI / BNI</div>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <div class="pt-6 flex justify-between items-center border-t border-neutral-200">
                        <button type="button" @click="step = 2" class="btn-outline-dark">
                            &larr; Kembali
                        </button>

                        <button type="submit" class="btn-dark">
                            Konfirmasi Booking &amp; Checkout &rarr;
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
