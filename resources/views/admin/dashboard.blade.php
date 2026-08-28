@extends('layouts.admin')

@section('page_title', 'Studio Overview')

@section('content')
<div class="space-y-8">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-neutral-800 gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-bold tracking-tight text-white uppercase font-sans">
                Welcome back, {{ auth()->user()->name }}!
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Ringkasan sistem workshop bengkel, antrean booking online, dyno run, dan absensi kamera staf.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-[11px] uppercase tracking-wider font-semibold transition-colors">
                Kelola Bookings
            </a>
            <a href="{{ route('admin.attendances.index') }}" class="px-4 py-2.5 border border-neutral-700 text-neutral-300 hover:text-white hover:border-neutral-500 text-[11px] uppercase tracking-wider transition-colors">
                Absensi Kamera
            </a>
        </div>
    </div>

    <!-- 8 Analytical Counter Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        
        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Bookings</div>
            <div class="text-3xl font-bold text-white">{{ $stats['bookings'] ?? \App\Models\Booking::count() }}</div>
            <a href="{{ route('admin.bookings.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Kelola Antrean &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Absensi Hari Ini</div>
            <div class="text-3xl font-bold text-emerald-400">{{ $stats['today_attendances'] ?? \App\Models\Attendance::whereDate('date', today())->count() }}</div>
            <a href="{{ route('admin.attendances.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Log Kamera &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Projects &amp; Dyno</div>
            <div class="text-3xl font-bold text-white">{{ $stats['projects'] ?? \App\Models\Project::count() }}</div>
            <a href="{{ route('admin.projects.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Galeri Modif &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Layanan Tuning</div>
            <div class="text-3xl font-bold text-white">{{ $stats['services'] ?? \App\Models\Service::count() }}</div>
            <a href="{{ route('admin.services.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Paket Modif &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Karyawan &amp; Mekanik</div>
            <div class="text-3xl font-bold text-white">{{ $stats['employees'] ?? \App\Models\User::where('role', 'karyawan')->count() }}</div>
            <a href="{{ route('admin.employees.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Data Staf &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Customer Terdaftar</div>
            <div class="text-3xl font-bold text-white">{{ $stats['customers'] ?? \App\Models\User::where('role', 'customer')->count() }}</div>
            <a href="{{ url('/admin/users') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Data Customer &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Pesan Masuk</div>
            <div class="text-3xl font-bold {{ ($stats['unread_messages'] ?? 0) > 0 ? 'text-accent' : 'text-white' }}">
                {{ $stats['unread_messages'] ?? \App\Models\ContactMessage::where('is_read', false)->count() }}
            </div>
            <a href="{{ url('/admin/messages') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Buka Inbox &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Subscribers</div>
            <div class="text-3xl font-bold text-white">{{ $stats['subscribers'] ?? \App\Models\NewsletterSubscriber::count() }}</div>
            <a href="{{ url('/admin/subscribers') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Lihat List &rarr;</a>
        </div>

    </div>

    <!-- Recent Data Tables (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Bookings Table -->
        <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white">Booking Terbaru</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-[10px] text-neutral-400 hover:text-white uppercase tracking-wider">Lihat Semua</a>
            </div>

            <div class="space-y-3">
                @forelse(\App\Models\Booking::with('service')->latest()->take(5)->get() as $b)
                    <div class="flex items-center justify-between p-3 bg-neutral-950/60 border border-neutral-800/80 text-xs">
                        <div class="truncate">
                            <div class="font-semibold text-white truncate">{{ $b->customer_name }} — {{ $b->vehicle_brand }} {{ $b->vehicle_model }}</div>
                            <div class="text-[10px] text-neutral-400">{{ $b->service->title ?? 'Custom Package' }} • {{ $b->booking_date->format('d M Y') }}</div>
                        </div>
                        <div class="flex items-center gap-3 pl-3">
                            <span class="px-2 py-0.5 text-[9px] uppercase font-bold {{ $b->status === 'completed' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-amber-950 text-amber-300 border border-amber-800' }}">
                                {{ $b->status }}
                            </span>
                            <a href="{{ route('admin.bookings.show', $b->id) }}" class="text-neutral-400 hover:text-white font-semibold">&rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-neutral-500 text-xs">Belum ada booking masuk.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Camera Attendance Table -->
        <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white">Absensi Kamera Terakhir</h3>
                <a href="{{ route('admin.attendances.index') }}" class="text-[10px] text-neutral-400 hover:text-white uppercase tracking-wider">Buka Log</a>
            </div>

            <div class="space-y-3">
                @forelse(\App\Models\Attendance::with('user')->latest()->take(5)->get() as $att)
                    <div class="p-3 bg-neutral-950/60 border border-neutral-800/80 text-xs flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if($att->check_in_photo_url)
                                <img src="{{ $att->check_in_photo_url }}" class="w-9 h-9 object-cover border border-neutral-800">
                            @else
                                <div class="w-9 h-9 bg-neutral-800 flex items-center justify-center font-bold text-neutral-400 text-xs">A</div>
                            @endif
                            <div>
                                <div class="font-semibold text-white">{{ $att->user->name ?? 'Staff' }}</div>
                                <div class="text-[10px] text-neutral-400">
                                    {{ $att->date ? ($att->date instanceof \DateTimeInterface ? $att->date->format('d M Y') : date('d M Y', strtotime($att->date))) : '-' }} &bull; In: {{ $att->clock_in ?? '-' }} &bull; Out: {{ $att->clock_out ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 text-[9px] uppercase font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                            {{ $att->status }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6 text-neutral-500 text-xs">Belum ada data absensi.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
