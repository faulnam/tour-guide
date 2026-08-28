@extends('layouts.admin')

@section('title', 'Detail Booking — ' . $booking->booking_code)

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-red-400 hover:underline mb-1 inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Booking
            </a>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight">
                BOOKING & WORK ORDER: {{ $booking->booking_code }}
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" 
               class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-black font-bold text-xs rounded-xl transition-all inline-flex items-center gap-1.5 shadow">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit / Assign Mekanik</span>
            </a>

            <button onclick="window.print()" class="px-3.5 py-2 bg-neutral-900 border border-neutral-800 text-neutral-300 rounded-xl text-xs font-bold">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Status Bar -->
    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 shadow-xl flex flex-wrap items-center justify-between gap-4">
        <div>
            <div class="text-[10px] text-neutral-400 uppercase font-semibold">Status Pengerjaan</div>
            <div class="mt-1">{!! $booking->status_badge !!}</div>
        </div>

        <div>
            <div class="text-[10px] text-neutral-400 uppercase font-semibold">Status Pembayaran</div>
            <div class="mt-1">{!! $booking->payment_badge !!}</div>
        </div>

        <div>
            <div class="text-[10px] text-neutral-400 uppercase font-semibold">Mekanik Penanggung Jawab</div>
            <div class="text-xs font-bold text-amber-400 mt-1">
                {{ $booking->mechanic->name ?? 'Belum Ditugaskan' }}
            </div>
        </div>

        <div>
            <div class="text-[10px] text-neutral-400 uppercase font-semibold">Progres Pengerjaan</div>
            <div class="font-racing font-bold text-sm text-red-400 mt-1">{{ $booking->progress_percentage }}% Selesai</div>
        </div>
    </div>

    <!-- 2 Column Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Activity Timeline & Progress Photos (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
                <h3 class="font-racing font-bold text-base text-white uppercase">LOG AKTIVITAS PROGRES WORKSHOP</h3>

                <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-neutral-800">
                    @forelse($booking->logs as $log)
                        <div class="relative flex items-start gap-4 pl-8">
                            <div class="absolute left-1.5 top-1 w-4 h-4 rounded-full bg-red-500 border-2 border-neutral-900 shadow"></div>
                            <div class="flex-1 bg-[#0a0a0e] border border-neutral-800/80 p-4 rounded-2xl space-y-1.5">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-white">{{ $log->title }}</span>
                                    <span class="text-neutral-500 font-mono text-[10px]">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-xs text-neutral-300">{{ $log->description }}</p>
                                <div class="text-[10px] text-neutral-500">Oleh: {{ $log->user->name ?? 'System' }}</div>
                                
                                @if($log->photo_path)
                                    <div class="pt-2">
                                        <img src="{{ $log->photo_url }}" class="w-48 h-32 object-cover rounded-xl border border-neutral-700">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-neutral-500 pl-8">Belum ada catatan log progres.</div>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Transaksi Pembayaran -->
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-4 shadow-xl">
                <h3 class="font-racing font-bold text-sm text-white uppercase">RIWAYAT TRANSAKSI PAYMENT GATEWAY</h3>

                <div class="space-y-2.5">
                    @forelse($booking->payments as $pay)
                        <div class="p-3.5 rounded-2xl bg-[#0a0a0e] border border-neutral-800 flex items-center justify-between text-xs">
                            <div>
                                <div class="font-mono font-bold text-white">{{ $pay->transaction_code }}</div>
                                <div class="text-[10px] text-neutral-400">{{ $pay->payment_channel }} • {{ $pay->paid_at ? $pay->paid_at->translatedFormat('d M Y H:i') : 'Pending' }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-racing font-bold text-emerald-400">Rp {{ number_format($pay->amount, 0, ',', '.') }}</div>
                                <span class="text-[9px] uppercase font-bold text-emerald-400 px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/30">Settlement</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-neutral-500 py-3">Belum ada transaksi pembayaran tercatat.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Unit Specs & Customer Summary (1 Col) -->
        <div class="space-y-6">
            
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-4 shadow-xl">
                <h4 class="font-racing font-bold text-xs text-white uppercase tracking-wider">UNIT & PEMILIK</h4>

                <div class="space-y-2.5 text-xs text-neutral-300">
                    <div class="flex justify-between"><span class="text-neutral-500">Tipe:</span> <span class="font-bold text-white">{{ $booking->vehicle_type_label }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Merk & Model:</span> <span class="font-bold text-white">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Plat Nomor:</span> <span class="font-mono font-bold text-red-400">{{ $booking->license_plate }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Tahun / Warna:</span> <span>{{ $booking->vehicle_year ?? '-' }} / {{ $booking->vehicle_color ?? '-' }}</span></div>
                    <div class="pt-2 border-t border-neutral-800 flex justify-between"><span class="text-neutral-500">Customer:</span> <span class="font-bold text-white">{{ $booking->customer_name }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Telepon:</span> <span class="font-bold text-emerald-400">{{ $booking->customer_phone }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Email:</span> <span>{{ $booking->customer_email }}</span></div>
                </div>

                @if($booking->custom_request)
                    <div class="pt-3 border-t border-neutral-800">
                        <div class="text-[10px] text-neutral-400 uppercase font-bold mb-1">Permintaan Khusus Customer:</div>
                        <p class="text-xs text-neutral-300 italic bg-[#0a0a0e] p-3 rounded-xl border border-neutral-800">
                            "{{ $booking->custom_request }}"
                        </p>
                    </div>
                @endif
            </div>

            <!-- Financial Summary Card -->
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-3 shadow-xl">
                <h4 class="font-racing font-bold text-xs text-white uppercase tracking-wider">FINANSIAL</h4>

                <div class="space-y-2 text-xs text-neutral-300">
                    <div class="flex justify-between text-neutral-400"><span>Total Biaya:</span> <span class="font-mono text-white">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between text-neutral-400"><span>Down Payment (DP):</span> <span class="font-mono text-red-400">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between text-emerald-400 font-bold"><span>Total Dibayar:</span> <span class="font-mono">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</span></div>
                    <div class="pt-2 border-t border-neutral-800 flex justify-between font-bold text-sm">
                        <span>Sisa Tagihan:</span>
                        <span class="font-racing text-amber-400">Rp {{ number_format(max(0, $booking->total_amount - $booking->paid_amount), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
