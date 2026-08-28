@extends('layouts.app')

@section('meta_title', 'Booking Antrean & Modifikasi Online — Apex Garage')

@section('content')
<div class="py-12 bg-[#09090b] min-h-screen" x-data="{
    step: 1,
    vehicleType: '{{ $selectedVehicleType !== 'all' ? $selectedVehicleType : 'mobil' }}',
    selectedService: {{ $selectedServiceId ?? 'null' }},
    servicePrice: 0,
    dpAmount: 250000,
    serviceTitle: '',
    paymentMethod: 'qris',
    useGarageVehicle: false,

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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-10 space-y-2">
            <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-500/30 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-red-400">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Sistem Booking & Antrean Workshop</span>
            </div>
            <h1 class="font-racing font-black text-3xl sm:text-4xl text-white uppercase tracking-tight">
                BOOKING MODIFIKASI & SERVIS
            </h1>
            <p class="text-xs sm:text-sm text-neutral-400 max-w-xl mx-auto">
                Pilih paket pengerjaan, tentukan jadwal kedatangan, dan bayar aman dengan Payment Gateway instan.
            </p>
        </div>

        <!-- Wizard Step Indicators -->
        <div class="mb-8 bg-[#121218] border border-neutral-800 p-3 rounded-2xl flex items-center justify-between text-xs">
            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-colors"
                 :class="step >= 1 ? 'text-red-400 font-bold bg-red-600/10 border border-red-500/30' : 'text-neutral-500'">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-racing"
                     :class="step >= 1 ? 'bg-red-600 text-white' : 'bg-neutral-800 text-neutral-400'">1</div>
                <span>1. Kendaraan & Paket</span>
            </div>

            <div class="h-0.5 w-6 sm:w-12 bg-neutral-800"></div>

            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-colors"
                 :class="step >= 2 ? 'text-red-400 font-bold bg-red-600/10 border border-red-500/30' : 'text-neutral-500'">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-racing"
                     :class="step >= 2 ? 'bg-red-600 text-white' : 'bg-neutral-800 text-neutral-400'">2</div>
                <span>2. Jadwal & Data Diri</span>
            </div>

            <div class="h-0.5 w-6 sm:w-12 bg-neutral-800"></div>

            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-colors"
                 :class="step >= 3 ? 'text-red-400 font-bold bg-red-600/10 border border-red-500/30' : 'text-neutral-500'">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-racing"
                     :class="step >= 3 ? 'bg-red-600 text-white' : 'bg-neutral-800 text-neutral-400'">3</div>
                <span>3. Konfirmasi & Bayar DP</span>
            </div>
        </div>

        <!-- Main Booking Form -->
        <form action="{{ route('booking.store') }}" method="POST" class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
            @csrf

            <!-- STEP 1: Pilih Kendaraan & Layanan -->
            <div x-show="step === 1" class="space-y-6">
                
                <div>
                    <h3 class="font-racing font-bold text-lg text-white mb-1">PILIH TIPE KENDARAAN</h3>
                    <p class="text-xs text-neutral-400 mb-4">Tentukan apakah Anda ingin memodifikasi Mobil atau Motor:</p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <label class="p-5 rounded-2xl border cursor-pointer transition-all flex items-center gap-4"
                               :class="vehicleType === 'mobil' ? 'bg-red-600/10 border-red-500 text-white shadow-lg shadow-red-600/20' : 'bg-[#0e0e12] border-neutral-800 text-neutral-400 hover:border-neutral-700'">
                            <input type="radio" name="vehicle_type" value="mobil" x-model="vehicleType" class="sr-only">
                            <div class="w-12 h-12 rounded-xl bg-neutral-800 flex items-center justify-center text-2xl" :class="vehicleType === 'mobil' ? 'text-red-500 bg-red-600/20' : ''">
                                🚗
                            </div>
                            <div>
                                <div class="font-bold text-sm text-white">Mobil / Supercar</div>
                                <div class="text-[11px] text-neutral-400">ECU Remap, Widebody, Air Suspension</div>
                            </div>
                        </label>

                        <label class="p-5 rounded-2xl border cursor-pointer transition-all flex items-center gap-4"
                               :class="vehicleType === 'motor' ? 'bg-amber-600/10 border-amber-500 text-white shadow-lg shadow-amber-600/20' : 'bg-[#0e0e12] border-neutral-800 text-neutral-400 hover:border-neutral-700'">
                            <input type="radio" name="vehicle_type" value="motor" x-model="vehicleType" class="sr-only">
                            <div class="w-12 h-12 rounded-xl bg-neutral-800 flex items-center justify-center text-2xl" :class="vehicleType === 'motor' ? 'text-amber-500 bg-amber-600/20' : ''">
                                🏍️
                            </div>
                            <div>
                                <div class="font-bold text-sm text-white">Motor / Moge</div>
                                <div class="text-[11px] text-neutral-400">Cafe Racer, Dyno, Knalpot Titanium</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Saved Vehicles from Garage (If Authenticated) -->
                @if(auth()->check() && $userVehicles->count())
                    <div class="p-4 bg-[#0e0e12] border border-neutral-800 rounded-2xl">
                        <div class="text-xs font-bold text-white mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-warehouse text-red-500"></i>
                            <span>Pilih dari Garasi Anda:</span>
                        </div>
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
                                        class="p-2.5 rounded-xl bg-neutral-900 hover:bg-neutral-800 border border-neutral-700 text-left text-xs text-neutral-300 flex items-center justify-between">
                                    <div>
                                        <div class="font-bold text-white">{{ $v->brand }} {{ $v->model }}</div>
                                        <div class="text-[10px] text-neutral-400">{{ $v->license_plate }} • {{ $v->type }}</div>
                                    </div>
                                    <i class="fa-solid fa-arrow-right text-[10px] text-red-500"></i>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Vehicle Details Form -->
                <div class="space-y-4 pt-2">
                    <h4 class="text-xs font-bold text-neutral-300 uppercase tracking-wider">Spesifikasi Kendaraan</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Merk Kendaraan *</label>
                            <input type="text" name="vehicle_brand" x-ref="vBrand" required placeholder="Contoh: Honda / Toyota / Kawasaki"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Model / Tipe *</label>
                            <input type="text" name="vehicle_model" x-ref="vModel" required placeholder="Contoh: Civic Turbo / ZX-25R"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Plat Nomor *</label>
                            <input type="text" name="license_plate" x-ref="vPlate" required placeholder="Contoh: B 1234 ABC"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 uppercase focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Tahun Pembuatan (Opsional)</label>
                            <input type="text" name="vehicle_year" x-ref="vYear" placeholder="Contoh: 2024"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Warna Bodi (Opsional)</label>
                            <input type="text" name="vehicle_color" x-ref="vColor" placeholder="Contoh: Championship White / Hitam"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>
                    </div>
                </div>

                <!-- Select Service / Mod Package -->
                <div class="space-y-4 pt-4 border-t border-neutral-800">
                    <h3 class="font-racing font-bold text-lg text-white mb-1">PILIH PAKET MODIFIKASI / SERVIS</h3>
                    <p class="text-xs text-neutral-400">Pilih salah satu paket layanan unggulan kami:</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-80 overflow-y-auto pr-1">
                        @foreach($services as $s)
                            <div @click="setService({{ $s->id }}, '{{ addslashes($s->title) }}', {{ (float)$s->base_price }})"
                                 class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between"
                                 :class="selectedService === {{ $s->id }} 
                                     ? 'bg-red-600/15 border-red-500 shadow-md shadow-red-600/20' 
                                     : 'bg-[#0e0e12] border-neutral-800 hover:border-neutral-700'">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="font-bold text-xs text-white" :class="selectedService === {{ $s->id }} ? 'text-red-400' : ''">{{ $s->title }}</div>
                                        <div class="text-[10px] text-neutral-400 mt-1 line-clamp-1">{{ $s->excerpt }}</div>
                                    </div>
                                    <input type="radio" name="service_id" value="{{ $s->id }}" :checked="selectedService === {{ $s->id }}" class="mt-1 text-red-600 focus:ring-red-500">
                                </div>
                                <div class="mt-3 pt-2 border-t border-neutral-800/80 flex items-center justify-between text-[11px]">
                                    <span class="text-neutral-500 capitalize">{{ $s->vehicle_type }}</span>
                                    <span class="font-racing font-bold text-red-400">{{ $s->formatted_price }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <button type="button" @click="step = 2"
                            class="px-8 py-3.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-2 shadow-lg shadow-red-600/30">
                        <span>Lanjut ke Langkah 2: Jadwal & Data Diri</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>

            </div>


            <!-- STEP 2: Jadwal Kedatangan & Data Diri Customer -->
            <div x-show="step === 2" class="space-y-6" x-cloak>
                
                <div>
                    <h3 class="font-racing font-bold text-lg text-white mb-1">JADWAL KEDATANGAN & TIME SLOT</h3>
                    <p class="text-xs text-neutral-400 mb-4">Tentukan tanggal dan jam kedatangan unit kendaraan Anda ke workshop:</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Tanggal Booking *</label>
                            <input type="date" name="booking_date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Pilihan Jam Slot Kedatangan *</label>
                            <select name="booking_time_slot" required class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                                <option value="09:00 WIB">09:00 WIB (Slot Pagi)</option>
                                <option value="11:00 WIB">11:00 WIB (Slot Siang 1)</option>
                                <option value="13:30 WIB">13:30 WIB (Slot Siang 2)</option>
                                <option value="15:30 WIB">15:30 WIB (Slot Sore)</option>
                                <option value="17:00 WIB">17:00 WIB (Slot Drop-Off Unit)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-neutral-800">
                    <h3 class="font-racing font-bold text-lg text-white mb-1">DATA KONTAK CUSTOMER</h3>
                    <p class="text-xs text-neutral-400">Informasi untuk konfirmasi jadwal dan update live progress pengerjaan:</p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Nama Lengkap *</label>
                            <input type="text" name="customer_name" required value="{{ auth()->user()->name ?? old('customer_name') }}" placeholder="Nama Anda"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Email Aktif *</label>
                            <input type="email" name="customer_email" required value="{{ auth()->user()->email ?? old('customer_email') }}" placeholder="nama@email.com"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">No. WhatsApp *</label>
                            <input type="text" name="customer_phone" required value="{{ auth()->user()->phone ?? old('customer_phone') }}" placeholder="0812xxxxxxxx"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Permintaan Khusus / Catatan Modifikasi (Opsional)</label>
                        <textarea name="custom_request" rows="3" placeholder="Jelaskan spesifikasi part yang ingin dipasang, target HP dyno, atau keluhan kendaraan Anda..."
                                  class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500"></textarea>
                    </div>

                    @if(auth()->check())
                        <div class="flex items-center text-xs text-neutral-300">
                            <input type="checkbox" name="save_vehicle" value="1" checked class="w-4 h-4 rounded bg-neutral-900 border-neutral-700 text-red-600 focus:ring-red-500">
                            <span class="ml-2">Simpan kendaraan ini otomatis ke Garasi Akun saya</span>
                        </div>
                    @endif
                </div>

                <div class="pt-6 flex justify-between items-center">
                    <button type="button" @click="step = 1"
                            class="px-6 py-3 bg-neutral-900 hover:bg-neutral-800 text-neutral-300 rounded-xl text-xs font-bold uppercase transition-colors">
                        &larr; Kembali
                    </button>

                    <button type="button" @click="step = 3"
                            class="px-8 py-3.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-2 shadow-lg shadow-red-600/30">
                        <span>Lanjut ke Langkah 3: Pembayaran & Konfirmasi</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>

            </div>


            <!-- STEP 3: Rincian Biaya, Payment Gateway, & Submit -->
            <div x-show="step === 3" class="space-y-6" x-cloak>
                
                <div>
                    <h3 class="font-racing font-bold text-lg text-white mb-1">RINGKASAN BIAYA & DOWN PAYMENT (DP)</h3>
                    <p class="text-xs text-neutral-400 mb-4">Down Payment diperlukan untuk mengunci slot antrean lift bengkel dan alokasi mekanik:</p>
                    
                    <div class="bg-[#0a0a0e] border border-neutral-800 rounded-2xl p-5 space-y-3">
                        <div class="flex items-center justify-between text-xs text-neutral-300">
                            <span>Layanan / Paket yang Dipilih:</span>
                            <span class="font-bold text-white" x-text="serviceTitle || 'Custom Modifikasi & Konsultasi'"></span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-neutral-300">
                            <span>Estimasi Total Biaya Paket:</span>
                            <span class="font-racing font-bold text-white" x-text="servicePrice > 0 ? formatRupiah(servicePrice) : 'Sesuai Estimasi Parts'"></span>
                        </div>
                        <div class="pt-3 border-t border-neutral-800 flex items-center justify-between">
                            <div>
                                <div class="text-xs font-bold text-white uppercase">Wajib Bayar Down Payment (DP):</div>
                                <div class="text-[10px] text-neutral-400">Dipotong dari total tagihan akhir saat unit selesai</div>
                            </div>
                            <div class="font-racing font-black text-2xl text-red-500" x-text="formatRupiah(dpAmount)"></div>
                        </div>
                    </div>
                </div>

                <!-- Payment Gateway Selection -->
                <div class="space-y-4 pt-2">
                    <h4 class="text-xs font-bold text-neutral-300 uppercase tracking-wider font-racing">PILIH METODE PAYMENT GATEWAY</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        
                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-center justify-between"
                               :class="paymentMethod === 'qris' ? 'bg-red-600/10 border-red-500 text-white' : 'bg-[#0e0e12] border-neutral-800 text-neutral-400'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="text-red-600">
                                <div>
                                    <div class="font-bold text-xs text-white">QRIS Instant (Gopay / OVO / Dana / BCA)</div>
                                    <div class="text-[10px] text-neutral-400">Verifikasi otomatis dalam hitungan detik</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-qrcode text-red-400 text-lg"></i>
                        </label>

                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-center justify-between"
                               :class="paymentMethod === 'midtrans' ? 'bg-red-600/10 border-red-500 text-white' : 'bg-[#0e0e12] border-neutral-800 text-neutral-400'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="midtrans" x-model="paymentMethod" class="text-red-600">
                                <div>
                                    <div class="font-bold text-xs text-white">Midtrans Snap Payment Gateway</div>
                                    <div class="text-[10px] text-neutral-400">Virtual Account BCA, Mandiri, BNI, Kartu Kredit</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-credit-card text-blue-400 text-lg"></i>
                        </label>

                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-center justify-between"
                               :class="paymentMethod === 'virtual_account' ? 'bg-red-600/10 border-red-500 text-white' : 'bg-[#0e0e12] border-neutral-800 text-neutral-400'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="virtual_account" x-model="paymentMethod" class="text-red-600">
                                <div>
                                    <div class="font-bold text-xs text-white">Transfer Virtual Account Bank</div>
                                    <div class="text-[10px] text-neutral-400">BCA / Mandiri / BRI / Permata</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-building-columns text-emerald-400 text-lg"></i>
                        </label>

                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-center justify-between"
                               :class="paymentMethod === 'cash_workshop' ? 'bg-red-600/10 border-red-500 text-white' : 'bg-[#0e0e12] border-neutral-800 text-neutral-400'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="cash_workshop" x-model="paymentMethod" class="text-red-600">
                                <div>
                                    <div class="font-bold text-xs text-white">Bayar di Workshop (Cash / Debit EDC)</div>
                                    <div class="text-[10px] text-neutral-400">Saat tiba di bengkel (tergantung ketersediaan antrean)</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-money-bill-wave text-amber-400 text-lg"></i>
                        </label>

                    </div>
                </div>

                <div class="pt-6 flex justify-between items-center border-t border-neutral-800">
                    <button type="button" @click="step = 2"
                            class="px-6 py-3 bg-neutral-900 hover:bg-neutral-800 text-neutral-300 rounded-xl text-xs font-bold uppercase transition-colors">
                        &larr; Kembali
                    </button>

                    <button type="submit" 
                            class="px-10 py-4 bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl text-xs font-racing font-bold uppercase tracking-wider transition-all flex items-center gap-2 shadow-xl shadow-red-600/40 hover:scale-105">
                        <i class="fa-solid fa-lock text-sm"></i>
                        <span>KONFIRMASI BOOKING & CHECKOUT &rarr;</span>
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>
@endsection
