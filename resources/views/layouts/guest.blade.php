<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPSH') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">
        @vite(['resources/css/app.css', 'resources/css/guest.css', 'resources/js/app.js'])
    </head>
        <body style="font-family:'Plus Jakarta Sans',sans-serif;">
            <div class="guest-bg">
            <div class="guest-orb guest-orb-1"></div>
            <div class="guest-orb guest-orb-2"></div>
            <div class="guest-orb guest-orb-3"></div>
            <div class="guest-orb guest-orb-4"></div>
            <div class="guest-grid"></div>

            {{-- Floating Decorative Leaves --}}
            <i data-lucide="leaf" class="guest-leaf guest-leaf-1" aria-hidden="true"></i>
            <i data-lucide="leaf" class="guest-leaf guest-leaf-2" aria-hidden="true"></i>
            <i data-lucide="leaf" class="guest-leaf guest-leaf-3" aria-hidden="true"></i>
            <i data-lucide="leaf" class="guest-leaf guest-leaf-4" aria-hidden="true"></i>
            <i data-lucide="sprout" class="guest-leaf guest-leaf-5" aria-hidden="true"></i>

            <div class="guest-logo">
                <a href="/">
                    <div class="guest-logo-icon">
                        <i data-lucide="leaf" style="width:22px;height:22px;color:#fff;" aria-hidden="true"></i>
                    </div>
                    <span class="guest-logo-text">{{ config('app.name', 'SIPSH') }}</span>
                </a>
                <p class="guest-logo-sub">Sistem Informasi Penjualan Sayuran Hidroponik</p>
            </div>

            <div class="guest-card">
                {{ $slot }}
            </div>

            <p class="guest-footer">© {{ date('Y') }} {{ config('app.name', 'SIPSH') }}. All rights reserved.</p>
        </div>


    </body>
</html>
