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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .reg-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #16a34a, #22c55e, #10b981);
            display: flex; align-items: center; justify-content: center;
            padding: 32px 16px; position: relative; overflow: hidden;
        }
        .reg-bg::before {
            content: ''; position: absolute; inset: 0;
            background-image: linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        @keyframes float {
            0%,100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-18px) rotate(5deg); }
            66% { transform: translateY(-8px) rotate(-3deg); }
        }
        .leaf-deco {
            position: absolute; pointer-events: none; z-index: 1;
            color: rgba(255,255,255,.08);
            animation: float 12s ease-in-out infinite;
        }
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
        [x-cloak] { display: none !important; }
        .role-card {
            border-radius: 16px; border: 2px solid #e5e7eb;
            padding: 24px; cursor: pointer;
            transition: all .2s ease;
            display: flex; align-items: flex-start; gap: 16px;
        }
        .role-card:hover { border-color: #86efac; }
        .role-card.active { border-color: #16a34a; background: #f0fdf4; }
    </style>
</head>
<body>
    <main>
    <div class="reg-bg">
        <i data-lucide="leaf" class="leaf-deco" style="top:8%;left:4%;font-size:2.8rem;animation-delay:0s;" aria-hidden="true"></i>
        <i data-lucide="leaf" class="leaf-deco" style="top:22%;right:6%;font-size:2rem;animation-delay:-4s;" aria-hidden="true"></i>
        <i data-lucide="sprout" class="leaf-deco" style="bottom:12%;left:10%;font-size:2.4rem;animation-delay:-7s;" aria-hidden="true"></i>
        <i data-lucide="leaf" class="leaf-deco" style="bottom:28%;right:4%;font-size:1.6rem;animation-delay:-10s;" aria-hidden="true"></i>

        <div style="max-width:580px;width:100%;position:relative;z-index:10;" x-data="registerForm()" x-cloak>
            {{-- Header --}}
            <div style="text-align:center;margin-bottom:24px;">
                <a href="/" style="display:inline-flex;align-items:center;gap:10px;text-decoration:none;margin-bottom:16px;">
                    <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,.2);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;">
                        <i data-lucide="leaf" style="width:28px;height:28px;color:#fff;" aria-hidden="true"></i>
                    </div>
                    <div style="text-align:left;">
                        <span style="font-size:24px;font-weight:800;color:#fff;">{{ config('app.name', 'SIPSH') }}</span>
                        <p style="font-size:11px;color:rgba(255,255,255,.7);margin-top:-1px;">Sayuran Hidroponik</p>
                    </div>
                </a>
                <h1 style="font-size:28px;font-weight:800;color:#fff;margin-bottom:4px;">Daftar Akun Baru</h1>
                <p style="font-size:14px;color:rgba(255,255,255,.8);">Bergabunglah dengan ribuan pengguna lainnya</p>
            </div>

            {{-- Progress --}}
            <div style="display:flex;align-items:center;justify-content:center;margin-bottom:28px;">
                <template x-for="(s, i) in steps" :key="i">
                    <div style="display:flex;align-items:center;">
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
            <div style="background:rgba(255,255,255,.95);backdrop-filter:blur(12px);border-radius:24px;padding:36px 32px;box-shadow:0 30px 80px rgba(0,0,0,.25);border:1px solid rgba(255,255,255,.3);">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="role" x-model="role">

                    {{-- Step 1: Role Selection --}}
                    <div x-show="step === 1">
                        <h2 style="font-size:22px;font-weight:800;color:#14532d;margin-bottom:4px;">Pilih Tipe Akun</h2>
                        <p style="font-size:14px;color:#6b7280;margin-bottom:24px;">Silakan pilih tipe akun Anda</p>

                        <div style="display:flex;flex-direction:column;gap:16px;">
                            {{-- Pembeli --}}
                            <div @click="role = 'pembeli'" :class="role === 'pembeli' ? 'role-card active' : 'role-card'">
                                <div style="display:flex;align-items:center;gap:12px;width:100%;">
                                    <div style="width:48px;height:48px;border-radius:12px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i data-lucide="user" style="width:24px;height:24px;color:#16a34a;" aria-hidden="true"></i>
                                    </div>
                                    <div style="flex:1;">
                                        <p style="font-weight:700;color:#14532d;font-size:16px;">Pembeli</p>
                                        <p style="font-size:13px;color:#6b7280;">Saya ingin membeli sayuran</p>
                                        <p style="font-size:12px;color:#9ca3af;margin-top:4px;">Bergabung sebagai pembeli untuk mendapatkan akses ke berbagai sayuran hidroponik segar berkualitas premium.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Petani --}}
                            <div @click="role = 'petani'" :class="role === 'petani' ? 'role-card active' : 'role-card'">
                                <div style="display:flex;align-items:center;gap:12px;width:100%;">
                                    <div style="width:48px;height:48px;border-radius:12px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i data-lucide="leaf" style="width:24px;height:24px;color:#16a34a;" aria-hidden="true"></i>
                                    </div>
                                    <div style="flex:1;">
                                        <p style="font-weight:700;color:#14532d;font-size:16px;">Petani</p>
                                        <p style="font-size:13px;color:#6b7280;">Saya ingin menjual sayuran</p>
                                        <p style="font-size:12px;color:#9ca3af;margin-top:4px;">Daftar sebagai petani untuk mulai menjual produk hidroponik Anda dan jangkau lebih banyak pelanggan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top:28px;">
                            <button type="button" @click="nextStep()"
                                style="width:100%;padding:14px;background:#16a34a;color:#fff;font-size:15px;font-weight:700;border:none;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(22,163,74,.3);transition:all .2s;">
                                Lanjutkan
                                <i data-lucide="arrow-right" style="width:18px;height:18px;" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Step 2: Personal Info --}}
                    <div x-show="step === 2">
                        <h2 style="font-size:22px;font-weight:800;color:#14532d;margin-bottom:4px;">Informasi Pribadi</h2>
                        <p style="font-size:14px;color:#6b7280;margin-bottom:24px;">Lengkapi data pribadi Anda</p>

                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Nama Lengkap</label>
                            <div style="position:relative;">
                                <i data-lucide="user" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                <input type="text" name="name" x-model="name" required placeholder="Nama lengkap Anda"
                                    style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;"
                                    onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                    onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                />
                            </div>
                            @error('name') <p style="margin-top:4px;font-size:12px;font-weight:600;color:#dc2626;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Email</label>
                            <div style="position:relative;">
                                <i data-lucide="mail" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                <input type="email" name="email" x-model="email" required autocomplete="username" placeholder="nama@example.com"
                                    style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;"
                                    onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                    onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                />
                            </div>
                            @error('email') <p style="margin-top:4px;font-size:12px;font-weight:600;color:#dc2626;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Password</label>
                            <div style="position:relative;">
                                <i data-lucide="lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                <input type="password" name="password" x-model="password" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                                    style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;"
                                    onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                    onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                />
                            </div>
                            @error('password') <p style="margin-top:4px;font-size:12px;font-weight:600;color:#dc2626;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Konfirmasi Password</label>
                            <div style="position:relative;">
                                <i data-lucide="lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                <input type="password" name="password_confirmation" x-model="passwordConfirmation" required autocomplete="new-password" placeholder="Ulangi password"
                                    style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;"
                                    onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                    onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                />
                            </div>
                        </div>

                        <div style="display:flex;gap:12px;margin-top:24px;">
                            <button type="button" @click="prevStep()"
                                style="flex:1;padding:14px;background:#fff;color:#16a34a;font-size:15px;font-weight:700;border:2px solid #16a34a;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s;">
                                <i data-lucide="arrow-left" style="width:18px;height:18px;" aria-hidden="true"></i>
                                Kembali
                            </button>
                            <button type="button" @click="nextStep()"
                                style="flex:1;padding:14px;background:#16a34a;color:#fff;font-size:15px;font-weight:700;border:none;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(22,163,74,.3);transition:all .2s;">
                                Lanjutkan
                                <i data-lucide="arrow-right" style="width:18px;height:18px;" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Step 3: Additional Info --}}
                    <div x-show="step === 3">
                        <h2 style="font-size:22px;font-weight:800;color:#14532d;margin-bottom:4px;">Informasi Tambahan</h2>
                        <p style="font-size:14px;color:#6b7280;margin-bottom:24px;">Beberapa informasi tambahan</p>

                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Nomor Telepon</label>
                            <div style="position:relative;">
                                <i data-lucide="phone" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                <input type="text" name="no_hp" x-model="noHp" required placeholder="+62 812-3456-7890"
                                    style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;"
                                    onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                    onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                />
                            </div>
                            @error('no_hp') <p style="margin-top:4px;font-size:12px;font-weight:600;color:#dc2626;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Alamat</label>
                            <div style="position:relative;">
                                <i data-lucide="map-pin" style="position:absolute;left:12px;top:14px;width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                <textarea name="lokasi_kebun" x-model="lokasi" rows="3" placeholder="Jl. Contoh No. 123, Jakarta"
                                    style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;resize:none;"
                                    onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                    onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                ></textarea>
                            </div>
                        </div>

                        {{-- Petani-only fields --}}
                        <div x-show="role === 'petani'" style="margin-bottom:16px;">
                            <label style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Nama Kebun/Usaha</label>
                            <div style="position:relative;">
                                <i data-lucide="leaf" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                <input type="text" name="nama_kebun" x-model="namaKebun" placeholder="Kebun Hijau Farm"
                                    style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;"
                                    onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                    onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                />
                            </div>
                            @error('nama_kebun') <p style="margin-top:4px;font-size:12px;font-weight:600;color:#dc2626;">{{ $message }}</p> @enderror
                        </div>

                        <div x-show="role === 'petani'" style="margin-bottom:16px;">
                            <label style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Deskripsi Usaha</label>
                            <textarea name="deskripsi_kebun" x-model="deskripsiKebun" rows="3" placeholder="Ceritakan tentang kebun hidroponik Anda..."
                                style="width:100%;padding:12px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;resize:none;"
                                onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                            ></textarea>
                        </div>

                        {{-- Notice --}}
                        <div style="background:#f0fdf4;border-radius:12px;padding:16px;margin-bottom:24px;">
                            <p style="font-weight:600;font-size:13px;color:#14532d;margin-bottom:4px;">📋 Perhatian</p>
                            <p style="font-size:12px;color:#6b7280;">
                                Dengan mendaftar, Anda menyetujui <a href="#" style="color:#16a34a;font-weight:600;text-decoration:none;">Syarat & Ketentuan</a> serta <a href="#" style="color:#16a34a;font-weight:600;text-decoration:none;">Kebijakan Privasi</a> kami.
                            </p>
                        </div>

                        <div style="display:flex;gap:12px;">
                            <button type="button" @click="prevStep()"
                                style="flex:1;padding:14px;background:#fff;color:#16a34a;font-size:15px;font-weight:700;border:2px solid #16a34a;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s;">
                                <i data-lucide="arrow-left" style="width:18px;height:18px;" aria-hidden="true"></i>
                                Kembali
                            </button>
                            <button type="submit"
                                style="flex:1;padding:14px;background:#16a34a;color:#fff;font-size:15px;font-weight:700;border:none;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(22,163,74,.3);transition:all .2s;">
                                Daftar Sekarang
                                <i data-lucide="arrow-right" style="width:18px;height:18px;" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Login link --}}
                <div style="margin-top:20px;padding-top:16px;border-top:1px solid #e5e7eb;text-align:center;">
                    <p style="font-size:13px;color:#6b7280;">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" style="font-weight:700;color:#16a34a;text-decoration:none;">Masuk di sini</a>
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
