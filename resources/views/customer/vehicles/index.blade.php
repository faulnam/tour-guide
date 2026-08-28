@extends('layouts.customer')

@section('title', 'Garasi Kendaraan Saya')

@section('content')
<div class="space-y-8" x-data="{ addModal: false }">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight">
                GARASI KENDARAAN SAYA
            </h1>
            <p class="text-xs text-neutral-400">Daftar motor dan mobil yang tersimpan di akun Anda untuk booking cepat 1-klik:</p>
        </div>

        <button @click="addModal = true" 
                class="px-5 py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all inline-flex items-center gap-2 shadow-lg shadow-red-600/30">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Kendaraan Baru</span>
        </button>
    </div>

    <!-- Vehicles Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($vehicles as $v)
            <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 shadow-xl space-y-4 hover:border-red-500/40 transition-colors flex flex-col justify-between">
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase font-racing px-2.5 py-0.5 rounded-full {{ $v->type === 'motor' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                            {{ $v->type === 'motor' ? '🏍️ Sepeda Motor' : '🚗 Mobil' }}
                        </span>

                        <form action="{{ route('customer.vehicles.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Hapus kendaraan ini dari garasi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-neutral-500 hover:text-red-400 text-xs p-1">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>

                    <div>
                        <h3 class="font-racing font-bold text-lg text-white">{{ $v->brand }} {{ $v->model }}</h3>
                        <div class="font-mono text-xs text-red-400 font-bold mt-0.5">{{ $v->license_plate }}</div>
                    </div>

                    <div class="p-3 bg-[#0a0a0e] rounded-xl text-xs space-y-1.5 border border-neutral-800/80 text-neutral-300">
                        <div class="flex justify-between"><span class="text-neutral-500">Tahun:</span> <span>{{ $v->year ?? '-' }}</span></div>
                        <div class="flex justify-between"><span class="text-neutral-500">Warna:</span> <span>{{ $v->color ?? '-' }}</span></div>
                        <div class="flex justify-between"><span class="text-neutral-500">Kapasitas Mesin:</span> <span>{{ $v->engine_cc ?? '-' }}</span></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-800">
                    <a href="{{ url('/booking?vehicle_type=' . $v->type) }}" 
                       class="w-full py-2.5 bg-neutral-800 hover:bg-red-600 text-white rounded-xl text-xs font-bold transition-colors block text-center">
                        <i class="fa-solid fa-calendar-plus mr-1"></i> Booking Servis Unit Ini
                    </a>
                </div>

            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-[#121218] border border-neutral-800 rounded-3xl text-neutral-500">
                <i class="fa-solid fa-warehouse text-3xl text-neutral-700 mb-3 block"></i>
                Belum ada kendaraan di garasi Anda. Tambahkan kendaraan pertama Anda!
            </div>
        @endforelse
    </div>

    <!-- Add Vehicle Modal -->
    <div x-show="addModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         x-cloak
         class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-center justify-center p-4"
         @click.self="addModal = false">
        
        <div class="bg-[#121218] border border-neutral-700 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="font-racing font-bold text-base text-white uppercase">TAMBAH KENDARAAN KE GARASI</h3>
                <button @click="addModal = false" class="text-neutral-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('customer.vehicles.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Tipe Kendaraan *</label>
                    <select name="type" required class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                        <option value="mobil">🚗 Mobil (Sports / Sedan / SUV / MPV)</option>
                        <option value="motor">🏍️ Sepeda Motor (Sport / Moge / Matic / Custom)</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Merk *</label>
                        <input type="text" name="brand" required placeholder="Contoh: Honda / Yamaha / BMW"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Model / Seri *</label>
                        <input type="text" name="model" required placeholder="Contoh: Civic Turbo / ZX-25R"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Plat Nomor *</label>
                        <input type="text" name="license_plate" required placeholder="Contoh: B 1234 ABC"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white uppercase placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Tahun (Opsional)</label>
                        <input type="text" name="year" placeholder="Contoh: 2024"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Warna Bodi (Opsional)</label>
                        <input type="text" name="color" placeholder="Contoh: Putih Mutiara"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Kapasitas Mesin (CC)</label>
                        <input type="text" name="engine_cc" placeholder="Contoh: 2000cc Turbo / 250cc"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="addModal = false" class="px-4 py-2.5 bg-neutral-800 text-neutral-300 rounded-xl text-xs font-bold">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase shadow-lg shadow-red-600/30">
                        Simpan ke Garasi
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
