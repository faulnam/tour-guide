@extends('layouts.karyawan')

@section('title', 'Absensi Kamera — Portal Karyawan')

@section('content')
<div class="space-y-8" x-data="{
    stream: null,
    cameraActive: false,
    cameraError: null,
    capturedImage: null,
    isProcessing: false,
    latitude: null,
    longitude: null,
    currentTime: '',
    currentDate: '',
    selectedModalImage: null,

    init() {
        this.updateClock();
        setInterval(() => this.updateClock(), 1000);
        this.getGeolocation();
        this.startCamera();
    },

    updateClock() {
        const now = new Date();
        this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
        this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
    },

    getGeolocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this.latitude = pos.coords.latitude;
                    this.longitude = pos.coords.longitude;
                },
                (err) => {
                    console.log('Geolocation not available:', err.message);
                }
            );
        }
    },

    async startCamera() {
        this.cameraError = null;
        try {
            const constraints = {
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    facingMode: 'user'
                },
                audio: false
            };
            this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            const video = this.$refs.videoElement;
            if (video) {
                video.srcObject = this.stream;
                video.play();
                this.cameraActive = true;
            }
        } catch (err) {
            console.error('Camera Access Error:', err);
            this.cameraActive = false;
            this.cameraError = 'Izin akses kamera diperlukan untuk melakukan absensi. Pastikan kamera diizinkan di browser Anda.';
        }
    },

    takeSnapshot() {
        const video = this.$refs.videoElement;
        const canvas = this.$refs.canvasElement;
        if (!video || !canvas) return null;

        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 480;
        const ctx = canvas.getContext('2d');
        
        // Draw frame
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Stamp watermark timestamp on the photo
        ctx.fillStyle = 'rgba(0, 0, 0, 0.6)';
        ctx.fillRect(10, canvas.height - 45, 320, 35);
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 12px monospace';
        ctx.fillText('APEX GARAGE • ' + this.currentTime + ' • ' + (this.latitude ? this.latitude.toFixed(4) + ',' + this.longitude.toFixed(4) : 'GPS OK'), 18, canvas.height - 22);

        this.capturedImage = canvas.toDataURL('image/jpeg', 0.85);
        return this.capturedImage;
    },

    submitCheckIn() {
        const photo = this.takeSnapshot();
        if (!photo) {
            alert('Gagal mengambil gambar kamera. Silakan pastikan kamera aktif.');
            return;
        }

        this.isProcessing = true;
        fetch('{{ route('karyawan.absensi.checkin') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                image_data: photo,
                latitude: this.latitude,
                longitude: this.longitude,
                notes: this.$refs.checkinNotes?.value || ''
            })
        })
        .then(res => res.json())
        .then(data => {
            this.isProcessing = false;
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Gagal memproses absensi.');
            }
        })
        .catch(err => {
            this.isProcessing = false;
            alert('Terjadi kesalahan saat mengunggah foto absensi.');
        });
    },

    submitCheckOut() {
        const photo = this.takeSnapshot();
        if (!photo) {
            alert('Gagal mengambil gambar kamera. Silakan pastikan kamera aktif.');
            return;
        }

        this.isProcessing = true;
        fetch('{{ route('karyawan.absensi.checkout') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                image_data: photo,
                latitude: this.latitude,
                longitude: this.longitude,
                work_summary: this.$refs.workSummary?.value || ''
            })
        })
        .then(res => res.json())
        .then(data => {
            this.isProcessing = false;
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Gagal memproses absensi pulang.');
            }
        })
        .catch(err => {
            this.isProcessing = false;
            alert('Terjadi kesalahan saat mengunggah foto absensi pulang.');
        });
    }
}">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase bg-amber-500/20 text-amber-400 border border-amber-500/30">
                <i class="fa-solid fa-camera"></i>
                <span>Sistem Absensi Real-Time Kamera</span>
            </div>
            <h1 class="font-racing font-black text-2xl sm:text-3xl text-white uppercase tracking-tight mt-1">
                PRESENSI HARIAN DENGAN WEBCAM
            </h1>
        </div>

        <!-- Digital WIB Clock Box -->
        <div class="bg-[#121218] border border-neutral-800 px-5 py-3 rounded-2xl text-right">
            <div class="text-[10px] text-neutral-400 uppercase font-bold" x-text="currentDate"></div>
            <div class="font-racing font-black text-xl text-amber-400 tracking-wider" x-text="currentTime"></div>
        </div>
    </div>

    <!-- Main Attendance Grid (Camera Viewfinder + Actions) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Live Camera Viewfinder (7 Cols) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 shadow-2xl space-y-4 glow-amber">
                
                <div class="flex items-center justify-between">
                    <div class="text-xs font-bold text-neutral-300 uppercase tracking-wider font-racing flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                        <span>LIVE WEBCAM VIEW</span>
                    </div>
                    <div class="text-[10px] text-neutral-400 font-mono">
                        GPS: <span x-text="latitude ? latitude.toFixed(4) + ', ' + longitude.toFixed(4) : 'Mendeteksi...'"></span>
                    </div>
                </div>

                <!-- Viewfinder Container -->
                <div class="relative bg-black rounded-2xl overflow-hidden aspect-[4/3] flex items-center justify-center border-2 border-neutral-800 group">
                    
                    <!-- Video Stream -->
                    <video x-ref="videoElement" autoplay playsinline muted class="w-full h-full object-cover transform -scale-x-100"></video>
                    <canvas x-ref="canvasElement" class="hidden"></canvas>

                    <!-- Reticle / Face Guide Overlay -->
                    <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                        <div class="w-56 h-64 border-2 border-dashed border-amber-400/60 rounded-full flex items-center justify-center">
                            <span class="text-[10px] text-amber-300 bg-black/60 px-2 py-0.5 rounded font-mono">Posisikan Wajah</span>
                        </div>
                    </div>

                    <!-- Camera Error Fallback -->
                    <div x-show="!cameraActive" class="absolute inset-0 bg-neutral-950/90 flex flex-col items-center justify-center p-6 text-center space-y-3" x-cloak>
                        <i class="fa-solid fa-camera-slash text-4xl text-neutral-600"></i>
                        <p class="text-xs text-neutral-400 max-w-sm" x-text="cameraError || 'Mengaktifkan kamera...'"></p>
                        <button type="button" @click="startCamera()" class="px-4 py-2 bg-amber-600 text-black text-xs font-bold rounded-xl">
                            Coba Aktifkan Kamera Lagi
                        </button>
                    </div>

                    <!-- Live Timestamp Overlay -->
                    <div class="absolute bottom-3 left-3 bg-black/75 backdrop-blur-md px-3 py-1.5 rounded-lg text-[11px] font-mono text-white flex items-center gap-2 border border-neutral-800">
                        <i class="fa-solid fa-clock text-amber-400"></i>
                        <span x-text="currentTime"></span>
                    </div>
                </div>

                <div class="text-[11px] text-neutral-500 text-center">
                    *Pastikan pencahayaan cukup dan wajah terlihat jelas pada reticle kamera saat menekan tombol absensi.
                </div>

            </div>
        </div>

        <!-- Right: Check-in / Check-out Panel & Status (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Status Hari Ini Card -->
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 shadow-2xl space-y-4">
                <h3 class="font-racing font-bold text-base text-white uppercase">STATUS HARI INI</h3>
                
                @if(!$todayAttendance || !$todayAttendance->check_in_time)
                    <!-- Belum Check-in -->
                    <div class="p-4 bg-amber-500/10 border border-amber-500/30 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2.5 text-xs font-bold text-amber-400">
                            <i class="fa-solid fa-door-open text-base"></i>
                            <span>Belum Melakukan Absensi Masuk</span>
                        </div>
                        <p class="text-xs text-neutral-300">
                            Jam kerja standar dimulai pukul <strong class="text-white">08:30 WIB</strong>. Ambil foto selfie untuk konfirmasi kehadiran shift Anda.
                        </p>

                        <div>
                            <label class="block text-[10px] font-bold uppercase text-neutral-400 mb-1">Catatan Kehadiran (Opsional):</label>
                            <input type="text" x-ref="checkinNotes" placeholder="Misal: Hadir tepat waktu, siap tugas tune-up"
                                   class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white placeholder-neutral-500 focus:outline-none">
                        </div>

                        <button type="button" @click="submitCheckIn()" :disabled="isProcessing"
                                class="w-full py-4 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 disabled:opacity-50 text-black font-racing font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-amber-600/30 transition-all flex items-center justify-center gap-2 hover:scale-[1.02]">
                            <i class="fa-solid fa-camera text-sm"></i>
                            <span x-text="isProcessing ? 'Menyimpan Foto...' : 'AMBIL FOTO MASUK (CHECK-IN)'"></span>
                        </button>
                    </div>

                @elseif(!$todayAttendance->check_out_time)
                    <!-- Sudah Check-in, Belum Check-out -->
                    <div class="space-y-4">
                        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl flex items-center justify-between">
                            <div>
                                <div class="text-[10px] text-neutral-400 uppercase font-bold">Jam Masuk Tercatat</div>
                                <div class="text-sm font-bold text-emerald-400 font-mono">{{ $todayAttendance->check_in_time }} WIB</div>
                                <div class="mt-1">{!! $todayAttendance->status_badge !!}</div>
                            </div>
                            @if($todayAttendance->check_in_photo)
                                <div class="w-14 h-14 rounded-xl overflow-hidden border border-neutral-700 cursor-pointer"
                                     @click="selectedModalImage = '{{ $todayAttendance->check_in_photo_url }}'">
                                    <img src="{{ $todayAttendance->check_in_photo_url }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                        </div>

                        <!-- Form Check-out -->
                        <div class="p-4 bg-red-600/10 border border-red-500/30 rounded-2xl space-y-3">
                            <div class="flex items-center gap-2 text-xs font-bold text-red-400">
                                <i class="fa-solid fa-door-closed text-base"></i>
                                <span>Absensi Pulang (Check-Out)</span>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase text-neutral-400 mb-1">Ringkasan Pekerjaan Hari Ini (Summary Log):</label>
                                <textarea x-ref="workSummary" rows="3" placeholder="Tuliskan pekerjaan yang selesai hari ini (misal: Selesai remap Civic FL5, setting klep CB750)..."
                                          class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3 py-2 text-xs text-white placeholder-neutral-500 focus:outline-none"></textarea>
                            </div>

                            <button type="button" @click="submitCheckOut()" :disabled="isProcessing"
                                    class="w-full py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 disabled:opacity-50 text-white font-racing font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-red-600/30 transition-all flex items-center justify-center gap-2 hover:scale-[1.02]">
                                <i class="fa-solid fa-camera text-sm"></i>
                                <span x-text="isProcessing ? 'Menyimpan Foto...' : 'AMBIL FOTO PULANG (CHECK-OUT)'"></span>
                            </button>
                        </div>
                    </div>

                @else
                    <!-- Lengkap Masuk & Pulang -->
                    <div class="p-5 bg-emerald-950/40 border border-emerald-500/40 rounded-2xl text-center space-y-3">
                        <div class="w-12 h-12 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto text-xl">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="font-bold text-sm text-white">Presensi Hari Ini Selesai</div>
                        <div class="grid grid-cols-2 gap-2 text-xs text-neutral-300 font-mono pt-2 border-t border-neutral-800">
                            <div>Masuk: {{ $todayAttendance->check_in_time }}</div>
                            <div>Pulang: {{ $todayAttendance->check_out_time }}</div>
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>

    <!-- Monthly Attendance History Table -->
    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-racing font-bold text-lg text-white">RIWAYAT ABSENSI KAMERA SAYA</h3>
                <p class="text-xs text-neutral-400">Daftar kehadiran dan bukti foto snapshot Anda:</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#0a0a0e] text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5">Foto Masuk</th>
                        <th class="p-3.5">Jam Masuk</th>
                        <th class="p-3.5">Foto Pulang</th>
                        <th class="p-3.5">Jam Pulang</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5">Ringkasan Kerja</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($attendances as $att)
                        <tr class="hover:bg-neutral-900/50 transition-colors">
                            <td class="p-3.5 font-bold text-white">
                                {{ \Carbon\Carbon::parse($att->date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="p-3.5">
                                @if($att->check_in_photo)
                                    <button type="button" @click="selectedModalImage = '{{ $att->check_in_photo_url }}'" class="w-10 h-10 rounded-lg overflow-hidden border border-neutral-700 hover:scale-110 transition-transform">
                                        <img src="{{ $att->check_in_photo_url }}" class="w-full h-full object-cover">
                                    </button>
                                @else
                                    <span class="text-neutral-500">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $att->check_in_time ? substr($att->check_in_time, 0, 5) . ' WIB' : '-' }}
                            </td>
                            <td class="p-3.5">
                                @if($att->check_out_photo)
                                    <button type="button" @click="selectedModalImage = '{{ $att->check_out_photo_url }}'" class="w-10 h-10 rounded-lg overflow-hidden border border-neutral-700 hover:scale-110 transition-transform">
                                        <img src="{{ $att->check_out_photo_url }}" class="w-full h-full object-cover">
                                    </button>
                                @else
                                    <span class="text-neutral-500">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $att->check_out_time ? substr($att->check_out_time, 0, 5) . ' WIB' : '-' }}
                            </td>
                            <td class="p-3.5">
                                {!! $att->status_badge !!}
                            </td>
                            <td class="p-3.5 text-neutral-400 max-w-xs truncate">
                                {{ $att->work_summary ?? $att->notes ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-neutral-500">
                                Belum ada riwayat absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $attendances->links() }}
        </div>
    </div>

    <!-- Photo Preview Modal -->
    <div x-show="selectedModalImage" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         x-cloak
         class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md flex items-center justify-center p-4"
         @click.self="selectedModalImage = null">
        <div class="bg-[#121218] border border-neutral-700 rounded-3xl p-4 max-w-md w-full shadow-2xl relative space-y-3">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-2">
                <span class="text-xs font-bold uppercase font-racing text-amber-400">Bukti Foto Snapshot Absensi</span>
                <button @click="selectedModalImage = null" class="text-neutral-400 hover:text-white text-base">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="rounded-2xl overflow-hidden bg-black aspect-[4/3]">
                <img :src="selectedModalImage" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

</div>
@endsection
