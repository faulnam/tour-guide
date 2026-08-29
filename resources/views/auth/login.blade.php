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
        <div class="w-full max-w-lg mx-auto px-6" x-data="{
            loginType: '{{ request('type', 'demo') }}', // 'demo' or 'real'
            roleTab: '{{ request('role', 'customer') }}', // 'customer', 'karyawan', 'admin'
            
            selectDemoRole(role) {
                this.roleTab = role;
                if (role === 'customer') {
                    this.fillCredentials('democustomer@tourguide.id', 'democustomer123');
                } else if (role === 'karyawan') {
                    this.fillCredentials('demoguide@tourguide.id', 'demoguide123');
                } else if (role === 'admin') {
                    this.fillCredentials('demoadmin@tourguide.id', 'demoadmin123');
                }
            },

            switchToReal() {
                this.loginType = 'real';
                this.$refs.emailInput.value = '';
                this.$refs.passInput.value = '';
            },

            switchToDemo() {
                this.loginType = 'demo';
                this.selectDemoRole(this.roleTab);
            },

            fillCredentials(email, pass) {
                this.$refs.emailInput.value = email;
                this.$refs.passInput.value = pass;
            }
        }">
            
            <div class="tour-card p-8 md:p-10 shadow-elevated space-y-6 bg-white">
                
                <div class="text-center space-y-1">
                    <div class="text-xl font-bold uppercase tracking-wider font-sans text-primary">{{ \App\Models\SiteSetting::get('company_name', 'NUSANTARA TOUR GUIDE') }}</div>
                    <p class="text-xs text-gray-500">Silakan pilih mode login di bawah ini</p>
                </div>

                <!-- Main Login Type Toggle (Akun Demo vs Akun Asli) -->
                <div class="grid grid-cols-2 p-1 bg-[#F8FAF9] rounded-2xl border border-gray-200 text-xs font-bold uppercase tracking-wider">
                    <button type="button" 
                            @click="switchToDemo()"
                            class="py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2"
                            :class="loginType === 'demo' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:text-primary'">
                        <i class="fa-solid fa-flask text-xs" :class="loginType === 'demo' ? 'text-accent' : ''"></i>
                        <span>Akun Demo (Uji Coba)</span>
                    </button>

                    <button type="button" 
                            @click="switchToReal()"
                            class="py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2"
                            :class="loginType === 'real' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:text-primary'">
                        <i class="fa-solid fa-lock text-xs" :class="loginType === 'real' ? 'text-accent' : ''"></i>
                        <span>Login Akun Resmi</span>
                    </button>
                </div>

                <!-- DEMO MODE SECTION -->
                <div x-show="loginType === 'demo'" x-transition x-cloak class="space-y-4">
                    
                    <!-- 3 Role Selector Tabs (Akun Demo) -->
                    <div class="grid grid-cols-3 rounded-xl border border-gray-200 text-[11px] uppercase tracking-wider font-bold text-center overflow-hidden">
                        <button type="button" @click="selectDemoRole('customer')"
                                class="py-2.5 transition-colors flex items-center justify-center gap-1.5"
                                :class="roleTab === 'customer' ? 'bg-secondary text-white' : 'bg-gray-50 text-gray-600 hover:text-primary'">
                            <i class="fa-solid fa-user text-[10px]"></i>
                            <span>Traveler</span>
                        </button>
                        <button type="button" @click="selectDemoRole('karyawan')"
                                class="py-2.5 transition-colors border-x border-gray-200 flex items-center justify-center gap-1.5"
                                :class="roleTab === 'karyawan' ? 'bg-secondary text-white' : 'bg-gray-50 text-gray-600 hover:text-primary'">
                            <i class="fa-solid fa-compass text-[10px]"></i>
                            <span>Pemandu</span>
                        </button>
                        <button type="button" @click="selectDemoRole('admin')"
                                class="py-2.5 transition-colors flex items-center justify-center gap-1.5"
                                :class="roleTab === 'admin' ? 'bg-secondary text-white' : 'bg-gray-50 text-gray-600 hover:text-primary'">
                            <i class="fa-solid fa-shield-halved text-[10px]"></i>
                            <span>Admin</span>
                        </button>
                    </div>

                    <!-- 25-Minute Auto Reset Info Banner -->
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 text-xs text-amber-900 space-y-2">
                        <div class="font-bold flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <span class="inline-block w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Akun Demo Aktif:</span>
                            </span>
                            <span class="text-[10px] uppercase font-bold text-amber-800 bg-amber-200/80 px-2 py-0.5 rounded-full" 
                                  x-text="roleTab === 'customer' ? 'Role Traveler' : (roleTab === 'karyawan' ? 'Role Guide' : 'Role Admin')"></span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] bg-white p-2 rounded-xl border border-amber-200/60 font-mono">
                            <span class="font-bold text-primary" x-text="roleTab === 'admin' ? 'demoadmin@tourguide.id' : (roleTab === 'karyawan' ? 'demoguide@tourguide.id' : 'democustomer@tourguide.id')"></span>
                            <span class="text-gray-600" x-text="roleTab === 'admin' ? 'demoadmin123' : (roleTab === 'karyawan' ? 'demoguide123' : 'democustomer123')"></span>
                        </div>
                        <div class="pt-1 flex items-start gap-2 text-[10px] text-amber-800 leading-snug">
                            <i class="fa-solid fa-clock-rotate-left text-amber-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>Pembersihan Otomatis (25 Menit):</strong> Setiap data atau konten yang Anda buat/edit di sesi demo ini akan otomatis direset kembali ke keadaan awal setelah 25 menit.</span>
                        </div>
                    </div>

                </div>

                <!-- REAL ACCOUNT MODE SECTION -->
                <div x-show="loginType === 'real'" x-transition x-cloak class="space-y-4">
                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 text-xs text-emerald-900 space-y-1">
                        <div class="font-bold flex items-center gap-2 text-emerald-950">
                            <i class="fa-solid fa-shield-check text-emerald-600 text-sm"></i>
                            <span>Mode Akun Resmi (Permanen)</span>
                        </div>
                        <p class="text-[11px] text-emerald-800 leading-relaxed">
                            Masukkan email dan password terdaftar Anda. Seluruh riwayat reservasi, transaksi, dan data profil Anda akan tersimpan secara permanen.
                        </p>
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
