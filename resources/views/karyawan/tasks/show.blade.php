@extends('layouts.karyawan')

@section('meta_title', 'Update Pengerjaan Unit ' . $booking->booking_code . ' — BENGKEL')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-neutral-200 gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">Tugas Workshop</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-black font-sans">
                {{ $booking->booking_code }}
            </h1>
        </div>
        <div>
            <a href="{{ route('karyawan.tasks.index') }}" class="btn-outline-dark">
                &larr; Kembali ke Daftar Tugas
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Vehicle & Request Specs (5 cols) -->
        <div class="lg:col-span-5 bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
            <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                Informasi Kendaraan &amp; Request
            </h3>

            <div class="space-y-3 text-xs text-neutral-700">
                <div class="flex justify-between">
                    <span class="text-neutral-500">Unit:</span>
                    <span class="font-bold text-black">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-neutral-500">Plat Nomor:</span>
                    <span class="font-mono font-bold text-black">{{ $booking->license_plate }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-neutral-500">Kategori:</span>
                    <span class="capitalize text-black">{{ $booking->vehicle_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-neutral-500">Paket:</span>
                    <span class="font-bold text-black">{{ $booking->service->title ?? 'Custom Tuning' }}</span>
                </div>
            </div>

            @if($booking->custom_request)
                <div class="pt-3 border-t border-neutral-200 space-y-1 text-xs">
                    <div class="font-bold text-black">Catatan Request Customer:</div>
                    <p class="text-neutral-600 bg-neutral-bg p-3 border border-neutral-200 italic">&ldquo;{{ $booking->custom_request }}&rdquo;</p>
                </div>
            @endif
        </div>

        <!-- Right: Update Form (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
            <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                Form Update Status &amp; Catatan Mekanik
            </h3>

            <form action="{{ route('karyawan.tasks.update', $booking->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Status Pengerjaan *</label>
                        <select name="status" required class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">
                            <option value="in_progress" {{ $booking->status === 'in_progress' ? 'selected' : '' }}>In Progress (Sedang Dikerjakan)</option>
                            <option value="qc" {{ $booking->status === 'qc' ? 'selected' : '' }}>QC &amp; Dyno Test (Uji Kalibrasi)</option>
                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed (Pengerjaan Selesai)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Progress (%) *</label>
                        <input type="number" name="progress_percentage" min="0" max="100" value="{{ old('progress_percentage', $booking->progress_percentage) }}" required
                               class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Catatan Pengerjaan / Log Teknis Mekanik</label>
                    <textarea name="admin_notes" rows="5" placeholder="Tuliskan part yang telah diganti, AFR dyno run, catatan torsi, atau status pengerjaan..."
                              class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                </div>

                <div class="pt-4 border-t border-neutral-200 flex justify-end">
                    <button type="submit" class="btn-dark">
                        Simpan Pembaruan &rarr;
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
