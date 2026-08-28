@extends('layouts.admin')

@section('page_title', 'Tambah Karyawan Baru')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-widest text-accent font-semibold">User Administration</div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">Tambah Karyawan / Mekanik</h2>
        </div>
        <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 max-w-2xl">
        <form action="{{ route('admin.employees.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Nama Lengkap *</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Nama Karyawan"
                       class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="email@bengkel.com"
                           class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">No. WhatsApp *</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="0812xxxxxxxx"
                           class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                </div>
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Spesialisasi / Keahlian</label>
                <input type="text" name="specialty" value="{{ old('specialty') }}" placeholder="Contoh: Dyno Tuner / Master Custom Builder / Cat Oven Spies Hecker"
                       class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Password *</label>
                    <input type="password" name="password" required placeholder="Min 6 karakter"
                           class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-400 mb-1">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                           class="w-full bg-neutral-950 border border-neutral-700 px-3 py-2.5 text-xs text-white focus:outline-none focus:border-white">
                </div>
            </div>

            <div class="pt-4 border-t border-neutral-800 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-wider font-semibold transition-colors">
                    Simpan Karyawan &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
