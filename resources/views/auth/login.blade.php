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
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        .login-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #16a34a, #22c55e, #10b981);
            display: flex; align-items: center; justify-content: center;
            padding: 16px; position: relative; overflow: hidden;
        }
        .login-bg::before {
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
    </style>
</head>
<body>
    <main>
    <div class="login-bg">
        {{-- Floating leaves --}}
        <i data-lucide="leaf" class="leaf-deco" style="top:10%;left:5%;font-size:2.5rem;animation-delay:0s;" aria-hidden="true"></i>
        <i data-lucide="leaf" class="leaf-deco" style="top:20%;right:8%;font-size:2rem;animation-delay:-3s;" aria-hidden="true"></i>
        <i data-lucide="sprout" class="leaf-deco" style="bottom:15%;left:12%;font-size:2.2rem;animation-delay:-6s;" aria-hidden="true"></i>
        <i data-lucide="leaf" class="leaf-deco" style="bottom:25%;right:5%;font-size:1.8rem;animation-delay:-9s;" aria-hidden="true"></i>

        <div style="max-width:1100px;width:100%;position:relative;z-index:10;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;">
                {{-- Left: Branding --}}
                <div class="hidden lg:block">
                    <a href="/" style="display:inline-flex;align-items:center;gap:12px;text-decoration:none;margin-bottom:32px;">
                        <div style="width:56px;height:56px;border-radius:16px;background:rgba(255,255,255,.2);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;">
                            <i data-lucide="leaf" style="width:32px;height:32px;color:#fff;" aria-hidden="true"></i>
                        </div>
                        <div>
                            <span style="font-size:28px;font-weight:800;color:#fff;">{{ config('app.name', 'SIPSH') }}</span>
                            <p style="font-size:12px;color:rgba(255,255,255,.7);margin-top:-2px;">Sayuran Hidroponik</p>
                        </div>
                    </a>

                    <h1 style="font-size:48px;font-weight:800;color:#fff;margin-bottom:24px;line-height:1.2;">
                        Selamat Datang
                        <br>Kembali!
                    </h1>

                    <p style="font-size:18px;color:rgba(255,255,255,.85);margin-bottom:32px;">
                        Masuk ke akun Anda untuk melanjutkan berbelanja sayuran segar dan organik
                    </p>

                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div style="display:flex;align-items:flex-start;gap:12px;color:#fff;">
                            <div style="width:24px;height:24px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;font-size:12px;">✓</div>
                            <div>
                                <p style="font-weight:600;">100% Segar & Organik</p>
                                <p style="font-size:13px;color:rgba(255,255,255,.7);">Sayuran hidroponik berkualitas premium</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:12px;color:#fff;">
                            <div style="width:24px;height:24px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;font-size:12px;">✓</div>
                            <div>
                                <p style="font-weight:600;">Pengiriman Cepat</p>
                                <p style="font-size:13px;color:rgba(255,255,255,.7);">Same-day delivery untuk area tertentu</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:12px;color:#fff;">
                            <div style="width:24px;height:24px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;font-size:12px;">✓</div>
                            <div>
                                <p style="font-weight:600;">Harga Terbaik</p>
                                <p style="font-size:13px;color:rgba(255,255,255,.7);">Langsung dari petani ke rumah Anda</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Login Form --}}
                <div style="max-width:440px;width:100%;margin:0 auto;">
                    <div style="background:rgba(255,255,255,.95);backdrop-filter:blur(12px);border-radius:24px;padding:36px 32px;box-shadow:0 30px 80px rgba(0,0,0,.25);border:1px solid rgba(255,255,255,.3);">
                        {{-- Mobile logo --}}
                        <div class="lg:hidden" style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
                            <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#16a34a,#10b981);display:flex;align-items:center;justify-content:center;">
                                <i data-lucide="leaf" style="width:22px;height:22px;color:#fff;" aria-hidden="true"></i>
                            </div>
                            <span style="font-size:22px;font-weight:800;color:#14532d;">{{ config('app.name', 'SIPSH') }}</span>
                        </div>

                        <h2 style="font-size:24px;font-weight:800;color:#14532d;margin-bottom:4px;">Masuk ke Akun</h2>
                        <p style="font-size:14px;color:#6b7280;margin-bottom:24px;">Masukkan email dan password untuk melanjutkan</p>

                        <x-auth-session-status :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div style="margin-bottom:16px;">
                                <label for="email" style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Email</label>
                                <div style="position:relative;">
                                    <i data-lucide="mail" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@example.com"
                                        style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;"
                                        onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                        onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                    />
                                </div>
                                @if ($errors->get('email'))
                                    <p style="margin-top:4px;font-size:12px;font-weight:600;color:#dc2626;">{{ $errors->first('email') }}</p>
                                @endif
                            </div>

                            <div style="margin-bottom:16px;">
                                <label for="password" style="display:block;font-size:14px;font-weight:600;color:#14532d;margin-bottom:6px;">Password</label>
                                <div style="position:relative;">
                                    <i data-lucide="lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#9ca3af;" aria-hidden="true"></i>
                                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                        style="width:100%;padding:12px 12px 12px 42px;border:2px solid #bbf7d0;border-radius:12px;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;color:#1a1a1a;"
                                        onfocus="this.style.borderColor='#16a34a';this.style.boxShadow='0 0 0 3px rgba(22,163,74,.15)'"
                                        onblur="this.style.borderColor='#bbf7d0';this.style.boxShadow='none'"
                                    />
                                </div>
                                @if ($errors->get('password'))
                                    <p style="margin-top:4px;font-size:12px;font-weight:600;color:#dc2626;">{{ $errors->first('password') }}</p>
                                @endif
                            </div>

                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                    <input type="checkbox" name="remember" id="remember_me" style="width:18px;height:18px;border-radius:4px;border:2px solid #16a34a;accent-color:#16a34a;cursor:pointer;">
                                    <span style="font-size:14px;color:#4b5563;">Ingat saya</span>
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" style="font-size:13px;font-weight:600;color:#16a34a;text-decoration:none;hover:text-color:#15803d;">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>

                            <button type="submit" style="width:100%;padding:14px;background:#16a34a;color:#fff;font-size:15px;font-weight:700;border:none;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(22,163,74,.3);transition:all .2s;"
                                onmouseover="this.style.background='#15803d';this.style.boxShadow='0 6px 20px rgba(22,163,74,.4)'"
                                onmouseout="this.style.background='#16a34a';this.style.boxShadow='0 4px 14px rgba(22,163,74,.3)'"
                            >
                                Masuk
                                <i data-lucide="arrow-right" style="width:18px;height:18px;" aria-hidden="true"></i>
                            </button>
                        </form>

                        {{-- Social divider --}}
                        <div style="position:relative;margin:24px 0;">
                            <div style="position:absolute;inset:0;display:flex;align-items:center;">
                                <div style="width:100%;border-top:1px solid #e5e7eb;"></div>
                            </div>
                            <div style="position:relative;display:flex;justify-content:center;">
                                <span style="padding:0 12px;background:#fff;font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;">Atau lanjutkan dengan</span>
                            </div>
                        </div>

                        {{-- Social buttons --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <button type="button" onclick="alert('Google login akan segera tersedia.')" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;font-size:13px;font-weight:600;color:#374151;cursor:pointer;transition:all .15s;"
                                onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#bbf7d0'"
                                onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb'"
                            >
                                <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                                Google
                            </button>
                            <button type="button" onclick="alert('Facebook login akan segera tersedia.')" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;font-size:13px;font-weight:600;color:#374151;cursor:pointer;transition:all .15s;"
                                onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#bbf7d0'"
                                onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb'"
                            >
                                <svg width="18" height="18" fill="#1877F2" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </button>
                        </div>

                        {{-- Register link --}}
                        <div style="margin-top:20px;padding-top:20px;border-top:1px solid #e5e7eb;text-align:center;">
                            <p style="font-size:13px;color:#6b7280;">
                                Belum punya akun?
                                <a href="{{ route('register') }}" style="font-weight:700;color:#16a34a;text-decoration:none;">Daftar Sekarang</a>
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
