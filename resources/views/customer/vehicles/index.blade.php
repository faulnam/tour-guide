@extends('layouts.customer')

@section('meta_title', 'Preferensi Wisata Saya — Nusantara Tour Guide')

@section('content')
<div class="space-y-6" x-data="{ showModal: false }">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 gap-4">
        <div>
            <div class="eyebrow text-sage font-bold">Profil Wisatawan</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-primary font-sans">
                Preferensi Destinasi &amp; Data Wisata
            </h1>
        </div>
        <button @click="showModal = true" class="btn-primary flex items-center gap-2 shadow-md">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Preferensi Destinasi</span>
        </button>
    </div>

    <!-- Vehicles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($vehicles as $v)
            <div class="tour-card p-6 space-y-4 flex flex-col justify-between group bg-white">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-sage font-bold">{{ $v->type === 'mobil' ? 'Private Tour Charter' : 'Open / Group Tour' }} &bull; {{ $v->year ?? '2024' }}</span>
                            <h3 class="text-lg font-bold text-primary uppercase mt-0.5">{{ $v->brand }} {{ $v->model }}</h3>
                        </div>
                        <span class="px-2.5 py-1 text-[9px] uppercase font-bold rounded-full bg-sage-light text-sage border border-sage/30">{{ $v->type }}</span>
                    </div>

                    <div class="p-3 bg-[#F8FAF9] rounded-xl border border-gray-100 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Estimasi Peserta:</span>
                            <span class="font-mono font-bold text-primary">{{ $v->license_plate }}</span>
                        </div>
                        @if($v->color)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Minat / Tema Khusus:</span>
                                <span class="text-primary font-medium">{{ $v->color }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ url('/booking?vehicle_id=' . $v->id) }}" class="text-xs font-bold text-primary uppercase tracking-wider hover:text-sage flex items-center gap-1">
                        <span>Pesan Tur Ini &rarr;</span>
                    </a>

                    <form action="{{ route('customer.vehicles.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Hapus preferensi destinasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-semibold">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 tour-card p-12 text-center text-gray-400 text-xs space-y-3 bg-white">
                <p>Belum ada destinasi favorit atau preferensi wisata yang tersimpan.</p>
                <button @click="showModal = true" class="btn-primary">
                    Tambah Preferensi Baru Sekarang
                </button>
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah Preferensi -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-6" @click.self="showModal = false">
        <div class="tour-card p-8 max-w-lg w-full space-y-6 shadow-elevated bg-white">
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <h3 class="text-base font-bold uppercase tracking-wider text-primary">Tambah Preferensi Destinasi</h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-primary text-xl">&times;</button>
            </div>

            <form action="{{ route('customer.vehicles.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <label class="p-3.5 rounded-xl border border-gray-200 cursor-pointer flex items-center gap-3 bg-[#F8FAF9]">
                        <input type="radio" name="type" value="mobil" checked class="accent-primary">
                        <span class="text-xs font-bold text-primary uppercase">Private Tour</span>
                    </label>
                    <label class="p-3.5 rounded-xl border border-gray-200 cursor-pointer flex items-center gap-3 bg-[#F8FAF9]">
                        <input type="radio" name="type" value="motor" class="accent-primary">
                        <span class="text-xs font-bold text-primary uppercase">Group / Open Tour</span>
                    </label>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Destinasi Utama *</label>
                        <input type="text" name="brand" required placeholder="Bali / Labuan Bajo / Raja Ampat"
                               class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Titik Jemput Pilihan *</label>
                        <input type="text" name="model" required placeholder="Bandara Ngurah Rai / Hotel Sanur"
                               class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-primary">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Perkiraan Jumlah Tamu *</label>
                        <input type="text" name="license_plate" required placeholder="Contoh: 2 Dewasa / 4 Orang"
                               class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Tahun / Musim Liburan</label>
                        <input type="text" name="year" placeholder="2025"
                               class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Tema Wisata / Minat Khusus</label>
                    <input type="text" name="color" placeholder="Bahari Snorkeling / Trekking Budaya / Kuliner Heritage"
                           class="w-full bg-[#F8FAF9] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-primary">
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 rounded-lg border border-gray-300 text-xs uppercase font-bold text-gray-600 hover:text-primary">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary shadow-sm">
                        Simpan Preferensi &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
