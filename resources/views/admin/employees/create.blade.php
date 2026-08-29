@extends('layouts.admin')

@section('page_title', 'Tambah Pemandu Wisata Baru')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between pb-4 border-b border-neutral-800">
        <div>
            <div class="text-[10px] uppercase tracking-wider text-accent font-bold">Manajemen Pemandu Wisata</div>
            <h2 class="text-xl font-bold uppercase tracking-wider text-white font-sans">Tambah Akun Guide</h2>
        </div>
        <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 border border-neutral-700 rounded-lg text-neutral-300 hover:text-white text-xs uppercase tracking-wider transition-colors">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 md:p-8 max-w-2xl">
        <form action="{{ route('admin.employees.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Nama Lengkap &amp; Gelar *</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: I Wayan Arta, S.Tr.Par (HPI Bali)"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="guide@tourguide.id"
                           class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">No. WhatsApp *</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="0812xxxxxxxx"
                           class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
                </div>
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Keahlian Wilayah &amp; Sertifikasi Lisensi</label>
                <input type="text" name="specialty" value="{{ old('specialty') }}" placeholder="Contoh: Pemandu Budaya Bali &amp; Lisensi HPI Madya / Dive Master Komodo"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Password Akun *</label>
                    <input type="password" name="password" required placeholder="Min 6 karakter"
                           class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-neutral-400 mb-1">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                           class="w-full bg-neutral-950 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-accent">
                </div>
            </div>

            <div class="pt-4 border-t border-neutral-800 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-primary text-white hover:bg-secondary rounded-xl text-xs uppercase tracking-wider font-bold transition-colors shadow-sm">
                    Simpan Data Pemandu &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
