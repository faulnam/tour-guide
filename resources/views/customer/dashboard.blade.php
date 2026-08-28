@extends('layouts.customer')

@section('meta_title', 'Customer Dashboard & Garasi — BENGKEL')

@section('content')

    <div class="space-y-8">
        
        <!-- Header Page -->
        <div class="border-b border-neutral-200 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="eyebrow text-accent font-semibold">Customer Area</div>
                <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tight text-black font-sans">
                    Selamat Datang, {{ auth()->user()->name }}
                </h1>
            </div>
            <div>
                <a href="{{ url('/booking') }}" class="btn-dark">
                    + Booking Servis &amp; Modifikasi
                </a>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white border border-neutral-200 p-6 space-y-2">
                <div class="eyebrow text-neutral-400 text-[10px]">Total Booking</div>
                <div class="text-3xl font-bold text-black">{{ $totalBookings }}</div>
                <div class="text-[11px] text-neutral-500">Pemesanan tercatat di sistem</div>
            </div>

            <div class="bg-white border border-neutral-200 p-6 space-y-2">
                <div class="eyebrow text-neutral-400 text-[10px]">Sedang Dalam Workshop</div>
                <div class="text-3xl font-bold text-amber-600">{{ $activeBookings }}</div>
                <div class="text-[11px] text-neutral-500">Unit sedang dalam pengerjaan teknisi</div>
            </div>

            <div class="bg-white border border-neutral-200 p-6 space-y-2">
                <div class="eyebrow text-neutral-400 text-[10px]">Kendaraan di Garasi</div>
                <div class="text-3xl font-bold text-black">{{ $vehicles->count() }}</div>
                <div class="text-[11px] text-neutral-500">Mobil &amp; motor tersimpan</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Active / Recent Bookings (7 cols) -->
            <div class="lg:col-span-7 bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-neutral-100 pb-3">
                    <div class="eyebrow text-black font-semibold">Booking Terkini</div>
                    <a href="{{ route('customer.bookings.index') }}" class="text-[11px] uppercase tracking-wider font-semibold text-black hover:text-accent">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($recentBookings as $b)
                        <div class="p-4 bg-neutral-bg border border-neutral-200 space-y-3">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-xs font-bold text-black">{{ $b->service->title ?? 'Custom Tuning Service' }}</div>
                                    <div class="text-[11px] text-neutral-500">{{ $b->vehicle_brand }} {{ $b->vehicle_model }} ({{ $b->license_plate }})</div>
                                </div>
                                <span class="px-2.5 py-1 text-[9px] uppercase font-bold tracking-wider {{ $b->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($b->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $b->status_label }}
                                </span>
                            </div>

                            <div class="text-[11px] text-neutral-600 flex items-center justify-between pt-2 border-t border-neutral-200">
                                <span>Jadwal: {{ $b->booking_date->format('d M Y') }} • {{ $b->booking_time_slot }}</span>
                                <a href="{{ route('customer.bookings.show', $b->id) }}" class="font-bold text-black hover:underline">
                                    Detail &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-neutral-400 text-xs">
                            Belum ada riwayat booking servis.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Column: My Garage (5 cols) -->
            <div class="lg:col-span-5 bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-neutral-100 pb-3">
                    <div class="eyebrow text-black font-semibold">Garasi Saya</div>
                    <a href="{{ route('customer.vehicles.index') }}" class="text-[11px] uppercase tracking-wider font-semibold text-black hover:text-accent">
                        Kelola &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($vehicles as $v)
                        <div class="p-3 bg-neutral-bg border border-neutral-200 flex items-center justify-between text-xs">
                            <div>
                                <div class="font-bold text-black">{{ $v->brand }} {{ $v->model }}</div>
                                <div class="text-[10px] text-neutral-500">{{ $v->license_plate }} • {{ $v->type }}</div>
                            </div>
                            <a href="{{ url('/booking?vehicle_id=' . $v->id) }}" class="px-2.5 py-1 bg-black text-white text-[10px] uppercase font-bold hover:bg-neutral-800 transition-colors">
                                Book
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-6 text-neutral-400 text-xs">
                            Belum ada kendaraan tersimpan di garasi.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

@endsection
