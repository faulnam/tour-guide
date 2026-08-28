@extends('layouts.app')

@section('meta_title', 'Payment Gateway Checkout — ' . $booking->booking_code)

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-24 overflow-hidden">
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Payment Gateway Portal</div>
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight text-white uppercase font-sans">
                Checkout &amp; Invoice
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-md mx-auto">
                No. Tagihan: <span class="font-mono font-bold text-white">{{ $payment->invoice_number }}</span>
            </p>
        </div>
    </section>

    <!-- Invoice Details & Simulator -->
    <section class="py-16 md:py-24 bg-neutral-bg" x-data="{
        isProcessing: false,
        paymentStatus: '{{ $payment->status }}',
        simulateSuccess() {
            this.isProcessing = true;
            fetch('{{ route('booking.simulate_pay', $payment->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.isProcessing = false;
                if(data.success) {
                    this.paymentStatus = 'paid';
                    setTimeout(() => {
                        window.location.href = '{{ route('customer.bookings.index') }}';
                    }, 2000);
                }
            })
            .catch(() => {
                this.isProcessing = false;
            });
        }
    }">
        <div class="max-w-3xl mx-auto px-6 space-y-8">
            
            <!-- Invoice Paper Card -->
            <div class="bg-white border border-neutral-200 p-8 md:p-12 shadow-sm space-y-8">
                
                <!-- Invoice Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-neutral-200 gap-4">
                    <div>
                        <div class="text-2xl font-bold uppercase tracking-widest3 font-sans">METRIX GARAGE</div>
                        <div class="text-[11px] text-neutral-500 uppercase mt-0.5">Workshop &amp; Tuning Studio</div>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="inline-block px-3 py-1 text-[10px] uppercase tracking-wider font-bold"
                              :class="paymentStatus === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'">
                            <span x-text="paymentStatus === 'paid' ? 'LUNAS (PAID)' : 'MENUNGGU PEMBAYARAN'"></span>
                        </span>
                        <div class="text-xs text-neutral-400 mt-1">{{ $payment->created_at->format('d M Y, H:i') }} WIB</div>
                    </div>
                </div>

                <!-- Booking Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-neutral-700">
                    <div class="space-y-1">
                        <div class="font-bold text-black uppercase tracking-wider text-[11px]">Informasi Customer:</div>
                        <div class="font-semibold text-black">{{ $booking->customer_name }}</div>
                        <div>{{ $booking->customer_phone }}</div>
                        <div>{{ $booking->customer_email }}</div>
                    </div>

                    <div class="space-y-1">
                        <div class="font-bold text-black uppercase tracking-wider text-[11px]">Jadwal &amp; Kendaraan:</div>
                        <div class="font-semibold text-black">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }} ({{ $booking->license_plate }})</div>
                        <div>Jadwal: {{ $booking->booking_date->format('d M Y') }} • {{ $booking->booking_time_slot }}</div>
                        <div class="capitalize text-neutral-500">Kategori: {{ $booking->vehicle_type }}</div>
                    </div>
                </div>

                <!-- Line Items Table -->
                <div class="border border-neutral-200 text-xs">
                    <div class="bg-neutral-bg px-4 py-3 border-b border-neutral-200 flex justify-between font-bold text-black uppercase text-[10px] tracking-wider">
                        <span>Rincian Item</span>
                        <span>Jumlah</span>
                    </div>
                    <div class="p-4 flex justify-between items-start border-b border-neutral-100">
                        <div>
                            <div class="font-bold text-black">{{ $booking->service->title ?? 'Custom Tuning & Modifikasi' }}</div>
                            <div class="text-[11px] text-neutral-500 mt-0.5">Booking Code: {{ $booking->booking_code }}</div>
                        </div>
                        <div class="font-semibold text-black">
                            {{ $booking->service ? $booking->service->formatted_price : 'Estimasi Pengerjaan' }}
                        </div>
                    </div>
                    <div class="p-4 bg-neutral-50 flex justify-between items-center font-bold text-sm text-black">
                        <div>
                            <div>Down Payment (DP Wajib):</div>
                            <div class="text-[10px] text-neutral-500 font-normal">Sisa pembayaran dilunasi setelah mobil/motor selesai dikerjakan</div>
                        </div>
                        <div class="text-lg">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Payment Method Simulator View -->
                <div class="pt-2 space-y-6">
                    <div class="text-center space-y-2">
                        <div class="eyebrow text-black font-semibold">Payment Gateway Simulator</div>
                        <p class="text-xs text-neutral-500">Scan QRIS atau salin Virtual Account berikut untuk menyelesaikan pembayaran DP:</p>
                    </div>

                    @if($payment->payment_method === 'qris')
                        <div class="p-6 bg-white border border-dashed border-neutral-300 flex flex-col items-center justify-center space-y-4 max-w-sm mx-auto text-center">
                            <div class="text-[11px] font-bold uppercase tracking-widest text-black">QRIS Standar Nasional</div>
                            <div class="p-4 bg-white border border-neutral-200">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=METRIX-PAY-{{ $payment->invoice_number }}" alt="QRIS Code" class="w-44 h-44">
                            </div>
                            <div class="text-[10px] text-neutral-500">Mendukung BCA Mobile, GoPay, OVO, ShopeePay, DANA, Livin Mandiri</div>
                        </div>
                    @else
                        <div class="p-6 bg-neutral-bg border border-neutral-200 max-w-sm mx-auto space-y-3 text-center">
                            <div class="text-[11px] font-bold uppercase tracking-widest text-neutral-500">BCA Virtual Account</div>
                            <div class="text-xl font-mono font-bold text-black tracking-wider">88019{{ str_pad($payment->id, 7, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-[10px] text-neutral-500">Otomatis terverifikasi dalam 30 detik setelah transfer</div>
                        </div>
                    @endif

                    <!-- Simulator Trigger Button -->
                    <div class="text-center pt-2 space-y-3">
                        <div x-show="paymentStatus !== 'paid'">
                            <button @click="simulateSuccess()" 
                                    :disabled="isProcessing"
                                    type="button" 
                                    class="btn-dark w-full sm:w-auto">
                                <span x-show="!isProcessing">Simulasikan Pembayaran Berhasil &rarr;</span>
                                <span x-show="isProcessing" x-cloak>Memverifikasi ke Gateway...</span>
                            </button>
                        </div>

                        <div x-show="paymentStatus === 'paid'" x-cloak class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs">
                            <div class="font-bold">Pembayaran DP Berhasil Dikonfirmasi!</div>
                            <div>Unit Anda telah masuk jadwal workshop. Mengalihkan ke Dashboard...</div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('booking.index') }}" class="text-xs text-neutral-500 hover:text-black underline">
                                &larr; Buat Jadwal Booking Lain
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection
