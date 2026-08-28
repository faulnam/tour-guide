@extends('layouts.app')

@section('meta_title', 'Hubungi Kami & Lokasi Workshop — Apex Garage')
@section('meta_description', 'Lokasi bengkel Apex Garage Jakarta, nomor WhatsApp konsultasi modifikasi, emergency towing hotline, dan form pesan.')

@section('content')

<!-- Header Banner -->
<section class="py-16 bg-[#0c0c10] border-b border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-500/30 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-red-400">
            <i class="fa-solid fa-location-dot"></i>
            <span>Workshop Location & Hotline</span>
        </div>
        <h1 class="font-racing font-black text-3xl sm:text-5xl text-white uppercase tracking-tight">
            HUBUNGI KAMI & KONSULTASI
        </h1>
        <p class="text-xs sm:text-sm text-neutral-400 max-w-2xl mx-auto">
            Diskusikan rencana modifikasi motor & mobil Anda langsung dengan tim teknisi dan tuner kami.
        </p>
    </div>
</section>

<!-- Contact Info & Form Grid -->
<section class="py-20 bg-[#09090b]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Left Info Cards -->
            <div class="space-y-6">
                <div class="bg-[#121218] border border-neutral-800 p-8 rounded-3xl space-y-6 shadow-xl">
                    <h3 class="font-racing font-bold text-xl text-white uppercase">INFORMASI WORKSHOP</h3>

                    <div class="space-y-4 text-xs text-neutral-300">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-red-600/20 text-red-500 flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white uppercase mb-0.5">Alamat Workshop</div>
                                <p class="text-neutral-400">Jl. TB Simatupang No. 88, Cilandak, Jakarta Selatan 12430</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-600/20 text-emerald-500 flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white uppercase mb-0.5">WhatsApp Konsultasi Modif</div>
                                <p class="text-emerald-400 font-mono font-bold">+62 812-8888-9999 (Fast Response)</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-600/20 text-amber-500 flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white uppercase mb-0.5">Jam Operasional</div>
                                <p class="text-neutral-400">Senin – Sabtu: 08:30 – 18:00 WIB (Minggu Tutup / Khusus Event Dyno)</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-600/20 text-blue-500 flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-solid fa-truck-pickup"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white uppercase mb-0.5">Hotline Towing & Pick-up Unit</div>
                                <p class="text-neutral-400">0811-9999-8888 (24 Jam Emergency Storing)</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-neutral-800">
                        <a href="{{ url('/booking') }}" class="w-full py-3.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider block text-center shadow-lg shadow-red-600/30 transition-all">
                            <i class="fa-solid fa-calendar-check mr-2"></i> Langsung Booking Antrean Online &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Message Form -->
            <div class="bg-[#121218] border border-neutral-800 p-8 rounded-3xl shadow-xl space-y-6">
                <h3 class="font-racing font-bold text-xl text-white uppercase">KIRIM PESAN / PERTANYAAN</h3>

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required placeholder="Nama Anda"
                               class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Email *</label>
                            <input type="email" name="email" required placeholder="nama@email.com"
                                   class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">No. WhatsApp *</label>
                            <input type="text" name="phone" required placeholder="0812xxxxxxxx"
                                   class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Subjek / Topik *</label>
                        <input type="text" name="subject" required placeholder="Contoh: Tanya Remap ECU Civic Turbo & Dyno"
                               class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-neutral-400 uppercase mb-1">Pesan / Rencana Modifikasi *</label>
                        <textarea name="message" rows="4" required placeholder="Tuliskan pertanyaan atau spesifikasi kendaraan Anda..."
                                  class="w-full bg-[#0a0a0e] border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full py-3.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-xl text-xs font-racing font-bold uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all">
                        Kirim Pesan ke Tim Apex
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
