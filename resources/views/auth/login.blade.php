@extends('layouts.app')

@section('meta_title', 'Login Portal — ' . \App\Models\SiteSetting::get('company_name', 'BENGKEL'))

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-16 md:pt-48 md:pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-3">
            <div class="eyebrow-light">Integrated Access Portal</div>
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight text-white uppercase font-sans">
                Portal Login
            </h1>
            <p class="text-neutral-300 text-xs md:text-sm max-w-md mx-auto">
                Akses portal Customer, Karyawan Bengkel, dan Admin CMS {{ \App\Models\SiteSetting::get('company_name', 'BENGKEL') }}.
            </p>
        </div>
    </section>

    <!-- Login Form Section -->
    <section class="py-16 md:py-24 bg-neutral-bg min-h-[60vh] flex items-center justify-center">
        <div class="w-full max-w-md mx-auto px-6" x-data="{
            roleTab: '{{ request('role', 'customer') }}',
            fillCredentials(email, pass) {
                this.$refs.emailInput.value = email;
                this.$refs.passInput.value = pass;
            }
        }">
            
            <div class="bg-white border border-neutral-200 p-8 md:p-10 shadow-lg space-y-6">
                
                <div class="text-center space-y-1">
                    <div class="text-2xl font-bold uppercase tracking-widest3 font-sans">{{ \App\Models\SiteSetting::get('company_name', 'BENGKEL') }}</div>
                    <div class="eyebrow text-[10px] text-neutral-400">Pilih Role Akses Demo</div>
                </div>

                <!-- 3 Role Selector Tabs (Akun Demo) -->
                <div class="grid grid-cols-3 border border-neutral-200 text-[11px] uppercase tracking-wider font-semibold text-center">
                    <button type="button" @click="roleTab = 'customer'; fillCredentials('democustomer@bengkel.com', 'democustomer123')"
                            class="py-2.5 transition-colors"
                            :class="roleTab === 'customer' ? 'bg-black text-white' : 'bg-neutral-50 text-neutral-500 hover:text-black'">
                        Customer
                    </button>
                    <button type="button" @click="roleTab = 'karyawan'; fillCredentials('demomekanik@bengkel.com', 'demomekanik123')"
                            class="py-2.5 transition-colors border-x border-neutral-200"
                            :class="roleTab === 'karyawan' ? 'bg-black text-white' : 'bg-neutral-50 text-neutral-500 hover:text-black'">
                        Karyawan
                    </button>
                    <button type="button" @click="roleTab = 'admin'; fillCredentials('demoadmin@bengkel.com', 'demoadmin123')"
                            class="py-2.5 transition-colors"
                            :class="roleTab === 'admin' ? 'bg-black text-white' : 'bg-neutral-50 text-neutral-500 hover:text-black'">
                        Admin
                    </button>
                </div>

                <!-- Quick Demo Helper Note -->
                <div class="p-3 bg-neutral-bg border border-neutral-200 text-[11px] text-neutral-600 space-y-2">
                    <div class="font-bold text-black flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Akun Demo Cepat:
                        </span>
                        <span class="text-[9px] uppercase tracking-wider text-accent font-semibold" x-text="roleTab"></span>
                    </div>
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="font-medium text-black" x-text="roleTab === 'admin' ? 'demoadmin@bengkel.com' : (roleTab === 'karyawan' ? 'demomekanik@bengkel.com' : 'democustomer@bengkel.com')"></span>
                        <span class="text-neutral-500 font-mono bg-white px-1.5 py-0.5 border border-neutral-200" x-text="roleTab === 'admin' ? 'demoadmin123' : (roleTab === 'karyawan' ? 'demomekanik123' : 'democustomer123')"></span>
                    </div>
                    <div class="pt-1.5 border-t border-neutral-200/70 flex items-start gap-1.5 text-[9px] text-neutral-500 leading-tight">
                        <svg class="w-3.5 h-3.5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span><strong>Mode Demo:</strong> Semua perubahan dan data baru akan otomatis dihapus / kembali semula setiap 5 menit.</span>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Email Address</label>
                        <input type="email" name="email" x-ref="emailInput" required value="{{ old('email', 'democustomer@bengkel.com') }}"
                               placeholder="email@domain.com"
                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                        @error('email')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-[11px] uppercase tracking-wider font-semibold text-black">Password</label>
                        </div>
                        <input type="password" name="password" x-ref="passInput" required value="democustomer123"
                               placeholder="••••••••"
                               class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3 focus:outline-none focus:border-black transition-colors">
                    </div>

                    <div class="flex items-center justify-between text-xs text-neutral-600 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="accent-black">
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-dark w-full">
                            Masuk ke Akun &rarr;
                        </button>
                    </div>
                </form>

                <div class="pt-4 border-t border-neutral-200 text-center text-xs text-neutral-500 space-y-2">
                    <div>
                        Belum punya akun customer?
                        <a href="{{ route('register') }}" class="font-bold text-black underline hover:text-accent">Daftar Akun Baru</a>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
