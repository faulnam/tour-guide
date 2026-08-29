@extends('layouts.app')

@section('meta_title', 'Login Portal — ' . \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide'))

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-primary-dark text-white pt-28 pb-12 md:pt-36 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/95 via-primary-dark/50 to-primary-dark/90"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-5 text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white uppercase font-sans">
                Portal Login
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm max-w-md mx-auto">
                Akses Portal Traveler, Pemandu Wisata (Guide), dan Admin CMS {{ \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide') }}.
            </p>
        </div>
    </section>

    <!-- Login Form Section -->
    <section class="py-16 md:py-24 bg-[#F8FAF9] min-h-[60vh] flex items-center justify-center">
        <div class="w-full max-w-md mx-auto px-6" x-data="{
            roleTab: '{{ request('role', 'customer') }}',
            fillCredentials(email, pass) {
                this.$refs.emailInput.value = email;
                this.$refs.passInput.value = pass;
            }
        }">
            
            <div class="tour-card p-8 md:p-10 shadow-elevated space-y-6 bg-white">
                
                <div class="text-center space-y-1">
                    <div class="text-xl font-bold uppercase tracking-wider font-sans text-primary">{{ \App\Models\SiteSetting::get('company_name', 'NUSANTARA TOUR GUIDE') }}</div>
                    <div class="eyebrow text-[10px] text-sage font-bold">Pilih Akun Demo Cepat</div>
                </div>

                <!-- 3 Role Selector Tabs (Akun Demo) -->
                <div class="grid grid-cols-3 rounded-xl border border-gray-200 text-[11px] uppercase tracking-wider font-bold text-center overflow-hidden">
                    <button type="button" @click="roleTab = 'customer'; fillCredentials('democustomer@tourguide.id', 'democustomer123')"
                            class="py-2.5 transition-colors"
                            :class="roleTab === 'customer' ? 'bg-primary text-white' : 'bg-gray-50 text-gray-600 hover:text-primary'">
                        Traveler
                    </button>
                    <button type="button" @click="roleTab = 'karyawan'; fillCredentials('demoguide@tourguide.id', 'demoguide123')"
                            class="py-2.5 transition-colors border-x border-gray-200"
                            :class="roleTab === 'karyawan' ? 'bg-primary text-white' : 'bg-gray-50 text-gray-600 hover:text-primary'">
                        Pemandu
                    </button>
                    <button type="button" @click="roleTab = 'admin'; fillCredentials('demoadmin@tourguide.id', 'demoadmin123')"
                            class="py-2.5 transition-colors"
                            :class="roleTab === 'admin' ? 'bg-primary text-white' : 'bg-gray-50 text-gray-600 hover:text-primary'">
                        Admin
                    </button>
                </div>

                <!-- Quick Demo Helper Note -->
                <div class="p-3.5 bg-[#F8FAF9] rounded-xl border border-gray-200 text-[11px] text-gray-600 space-y-2">
                    <div class="font-bold text-primary flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Akun Demo Cepat:
                        </span>
                        <span class="text-[9px] uppercase tracking-wider text-sage font-bold" x-text="roleTab === 'customer' ? 'Traveler' : (roleTab === 'karyawan' ? 'Pemandu Guide' : 'Administrator')"></span>
                    </div>
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="font-medium text-primary" x-text="roleTab === 'admin' ? 'demoadmin@tourguide.id' : (roleTab === 'karyawan' ? 'demoguide@tourguide.id' : 'democustomer@tourguide.id')"></span>
                        <span class="text-gray-600 font-mono bg-white px-2 py-0.5 rounded border border-gray-200" x-text="roleTab === 'admin' ? 'demoadmin123' : (roleTab === 'karyawan' ? 'demoguide123' : 'democustomer123')"></span>
                    </div>
                    <div class="pt-1.5 border-t border-gray-200/70 flex items-start gap-1.5 text-[9px] text-gray-500 leading-tight">
                        <i class="fa-solid fa-circle-info text-amber-600 text-[10px] mt-0.5"></i>
                        <span><strong>Mode Demo:</strong> Database aman &amp; Anda dapat mencoba simulasi seluruh fitur di 3 role.</span>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-primary mb-1">Email Address</label>
                        <input type="email" name="email" x-ref="emailInput" required value="{{ old('email', 'democustomer@tourguide.id') }}"
                               placeholder="email@domain.com"
                               class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        @error('email')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-primary">Password</label>
                        </div>
                        <input type="password" name="password" x-ref="passInput" required value="democustomer123"
                               placeholder="Password Anda"
                               class="w-full bg-[#F8FAF9] border border-gray-200 text-gray-800 text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-primary transition-colors">
                        @error('password')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2">
                            <span>Masuk ke Portal &rarr;</span>
                        </button>
                    </div>
                </form>

                <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                    Belum punya akun traveler?
                    <a href="{{ route('register') }}" class="font-bold text-primary underline hover:text-sage">Daftar Akun Baru</a>
                </div>

            </div>

        </div>
    </section>

@endsection
