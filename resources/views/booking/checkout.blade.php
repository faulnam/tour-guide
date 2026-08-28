@extends('layouts.app')

@section('meta_title', 'Checkout Pembayaran — ' . $booking->booking_code)

@section('content')
<div class="py-12 bg-[#09090b] min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider font-mono
                {{ $booking->payment_status === 'unpaid' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' }}">
                <i class="fa-solid {{ $booking->payment_status === 'unpaid' ? 'fa-hourglass-half' : 'fa-circle-check' }}"></i>
                <span>Status Pembayaran: {{ strtoupper($booking->payment_status) }}</span>
            </div>

            <h1 class="font-racing font-black text-3xl text-white tracking-tight uppercase">
                INVOICE & CHECKOUT BOOKING
            </h1>
            <p class="text-xs text-neutral-400">Kode Booking: <span class="font-mono font-bold text-red-400">{{ $booking->booking_code }}</span></p>
        </div>

        <!-- Main Card -->
        <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
            
            <!-- Booking Status Header -->
            <div class="p-4 rounded-2xl bg-neutral-900/80 border border-neutral-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <div class="text-[11px] text-neutral-400 uppercase font-semibold">Status Pengerjaan</div>
                    <div class="mt-1">{!! $booking->status_badge !!}</div>
                </div>

                <div class="text-right">
                    <div class="text-[11px] text-neutral-400 uppercase font-semibold">Jadwal Kedatangan</div>
                    <div class="text-xs font-bold text-white mt-1">
                        <i class="fa-solid fa-calendar-day text-red-500 mr-1"></i>
                        {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }} ({{ $booking->booking_time_slot }})
                    </div>
                </div>
            </div>

            <!-- Vehicle & Customer Details Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                
                <div class="space-y-3 bg-[#0a0a0e] p-4 rounded-2xl border border-neutral-800/80">
                    <div class="text-xs font-bold text-neutral-300 uppercase tracking-wider font-racing flex items-center gap-2">
                        <span>{{ $booking->vehicle_type_label }}</span>
                        <span>Spesifikasi Unit</span>
                    </div>

                    <div class="space-y-1.5 text-xs text-neutral-300">
                        <div class="flex justify-between"><span class="text-neutral-500">Merk & Model:</span> <span class="font-bold text-white">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</span></div>
                        <div class="flex justify-between"><span class="text-neutral-500">Plat Nomor:</span> <span class="font-mono font-bold text-red-400">{{ $booking->license_plate }}</span></div>
                        <div class="flex justify-between"><span class="text-neutral-500">Tahun:</span> <span>{{ $booking->vehicle_year ?? '-' }}</span></div>
                        <div class="flex justify-between"><span class="text-neutral-500">Warna Bodi:</span> <span>{{ $booking->vehicle_color ?? '-' }}</span></div>
                    </div>
                </div>

                <div class="space-y-3 bg-[#0a0a0e] p-4 rounded-2xl border border-neutral-800/80">
                    <div class="text-xs font-bold text-neutral-300 uppercase tracking-wider font-racing flex items-center gap-2">
                        <i class="fa-solid fa-user text-red-500"></i>
                        <span>Data Pemilik</span>
                    </div>

                    <div class="space-y-1.5 text-xs text-neutral-300">
                        <div class="flex justify-between"><span class="text-neutral-500">Nama:</span> <span class="font-bold text-white">{{ $booking->customer_name }}</span></div>
                        <div class="flex justify-between"><span class="text-neutral-500">Email:</span> <span>{{ $booking->customer_email }}</span></div>
                        <div class="flex justify-between"><span class="text-neutral-500">WhatsApp:</span> <span class="font-bold text-emerald-400">{{ $booking->customer_phone }}</span></div>
                        <div class="flex justify-between"><span class="text-neutral-500">Layanan:</span> <span class="font-bold text-red-400">{{ $booking->service->title ?? 'Custom Tuning' }}</span></div>
                    </div>
                </div>

            </div>

            <!-- Financial Summary Table -->
            <div class="border-t border-neutral-800 pt-5 space-y-3">
                <h4 class="text-xs font-bold text-neutral-300 uppercase tracking-wider font-racing">Rincian Pembayaran</h4>
                
                <div class="bg-[#0a0a0e] rounded-2xl p-4 space-y-2.5 text-xs text-neutral-300 border border-neutral-800">
                    <div class="flex justify-between">
                        <span>Biaya Paket Layanan:</span>
                        <span class="font-mono font-bold text-white">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-400">
                        <span>Down Payment (DP Wajib):</span>
                        <span class="font-mono font-bold text-red-400">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-emerald-400">
                        <span>Total Sudah Dibayar:</span>
                        <span class="font-mono font-bold">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-2 border-t border-neutral-800 flex justify-between text-sm font-bold text-white">
                        <span>Sisa Pembayaran Pelunasan:</span>
                        <span class="font-racing font-black text-amber-400">
                            Rp {{ number_format(max(0, $booking->total_amount - $booking->paid_amount), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- PAYMENT GATEWAY INTERFACE / ACTION -->
            @if($booking->payment_status === 'unpaid')
                <div class="border-t border-neutral-800 pt-6 space-y-4">
                    <div class="text-center space-y-1">
                        <div class="text-xs font-bold text-white uppercase tracking-wider font-racing">Selesaikan Pembayaran DP Sekarang</div>
                        <div class="text-xs text-neutral-400">Gunakan Payment Gateway QRIS / Virtual Account Simulator di bawah ini:</div>
                    </div>

                    <!-- Payment Gateway Simulation Box -->
                    <div class="bg-gradient-to-b from-[#181822] to-[#0e0e14] border border-red-500/40 rounded-2xl p-6 text-center space-y-4 shadow-xl glow-red">
                        
                        <div class="max-w-xs mx-auto bg-white p-3 rounded-2xl shadow-lg">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=APEX-GARAGE-PAY-{{ $booking->booking_code }}-RP-{{ $booking->dp_amount }}" 
                                 alt="QRIS Barcode" class="w-48 h-48 mx-auto object-contain">
                            <div class="text-[10px] text-black font-bold uppercase mt-1 tracking-wider">NMID: ID1020268889999</div>
                        </div>

                        <div class="space-y-1">
                            <div class="text-xs text-neutral-400">Jumlah Tagihan DP:</div>
                            <div class="font-racing font-black text-2xl text-red-400">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</div>
                        </div>

                        <!-- Instant Simulation Action Buttons -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                            <form action="{{ route('payment.simulate', $booking->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_type" value="dp">
                                <input type="hidden" name="payment_method" value="qris">
                                <button type="submit" 
                                        class="w-full py-3.5 px-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl text-xs font-racing font-bold uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-bolt text-amber-300"></i>
                                    <span>Simulasi Bayar DP Berhasil</span>
                                </button>
                            </form>

                            <form action="{{ route('payment.simulate', $booking->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_type" value="full">
                                <input type="hidden" name="payment_method" value="virtual_account">
                                <button type="submit" 
                                        class="w-full py-3.5 px-4 bg-neutral-800 hover:bg-neutral-700 text-white border border-neutral-700 rounded-xl text-xs font-racing font-bold uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-check-double text-emerald-400"></i>
                                    <span>Simulasi Pelunasan Full</span>
                                </button>
                            </form>
                        </div>

                        <div class="text-[10px] text-neutral-500">
                            *Sistem integrasi Payment Gateway otomatis memvalidasi transaksi dalam &lt; 2 detik.
                        </div>

                    </div>
                </div>
            @else
                <!-- Payment Confirmed Banner -->
                <div class="border-t border-neutral-800 pt-6">
                    <div class="bg-emerald-950/40 border border-emerald-500/40 rounded-2xl p-6 text-center space-y-3">
                        <div class="w-12 h-12 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto text-xl">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div class="font-racing font-bold text-lg text-white">PEMBAYARAN DP TELAH DITERIMA</div>
                        <p class="text-xs text-neutral-300 max-w-md mx-auto">
                            Slot antrean dan teknisi modifikasi telah dialokasikan untuk kendaraan Anda. Silakan bawa kendaraan tepat pada jadwal kedatangan.
                        </p>
                        @if(auth()->check())
                            <div class="pt-2">
                                <a href="{{ route('customer.bookings.show', $booking->id) }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all">
                                    <i class="fa-solid fa-satellite-dish"></i>
                                    <span>Buka Live Tracker Pengerjaan</span>
                                </a>
                            </div>
                        @else
                            <div class="pt-2">
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all">
                                    <span>Login ke Akun Customer untuk Tracking Live</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Bottom Actions -->
            <div class="pt-4 border-t border-neutral-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <button onclick="window.print()" class="text-neutral-400 hover:text-white flex items-center gap-1.5 py-2 px-3 rounded-lg bg-neutral-900 border border-neutral-800">
                    <i class="fa-solid fa-print"></i> Cetak / Simpan Invoice PDF
                </button>

                <a href="{{ url('/') }}" class="text-neutral-400 hover:text-white flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
