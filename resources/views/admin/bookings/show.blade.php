@extends('layouts.admin')

@section('page_title', 'Detail Booking ' . $booking->booking_code)

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-accent font-semibold">Booking Management</div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">
                {{ $booking->booking_code }}
            </h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="px-4 py-2 bg-white text-black hover:bg-neutral-200 text-xs font-semibold uppercase tracking-wider transition-colors">
                Update Status / Mekanik &rarr;
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Booking Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Customer & Vehicle Info (7 cols) -->
        <div class="lg:col-span-7 bg-neutral-900 border border-neutral-800 p-6 space-y-6">
            <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                Informasi Pemesanan &amp; Unit Kendaraan
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
                <div class="font-bold text-white text-sm">{{ $booking->service->title ?? 'Custom Package' }}</div>
                <div>Tanggal Kedatangan: {{ $booking->booking_date->format('d F Y') }} • {{ $booking->booking_time_slot }}</div>
                @if($booking->custom_request)
                    <div class="p-3 bg-neutral-950 border border-neutral-800 text-neutral-400 mt-2 italic">
                        &ldquo;{{ $booking->custom_request }}&rdquo;
                    </div>
                @endif
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
                        <span class="px-2 py-0.5 text-[9px] uppercase font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                            {{ $booking->status }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Progress:</span>
                        <span class="font-mono text-white font-bold">{{ $booking->progress_percentage }}%</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Mekanik Penanggung Jawab:</span>
                        <span class="font-bold text-accent">{{ $booking->mechanic->name ?? 'Belum Ditugaskan' }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Informasi Pembayaran
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Status DP:</span>
                        <span class="px-2 py-0.5 text-[9px] uppercase font-bold {{ $booking->payment_status === 'paid' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-amber-950 text-amber-300 border border-amber-800' }}">
                            {{ $booking->payment_status === 'paid' ? 'LUNAS' : 'MENUNGGU' }}
                        </span>
                    </div>

                    @if($booking->payment)
                        <div class="flex justify-between items-center">
                            <span class="text-neutral-400">No. Invoice:</span>
                            <span class="font-mono text-white">{{ $booking->payment->invoice_number }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-neutral-400">Jumlah DP:</span>
                            <span class="font-bold text-white text-sm">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-neutral-400">Metode:</span>
                            <span class="uppercase text-white">{{ $booking->payment->payment_method }}</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
