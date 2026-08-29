@extends('layouts.app')

@section('meta_title', 'Invoice & Travel Pass — ' . $booking->booking_code)

@section('content')

    @php
        $totalAmount = (float) ($booking->total_amount > 0 ? $booking->total_amount : ($booking->service->price ?? 0));
        $paidAmount = (float) $booking->paid_amount;
        $remainingAmount = max(0, $totalAmount - $paidAmount);
        $dpAmount = (float) ($booking->dp_amount > 0 ? $booking->dp_amount : 300000);
        $isCompleted = ($booking->status === 'completed');
        $isFullyPaid = $booking->is_fully_paid;
        $isDpPaid = in_array($booking->payment_status, ['dp_paid', 'paid']);
        $txnCode = $payment->transaction_code ?? ('PAY-' . $booking->booking_code);
        $payMethod = $payment->payment_method ?? ($booking->payment_method ?? 'qris');
    @endphp

    <!-- Top Banner -->
    <section class="relative bg-primary-dark text-white pt-36 pb-16 md:pt-44 md:pb-20 overflow-hidden border-b border-primary/50 print:hidden">
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-3">
            <div class="text-[10px] uppercase tracking-widest text-accent font-bold">Portal Traveler &amp; Invoice Resmi</div>
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white uppercase font-sans">
                Invoice &amp; Digital Travel Pass
            </h1>
            <p class="text-gray-300 text-xs max-w-md mx-auto">
                Kode Booking: <span class="font-mono font-bold text-accent">{{ $booking->booking_code }}</span> &bull; Status: <span class="text-white font-semibold uppercase">{{ $booking->status_label }}</span>
            </p>
        </div>
    </section>

    <!-- Main Container -->
    <section class="py-12 md:py-16 bg-[#F8FAF9] min-h-[80vh]" x-data="{
        isProcessing: false,
        paymentStatus: '{{ $isFullyPaid ? 'paid' : ($isDpPaid ? 'dp_paid' : 'unpaid') }}',
        remainingAmount: {{ (int)$remainingAmount }},
        deliveryMethod: '{{ old('delivery_method', $booking->delivery_method ?? 'pickup_workshop') }}',
        deliveryAddress: '{{ old('delivery_address', $booking->delivery_address ?? (auth()->check() ? auth()->user()->address : '')) }}',
        deliveryNotes: '{{ old('delivery_notes', $booking->delivery_notes ?? '') }}',
        deliverySaved: false,
        deliveryLoading: false,

        simulatePay(type) {
            this.isProcessing = true;
            fetch('{{ route('payment.simulate', $booking->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_type: type,
                    payment_method: '{{ $payMethod }}'
                })
            })
            .then(res => res.json())
            .then(data => {
                this.isProcessing = false;
                if(data.success) {
                    if (type === 'remaining' || type === 'settlement' || type === 'full') {
                        this.paymentStatus = 'paid';
                        this.remainingAmount = 0;
                    } else {
                        this.paymentStatus = 'dp_paid';
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                }
            })
            .catch(() => {
                this.isProcessing = false;
            });
        },

        saveDelivery() {
            this.deliveryLoading = true;
            this.deliverySaved = false;
            fetch('{{ route('booking.delivery_method', $booking->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    delivery_method: this.deliveryMethod,
                    delivery_address: this.deliveryAddress,
                    delivery_notes: this.deliveryNotes
                })
            })
            .then(res => res.json())
            .then(data => {
                this.deliveryLoading = false;
                if(data.success) {
                    this.deliverySaved = true;
                    setTimeout(() => { this.deliverySaved = false; }, 4000);
                }
            })
            .catch(() => {
                this.deliveryLoading = false;
            });
        }
    }">
        <div class="max-w-4xl mx-auto px-6 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-white rounded-xl border border-emerald-300 text-emerald-900 text-xs space-y-1 shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <div>
                        <div class="font-bold uppercase tracking-wider">Berhasil:</div>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- NOTICE BANNER: Trip Completed -->
            @if($isCompleted)
                <div class="bg-primary text-white p-6 md:p-8 rounded-2xl space-y-3 shadow-lg border border-sage/40">
                    <div class="flex items-center space-x-2 text-[10px] uppercase tracking-wider text-accent font-bold">
                        <i class="fa-solid fa-flag-checkered text-accent"></i>
                        <span>Ekspedisi Wisata Selesai &amp; Sukses</span>
                    </div>
                    <h2 class="text-xl md:text-2xl font-bold uppercase tracking-wide font-sans">
                        Perjalanan Wisata Telah Selesai dengan Selamat
                    </h2>
                    <p class="text-gray-200 text-xs leading-relaxed max-w-2xl">
                        Terima kasih telah mempercayakan petualangan Anda bersama pemandu berlisensi resmi Nusantara Tour Guide. Silakan pastikan pelunasan sisa pembayaran telah selesai di bawah ini.
                    </p>
                </div>
            @endif

            <!-- Invoice Document Paper Card -->
            <div class="tour-card p-8 md:p-12 shadow-soft space-y-8 bg-white">
                
                <!-- Header / Logo & Invoice Meta -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-gray-100 gap-4">
                    <div>
                        <div class="text-2xl font-bold uppercase tracking-wider font-sans text-primary">{{ \App\Models\SiteSetting::get('company_name', 'NUSANTARA TOUR GUIDE') }}</div>
                        <div class="text-[10px] text-sage uppercase mt-0.5 tracking-wider font-bold">{{ \App\Models\SiteSetting::get('company_tagline', 'Pemandu Wisata Resmi Berlisensi HPI & Ekspedisi Indonesia') }}</div>
                        <div class="text-xs text-gray-500 mt-1">Travel Pass Resmi &bull; No: <span class="font-mono font-bold text-primary">{{ $booking->booking_code }}</span></div>
                    </div>
                    <div class="text-left sm:text-right space-y-1">
                        @if($isFullyPaid)
                            <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 text-[10px] uppercase tracking-wider font-bold">
                                ✓ LUNAS PENUH (FULLY PAID)
                            </span>
                        @elseif($isDpPaid)
                            @if($isCompleted)
                                <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-[10px] uppercase tracking-wider font-bold">
                                    MENUNGGU PELUNASAN SISA
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full bg-sage-light text-sage border border-sage/40 text-[10px] uppercase tracking-wider font-bold">
                                    DP TERBAYAR (JADWAL TERKUNCI)
                                </span>
                            @endif
                        @else
                            <span class="inline-block px-3 py-1 rounded-full bg-rose-100 text-rose-800 border border-rose-300 text-[10px] uppercase tracking-wider font-bold">
                                MENUNGGU PEMBAYARAN DP
                            </span>
                        @endif

                        <div class="text-xs text-gray-500">
                            Tanggal: {{ $booking->created_at ? $booking->created_at->translatedFormat('d F Y') : date('d F Y') }}
                        </div>
                    </div>
                </div>

                <!-- Customer & Trip Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-gray-700">
                    <div class="space-y-1.5 p-4 rounded-xl bg-[#F8FAF9] border border-gray-100">
                        <div class="font-bold text-primary uppercase tracking-wider text-[10px]">Data Tamu / Traveler:</div>
                        <div class="font-bold text-primary text-sm">{{ $booking->customer_name }}</div>
                        <div>No. WhatsApp: <span class="font-mono text-primary font-semibold">{{ $booking->customer_phone }}</span></div>
                        <div>Email: <span class="text-primary">{{ $booking->customer_email }}</span></div>
                    </div>

                    <div class="space-y-1.5 p-4 rounded-xl bg-[#F8FAF9] border border-gray-100">
                        <div class="font-bold text-primary uppercase tracking-wider text-[10px]">Rincian Perjalanan &amp; Destinasi:</div>
                        <div class="font-bold text-primary text-sm">{{ $booking->vehicle_brand }} ({{ $booking->vehicle_model }})</div>
                        <div>Peserta / Tamu: <span class="font-mono font-bold text-primary">{{ $booking->license_plate }}</span> ({{ ucfirst($booking->vehicle_type) }})</div>
                        <div>Jadwal Penjemputan: <span class="text-primary font-semibold">{{ $booking->booking_date ? $booking->booking_date->translatedFormat('d F Y') : '-' }} &bull; {{ $booking->booking_time_slot }}</span></div>
                    </div>
                </div>

                <!-- Financial Line Items Breakdown -->
                <div class="rounded-xl border border-gray-200 overflow-hidden text-xs">
                    <div class="bg-[#F8FAF9] px-4 py-3 border-b border-gray-200 flex justify-between font-bold text-primary uppercase text-[10px] tracking-wider">
                        <span>Deskripsi Paket Pemandu Wisata</span>
                        <span>Nominal</span>
                    </div>

                    <div class="p-4 flex justify-between items-start border-b border-gray-100">
                        <div>
                            <div class="font-bold text-primary text-sm">{{ $booking->service->title ?? 'Private Guided Tour & Expedition' }}</div>
                            <div class="text-[11px] text-gray-500 mt-0.5">Kode Registrasi: {{ $booking->booking_code }}</div>
                            @if($booking->guide ?? $booking->mechanic)
                                <div class="text-[11px] text-sage font-semibold mt-0.5">
                                    <i class="fa-solid fa-user-check mr-1"></i> Pemandu Wisata: {{ ($booking->guide ?? $booking->mechanic)->name }}
                                </div>
                            @endif
                        </div>
                        <div class="font-bold text-primary text-sm">
                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Subtotal Breakdown -->
                    <div class="p-4 space-y-2 bg-[#F8FAF9]">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Estimasi Total Biaya Paket:</span>
                            <span class="font-semibold text-primary">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center text-gray-600">
                            <span>Total yang Sudah Terbayar (DP):</span>
                            <span class="font-semibold text-emerald-700">
                                - Rp {{ number_format($paidAmount, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t border-gray-200 font-bold text-base text-primary">
                            <div>
                                <span>Sisa Tagihan Pelunasan:</span>
                                <div class="text-[10px] text-gray-500 font-normal">
                                    {{ $remainingAmount <= 0 ? 'Seluruh biaya paket telah lunas penuh.' : 'Dapat dilunasi secara online atau tunai saat bertemu pemandu di hari H.' }}
                                </div>
                            </div>
                            <div class="text-xl font-bold font-sans text-primary">
                                {{ $remainingAmount <= 0 ? 'LUNAS (Rp 0)' : 'Rp ' . number_format($remainingAmount, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: PAYMENT / SETTLEMENT SIMULATOR (If Remaining Balance Exists) -->
                @if(!$isFullyPaid)
                    <div class="p-6 md:p-8 rounded-2xl bg-[#F8FAF9] border border-gray-200 space-y-6 print:hidden">
                        <div class="border-b border-gray-200 pb-3">
                            <div class="text-[10px] uppercase tracking-wider text-sage font-bold">
                                {{ $isCompleted ? 'Pelunasan Akhir Trip' : ($isDpPaid ? 'Pelunasan Lebih Awal' : 'Pembayaran Uang Muka (DP)') }}
                            </div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-primary">
                                {{ $isCompleted ? 'Instruksi Pelunasan Sisa Tagihan' : ($isDpPaid ? 'Pelunasan Penuh Sisa Tagihan' : 'Instruksi Pembayaran Down Payment (DP)') }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                @if($isCompleted || $isDpPaid)
                                    Nominal yang harus dibayarkan: <strong class="text-primary">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</strong>
                                @else
                                    Nominal Down Payment (DP 30%): <strong class="text-primary">Rp {{ number_format($dpAmount, 0, ',', '.') }}</strong>
                                @endif
                            </p>
                        </div>

                        <!-- QRIS / Virtual Account Box -->
                        @if($payMethod === 'qris')
                            <div class="p-6 bg-white rounded-2xl border border-dashed border-gray-300 flex flex-col items-center justify-center space-y-3 max-w-xs mx-auto text-center shadow-soft">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-primary">QRIS Standar Nasional</div>
                                <div class="p-3 bg-white border border-gray-100 rounded-xl">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=NUSANTARA-TG-PAY-{{ $txnCode }}" alt="QRIS Code" class="w-40 h-40">
                                </div>
                                <div class="text-[10px] text-gray-500">BCA, Mandiri, GoPay, OVO, ShopeePay, DANA</div>
                            </div>
                        @else
                            <div class="p-6 bg-white rounded-2xl border border-gray-200 max-w-sm mx-auto space-y-2 text-center shadow-soft">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-500">BCA Virtual Account</div>
                                <div class="text-xl font-mono font-bold text-primary tracking-wider">88019{{ str_pad($booking->id, 7, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-[10px] text-gray-500">Otomatis terverifikasi dalam hitungan detik setelah transfer</div>
                            </div>
                        @endif

                        <!-- Pay Button Simulator -->
                        <div class="text-center pt-2 space-y-3">
                            @if($isCompleted || $isDpPaid)
                                <button @click="simulatePay('remaining')" 
                                        :disabled="isProcessing"
                                        type="button" 
                                        class="btn-primary w-full sm:w-auto px-8 py-3 shadow-md">
                                    <span x-show="!isProcessing">Simulasikan Pelunasan Sisa Tagihan (Rp {{ number_format($remainingAmount, 0, ',', '.') }}) Berhasil &rarr;</span>
                                    <span x-show="isProcessing" x-cloak>Memverifikasi Pembayaran...</span>
                                </button>
                            @else
                                <button @click="simulatePay('dp')" 
                                        :disabled="isProcessing"
                                        type="button" 
                                        class="btn-primary w-full sm:w-auto px-8 py-3 shadow-md">
                                    <span x-show="!isProcessing">Simulasikan Pembayaran DP (Rp {{ number_format($dpAmount, 0, ',', '.') }}) Berhasil &rarr;</span>
                                    <span x-show="isProcessing" x-cloak>Memverifikasi Pembayaran...</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- SECTION: MEETING POINT & PENJEMPUTAN WISATAWAN -->
                <div class="pt-6 border-t border-gray-100 space-y-6">
                    <div class="border-b border-gray-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <div class="text-[10px] uppercase tracking-wider text-sage font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-map-location-dot text-accent"></i>
                                <span>Konfirmasi Titik Penjemputan / Meeting Point</span>
                            </div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-primary mt-0.5">
                                Lokasi Penjemputan oleh Pemandu Wisata
                            </h3>
                            <p class="text-xs text-gray-500">Pemandu kami akan menunggu dan menyambut Anda di lokasi ini sesuai jam jadwal.</p>
                        </div>
                        @if($booking->delivery_method)
                            <span class="inline-block px-3 py-1 rounded-full bg-sage-light text-sage border border-sage/40 text-[10px] uppercase font-bold tracking-wider">
                                ✓ {{ $booking->delivery_method_label }}
                            </span>
                        @endif
                    </div>

                    <!-- Handover Options Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Option 1: Dijemput di Hotel/Bandara -->
                        <label class="relative p-5 rounded-2xl border cursor-pointer transition-all flex flex-col justify-between space-y-3"
                               :class="deliveryMethod === 'pickup_workshop' ? 'border-primary bg-sage-light/30 ring-2 ring-primary' : 'border-gray-200 bg-white hover:border-gray-300'">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <div class="font-bold text-xs uppercase tracking-wider text-primary">Dijemput Armada Tour Guide</div>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">
                                        Pemandu bersama armada privat menjemput Anda langsung di lobby hotel / terminal kedatangan bandara.
                                    </p>
                                </div>
                                <input type="radio" name="delivery_choice" value="pickup_workshop" x-model="deliveryMethod" class="mt-1 accent-primary">
                            </div>

                            <div class="text-[11px] text-gray-600 bg-white p-3 rounded-xl border border-gray-100 space-y-1">
                                <div class="font-bold text-primary">Titik Pertemuan:</div>
                                <div>{{ $booking->vehicle_model ?? 'Bandara / Hotel yang telah didaftarkan' }}</div>
                                <div class="text-gray-400 text-[10px]">Pemandu memegang papan nama traveler</div>
                            </div>
                        </label>

                        <!-- Option 2: Bertemu Langsung di Meeting Point -->
                        <label class="relative p-5 rounded-2xl border cursor-pointer transition-all flex flex-col justify-between space-y-3"
                               :class="deliveryMethod === 'delivery_address' ? 'border-primary bg-sage-light/30 ring-2 ring-primary' : 'border-gray-200 bg-white hover:border-gray-300'">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <div class="font-bold text-xs uppercase tracking-wider text-primary">Bertemu di Kantor Hub / Titik Kumpul</div>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">
                                        Traveler datang langsung ke Tourism Hub / dermaga penyeberangan kapal kami.
                                    </p>
                                </div>
                                <input type="radio" name="delivery_choice" value="delivery_address" x-model="deliveryMethod" class="mt-1 accent-primary">
                            </div>

                            <div class="text-[11px] text-gray-600 bg-white p-3 rounded-xl border border-gray-100 space-y-1">
                                <div class="font-bold text-primary">Hub Pariwisata:</div>
                                <div>Nusantara Tourism Hub &bull; Pos Pemandu Wisata Resmi</div>
                            </div>
                        </label>

                    </div>

                    <!-- Delivery Details Form -->
                    <div x-show="deliveryMethod === 'delivery_address'" x-transition x-cloak class="p-5 bg-[#F8FAF9] rounded-2xl border border-gray-200 space-y-4 text-xs">
                        <div class="font-bold text-primary uppercase tracking-wider text-[11px]">Konfirmasi Alamat Penginapan / Titik Temu Tambahan:</div>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Alamat Hotel / Villa / Lokasi Spesifik *</label>
                                <textarea x-model="deliveryAddress" rows="2" placeholder="Nama hotel, nomor kamar, nama jalan, area kota..."
                                          class="w-full bg-white border border-gray-200 text-gray-800 text-xs px-3.5 py-2.5 rounded-xl focus:outline-none focus:border-primary">{{ old('delivery_address', $booking->delivery_address) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Catatan Khusus Penjemputan</label>
                                <input type="text" x-model="deliveryNotes" placeholder="Contoh: Tolong hubungi WA 15 menit sebelum tiba di hotel"
                                       class="w-full bg-white border border-gray-200 text-gray-800 text-xs px-3.5 py-2.5 rounded-xl focus:outline-none focus:border-primary">
                            </div>
                        </div>
                    </div>

                    <!-- Save Handover Button -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                        <button type="button" 
                                @click="saveDelivery()"
                                :disabled="deliveryLoading"
                                class="btn-primary text-xs px-6 py-2.5 shadow-sm">
                            <span x-show="!deliveryLoading">Simpan Titik Penjemputan &rarr;</span>
                            <span x-show="deliveryLoading" x-cloak>Menyimpan Pilihan...</span>
                        </button>

                        <div x-show="deliverySaved" x-cloak class="text-xs font-bold text-emerald-700 flex items-center gap-1.5">
                            <span>✓</span>
                            <span>Pilihan penjemputan berhasil diperbarui! Pemandu wisata telah diberi notifikasi.</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4 text-xs print:hidden">
                    <div class="flex items-center gap-3">
                        <button onclick="window.print()" type="button" class="px-5 py-2.5 rounded-xl border border-gray-300 hover:border-primary text-primary font-bold text-xs uppercase tracking-wider transition-all">
                            <i class="fa-solid fa-print mr-1"></i> Cetak Travel Pass
                        </button>

                        @if(auth()->check())
                            <a href="{{ route('customer.profile', ['tab' => 'orders']) }}" class="text-gray-500 hover:text-primary underline">
                                &larr; Kembali ke Portal Traveler
                            </a>
                        @else
                            <a href="{{ url('/') }}" class="text-gray-500 hover:text-primary underline">
                                &larr; Kembali ke Beranda
                            </a>
                        @endif
                    </div>

                    <div class="text-gray-400 text-[11px]">
                        Layanan Bantuan 24/7 di WhatsApp: <strong class="text-primary font-mono">{{ \App\Models\SiteSetting::get('contact_whatsapp', '081288889999') }}</strong>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
