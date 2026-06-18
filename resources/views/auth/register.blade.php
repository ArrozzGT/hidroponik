<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPSH') }} — Daftar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .step-circle {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 15px;
            transition: all .3s ease;
        }
        .step-line {
            flex: 1; height: 4px; border-radius: 2px;
            margin: 0 8px; transition: all .3s ease;
        }
        .role-card {
            border-radius: 16px; border: 2px solid #e5e7eb;
            padding: 24px; cursor: pointer;
            transition: all .2s ease;
        }
        .role-card:hover { border-color: #86efac; }
        .role-card.active { border-color: #16a34a; background: #f0fdf4; }
    </style>
</head>
<body>
    <main>
        <div class="min-h-screen bg-gradient-to-br from-green-600 via-green-500 to-emerald-500 flex items-center justify-center p-8 relative overflow-hidden">
            {{-- Floating leaves --}}
            <i data-lucide="leaf" class="absolute pointer-events-none z-[1] text-white/10 animate-[leafFloat_12s_ease-in-out_infinite]" style="top:8%;left:4%;font-size:2.8rem;" aria-hidden="true"></i>
            <i data-lucide="leaf" class="absolute pointer-events-none z-[1] text-white/10 animate-[leafFloat_12s_ease-in-out_infinite]" style="top:22%;right:6%;font-size:2rem;animation-delay:-4s;" aria-hidden="true"></i>
            <i data-lucide="sprout" class="absolute pointer-events-none z-[1] text-white/10 animate-[leafFloat_12s_ease-in-out_infinite]" style="bottom:12%;left:10%;font-size:2.4rem;animation-delay:-7s;" aria-hidden="true"></i>
            <i data-lucide="leaf" class="absolute pointer-events-none z-[1] text-white/10 animate-[leafFloat_12s_ease-in-out_infinite]" style="bottom:28%;right:4%;font-size:1.6rem;animation-delay:-10s;" aria-hidden="true"></i>

            <div class="max-w-[580px] w-full relative z-10" x-data="registerForm()" x-cloak>
                {{-- Header --}}
                <div class="text-center mb-6">
                    <a href="/" class="inline-flex items-center gap-2.5 no-underline mb-4">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                            <i data-lucide="leaf" class="w-7 h-7 text-white" aria-hidden="true"></i>
                        </div>
                        <div class="text-left">
                            <span class="text-2xl font-extrabold text-white">{{ config('app.name', 'SIPSH') }}</span>
                            <p class="text-[11px] text-white/70 -mt-0.5">Sayuran Hidroponik</p>
                        </div>
                    </a>
                    <h1 class="text-[28px] font-extrabold text-white mb-1">Daftar Akun Baru</h1>
                    <p class="text-sm text-white/80">Bergabunglah dengan ribuan pengguna lainnya</p>
                </div>

                {{-- Progress stepper --}}
                <div class="flex items-center justify-center mb-7">
                    <template x-for="(s, i) in steps" :key="i">
                        <div class="flex items-center">
                            <div x-text="i + 1"
                                :class="step >= i + 1 ? 'step-circle bg-white text-green-600 shadow-lg' : 'step-circle bg-white/20 text-white'"
                            ></div>
                            <div x-show="i < steps.length - 1"
                                :class="step > i + 1 ? 'step-line bg-white' : 'step-line bg-white/20'"
                            ></div>
                        </div>
                    </template>
                </div>

                {{-- Card --}}
                <div class="bg-white/95 backdrop-blur-lg rounded-3xl p-9 shadow-[0_30px_80px_rgba(0,0,0,.25)] border border-white/30">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="role" x-model="role">

                        {{-- Step 1: Role Selection --}}
                        <div x-show="step === 1">
                            <h2 class="text-[22px] font-extrabold text-green-900 mb-1">Pilih Tipe Akun</h2>
                            <p class="text-sm text-gray-500 mb-6">Silakan pilih tipe akun Anda</p>

                            <div class="flex flex-col gap-4">
                                {{-- Pembeli --}}
                                <div @click="role = 'pembeli'" :class="role === 'pembeli' ? 'role-card active' : 'role-card'">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                            <i data-lucide="user" class="w-6 h-6 text-green-600" aria-hidden="true"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-green-900 text-base">Pembeli</p>
                                            <p class="text-xs text-gray-500">Saya ingin membeli sayuran</p>
                                            <p class="text-[11px] text-gray-400 mt-1">Bergabung sebagai pembeli untuk mendapatkan akses ke berbagai sayuran hidroponik segar berkualitas premium.</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Petani --}}
                                <div @click="role = 'petani'" :class="role === 'petani' ? 'role-card active' : 'role-card'">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                            <i data-lucide="leaf" class="w-6 h-6 text-green-600" aria-hidden="true"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-green-900 text-base">Petani</p>
                                            <p class="text-xs text-gray-500">Saya ingin menjual sayuran</p>
                                            <p class="text-[11px] text-gray-400 mt-1">Daftar sebagai petani untuk mulai menjual produk hidroponik Anda dan jangkau lebih banyak pelanggan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-7">
                                <button type="button" @click="nextStep()"
                                    class="w-full py-3.5 bg-green-600 text-white text-sm font-bold border-none rounded-xl cursor-pointer flex items-center justify-center gap-2 shadow-[0_4px_14px_rgba(22,163,74,.3)] hover:bg-green-700 hover:shadow-[0_6px_20px_rgba(22,163,74,.4)] transition-all">
                                    Lanjutkan
                                    <i data-lucide="arrow-right" class="w-4.5 h-4.5" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Step 2: Personal Info --}}
                        <div x-show="step === 2">
                            <h2 class="text-[22px] font-extrabold text-green-900 mb-1">Informasi Pribadi</h2>
                            <p class="text-sm text-gray-500 mb-6">Lengkapi data pribadi Anda</p>

                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <div class="relative mt-1.5">
                                    <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                    <x-text-input id="name" type="text" name="name" x-model="name" required placeholder="Nama lengkap Anda" class="w-full pl-11" />
                                </div>
                                @error('name') <x-input-error :messages="$errors->get('name')" class="mt-1" /> @enderror
                            </div>

                            <div class="mb-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <div class="relative mt-1.5">
                                    <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                    <x-text-input id="email" type="email" name="email" x-model="email" required autocomplete="username" placeholder="nama@example.com" class="w-full pl-11" />
                                </div>
                                @error('email') <x-input-error :messages="$errors->get('email')" class="mt-1" /> @enderror
                            </div>

                            <div class="mb-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <div class="relative mt-1.5">
                                    <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                    <x-text-input id="password" type="password" name="password" x-model="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="w-full pl-11" />
                                </div>
                                @error('password') <x-input-error :messages="$errors->get('password')" class="mt-1" /> @enderror
                            </div>

                            <div class="mb-4">
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <div class="relative mt-1.5">
                                    <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" x-model="passwordConfirmation" required autocomplete="new-password" placeholder="Ulangi password" class="w-full pl-11" />
                                </div>
                            </div>

                            <div class="flex gap-3 mt-6">
                                <button type="button" @click="prevStep()"
                                    class="flex-1 py-3.5 bg-white text-green-600 text-sm font-bold border-2 border-green-600 rounded-xl cursor-pointer flex items-center justify-center gap-2 hover:bg-green-50 transition-all">
                                    <i data-lucide="arrow-left" class="w-4.5 h-4.5" aria-hidden="true"></i>
                                    Kembali
                                </button>
                                <button type="button" @click="nextStep()"
                                    class="flex-1 py-3.5 bg-green-600 text-white text-sm font-bold border-none rounded-xl cursor-pointer flex items-center justify-center gap-2 shadow-[0_4px_14px_rgba(22,163,74,.3)] hover:bg-green-700 hover:shadow-[0_6px_20px_rgba(22,163,74,.4)] transition-all">
                                    Lanjutkan
                                    <i data-lucide="arrow-right" class="w-4.5 h-4.5" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Step 3: Additional Info --}}
                        <div x-show="step === 3">
                            <h2 class="text-[22px] font-extrabold text-green-900 mb-1">Informasi Tambahan</h2>
                            <p class="text-sm text-gray-500 mb-6">Beberapa informasi tambahan</p>

                            <div class="mb-4">
                                <x-input-label for="no_hp" :value="__('Nomor Telepon')" />
                                <div class="relative mt-1.5">
                                    <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                    <x-text-input id="no_hp" type="text" name="no_hp" x-model="noHp" required placeholder="+62 812-3456-7890" class="w-full pl-11" />
                                </div>
                                @error('no_hp') <x-input-error :messages="$errors->get('no_hp')" class="mt-1" /> @enderror
                            </div>

                            <div class="mb-4">
                                <x-input-label for="lokasi_kebun" :value="__('Alamat')" />
                                <div class="relative mt-1.5">
                                    <i data-lucide="map-pin" class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                    <textarea id="lokasi_kebun" name="lokasi_kebun" x-model="lokasi" rows="3" placeholder="Jl. Contoh No. 123, Jakarta"
                                        class="w-full pl-11 form-input min-h-[80px] resize-none"></textarea>
                                </div>
                            </div>

                            {{-- Petani-only fields --}}
                            <div x-show="role === 'petani'" class="mb-4">
                                <x-input-label for="nama_kebun" :value="__('Nama Kebun/Usaha')" />
                                <div class="relative mt-1.5">
                                    <i data-lucide="leaf" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" aria-hidden="true"></i>
                                    <x-text-input id="nama_kebun" type="text" name="nama_kebun" x-model="namaKebun" placeholder="Kebun Hijau Farm" class="w-full pl-11" />
                                </div>
                                @error('nama_kebun') <x-input-error :messages="$errors->get('nama_kebun')" class="mt-1" /> @enderror
                            </div>

                            <div x-show="role === 'petani'" class="mb-4">
                                <x-input-label for="deskripsi_kebun" :value="__('Deskripsi Usaha')" />
                                <textarea id="deskripsi_kebun" name="deskripsi_kebun" x-model="deskripsiKebun" rows="3" placeholder="Ceritakan tentang kebun hidroponik Anda..."
                                    class="w-full form-input min-h-[80px] resize-none"></textarea>
                            </div>

                            {{-- Notice --}}
                            <div class="bg-green-50 rounded-xl p-4 mb-6">
                                <p class="font-semibold text-xs text-green-900 mb-1">📋 Perhatian</p>
                                <p class="text-[11px] text-gray-500">
                                    Dengan mendaftar, Anda menyetujui <a href="#" class="text-green-600 font-semibold no-underline">Syarat & Ketentuan</a> serta <a href="#" class="text-green-600 font-semibold no-underline">Kebijakan Privasi</a> kami.
                                </p>
                            </div>

                            <div class="flex gap-3">
                                <button type="button" @click="prevStep()"
                                    class="flex-1 py-3.5 bg-white text-green-600 text-sm font-bold border-2 border-green-600 rounded-xl cursor-pointer flex items-center justify-center gap-2 hover:bg-green-50 transition-all">
                                    <i data-lucide="arrow-left" class="w-4.5 h-4.5" aria-hidden="true"></i>
                                    Kembali
                                </button>
                                <button type="submit"
                                    class="flex-1 py-3.5 bg-green-600 text-white text-sm font-bold border-none rounded-xl cursor-pointer flex items-center justify-center gap-2 shadow-[0_4px_14px_rgba(22,163,74,.3)] hover:bg-green-700 hover:shadow-[0_6px_20px_rgba(22,163,74,.4)] transition-all">
                                    Daftar Sekarang
                                    <i data-lucide="arrow-right" class="w-4.5 h-4.5" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Login link --}}
                    <div class="mt-5 pt-4 border-t border-gray-200 text-center">
                        <p class="text-xs text-gray-500">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-bold text-green-600 no-underline hover:text-green-700 transition-colors">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function registerForm() {
            return {
                step: 1,
                steps: ['Pilih Tipe Akun', 'Informasi Pribadi', 'Informasi Tambahan'],
                role: 'pembeli',
                name: '{{ old('name') }}',
                email: '{{ old('email') }}',
                password: '',
                passwordConfirmation: '',
                noHp: '{{ old('no_hp') }}',
                lokasi: '{{ old('lokasi_kebun') }}',
                namaKebun: '{{ old('nama_kebun') }}',
                deskripsiKebun: '{{ old('deskripsi_kebun') }}',
                nextStep() {
                    if (this.step < 3) this.step++;
                },
                prevStep() {
                    if (this.step > 1) this.step--;
                }
            };
        }
    </script>
</body>
</html>