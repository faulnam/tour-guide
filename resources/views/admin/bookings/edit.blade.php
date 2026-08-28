@extends('layouts.admin')

@section('page_title', 'Update Booking ' . $booking->booking_code)

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-accent font-semibold">Penugasan &amp; Manajemen Booking</div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">
                {{ $booking->booking_code }}
            </h2>
            <div class="text-xs text-neutral-400 mt-0.5">
                Unit: <span class="text-white font-semibold">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</span> ({{ $booking->license_plate }}) &bull; Customer: <span class="text-white">{{ $booking->customer_name }}</span>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-4 py-2 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
                &larr; Batal &amp; Kembali
            </a>
        </div>
    </div>

    @if(isset($errors) && $errors->any())
        <div class="p-4 bg-red-950/80 border border-red-800 text-red-300 text-xs space-y-1">
            <div class="font-bold uppercase tracking-wider">Terjadi kesalahan validasi:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Form Card -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 max-w-4xl" x-data="{
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

            <!-- Section 1: Workshop Assignment & Status -->
            <div class="space-y-4">
                <div class="text-[11px] uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-2">
                    1. Penugasan Teknisi / Mekanik &amp; Status Pengerjaan
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                            Tugaskan Mekanik / Lead Tuner <span class="text-accent">*</span>
                        </label>
                        <select name="karyawan_id" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                            <option value="">-- Belum Ditugaskan --</option>
                            @foreach($mechanics as $m)
                                <option value="{{ $m->id }}" {{ old('karyawan_id', $booking->karyawan_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }} ({{ $m->specialty ?? 'Workshop Specialist' }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-neutral-500 mt-1">Menugaskan mekanik akan otomatis mengaktifkan status pengerjaan (In Progress).</p>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                            Status Pengerjaan Workshop <span class="text-red-500">*</span>
                        </label>
                        <select name="status" x-model="status" @change="onStatusChange($event.target.value)" required class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                            <option value="pending">Pending (Menunggu Antrean)</option>
                            <option value="confirmed">Confirmed (Terkonfirmasi Masuk)</option>
                            <option value="in_progress">In Progress (Sedang Dikerjakan)</option>
                            <option value="qc">QC &amp; Dyno Test (Uji Kalibrasi)</option>
                            <option value="completed">Completed (Selesai / Siap Diambil)</option>
                            <option value="cancelled">Cancelled (Dibatalkan)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center pt-2">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                            Persentase Progress Pengerjaan (<span x-text="progress"></span>%)
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="range" min="0" max="100" step="5" x-model="progress" name="progress_percentage"
                                   class="w-full h-2 bg-neutral-800 rounded-lg appearance-none cursor-pointer accent-accent">
                            <input type="number" min="0" max="100" x-model="progress"
                                   class="w-20 bg-neutral-950 border border-neutral-700 px-2 py-1.5 text-xs text-center text-white font-mono">
                        </div>
                        <p class="text-[10px] text-neutral-500 mt-1">
                            Otomatis terisi sesuai status pengerjaan dan dapat disesuaikan berkala oleh Mekanik pelaksana di portalnya.
                        </p>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                            Paket Modifikasi / Servis
                        </label>
                        <select name="service_id" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                            <option value="">-- Custom Service / Tidak Terikat Paket --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}" {{ old('service_id', $booking->service_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->title }} ({{ $s->formatted_price }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>


            <!-- Section 2: Notes -->
            <div class="space-y-4 pt-4 border-t border-neutral-800">
                <div class="text-[11px] uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-2">
                    2. Catatan Teknis &amp; Komunikasi Pengerjaan
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                        Catatan Pengerjaan / Log Teknis Mekanik (Bisa dilihat oleh Customer pada Live Tracker)
                    </label>
                    <textarea name="mechanic_notes" rows="4" placeholder="Catatan part yang diganti, AFR dyno run, catatan torsi baut, atau progres terkini..."
                              class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">{{ old('mechanic_notes', $booking->mechanic_notes) }}</textarea>
                </div>
            </div>

            <!-- Section 3: Handover & Delivery Settings -->
            <div class="space-y-4 pt-4 border-t border-neutral-800" x-data="{
                delMethod: '{{ old('delivery_method', $booking->delivery_method ?? 'pickup_workshop') }}'
            }">
                <div class="text-[11px] uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-2">
                    3. Metode Penyerahan &amp; Pengambilan Unit (Setelah Selesai)
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                            Metode Penyerahan Kendaraan
                        </label>
                        <select name="delivery_method" x-model="delMethod" class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                            <option value="pickup_workshop">Diambil Sendiri ke Workshop BENGKEL</option>
                            <option value="delivery_address">Diantar ke Alamat Customer (Delivery / Towing)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                            Catatan Pengantaran Khusus
                        </label>
                        <input type="text" name="delivery_notes" value="{{ old('delivery_notes', $booking->delivery_notes) }}" placeholder="Contoh: Titip security, kirim pakai towing..."
                               class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                    </div>
                </div>

                <div x-show="delMethod === 'delivery_address'" class="pt-2" x-cloak>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                        Alamat Lengkap Tujuan Pengiriman Unit
                    </label>
                    <textarea name="delivery_address" rows="2" placeholder="Nama jalan, nomor rumah, RT/RW, kota, kode pos..."
                              class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">{{ old('delivery_address', $booking->delivery_address ?: ($booking->customer->address ?? '')) }}</textarea>
                </div>
            </div>

            <div class="pt-6 border-t border-neutral-800 flex items-center justify-between">
                <div class="text-xs text-neutral-500">
                    Perubahan status, mekanik, dan penyerahan unit akan otomatis dicatat ke riwayat log aktivitas booking.
                </div>
                <button type="submit" class="px-6 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest font-bold transition-colors">
                    Simpan Perubahan &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
