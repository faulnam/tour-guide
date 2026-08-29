@extends('layouts.customer')

@section('meta_title', 'Akun Traveler — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))

@section('content')

    <!-- Top Banner / Breadcrumb -->
    <section class="bg-neutral-900 text-white pt-32 pb-14 border-b border-neutral-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                <div class="space-y-2">
                    <div class="flex items-center space-x-2 text-xs uppercase tracking-widest text-neutral-400">
                        <span>Portal Customer</span>
                        <span>&bull;</span>
                        <span class="text-accent font-semibold">Profil & Layanan</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-wider uppercase font-sans">
                        {{ $user->name }}
                    </h1>
                    <p class="text-xs text-neutral-400">
                        Member sejak {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }} &bull; {{ $user->email }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/booking') }}" class="px-4 py-2.5 bg-accent text-white text-xs uppercase tracking-wider font-bold hover:bg-opacity-90 transition-all">
                        + Buat Booking Baru
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Customer Hub Section -->
    <section class="py-12 bg-neutral-bg min-h-[75vh]" x-data="{ 
        tab: '{{ request('tab', $activeTab ?? 'identity') }}',
        switchTab(newTab) {
            this.tab = newTab;
            const url = new URL(window.location);
            url.searchParams.set('tab', newTab);
            window.history.pushState({}, '', url);
        }
    }">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Summary Stats Bar -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white border border-neutral-200 p-5 space-y-1">
                    <div class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Total Booking</div>
                    <div class="text-2xl font-extrabold text-black font-sans">{{ $allBookingsCount }}</div>
                    <div class="text-[10px] text-neutral-500">Semua pesanan</div>
                </div>

                <div class="bg-white border border-neutral-200 p-5 space-y-1">
                    <div class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Pesanan Aktif</div>
                    <div class="text-2xl font-extrabold text-black font-sans">{{ $activeBookings->count() }}</div>
                    <div class="text-[10px] text-neutral-500">Dalam proses pengerjaan</div>
                </div>

                <div class="bg-white border border-neutral-200 p-5 space-y-1">
                    <div class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Garansi Aktif</div>
                    <div class="text-2xl font-extrabold text-black font-sans">
                        {{ $warrantyBookings->filter->is_warranty_active->count() }}
                    </div>
                    <div class="text-[10px] text-neutral-500">Klaim siap dilayani</div>
                </div>

                <div class="bg-white border border-neutral-200 p-5 space-y-1">
                    <div class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Kendaraan Garasi</div>
                    <div class="text-2xl font-extrabold text-black font-sans">{{ $vehicles->count() }}</div>
                    <div class="text-[10px] text-neutral-500">Mobil & Motor terdaftar</div>
                </div>
            </div>

            <!-- Tab Navigation Header -->
            <div class="bg-white border border-neutral-200 mb-8 overflow-x-auto">
                <div class="flex border-b border-neutral-200 text-xs uppercase tracking-wider font-bold min-w-max">
                    <button type="button" @click="switchTab('identity')"
                            class="py-4 px-6 md:px-8 transition-all flex items-center space-x-2 border-b-2"
                            :class="tab === 'identity' ? 'border-black text-black bg-neutral-50' : 'border-transparent text-neutral-500 hover:text-black'">
                        <span>Jatidiri (Data Diri)</span>
                    </button>

                    <button type="button" @click="switchTab('orders')"
                            class="py-4 px-6 md:px-8 transition-all flex items-center space-x-2 border-b-2"
                            :class="tab === 'orders' ? 'border-black text-black bg-neutral-50' : 'border-transparent text-neutral-500 hover:text-black'">
                        <span>Informasi Pesanan</span>
                        @if($activeBookings->count())
                            <span class="px-2 py-0.5 text-[10px] bg-black text-white rounded-full font-sans">
                                {{ $activeBookings->count() }}
                            </span>
                        @endif
                    </button>

                    <button type="button" @click="switchTab('warranty')"
                            class="py-4 px-6 md:px-8 transition-all flex items-center space-x-2 border-b-2"
                            :class="tab === 'warranty' ? 'border-black text-black bg-neutral-50' : 'border-transparent text-neutral-500 hover:text-black'">
                        <span>Cek Garansi</span>
                        @if($warrantyBookings->filter->is_warranty_active->count())
                            <span class="px-2 py-0.5 text-[10px] bg-black text-white rounded-full font-sans">
                                {{ $warrantyBookings->filter->is_warranty_active->count() }}
                            </span>
                        @endif
                    </button>
                </div>
            </div>

            <!-- TAB 1: JATIDIRI (DATA DIRI) -->
            <div x-show="tab === 'identity'" x-cloak class="space-y-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Identity Overview Card -->
                    <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
                        <div class="flex items-center space-x-4 pb-6 border-b border-neutral-200">
                            <div class="w-16 h-16 rounded-none bg-black text-white flex items-center justify-center text-xl font-bold font-sans">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-base text-black uppercase tracking-wider">{{ $user->name }}</h3>
                                <p class="text-xs text-neutral-500">{{ $user->email }}</p>
                                <span class="inline-block mt-1 px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] uppercase font-bold tracking-wider">
                                    Customer Terverifikasi
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between py-1.5 border-b border-neutral-100">
                                <span class="text-neutral-500">Nomor WhatsApp:</span>
                                <span class="font-semibold text-black">{{ $user->phone ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-neutral-100">
                                <span class="text-neutral-500">Role Akun:</span>
                                <span class="font-semibold text-black uppercase">Customer</span>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-neutral-100">
                                <span class="text-neutral-500">Bergabung:</span>
                                <span class="font-semibold text-black">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="py-1.5 space-y-1">
                                <span class="text-neutral-500 block">Alamat Domisili:</span>
                                <p class="text-neutral-800 font-medium bg-neutral-50 p-2.5 border border-neutral-200">
                                    {{ $user->address ?? 'Belum ada alamat domisili yang disimpan.' }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-neutral-200">
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-center py-2.5 border border-red-200 text-red-600 hover:bg-red-50 text-xs uppercase tracking-wider font-bold transition-colors">
                                    Keluar dari Akun
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Edit Profile & Password Forms -->
                    <div class="lg:col-span-2 space-y-8">
                        
                        <!-- Update Profile Info Form -->
                        <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
                            <div class="border-b border-neutral-200 pb-3">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-black">Perbarui Data Diri (Jatidiri)</h3>
                                <p class="text-xs text-neutral-400">Pastikan nomor telepon WhatsApp aktif untuk konfirmasi jadwal dan update pengerjaan.</p>
                            </div>

                            <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Nama Lengkap *</label>
                                        <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black">
                                        @error('name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">No. WhatsApp / HP *</label>
                                        <input type="text" name="phone" required value="{{ old('phone', $user->phone) }}"
                                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black">
                                        @error('phone') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Alamat Email *</label>
                                    <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                                           class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black">
                                    @error('email') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Alamat Domisili Lengkap</label>
                                    <textarea name="address" rows="3" placeholder="Jalan, No. Rumah, Kota, Kode Pos"
                                              class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black">{{ old('address', $user->address) }}</textarea>
                                    @error('address') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="px-6 py-3 bg-black text-white text-xs uppercase tracking-wider font-bold hover:bg-neutral-800 transition-colors">
                                        Simpan Perubahan Data Diri &rarr;
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Update Password Form -->
                        <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
                            <div class="border-b border-neutral-200 pb-3">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-black">Ganti Kata Sandi</h3>
                                <p class="text-xs text-neutral-400">Gunakan kombinasi minimal 6 karakter untuk keamanan akun Anda.</p>
                            </div>

                            <form action="{{ route('customer.password.update') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Kata Sandi Saat Ini *</label>
                                    <input type="password" name="current_password" required
                                           class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black">
                                    @error('current_password') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Kata Sandi Baru *</label>
                                        <input type="password" name="password" required placeholder="Min. 6 karakter"
                                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black">
                                        @error('password') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Ulangi Kata Sandi Baru *</label>
                                        <input type="password" name="password_confirmation" required placeholder="Konfirmasi sandi"
                                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black">
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="px-6 py-3 bg-neutral-900 text-white text-xs uppercase tracking-wider font-bold hover:bg-black transition-colors">
                                        Perbarui Kata Sandi &rarr;
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

            <!-- TAB 2: INFORMASI PESANAN (BOOKINGS & SERVICE TRACKING) -->
            <div x-show="tab === 'orders'" x-cloak class="space-y-8">
                
                <!-- Section Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-neutral-200 p-6">
                    <div>
                        <h2 class="text-base font-bold uppercase tracking-wider text-black">Live Tracking & Riwayat Pesanan</h2>
                        <p class="text-xs text-neutral-500">Pantau proses pengerjaan modifikasi dan servis kendaraan Anda secara transparan.</p>
                    </div>
                    <a href="{{ url('/booking') }}" class="inline-flex items-center px-4 py-2 bg-black text-white text-xs uppercase tracking-wider font-bold hover:bg-neutral-800 transition-colors">
                        + Tambah Booking
                    </a>
                </div>

                <!-- 1. Active Bookings (Sedang Berjalan) -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 text-xs uppercase tracking-widest font-bold text-black">
                        <span class="w-2 h-2 bg-black inline-block"></span>
                        <span>Pesanan Sedang Diproses ({{ $activeBookings->count() }})</span>
                    </div>

                    @forelse($activeBookings as $booking)
                        <div class="bg-white border border-neutral-200 p-6 md:p-8 space-y-6 shadow-sm">
                            
                            <!-- Top Header: Booking Code & Status -->
                            <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-neutral-200">
                                <div>
                                    <div class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Nomor Booking</div>
                                    <div class="text-lg font-bold text-black font-sans tracking-wider">{{ $booking->booking_code }}</div>
                                    <div class="text-xs text-neutral-500">
                                        Jadwal: <strong>{{ $booking->booking_date ? $booking->booking_date->translatedFormat('d F Y') : '-' }}</strong> &bull; Sesi: {{ $booking->booking_time_slot }}
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-2">
                                    {!! $booking->status_badge !!}
                                    {!! $booking->payment_badge !!}
                                </div>
                            </div>

                            <!-- Vehicle & Service Summary -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-neutral-50 p-4 border border-neutral-200 text-xs">
                                <div>
                                    <span class="text-neutral-500 block text-[10px] uppercase tracking-wider font-semibold">Kendaraan:</span>
                                    <span class="font-bold text-black text-sm">{{ $booking->vehicle_brand }} {{ $booking->vehicle_model }}</span>
                                    <div class="text-neutral-600 mt-0.5">
                                        Plat: <span class="font-mono font-bold">{{ $booking->license_plate }}</span> ({{ $booking->vehicle_type_label }})
                                    </div>
                                </div>

                                <div>
                                    <span class="text-neutral-500 block text-[10px] uppercase tracking-wider font-semibold">Paket Layanan:</span>
                                    <span class="font-bold text-black text-sm">{{ $booking->service ? $booking->service->title : 'Custom Tuning & Service' }}</span>
                                    <div class="text-neutral-600 mt-0.5">
                                        Mekanik: <strong>{{ $booking->mechanic ? $booking->mechanic->name : 'Dalam Penugasan Tim' }}</strong>
                                    </div>
                                </div>

                                <div>
                                    <span class="text-neutral-500 block text-[10px] uppercase tracking-wider font-semibold">Estimasi Total Biaya:</span>
                                    <span class="font-bold text-black text-sm">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                    <div class="text-neutral-600 mt-0.5">
                                        Terbayar: <strong>Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</strong>
                                        @if($booking->remaining_amount > 0)
                                            &bull; Sisa: <strong class="text-black">Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</strong>
                                        @else
                                            &bull; <strong class="text-black">Lunas</strong>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Live Progress Bar (0-100%) -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold uppercase tracking-wider text-black">Progress Pengerjaan:</span>
                                    <span class="font-bold text-black font-sans text-sm">{{ $booking->progress_percentage }}%</span>
                                </div>
                                <div class="w-full h-3 bg-neutral-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-neutral-900 via-neutral-700 to-accent transition-all duration-500"
                                         style="width: {{ $booking->progress_percentage }}%"></div>
                                </div>
                                <div class="flex justify-between text-[10px] text-neutral-400 uppercase tracking-widest pt-1">
                                    <span>Penerimaan</span>
                                    <span>Bongkar / Fabrikasi</span>
                                    <span>Tuning & Dyno</span>
                                    <span>Quality Control</span>
                                    <span>Selesai</span>
                                </div>
                            </div>

                            <!-- Tour Guide Update Note -->
                            @if($booking->mechanic_notes)
                                <div class="p-4 bg-[#F8FAF9] rounded-xl border border-gray-100 text-xs space-y-1">
                                    <div class="font-bold text-primary uppercase tracking-wider text-[10px]">Catatan Lapangan dari Pemandu:</div>
                                    <p class="text-gray-700">{{ $booking->mechanic_notes }}</p>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap items-center justify-between gap-4 pt-2 border-t border-gray-100">
                                <div class="text-xs text-gray-500">
                                    Permintaan khusus: <span class="italic text-primary">{{ $booking->custom_request ?? 'Tidak ada catatan tambahan' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('contact_whatsapp', '081288889999')) }}?text={{ urlencode('Halo ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') . ', saya ingin konsultasi status booking ' . $booking->booking_code . ' destinasi ' . $booking->vehicle_brand) }}"
                                       target="_blank"
                                       class="px-3.5 py-2 bg-primary text-white rounded-lg text-xs uppercase tracking-wider font-bold hover:bg-secondary transition-colors flex items-center gap-1.5 shadow-sm">
                                        <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                                        <span>Chat Support</span>
                                    </a>
                                    <a href="{{ route('booking.checkout', $booking->booking_code) }}"
                                       class="px-3.5 py-2 rounded-lg border border-accent bg-accent text-neutral-dark text-xs uppercase tracking-wider font-bold hover:bg-accent-dark hover:text-white transition-all shadow-sm">
                                        @if($booking->status === 'completed' && $booking->remaining_amount > 0)
                                            Pelunasan &amp; Selesai &rarr;
                                        @elseif($booking->status === 'completed')
                                            Invoice &amp; Travel Pass &rarr;
                                        @else
                                            Detail &amp; Travel Pass &rarr;
                                        @endif
                                    </a>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center space-y-3 shadow-soft">
                            <div class="text-3xl text-sage"><i class="fa-solid fa-compass"></i></div>
                            <h4 class="text-sm font-bold uppercase tracking-wider text-primary">Tidak Ada Jadwal Trip Aktif Saat Ini</h4>
                            <p class="text-xs text-gray-500 max-w-md mx-auto">
                                Anda belum memiliki agenda tur yang sedang berlangsung. Rencanakan liburan impian Anda bersama pemandu lokal berlisensi resmi Nusantara Tour Guide.
                            </p>
                            <a href="{{ url('/booking') }}" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md inline-flex items-center gap-2">
                                <i class="fa-solid fa-calendar-check text-xs text-accent"></i>
                                <span>Booking Pemandu Sekarang &rarr;</span>
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- 2. Completed / Past Bookings (Riwayat Selesai) -->
                <div class="space-y-4 pt-6">
                    <div class="text-xs uppercase tracking-widest font-bold text-neutral-500">
                        Riwayat Pengerjaan Selesai & Sebelumnya ({{ $historyBookings->total() }})
                    </div>

                    @if($historyBookings->count())
                        <div class="bg-white border border-neutral-200 overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="bg-neutral-50 border-b border-neutral-200 text-[10px] uppercase tracking-wider text-neutral-500">
                                        <th class="p-4">Kode Booking</th>
                                        <th class="p-4">Kendaraan</th>
                                        <th class="p-4">Layanan</th>
                                        <th class="p-4">Tanggal</th>
                                        <th class="p-4">Status</th>
                                        <th class="p-4">Garansi</th>
                                        <th class="p-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-100">
                                    @foreach($historyBookings as $history)
                                        <tr class="hover:bg-neutral-50 transition-colors">
                                            <td class="p-4 font-mono font-bold text-black">{{ $history->booking_code }}</td>
                                            <td class="p-4">
                                                <div class="font-semibold text-black">{{ $history->vehicle_brand }} {{ $history->vehicle_model }}</div>
                                                <div class="text-[10px] text-neutral-400 font-mono">{{ $history->license_plate }}</div>
                                            </td>
                                            <td class="p-4 text-neutral-700">{{ $history->service ? $history->service->title : 'Custom Modification' }}</td>
                                            <td class="p-4 text-neutral-500">{{ $history->booking_date ? $history->booking_date->format('d/m/Y') : '-' }}</td>
                                            <td class="p-4">{!! $history->status_badge !!}</td>
                                            <td class="p-4">{!! $history->warranty_status_badge !!}</td>
                                            <td class="p-4 text-right">
                                                <a href="{{ route('booking.checkout', $history->booking_code) }}" class="px-3 py-1 bg-neutral-100 hover:bg-black hover:text-white text-black font-semibold text-[10px] uppercase tracking-wider transition-colors">
                                                    Invoice
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pt-2">
                            {{ $historyBookings->appends(['tab' => 'orders'])->links() }}
                        </div>
                    @else
                        <div class="p-6 bg-white border border-neutral-200 text-center text-xs text-neutral-400">
                            Belum ada riwayat pesanan selesai sebelumnya.
                        </div>
                    @endif
                </div>

            </div>

            <!-- TAB 3: CEK GARANSI (WARRANTY STATUS & LOOKUP) -->
            <div x-show="tab === 'warranty'" x-cloak class="space-y-8">
                
                <!-- Quick Warranty Search Card -->
                <div class="bg-black text-white p-6 md:p-8 space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <span class="text-accent text-[10px] uppercase tracking-widest font-bold">Verifikasi & Klaim Instan</span>
                            <h2 class="text-xl font-bold uppercase tracking-wider font-sans">Cek Status Garansi Pengerjaan</h2>
                            <p class="text-xs text-neutral-400">Masukkan Kode Booking (misal: BK-202608-0001) atau Nomor Plat Kendaraan Anda.</p>
                        </div>
                        <form action="{{ route('warranty.check') }}" method="POST" class="flex w-full md:w-auto gap-2">
                            @csrf
                            <input type="text" name="code" required value="{{ request('warranty_code', old('code')) }}" placeholder="Kode Booking / Plat Nomor"
                                   class="bg-neutral-900 border border-neutral-700 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-accent uppercase min-w-[220px]">
                            <button type="submit" class="px-5 py-2.5 bg-accent text-white text-xs uppercase tracking-wider font-bold hover:bg-opacity-90 transition-all shrink-0">
                                Cari Garansi &rarr;
                            </button>
                        </form>
                    </div>
                </div>

                <!-- If Warranty Search Result is Shown -->
                @if(isset($warrantySearchResult) && $warrantySearchResult)
                    <div class="bg-emerald-50 border-2 border-emerald-400 p-6 md:p-8 space-y-4">
                        <div class="flex items-center justify-between border-b border-emerald-200 pb-3">
                            <div class="flex items-center space-x-2">
                                <span class="text-xl">🛡️</span>
                                <h3 class="text-sm font-bold uppercase tracking-wider text-emerald-900">Hasil Pencarian Garansi: {{ $warrantySearchResult->booking_code }}</h3>
                            </div>
                            {!! $warrantySearchResult->warranty_status_badge !!}
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                            <div>
                                <span class="text-emerald-700 block text-[10px] uppercase tracking-wider">Kendaraan:</span>
                                <strong class="text-emerald-950 text-sm">{{ $warrantySearchResult->vehicle_brand }} {{ $warrantySearchResult->vehicle_model }}</strong>
                                <div class="font-mono text-emerald-800">{{ $warrantySearchResult->license_plate }}</div>
                            </div>
                            <div>
                                <span class="text-emerald-700 block text-[10px] uppercase tracking-wider">Layanan Terpasang:</span>
                                <strong class="text-emerald-950">{{ $warrantySearchResult->service ? $warrantySearchResult->service->title : 'Custom Modification' }}</strong>
                            </div>
                            <div>
                                <span class="text-emerald-700 block text-[10px] uppercase tracking-wider">Masa Garansi:</span>
                                <strong class="text-emerald-950">{{ $warrantySearchResult->warranty_days }} Hari</strong>
                                <div class="text-[10px] text-emerald-800">
                                    Berlaku s/d: {{ $warrantySearchResult->warranty_end_date ? $warrantySearchResult->warranty_end_date->translatedFormat('d F Y') : '-' }}
                                </div>
                            </div>
                            <div class="flex items-center md:justify-end">
                                @if($warrantySearchResult->is_warranty_active)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('contact_whatsapp', '081288889999')) }}?text={{ urlencode('Halo ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') . ', saya ingin konsultasi bantuan voucher/asuransi untuk Booking ' . $warrantySearchResult->booking_code . ' destinasi ' . $warrantySearchResult->vehicle_brand) }}"
                                       target="_blank"
                                       class="px-4 py-2 bg-primary text-white rounded-lg text-xs uppercase tracking-wider font-bold hover:bg-secondary transition-colors shadow-sm">
                                        Bantuan Layanan (WA) &rarr;
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs italic">Voucher / proteksi sudah kedaluwarsa</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Active Warranty Cards for Current Customer -->
                <div class="space-y-4">
                    <div class="text-xs uppercase tracking-wider font-bold text-primary">
                        Daftar Jaminan Layanan &amp; Voucher Trip Anda ({{ $warrantyBookings->count() }})
                    </div>

                    @forelse($warrantyBookings as $wb)
                        <div class="tour-card p-6 md:p-8 space-y-6 shadow-soft bg-white">
                            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-4">
                                <div>
                                    <div class="text-[10px] uppercase tracking-wider text-gray-400 font-bold">Nomor Reservasi / Voucher</div>
                                    <div class="text-lg font-bold font-mono text-primary">{{ $wb->booking_code }}</div>
                                    <div class="text-xs text-gray-500">
                                        Diselesaikan pada: {{ $wb->warranty_start_date ? $wb->warranty_start_date->translatedFormat('d F Y') : '-' }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    {!! $wb->warranty_status_badge !!}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase tracking-wider font-bold">Destinasi:</span>
                                    <span class="font-bold text-primary text-sm">{{ $wb->vehicle_brand }}</span>
                                    <div class="text-gray-500 font-mono">{{ $wb->vehicle_model }}</div>
                                </div>

                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase tracking-wider font-bold">Paket Pemandu Wisata:</span>
                                    <span class="font-bold text-primary text-sm">{{ $wb->service ? $wb->service->title : 'Private Guided Tour' }}</span>
                                    <div class="text-sage text-[11px] mt-0.5 font-semibold">Lisensi HPI / APGI</div>
                                </div>

                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase tracking-wider font-bold">Masa Berlaku Voucher:</span>
                                    <span class="font-bold text-primary text-sm">
                                        Hingga {{ $wb->warranty_end_date ? $wb->warranty_end_date->translatedFormat('d F Y') : '-' }}
                                    </span>
                                    @if($wb->is_warranty_active)
                                        <div class="text-emerald-700 font-bold text-[11px] mt-0.5">
                                            Aktif (Sisa {{ $wb->warranty_remaining_days }} hari)
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Warranty Coverage Terms -->
                            <div class="p-4 bg-[#F8FAF9] rounded-xl border border-gray-100 text-xs space-y-1.5">
                                <div class="font-bold uppercase tracking-wider text-[10px] text-primary">Cakupan Jaminan &amp; Proteksi Trip:</div>
                                <ul class="list-disc list-inside text-gray-600 text-[11px] space-y-0.5">
                                    <li>Jaminan pendampingan oleh pemandu bersertifikasi resmi HPI/APGI berwawasan budaya luas.</li>
                                    <li>Asuransi kecelakaan diri dan santunan medis darurat selama durasi pendampingan berlangsung.</li>
                                    <li>Reschedule voucher fleksibel tanpa penalti apabila destinasi ditutup karena faktor alam/cuaca.</li>
                                </ul>
                            </div>

                            <!-- Claim Button -->
                            <div class="flex flex-wrap items-center justify-between gap-4 pt-2 border-t border-gray-100">
                                <div class="text-xs text-gray-500">
                                    Pemandu utama: <strong>{{ $wb->guide ? $wb->guide->name : 'Pemandu Berlisensi HPI' }}</strong>
                                </div>

                                @if($wb->is_warranty_active)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('contact_whatsapp', '081288889999')) }}?text={{ urlencode('Halo ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') . ', saya ingin konsultasi voucher trip ' . $wb->booking_code . ' destinasi ' . $wb->vehicle_brand) }}"
                                       target="_blank"
                                       class="px-5 py-2.5 bg-primary text-white rounded-lg text-xs uppercase tracking-wider font-bold hover:bg-secondary transition-colors flex items-center gap-2 shadow-sm">
                                        <span>🛡️ Bantuan Layanan (WA) &rarr;</span>
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs uppercase font-semibold">Voucher Telah Digunakan</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center space-y-3 shadow-soft">
                            <div class="text-3xl text-sage"><i class="fa-solid fa-shield-halved"></i></div>
                            <h4 class="text-sm font-bold uppercase tracking-wider text-primary">Belum Ada Voucher Jaminan Aktif</h4>
                            <p class="text-xs text-gray-500 max-w-md mx-auto">
                                Jaminan proteksi &amp; sertifikat perjalanan resmi akan otomatis aktif setelah status trip Anda diselesaikan.
                            </p>
                        </div>
                    @endforelse
                </div>

            </div>

        </div>
    </section>

@endsection
