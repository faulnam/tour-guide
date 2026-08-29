@extends('layouts.customer')

@section('meta_title', 'Dashboard Traveler — Nusantara Tour Guide')

@section('content')

    <div class="space-y-8">
        
        <!-- Header Page -->
        <div class="border-b border-gray-100 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="eyebrow text-sage font-bold">Portal Wisatawan</div>
                <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tight text-primary font-sans">
                    Selamat Datang, {{ auth()->user()->name }}
                </h1>
            </div>
            <div>
                <a href="{{ url('/booking') }}" class="btn-primary flex items-center gap-2 shadow-md">
                    <i class="fa-solid fa-calendar-check text-xs"></i>
                    <span>Booking Pemandu Wisata &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="tour-card p-6 space-y-2 bg-white">
                <div class="eyebrow text-sage font-bold text-[10px]">Total Reservasi Trip</div>
                <div class="text-3xl font-bold text-primary">{{ $totalBookings }}</div>
                <div class="text-[11px] text-gray-500">Pemesanan tercatat di akun Anda</div>
            </div>

            <div class="tour-card p-6 space-y-2 bg-white">
                <div class="eyebrow text-sage font-bold text-[10px]">Trip Aktif / Berjalan</div>
                <div class="text-3xl font-bold text-emerald-700">{{ $activeBookings }}</div>
                <div class="text-[11px] text-gray-500">Jadwal tur dalam pendampingan pemandu</div>
            </div>

            <div class="tour-card p-6 space-y-2 bg-white">
                <div class="eyebrow text-sage font-bold text-[10px]">Preferensi Destinasi</div>
                <div class="text-3xl font-bold text-primary">{{ $vehicles->count() }}</div>
                <div class="text-[11px] text-gray-500">Rencana liburan tersimpan</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Active / Recent Bookings (7 cols) -->
            <div class="lg:col-span-7 tour-card p-6 md:p-8 space-y-6 bg-white">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="eyebrow text-primary font-bold">Reservasi Terkini</div>
                    <a href="{{ route('customer.bookings.index') }}" class="text-[11px] uppercase tracking-wider font-bold text-primary hover:text-sage flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($recentBookings as $b)
                        <div class="p-4 bg-[#F8FAF9] rounded-xl border border-gray-100 space-y-3 shadow-soft">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-xs font-bold text-primary">{{ $b->service->title ?? 'Private Guided Tour' }}</div>
                                    <div class="text-[11px] text-gray-600">Destinasi: <strong>{{ $b->vehicle_brand }}</strong> ({{ $b->vehicle_model }})</div>
                                </div>
                                <span class="px-2.5 py-1 text-[9px] uppercase font-bold rounded-full {{ $b->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($b->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $b->status_label }}
                                </span>
                            </div>

                            <div class="text-[11px] text-gray-600 flex items-center justify-between pt-2 border-t border-gray-200">
                                <span>Jadwal: {{ $b->booking_date->format('d M Y') }} &bull; {{ $b->booking_time_slot }}</span>
                                <a href="{{ route('customer.bookings.show', $b->id) }}" class="font-bold text-primary hover:text-sage flex items-center gap-1">
                                    <span>Detail Pass</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400 text-xs">
                            Belum ada riwayat reservasi trip.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Column: Preferences (5 cols) -->
            <div class="lg:col-span-5 tour-card p-6 md:p-8 space-y-6 bg-white">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="eyebrow text-primary font-bold">Destinasi Impian Saya</div>
                    <a href="{{ route('customer.vehicles.index') }}" class="text-[11px] uppercase tracking-wider font-bold text-primary hover:text-sage flex items-center gap-1">
                        <span>Kelola</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($vehicles as $v)
                        <div class="p-3 bg-[#F8FAF9] rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                            <div>
                                <div class="font-bold text-primary">{{ $v->brand }}</div>
                                <div class="text-[10px] text-gray-500">{{ $v->model }} &bull; {{ $v->type === 'mobil' ? 'Private' : 'Group' }}</div>
                            </div>
                            <a href="{{ url('/booking?vehicle_id=' . $v->id) }}" class="btn-primary px-3 py-1 text-[10px] uppercase font-bold shadow-sm">
                                Pesan
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-xs">
                            Belum ada preferensi destinasi tersimpan.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

@endsection
