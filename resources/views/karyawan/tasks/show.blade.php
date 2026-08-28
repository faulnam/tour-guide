@extends('layouts.karyawan')

@section('title', 'Detail Tugas — ' . $task->booking_code)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('karyawan.tasks.index') }}" class="text-xs text-amber-400 hover:underline mb-1 inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Tugas
            </a>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight">
                WORK ORDER PENGERJAAN: {{ $task->booking_code }}
            </h1>
        </div>
        <div>
            {!! $task->status_badge !!}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Update Progress Form & Timeline Logs -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Update Progress Form Card -->
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                <h3 class="font-racing font-bold text-base text-white uppercase">UPDATE PROGRES PENGERJAAN</h3>

                <form action="{{ route('karyawan.tasks.progress', $task->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Status Pengerjaan *</label>
                            <select name="status" required class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-amber-500">
                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan (In Progress)</option>
                                <option value="qc" {{ $task->status === 'qc' ? 'selected' : '' }}>Quality Control & Dyno Test (QC)</option>
                                <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Selesai / Siap Diambil Customer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Persentase Progres (0-100%) *</label>
                            <input type="number" name="progress_percentage" min="0" max="100" required value="{{ $task->progress_percentage }}"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Tahap Pekerjaan (Stage) *</label>
                            <select name="stage" required class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-amber-500">
                                <option value="disassembly">1. Pembongkaran / Disassembly</option>
                                <option value="machining_dyno">2. Setting Mesin / Remap / Dyno</option>
                                <option value="paint_body">3. Pengecatan Oven / Fabrikasi Bodykit</option>
                                <option value="assembly">4. Perakitan / Wiring Kelistrikan</option>
                                <option value="qc_test">5. Final QC & Test Drive</option>
                                <option value="ready">6. Unit Siap Serah Terima</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Judul Aktivitas Progres *</label>
                            <input type="text" name="stage_title" required placeholder="Contoh: Selesai Dyno Baseline & Porting"
                                   class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Catatan Mekanik / Detail Pengerjaan</label>
                        <textarea name="mechanic_notes" rows="3" placeholder="Tuliskan catatan teknis part yang diganti, hasil AFR dyno, atau hal yang perlu diketahui customer..."
                                  class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-amber-500">{{ $task->mechanic_notes }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Upload Foto Bukti Progres (Opsional)</label>
                        <input type="file" name="progress_photo" accept="image/*"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2 text-xs text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-600 file:text-black hover:file:bg-amber-500">
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-black font-racing font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-amber-600/30 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Simpan & Publikasikan Progres ke Customer</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Real-Time Activity Logs Timeline -->
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 space-y-6">
                <h3 class="font-racing font-bold text-base text-white uppercase">TIMELINE PROGRES PENGERJAAN</h3>

                <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-neutral-800">
                    @forelse($task->logs as $log)
                        <div class="relative flex items-start gap-4 pl-8">
                            <div class="absolute left-1.5 top-1 w-4 h-4 rounded-full bg-amber-500 border-2 border-neutral-900 shadow"></div>
                            <div class="flex-1 bg-[#0a0a0e] border border-neutral-800/80 p-4 rounded-2xl space-y-1.5">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-white">{{ $log->title }}</span>
                                    <span class="text-neutral-500 font-mono text-[10px]">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-xs text-neutral-400">{{ $log->description }}</p>
                                <div class="text-[10px] text-neutral-500">Oleh: {{ $log->user->name ?? 'Mekanik' }}</div>
                                @if($log->photo_path)
                                    <div class="pt-2">
                                        <img src="{{ $log->photo_url }}" class="w-36 h-24 object-cover rounded-xl border border-neutral-700">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-neutral-500 pl-8">Belum ada catatan log progres.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Vehicle Specs & Customer Info -->
        <div class="space-y-6">
            
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-4">
                <h4 class="font-racing font-bold text-xs text-white uppercase tracking-wider">DETAIL KENDARAAN</h4>

                <div class="space-y-2 text-xs text-neutral-300">
                    <div class="flex justify-between"><span class="text-neutral-500">Tipe:</span> <span class="font-bold text-white">{{ $task->vehicle_type_label }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Merk & Model:</span> <span class="font-bold text-white">{{ $task->vehicle_brand }} {{ $task->vehicle_model }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Plat Nomor:</span> <span class="font-mono font-bold text-red-400">{{ $task->license_plate }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Tahun / Warna:</span> <span>{{ $task->vehicle_year ?? '-' }} / {{ $task->vehicle_color ?? '-' }}</span></div>
                </div>
            </div>

            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-4">
                <h4 class="font-racing font-bold text-xs text-white uppercase tracking-wider">CUSTOMER & JADWAL</h4>

                <div class="space-y-2 text-xs text-neutral-300">
                    <div class="flex justify-between"><span class="text-neutral-500">Nama:</span> <span class="font-bold text-white">{{ $task->customer_name }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Telepon:</span> <span class="font-bold text-emerald-400">{{ $task->customer_phone }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Tgl Booking:</span> <span>{{ \Carbon\Carbon::parse($task->booking_date)->translatedFormat('d M Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-neutral-500">Slot Jam:</span> <span>{{ $task->booking_time_slot }}</span></div>
                </div>

                @if($task->custom_request)
                    <div class="pt-3 border-t border-neutral-800">
                        <div class="text-[10px] text-neutral-400 uppercase font-bold mb-1">Permintaan Khusus Customer:</div>
                        <p class="text-xs text-neutral-300 italic bg-[#0a0a0e] p-3 rounded-xl border border-neutral-800">
                            "{{ $task->custom_request }}"
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
