@extends('layouts.app')

@section('meta_title', 'Daftar Akun Customer — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-16 md:pt-48 md:pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-3">
            <div class="eyebrow-light">Customer Registration</div>
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight text-white uppercase font-sans">
                Daftar Akun
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-md mx-auto">
                Buat akun customer untuk memantau progress pengerjaan modifikasi dan klaim garansi servis.
            </p>
        </div>
    </section>

    <!-- Register Form Section -->
    <section class="py-16 md:py-24 bg-neutral-bg min-h-[60vh] flex items-center justify-center">
        <div class="w-full max-w-md mx-auto px-6">
            
            <div class="bg-white border border-neutral-200 p-8 md:p-10 shadow-lg space-y-6">
                
                <div class="text-center space-y-1">
                    <div class="text-2xl font-bold uppercase tracking-widest3 font-sans">{{ \App\Models\SiteSetting::get('company_name', 'BENGKEL') }}</div>
                    <div class="eyebrow text-[10px] text-neutral-400">Pendaftaran Akun Customer</div>
                </div>

                <!-- Register Form -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required value="{{ old('name') }}" placeholder="Nama Anda"
                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                        @error('name')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Email Address *</label>
                        <input type="email" name="email" required value="{{ old('email') }}" placeholder="nama@email.com"
                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                        @error('email')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">No. WhatsApp *</label>
                        <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="0812xxxxxxxx"
                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                        @error('phone')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Password *</label>
                            <input type="password" name="password" required placeholder="Min 6 karakter"
                                   class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Konfirmasi Password *</label>
                            <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                                   class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-dark w-full">
                            Daftar Sekarang &rarr;
                        </button>
                    </div>
                </form>

                <div class="pt-4 border-t border-neutral-200 text-center text-xs text-neutral-500">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-bold text-black underline hover:text-accent">Masuk di Sini</a>
                </div>

            </div>

        </div>
    </section>

@endsection
