<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPSH') }} – Marketplace Hidroponik</title>
    <meta name="description" content="Platform marketplace sayuran hidroponik segar langsung dari petani lokal Sambas. Sehat, tanpa pestisida, harga terbaik.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        @keyframes float {
            0%,100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-18px) rotate(5deg); }
            66% { transform: translateY(-8px) rotate(-3deg); }
        }
        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal-d-1 { transition-delay: .1s; }
        .reveal-d-2 { transition-delay: .2s; }
        .reveal-d-3 { transition-delay: .3s; }
        .reveal-d-4 { transition-delay: .4s; }
    </style>
</head>
<body class="font-sans bg-[var(--background)] text-[var(--foreground)]">

    <x-navbar :showSearch="false" />
    <main>
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-green-900 via-green-800 to-green-950">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS1vcGFjaXR5PSIwLjA0IiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-30"></div>
        <div class="parallax-orb" data-speed="0.8" style="top:-20%;right:-10%;width:600px;height:600px;background:radial-gradient(circle,rgba(74,222,128,0.3),transparent);"></div>
        <div class="parallax-orb" data-speed="1.2" style="bottom:-30%;left:-10%;width:500px;height:500px;background:radial-gradient(circle,rgba(16,185,129,0.2),transparent);"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left Content --}}
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white/90 text-sm font-semibold mb-6">
                        <span class="w-2 h-2 rounded-full bg-green-400 shadow-[0_0_0_3px_rgba(74,222,128,0.3)]"></span>
                        Marketplace Hidroponik Terpercaya
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
                        Sayuran Segar
                        <br>
                        <span class="bg-gradient-to-r from-green-300 via-green-400 to-lime-400 bg-clip-text text-transparent">Langsung dari Petani</span>
                    </h1>
                    <p class="text-lg text-white/70 max-w-2xl mb-8 leading-relaxed">
                        Platform marketplace terpercaya untuk sayuran hidroponik berkualitas premium.
                        Segar, sehat, dan dikirim langsung ke rumah Anda.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('shop.index') }}" class="btn-primary magnetic">
                            <i data-lucide="shopping-bag" class="h-5 w-5" aria-hidden="true"></i>
                            Mulai Belanja
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-xl border-2 border-white/30 text-white hover:bg-white/10 active:scale-95 transition-all duration-150 magnetic">
                            <i data-lucide="store" class="h-5 w-5" aria-hidden="true"></i>
                            Daftar Sebagai Petani
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 mt-12">
                        <div>
                            <p class="text-3xl font-extrabold text-green-300">500+</p>
                            <p class="text-sm text-white/60">Produk</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold text-green-300">150+</p>
                            <p class="text-sm text-white/60">Petani</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold text-green-300">10K+</p>
                            <p class="text-sm text-white/60">Pelanggan</p>
                        </div>
                    </div>
                </div>

                {{-- Right Image --}}
                <div class="relative hidden lg:block img-zoom">
                    <div class="absolute -inset-4 bg-gradient-to-r from-green-600/20 to-emerald-500/20 rounded-3xl blur-2xl"></div>
                    <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?w=800" alt="Fresh Vegetables"
                        class="relative rounded-3xl shadow-2xl w-full object-cover aspect-[4/3]">
                </div>
            </div>
        </div>

        {{-- Wave Divider --}}
        <div class="absolute bottom-[-2px] left-0 right-0 leading-none">
            <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-16 lg:h-20">
                <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="var(--background)"/>
            </svg>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 tracking-widest uppercase mb-4">
                    <i data-lucide="sparkles" class="w-[13px] h-[13px]" aria-hidden="true"></i>
                    Keunggulan
                </span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-green-900 mb-3">Mengapa Memilih SIPSH?</h2>
                <p class="text-[var(--muted-foreground)] max-w-2xl mx-auto">
                    Kami berkomitmen memberikan pengalaman berbelanja sayuran terbaik dengan jaminan kualitas premium
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @php
                $features = [
                    ['icon' => 'leaf', 'title' => '100% Segar & Organik', 'desc' => 'Sayuran hidroponik tanpa pestisida, dipanen saat pesanan masuk untuk kesegaran maksimal'],
                    ['icon' => 'shield-check', 'title' => 'Kualitas Terjamin', 'desc' => 'Setiap produk melewati kontrol kualitas ketat dan memiliki sertifikasi organik'],
                    ['icon' => 'truck', 'title' => 'Pengiriman Cepat', 'desc' => 'Layanan same-day delivery untuk area tertentu, packaging khusus menjaga kesegaran'],
                ];
                @endphp
                @foreach ($features as $i => $f)
                    <div class="card card-pad border-green-100 hover:shadow-xl transition-all duration-300 group h-full bg-white/80 backdrop-blur-sm reveal tilt-3d {{ 'reveal-d-' . ($i + 1) }}">
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-green-600 to-emerald-500 mb-6 shadow-lg shadow-green-600/30 group-hover:scale-110 transition-transform">
                            <i data-lucide="{{ $f['icon'] }}" class="h-7 w-7 text-white" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-xl font-bold text-green-900 mb-3">{{ $f['title'] }}</h3>
                        <p class="text-[var(--muted-foreground)]">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="py-16 lg:py-24 bg-white/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 tracking-widest uppercase mb-4">
                    <i data-lucide="git-branch" class="w-[13px] h-[13px]" aria-hidden="true"></i>
                    Cara Kerja
                </span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-green-900 mb-3">Mudah, Cepat, Terpercaya</h2>
                <p class="text-[var(--muted-foreground)] max-w-xl mx-auto">Hanya butuh beberapa langkah untuk mendapatkan sayuran segar pilihan Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                $steps = [
                    ['icon' => 'user-plus', 'title' => 'Daftar Akun', 'desc' => 'Buat akun gratis sebagai pembeli atau petani dalam hitungan menit.'],
                    ['icon' => 'search', 'title' => 'Pilih Produk', 'desc' => 'Jelajahi ratusan produk sayuran hidroponik segar dari berbagai petani.'],
                    ['icon' => 'credit-card', 'title' => 'Bayar & Pesan', 'desc' => 'Checkout mudah dengan berbagai metode pembayaran yang aman.'],
                    ['icon' => 'package-check', 'title' => 'Terima Segar', 'desc' => 'Nikmati sayuran segar berkualitas langsung diantar ke pintu rumah Anda.'],
                ];
                @endphp
                @foreach ($steps as $i => $s)
                    <div class="text-center reveal {{ 'reveal-d-' . ($i + 1) }}">
                        <div class="w-20 h-20 rounded-full mx-auto mb-5 bg-gradient-to-br from-green-600 to-emerald-500 flex items-center justify-center text-2xl font-black text-white shadow-lg shadow-green-600/35">
                            <i data-lucide="{{ $s['icon'] }}" class="h-7 w-7" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-lg font-bold text-green-900 mb-2">{{ $s['title'] }}</h3>
                        <p class="text-sm text-[var(--muted-foreground)]">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 tracking-widest uppercase mb-4">
                    <i data-lucide="star" class="w-[13px] h-[13px]" aria-hidden="true"></i>
                    Testimoni
                </span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-green-900 mb-3">Apa Kata Pelanggan Kami</h2>
                <p class="text-[var(--muted-foreground)] max-w-2xl mx-auto">Ribuan pelanggan puas telah mempercayai SIPSH untuk kebutuhan sayuran segar mereka</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @php
                $testimonials = [
                    ['name' => 'Sari Amelia', 'role' => 'Pembeli dari Sambas', 'text' => 'Sayurannya segar banget! Selada dan bayam hidroponiknya tahan lama di kulkas. Harga juga jauh lebih murah dari supermarket. Pasti beli lagi!', 'initial' => 'SA'],
                    ['name' => 'Budi Waluyo', 'role' => 'Petani Hidroponik Sambas', 'text' => 'Platform yang sangat membantu para petani seperti saya. Sekarang produk kebun bisa langsung dijual ke konsumen tanpa perlu ke pasar.', 'initial' => 'BW'],
                    ['name' => 'Rini Pratiwi', 'role' => 'Ibu Rumah Tangga, Pontianak', 'text' => 'Pesan pagi, sore sudah sampai. Kemasannya rapi dan sayurannya benar-benar segar. Anak-anak jadi lebih suka makan sayur!', 'initial' => 'RP'],
                ];
                @endphp
                @foreach ($testimonials as $i => $t)
                    <div class="card border-green-100 hover:shadow-xl transition-all duration-300 h-full bg-white/80 backdrop-blur-sm reveal tilt-3d {{ 'reveal-d-' . ($i + 1) }}">
                        <div class="p-8">
                            <div class="flex gap-1 mb-4">
                                @for($j=0;$j<5;$j++)
                                    <i data-lucide="star" class="h-4 w-4 fill-yellow-400 text-yellow-400" aria-hidden="true"></i>
                                @endfor
                            </div>
                            <p class="text-[var(--foreground)] mb-6 italic leading-relaxed">"{{ $t['text'] }}"</p>
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-green-600 to-emerald-500 flex items-center justify-center text-white font-bold text-sm">
                                    {{ $t['initial'] }}
                                </div>
                                <div>
                                    <p class="font-semibold text-green-900">{{ $t['name'] }}</p>
                                    <p class="text-sm text-[var(--muted-foreground)]">{{ $t['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-gradient-to-br from-green-600 to-emerald-500 p-10 lg:p-16 text-center relative overflow-hidden reveal">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS1vcGFjaXR5PSIwLjA1IiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-30"></div>
                <div class="relative">
                    <p class="text-sm font-bold tracking-widest uppercase text-green-100 mb-3">🌿 Bergabung Sekarang</p>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4">Siap Memulai Hidup Sehat?</h2>
                    <p class="text-green-50 text-lg mb-8 max-w-2xl mx-auto">
                        Bergabunglah dengan ribuan pelanggan yang telah merasakan manfaat sayuran hidroponik segar
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white text-green-700 text-sm font-semibold rounded-xl hover:bg-green-50 active:scale-95 transition-all duration-150 shadow-lg magnetic">
                            <i data-lucide="shopping-cart" class="h-5 w-5" aria-hidden="true"></i>
                            Belanja Sekarang
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-xl border-2 border-white/30 text-white hover:bg-white/10 active:scale-95 transition-all duration-150 magnetic">
                            <i data-lucide="sprout" class="h-5 w-5" aria-hidden="true"></i>
                            Daftar Sebagai Petani
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </main>

    <x-footer />
</body>
</html>
