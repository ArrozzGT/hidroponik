@props(['variant' => 'default'])

@php
$isDark = $variant === 'dark';
$bg = $isDark ? 'bg-surface-900' : 'bg-emerald-800';
$textMuted = $isDark ? 'text-[#F5F5F0]/50' : 'text-emerald-200';
$textHover = $isDark ? 'hover:text-produce-lettuce' : 'hover:text-white';
$iconColor = $isDark ? 'text-produce-lettuce' : 'text-emerald-300';
$divider = $isDark ? 'border-white/5' : 'border-white/10';
$socialBg = $isDark ? 'bg-white/5 hover:bg-white/10' : 'bg-white/10 hover:bg-white/20';
@endphp

<footer class="{{ $bg }} text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                        <i data-lucide="leaf" class="h-6 w-6 {{ $iconColor }}" aria-hidden="true"></i>
                    </div>
                    <div>
                        <span class="text-xl font-heading font-bold text-white">{{ config('app.name', 'SIPSH') }}</span>
                        <p class="text-xs {{ $isDark ? 'text-produce-lettuce/70' : 'text-emerald-300' }} -mt-0.5">Sayuran Hidroponik</p>
                    </div>
                </div>
                <p class="{{ $textMuted }} text-sm mb-4">
                    Platform marketplace sayuran hidroponik segar, organik, dan berkualitas langsung dari petani.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="social-bounce flex h-9 w-9 items-center justify-center rounded-lg {{ $socialBg }} transition-colors">
                        <i data-lucide="facebook" class="h-4 w-4" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="social-bounce flex h-9 w-9 items-center justify-center rounded-lg {{ $socialBg }}" style="animation-delay: 0.05s;">
                        <i data-lucide="instagram" class="h-4 w-4" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="social-bounce flex h-9 w-9 items-center justify-center rounded-lg {{ $socialBg }}" style="animation-delay: 0.1s;">
                        <i data-lucide="twitter" class="h-4 w-4" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-heading font-semibold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm {{ $textMuted }}">
                    <li><a href="/" class="{{ $textHover }} transition-colors">Beranda</a></li>
                    <li><a href="/shop" class="{{ $textHover }} transition-colors">Belanja</a></li>
                    <li><a href="/petani/dashboard" class="{{ $textHover }} transition-colors">Dashboard Petani</a></li>
                    <li><a href="#" class="{{ $textHover }} transition-colors">Tentang Kami</a></li>
                </ul>
            </div>

            {{-- Customer Service --}}
            <div>
                <h4 class="font-heading font-semibold mb-4">Layanan Pelanggan</h4>
                <ul class="space-y-2 text-sm {{ $textMuted }}">
                    <li><a href="#" class="{{ $textHover }} transition-colors">Pusat Bantuan</a></li>
                    <li><a href="#" class="{{ $textHover }} transition-colors">Cara Berbelanja</a></li>
                    <li><a href="#" class="{{ $textHover }} transition-colors">Kebijakan Pengembalian</a></li>
                    <li><a href="#" class="{{ $textHover }} transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-heading font-semibold mb-4">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm {{ $textMuted }}">
                    <li class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="h-4 w-4 mt-0.5 flex-shrink-0 text-white/40" aria-hidden="true"></i>
                        <span>Jl. Pertanian No. 123, Jakarta, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="phone" class="h-4 w-4 flex-shrink-0 text-white/40" aria-hidden="true"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="mail" class="h-4 w-4 flex-shrink-0 text-white/40" aria-hidden="true"></i>
                        <span>info@sipsh.co.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t {{ $divider }} mt-8 pt-8 text-center text-sm {{ $textMuted }}">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'SIPSH') }}. All rights reserved.</p>
        </div>
    </div>
</footer>
