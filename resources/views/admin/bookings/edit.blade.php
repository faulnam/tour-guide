@extends('layouts.admin')

@section('title', 'Edit Booking — ' . $booking->booking_code)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-xs text-red-400 hover:underline mb-1 inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Detail Booking
            </a>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight">
                EDIT WORK ORDER & PENUGASAN MEKANIK
            </h1>
        </div>
    </div>

    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 shadow-2xl">
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Penugasan Mekanik & Layanan -->
            <div class="space-y-4">
                <h3 class="font-racing font-bold text-sm text-white uppercase">PENUGASAN MEKANIK & LAYANAN</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Tugaskan ke Mekanik / Karyawan</label>
                        <select name="karyawan_id" class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">-- Pilih Mekanik Workshop --</option>
                            @foreach($mechanics as $mek)
                                <option value="{{ $mek->id }}" {{ $booking->karyawan_id == $mek->id ? 'selected' : '' }}>
                                    {{ $mek->name }} ({{ $mek->specialty ?? 'Mekanik' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Paket Layanan</label>
                        <select name="service_id" class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($services as $srv)
                                <option value="{{ $srv->id }}" {{ $booking->service_id == $srv->id ? 'selected' : '' }}>
                                    {{ $srv->title }} ({{ $srv->formatted_price }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Status Pengerjaan & Progres -->
            <div class="space-y-4 pt-4 border-t border-neutral-800">
                <h3 class="font-racing font-bold text-sm text-white uppercase">STATUS PENGERJAAN & PROGRES</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Status Pengerjaan *</label>
                        <select name="status" required class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu Konfirmasi)</option>
                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed (Unit di Workshop)</option>
                            <option value="in_progress" {{ $booking->status === 'in_progress' ? 'selected' : '' }}>In Progress (Sedang Dikerjakan)</option>
                            <option value="qc" {{ $booking->status === 'qc' ? 'selected' : '' }}>QC & Dyno Test</option>
                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed (Selesai Siap Diambil)</option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Persentase Progres (0-100%) *</label>
                        <input type="number" name="progress_percentage" min="0" max="100" required value="{{ $booking->progress_percentage }}"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Catatan Pengerjaan Teknisi</label>
                    <textarea name="mechanic_notes" rows="3" class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">{{ $booking->mechanic_notes }}</textarea>
                </div>
            </div>

            <!-- Finansial & Pembayaran -->
            <div class="space-y-4 pt-4 border-t border-neutral-800">
                <h3 class="font-racing font-bold text-sm text-white uppercase">FINANSIAL & STATUS PEMBAYARAN</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Total Biaya Tagihan (Rp) *</label>
                        <input type="number" name="total_amount" required value="{{ (int)$booking->total_amount }}"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Down Payment DP (Rp) *</label>
                        <input type="number" name="dp_amount" required value="{{ (int)$booking->dp_amount }}"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Jumlah Sudah Dibayar (Rp) *</label>
                        <input type="number" name="paid_amount" required value="{{ (int)$booking->paid_amount }}"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Status Pembayaran *</label>
                        <select name="payment_status" required class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="unpaid" {{ $booking->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid (Belum Bayar)</option>
                            <option value="dp_paid" {{ $booking->payment_status === 'dp_paid' ? 'selected' : '' }}>DP Paid (DP Lunas)</option>
                            <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Paid (Lunas Penuh)</option>
                            <option value="refunded" {{ $booking->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-between items-center border-t border-neutral-800">
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-xs text-neutral-400 hover:text-white">
                    Batal
                </a>

                <button type="submit" 
                        class="px-8 py-3 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-red-600/30">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
