<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPSH') }} – Marketplace Hidroponik</title>
    <meta name="description" content="Platform marketplace sayuran hidroponik segar langsung dari petani lokal Sambas. Sehat, tanpa pestisida, harga terbaik.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-body antialiased bg-white text-gray-900">

    <x-navbar :showSearch="false" />
    <main>
    {{-- HERO --}}
    <section class="relative bg-gradient-to-br from-primary-800 via-primary-700 to-primary-800 animate-gradient-x overflow-hidden">
        {{-- Floating Bubbles --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute w-64 h-64 rounded-full bg-emerald-400/5 -top-20 -left-20 animate-float" style="animation-delay: 0s; animation-duration: 7s;"></div>
            <div class="absolute w-48 h-48 rounded-full bg-emerald-300/5 top-1/3 -right-16 animate-float" style="animation-delay: 1.2s; animation-duration: 9s;"></div>
            <div class="absolute w-80 h-80 rounded-full bg-teal-400/5 -bottom-32 left-1/4 animate-float" style="animation-delay: 2.5s; animation-duration: 8s;"></div>
            <div class="absolute w-40 h-40 rounded-full bg-white/5 top-1/4 left-1/3 animate-float" style="animation-delay: 0.8s; animation-duration: 10s;"></div>
            <div class="absolute w-56 h-56 rounded-full bg-emerald-200/5 bottom-1/4 right-1/4 animate-float" style="animation-delay: 3s; animation-duration: 7.5s;"></div>
            <div class="absolute w-36 h-36 rounded-full bg-teal-300/5 top-2/3 left-1/6 animate-float" style="animation-delay: 1.8s; animation-duration: 8.5s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Left Content --}}
                <div class="animate-fade-in-up">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 text-white text-sm font-medium mb-6 stagger-1">
                        Marketplace Hidroponik Terpercaya
                    </span>
                    <div class="typewriter-wrapper stagger-2">
                        <h1 class="text-5xl lg:text-7xl font-heading font-bold text-white leading-tight mb-6">
                            Sayuran Segar<br>Langsung dari Petani
                        </h1>
                    </div>
                    <p class="text-emerald-200/80 text-lg max-w-lg mb-8 leading-relaxed stagger-3">
                        Platform marketplace terpercaya untuk sayuran hidroponik berkualitas premium.
                        Segar, sehat, dan dikirim langsung ke rumah Anda.
                    </p>
                    <div class="flex flex-wrap gap-4 stagger-4">
                        <a href="{{ route('shop.index') }}" class="magnetic bg-emerald-500 hover:bg-emerald-400 text-white font-semibold px-8 py-3 rounded-lg transition-colors inline-block ripple-container">
                            Mulai Belanja
                        </a>
                        <a href="{{ route('register') }}" class="magnetic border border-white/30 text-white hover:bg-white/10 px-8 py-3 rounded-lg transition-colors font-medium inline-block ripple-container">
                            Daftar Sebagai Petani
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 mt-12 stagger-5">
                        <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                            <p class="text-3xl font-heading font-bold text-white">
                                <span x-data="countUp(500)" x-text="current"></span><span class="text-emerald-300">+</span>
                            </p>
                            <p class="text-emerald-200/70 text-sm">Produk</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                            <p class="text-3xl font-heading font-bold text-white">
                                <span x-data="countUp(150)" x-text="current"></span><span class="text-emerald-300">+</span>
                            </p>
                            <p class="text-emerald-200/70 text-sm">Petani</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-5">
                            <p class="text-3xl font-heading font-bold text-white">
                                <span x-data="countUp(10000)" x-text="current.toLocaleString()"></span><span class="text-emerald-300">+</span>
                            </p>
                            <p class="text-emerald-200/70 text-sm">Pelanggan</p>
                        </div>
                    </div>
                </div>

                {{-- Right Image --}}
                <div class="relative hidden lg:block perspective-1000">
                    <div class="parallax-container rounded-xl overflow-hidden" x-data x-init="initParallax($el)">
                        <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?w=800" alt="Fresh Vegetables"
                            class="w-full object-cover aspect-[4/3] transition-transform duration-300 hover:scale-105" loading="lazy" width="800" height="600">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="bg-white py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-heading font-bold text-gray-900 mb-3">Kenapa Pilih SIPSH?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Kami berkomitmen memberikan pengalaman berbelanja sayuran terbaik dengan jaminan kualitas premium
                </p>
            </div>

            @php
            $features = [
                ['icon' => 'leaf', 'title' => '100% Segar & Organik', 'desc' => 'Sayuran hidroponik tanpa pestisida, dipanen saat pesanan masuk untuk kesegaran maksimal'],
                ['icon' => 'shield-check', 'title' => 'Kualitas Terjamin', 'desc' => 'Setiap produk melewati kontrol kualitas ketat dan memiliki sertifikasi organik'],
                ['icon' => 'truck', 'title' => 'Pengiriman Cepat', 'desc' => 'Layanan same-day delivery untuk area tertentu, packaging khusus menjaga kesegaran'],
            ];
            @endphp

            <div class="grid md:grid-cols-3 gap-12">
                @foreach ($features as $i => $f)
                    <div class="text-center animate-fade-in-up stagger-{{ $i + 1 }}">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-5">
                            <i data-lucide="{{ $f['icon'] }}" class="h-6 w-6 text-emerald-600" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-lg font-heading font-semibold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="bg-gray-50 py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-heading font-bold text-gray-900 mb-3">Cara Kerja</h2>
                <p class="text-gray-600 max-w-xl mx-auto">Hanya butuh beberapa langkah untuk mendapatkan sayuran segar pilihan Anda.</p>
            </div>

            <div class="relative">
                {{-- Connector line --}}
                <div class="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%] border-t-2 border-dashed border-emerald-200"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                    $steps = [
                        ['num' => '1', 'icon' => 'user-plus', 'title' => 'Daftar Akun', 'desc' => 'Buat akun gratis sebagai pembeli atau petani dalam hitungan menit.'],
                        ['num' => '2', 'icon' => 'search', 'title' => 'Pilih Produk', 'desc' => 'Jelajahi ratusan produk sayuran hidroponik segar dari berbagai petani.'],
                        ['num' => '3', 'icon' => 'credit-card', 'title' => 'Bayar & Pesan', 'desc' => 'Checkout mudah dengan berbagai metode pembayaran yang aman.'],
                        ['num' => '4', 'icon' => 'package-check', 'title' => 'Terima Segar', 'desc' => 'Nikmati sayuran segar berkualitas langsung diantar ke pintu rumah Anda.'],
                    ];
                    @endphp
                    @foreach ($steps as $si => $s)
                        <div class="text-center relative animate-fade-in-up stagger-{{ $si + 1 }}">
                            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center mx-auto mb-5 font-heading font-bold relative z-10">
                                {{ $s['num'] }}
                            </div>
                            <h3 class="text-base font-heading font-semibold text-gray-900 mb-2">{{ $s['title'] }}</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $s['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="bg-white py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-heading font-bold text-gray-900 mb-3">Apa Kata Mereka</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Ribuan pelanggan puas telah mempercayai SIPSH untuk kebutuhan sayuran segar mereka</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @php
                $testimonials = [
                    ['name' => 'Sari Amelia', 'role' => 'Pembeli dari Sambas', 'text' => 'Sayurannya segar banget! Selada dan bayam hidroponiknya tahan lama di kulkas. Harga juga jauh lebih murah dari supermarket. Pasti beli lagi!', 'initial' => 'SA'],
                    ['name' => 'Budi Waluyo', 'role' => 'Petani Hidroponik Sambas', 'text' => 'Platform yang sangat membantu para petani seperti saya. Sekarang produk kebun bisa langsung dijual ke konsumen tanpa perlu ke pasar.', 'initial' => 'BW'],
                    ['name' => 'Rini Pratiwi', 'role' => 'Ibu Rumah Tangga, Pontianak', 'text' => 'Pesan pagi, sore sudah sampai. Kemasannya rapi dan sayurannya benar-benar segar. Anak-anak jadi lebih suka makan sayur!', 'initial' => 'RP'],
                    ['name' => 'Ahmad Fauzi', 'role' => 'Pembeli dari Singkawang', 'text' => 'Sudah 3 bulan langganan. Kualitas selalu konsisten. Petani-petani di sini sangat profesional dan ramah.', 'initial' => 'AF'],
                ];
                @endphp

                @foreach ($testimonials as $i => $t)
                    <div class="border border-gray-100 rounded-xl p-6 animate-fade-in-up stagger-{{ $i + 1 }}">
                        <div class="flex gap-1 mb-4">
                            @for($j=0;$j<5;$j++)
                                <i data-lucide="star" class="h-4 w-4 fill-amber-400 text-amber-400" aria-hidden="true"></i>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-6 italic leading-relaxed">"{{ $t['text'] }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-heading font-bold text-sm">
                                {{ $t['initial'] }}
                            </div>
                            <div>
                                <p class="font-heading font-semibold text-gray-900 text-sm">{{ $t['name'] }}</p>
                                <p class="text-xs text-gray-600">{{ $t['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-emerald-700 py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-heading font-bold text-white mb-4">Siap Memulai?</h2>
            <p class="text-emerald-200 text-lg mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan petani dan pembeli yang telah merasakan manfaat sayuran hidroponik segar
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('shop.index') }}" class="magnetic bg-white text-emerald-700 font-semibold px-8 py-3 rounded-lg hover:bg-emerald-50 transition-colors inline-block">
                    Belanja Sekarang
                </a>
                <a href="{{ route('register') }}" class="magnetic border border-white/30 text-white font-medium px-8 py-3 rounded-lg hover:bg-white/10 transition-colors inline-block">
                    Daftar Petani
                </a>
            </div>
        </div>
    </section>

    </main>

    <x-footer />
</body>
</html>
