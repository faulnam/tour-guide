@extends('layouts.admin')

@section('page_title', 'Detail Booking ' . $booking->booking_code)

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-accent font-semibold">Booking Management &amp; Dispatch</div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">
                {{ $booking->booking_code }}
            </h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="px-4 py-2 bg-white text-black hover:bg-neutral-200 text-xs font-semibold uppercase tracking-wider transition-colors">
                Edit Status / Penugasan Mekanik &rarr;
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Booking Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Customer, Vehicle & Timeline (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Customer & Unit Card -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-6">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Informasi Pemesan &amp; Unit Kendaraan
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-neutral-300">
                    <div class="space-y-2">
                        <div class="text-[10px] uppercase font-bold text-neutral-500">Customer</div>
                        <div class="text-sm font-bold text-white">{{ $booking->customer_name }}</div>
                        <div>Email: {{ $booking->customer_email }}</div>
                        <div>Telepon: {{ $booking->customer_phone }}</div>
                    </div>

                    <div class="space-y-2">
                        <div class="text-[10px] uppercase font-bold text-neutral-500">Kendaraan</div>
                        <div class="text-sm font-bold text-white">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</div>
                        <div>Plat Nomor: <span class="font-mono text-accent font-bold">{{ $booking->license_plate }}</span></div>
                        <div class="capitalize">Kategori: {{ $booking->vehicle_type }}</div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-800 space-y-2 text-xs text-neutral-300">
                    <div class="text-[10px] uppercase font-bold text-neutral-500">Jadwal &amp; Layanan</div>
                    <div class="font-bold text-white text-sm">{{ $booking->service->title ?? 'Custom Modification & Service' }}</div>
                    <div>Tanggal Kedatangan: {{ $booking->booking_date ? $booking->booking_date->format('d F Y') : '-' }} • {{ $booking->booking_time_slot }}</div>
                    
                    @if($booking->custom_request)
                        <div class="p-3 bg-neutral-950 border border-neutral-800 text-neutral-400 mt-2 italic">
                            <span class="font-bold text-neutral-300 not-italic block text-[10px] uppercase">Permintaan Khusus:</span>
                            &ldquo;{{ $booking->custom_request }}&rdquo;
                        </div>
                    @endif

                    @if($booking->mechanic_notes)
                        <div class="p-3 bg-neutral-950 border border-neutral-800 text-accent mt-2">
                            <span class="font-bold text-neutral-300 block text-[10px] uppercase">Catatan Mekanik / Workshop:</span>
                            {{ $booking->mechanic_notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Logs Timeline -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Riwayat Aktivitas &amp; Log Pengerjaan
                </h3>

                <div class="space-y-4 text-xs">
                    @forelse($booking->logs as $log)
                        <div class="flex items-start gap-3 border-l-2 border-accent pl-4 py-1">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white text-xs">{{ $log->title }}</span>
                                    <span class="text-[10px] text-neutral-500">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-neutral-400 text-[11px]">{{ $log->description }}</p>
                                @if($log->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $log->photo_path) }}" alt="Progres Foto" class="w-32 h-20 object-cover border border-neutral-700">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-neutral-500 text-xs italic">Belum ada riwayat aktivitas yang tercatat.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Status, Payment & Mechanic Assignment (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Progress & Mechanic Card -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Status Workshop &amp; Mekanik
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Status Pengerjaan:</span>
                        <div>{!! $booking->status_badge !!}</div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center">
                            <span class="text-neutral-400">Progress Pengerjaan:</span>
                            <span class="font-mono text-white font-bold">{{ $booking->progress_percentage }}%</span>
                        </div>
                        <div class="w-full h-2 bg-neutral-950 rounded overflow-hidden">
                            <div class="h-full bg-accent transition-all duration-500" style="width: {{ $booking->progress_percentage }}%"></div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-1 border-t border-neutral-800">
                        <span class="text-neutral-400">Mekanik Penanggung Jawab:</span>
                        @if($booking->mechanic)
                            <span class="font-bold text-accent">{{ $booking->mechanic->name }}</span>
                        @else
                            <span class="text-neutral-500 italic">Belum Ditugaskan</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white border-b border-neutral-800 pb-3">
                    Informasi Pembayaran &amp; Tagihan
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Status Pembayaran:</span>
                        <div>{!! $booking->payment_badge !!}</div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Estimasi Total Biaya:</span>
                        <span class="font-bold text-white text-sm">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Ketentuan DP Wajib:</span>
                        <span class="font-semibold text-neutral-300">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center border-t border-neutral-800 pt-2">
                        <span class="text-neutral-400">Total Terbayar:</span>
                        <span class="font-bold text-emerald-400">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-neutral-400">Sisa Pelunasan:</span>
                        @php $sisa = max(0, $booking->total_amount - $booking->paid_amount); @endphp
                        <span class="font-bold {{ $sisa > 0 ? 'text-amber-400' : 'text-emerald-400' }}">
                            {{ $sisa > 0 ? 'Rp ' . number_format($sisa, 0, ',', '.') : 'Lunas Penuh' }}
                        </span>
                    </div>

                    @php $latestPayment = $booking->payments->last(); @endphp
                    @if($latestPayment)
                        <div class="pt-3 border-t border-neutral-800 space-y-1.5 text-[11px]">
                            <div class="font-bold text-neutral-400 uppercase text-[10px]">Transaksi Gateway Terkini:</div>
                            <div class="flex justify-between text-neutral-400">
                                <span>No. Transaksi:</span>
                                <span class="font-mono text-white">{{ $latestPayment->transaction_code }}</span>
                            </div>
                            <div class="flex justify-between text-neutral-400">
                                <span>Metode Pembayaran:</span>
                                <span class="uppercase text-white">{{ $latestPayment->payment_method }}</span>
                            </div>
                            <div class="flex justify-between text-neutral-400">
                                <span>Waktu Bayar:</span>
                                <span class="text-white">{{ $latestPayment->paid_at ? $latestPayment->paid_at->format('d M Y, H:i') : ($latestPayment->created_at->format('d M Y, H:i')) }} WIB</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SECTION: HANDOVER / PENGAMBILAN & PENGANTARAN KENDARAAN (ADMIN NOTICE) -->
            <div class="bg-neutral-900 border {{ $booking->status === 'completed' ? 'border-accent ring-1 ring-accent/30' : 'border-neutral-800' }} p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $booking->status === 'completed' ? 'bg-emerald-400 animate-pulse' : 'bg-neutral-600' }}"></span>
                        <h3 class="text-xs uppercase tracking-widest font-bold text-white">
                            Metode Penyerahan Unit Kendaraan
                        </h3>
                    </div>
                    @if($booking->status === 'completed')
                        <span class="text-[9px] uppercase font-bold px-2 py-0.5 bg-emerald-950 text-emerald-300 border border-emerald-800">
                            Unit Selesai
                        </span>
                    @endif
                </div>

                <div class="space-y-3 text-xs text-neutral-300">
                    @if($booking->status === 'completed')
                        @if($booking->delivery_method === 'delivery_address')
                            <div class="p-3 bg-purple-950/40 border border-purple-800/80 space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-base">🚚</span>
                                    <span class="font-bold text-white uppercase text-[11px] tracking-wider">DIANTAR KE ALAMAT CUSTOMER (DELIVERY / TOWING)</span>
                                </div>
                                <div class="pt-2 border-t border-purple-800/40 space-y-1 text-xs">
                                    <div class="text-[10px] uppercase font-semibold text-purple-300">Alamat Tujuan Pengiriman:</div>
                                    <div class="font-medium text-white bg-neutral-950 p-2.5 border border-purple-900/60 select-all leading-relaxed">
                                        {{ $booking->delivery_address ?: ($booking->customer->address ?? 'Alamat belum diinput oleh customer') }}
                                    </div>
                                    <div class="text-[10px] text-neutral-400 pt-1 flex justify-between">
                                        <span>Kontak Customer: <strong class="text-white">{{ $booking->customer_phone }}</strong></span>
                                        <span>Nama: <strong class="text-white">{{ $booking->customer_name }}</strong></span>
                                    </div>
                                </div>
                                @if($booking->delivery_notes)
                                    <div class="p-2 bg-neutral-950 text-[11px] text-neutral-300 border border-purple-900/40 italic">
                                        <span class="font-semibold text-purple-300 not-italic">Catatan Khusus:</span> {{ $booking->delivery_notes }}
                                    </div>
                                @endif
                            </div>
                        @elseif($booking->delivery_method === 'pickup_workshop')
                            <div class="p-3 bg-neutral-950 border border-neutral-700 space-y-1.5">
                                <div class="flex items-center gap-2 text-white font-bold uppercase text-[11px] tracking-wider">
                                    <span class="text-base">🏭</span>
                                    <span>DIAMBIL SENDIRI OLEH CUSTOMER DI WORKSHOP</span>
                                </div>
                                <p class="text-[11px] text-neutral-400">
                                    Customer / perwakilan akan datang langsung ke studio workshop BENGKEL untuk serah terima unit kendaraan.
                                </p>
                                @if($booking->delivery_notes)
                                    <div class="p-2 bg-neutral-900 text-[11px] text-neutral-300 border border-neutral-800 italic mt-1">
                                        <span class="font-semibold text-neutral-400 not-italic">Catatan:</span> {{ $booking->delivery_notes }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-3 bg-amber-950/50 border border-amber-700/60 text-amber-200 space-y-1">
                                <div class="font-bold flex items-center gap-1.5 text-[11px] uppercase">
                                    <span>⚠️</span>
                                    <span>Menunggu Pilihan Customer</span>
                                </div>
                                <p class="text-[11px] text-amber-300/80">
                                    Customer belum memilih metode pengambilan di portalnya. Anda dapat mengonfirmasi via WhatsApp ({{ $booking->customer_phone }}).
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="p-3 bg-neutral-950 border border-neutral-800 text-neutral-400 space-y-1 text-[11px]">
                            <div class="font-semibold text-neutral-300">Unit Masih Dalam Pengerjaan Workshop</div>
                            <p class="leading-relaxed">
                                Opsi penyerahan (diambil sendiri vs diantar ke alamat) akan diisi oleh customer begitu status pengerjaan telah diselesaikan (Completed 100%).
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
