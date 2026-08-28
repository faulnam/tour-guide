@extends('layouts.admin')

@section('page_title', 'Staff & Mechanics')

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white font-sans">
                Karyawan &amp; Mekanik Bengkel
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Kelola data akun staf, teknisi, dan spesialisasi pengerjaan modifikasi.
            </p>
        </div>

        <a href="{{ route('admin.employees.create') }}" 
           class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-semibold uppercase tracking-wider transition-colors inline-flex items-center gap-2">
            <span>+ Tambah Karyawan Baru</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Nama &amp; Kontak</th>
                        <th class="p-3.5">Spesialisasi</th>
                        <th class="p-3.5">Total Absensi</th>
                        <th class="p-3.5">Tugas Aktif</th>
                        <th class="p-3.5">Status Akun</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($employees as $emp)
                        <tr class="hover:bg-neutral-950/50 transition-colors">
                            <td class="p-3.5">
                                <div class="font-semibold text-white">{{ $emp->name }}</div>
                                <div class="text-[10px] text-neutral-400 font-mono">{{ $emp->email }} • {{ $emp->phone }}</div>
                            </td>
                            <td class="p-3.5 font-semibold text-accent">
                                {{ $emp->specialty ?? 'Mekanik / Teknisi' }}
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $emp->attendances_count }} Hari
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $emp->assigned_bookings_count }} Unit
                            </td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 text-[9px] uppercase font-bold {{ $emp->is_active ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-red-950 text-red-300 border border-red-800' }}">
                                    {{ $emp->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="p-3.5 text-right space-x-3">
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" class="text-neutral-400 hover:text-white font-semibold">
                                    Edit
                                </a>

                                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus karyawan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-neutral-500">
                                Belum ada data karyawan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($employees->hasPages())
            <div class="pt-4 border-t border-neutral-800 flex justify-center">
                {{ $employees->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
