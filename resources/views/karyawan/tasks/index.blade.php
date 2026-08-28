@extends('layouts.karyawan')

@section('meta_title', 'Tugas Pengerjaan Bengkel — Metrix Garage')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-neutral-200 gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">Mekanik Workshop</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-black font-sans">
                Tugas Unit Kendaraan
            </h1>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-neutral-200 p-4">
        <form action="{{ route('karyawan.tasks.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-500 mb-1">Status Tugas</label>
                <select name="status" class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2 text-xs text-black focus:outline-none focus:border-black">
                    <option value="">Semua Status</option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed (Siap Mulai)</option>
                    <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress (Dikerjakan)</option>
                    <option value="qc" {{ $status === 'qc' ? 'selected' : '' }}>QC &amp; Dyno Test</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn-dark">
                    Filter Tugas &rarr;
                </button>
            </div>
        </form>
    </div>

    <!-- Tasks List Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tasks as $t)
            <div class="bg-white border border-neutral-200 p-6 space-y-4 hover:border-black transition-colors flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="font-mono text-xs font-bold text-black">{{ $t->booking_code }}</span>
                            <h3 class="text-base font-bold text-black mt-0.5">{{ $t->vehicle_brand }} {{ $t->vehicle_model }}</h3>
                        </div>
                        <span class="px-2 py-0.5 text-[9px] uppercase font-bold bg-neutral-bg border border-neutral-300 text-black">
                            {{ $t->status }}
                        </span>
                    </div>

                    <div class="p-3 bg-neutral-bg border border-neutral-200 space-y-1 text-xs">
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Plat Nomor:</span>
                            <span class="font-mono font-bold text-black">{{ $t->license_plate }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Layanan:</span>
                            <span class="text-black font-semibold">{{ $t->service->title ?? 'Custom Service' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Jadwal:</span>
                            <span class="text-black">{{ $t->booking_date->format('d M Y') }} ({{ $t->booking_time_slot }})</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between text-xs text-neutral-500">
                            <span>Progress:</span>
                            <span class="font-bold text-black">{{ $t->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-neutral-200 h-1.5">
                            <div class="bg-black h-1.5" style="width: {{ $t->progress_percentage }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-100">
                    <a href="{{ route('karyawan.tasks.show', $t->id) }}" class="btn-dark w-full text-center block">
                        Update Progress &amp; Catatan &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white border border-neutral-200 p-12 text-center text-neutral-400 text-xs">
                Tidak ada penugasan pengerjaan unit yang cocok.
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
