@extends('layouts.admin')

@section('page_title', 'Ringkasan Eksekutif CMS')

@section('content')
<div class="space-y-8">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-neutral-800 gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-bold tracking-tight text-white uppercase font-sans">
                Selamat Datang, {{ auth()->user()->name }}!
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Ringkasan operasional reservasi pemandu wisata, destinasi Indonesia, dan absensi kamera selfie staf lapangan.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2.5 bg-primary text-white hover:bg-secondary rounded-lg text-[11px] uppercase tracking-wider font-bold transition-colors shadow-sm">
                Kelola Reservasi
            </a>
            <a href="{{ route('admin.attendances.index') }}" class="px-4 py-2.5 border border-neutral-700 text-neutral-300 hover:text-white hover:border-neutral-500 rounded-lg text-[11px] uppercase tracking-wider transition-colors">
                Absensi Kamera
            </a>
        </div>
    </div>

    <!-- 8 Analytical Counter Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        
        <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-5 space-y-2">
            <div class="text-xs uppercase tracking-wider text-neutral-400 font-bold">Reservasi Traveler</div>
            <div class="text-3xl font-bold text-white">{{ $stats['bookings'] ?? \App\Models\Booking::count() }}</div>
            <a href="{{ route('admin.bookings.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Kelola Jadwal &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-5 space-y-2">
            <div class="text-xs uppercase tracking-wider text-neutral-400 font-bold">Absensi Hari Ini</div>
            <div class="text-3xl font-bold text-emerald-400">{{ $stats['today_attendances'] ?? \App\Models\Attendance::whereDate('date', today())->count() }}</div>
            <a href="{{ route('admin.attendances.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Log Kamera &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-5 space-y-2">
            <div class="text-xs uppercase tracking-wider text-neutral-400 font-bold">Destinasi &amp; Ekspedisi</div>
            <div class="text-3xl font-bold text-white">{{ $stats['projects'] ?? \App\Models\Project::count() }}</div>
            <a href="{{ route('admin.projects.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Katalog Rute &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-5 space-y-2">
            <div class="text-xs uppercase tracking-wider text-neutral-400 font-bold">Paket Pemandu</div>
            <div class="text-3xl font-bold text-white">{{ $stats['services'] ?? \App\Models\Service::count() }}</div>
            <a href="{{ route('admin.services.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Kelola Paket &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-5 space-y-2">
            <div class="text-xs uppercase tracking-wider text-neutral-400 font-bold">Pemandu Wisata</div>
            <div class="text-3xl font-bold text-white">{{ $stats['employees'] ?? \App\Models\User::where('role', 'karyawan')->count() }}</div>
            <a href="{{ route('admin.employees.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Data Guide HPI &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-5 space-y-2">
            <div class="text-xs uppercase tracking-wider text-neutral-400 font-bold">Traveler Terdaftar</div>
            <div class="text-3xl font-bold text-white">{{ $stats['customers'] ?? \App\Models\User::where('role', 'customer')->count() }}</div>
            <a href="{{ url('/admin/users') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Data Wisatawan &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-5 space-y-2">
            <div class="text-xs uppercase tracking-wider text-neutral-400 font-bold">Pesan Masuk</div>
            <div class="text-3xl font-bold {{ ($stats['unread_messages'] ?? 0) > 0 ? 'text-accent' : 'text-white' }}">
                {{ $stats['unread_messages'] ?? \App\Models\ContactMessage::where('is_read', false)->count() }}
            </div>
            <a href="{{ url('/admin/messages') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Buka Inbox &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-5 space-y-2">
            <div class="text-xs uppercase tracking-wider text-neutral-400 font-bold">Subscribers Newsletter</div>
            <div class="text-3xl font-bold text-white">{{ $stats['subscribers'] ?? \App\Models\NewsletterSubscriber::count() }}</div>
            <a href="{{ url('/admin/subscribers') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Lihat List &rarr;</a>
        </div>

    </div>

    <!-- Recent Data Tables (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Bookings Table -->
        <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-wider font-bold text-white">Reservasi Wisata Terbaru</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-[10px] text-neutral-400 hover:text-white uppercase tracking-wider">Lihat Semua</a>
            </div>

            <div class="space-y-3">
                @forelse(\App\Models\Booking::with('service')->latest()->take(5)->get() as $b)
                    <div class="flex items-center justify-between p-3 bg-neutral-950/60 border border-neutral-800 rounded-xl text-xs">
                        <div class="truncate">
                            <div class="font-bold text-white truncate">{{ $b->customer_name }} &bull; {{ $b->vehicle_brand }}</div>
                            <div class="text-[10px] text-neutral-400">{{ $b->service->title ?? 'Private Guided Tour' }} &bull; {{ $b->booking_date ? $b->booking_date->format('d M Y') : '-' }}</div>
                        </div>
                        <div class="flex items-center gap-3 pl-3">
                            {!! $b->status_badge !!}
                            <a href="{{ route('admin.bookings.show', $b->id) }}" class="text-accent hover:underline font-mono text-[11px]">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="text-neutral-500 text-xs py-4 text-center">Belum ada reservasi trip.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Attendances Table -->
        <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-wider font-bold text-white">Presensi Pemandu Terkini</h3>
                <a href="{{ route('admin.attendances.index') }}" class="text-[10px] text-neutral-400 hover:text-white uppercase tracking-wider">Log Lengkap</a>
            </div>

            <div class="space-y-3">
                @forelse(\App\Models\Attendance::with('user')->latest()->take(5)->get() as $a)
                    <div class="flex items-center justify-between p-3 bg-neutral-950/60 border border-neutral-800 rounded-xl text-xs">
                        <div class="truncate">
                            <div class="font-bold text-white truncate">{{ $a->user->name ?? 'Pemandu' }}</div>
                            <div class="text-[10px] text-neutral-400">Masuk: {{ $a->check_in_time ? substr($a->check_in_time, 0, 5) : '-' }} &bull; Pulang: {{ $a->check_out_time ? substr($a->check_out_time, 0, 5) : '-' }}</div>
                        </div>
                        <div class="text-[10px] text-neutral-400 font-mono">
                            {{ $a->date ? (is_string($a->date) ? date('d M', strtotime($a->date)) : $a->date->format('d M')) : '-' }}
                        </div>
                    </div>
                @empty
                    <div class="text-neutral-500 text-xs py-4 text-center">Belum ada log presensi pemandu.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
