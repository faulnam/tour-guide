@extends('layouts.karyawan')

@php
    $b = $task ?? $booking;
@endphp

@section('meta_title', 'Update Pengerjaan Unit ' . $b->booking_code . ' — BENGKEL')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-neutral-200 gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">Tugas &amp; Pengerjaan Workshop</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-black font-sans">
                {{ $b->booking_code }}
            </h1>
        </div>
        <div>
            <a href="{{ route('karyawan.tasks.index') }}" class="btn-outline-dark text-xs">
                &larr; Kembali ke Daftar Tugas
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs space-y-1">
            <div class="font-bold">Terjadi kesalahan validasi:</div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Vehicle & Request Specs (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Informasi Kendaraan &amp; Request
                </h3>

                <div class="space-y-3 text-xs text-neutral-700">
                    <div class="flex justify-between">
                        <span class="text-neutral-500">Unit:</span>
                        <span class="font-bold text-black">{{ $b->vehicle_brand }} {{ $b->vehicle_model }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-500">Plat Nomor:</span>
                        <span class="font-mono font-bold text-black">{{ $b->license_plate }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-500">Kategori:</span>
                        <span class="capitalize text-black">{{ $b->vehicle_type }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-500">Paket:</span>
                        <span class="font-bold text-black">{{ $b->service->title ?? 'Custom Tuning' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-500">Pemilik / Customer:</span>
                        <span class="font-semibold text-black">{{ $b->customer_name }}</span>
                    </div>
                </div>

                @if($b->custom_request)
                    <div class="pt-3 border-t border-neutral-200 space-y-1 text-xs">
                        <div class="font-bold text-black text-[10px] uppercase">Catatan Request Customer:</div>
                        <p class="text-neutral-600 bg-neutral-bg p-3 border border-neutral-200 italic">&ldquo;{{ $b->custom_request }}&rdquo;</p>
                    </div>
                @endif
            </div>

            <!-- Activity Logs Timeline -->
            <div class="bg-white border border-neutral-200 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Riwayat Update Progres
                </h3>

                <div class="space-y-3 text-xs">
                    @forelse($b->logs as $log)
                        <div class="border-l-2 border-accent pl-3 py-1 space-y-0.5">
                            <div class="flex justify-between text-[11px] font-bold text-black">
                                <span>{{ $log->title }}</span>
                                <span class="text-[10px] text-neutral-400 font-normal">{{ $log->created_at->format('d M, H:i') }}</span>
                            </div>
                            <p class="text-neutral-600 text-[11px]">{{ $log->description }}</p>
                            @if($log->photo_path)
                                <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Foto Progres" class="w-24 h-16 object-cover border border-neutral-200 mt-1">
                            @endif
                        </div>
                    @empty
                        <p class="text-neutral-400 text-xs italic">Belum ada riwayat aktivitas.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Update Form (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-neutral-200 p-6 md:p-8 space-y-6" x-data="{
            status: '{{ old('status', $b->status === 'pending' || $b->status === 'confirmed' ? 'in_progress' : $b->status) }}',
            progress: '{{ old('progress_percentage', max(25, (int)$b->progress_percentage)) }}',
            onStatusChange(val) {
                this.status = val;
                if (val === 'in_progress' && this.progress < 25) this.progress = 25;
                if (val === 'qc' && this.progress < 85) this.progress = 85;
                if (val === 'completed') this.progress = 100;
            }
        }">
            <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                Form Pembaruan Status &amp; Progres Pengerjaan
            </h3>

            <form action="{{ route('karyawan.tasks.update', $b->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Status Pengerjaan *</label>
                        <select name="status" x-model="status" @change="onStatusChange($event.target.value)" required class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">
                            <option value="in_progress">In Progress (Sedang Dikerjakan)</option>
                            <option value="qc">QC &amp; Dyno Test (Uji Kalibrasi)</option>
                            <option value="completed">Completed (Pengerjaan Selesai)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">
                            Progress (%) * (<span x-text="progress"></span>%)
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="range" min="0" max="100" step="5" x-model="progress" name="progress_percentage"
                                   class="w-full h-2 bg-neutral-200 rounded-lg appearance-none cursor-pointer accent-black">
                            <input type="number" min="0" max="100" x-model="progress"
                                   class="w-16 bg-neutral-bg border border-neutral-300 px-2 py-1.5 text-xs text-center text-black font-mono font-bold">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">
                        Judul Tahapan Pengerjaan (Opsional)
                    </label>
                    <input type="text" name="stage_title" value="{{ old('stage_title') }}" placeholder="Contoh: Dyno Run Stage 2 & Setting ECU Selesai"
                           class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2 text-xs text-black focus:outline-none focus:border-black">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">
                        Catatan Pengerjaan / Log Teknis Mekanik (Terlihat oleh Customer)
                    </label>
                    <textarea name="mechanic_notes" rows="4" placeholder="Tuliskan part yang telah diganti, setting AFR, catatan torsi, kendala, atau instruksi berikutnya..."
                              class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">{{ old('mechanic_notes', $b->mechanic_notes) }}</textarea>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">
                        Upload Foto Dokumentasi Progres (Opsional)
                    </label>
                    <input type="file" name="progress_photo" accept="image/*"
                           class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2 text-xs text-black focus:outline-none focus:border-black file:mr-4 file:py-1 file:px-3 file:border-0 file:text-xs file:bg-black file:text-white">
                    <p class="text-[10px] text-neutral-500 mt-1">Format: JPG, PNG, WEBP (Maks 5MB). Foto akan ditampilkan di live tracker customer.</p>
                </div>

                <div class="pt-4 border-t border-neutral-200 flex justify-end">
                    <button type="submit" class="btn-dark">
                        Simpan Pembaruan Progres &rarr;
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
