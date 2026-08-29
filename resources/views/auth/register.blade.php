@extends('layouts.app')

@section('meta_title', 'Daftar Akun Traveler — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white uppercase font-sans">
                Daftar Akun Baru
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm max-w-md mx-auto">
                Buat akun traveler untuk memesan pemandu resmi, memantau rute ekspedisi, dan menyimpan riwayat perjalanan.
            </p>
        </div>
    </section>

    <!-- Register Form Section -->
    <section class="py-16 md:py-24 bg-[#F8FAF9] min-h-[60vh] flex items-center justify-center">
        <div class="w-full max-w-md mx-auto px-6">
            
            <div class="tour-card p-8 md:p-10 shadow-elevated space-y-6 bg-white">
                
                <div class="text-center space-y-1">
                    <div class="text-xl font-bold uppercase tracking-wider font-sans text-primary">{{ \App\Models\SiteSetting::get('company_name', 'NUSANTARA TOUR GUIDE') }}</div>
                    <div class="eyebrow text-[10px] text-sage font-bold">Pendaftaran Akun Traveler</div>
                </div>

                <!-- Register Form -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required value="{{ old('name') }}" placeholder="Nama Lengkap Anda"
                               class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        @error('name')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Alamat Email *</label>
                        <input type="email" name="email" required value="{{ old('email') }}" placeholder="email@domain.com"
                               class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        @error('email')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Nomor WhatsApp *</label>
                        <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="0812xxxxxxxx"
                               class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        @error('phone')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Password *</label>
                            <input type="password" name="password" required placeholder="Min 6 karakter"
                                   class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Ulangi Password *</label>
                            <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                                   class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-primary w-full py-3.5 shadow-md flex items-center justify-center gap-2">
                            <span>Daftar Sekarang &rarr;</span>
                        </button>
                    </div>
                </form>

                <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-bold text-primary underline hover:text-sage">Masuk di Sini</a>
                </div>

            </div>

        </div>
    </section>

@endsection
