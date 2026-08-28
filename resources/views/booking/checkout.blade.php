@extends('layouts.app')

@section('meta_title', 'Invoice & Pelunasan — ' . $booking->booking_code)

@section('content')

    @php
        $totalAmount = (float) ($booking->total_amount > 0 ? $booking->total_amount : ($booking->service->price ?? 0));
        $paidAmount = (float) $booking->paid_amount;
        $remainingAmount = max(0, $totalAmount - $paidAmount);
        $dpAmount = (float) ($booking->dp_amount > 0 ? $booking->dp_amount : 250000);
        $isCompleted = ($booking->status === 'completed');
        $isFullyPaid = $booking->is_fully_paid;
        $isDpPaid = in_array($booking->payment_status, ['dp_paid', 'paid']);
        $txnCode = $payment->transaction_code ?? ('PAY-' . $booking->booking_code);
        $payMethod = $payment->payment_method ?? ($booking->payment_method ?? 'qris');
    @endphp

    <!-- Top Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-16 md:pt-44 md:pb-20 overflow-hidden border-b border-neutral-800 print:hidden">
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-3">
            <div class="text-[10px] uppercase tracking-widest text-accent font-semibold">Payment &amp; Handover Portal</div>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white uppercase font-sans">
                Invoice &amp; Status Pelunasan
            </h1>
            <p class="text-neutral-400 text-xs max-w-md mx-auto">
                Nomor Booking: <span class="font-mono font-bold text-white">{{ $booking->booking_code }}</span> &bull; Status: <span class="text-white font-semibold uppercase">{{ $booking->status_label }}</span>
            </p>
        </div>
    </section>

    <!-- Main Container -->
    <section class="py-12 md:py-16 bg-neutral-bg min-h-[80vh]" x-data="{
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
                <div class="p-4 bg-white border border-neutral-300 text-black text-xs space-y-1 shadow-sm">
                    <div class="font-bold uppercase tracking-wider">Berhasil:</div>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- NOTICE BANNER: Work Completed -->
            @if($isCompleted)
                <div class="bg-black text-white p-6 md:p-8 space-y-3 shadow-lg border border-neutral-800">
                    <div class="flex items-center space-x-2 text-[10px] uppercase tracking-widest text-accent font-bold">
                        <span class="w-2 h-2 bg-accent inline-block"></span>
                        <span>Unit Modifikasi Siap Diserahkan</span>
                    </div>
                    <h2 class="text-xl md:text-2xl font-bold uppercase tracking-wide font-sans">
                        Pengerjaan Kendaraan Telah Selesai &amp; Lulus QC
                    </h2>
                    <p class="text-neutral-300 text-xs leading-relaxed max-w-2xl">
                        Seluruh tahapan kalibrasi dan pengerjaan mekanik telah rampung 100%. Silakan pastikan pelunasan sisa pembayaran telah selesai dan tentukan opsi penyerahan unit kendaraan Anda di bawah ini.
                    </p>
                </div>
            @endif

            <!-- Invoice Document Paper Card -->
            <div class="bg-white border border-neutral-200 p-8 md:p-12 shadow-sm space-y-8">
                
                <!-- Header / Logo & Invoice Meta -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-neutral-200 gap-4">
                    <div>
                        <div class="text-2xl font-extrabold uppercase tracking-widest3 font-sans">{{ \App\Models\SiteSetting::get('company_name', 'BENGKEL') }}</div>
                        <div class="text-[10px] text-neutral-500 uppercase mt-0.5 tracking-wider">{{ \App\Models\SiteSetting::get('company_tagline', 'Workshop & Studio Modifikasi Motor dan Mobil') }}</div>
                        <div class="text-xs text-neutral-400 mt-1">Invoice Resmi Workshop &bull; No: <span class="font-mono font-bold text-black">{{ $booking->booking_code }}</span></div>
                    </div>
                    <div class="text-left sm:text-right space-y-1">
                        @if($isFullyPaid)
                            <span class="inline-block px-3 py-1 bg-black text-white text-[10px] uppercase tracking-widest font-bold">
                                LUNAS PENUH (FULLY PAID)
                            </span>
                        @elseif($isDpPaid)
                            @if($isCompleted)
                                <span class="inline-block px-3 py-1 bg-neutral-100 text-black border border-black text-[10px] uppercase tracking-widest font-bold">
                                    MENUNGGU PELUNASAN SISA
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-neutral-100 text-black border border-neutral-300 text-[10px] uppercase tracking-widest font-bold">
                                    DP TERBAYAR (IN PROGRESS)
                                </span>
                            @endif
                        @else
                            <span class="inline-block px-3 py-1 bg-neutral-100 text-neutral-700 border border-neutral-300 text-[10px] uppercase tracking-widest font-bold">
                                MENUNGGU PEMBAYARAN DP
                            </span>
                        @endif

                        <div class="text-xs text-neutral-400">
                            Tanggal: {{ $booking->created_at ? $booking->created_at->translatedFormat('d F Y') : date('d F Y') }}
                        </div>
                    </div>
                </div>

                <!-- Customer & Vehicle Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-neutral-700">
                    <div class="space-y-1.5 p-4 bg-neutral-bg border border-neutral-200">
                        <div class="font-bold text-black uppercase tracking-wider text-[10px]">Data Customer:</div>
                        <div class="font-bold text-black text-sm">{{ $booking->customer_name }}</div>
                        <div>No. WhatsApp: <span class="font-mono text-black font-semibold">{{ $booking->customer_phone }}</span></div>
                        <div>Email: <span class="text-black">{{ $booking->customer_email }}</span></div>
                    </div>

                    <div class="space-y-1.5 p-4 bg-neutral-bg border border-neutral-200">
                        <div class="font-bold text-black uppercase tracking-wider text-[10px]">Spesifikasi Kendaraan:</div>
                        <div class="font-bold text-black text-sm">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</div>
                        <div>Nomor Plat: <span class="font-mono font-bold text-black">{{ $booking->license_plate }}</span> ({{ ucfirst($booking->vehicle_type) }})</div>
                        <div>Jadwal Masuk: <span class="text-black font-semibold">{{ $booking->booking_date ? $booking->booking_date->translatedFormat('d F Y') : '-' }} &bull; {{ $booking->booking_time_slot }}</span></div>
                    </div>
                </div>

                <!-- Financial Line Items Breakdown -->
                <div class="border border-neutral-200 text-xs">
                    <div class="bg-neutral-bg px-4 py-3 border-b border-neutral-200 flex justify-between font-bold text-black uppercase text-[10px] tracking-wider">
                        <span>Deskripsi Layanan &amp; Pengerjaan</span>
                        <span>Nominal</span>
                    </div>

                    <div class="p-4 flex justify-between items-start border-b border-neutral-100">
                        <div>
                            <div class="font-bold text-black text-sm">{{ $booking->service->title ?? 'Custom Tuning & Modifikasi' }}</div>
                            <div class="text-[11px] text-neutral-500 mt-0.5">Kode Registrasi: {{ $booking->booking_code }}</div>
                            @if($booking->mechanic)
                                <div class="text-[11px] text-neutral-600 mt-0.5">Lead Mekanik: {{ $booking->mechanic->name }}</div>
                            @endif
                        </div>
                        <div class="font-bold text-black text-sm">
                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Subtotal Breakdown -->
                    <div class="p-4 space-y-2 bg-neutral-50/50">
                        <div class="flex justify-between items-center text-neutral-600">
                            <span>Estimasi Total Biaya Pengerjaan:</span>
                            <span class="font-semibold text-black">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center text-neutral-600">
                            <span>Total yang Sudah Terbayar (DP):</span>
                            <span class="font-semibold text-black">
                                - Rp {{ number_format($paidAmount, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t border-neutral-200 font-bold text-base text-black">
                            <div>
                                <span>Sisa Tagihan Pelunasan:</span>
                                <div class="text-[10px] text-neutral-500 font-normal">
                                    {{ $remainingAmount <= 0 ? 'Seluruh biaya pengerjaan telah lunas penuh.' : 'Wajib dilunasi sebelum unit kendaraan diserahkan/diantar.' }}
                                </div>
                            </div>
                            <div class="text-xl font-extrabold font-sans text-black">
                                {{ $remainingAmount <= 0 ? 'LUNAS (Rp 0)' : 'Rp ' . number_format($remainingAmount, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: PAYMENT / SETTLEMENT SIMULATOR (If Remaining Balance Exists) -->
                @if(!$isFullyPaid)
                    <div class="p-6 md:p-8 bg-neutral-bg border border-neutral-200 space-y-6 print:hidden">
                        <div class="border-b border-neutral-200 pb-3">
                            <div class="text-[10px] uppercase tracking-widest text-accent font-bold">
                                {{ $isCompleted ? 'Pelunasan Akhir Pengerjaan' : ($isDpPaid ? 'Pelunasan Lebih Awal' : 'Pembayaran Uang Muka (DP)') }}
                            </div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-black">
                                {{ $isCompleted ? 'Instruksi Pelunasan Sisa Tagihan' : ($isDpPaid ? 'Pelunasan Penuh Sisa Tagihan' : 'Instruksi Pembayaran Down Payment (DP)') }}
                            </h3>
                            <p class="text-xs text-neutral-500 mt-0.5">
                                @if($isCompleted || $isDpPaid)
                                    Nominal yang harus dibayarkan: <strong class="text-black">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</strong>
                                @else
                                    Nominal Down Payment (DP): <strong class="text-black">Rp {{ number_format($dpAmount, 0, ',', '.') }}</strong>
                                @endif
                            </p>
                        </div>

                        <!-- QRIS / Virtual Account Box -->
                        @if($payMethod === 'qris')
                            <div class="p-6 bg-white border border-dashed border-neutral-300 flex flex-col items-center justify-center space-y-3 max-w-xs mx-auto text-center">
                                <div class="text-[10px] font-bold uppercase tracking-widest text-black">QRIS Standar Nasional</div>
                                <div class="p-3 bg-white border border-neutral-200">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=BENGKEL-PAY-{{ $txnCode }}" alt="QRIS Code" class="w-40 h-40">
                                </div>
                                <div class="text-[10px] text-neutral-500">BCA, Mandiri, GoPay, OVO, ShopeePay, DANA, AstraPay</div>
                            </div>
                        @else
                            <div class="p-6 bg-white border border-neutral-200 max-w-sm mx-auto space-y-2 text-center">
                                <div class="text-[10px] font-bold uppercase tracking-widest text-neutral-500">BCA Virtual Account</div>
                                <div class="text-xl font-mono font-bold text-black tracking-wider">88019{{ str_pad($booking->id, 7, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-[10px] text-neutral-500">Otomatis terverifikasi dalam 30 detik setelah transfer</div>
                            </div>
                        @endif

                        <!-- Pay Button Simulator -->
                        <div class="text-center pt-2 space-y-3">
                            @if($isCompleted || $isDpPaid)
                                <button @click="simulatePay('remaining')" 
                                        :disabled="isProcessing"
                                        type="button" 
                                        class="btn-dark w-full sm:w-auto px-8 py-3">
                                    <span x-show="!isProcessing">Simulasikan Pelunasan Sisa Tagihan (Rp {{ number_format($remainingAmount, 0, ',', '.') }}) Berhasil &rarr;</span>
                                    <span x-show="isProcessing" x-cloak>Memverifikasi Pembayaran...</span>
                                </button>
                            @else
                                <button @click="simulatePay('dp')" 
                                        :disabled="isProcessing"
                                        type="button" 
                                        class="btn-dark w-full sm:w-auto px-8 py-3">
                                    <span x-show="!isProcessing">Simulasikan Pembayaran DP (Rp {{ number_format($dpAmount, 0, ',', '.') }}) Berhasil &rarr;</span>
                                    <span x-show="isProcessing" x-cloak>Memverifikasi Pembayaran...</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- SECTION: VEHICLE HANDOVER / OPSI PENYERAHAN KENDARAAN -->
                <div class="pt-6 border-t border-neutral-200 space-y-6">
                    <div class="border-b border-neutral-200 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <div class="text-[10px] uppercase tracking-widest text-accent font-bold">Opsi Penyerahan Unit</div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-black">
                                Metode Pengambilan / Pengantaran Kendaraan
                            </h3>
                            <p class="text-xs text-neutral-500">Tentukan apakah kendaraan akan diambil sendiri ke workshop atau diantar ke alamat Anda.</p>
                        </div>
                        @if($booking->delivery_method)
                            <span class="inline-block px-2.5 py-1 bg-neutral-100 text-black border border-neutral-300 text-[10px] uppercase font-bold tracking-wider">
                                {{ $booking->delivery_method_label }}
                            </span>
                        @endif
                    </div>

                    <!-- Handover Options Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Option 1: Diambil Sendiri -->
                        <label class="relative p-5 border cursor-pointer transition-all flex flex-col justify-between space-y-3"
                               :class="deliveryMethod === 'pickup_workshop' ? 'border-black bg-neutral-50 ring-1 ring-black' : 'border-neutral-200 bg-white hover:border-neutral-400'">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <div class="font-bold text-xs uppercase tracking-wider text-black">Diambil Sendiri ke Workshop</div>
                                    <p class="text-[11px] text-neutral-500 leading-relaxed">
                                        Anda atau perwakilan mengambil unit langsung di studio workshop BENGKEL.
                                    </p>
                                </div>
                                <input type="radio" name="delivery_choice" value="pickup_workshop" x-model="deliveryMethod" class="mt-1 accent-black">
                            </div>

                            <div class="text-[11px] text-neutral-600 bg-white p-3 border border-neutral-200 space-y-1">
                                <div class="font-semibold text-black">Lokasi Workshop:</div>
                                <div>Jl. Raya Modifikasi No. 88, Workshop Studio &amp; Dyno Lab, Jakarta</div>
                                <div class="text-neutral-400 text-[10px]">Senin – Sabtu &bull; 08:30 – 18:00 WIB</div>
                            </div>
                        </label>

                        <!-- Option 2: Diantar ke Alamat Customer -->
                        <label class="relative p-5 border cursor-pointer transition-all flex flex-col justify-between space-y-3"
                               :class="deliveryMethod === 'delivery_address' ? 'border-black bg-neutral-50 ring-1 ring-black' : 'border-neutral-200 bg-white hover:border-neutral-400'">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <div class="font-bold text-xs uppercase tracking-wider text-black">Diantar ke Alamat (Delivery / Towing)</div>
                                    <p class="text-[11px] text-neutral-500 leading-relaxed">
                                        Unit dikirimkan dengan aman menggunakan towing / valet delivery ke alamat Anda.
                                    </p>
                                </div>
                                <input type="radio" name="delivery_choice" value="delivery_address" x-model="deliveryMethod" class="mt-1 accent-black">
                            </div>

                            <div class="text-[11px] text-neutral-600 bg-white p-3 border border-neutral-200 space-y-1">
                                <div class="font-semibold text-black">Ketentuan Pengantaran:</div>
                                <div>Driver/towing kami akan menghubungi WhatsApp Anda sebelum unit diberangkatkan.</div>
                            </div>
                        </label>

                    </div>

                    <!-- Delivery Details Form (Appears when Diantar ke Alamat is selected) -->
                    <div x-show="deliveryMethod === 'delivery_address'" x-transition x-cloak class="p-5 bg-neutral-50 border border-neutral-200 space-y-4 text-xs">
                        <div class="font-bold text-black uppercase tracking-wider text-[11px]">Konfirmasi Alamat Pengantaran:</div>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Alamat Lengkap Tujuan Pengiriman *</label>
                                <textarea x-model="deliveryAddress" rows="2" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota, kode pos..."
                                          class="w-full bg-white border border-neutral-300 text-black text-xs px-3.5 py-2.5 focus:outline-none focus:border-black">{{ old('delivery_address', $booking->delivery_address) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Catatan Waktu / Instruksi Pengantaran Khusus (Opsional)</label>
                                <input type="text" x-model="deliveryNotes" placeholder="Contoh: Tolong diantar setelah jam 14:00 WIB, titipkan ke satpam jika belum ada di rumah"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-3.5 py-2.5 focus:outline-none focus:border-black">
                            </div>
                        </div>
                    </div>

                    <!-- Save Handover Button -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                        <button type="button" 
                                @click="saveDelivery()"
                                :disabled="deliveryLoading"
                                class="btn-dark text-xs px-6 py-2.5">
                            <span x-show="!deliveryLoading">Simpan Opsi Penyerahan Kendaraan &rarr;</span>
                            <span x-show="deliveryLoading" x-cloak>Menyimpan Pilihan...</span>
                        </button>

                        <div x-show="deliverySaved" x-cloak class="text-xs font-bold text-black flex items-center gap-1.5">
                            <span>✓</span>
                            <span>Opsi penyerahan unit berhasil diperbarui!</span>
                        </div>
                    </div>

                </div>

                <!-- Footer Action Buttons -->
                <div class="pt-6 border-t border-neutral-200 flex flex-wrap items-center justify-between gap-4 text-xs print:hidden">
                    <div class="flex items-center gap-3">
                        <button onclick="window.print()" type="button" class="btn-outline-dark text-xs py-2 px-4">
                            Cetak / Print Invoice
                        </button>

                        @if(auth()->check())
                            <a href="{{ route('customer.profile', ['tab' => 'orders']) }}" class="text-neutral-500 hover:text-black underline">
                                &larr; Kembali ke Portal Customer
                            </a>
                        @else
                            <a href="{{ url('/') }}" class="text-neutral-500 hover:text-black underline">
                                &larr; Kembali ke Beranda
                            </a>
                        @endif
                    </div>

                    <div class="text-neutral-400 text-[11px]">
                        Butuh bantuan? Hubungi CS BENGKEL di WhatsApp <strong class="text-black font-mono">{{ \App\Models\SiteSetting::get('company_whatsapp', '+6281288889999') }}</strong>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
