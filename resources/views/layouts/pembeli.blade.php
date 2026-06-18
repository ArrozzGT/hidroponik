<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title') @yield('title') – @endif{{ config('app.name', 'SIPSH') }} — Pembeli</title>

    <!-- Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">

<div x-data="pembeliLayout()" x-init="init()" class="min-h-screen flex flex-col lg:flex-row">

    {{-- ══ SIDEBAR OVERLAY (mobile) ══ --}}
    <div x-show="sidebarOpen" x-transition.opacity.duration.200ms
         class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm lg:hidden"
         @click="sidebarOpen = false" x-cloak></div>

    {{-- ══ SIDEBAR ══ --}}
    <aside id="sidebar" class="fixed top-0 left-0 z-40 h-full w-64 flex flex-col
                   transition-transform duration-300 ease-in-out
                   text-white shadow-2xl lg:rounded-r-2xl"
           style="background: linear-gradient(180deg, #134e4a 0%, #0f766e 50%, #0d9488 100%);"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           x-cloak>

        {{-- Sidebar Header --}}
            <div class="flex items-center gap-3 px-5 h-16 shrink-0 border-b border-teal-600/50 overflow-hidden">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-glow shrink-0"
                 style="background:linear-gradient(135deg,#2dd4bf,#0d9488);">
                <i data-lucide="shopping-bag" style="width:18px;height:18px;color:#fff;" aria-hidden="true"></i>
            </div>
            <span class="font-extrabold text-lg tracking-tight truncate min-w-0"
                  style="background:linear-gradient(135deg,#99f6e4,#2dd4bf);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                {{ config('app.name', 'SIPSH') }}
            </span>
            <span class="ml-auto text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full bg-teal-700 text-teal-300 border border-teal-600/50">Pembeli</span>
        </div>

        {{-- Sidebar Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @php
                $pembeliNav = [
                    ['route' => 'pembeli.dashboard',   'label' => 'Dashboard',      'icon' => 'layout-dashboard'],
                    ['route' => 'shop.index',         'label' => 'Toko',           'icon' => 'store'],
                    ['route' => 'cart.index',         'label' => 'Keranjang',      'icon' => 'shopping-cart',  'badge' => $cartCount ?? 0],
                    ['route' => 'orders.index',       'label' => 'Pesanan Saya',   'icon' => 'clipboard-list'],
                    ['route' => 'notifications.index', 'label' => 'Notifikasi',    'icon' => 'bell',           'badge' => $notifCount ?? 0],
                ];
            @endphp

            <div class="text-[10px] font-bold uppercase tracking-widest text-teal-400/70 px-3 pt-4 pb-2">Menu Utama</div>

            @foreach($pembeliNav as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group
                          {{ request()->routeIs($item['route']) ? 'bg-teal-600/70 text-white shadow-md' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0
                                {{ request()->routeIs($item['route']) ? 'bg-teal-500' : 'bg-teal-800/50 group-hover:bg-teal-700/70' }}
                                 transition-all duration-150">
                        <i data-lucide="{{ $item['icon'] }}" style="width:16px;height:16px;" aria-hidden="true"></i>
                    </span>
                    {{ $item['label'] }}
                    @if(!empty($item['badge']) && $item['badge'] > 0)
                        <span class="ml-auto min-w-[18px] h-[18px] px-1 rounded-full text-[10px] font-bold flex items-center justify-center" style="background:linear-gradient(135deg,#2dd4bf,#0d9488);">{{ $item['badge'] > 9 ? '9+' : $item['badge'] }}</span>
                    @elseif(request()->routeIs($item['route']))
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-teal-300 animate-pulse"></span>
                    @endif
                </a>
            @endforeach

            <div class="text-[10px] font-bold uppercase tracking-widest text-teal-400/70 px-3 pt-6 pb-2">Akun</div>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group
                      {{ request()->routeIs('profile.edit') ? 'bg-teal-600/70 text-white shadow-md' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 bg-teal-800/50 group-hover:bg-teal-700/70 transition-all duration-150">
                    <i data-lucide="settings" style="width:16px;height:16px;" aria-hidden="true"></i>
                </span>
                Pengaturan Profil
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group text-teal-100 hover:bg-red-800/60 hover:text-red-200">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 bg-teal-800/50 group-hover:bg-red-700/70 transition-all duration-150">
                        <i data-lucide="log-out" style="width:16px;height:16px;" aria-hidden="true"></i>
                    </span>
                    Keluar
                </button>
            </form>
        </nav>

        {{-- Sidebar Footer --}}
        <div class="px-5 py-3 border-t border-teal-600/50 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0"
                     style="background:linear-gradient(135deg,#2dd4bf,#0f766e);">
                    {{ strtoupper(substr(Auth::user()->name ?? 'B', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? '' }}</p>
                    <p class="text-[10px] text-teal-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ══ MAIN CONTENT AREA ══ --}}
    <div class="flex-1 flex flex-col min-w-0 min-h-screen transition-all duration-300"
         :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">

        {{-- Top Navbar --}}
        <header class="sticky top-0 z-20 bg-white/90 backdrop-blur-xl border-b border-slate-200/80 shadow-soft">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">

                {{-- Left: hamburger + breadcrumb --}}
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:text-teal-700 hover:bg-teal-50 transition-all duration-200 lg:mr-1"
                            :title="sidebarOpen ? 'Tutup sidebar' : 'Buka sidebar'"
                            :aria-expanded="sidebarOpen"
                            aria-controls="sidebar">
                        <i data-lucide="panel-left-close" x-show="sidebarOpen" style="width:19px;height:19px;" aria-hidden="true"></i>
                        <i data-lucide="panel-left-open" x-show="!sidebarOpen" style="width:19px;height:19px;" aria-hidden="true"></i>
                    </button>

                    <div class="hidden sm:flex items-center gap-2 text-sm text-slate-400">
                        <span class="font-medium text-slate-600">Pembeli</span>
                        <span>/</span>
                        <span class="text-slate-900 font-semibold">@yield('page', 'Dashboard')</span>
                    </div>
                </div>

                {{-- Right: cart badge + user --}}
                <div class="flex items-center gap-2">

                    {{-- Cart icon --}}
                    <a href="{{ route('cart.index') }}"
                       class="relative w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:text-teal-700 hover:bg-teal-50 transition-all duration-200"
                       title="Keranjang">
                        <i data-lucide="shopping-cart" style="width:19px;height:19px;" aria-hidden="true"></i>
                        @if(($cartCount ?? 0) > 0)
                            <span class="absolute -top-0.5 -right-0.5 w-4 h-4 text-white text-[9px] font-bold rounded-full flex items-center justify-center leading-none"
                                  style="background:linear-gradient(135deg,#0d9488,#0f766e);">{{ min($cartCount ?? 0, 9) }}</span>
                        @endif
                    </a>

                    {{-- Notifications bell --}}
                    <a href="{{ route('notifications.index') }}"
                       class="relative w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:text-teal-700 hover:bg-teal-50 transition-all duration-200"
                       title="Notifikasi">
                        <i data-lucide="bell" style="width:19px;height:19px;" aria-hidden="true"></i>
                        @if(($notifCount ?? 0) > 0)
                            <span class="absolute -top-0.5 -right-0.5 w-4 h-4 text-white text-[9px] font-bold rounded-full flex items-center justify-center leading-none"
                                  style="background:linear-gradient(135deg,#ef4444,#dc2626);">{{ min($notifCount, 9) }}</span>
                        @endif
                    </a>

                    {{-- User dropdown --}}
                    <x-dropdown align="right" width="52">
                        <x-slot name="trigger">
                            <button class="group inline-flex items-center px-3 py-2 border border-slate-200/60 rounded-full text-sm font-medium text-slate-600 bg-white/70 hover:bg-white hover:border-teal-200 hover:text-slate-800 focus:outline-none transition-all duration-200 shadow-soft hover:shadow-soft-md gap-2">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                     style="background:linear-gradient(135deg,#2dd4bf,#0f766e);">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'B', 0, 1)) }}
                                </div>
                                <span class="hidden md:block">{{ Auth::user()->name ?? '' }}</span>
                                <i data-lucide="chevron-down" style="width:14px;height:14px;color:#9ca3af;" aria-hidden="true"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name ?? '' }}</p>
                                <p class="text-xs text-slate-400">{{ Auth::user()->email ?? '' }}</p>
                                <span class="inline-flex mt-1.5 px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-teal-100 text-teal-700">Pembeli</span>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <i data-lucide="settings" style="width:14px;height:14px;" aria-hidden="true"></i> &nbsp;Profil
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2">
                                    <i data-lucide="log-out" style="width:14px;height:14px;" aria-hidden="true"></i> &nbsp;Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1">
            @hasSection('header')
                <div class="page-header border-b border-slate-100 bg-white/50">
                    <div class="max-w-7xl mx-auto w-full py-3 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </div>
            @elseif(isset($header))
                <div class="page-header border-b border-slate-100 bg-white/50">
                    <div class="max-w-7xl mx-auto w-full py-3 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            @hasSection('pembeli-content')
                @yield('pembeli-content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
    </div>
</div>
<script>
    function pembeliLayout() {
        return {
            sidebarOpen: window.innerWidth >= 1024,
            init() {
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        this.sidebarOpen = true;
                    }
                });
            }
        };
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>

</body>
</html>
