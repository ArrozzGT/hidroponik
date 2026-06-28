<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — {{ config('app.name', 'SIPSH') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased bg-white">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center max-w-md">
            <div class="w-20 h-20 rounded-2xl bg-emerald-100 flex items-center justify-center mx-auto mb-6 animate-drift">
                <i data-lucide="leaf" style="width:40px;height:40px;color:#059669;" aria-hidden="true"></i>
            </div>

            <h1 class="text-7xl font-heading font-bold text-emerald-600 mb-2">404</h1>
            <h2 class="text-xl font-heading font-semibold text-gray-900 mb-3">Halaman tidak ditemukan</h2>
            <p class="text-gray-600 text-sm mb-8 leading-relaxed">
                Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.<br>
                Silakan kembali ke beranda atau lihat produk kami.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('dashboard') }}"
                   class="w-full sm:w-auto px-6 py-3 bg-emerald-600 text-white rounded-lg font-medium text-sm hover:bg-emerald-700 transition-colors inline-flex items-center justify-center gap-2">
                    <i data-lucide="home" style="width:16px;height:16px;" aria-hidden="true"></i>
                    Ke Beranda
                </a>
                <a href="{{ route('shop.index') }}"
                   class="w-full sm:w-auto px-6 py-3 border-2 border-emerald-600 text-emerald-700 rounded-lg font-medium text-sm hover:bg-emerald-50 transition-colors inline-flex items-center justify-center gap-2">
                    <i data-lucide="shopping-bag" style="width:16px;height:16px;" aria-hidden="true"></i>
                    Lihat Produk
                </a>
            </div>
        </div>
    </div>
</body>
</html>
