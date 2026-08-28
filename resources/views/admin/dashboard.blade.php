@extends('layouts.admin')

@section('title', 'Dashboard Workshop & Bengkel')

@section('content')
<div class="space-y-8">
    
    <!-- Top KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Pendapatan -->
        <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-2 shadow-xl">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Total Omzet Bengkel</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-rupiah-sign"></i>
                </div>
            </div>
            <div class="font-racing font-black text-2xl text-emerald-400">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <div class="text-[10px] text-neutral-400">Total DP & Pelunasan terverifikasi</div>
        </div>

        <!-- Antrean Pengerjaan Aktif -->
        <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-2 shadow-xl">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Unit Sedang Dikerjakan</span>
                <div class="w-8 h-8 rounded-xl bg-red-600/20 text-red-500 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
            </div>
            <div class="font-racing font-black text-2xl text-white">
                {{ $activeBookingsCount }} <span class="text-xs text-neutral-400 font-sans font-normal">Kendaraan</span>
            </div>
            <div class="text-[10px] text-amber-400 font-bold">{{ $pendingBookingsCount }} Menunggu Konfirmasi</div>
        </div>

        <!-- Kehadiran Mekanik Hari Ini -->
        <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-2 shadow-xl">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Kehadiran Mekanik</span>
                <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-camera"></i>
                </div>
            </div>
            <div class="font-racing font-black text-2xl text-amber-400">
                {{ $presentTodayCount }} / {{ $totalMechanics }} <span class="text-xs text-neutral-400 font-sans font-normal">Mekanik</span>
            </div>
            <div class="text-[10px] text-neutral-400"><a href="{{ route('admin.attendances.index') }}" class="text-amber-400 underline">Lihat Foto Absensi Kamera &rarr;</a></div>
        </div>

        <!-- Total Customer & Layanan -->
        <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-2 shadow-xl">
            <div class="flex items-center justify-between text-neutral-400 text-xs uppercase font-bold tracking-wider">
                <span>Customer & Layanan</span>
                <div class="w-8 h-8 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="font-racing font-black text-2xl text-white">
                {{ $totalCustomers }} <span class="text-xs text-neutral-400 font-sans font-normal">Klien</span>
            </div>
            <div class="text-[10px] text-neutral-400">{{ $totalServices }} Paket Modifikasi Aktif</div>
        </div>

    </div>

    <!-- 2 Column: Today's Camera Attendance Live Feed + Recent Bookings -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Today's Camera Attendance Feed (5 Cols) -->
        <div class="lg:col-span-5 bg-[#121218] border border-neutral-800 rounded-3xl p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-racing font-bold text-sm text-white uppercase flex items-center gap-2">
                        <i class="fa-solid fa-camera text-amber-400"></i>
                        <span>ABSENSI KAMERA HARI INI</span>
                    </h3>
                    <p class="text-[11px] text-neutral-400">Foto selfie masuk mekanik shift hari ini:</p>
                </div>
                <a href="{{ route('admin.attendances.index') }}" class="text-[11px] font-bold text-amber-400 hover:underline">Rekap Lengkap &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($todayAttendances as $att)
                    <div class="p-3.5 rounded-2xl bg-[#0a0a0e] border border-neutral-800 flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-black flex-shrink-0 border border-neutral-700">
                            @if($att->check_in_photo)
                                <img src="{{ $att->check_in_photo_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-600"><i class="fa-solid fa-user"></i></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-xs text-white truncate">{{ $att->user->name ?? 'Mekanik' }}</div>
                            <div class="text-[10px] text-neutral-400 font-mono">Masuk: <span class="text-emerald-400">{{ $att->check_in_time }} WIB</span></div>
                            <div class="mt-0.5">{!! $att->status_badge !!}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-neutral-500 text-xs">
                        Belum ada mekanik yang melakukan absensi kamera hari ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Recent Workshop Bookings (7 Cols) -->
        <div class="lg:col-span-7 bg-[#121218] border border-neutral-800 rounded-3xl p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-racing font-bold text-sm text-white uppercase flex items-center gap-2">
                        <i class="fa-solid fa-car-side text-red-500"></i>
                        <span>ANTREAN BOOKING TERBARU</span>
                    </h3>
                    <p class="text-[11px] text-neutral-400">Pesanan modifikasi motor & mobil yang masuk:</p>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="text-[11px] font-bold text-red-400 hover:underline">Lihat Semua &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#0a0a0e] text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                        <tr>
                            <th class="p-2.5">Kode & Unit</th>
                            <th class="p-2.5">Customer</th>
                            <th class="p-2.5">Status</th>
                            <th class="p-2.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800 text-neutral-300">
                        @forelse($recentBookings as $bk)
                            <tr class="hover:bg-neutral-900/50">
                                <td class="p-2.5">
                                    <div class="font-mono font-bold text-white">{{ $bk->booking_code }}</div>
                                    <div class="text-[10px] text-neutral-400">{{ $bk->vehicle_type_label }} {{ $bk->vehicle_brand }} {{ $bk->vehicle_model }}</div>
                                </td>
                                <td class="p-2.5">
                                    <div class="font-bold text-white">{{ $bk->customer_name }}</div>
                                    <div class="text-[10px] text-neutral-500">{{ $bk->customer_phone }}</div>
                                </td>
                                <td class="p-2.5">
                                    {!! $bk->status_badge !!}
                                </td>
                                <td class="p-2.5 text-right">
                                    <a href="{{ route('admin.bookings.show', $bk->id) }}" class="px-2.5 py-1.5 bg-neutral-800 hover:bg-red-600 text-white rounded-lg text-[10px] font-bold transition-colors">
                                        Kelola
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-neutral-500">Belum ada booking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
