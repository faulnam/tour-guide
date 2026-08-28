<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0a0a0c]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — Apex Garage Portal</title>

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
<body class="h-full text-neutral-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-grid relative overflow-x-hidden selection:bg-red-600 selection:text-white" x-data="{ currentRole: '{{ request('role', 'customer') }}' }">

    <!-- Ambient Neon Background Blobs -->
    <div class="fixed top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-10 right-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
            <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-800 rounded-xl flex items-center justify-center text-white font-racing font-black text-xl shadow-lg shadow-red-600/30 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-gauge-high"></i>
            </div>
            <div class="text-left">
                <span class="font-racing font-extrabold text-2xl tracking-wider text-white block">APEX<span class="text-red-500">GARAGE</span></span>
                <span class="text-[10px] tracking-[0.3em] uppercase text-neutral-400 font-bold block">Tuning & Custom Portal</span>
            </div>
        </a>

        <h2 class="mt-6 text-2xl font-extrabold text-white tracking-tight">
            Masuk ke Akun Anda
        </h2>
        <p class="mt-2 text-xs text-neutral-400">
            Akses sistem terpadu Admin Bengkel, Absensi Karyawan, & Booking Customer
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="bg-[#121218]/90 backdrop-blur-xl py-8 px-6 shadow-2xl rounded-2xl sm:px-10 border border-neutral-800/80 glow-red">
            
            <!-- Quick Demo Role Switcher Tabs -->
            <div class="mb-6 bg-neutral-900/90 p-1 rounded-xl border border-neutral-800 grid grid-cols-3 gap-1 text-center">
                <button type="button" @click="currentRole = 'customer'; fillCredentials('customer@gmail.com', 'customer123')"
                        :class="currentRole === 'customer' ? 'bg-red-600 text-white font-bold shadow' : 'text-neutral-400 hover:text-white'"
                        class="py-2 text-xs rounded-lg transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-user"></i> Customer
                </button>
                <button type="button" @click="currentRole = 'karyawan'; fillCredentials('mekanik@bengkel.com', 'mekanik123')"
                        :class="currentRole === 'karyawan' ? 'bg-amber-600 text-white font-bold shadow' : 'text-neutral-400 hover:text-white'"
                        class="py-2 text-xs rounded-lg transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-wrench"></i> Karyawan
                </button>
                <button type="button" @click="currentRole = 'admin'; fillCredentials('admin@bengkel.com', 'admin123')"
                        :class="currentRole === 'admin' ? 'bg-neutral-700 text-white font-bold shadow' : 'text-neutral-400 hover:text-white'"
                        class="py-2 text-xs rounded-lg transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-shield-halved"></i> Admin
                </button>
            </div>

            <!-- Role Badge Hint -->
            <div class="mb-5 p-3 rounded-xl text-xs flex items-center justify-between border"
                 :class="{
                     'bg-red-500/10 border-red-500/30 text-red-300': currentRole === 'customer',
                     'bg-amber-500/10 border-amber-500/30 text-amber-300': currentRole === 'karyawan',
                     'bg-neutral-800 border-neutral-700 text-neutral-300': currentRole === 'admin'
                 }">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i>
                    <span x-text="currentRole === 'customer' ? 'Portal Customer: Booking & Live Status Tracker' : (currentRole === 'karyawan' ? 'Portal Karyawan: Absensi Kamera & Tugas Mekanik' : 'Portal Admin: Workshop CMS & Rekap Absensi')"></span>
                </div>
                <span class="text-[10px] uppercase font-mono px-2 py-0.5 rounded bg-black/40" x-text="currentRole"></span>
            </div>

            @if(session('success'))
                <div class="mb-5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-3 rounded-xl text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl text-xs flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-4" id="loginForm">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-500">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               value="{{ old('email', 'customer@gmail.com') }}"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror" 
                               placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-neutral-300">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               value="customer123"
                               class="w-full bg-[#0e0e12] border border-neutral-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror" 
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center text-neutral-400 hover:text-neutral-200 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-neutral-900 border-neutral-700 text-red-600 focus:ring-red-500">
                        <span class="ml-2">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" 
                        class="w-full mt-2 flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl text-xs font-bold uppercase tracking-widest text-white bg-gradient-to-r from-red-600 via-red-500 to-red-700 hover:from-red-500 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-lg shadow-red-600/30 hover:shadow-red-600/50 hover:scale-[1.01] active:scale-[0.99] transition-all">
                    <span>Masuk Sekarang</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="mt-6 border-t border-neutral-800 pt-5 text-center text-xs text-neutral-400">
                Belum memiliki akun Customer? 
                <a href="{{ route('register') }}" class="font-bold text-red-400 hover:text-red-300 ml-1 underline">Daftar Sekarang</a>
            </div>

            <!-- Quick Demo Autofill Helper Bar -->
            <div class="mt-6 pt-4 border-t border-neutral-800/80">
                <div class="text-[11px] font-semibold text-neutral-400 uppercase tracking-wider mb-2 text-center">Akun Demo Pengujian:</div>
                <div class="grid grid-cols-3 gap-2 text-[10px]">
                    <button type="button" @click="currentRole = 'admin'; fillCredentials('admin@bengkel.com', 'admin123')"
                            class="p-2 bg-neutral-900 hover:bg-neutral-800 rounded-lg border border-neutral-700/60 text-left transition-colors">
                        <div class="font-bold text-white">👑 Admin</div>
                        <div class="text-neutral-400 truncate">admin@bengkel.com</div>
                        <div class="text-neutral-500">pass: admin123</div>
                    </button>
                    <button type="button" @click="currentRole = 'karyawan'; fillCredentials('mekanik@bengkel.com', 'mekanik123')"
                            class="p-2 bg-neutral-900 hover:bg-neutral-800 rounded-lg border border-neutral-700/60 text-left transition-colors">
                        <div class="font-bold text-amber-400">🔧 Mekanik</div>
                        <div class="text-neutral-400 truncate">mekanik@bengkel.com</div>
                        <div class="text-neutral-500">pass: mekanik123</div>
                    </button>
                    <button type="button" @click="currentRole = 'customer'; fillCredentials('customer@gmail.com', 'customer123')"
                            class="p-2 bg-neutral-900 hover:bg-neutral-800 rounded-lg border border-neutral-700/60 text-left transition-colors">
                        <div class="font-bold text-red-400">👤 Customer</div>
                        <div class="text-neutral-400 truncate">customer@gmail.com</div>
                        <div class="text-neutral-500">pass: customer123</div>
                    </button>
                </div>
            </div>

        </div>

        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-xs text-neutral-400 hover:text-white transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda Apex Garage
            </a>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
