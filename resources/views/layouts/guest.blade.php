<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPSH') }}</title>

        @vite(['resources/css/app.css', 'resources/css/guest.css', 'resources/js/app.js'])
    </head>
    <body class="font-body antialiased">
        <div class="scroll-progress" aria-hidden="true"></div>
        <div class="lg:grid lg:grid-cols-2 min-h-screen">
            {{-- Left Panel --}}
            <div class="guest-bg relative p-12 lg:p-16 flex flex-col justify-between overflow-hidden">
                <div class="guest-circle guest-circle-1"></div>
                <div class="guest-circle guest-circle-2"></div>
                <div class="guest-circle guest-circle-3"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center">
                            <i data-lucide="leaf" style="width:22px;height:22px;color:#fff;" aria-hidden="true"></i>
                        </div>
                        <span class="font-heading font-bold text-xl text-white">{{ config('app.name', 'SIPSH') }}</span>
                    </div>

                    <h1 class="font-heading font-bold text-3xl lg:text-4xl text-white leading-tight mb-6">
                        Marketplace Hidroponik<br/>
                        <span class="text-emerald-300">Terpercaya</span>
                    </h1>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-800/50 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="shopping-bag" style="width:16px;height:16px;color:#6ee7b7;" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Belanja Sayuran Segar</p>
                                <p class="text-emerald-200/70 text-sm">Langsung dari petani hidroponik terbaik</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-800/50 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="truck" style="width:16px;height:16px;color:#6ee7b7;" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Pengiriman Cepat</p>
                                <p class="text-emerald-200/70 text-sm">Dipetik dan dikirim di hari yang sama</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-800/50 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="badge-check" style="width:16px;height:16px;color:#6ee7b7;" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Kualitas Terjamin</p>
                                <p class="text-emerald-200/70 text-sm">Tanpa pestisida, 100% organik</p>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="relative z-10 text-emerald-800 text-sm">© {{ date('Y') }} {{ config('app.name', 'SIPSH') }}. All rights reserved.</p>
            </div>

            {{-- Right Panel --}}
            <div class="bg-white p-12 lg:p-16 flex items-center justify-center">
                <div class="guest-card">
                    <div class="text-center mb-8">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="leaf" style="width:24px;height:24px;color:#059669;" aria-hidden="true"></i>
                        </div>
                        <h2 class="font-heading font-bold text-xl text-gray-900">{{ config('app.name', 'SIPSH') }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Sistem Informasi Penjualan Sayuran Hidroponik</p>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-xl p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <button class="back-to-top fixed bottom-6 right-6 z-50 w-10 h-10 rounded-full bg-emerald-600 text-white shadow-lg flex items-center justify-center transition-all duration-300 opacity-0 invisible hover:bg-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2" aria-label="Kembali ke atas">
            <i data-lucide="chevron-up" class="h-5 w-5" aria-hidden="true"></i>
        </button>

        @if(session('success'))<div data-toast="success" data-message="{{ session('success') }}"></div>@endif
        @if(session('error'))<div data-toast="error" data-message="{{ session('error') }}"></div>@endif
        <x-toast />
    </body>
</html>
