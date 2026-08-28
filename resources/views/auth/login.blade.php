@extends('layouts.app')

@section('meta_title', 'Login Portal — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Garage'))

@section('content')

    <section class="py-28 md:py-36 bg-neutral-bg min-h-[85vh] flex items-center justify-center">
        <div class="w-full max-w-md mx-auto px-6" x-data="{
            roleTab: '{{ request('role', 'customer') }}',
            fillCredentials(email, pass) {
                this.$refs.emailInput.value = email;
                this.$refs.passInput.value = pass;
            }
        }">
            
            <div class="bg-white border border-neutral-200 p-8 md:p-10 shadow-sm space-y-6">
                
                <div class="text-center space-y-2">
                    <div class="text-2xl font-bold uppercase tracking-widest3 font-sans">METRIX</div>
                    <div class="eyebrow text-[10px] text-neutral-400">Portal Akses Akun</div>
                </div>

                <!-- 3 Role Selector Tabs -->
                <div class="grid grid-cols-3 border border-neutral-200 text-[11px] uppercase tracking-wider font-semibold text-center">
                    <button type="button" @click="roleTab = 'customer'; fillCredentials('customer@metrixgarage.com', 'password')"
                            class="py-2.5 transition-colors"
                            :class="roleTab === 'customer' ? 'bg-black text-white' : 'bg-neutral-50 text-neutral-500 hover:text-black'">
                        Customer
                    </button>
                    <button type="button" @click="roleTab = 'karyawan'; fillCredentials('karyawan@metrixgarage.com', 'password')"
                            class="py-2.5 transition-colors border-x border-neutral-200"
                            :class="roleTab === 'karyawan' ? 'bg-black text-white' : 'bg-neutral-50 text-neutral-500 hover:text-black'">
                        Karyawan
                    </button>
                    <button type="button" @click="roleTab = 'admin'; fillCredentials('admin@metrixgarage.com', 'password')"
                            class="py-2.5 transition-colors"
                            :class="roleTab === 'admin' ? 'bg-black text-white' : 'bg-neutral-50 text-neutral-500 hover:text-black'">
                        Admin
                    </button>
                </div>

                <!-- Quick Demo Helper Note -->
                <div class="p-3 bg-neutral-bg border border-neutral-200 text-[11px] text-neutral-600 space-y-1">
                    <div class="font-bold text-black flex items-center justify-between">
                        <span>Akun Demo Cepat:</span>
                        <span class="text-[9px] uppercase tracking-wider text-accent font-semibold" x-text="roleTab"></span>
                    </div>
                    <div class="flex items-center justify-between text-[10px]">
                        <span x-text="roleTab === 'admin' ? 'admin@metrixgarage.com' : (roleTab === 'karyawan' ? 'karyawan@metrixgarage.com' : 'customer@metrixgarage.com')"></span>
                        <span class="text-neutral-400">password: password</span>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-1">Email Address</label>
                        <input type="email" name="email" x-ref="emailInput" required value="{{ old('email', 'customer@metrixgarage.com') }}"
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
                        <input type="password" name="password" x-ref="passInput" required value="password"
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
