@extends('layouts.customer')

@section('meta_title', 'Garasi Kendaraan Saya — BENGKEL')

@section('content')
<div class="space-y-6" x-data="{ showModal: false }">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-neutral-200 gap-4">
        <div>
            <div class="eyebrow text-accent font-semibold">My Garage</div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-black font-sans">
                Koleksi Kendaraan Saya
            </h1>
        </div>
        <button @click="showModal = true" class="btn-dark">
            + Tambah Kendaraan Baru
        </button>
    </div>

    <!-- Vehicles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($vehicles as $v)
            <div class="bg-white border border-neutral-200 p-6 space-y-4 hover:border-black transition-colors flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-xs uppercase tracking-widest text-neutral-400 font-semibold">{{ $v->type }} • {{ $v->year ?? '2024' }}</span>
                            <h3 class="text-lg font-bold text-black uppercase mt-0.5">{{ $v->brand }} {{ $v->model }}</h3>
                        </div>
                        <span class="px-2 py-0.5 text-[9px] uppercase font-bold bg-neutral-bg border border-neutral-300 text-black">{{ $v->type }}</span>
                    </div>

                    <div class="p-3 bg-neutral-bg border border-neutral-200 space-y-1 text-xs">
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Plat Nomor:</span>
                            <span class="font-mono font-bold text-black">{{ $v->license_plate }}</span>
                        </div>
                        @if($v->color)
                            <div class="flex justify-between">
                                <span class="text-neutral-500">Warna:</span>
                                <span class="text-black">{{ $v->color }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-100 flex items-center justify-between">
                    <a href="{{ url('/booking?vehicle_id=' . $v->id) }}" class="text-xs font-bold text-black uppercase tracking-wider hover:text-accent">
                        Book Servis &rarr;
                    </a>

                    <form action="{{ route('customer.vehicles.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Hapus kendaraan ini dari garasi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white border border-neutral-200 p-12 text-center text-neutral-400 text-xs space-y-3">
                <p>Belum ada kendaraan yang ditambahkan ke garasi akun Anda.</p>
                <button @click="showModal = true" class="btn-dark">
                    Tambah Kendaraan Sekarang
                </button>
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah Kendaraan -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-6" @click.self="showModal = false">
        <div class="bg-white border border-neutral-200 p-8 max-w-lg w-full space-y-6 shadow-2xl">
            <div class="flex justify-between items-center pb-3 border-b border-neutral-200">
                <h3 class="text-base font-bold uppercase tracking-wider text-black">Tambah Kendaraan ke Garasi</h3>
                <button @click="showModal = false" class="text-neutral-400 hover:text-black text-lg">&times;</button>
            </div>

            <form action="{{ route('customer.vehicles.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <label class="p-3 border border-neutral-200 cursor-pointer flex items-center gap-3">
                        <input type="radio" name="type" value="mobil" checked class="accent-black">
                        <span class="text-xs font-bold text-black uppercase">Mobil</span>
                    </label>
                    <label class="p-3 border border-neutral-200 cursor-pointer flex items-center gap-3">
                        <input type="radio" name="type" value="motor" class="accent-black">
                        <span class="text-xs font-bold text-black uppercase">Motor</span>
                    </label>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Merk *</label>
                        <input type="text" name="brand" required placeholder="Toyota / Honda / Kawasaki"
                               class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Model / Tipe *</label>
                        <input type="text" name="model" required placeholder="Supra / Civic / ZX-25R"
                               class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Plat Nomor *</label>
                        <input type="text" name="license_plate" required placeholder="B 1234 XYZ"
                               class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black uppercase focus:outline-none focus:border-black">
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Tahun Kendaraan</label>
                        <input type="text" name="year" placeholder="2023"
                               class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Warna Bodi</label>
                    <input type="text" name="color" placeholder="Hitam Glossy / Abu-abu Matte"
                           class="w-full bg-neutral-bg border border-neutral-300 px-3 py-2.5 text-xs text-black focus:outline-none focus:border-black">
                </div>

                <div class="pt-4 border-t border-neutral-200 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="btn-outline-dark">
                        Batal
                    </button>
                    <button type="submit" class="btn-dark">
                        Simpan ke Garasi &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
