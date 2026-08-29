@extends('layouts.karyawan')

@php
    $b = $task ?? $booking;
@endphp

@section('meta_title', 'Update Progres Trip ' . $b->booking_code . ' — Nusantara Tour Guide')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 gap-4">
        <div>
            <div class="eyebrow text-sage font-bold">Penugasan Pemandu Lapangan</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-primary font-sans">
                {{ $b->booking_code }} &bull; {{ $b->vehicle_brand }}
            </h1>
        </div>
        <div>
            <a href="{{ route('karyawan.tasks.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 hover:border-primary text-primary font-bold text-xs uppercase tracking-wider transition-all">
                &larr; Kembali ke Daftar Tugas
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="p-4 bg-rose-50 rounded-xl border border-rose-200 text-rose-800 text-xs space-y-1">
            <div class="font-bold">Terjadi kesalahan validasi:</div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Destination & Request Specs (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="tour-card p-6 md:p-8 space-y-6 bg-white">
                <h3 class="text-xs uppercase tracking-wider font-bold text-primary border-b border-gray-100 pb-3">
                    Informasi Destinasi &amp; Tamu
                </h3>

                <div class="space-y-3 text-xs text-gray-700">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Destinasi:</span>
                        <span class="font-bold text-primary">{{ $b->vehicle_brand }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Titik Jemput:</span>
                        <span class="font-bold text-primary">{{ $b->vehicle_model }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Peserta:</span>
                        <span class="font-mono font-bold text-primary">{{ $b->license_plate }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Kategori Tur:</span>
                        <span class="capitalize text-primary">{{ $b->vehicle_type }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Paket:</span>
                        <span class="font-bold text-primary">{{ $b->service->title ?? 'Private Guided Tour' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Wisatawan / Kontak:</span>
                        <span class="font-semibold text-primary">{{ $b->customer_name }} ({{ $b->customer_phone }})</span>
                    </div>
                </div>

                @if($b->custom_request)
                    <div class="pt-3 border-t border-gray-100 space-y-1 text-xs">
                        <div class="font-bold text-primary text-[10px] uppercase">Catatan / Permintaan Khusus Tamu:</div>
                        <p class="text-gray-600 bg-[#F8FAF9] p-3 rounded-xl border border-gray-100 italic">&ldquo;{{ $b->custom_request }}&rdquo;</p>
                    </div>
                @endif

                @if($b->status === 'completed')
                    <div class="pt-3 border-t border-gray-100 space-y-2 text-xs">
                        <div class="font-bold text-[10px] uppercase flex items-center gap-1.5 text-emerald-700">
                            <span>✓</span>
                            <span>Konfirmasi Lokasi Selesai / Pengantaran:</span>
                        </div>
                        <div class="p-3 bg-[#F8FAF9] rounded-xl border border-gray-100 space-y-1 text-gray-800">
                            <div class="font-bold">{{ $b->delivery_method_label }}</div>
                            @if($b->delivery_method === 'delivery_address' && $b->delivery_address)
                                <div class="text-[11px] text-gray-600">
                                    <strong>Lokasi Pengantaran:</strong> {{ $b->delivery_address }}
                                </div>
                            @endif
                            @if($b->delivery_notes)
                                <div class="text-[11px] text-gray-500 italic">
                                    Catatan: {{ $b->delivery_notes }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Stage Logs History -->
            <div class="tour-card p-6 md:p-8 space-y-4 bg-white">
                <h3 class="text-xs uppercase tracking-wider font-bold text-primary border-b border-gray-100 pb-3">
                    Log Perjalanan Lapangan
                </h3>

                <div class="space-y-4 max-h-80 overflow-y-auto pr-1">
                    @forelse($b->logs->sortByDesc('created_at') as $log)
                        <div class="p-3 bg-[#F8FAF9] rounded-xl border border-gray-100 space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-primary">{{ $log->title }}</span>
                                <span class="text-[10px] text-gray-400 font-mono">{{ $log->created_at->format('d/m H:i') }}</span>
                            </div>
                            <p class="text-gray-600 leading-relaxed">{{ $log->description }}</p>
                            @if($log->photo_path)
                                <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Foto Log" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-xs">
                            Belum ada catatan log progres yang ditambahkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Update Form (7 cols) -->
        <div class="lg:col-span-7 tour-card p-6 md:p-8 space-y-6 bg-white">
            <h3 class="text-xs uppercase tracking-wider font-bold text-primary border-b border-gray-100 pb-3">
                Update Status &amp; Unggah Catatan Ekspedisi
            </h3>

            <form action="{{ route('karyawan.tasks.update', $b->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Status Ekspedisi *</label>
                    <select name="status" required class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-4 py-3 text-xs text-gray-800 focus:outline-none focus:border-primary">
                        <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>Confirmed (Jadwal Terkonfirmasi)</option>
                        <option value="in_progress" {{ $b->status === 'in_progress' ? 'selected' : '' }}>In Progress (Tur Sedang Berlangsung)</option>
                        <option value="qc" {{ $b->status === 'qc' ? 'selected' : '' }}>Tahap Akhir / Spot Foto Terakhir</option>
                        <option value="completed" {{ $b->status === 'completed' ? 'selected' : '' }}>Completed (Seluruh Rute Selesai &amp; Sukses)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Judul Aktivitas / Tahap Rute *</label>
                    <input type="text" name="log_title" required placeholder="Contoh: Penjemputan Bandara / Tiba di Puncak Padar"
                           class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-4 py-3 text-xs text-gray-800 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Catatan Kondisi Lapangan &amp; Tamu *</label>
                    <textarea name="log_description" rows="3" required placeholder="Deskripsikan cuaca, aktivitas tamu, waktu kedatangan, atau spot yang telah dikunjungi..."
                              class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-4 py-3 text-xs text-gray-800 focus:outline-none focus:border-primary"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Unggah Foto Dokumentasi Lapangan (Opsional)</label>
                    <input type="file" name="log_photo" accept="image/*"
                           class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-primary">
                    <p class="text-[10px] text-gray-400 mt-1">Foto ini akan otomatis muncul di portal digital travel pass milik traveler.</p>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cloud-arrow-up text-xs text-accent"></i>
                        <span>Simpan Perubahan &amp; Kirim Update &rarr;</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
