@extends('layouts.karyawan')

@section('meta_title', 'Tugas Pemandu Wisata — Nusantara Tour Guide')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 gap-4">
        <div>
            <div class="eyebrow text-sage font-bold">Portal Pemandu Wisata</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-primary font-sans">
                Penugasan Trip &amp; Ekspedisi
            </h1>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="tour-card p-4 bg-white">
        <form action="{{ route('karyawan.tasks.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-[11px] uppercase tracking-wider font-bold text-gray-500 mb-1">Status Trip</label>
                <select name="status" class="w-full bg-[#F8FAF9] border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-800 focus:outline-none focus:border-primary">
                    <option value="">Semua Status</option>
                    <option value="confirmed" {{ ($status ?? '') === 'confirmed' ? 'selected' : '' }}>Confirmed (Jadwal Terkunci)</option>
                    <option value="in_progress" {{ ($status ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress (Sedang Berjalan)</option>
                    <option value="qc" {{ ($status ?? '') === 'qc' ? 'selected' : '' }}>Tahap Akhir / Evaluasi</option>
                    <option value="completed" {{ ($status ?? '') === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                </select>
            </div>

            <div>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Filter Penugasan &rarr;</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tasks List Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tasks as $t)
            <div class="tour-card p-6 space-y-4 flex flex-col justify-between group bg-white">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="font-mono text-xs font-bold text-sage">{{ $t->booking_code }}</span>
                            <h3 class="text-base font-bold text-primary mt-0.5">{{ $t->vehicle_brand }}</h3>
                            <div class="text-[11px] text-gray-500">{{ $t->vehicle_model }}</div>
                        </div>
                        <span class="px-2.5 py-1 text-[9px] uppercase font-bold rounded-full bg-sage-light text-sage border border-sage/30">
                            {{ $t->status_label ?? $t->status }}
                        </span>
                    </div>

                    <div class="p-3 bg-[#F8FAF9] rounded-xl border border-gray-100 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tamu / Wisatawan:</span>
                            <span class="font-bold text-primary">{{ $t->customer_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Peserta:</span>
                            <span class="font-mono font-bold text-primary">{{ $t->license_plate }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Paket Wisata:</span>
                            <span class="text-primary font-semibold truncate max-w-[150px]">{{ $t->service->title ?? 'Private Guided Tour' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jadwal:</span>
                            <span class="text-primary">
                                {{ $t->booking_date ? (is_string($t->booking_date) ? date('d M Y', strtotime($t->booking_date)) : $t->booking_date->format('d M Y')) : '-' }} ({{ $t->booking_time_slot }})
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Progress Rute:</span>
                            <span class="font-bold text-primary">{{ $t->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-primary h-2 rounded-full transition-all duration-300" style="width: {{ $t->progress_percentage }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <a href="{{ route('karyawan.tasks.show', $t->id) }}" class="w-full py-2.5 px-4 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2 text-center">
                        <span>Update Progress &amp; Log Foto &rarr;</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 tour-card p-12 text-center text-gray-400 text-xs bg-white">
                Tidak ada penugasan trip wisata yang cocok.
            </div>
        @endforelse
    </div>

    @if($tasks->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $tasks->links() }}
        </div>
    @endif

</div>
@endsection
