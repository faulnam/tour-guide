@extends('layouts.admin')

@section('page_title', 'Update Reservasi ' . $booking->booking_code)

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-wider text-accent font-bold">Penugasan &amp; Manajemen Reservasi</div>
            <h2 class="text-xl font-bold uppercase tracking-wider text-white font-sans">
                {{ $booking->booking_code }}
            </h2>
            <div class="text-xs text-neutral-400 mt-0.5">
                Destinasi: <span class="text-white font-semibold">{{ $booking->vehicle_brand }}</span> &bull; Traveler: <span class="text-white">{{ $booking->customer_name }}</span>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-4 py-2 border border-neutral-700 rounded-lg text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
                &larr; Batal &amp; Kembali
            </a>
        </div>
    </div>

    @if(isset($errors) && $errors->any())
        <div class="p-4 bg-rose-950/80 border border-rose-800 text-rose-300 text-xs space-y-1 rounded-xl">
            <div class="font-bold uppercase tracking-wider">Terjadi kesalahan validasi:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Form Card -->
    <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 md:p-8 max-w-4xl" x-data="{
        status: '{{ old('status', $booking->status) }}',
        progress: '{{ old('progress_percentage', $booking->progress_percentage) }}',
        onStatusChange(val) {
            this.status = val;
            if (val === 'pending') this.progress = 0;
            else if (val === 'confirmed') this.progress = Math.max(10, this.progress);
            else if (val === 'in_progress') this.progress = Math.max(25, this.progress);
            else if (val === 'qc') this.progress = Math.max(85, this.progress);
            else if (val === 'completed') this.progress = 100;
            else if (val === 'cancelled') this.progress = 0;
        }
    }">
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Guide Assignment & Status -->
            <div class="space-y-4">
                <div class="text-[11px] uppercase tracking-wider font-bold text-white border-b border-neutral-800 pb-2">
                    1. Penugasan Pemandu Wisata &amp; Status Ekspedisi
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-300 mb-1">
                            Tugaskan Pemandu Wisata (Tour Guide) <span class="text-accent">*</span>
                        </label>
                        <select name="karyawan_id" class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
                            <option value="">-- Belum Ditugaskan --</option>
                            @foreach($mechanics as $m)
                                <option value="{{ $m->id }}" {{ old('karyawan_id', $booking->karyawan_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }} ({{ $m->specialty ?? 'Pemandu Lisensi HPI' }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-neutral-500 mt-1">Pemandu yang ditugaskan akan otomatis menerima penugasan di portal staf.</p>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-300 mb-1">
                            Status Progres Trip <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" x-model="status" @change="onStatusChange($event.target.value)" required class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
                            <option value="pending">Pending (Menunggu Pembayaran DP)</option>
                            <option value="confirmed">Confirmed (Jadwal Terkunci &amp; Terkonfirmasi)</option>
                            <option value="in_progress">In Progress (Tur Sedang Berlangsung)</option>
                            <option value="qc">Tahap Akhir / Spot Terakhir</option>
                            <option value="completed">Completed (Selesai Sepenuhnya)</option>
                            <option value="cancelled">Cancelled (Dibatalkan)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center pt-2">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-300 mb-1">
                            Persentase Progress Rute (<span x-text="progress"></span>%)
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="range" min="0" max="100" step="5" x-model="progress" name="progress_percentage"
                                   class="w-full h-2 bg-neutral-800 rounded-lg appearance-none cursor-pointer accent-accent">
                            <input type="number" min="0" max="100" x-model="progress"
                                   class="w-16 bg-neutral-950 border border-neutral-700 rounded-lg px-2 py-1 text-xs text-center text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-300 mb-1">
                            Status Pembayaran
                        </label>
                        <select name="payment_status" class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
                            <option value="unpaid" {{ old('payment_status', $booking->payment_status) === 'unpaid' ? 'selected' : '' }}>Unpaid (Belum Bayar DP)</option>
                            <option value="dp_paid" {{ old('payment_status', $booking->payment_status) === 'dp_paid' ? 'selected' : '' }}>DP Paid (Uang Muka 30% Terbayar)</option>
                            <option value="fully_paid" {{ old('payment_status', $booking->payment_status) === 'fully_paid' ? 'selected' : '' }}>Fully Paid (Lunas 100%)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Notes -->
            <div class="space-y-4 pt-4 border-t border-neutral-800">
                <div class="text-[11px] uppercase tracking-wider font-bold text-white border-b border-neutral-800 pb-2">
                    2. Catatan Evaluasi &amp; Koordinasi Lapangan
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-300 mb-1">
                        Catatan Resmi Pemandu / Dispatcher
                    </label>
                    <textarea name="mechanic_notes" rows="3" placeholder="Contoh: Tamu telah dijemput di Bandara Ngurah Rai, cuaca cerah..."
                              class="w-full bg-neutral-950 border border-neutral-700 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-accent">{{ old('mechanic_notes', $booking->mechanic_notes) }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-neutral-800 flex justify-end gap-3">
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-5 py-2.5 border border-neutral-700 rounded-xl text-neutral-400 hover:text-white text-xs uppercase tracking-wider font-bold">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white hover:bg-secondary rounded-xl text-xs uppercase tracking-wider font-bold transition-colors shadow-sm">
                    Simpan Perubahan &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
