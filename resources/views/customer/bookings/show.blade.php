@extends('layouts.customer')

@section('title', 'Live Tracker — ' . $booking->booking_code)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('customer.bookings.index') }}" class="text-xs text-red-400 hover:underline mb-1 inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat Booking
            </a>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight">
                LIVE BUILD TRACKER: {{ $booking->booking_code }}
            </h1>
        </div>
        <div class="flex items-center gap-2">
            {!! $booking->status_badge !!}
            {!! $booking->payment_badge !!}
        </div>
    </div>

    <!-- Live Stage Progress Bar -->
    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="font-racing font-bold text-base text-white uppercase">TAHAPAN PENGERJAAN KENDARAAN</h3>
            <span class="font-racing font-black text-xl text-red-500">{{ $booking->progress_percentage }}% SELESAI</span>
        </div>

        <!-- 5-Step Stage Visual Flow -->
        @php
            $stages = [
                ['key' => 'pending', 'label' => '1. Booking Diterima', 'icon' => 'calendar-check'],
                ['key' => 'confirmed', 'label' => '2. Unit di Workshop', 'icon' => 'warehouse'],
                ['key' => 'in_progress', 'label' => '3. Dikerjakan Mekanik', 'icon' => 'wrench'],
                ['key' => 'qc', 'label' => '4. Dyno & Final QC', 'icon' => 'gauge-high'],
                ['key' => 'completed', 'label' => '5. Siap Diambil', 'icon' => 'flag-checkered'],
            ];

            $currentRank = match($booking->status) {
                'confirmed' => 2,
                'in_progress' => 3,
                'qc' => 4,
                'completed' => 5,
                default => 1,
            };
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 pt-2">
            @foreach($stages as $idx => $st)
                @php $rank = $idx + 1; @endphp
                <div class="p-3.5 rounded-2xl border text-center space-y-2 transition-all
                    {{ $rank <= $currentRank ? 'bg-red-600/10 border-red-500 text-white' : 'bg-[#0a0a0e] border-neutral-800 text-neutral-500 opacity-60' }}">
                    <div class="w-10 h-10 rounded-full mx-auto flex items-center justify-center text-sm font-bold
                        {{ $rank < $currentRank ? 'bg-emerald-500 text-white' : ($rank == $currentRank ? 'bg-red-600 text-white animate-pulse' : 'bg-neutral-800 text-neutral-500') }}">
                        <i class="fa-solid fa-{{ $st['icon'] }}"></i>
                    </div>
                    <div class="text-[11px] font-bold">{{ $st['label'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="w-full bg-neutral-900 rounded-full h-3 overflow-hidden border border-neutral-800">
            <div class="bg-gradient-to-r from-red-600 via-amber-500 to-emerald-500 h-3 rounded-full transition-all duration-700" style="width: {{ $booking->progress_percentage }}%"></div>
        </div>

        @if($booking->mechanic)
            <div class="p-4 bg-[#0a0a0e] border border-neutral-800 rounded-2xl flex items-center justify-between text-xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-id-badge"></i>
                    </div>
                    <div>
                        <div class="font-bold text-white">Ditangani oleh: {{ $booking->mechanic->name }}</div>
                        <div class="text-[10px] text-amber-400">{{ $booking->mechanic->specialty ?? 'Lead Tuner' }}</div>
                    </div>
                </div>
                <span class="text-[11px] text-neutral-400 font-mono">Status: Aktif</span>
            </div>
        @endif
    </div>

    <!-- Live Activity Logs / Mechanic Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 space-y-6">
            <h3 class="font-racing font-bold text-base text-white uppercase flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                <span>LOG PROGRES AKTIVITAS DARI WORKSHOP</span>
            </h3>

            <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-neutral-800">
                @forelse($booking->logs as $log)
                    <div class="relative flex items-start gap-4 pl-8">
                        <div class="absolute left-1.5 top-1 w-4 h-4 rounded-full bg-red-500 border-2 border-neutral-900 shadow"></div>
                        <div class="flex-1 bg-[#0a0a0e] border border-neutral-800/80 p-4 rounded-2xl space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-white">{{ $log->title }}</span>
                                <span class="text-neutral-500 font-mono text-[10px]">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                            <p class="text-xs text-neutral-300 leading-relaxed">{{ $log->description }}</p>
                            
                            @if($log->photo_path)
                                <div class="pt-2">
                                    <img src="{{ $log->photo_url }}" class="w-full sm:w-64 h-40 object-cover rounded-xl border border-neutral-700">
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-xs text-neutral-500 pl-8">
                        Belum ada update log pengerjaan dari teknisi.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Digital Invoice & Summary -->
        <div class="space-y-6">
            
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-4 shadow-xl">
                <h4 class="font-racing font-bold text-xs text-white uppercase tracking-wider">DIGITAL INVOICE</h4>

                <div class="space-y-2 text-xs text-neutral-300">
                    <div class="flex justify-between"><span class="text-neutral-500">Unit:</span> <span class="font-bold text-white">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Plat Nomor:</span> <span class="font-mono font-bold text-red-400">{{ $booking->license_plate }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Paket Layanan:</span> <span class="font-bold text-white">{{ $booking->service->title ?? 'Custom Tuning' }}</span></div>
                </div>

                <div class="pt-3 border-t border-neutral-800 space-y-2 text-xs">
                    <div class="flex justify-between text-neutral-400"><span>Estimasi Total:</span> <span class="font-mono text-white">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between text-neutral-400"><span>Down Payment (DP):</span> <span class="font-mono text-red-400">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between text-emerald-400 font-bold"><span>Total Dibayar:</span> <span class="font-mono">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</span></div>
                    <div class="pt-2 border-t border-neutral-800 flex justify-between font-bold text-sm">
                        <span>Sisa Tagihan:</span>
                        <span class="font-racing text-amber-400">Rp {{ number_format(max(0, $booking->total_amount - $booking->paid_amount), 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($booking->payment_status === 'unpaid')
                    <div class="pt-2">
                        <a href="{{ route('booking.checkout', $booking->booking_code) }}" 
                           class="w-full py-3 bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase rounded-xl transition-all block text-center shadow-lg shadow-red-600/30">
                            Bayar DP Sekarang &rarr;
                        </a>
                    </div>
                @endif

                <button onclick="window.print()" class="w-full py-2.5 bg-neutral-900 hover:bg-neutral-800 border border-neutral-800 text-neutral-300 rounded-xl text-xs font-bold transition-colors">
                    <i class="fa-solid fa-print mr-1"></i> Cetak Invoice
                </button>
            </div>

        </div>

    </div>

</div>
@endsection
