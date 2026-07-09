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
<body class="font-body antialiased dark-landing">

    <x-navbar :dark="true" :showSearch="false" />
    <main>

    {{-- HERO --}}
    <section class="relative bg-surface-950 min-h-[90vh] flex items-center overflow-hidden">
        {{-- Background Gradients --}}
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-1/4 -left-32 w-[500px] h-[500px] rounded-full bg-produce-lettuce/5 blur-[120px]"></div>
            <div class="absolute -bottom-32 right-1/4 w-[400px] h-[400px] rounded-full bg-produce-tomato/5 blur-[100px]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-produce-carrot/3 blur-[150px]"></div>
        </div>

        {{-- Floating 3D Objects --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true" id="hero-3d-scene">
            <div class="hero-3d-object absolute w-20 h-20 rounded-2xl bg-produce-lettuce/20 border border-produce-lettuce/30 top-[15%] left-[8%]" style="animation: heroFloat 8s ease-in-out infinite, heroSpin 20s linear infinite;"></div>
            <div class="hero-3d-object absolute w-16 h-16 rounded-full bg-produce-tomato/15 border border-produce-tomato/30 top-[25%] right-[12%]" style="animation: heroFloat 10s ease-in-out infinite 1s, heroSpin 25s linear infinite reverse;"></div>
            <div class="hero-3d-object absolute w-14 h-14 rounded-2xl bg-produce-lemon/15 border border-produce-lemon/30 bottom-[30%] left-[15%]" style="animation: heroFloat 7s ease-in-out infinite 0.5s, heroSpin 18s linear infinite;"></div>
            <div class="hero-3d-object absolute w-24 h-24 rounded-full bg-produce-carrot/10 border border-produce-carrot/30 bottom-[20%] right-[18%]" style="animation: heroFloat 9s ease-in-out infinite 2s, heroSpin 22s linear infinite reverse;"></div>
            <div class="hero-3d-object absolute w-12 h-12 rounded-xl bg-produce-eggplant/20 border border-produce-eggplant/30 top-[40%] left-[5%]" style="animation: heroFloat 11s ease-in-out infinite 1.5s, heroSpin 15s linear infinite;"></div>
            <div class="hero-3d-object absolute w-10 h-10 rotate-45 bg-produce-lettuce/15 border border-produce-lettuce/25 bottom-[40%] right-[8%]" style="animation: heroFloat 8s ease-in-out infinite 0.8s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Left Content --}}
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-produce-lettuce/10 text-produce-lettuce text-sm font-medium mb-6">
                        <span class="w-2 h-2 rounded-full bg-produce-lettuce animate-pulse-soft"></span>
                        Marketplace Hidroponik Terpercaya
                    </span>

                    <h1 class="text-5xl lg:text-7xl font-heading font-bold text-white leading-tight mb-6">
                        Sayuran Segar<br>
                        <span class="text-produce-lettuce">Langsung dari Petani</span>
                    </h1>

                    <p class="text-[#F5F5F0]/60 text-lg max-w-lg mb-10 leading-relaxed">
                        Platform marketplace terpercaya untuk sayuran hidroponik berkualitas premium.
                        Segar, sehat, dan dikirim langsung ke rumah Anda.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-produce-lettuce text-surface-950 font-semibold px-8 py-3.5 rounded-xl hover:brightness-110 transition-all magnetic">
                            Mulai Belanja
                            <i data-lucide="arrow-right" class="h-4 w-4" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 border border-white/20 text-[#F5F5F0] px-8 py-3.5 rounded-xl hover:bg-white/5 transition-all font-medium magnetic">
                            Daftar Sebagai Petani
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 mt-14">
                        <div class="bg-surface-900/60 backdrop-blur border border-white/5 rounded-2xl p-5">
                            <p class="text-3xl font-heading font-bold text-white">
                                <span x-data="countUp(500)" x-text="current"></span><span class="text-produce-lettuce">+</span>
                            </p>
                            <p class="text-[#F5F5F0]/50 text-sm mt-1">Produk</p>
                        </div>
                        <div class="bg-surface-900/60 backdrop-blur border border-white/5 rounded-2xl p-5">
                            <p class="text-3xl font-heading font-bold text-white">
                                <span x-data="countUp(150)" x-text="current"></span><span class="text-produce-lettuce">+</span>
                            </p>
                            <p class="text-[#F5F5F0]/50 text-sm mt-1">Petani</p>
                        </div>
                        <div class="bg-surface-900/60 backdrop-blur border border-white/5 rounded-2xl p-5">
                            <p class="text-3xl font-heading font-bold text-white">
                                <span x-data="countUp(10000)" x-text="current.toLocaleString()"></span><span class="text-produce-lettuce">+</span>
                            </p>
                            <p class="text-[#F5F5F0]/50 text-sm mt-1">Pelanggan</p>
                        </div>
                    </div>
                </div>

                {{-- Right: 3D Hero Scene --}}
                <div class="relative hidden lg:block" style="min-height: 500px;">
                    <canvas id="hero-3d-canvas" class="w-full h-full absolute inset-0" style="min-height: 500px;"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none" id="hero-3d-loading">
                        <div class="relative w-80 h-80">
                            <div class="absolute inset-0 rounded-full border border-produce-lettuce/20 animate-pulse-soft" style="animation-duration: 4s;"></div>
                            <div class="absolute inset-4 rounded-full border border-produce-lettuce/10 animate-pulse-soft" style="animation-duration: 5s; animation-delay: 0.5s;"></div>
                            <div class="absolute inset-8 rounded-full border border-produce-carrot/10 animate-pulse-soft" style="animation-duration: 3.5s; animation-delay: 1s;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="bg-surface-900 py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
                <h2 class="font-heading text-3xl lg:text-4xl text-white text-center">Kenapa Pilih SIPSH?</h2>
                <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
            </div>
            <p class="text-[#F5F5F0]/50 max-w-2xl mx-auto text-center mb-16">
                Kami berkomitmen memberikan pengalaman berbelanja sayuran terbaik dengan jaminan kualitas premium
            </p>

            @php
            $features = [
                ['icon' => 'leaf', 'title' => '100% Segar & Organik', 'desc' => 'Sayuran hidroponik tanpa pestisida, dipanen saat pesanan masuk untuk kesegaran maksimal'],
                ['icon' => 'shield-check', 'title' => 'Kualitas Terjamin', 'desc' => 'Setiap produk melewati kontrol kualitas ketat dan memiliki sertifikasi organik'],
                ['icon' => 'truck', 'title' => 'Pengiriman Cepat', 'desc' => 'Layanan same-day delivery untuk area tertentu, packaging khusus menjaga kesegaran'],
            ];
            @endphp

            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($features as $i => $f)
                    <div class="bg-surface-800/50 border border-white/5 rounded-2xl p-8 text-center hover:bg-surface-800/80 transition-all reveal" style="transition-delay: {{ $i * 100 }}ms;">
                        <div class="w-14 h-14 rounded-2xl bg-produce-lettuce/10 flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="{{ $f['icon'] }}" class="h-7 w-7 text-produce-lettuce" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-lg font-heading font-semibold text-white mb-3">{{ $f['title'] }}</h3>
                        <p class="text-[#F5F5F0]/50 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FEATURED PRODUCTS --}}
    <section class="bg-surface-950 py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
                <h2 class="font-heading text-3xl lg:text-4xl text-white text-center">Produk Unggulan</h2>
                <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
            </div>
            <p class="text-[#F5F5F0]/50 max-w-2xl mx-auto text-center mb-14">
                Sayuran segar pilihan terbaik dari petani hidroponik terbaik kami
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <div class="product-card-dark tilt-3d">
                        <a href="{{ route('shop.show', $product->slug) }}" class="block relative aspect-square rounded-2xl overflow-hidden bg-surface-800 mb-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-contain drop-shadow-xl"
                                     loading="lazy"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="w-full h-full hidden items-center justify-center bg-surface-800">
                                    <i data-lucide="sprout" style="width:40px;height:40px;color:#7ED957;" aria-hidden="true"></i>
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-surface-800">
                                    <i data-lucide="sprout" style="width:40px;height:40px;color:#7ED957;" aria-hidden="true"></i>
                                </div>
                            @endif

                            {{-- Badge Category --}}
                            <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-surface-900/80 text-[#F5F5F0]/70 border border-white/5">
                                {{ $product->category->name ?? 'Sayuran' }}
                            </span>

                            {{-- Status Badges --}}
                            <div class="absolute top-3 right-3 flex flex-col gap-1">
                                @if($product->stock == 0)
                                    <span class="badge-produce-tomato px-2 py-0.5 rounded-full text-[10px] font-semibold">HABIS</span>
                                @elseif($product->created_at->diffInDays(now()) < 7)
                                    <span class="badge-produce-lemon px-2 py-0.5 rounded-full text-[10px] font-semibold">BARU</span>
                                @endif
                            </div>
                        </a>

                        <div class="px-1">
                            <a href="{{ route('shop.show', $product->slug) }}">
                                <h3 class="font-heading font-semibold text-white truncate text-sm hover:text-produce-lettuce transition-colors">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            <p class="text-xs text-[#F5F5F0]/40 mt-0.5 truncate">
                                {{ $product->user->petaniProfile->nama_kebun ?? $product->user->name }}
                            </p>

                            <div class="mt-3 flex items-baseline gap-1">
                                <span class="text-base font-bold text-produce-carrot">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-[#F5F5F0]/40">/ {{ $product->unit }}</span>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST"
                                          @submit.prevent="fetch($event.target.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }, body: new FormData($event.target) }).then(r => { if(r.ok) { $dispatch('notify', { type: 'success', message: 'Produk ditambahkan ke keranjang!' }); } })">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                                class="w-10 h-10 rounded-full border border-produce-lettuce/40 text-produce-lettuce flex items-center justify-center hover:bg-produce-lettuce hover:text-surface-950 transition-all">
                                            <i data-lucide="shopping-cart" class="h-4 w-4" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-[#F5F5F0]/30">Stok Habis</span>
                                @endif
                                <a href="{{ route('shop.show', $product->slug) }}" class="text-xs text-[#F5F5F0]/50 hover:text-produce-lettuce transition-colors">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    @for($i = 0; $i < 4; $i++)
                        <div class="product-card-dark">
                            <div class="aspect-square rounded-2xl overflow-hidden bg-surface-800 mb-4 flex items-center justify-center">
                                <i data-lucide="sprout" style="width:48px;height:48px;color:#7ED957/20;" aria-hidden="true"></i>
                            </div>
                            <div class="px-1 space-y-3">
                                <div class="h-4 bg-surface-800 rounded w-3/4"></div>
                                <div class="h-3 bg-surface-800 rounded w-1/2"></div>
                                <div class="h-5 bg-surface-800 rounded w-1/3"></div>
                                <div class="h-10 bg-surface-800 rounded-full w-10"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 border border-white/20 text-[#F5F5F0] px-8 py-3 rounded-xl hover:bg-white/5 transition-all font-medium">
                    Lihat Semua Produk
                    <i data-lucide="arrow-right" class="h-4 w-4" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="bg-surface-900 py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
                <h2 class="font-heading text-3xl lg:text-4xl text-white text-center">Cara Kerja</h2>
                <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
            </div>
            <p class="text-[#F5F5F0]/50 max-w-xl mx-auto text-center mb-16">
                Hanya butuh beberapa langkah untuk mendapatkan sayuran segar pilihan Anda.
            </p>

            <div class="relative">
                <div class="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%] border-t-2 border-dashed border-white/5"></div>

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
                        <div class="text-center relative reveal" style="transition-delay: {{ $si * 100 }}ms;">
                            <div class="w-14 h-14 rounded-2xl bg-surface-800 border border-white/5 flex items-center justify-center mx-auto mb-6 relative z-10">
                                <i data-lucide="{{ $s['icon'] }}" class="h-6 w-6 text-produce-lettuce" aria-hidden="true"></i>
                            </div>
                            <span class="block text-produce-lettuce font-heading font-bold text-lg mb-2">{{ $s['num'] }}</span>
                            <h3 class="text-base font-heading font-semibold text-white mb-2">{{ $s['title'] }}</h3>
                            <p class="text-sm text-[#F5F5F0]/50 leading-relaxed">{{ $s['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="bg-surface-950 py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
                <h2 class="font-heading text-3xl lg:text-4xl text-white text-center">Apa Kata Mereka</h2>
                <span class="h-8 w-1 rounded-full bg-produce-lettuce"></span>
            </div>
            <p class="text-[#F5F5F0]/50 max-w-2xl mx-auto text-center mb-16">
                Ribuan pelanggan puas telah mempercayai SIPSH untuk kebutuhan sayuran segar mereka
            </p>

            <div class="grid md:grid-cols-2 gap-6">
                @php
                $testimonials = [
                    ['name' => 'Sari Amelia', 'role' => 'Pembeli dari Sambas', 'text' => 'Sayurannya segar banget! Selada dan bayam hidroponiknya tahan lama di kulkas. Harga juga jauh lebih murah dari supermarket. Pasti beli lagi!', 'initial' => 'SA'],
                    ['name' => 'Budi Waluyo', 'role' => 'Petani Hidroponik Sambas', 'text' => 'Platform yang sangat membantu para petani seperti saya. Sekarang produk kebun bisa langsung dijual ke konsumen tanpa perlu ke pasar.', 'initial' => 'BW'],
                    ['name' => 'Rini Pratiwi', 'role' => 'Ibu Rumah Tangga, Pontianak', 'text' => 'Pesan pagi, sore sudah sampai. Kemasannya rapi dan sayurannya benar-benar segar. Anak-anak jadi lebih suka makan sayur!', 'initial' => 'RP'],
                    ['name' => 'Ahmad Fauzi', 'role' => 'Pembeli dari Singkawang', 'text' => 'Sudah 3 bulan langganan. Kualitas selalu konsisten. Petani-petani di sini sangat profesional dan ramah.', 'initial' => 'AF'],
                ];
                @endphp

                @foreach ($testimonials as $i => $t)
                    <div class="bg-surface-900/60 backdrop-blur rounded-2xl p-6 border border-surface-700/50 reveal" style="transition-delay: {{ $i * 100 }}ms;">
                        <div class="flex gap-1 mb-4">
                            @for($j=0;$j<5;$j++)
                                <i data-lucide="star" class="h-4 w-4 fill-produce-carrot text-produce-carrot" aria-hidden="true"></i>
                            @endfor
                        </div>
                        <p class="text-[#F5F5F0]/70 mb-6 italic leading-relaxed text-sm">"{{ $t['text'] }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-produce-lettuce/15 text-produce-lettuce flex items-center justify-center font-heading font-bold text-sm">
                                {{ $t['initial'] }}
                            </div>
                            <div>
                                <p class="font-heading font-semibold text-white text-sm">{{ $t['name'] }}</p>
                                <p class="text-xs text-[#F5F5F0]/40">{{ $t['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-surface-800 py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-heading font-bold text-white mb-4">Siap Memulai?</h2>
            <p class="text-[#F5F5F0]/50 text-lg mb-10 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan petani dan pembeli yang telah merasakan manfaat sayuran hidroponik segar
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-produce-lettuce text-surface-950 font-semibold px-8 py-3.5 rounded-xl hover:brightness-110 transition-all magnetic">
                    Belanja Sekarang
                    <i data-lucide="shopping-bag" class="h-4 w-4" aria-hidden="true"></i>
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center border border-white/20 text-[#F5F5F0] px-8 py-3.5 rounded-xl hover:bg-white/5 transition-all font-medium magnetic">
                    Daftar Petani
                </a>
            </div>
        </div>
    </section>

    </main>

    <x-footer variant="dark" />

    <style>
        .hero-3d-object {
            will-change: transform;
            transition: transform 0.1s ease-out;
        }
        @keyframes heroFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(5deg); }
            66% { transform: translateY(-10px) rotate(-3deg); }
        }
        @keyframes heroSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @media (prefers-reduced-motion: reduce) {
            .hero-3d-object {
                animation: none !important;
            }
        }
    </style>
</body>
</html>
