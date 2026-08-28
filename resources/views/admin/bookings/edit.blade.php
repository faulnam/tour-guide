@extends('layouts.admin')

@section('page_title', 'Update Booking ' . $booking->booking_code)

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-accent font-semibold">Update Assignment &amp; Progress</div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">
                {{ $booking->booking_code }}
            </h2>
        </div>
        <div>
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-4 py-2 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
                &larr; Batal &amp; Kembali
            </a>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 max-w-3xl">
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Status Pengerjaan *</label>
                    <select name="status" required class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu Antrean)</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed (Terkonfirmasi Masuk)</option>
                        <option value="in_progress" {{ $booking->status === 'in_progress' ? 'selected' : '' }}>In Progress (Sedang Dikerjakan)</option>
                        <option value="qc" {{ $booking->status === 'qc' ? 'selected' : '' }}>QC &amp; Dyno Test</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Tugaskan Mekanik / Lead Tuner</label>
                    <select name="mechanic_id" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                        <option value="">-- Belum Ditugaskan --</option>
                        @foreach($mechanics as $m)
                            <option value="{{ $m->id }}" {{ $booking->mechanic_id == $m->id ? 'selected' : '' }}>
                                {{ $m->name }} ({{ $m->specialty ?? 'Teknisi' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Persentase Progress (0 - 100)%</label>
                    <input type="number" name="progress_percentage" min="0" max="100" value="{{ old('progress_percentage', $booking->progress_percentage) }}"
                           class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Status Pembayaran DP</label>
                    <select name="payment_status" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                        <option value="unpaid" {{ $booking->payment_status === 'unpaid' ? 'selected' : '' }}>Pending / Belum Bayar</option>
                        <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Catatan Pengerjaan Internal Mekanik</label>
                <textarea name="admin_notes" rows="4" placeholder="Catatan part yang diganti, AFR dyno, atau keluhan teknis..."
                          class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
            </div>

            <div class="pt-4 border-t border-neutral-800 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-wider font-semibold transition-colors">
                    Simpan Perubahan &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
