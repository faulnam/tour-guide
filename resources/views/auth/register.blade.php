<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0a0a0c]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun Customer — Apex Garage</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Orbitron:wght@600;800;900&display=swap" rel="stylesheet">

    <!-- Compiled CSS & FontAwesome -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-racing { font-family: 'Orbitron', sans-serif; }
        .glow-red { box-shadow: 0 0 35px -5px rgba(239, 68, 68, 0.3); }
        .bg-grid { background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px); background-size: 24px 24px; }
    </style>
</head>
<body class="h-full text-neutral-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-grid relative overflow-x-hidden selection:bg-red-600 selection:text-white">

    <div class="fixed top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
            <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-800 rounded-xl flex items-center justify-center text-white font-racing font-black text-xl shadow-lg shadow-red-600/30 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-gauge-high"></i>
            </div>
            <div class="text-left">
                <span class="font-racing font-extrabold text-2xl tracking-wider text-white block">APEX<span class="text-red-500">GARAGE</span></span>
                <span class="text-[10px] tracking-[0.3em] uppercase text-neutral-400 font-bold block">Customer Portal</span>
            </div>
        </a>

        <h2 class="mt-6 text-2xl font-extrabold text-white tracking-tight">
            Daftar Akun Baru
        </h2>
        <p class="mt-2 text-xs text-neutral-400">
            Nikmati kemudahan booking servis, simpan garasi kendaraan, dan pantau live status modifikasi
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="bg-[#121218]/90 backdrop-blur-xl py-8 px-6 shadow-2xl rounded-2xl sm:px-10 border border-neutral-800/80 glow-red">
            
            <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Nama Lengkap
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-500">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                               placeholder="Nama Anda">
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-500">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror" 
                               placeholder="email@example.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Nomor WhatsApp / HP
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-500">
                            <i class="fa-solid fa-phone text-sm"></i>
                        </div>
                        <input id="phone" name="phone" type="text" required value="{{ old('phone') }}"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('phone') border-red-500 @enderror" 
                               placeholder="0812xxxxxxxx">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Kata Sandi (Minimal 6 Karakter)
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror" 
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-500">
                            <i class="fa-solid fa-shield-check text-sm"></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                               placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Alamat / Domisili (Opsional)
                    </label>
                    <textarea id="address" name="address" rows="2"
                              class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                              placeholder="Kota / Daerah tempat tinggal">{{ old('address') }}</textarea>
                </div>

                <button type="submit" 
                        class="w-full mt-2 flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl text-xs font-bold uppercase tracking-widest text-white bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-lg shadow-red-600/30 hover:shadow-red-600/50 hover:scale-[1.01] active:scale-[0.99] transition-all">
                    <span>Daftar Akun Customer</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="mt-6 border-t border-neutral-800 pt-5 text-center text-xs text-neutral-400">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-red-400 hover:text-red-300 ml-1 underline">Masuk di Sini</a>
            </div>

        </div>

        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-xs text-neutral-400 hover:text-white transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda Apex Garage
            </a>
        </div>
    </div>
</body>
</html>
