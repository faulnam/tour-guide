@extends('layouts.admin')

@section('title', 'Kelola Karyawan & Mekanik')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-racing font-bold text-2xl text-white uppercase tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-wrench text-amber-400"></i>
                <span>DAFTAR KARYAWAN & MEKANIK BENGKEL</span>
            </h1>
            <p class="text-xs text-neutral-400">Kelola akun staf, teknisi, dan spesialisasi pengerjaan:</p>
        </div>

        <a href="{{ route('admin.employees.create') }}" 
           class="px-5 py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all inline-flex items-center gap-2 shadow-lg shadow-red-600/30">
            <i class="fa-solid fa-user-plus"></i>
            <span>Tambah Karyawan Baru</span>
        </a>
    </div>

    <div class="bg-[#121218] border border-neutral-800 rounded-3xl p-6 space-y-4 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#0a0a0e] text-neutral-400 uppercase tracking-wider font-semibold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Nama & Kontak</th>
                        <th class="p-3.5">Spesialisasi / Jabatan</th>
                        <th class="p-3.5">Total Absensi</th>
                        <th class="p-3.5">Tugas Ditugaskan</th>
                        <th class="p-3.5">Status Akun</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($employees as $emp)
                        <tr class="hover:bg-neutral-900/50 transition-colors">
                            <td class="p-3.5">
                                <div class="font-bold text-white">{{ $emp->name }}</div>
                                <div class="text-[10px] text-neutral-400 font-mono">{{ $emp->email }} • {{ $emp->phone }}</div>
                            </td>
                            <td class="p-3.5">
                                <span class="font-bold text-amber-400">{{ $emp->specialty ?? 'Mekanik' }}</span>
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $emp->attendances_count }} Hari
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $emp->assigned_bookings_count }} Unit
                            </td>
                            <td class="p-3.5">
                                @if($emp->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-500/20 text-red-400 border border-red-500/30">Nonaktif</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-right space-x-2">
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" 
                                   class="px-2.5 py-1.5 bg-neutral-800 hover:bg-amber-600 hover:text-black text-white rounded-lg font-bold text-[11px] transition-colors">
                                    Edit
                                </a>

                                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus karyawan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 bg-neutral-800 hover:bg-red-600 text-neutral-400 hover:text-white rounded-lg font-bold text-[11px] transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-neutral-500">
                                Belum ada data karyawan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $employees->links() }}
        </div>
    </div>

</div>
@endsection
