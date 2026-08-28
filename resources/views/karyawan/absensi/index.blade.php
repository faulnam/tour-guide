@extends('layouts.karyawan')

@section('meta_title', 'Absensi Kamera Live — BENGKEL')

@section('content')

    <div class="space-y-8" x-data="cameraAttendance()" x-init="initCamera()">
        
        <!-- Header Page -->
        <div class="border-b border-neutral-200 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="eyebrow text-accent font-semibold">Staff Time &amp; Attendance</div>
                <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tight text-black font-sans">
                    Sistem Absensi Kamera
                </h1>
            </div>
            <div class="text-xs text-neutral-500">
                Tanggal: <span class="font-bold text-black">{{ date('d F Y') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Live Camera Box (7 cols) -->
            <div class="lg:col-span-7 bg-white border border-neutral-200 p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-neutral-100 pb-3">
                    <div class="font-bold text-xs uppercase tracking-wider text-black flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full" :class="streamActive ? 'bg-emerald-500 animate-pulse' : 'bg-red-500'"></span>
                        <span>Viewfinder Kamera Webcam</span>
                    </div>
                    <button type="button" @click="initCamera()" class="text-[10px] uppercase tracking-widest text-neutral-500 hover:text-black font-semibold">
                        Restart Kamera
                    </button>
                </div>

                <!-- Video / Snapshot Viewport -->
                <div class="relative aspect-[4/3] bg-neutral-950 border border-neutral-300 overflow-hidden flex items-center justify-center">
                    
                    <!-- Live Video Stream -->
                    <video x-ref="videoElement" autoplay playsinline muted 
                           class="w-full h-full object-cover"
                           :class="snapshotData ? 'hidden' : 'block'"></video>

                    <!-- Snapshot Result Preview -->
                    <img x-show="snapshotData" :src="snapshotData" alt="Snapshot Foto Absen" class="w-full h-full object-cover">

                    <!-- Canvas Buffer (Hidden) -->
                    <canvas x-ref="canvasElement" class="hidden"></canvas>

                    <!-- Face Guide Overlay -->
                    <div x-show="!snapshotData && streamActive" class="absolute inset-0 pointer-events-none flex items-center justify-center border-2 border-dashed border-white/30 m-8 rounded-lg">
                        <span class="text-white/60 text-[10px] uppercase tracking-widest bg-black/40 px-3 py-1">Posisikan Wajah di Dalam Kotak</span>
                    </div>

                    <!-- Loading / Fallback Indicator -->
                    <div x-show="!streamActive && !snapshotData" class="text-center p-6 text-neutral-400 space-y-2">
                        <svg class="w-8 h-8 mx-auto text-neutral-600 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        <div class="text-xs">Memuat akses webcam...</div>
                    </div>
                </div>

                <!-- Capture & Location Controls -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs text-neutral-600 bg-neutral-bg p-3 border border-neutral-200">
                        <div>Lokasi GPS: <span class="font-mono text-black font-bold" x-text="locationStatus">Mencari koordinat...</span></div>
                        <button type="button" @click="getLocation()" class="text-[10px] uppercase tracking-widest font-semibold text-black underline">Update GPS</button>
                    </div>

                    <div class="flex items-center gap-3">
                        <button x-show="!snapshotData" 
                                @click="takeSnapshot()" 
                                type="button" 
                                class="btn-dark flex-1">
                            Ambil Foto Snapshot
                        </button>

                        <button x-show="snapshotData" 
                                @click="retakeSnapshot()" 
                                type="button" 
                                class="btn-outline-dark">
                            Foto Ulang
                        </button>
                    </div>
                </div>

                <!-- Attendance Submit Form -->
                <form action="{{ route('karyawan.absensi.store') }}" method="POST" class="pt-4 border-t border-neutral-200 space-y-4">
                    @csrf
                    <input type="hidden" name="photo" x-model="snapshotData">
                    <input type="hidden" name="latitude" x-model="latitude">
                    <input type="hidden" name="longitude" x-model="longitude">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Tipe Absensi *</label>
                            <select name="type" required class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                                @if(!$todayAttendance || !$todayAttendance->clock_in)
                                    <option value="in">Clock In (Masuk Shift)</option>
                                @endif
                                @if($todayAttendance && $todayAttendance->clock_in && !$todayAttendance->clock_out)
                                    <option value="out">Clock Out (Pulang Shift)</option>
                                @endif
                                <option value="in">Clock In (Masuk Shift)</option>
                                <option value="out">Clock Out (Pulang Shift)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Catatan Pekerjaan (Opsional)</label>
                            <input type="text" name="notes" placeholder="Contoh: Dyno run Civic Turbo"
                                   class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                        </div>
                    </div>

                    <div>
                        <button type="submit" :disabled="!snapshotData" class="btn-dark w-full disabled:opacity-40 disabled:cursor-not-allowed">
                            Kirim Absensi Kamera &rarr;
                        </button>
                    </div>
                </form>

            </div>

            <!-- Right Column: Today Status & Log History (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Today Status Card -->
                <div class="bg-white border border-neutral-200 p-6 space-y-4">
                    <div class="eyebrow text-black font-semibold">Status Kehadiran Hari Ini</div>
                    
                    @if($todayAttendance)
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between items-center p-3 bg-neutral-bg border border-neutral-200">
                                <div>
                                    <div class="text-[10px] uppercase tracking-wider text-neutral-500">Clock In (Masuk)</div>
                                    <div class="font-bold text-black text-sm">{{ $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i:s') . ' WIB' : '-' }}</div>
                                </div>
                                @if($todayAttendance->photo_in)
                                    <img src="{{ asset('storage/' . $todayAttendance->photo_in) }}" class="w-12 h-12 object-cover border border-neutral-200">
                                @endif
                            </div>

                            <div class="flex justify-between items-center p-3 bg-neutral-bg border border-neutral-200">
                                <div>
                                    <div class="text-[10px] uppercase tracking-wider text-neutral-500">Clock Out (Pulang)</div>
                                    <div class="font-bold text-black text-sm">{{ $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i:s') . ' WIB' : 'Belum Absen Pulang' }}</div>
                                </div>
                                @if($todayAttendance->photo_out)
                                    <img src="{{ asset('storage/' . $todayAttendance->photo_out) }}" class="w-12 h-12 object-cover border border-neutral-200">
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 text-xs">
                            Anda belum melakukan absensi masuk (Clock In) hari ini.
                        </div>
                    @endif
                </div>

                <!-- Recent Attendance Log -->
                <div class="bg-white border border-neutral-200 p-6 space-y-4">
                    <div class="eyebrow text-black font-semibold">Riwayat Absensi Terakhir</div>
                    <div class="space-y-2 max-h-72 overflow-y-auto">
                        @forelse($recentAttendances as $att)
                            <div class="p-3 bg-neutral-bg border border-neutral-200 text-xs flex justify-between items-center">
                                <div>
                                    <div class="font-bold text-black">{{ $att->date->format('d M Y') }}</div>
                                    <div class="text-[10px] text-neutral-500">
                                        In: {{ $att->clock_in ? $att->clock_in->format('H:i') : '-' }} • Out: {{ $att->clock_out ? $att->clock_out->format('H:i') : '-' }}
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 text-[9px] uppercase font-bold {{ $att->status === 'present' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $att->status }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-4 text-xs text-neutral-400">Belum ada riwayat absensi.</div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script>
function cameraAttendance() {
    return {
        streamActive: false,
        snapshotData: null,
        latitude: null,
        longitude: null,
        locationStatus: 'Mendeteksi lokasi...',

        initCamera() {
            this.snapshotData = null;
            this.getLocation();

            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ 
                    video: { width: { ideal: 640 }, height: { ideal: 480 }, facingMode: 'user' } 
                })
                .then(stream => {
                    this.$refs.videoElement.srcObject = stream;
                    this.streamActive = true;
                })
                .catch(err => {
                    console.error("Camera access error:", err);
                    this.streamActive = false;
                    this.locationStatus = 'Kamera tidak diizinkan / tidak tersedia.';
                });
            }
        },

        takeSnapshot() {
            const video = this.$refs.videoElement;
            const canvas = this.$refs.canvasElement;
            if (!video) return;

            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            this.snapshotData = canvas.toDataURL('image/jpeg', 0.85);
        },

        retakeSnapshot() {
            this.snapshotData = null;
        },

        getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        this.latitude = pos.coords.latitude;
                        this.longitude = pos.coords.longitude;
                        this.locationStatus = `${this.latitude.toFixed(5)}, ${this.longitude.toFixed(5)}`;
                    },
                    (err) => {
                        this.latitude = -6.2088;
                        this.longitude = 106.8456;
                        this.locationStatus = 'Workshop Studio (Jakarta)';
                    }
                );
            } else {
                this.latitude = -6.2088;
                this.longitude = 106.8456;
                this.locationStatus = 'Workshop Studio (Jakarta)';
            }
        }
    }
}
</script>
@endpush
