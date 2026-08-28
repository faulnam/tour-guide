@extends('layouts.admin')

@section('page_title', 'Detail Booking ' . $booking->booking_code)

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-accent font-semibold">Booking Management &amp; Dispatch</div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">
                {{ $booking->booking_code }}
            </h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="px-4 py-2 bg-white text-black hover:bg-neutral-200 text-xs font-semibold uppercase tracking-wider transition-colors">
                Edit Status / Penugasan Mekanik &rarr;
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Booking Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Customer, Vehicle & Timeline (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Customer & Unit Card -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-6">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Informasi Pemesan &amp; Unit Kendaraan
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-neutral-300">
                    <div class="space-y-2">
                        <div class="text-[10px] uppercase font-bold text-neutral-500">Customer</div>
                        <div class="text-sm font-bold text-white">{{ $booking->customer_name }}</div>
                        <div>Email: {{ $booking->customer_email }}</div>
                        <div>Telepon: {{ $booking->customer_phone }}</div>
                    </div>

                    <div class="space-y-2">
                        <div class="text-[10px] uppercase font-bold text-neutral-500">Kendaraan</div>
                        <div class="text-sm font-bold text-white">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</div>
                        <div>Plat Nomor: <span class="font-mono text-accent font-bold">{{ $booking->license_plate }}</span></div>
                        <div class="capitalize">Kategori: {{ $booking->vehicle_type }}</div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-800 space-y-2 text-xs text-neutral-300">
                    <div class="text-[10px] uppercase font-bold text-neutral-500">Jadwal &amp; Layanan</div>
                    <div class="font-bold text-white text-sm">{{ $booking->service->title ?? 'Custom Modification & Service' }}</div>
                    <div>Tanggal Kedatangan: {{ $booking->booking_date ? $booking->booking_date->format('d F Y') : '-' }} • {{ $booking->booking_time_slot }}</div>
                    
                    @if($booking->custom_request)
                        <div class="p-3 bg-neutral-950 border border-neutral-800 text-neutral-400 mt-2 italic">
                            <span class="font-bold text-neutral-300 not-italic block text-[10px] uppercase">Permintaan Khusus:</span>
                            &ldquo;{{ $booking->custom_request }}&rdquo;
                        </div>
                    @endif

                    @if($booking->mechanic_notes)
                        <div class="p-3 bg-neutral-950 border border-neutral-800 text-accent mt-2">
                            <span class="font-bold text-neutral-300 block text-[10px] uppercase">Catatan Mekanik / Workshop:</span>
                            {{ $booking->mechanic_notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Logs Timeline -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Riwayat Aktivitas &amp; Log Pengerjaan
                </h3>

                <div class="space-y-4 text-xs">
                    @forelse($booking->logs as $log)
                        <div class="flex items-start gap-3 border-l-2 border-accent pl-4 py-1">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white text-xs">{{ $log->title }}</span>
                                    <span class="text-[10px] text-neutral-500">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-neutral-400 text-[11px]">{{ $log->description }}</p>
                                @if($log->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Progres Foto" class="w-32 h-20 object-cover border border-neutral-700">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-neutral-500 text-xs italic">Belum ada riwayat aktivitas yang tercatat.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Status, Payment & Mechanic Assignment (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Progress & Mechanic Card -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Status Workshop &amp; Mekanik
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Status Pengerjaan:</span>
                        <div>{!! $booking->status_badge !!}</div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center">
                            <span class="text-neutral-400">Progress Pengerjaan:</span>
                            <span class="font-mono text-white font-bold">{{ $booking->progress_percentage }}%</span>
                        </div>
                        <div class="w-full h-2 bg-neutral-950 rounded overflow-hidden">
                            <div class="h-full bg-accent transition-all duration-500" style="width: {{ $booking->progress_percentage }}%"></div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-1 border-t border-neutral-800">
                        <span class="text-neutral-400">Mekanik Penanggung Jawab:</span>
                        @if($booking->mechanic)
                            <span class="font-bold text-accent">{{ $booking->mechanic->name }}</span>
                        @else
                            <span class="text-neutral-500 italic">Belum Ditugaskan</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Informasi Pembayaran &amp; Tagihan
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Status Pembayaran:</span>
                        <div>{!! $booking->payment_badge !!}</div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Estimasi Total Biaya:</span>
                        <span class="font-bold text-white text-sm">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Ketentuan DP Wajib:</span>
                        <span class="font-semibold text-neutral-300">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center border-t border-neutral-800 pt-2">
                        <span class="text-neutral-400">Total Terbayar:</span>
                        <span class="font-bold text-emerald-400">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Sisa Pelunasan:</span>
                        @php $sisa = max(0, $booking->total_amount - $booking->paid_amount); @endphp
                        <span class="font-bold {{ $sisa > 0 ? 'text-amber-400' : 'text-emerald-400' }}">
                            {{ $sisa > 0 ? 'Rp ' . number_format($sisa, 0, ',', '.') : 'Lunas Penuh' }}
                        </span>
                    </div>

                    @php $latestPayment = $booking->payments->last(); @endphp
                    @if($latestPayment)
                        <div class="pt-3 border-t border-neutral-800 space-y-1.5 text-[11px]">
                            <div class="font-bold text-neutral-400 uppercase text-[10px]">Transaksi Gateway Terkini:</div>
                            <div class="flex justify-between text-neutral-400">
                                <span>No. Transaksi:</span>
                                <span class="font-mono text-white">{{ $latestPayment->transaction_code }}</span>
                            </div>
                            <div class="flex justify-between text-neutral-400">
                                <span>Metode Pembayaran:</span>
                                <span class="uppercase text-white">{{ $latestPayment->payment_method }}</span>
                            </div>
                            <div class="flex justify-between text-neutral-400">
                                <span>Waktu Bayar:</span>
                                <span class="text-white">{{ $latestPayment->paid_at ? $latestPayment->paid_at->format('d M Y, H:i') : ($latestPayment->created_at->format('d M Y, H:i')) }} WIB</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
