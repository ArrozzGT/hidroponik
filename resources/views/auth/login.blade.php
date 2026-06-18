<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPSH') }} — Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main>
        <div class="min-h-screen bg-gradient-to-br from-green-600 via-green-500 to-emerald-500 flex items-center justify-center p-4 relative overflow-hidden">
            {{-- Floating leaves --}}
            <i data-lucide="leaf" class="absolute pointer-events-none z-[1] text-white/10 animate-[leafFloat_12s_ease-in-out_infinite]" style="top:10%;left:5%;font-size:2.5rem;" aria-hidden="true"></i>
            <i data-lucide="leaf" class="absolute pointer-events-none z-[1] text-white/10 animate-[leafFloat_12s_ease-in-out_infinite]" style="top:20%;right:8%;font-size:2rem;animation-delay:-3s;" aria-hidden="true"></i>
            <i data-lucide="sprout" class="absolute pointer-events-none z-[1] text-white/10 animate-[leafFloat_12s_ease-in-out_infinite]" style="bottom:15%;left:12%;font-size:2.2rem;animation-delay:-6s;" aria-hidden="true"></i>
            <i data-lucide="leaf" class="absolute pointer-events-none z-[1] text-white/10 animate-[leafFloat_12s_ease-in-out_infinite]" style="bottom:25%;right:5%;font-size:1.8rem;animation-delay:-9s;" aria-hidden="true"></i>

            <div class="max-w-[1100px] w-full relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    {{-- Left: Branding --}}
                    <div class="hidden lg:block">
                        <a href="/" class="inline-flex items-center gap-3 no-underline mb-8">
                            <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center">
                                <i data-lucide="leaf" class="w-8 h-8 text-white" aria-hidden="true"></i>
                            </div>
                            <div>
                                <span class="text-[28px] font-extrabold text-white">{{ config('app.name', 'SIPSH') }}</span>
                                <p class="text-xs text-white/70 -mt-0.5">Sayuran Hidroponik</p>
                            </div>
                        </a>

                        <h1 class="text-5xl font-extrabold text-white mb-6 leading-tight">
                            Selamat Datang<br>Kembali!
                        </h1>

                        <p class="text-lg text-white/85 mb-8">
                            Masuk ke akun Anda untuk melanjutkan berbelanja sayuran segar dan organik
                        </p>

                        <div class="flex flex-col gap-4 text-white">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center shrink-0 mt-0.5 text-xs">✓</div>
                                <div>
                                    <p class="font-semibold">100% Segar & Organik</p>
                                    <p class="text-xs text-white/70">Sayuran hidroponik berkualitas premium</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center shrink-0 mt-0.5 text-xs">✓</div>
                                <div>
                                    <p class="font-semibold">Pengiriman Cepat</p>
                                    <p class="text-xs text-white/70">Same-day delivery untuk area tertentu</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center shrink-0 mt-0.5 text-xs">✓</div>
                                <div>
                                    <p class="font-semibold">Harga Terbaik</p>
                                    <p class="text-xs text-white/70">Langsung dari petani ke rumah Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Login Form --}}
                    <div class="max-w-[440px] w-full mx-auto">
                        <div class="bg-white/95 backdrop-blur-lg rounded-3xl p-9 shadow-[0_30px_80px_rgba(0,0,0,.25)] border border-white/30">
                            {{-- Mobile logo --}}
                            <div class="lg:hidden flex items-center gap-2.5 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-600 to-emerald-500 flex items-center justify-center">
                                    <i data-lucide="leaf" class="w-5.5 h-5.5 text-white" aria-hidden="true"></i>
                                </div>
                                <span class="text-[22px] font-extrabold text-green-900">{{ config('app.name', 'SIPSH') }}</span>
                            </div>

                            <h2 class="text-2xl font-extrabold text-green-900 mb-1">Masuk ke Akun</h2>
                            <p class="text-sm text-gray-500 mb-6">Masukkan email dan password untuk melanjutkan</p>

                            <x-auth-session-status :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <div class="relative mt-1.5">
                                        <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@example.com" class="w-full pl-11" />
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="password" :value="__('Password')" />
                                    <div class="relative mt-1.5">
                                        <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                        <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full pl-11" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                                </div>

                                <div class="flex items-center justify-between mb-5">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="remember" id="remember_me" class="w-4.5 h-4.5 rounded border-green-500 text-green-600 focus:ring-green-500 cursor-pointer">
                                        <span class="text-sm text-gray-600">Ingat saya</span>
                                    </label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-green-600 no-underline hover:text-green-700 transition-colors">
                                            Lupa password?
                                        </a>
                                    @endif
                                </div>

                                <x-primary-button class="w-full justify-center py-3.5 shadow-[0_4px_14px_rgba(22,163,74,.3)] hover:shadow-[0_6px_20px_rgba(22,163,74,.4)]">
                                    Masuk
                                    <i data-lucide="arrow-right" class="w-4.5 h-4.5" aria-hidden="true"></i>
                                </x-primary-button>
                            </form>

                            {{-- Social divider --}}
                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="px-3 bg-white text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Atau lanjutkan dengan</span>
                                </div>
                            </div>

                            {{-- Social buttons --}}
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" onclick="alert('Google login akan segera tersedia.')" class="flex items-center justify-center gap-2 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-semibold text-gray-700 cursor-pointer transition-all hover:bg-green-50 hover:border-green-200">
                                    <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                                    Google
                                </button>
                                <button type="button" onclick="alert('Facebook login akan segera tersedia.')" class="flex items-center justify-center gap-2 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-semibold text-gray-700 cursor-pointer transition-all hover:bg-green-50 hover:border-green-200">
                                    <svg width="18" height="18" fill="#1877F2" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    Facebook
                                </button>
                            </div>

                            {{-- Register link --}}
                            <div class="mt-5 pt-5 border-t border-gray-200 text-center">
                                <p class="text-xs text-gray-500">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}" class="font-bold text-green-600 no-underline hover:text-green-700 transition-colors">Daftar Sekarang</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>