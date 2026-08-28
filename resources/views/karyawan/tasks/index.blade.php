@extends('layouts.karyawan')

@section('title', 'Tugas Pengerjaan Modifikasi')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight">
                DAFTAR TUGAS MODIFIKASI & SERVIS
            </h1>
            <p class="text-xs text-neutral-400">Kelola pengerjaan kendaraan yang ditugaskan ke Anda:</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tasks as $task)
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 shadow-xl space-y-4 hover:border-amber-500/50 transition-all flex flex-col justify-between">
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-xs font-bold text-amber-400">{{ $task->booking_code }}</span>
                        {!! $task->status_badge !!}
                    </div>

                    <div>
                        <div class="text-xs font-bold text-neutral-400 uppercase tracking-wider">{{ $task->vehicle_type_label }}</div>
                        <h3 class="font-bold text-base text-white mt-0.5">{{ $task->vehicle_brand }} {{ $task->vehicle_model }}</h3>
                        <div class="font-mono text-xs text-red-400 font-semibold">{{ $task->license_plate }}</div>
                    </div>

                    <div class="p-3 bg-[#0a0a0e] rounded-xl text-xs space-y-1 border border-neutral-800/80">
                        <div class="text-neutral-400">Layanan: <strong class="text-white">{{ $task->service->title ?? 'Custom Tuning' }}</strong></div>
                        <div class="text-neutral-400">Jadwal: <span class="text-neutral-300">{{ \Carbon\Carbon::parse($task->booking_date)->translatedFormat('d M Y') }} ({{ $task->booking_time_slot }})</span></div>
                        <div class="text-neutral-400">Pemilik: <span class="text-neutral-300">{{ $task->customer_name }}</span></div>
                    </div>

                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between text-[10px] text-neutral-400 mb-1 font-mono">
                            <span>Progres Pengerjaan</span>
                            <span class="font-bold text-amber-400">{{ $task->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-neutral-800 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-amber-500 to-red-500 h-2 rounded-full" style="width: {{ $task->progress_percentage }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-800 flex items-center justify-between">
                    <span class="text-[11px] text-neutral-500">Update berkala</span>
                    <a href="{{ route('karyawan.tasks.show', $task->id) }}" 
                       class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-black font-bold text-xs rounded-xl transition-colors inline-flex items-center gap-1.5 shadow-md shadow-amber-600/20">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Buka Work Order</span>
                    </a>
                </div>

            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-[#121218] border border-neutral-800 rounded-3xl text-neutral-500">
                <i class="fa-solid fa-wrench text-3xl text-neutral-700 mb-3 block"></i>
                Belum ada tugas modifikasi yang ditugaskan ke akun Anda.
            </div>
        @endforelse
    </div>

    <div>
        {{ $tasks->links() }}
    </div>

</div>
@endsection
