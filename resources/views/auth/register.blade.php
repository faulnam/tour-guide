@extends('layouts.app')

@section('meta_title', 'Daftar Akun Customer — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Garage'))

@section('content')

    <section class="py-28 md:py-36 bg-neutral-bg min-h-[85vh] flex items-center justify-center">
        <div class="w-full max-w-md mx-auto px-6">
            
            <div class="bg-white border border-neutral-200 p-8 md:p-10 shadow-sm space-y-6">
                
                <div class="text-center space-y-2">
                    <div class="text-2xl font-bold uppercase tracking-widest3 font-sans">METRIX</div>
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
