@extends('layouts.admin')

@section('title', 'Edit Karyawan — ' . $employee->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <div>
        <a href="{{ route('admin.employees.index') }}" class="text-xs text-red-400 hover:underline mb-1 inline-flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Karyawan
        </a>
        <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight">
            EDIT DATA KARYAWAN / MEKANIK
        </h1>
    </div>

    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 sm:p-8 shadow-2xl">
        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Nama Lengkap *</label>
                <input type="text" name="name" required value="{{ old('name', $employee->name) }}"
                       class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                @error('name') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Email Login *</label>
                    <input type="email" name="email" required value="{{ old('email', $employee->email) }}"
                           class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    @error('email') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Nomor Telepon / WhatsApp *</label>
                    <input type="text" name="phone" required value="{{ old('phone', $employee->phone) }}"
                           class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    @error('phone') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Ubah Kata Sandi (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    @error('password') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Spesialisasi / Jabatan *</label>
                    <input type="text" name="specialty" required value="{{ old('specialty', $employee->specialty) }}"
                           class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">
                    @error('specialty') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Alamat Domisili</label>
                <textarea name="address" rows="2" class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-red-500">{{ old('address', $employee->address) }}</textarea>
            </div>

            <div class="flex items-center text-xs text-neutral-300">
                <input type="checkbox" name="is_active" value="1" {{ $employee->is_active ? 'checked' : '' }} class="w-4 h-4 rounded bg-neutral-900 border-neutral-700 text-red-600 focus:ring-red-500">
                <span class="ml-2">Status Akun Aktif (Dapat Login & Melakukan Absensi)</span>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-neutral-800">
                <a href="{{ route('admin.employees.index') }}" class="px-4 py-2.5 bg-neutral-800 text-neutral-300 rounded-xl text-xs font-bold">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase shadow-lg shadow-red-600/30">
                    Update Karyawan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
