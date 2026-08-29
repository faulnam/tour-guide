@extends('layouts.admin')

@section('page_title', 'Pemandu Wisata (Tour Guides)')

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <h2 class="text-xl font-bold uppercase tracking-wider text-white font-sans">
                Pemandu Wisata &amp; Tim Lapangan
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Kelola data akun guide, sertifikasi HPI/APGI, dan riwayat penugasan ekspedisi tur.
            </p>
        </div>

        <a href="{{ route('admin.employees.create') }}" 
           class="px-4 py-2.5 bg-primary text-white hover:bg-secondary rounded-lg text-xs font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Pemandu Baru</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-neutral-900 border border-neutral-800 rounded-2xl p-6 space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider font-bold border-b border-neutral-800">
                    <tr>
                        <th class="p-3.5">Nama &amp; Kontak</th>
                        <th class="p-3.5">Keahlian Wilayah / Lisensi</th>
                        <th class="p-3.5">Presensi GPS</th>
                        <th class="p-3.5">Trip Aktif</th>
                        <th class="p-3.5">Status Akun</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800 text-neutral-300">
                    @forelse($employees as $emp)
                        <tr class="hover:bg-neutral-950/50 transition-colors">
                            <td class="p-3.5">
                                <div class="font-bold text-white">{{ $emp->name }}</div>
                                <div class="text-[10px] text-neutral-400 font-mono">{{ $emp->email }} &bull; {{ $emp->phone }}</div>
                            </td>
                            <td class="p-3.5 font-semibold text-accent">
                                {{ $emp->specialty ?? 'Pemandu Wisata Berlisensi HPI' }}
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $emp->attendances_count }} Hari
                            </td>
                            <td class="p-3.5 font-mono">
                                {{ $emp->assigned_bookings_count }} Trip
                            </td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-1 rounded-full text-[9px] uppercase font-bold {{ $emp->is_active ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-rose-950 text-rose-300 border border-rose-800' }}">
                                    {{ $emp->is_active ? 'Aktif Bertugas' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="p-3.5 text-right space-x-3">
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" class="text-neutral-400 hover:text-white font-bold">
                                    Edit
                                </a>

                                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pemandu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:text-rose-300 font-bold">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-neutral-500">
                                Belum ada data pemandu wisata terdaftar.
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
