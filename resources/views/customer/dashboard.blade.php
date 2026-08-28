@extends('layouts.customer')

@section('title', 'Garasi & Booking Saya')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-neutral-900 via-[#181822] to-red-950/40 border border-neutral-800 rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl">
        <div class="space-y-2 text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase bg-red-600/20 text-red-400 border border-red-500/30">
                <i class="fa-solid fa-user-check"></i>
                <span>Customer Portal</span>
            </div>
            <h1 class="font-racing font-bold text-2xl sm:text-3xl text-white">
                Selamat Datang, {{ $user->name }}!
            </h1>
            <p class="text-xs text-neutral-400">
                Pantau antrean pengerjaan mobil & motor Anda secara real-time dari mana saja.
            </p>
        </div>

        <div class="flex-shrink-0">
            <a href="{{ url('/booking') }}" 
               class="px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-racing font-bold text-xs uppercase tracking-wider rounded-2xl shadow-xl shadow-red-600/30 hover:scale-105 transition-all flex items-center gap-2.5">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>BUAT BOOKING BARU</span>
            </a>
        </div>
    </div>

    <!-- Quick Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <div class="bg-[#121218] border border-neutral-800 rounded-2xl p-6 space-y-3">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Unit Sedang Diproses</span>
                <i class="fa-solid fa-gears text-red-500"></i>
            </div>
            <div class="font-racing font-black text-3xl text-white">
                {{ $activeBookings->count() }} <span class="text-xs text-neutral-400 font-sans font-normal">Kendaraan</span>
            </div>
            <div class="text-xs text-neutral-400">Booking aktif dalam pengerjaan</div>
        </div>

        <div class="bg-[#121218] border border-neutral-800 rounded-2xl p-6 space-y-3">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Garasi Kendaraan Saya</span>
                <i class="fa-solid fa-warehouse text-amber-400"></i>
            </div>
            <div class="font-racing font-black text-3xl text-amber-400">
                {{ $vehicles->count() }} <span class="text-xs text-neutral-400 font-sans font-normal">Unit Terdaftar</span>
            </div>
            <div class="text-xs text-neutral-400"><a href="{{ route('customer.vehicles.index') }}" class="underline hover:text-white">Kelola Garasi &rarr;</a></div>
        </div>

        <div class="bg-[#121218] border border-neutral-800 rounded-2xl p-6 space-y-3">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Total Modifikasi Selesai</span>
                <i class="fa-solid fa-circle-check text-emerald-400"></i>
            </div>
            <div class="font-racing font-black text-3xl text-emerald-400">
                {{ $completedBookings }} <span class="text-xs text-neutral-400 font-sans font-normal">Project</span>
            </div>
            <div class="text-xs text-neutral-400">Total belanja: Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
        </div>

    </div>

    <!-- Active Bookings with Live Progress Trackers -->
    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-racing font-bold text-lg text-white">LIVE TRACKER PENGERJAAN KENDARAAN</h3>
                <p class="text-xs text-neutral-400">Status perkembangan modifikasi mobil & motor Anda saat ini di workshop:</p>
            </div>
            <a href="{{ route('customer.bookings.index') }}" class="text-xs font-bold text-red-400 hover:text-red-300">Semua Booking &rarr;</a>
        </div>

        <div class="space-y-4">
            @forelse($activeBookings as $b)
                <div class="bg-[#0a0a0e] border border-neutral-800 p-6 rounded-2xl space-y-4 hover:border-red-500/40 transition-colors">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-bold text-red-400">{{ $b->booking_code }}</span>
                                <span>•</span>
                                <span class="text-xs font-bold text-white">{{ $b->vehicle_type_label }} {{ $b->vehicle_brand }} {{ $b->vehicle_model }}</span>
                                <span class="font-mono text-xs text-neutral-400">({{ $b->license_plate }})</span>
                            </div>
                            <div class="text-xs text-neutral-400 mt-1">
                                Layanan: <strong class="text-white">{{ $b->service->title ?? 'Custom Tuning' }}</strong> • Jadwal: {{ \Carbon\Carbon::parse($b->booking_date)->translatedFormat('d M Y') }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            {!! $b->status_badge !!}
                            {!! $b->payment_badge !!}
                        </div>
                    </div>

                    <!-- Visual Progress Bar -->
                    <div class="space-y-1.5 pt-2">
                        <div class="flex justify-between text-xs font-mono">
                            <span class="text-neutral-400">Progres Teknisi: <strong class="text-white">{{ $b->mechanic->name ?? 'Tim Workshop' }}</strong></span>
                            <span class="font-bold text-red-400">{{ $b->progress_percentage }}% Selesai</span>
                        </div>
                        <div class="w-full bg-neutral-900 rounded-full h-3 overflow-hidden border border-neutral-800">
                            <div class="bg-gradient-to-r from-red-600 to-amber-500 h-3 rounded-full transition-all duration-500" style="width: {{ $b->progress_percentage }}%"></div>
                        </div>
                    </div>

                    @if($b->mechanic_notes)
                        <div class="p-3 bg-neutral-900/90 rounded-xl text-xs text-neutral-300 border border-neutral-800">
                            <span class="text-[10px] text-amber-400 font-bold uppercase block mb-0.5"><i class="fa-solid fa-message mr-1"></i> Catatan Terkini Mekanik:</span>
                            {{ $b->mechanic_notes }}
                        </div>
                    @endif

                    <div class="pt-3 border-t border-neutral-800/80 flex items-center justify-between">
                        <span class="text-xs text-neutral-400">Total Biaya: <strong class="text-white">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</strong></span>
                        
                        <div class="flex items-center gap-2">
                            @if($b->payment_status === 'unpaid')
                                <a href="{{ route('booking.checkout', $b->booking_code) }}" 
                                   class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-red-600/30">
                                    Bayar DP Sekarang &rarr;
                                </a>
                            @endif

                            <a href="{{ route('customer.bookings.show', $b->id) }}" 
                               class="px-4 py-2 bg-neutral-800 hover:bg-neutral-700 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-satellite-dish text-red-500"></i>
                                <span>Buka Live Tracker & Invoice</span>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="text-center py-12 text-neutral-500">
                    <i class="fa-solid fa-car text-3xl text-neutral-700 mb-3 block"></i>
                    Belum ada kendaraan yang sedang dalam antrean pengerjaan.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
