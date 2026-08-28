@extends('layouts.app')

@section('meta_title', 'Contact Us & Workshop Studio — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Garage'))
@section('meta_description', 'Hubungi kami untuk konsultasi modifikasi motor & mobil, hotline towing, dan jadwal dyno tuning di Jakarta.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Get In Touch</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase font-sans">
                Contact Us
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
                Konsultasikan rencana modifikasi, tuning dyno, atau kebutuhan servis kendaraan Anda dengan master tuner Metrix.
            </p>
        </div>
    </section>

    <!-- Main Contact Information & Form -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                <!-- Left Details (5 cols) -->
                <div class="lg:col-span-5 space-y-10">
                    <div class="space-y-3">
                        <div class="eyebrow text-accent font-semibold">Workshop Studio</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">
                            Jakarta Headquarters
                        </h2>
                    </div>

                    <div class="space-y-6 text-xs text-neutral-700 divide-y divide-neutral-200">
                        <div class="pt-2 space-y-1">
                            <div class="font-bold text-black uppercase tracking-wider text-[11px]">Alamat Studio:</div>
                            <p class="text-neutral-600 whitespace-pre-line leading-relaxed">
                                {{ \App\Models\SiteSetting::get('company_address', "Metrix Garage & Tuning\nJl. TB Simatupang No. 88\nCilandak, Jakarta Selatan 12430") }}
                            </p>
                        </div>

                        <div class="pt-4 space-y-1">
                            <div class="font-bold text-black uppercase tracking-wider text-[11px]">Telepon &amp; WhatsApp:</div>
                            <p class="text-neutral-600">
                                {{ \App\Models\SiteSetting::get('company_phone_1', '+62 21 7890 1234') }}<br>
                                WhatsApp: {{ \App\Models\SiteSetting::get('company_whatsapp', '+62 812-8888-9999') }} (Konsultasi Fast Response)
                            </p>
                        </div>

                        <div class="pt-4 space-y-1">
                            <div class="font-bold text-black uppercase tracking-wider text-[11px]">Jam Operasional:</div>
                            <p class="text-neutral-600">
                                Senin – Sabtu: 08:30 – 18:00 WIB<br>
                                Minggu: Tutup (Khusus Booking Event Dyno)
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ url('/booking') }}" class="btn-dark block text-center">
                            Booking Antrean Online &rarr;
                        </a>
                    </div>
                </div>

                <!-- Right Form (7 cols) -->
                <div class="lg:col-span-7 bg-neutral-bg p-8 md:p-12 border border-neutral-200">
                    <div class="space-y-2 mb-8">
                        <div class="eyebrow text-accent font-semibold">Start A Conversation</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black uppercase font-sans">
                            Send Us A Message
                        </h2>
                    </div>

                    <form action="{{ url('/contact-us') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" required placeholder="Nama Anda"
                                   class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" required placeholder="name@example.com"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                            </div>

                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                    No. Telepon / WhatsApp
                                </label>
                                <input type="text" name="phone" placeholder="0812xxxxxxxx"
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                Rencana Modifikasi / Pesan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message" rows="5" required placeholder="Tuliskan spesifikasi kendaraan atau pertanyaan Anda..."
                                      class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors"></textarea>
                        </div>

                        <div>
                            <button type="submit" class="btn-dark w-full md:w-auto">
                                Submit Message &rarr;
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

@endsection
