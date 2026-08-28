@extends('layouts.customer')

@section('meta_title', 'Detail Booking ' . $booking->booking_code . ' — BENGKEL')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-neutral-200 gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">Detail Pemesanan &amp; Pengerjaan</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-black font-sans">
                {{ $booking->booking_code }}
            </h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="btn-dark text-xs">
                Lihat Invoice / Pembayaran &rarr;
            </a>
            <a href="{{ route('customer.bookings.index') }}" class="btn-outline-dark text-xs">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Details & Log (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Informasi Kendaraan &amp; Paket Servis
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-neutral-700">
                    <div class="space-y-1">
                        <div class="text-[10px] uppercase font-bold text-neutral-400">Kendaraan:</div>
                        <div class="text-base font-bold text-black">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</div>
                        <div>Plat: <span class="font-mono font-bold">{{ $booking->license_plate }}</span></div>
                        <div class="capitalize text-neutral-500">Tipe: {{ $booking->vehicle_type }}</div>
                    </div>

                    <div class="space-y-1">
                        <div class="text-[10px] uppercase font-bold text-neutral-400">Jadwal Kedatangan:</div>
                        <div class="font-bold text-black">{{ $booking->booking_date ? $booking->booking_date->translatedFormat('l, d F Y') : '-' }}</div>
                        <div>Pukul: {{ $booking->booking_time_slot }}</div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-200 space-y-2 text-xs">
                    <div class="text-[10px] uppercase font-bold text-neutral-400">Layanan:</div>
                    <div class="font-bold text-black text-sm">{{ $booking->service->title ?? 'Custom Tuning & Modifikasi' }}</div>
                    @if($booking->custom_request)
                        <div class="p-3 bg-neutral-bg border border-neutral-200 text-neutral-600 mt-2">
                            <span class="font-bold text-black block text-[10px] uppercase">Catatan Permintaan Anda:</span>
                            &ldquo;{{ $booking->custom_request }}&rdquo;
                        </div>
                    @endif

                    @if($booking->mechanic_notes)
                        <div class="p-3 bg-neutral-bg border border-neutral-200 text-neutral-800 mt-2">
                            <span class="font-bold text-black block text-[10px] uppercase">Catatan Langsung dari Teknisi:</span>
                            {{ $booking->mechanic_notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Logs Timeline -->
            <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Linimasa Pengerjaan Unit di Workshop
                </h3>

                <div class="space-y-4 text-xs">
                    @forelse($booking->logs as $log)
                        <div class="flex items-start gap-3 border-l-2 border-accent pl-4 py-1">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-black text-xs">{{ $log->title }}</span>
                                    <span class="text-[10px] text-neutral-400">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-neutral-600 text-[11px]">{{ $log->description }}</p>
                                @if($log->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Progres Foto" class="w-40 h-28 object-cover border border-neutral-200">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-neutral-400 text-xs italic">Menunggu update progres awal dari workshop.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Status Tracker & Payment (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white border border-neutral-200 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Status Pengerjaan Workshop
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Status Saat Ini:</span>
                        <div>{!! $booking->status_badge !!}</div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between text-neutral-500">
                            <span>Progress Pengerjaan:</span>
                            <span class="font-bold text-black">{{ $booking->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-neutral-200 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-black h-2.5 transition-all duration-500" style="width: {{ $booking->progress_percentage }}%"></div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-neutral-100">
                        <span class="text-neutral-500">Lead Mekanik:</span>
                        <span class="font-bold text-black">{{ $booking->mechanic->name ?? 'Dalam Penjadwalan Tim' }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Card -->
            <div class="bg-white border border-neutral-200 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-black border-b border-neutral-200 pb-3">
                    Status Pembayaran
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Status Tagihan:</span>
                        <div>{!! $booking->payment_badge !!}</div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Estimasi Total Biaya:</span>
                        <span class="font-bold text-black">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Ketentuan DP Wajib:</span>
                        <span class="font-semibold text-neutral-700">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center border-t border-neutral-100 pt-2">
                        <span class="text-neutral-500">Total Terbayar:</span>
                        <span class="font-bold text-black">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-500">Sisa Pelunasan:</span>
                        @php $sisa = $booking->remaining_amount; @endphp
                        <span class="font-bold text-black">
                            {{ $sisa > 0 ? 'Rp ' . number_format($sisa, 0, ',', '.') : 'Lunas Penuh' }}
                        </span>
                    </div>

                    @if($booking->status === 'completed' && $sisa > 0)
                        <div class="pt-3">
                            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="btn-dark w-full text-center block">
                                Lunasi Sisa Tagihan (Rp {{ number_format($sisa, 0, ',', '.') }}) &rarr;
                            </a>
                        </div>
                    @elseif(!in_array($booking->payment_status, ['paid', 'dp_paid']))
                        <div class="pt-3">
                            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="btn-dark w-full text-center block">
                                Bayar DP Sekarang &rarr;
                            </a>
                        </div>
                    @else
                        <div class="pt-3">
                            <a href="{{ route('booking.checkout', $booking->booking_code) }}" class="btn-outline-dark w-full text-center block text-xs">
                                Lihat Invoice &amp; Penyerahan Unit &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Handover Preference Card -->
            @if($booking->status === 'completed')
                <div class="bg-white border-2 border-black p-6 space-y-4 shadow-sm" x-data="{
                    deliveryMethod: '{{ old('delivery_method', $booking->delivery_method ?? 'pickup_workshop') }}',
                    deliveryAddress: '{{ old('delivery_address', $booking->delivery_address ?? (auth()->user()->address ?? '')) }}',
                    deliveryNotes: '{{ old('delivery_notes', $booking->delivery_notes ?? '') }}',
                    isEditing: {{ $booking->delivery_method ? 'false' : 'true' }},
                    loading: false,
                    saved: false,
                    save() {
                        this.loading = true;
                        fetch('{{ route('booking.delivery_method', $booking->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                delivery_method: this.deliveryMethod,
                                delivery_address: this.deliveryAddress,
                                delivery_notes: this.deliveryNotes
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.loading = false;
                            if(data.success) {
                                this.saved = true;
                                this.isEditing = false;
                                setTimeout(() => window.location.reload(), 1000);
                            }
                        })
                        .catch(() => { this.loading = false; });
                    }
                }">
                    <div class="flex items-center justify-between border-b border-neutral-200 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-ping"></span>
                            <h3 class="text-xs uppercase tracking-widest font-bold text-black">
                                Metode Penyerahan Unit (Pengerjaan Selesai)
                            </h3>
                        </div>
                        @if($booking->delivery_method)
                            <button type="button" @click="isEditing = !isEditing" class="text-[11px] text-accent hover:underline font-semibold uppercase">
                                <span x-show="!isEditing">Ubah Pilihan</span>
                                <span x-show="isEditing" x-cloak>Tutup Form</span>
                            </button>
                        @endif
                    </div>

                    <!-- Display Selected State -->
                    <div x-show="!isEditing" class="space-y-2 text-xs">
                        <div class="font-bold text-black text-sm flex items-center gap-1.5">
                            <span class="text-emerald-600">✓</span>
                            <span>{{ $booking->delivery_method_label }}</span>
                        </div>
                        @if($booking->delivery_method === 'delivery_address' && $booking->delivery_address)
                            <div class="text-neutral-700 p-3 bg-neutral-50 border border-neutral-200">
                                <span class="font-bold text-black block text-[10px] uppercase">Alamat Tujuan Pengiriman:</span>
                                {{ $booking->delivery_address }}
                            </div>
                        @elseif($booking->delivery_method === 'pickup_workshop')
                            <div class="text-neutral-600 p-3 bg-neutral-50 border border-neutral-200 text-[11px]">
                                <strong class="text-black">Lokasi Workshop:</strong> Jl. Raya Modifikasi No. 88, Studio &amp; Dyno Lab, Jakarta.<br>
                                <span class="text-neutral-500">Silakan datang membawa bukti booking atau KTP terdaftar pada jam operasional (08:30 - 18:00 WIB).</span>
                            </div>
                        @endif
                        @if($booking->delivery_notes)
                            <div class="text-neutral-500 text-[11px] italic">
                                Catatan: {{ $booking->delivery_notes }}
                            </div>
                        @endif
                    </div>

                    <!-- Interactive Form State -->
                    <div x-show="isEditing" class="space-y-4 text-xs" x-cloak>
                        <p class="text-neutral-600 text-[11px]">
                            Unit Anda sudah selesai! Silakan tentukan apakah unit akan diambil sendiri ke workshop atau diantar ke alamat Anda:
                        </p>

                        <div class="space-y-2">
                            <label class="p-3 border flex items-start gap-2.5 cursor-pointer"
                                   :class="deliveryMethod === 'pickup_workshop' ? 'border-black bg-neutral-50 ring-1 ring-black' : 'border-neutral-200'">
                                <input type="radio" name="cust_delivery" value="pickup_workshop" x-model="deliveryMethod" class="mt-0.5 accent-black">
                                <div>
                                    <div class="font-bold text-black">Diambil Sendiri ke Workshop</div>
                                    <div class="text-[10px] text-neutral-500">Ambil langsung ke studio workshop BENGKEL</div>
                                </div>
                            </label>

                            <label class="p-3 border flex items-start gap-2.5 cursor-pointer"
                                   :class="deliveryMethod === 'delivery_address' ? 'border-black bg-neutral-50 ring-1 ring-black' : 'border-neutral-200'">
                                <input type="radio" name="cust_delivery" value="delivery_address" x-model="deliveryMethod" class="mt-0.5 accent-black">
                                <div>
                                    <div class="font-bold text-black">Diantar ke Alamat (Delivery / Towing)</div>
                                    <div class="text-[10px] text-neutral-500">Unit diantar menggunakan towing valet delivery</div>
                                </div>
                            </label>
                        </div>

                        <div x-show="deliveryMethod === 'delivery_address'" class="space-y-2 pt-2 border-t border-neutral-200">
                            <div>
                                <label class="block text-[10px] uppercase font-bold text-black mb-1">Alamat Tujuan Lengkap *</label>
                                <textarea x-model="deliveryAddress" rows="2" placeholder="Nama jalan, nomor rumah, RT/RW, kota, kode pos..."
                                          class="w-full bg-neutral-bg border border-neutral-300 p-2 text-xs text-black focus:outline-none focus:border-black"></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase font-bold text-black mb-1">Catatan Waktu / Instruksi (Opsional)</label>
                                <input type="text" x-model="deliveryNotes" placeholder="Contoh: Tolong antar setelah jam 13:00 WIB"
                                       class="w-full bg-neutral-bg border border-neutral-300 p-2 text-xs text-black focus:outline-none focus:border-black">
                            </div>
                        </div>

                        <div class="pt-2 flex items-center justify-between">
                            <button type="button" @click="save()" :disabled="loading" class="btn-dark text-xs px-5 py-2">
                                <span x-show="!loading">Konfirmasi Pilihan &rarr;</span>
                                <span x-show="loading" x-cloak>Menyimpan...</span>
                            </button>
                            <span x-show="saved" class="text-emerald-600 font-bold text-[11px]">✓ Tersimpan!</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white border border-neutral-200 p-5 space-y-2 text-xs">
                    <div class="flex items-center gap-2 text-neutral-400">
                        <span class="w-2 h-2 rounded-full bg-neutral-300"></span>
                        <span class="uppercase tracking-widest font-bold text-[10px]">Opsi Penyerahan Unit</span>
                    </div>
                    <p class="text-neutral-500 text-[11px] leading-relaxed">
                        Pilihan pengambilan di workshop atau pengantaran ke alamat (delivery) akan aktif secara otomatis setelah pengerjaan unit <strong class="text-black">Selesai (Completed)</strong>.
                    </p>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection
