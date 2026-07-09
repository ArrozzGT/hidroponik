<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title') @yield('title') – @endif{{ config('app.name', 'SIPSH') }} — Petani</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="{{ asset('vendor/lucide.min.js') }}"></script>
</head>
<body class="font-body antialiased bg-[#0a1612]">

<div x-data="petaniLayout()" x-init="init()" class="min-h-screen flex">

    {{-- Sidebar Overlay (mobile) --}}
    <div x-show="sidebarOpen" x-transition.opacity.duration.200ms
         class="fixed inset-0 z-30 bg-black/50 lg:hidden"
         @click="sidebarOpen = false" x-cloak></div>

    {{-- Sidebar --}}
    <aside id="sidebar"
           class="sidebar-dark fixed top-0 left-0 z-40 h-full w-56 lg:w-64 xl:w-72 flex flex-col
                  transition-transform duration-300 ease-in-out"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           x-cloak>

        {{-- Brand --}}
        <div class="sidebar-header flex items-center gap-2.5 px-4 h-14 shrink-0">
            <div class="w-7 h-7 rounded-lg" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
                <i data-lucide="sprout" style="width:15px;height:15px;color:#fff;" aria-hidden="true"></i>
            </div>
            <span class="font-heading font-bold text-base text-white">{{ config('app.name', 'SIPSH') }}</span>
            <span class="ml-auto text-[10px] font-medium text-harvest-leaf" style="background:rgba(34,197,94,0.15);padding:2px 8px;border-radius:6px;">Petani</span>
        </div>

        {{-- Navigation --}}
        <nav @click="sidebarOpen = false" class="flex-1 overflow-y-auto py-3 px-2 space-y-0.5">
            @php
                $petaniNav = [
                    ['route' => 'petani.dashboard',        'label' => 'Dashboard',       'icon' => 'layout-dashboard'],
                    ['route' => 'petani.products.index',  'label' => 'Produk Saya',     'icon' => 'sprout'],
                    ['route' => 'petani.panen.index',     'label' => 'Data Panen',      'icon' => 'tractor'],
                    ['route' => 'petani.stok-nutrisi.index','label' => 'Stok Nutrisi',  'icon' => 'flask-conical'],
                    ['route' => 'petani.orders.index',    'label' => 'Pesanan Masuk',   'icon' => 'clipboard-list'],
                    ['route' => 'notifications.index',    'label' => 'Notifikasi',      'icon' => 'bell'],
                    ['route' => 'shop.index',             'label' => 'Lihat Toko',      'icon' => 'store'],
                ];
            @endphp

            <div class="text-[10px] font-medium text-white/30 uppercase tracking-wider px-3 pt-3 pb-1.5">Menu</div>

            @foreach($petaniNav as $item)
                <a href="{{ route($item['route']) }}"
                   class="nav-item flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg
                          {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    <i data-lucide="{{ $item['icon'] }}" style="width:16px;height:16px;" aria-hidden="true"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="text-[10px] font-medium text-white/30 uppercase tracking-wider px-3 pt-5 pb-1.5">Akun</div>

            <a href="{{ route('profile.edit') }}"
               class="nav-item flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg
                      {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i data-lucide="settings" style="width:16px;height:16px;" aria-hidden="true"></i>
                Pengaturan Profil
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-1">
                @csrf
                <button type="submit"
                        class="nav-item flex items-center gap-2.5 w-full px-3 py-2 text-sm rounded-lg hover:text-harvest-tomato hover:bg-harvest-tomato/10">
                    <i data-lucide="log-out" style="width:16px;height:16px;" aria-hidden="true"></i>
                    Keluar
                </button>
            </form>
        </nav>

        {{-- Sidebar Footer --}}
        <div class="sidebar-header px-4 py-3 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full" style="background:linear-gradient(135deg,#22c55e,#16a34a);display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:600;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-white/80 truncate">{{ Auth::user()->name ?? '' }}</p>
                    <p class="text-[10px] text-white/40 truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
                <span class="px-1.5 py-0.5 text-[10px] font-medium text-harvest-leaf" style="background:rgba(34,197,94,0.15);border-radius:6px;">Petani</span>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col min-w-0 min-h-screen content-area" style="background-image:radial-gradient(at 20% 30%, rgba(34,197,94,0.06) 0px, transparent 50%),radial-gradient(at 80% 20%, rgba(250,204,21,0.03) 0px, transparent 50%);" :class="sidebarOpen ? 'lg:ml-64 xl:ml-72' : 'lg:ml-0'">
        {{-- Topbar --}}
        <header class="topbar-dark sticky top-0 z-20">
            <div class="flex items-center justify-between h-14 px-4 sm:px-6 lg:px-10">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="text-white/60 hover:text-white transition-colors lg:mr-1"
                            aria-controls="sidebar">
                        <i data-lucide="panel-left-close" x-show="sidebarOpen" style="width:18px;height:18px;" aria-hidden="true"></i>
                        <i data-lucide="panel-left-open" x-show="!sidebarOpen" style="width:18px;height:18px;" aria-hidden="true"></i>
                    </button>
                    <div class="hidden sm:flex items-center gap-1.5 text-sm text-white/50">
                        <span>Petani</span>
                        <span>/</span>
                        <span class="text-white/80 font-medium">@yield('page', 'Dashboard')</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('notifications.index') }}"
                       class="relative p-2 text-white/60 hover:text-white transition-colors rounded-lg hover:bg-white/5"
                       title="Notifikasi">
                        <i data-lucide="bell" style="width:18px;height:18px;" aria-hidden="true"></i>
                        @if(($notifCount ?? 0) > 0)
                            <span class="absolute top-1 right-1 w-3.5 h-3.5 bg-harvest-tomato text-white text-[8px] font-bold rounded-full flex items-center justify-center">{{ min($notifCount, 9) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('shop.index') }}"
                       class="p-2 text-white/60 hover:text-white transition-colors rounded-lg hover:bg-white/5"
                       title="Lihat Toko">
                        <i data-lucide="store" style="width:18px;height:18px;" aria-hidden="true"></i>
                    </a>
                    <x-dropdown align="right" width="52">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-1.5 text-sm text-white/60 hover:text-white transition-colors">
                                <div class="w-7 h-7 rounded-full" style="background:linear-gradient(135deg,#22c55e,#16a34a);display:flex;align-items:center;justify-content:center;color:#fff;font-size:10px;font-weight:600;">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                                </div>
                                <span class="hidden md:block">{{ Auth::user()->name ?? '' }}</span>
                                <i data-lucide="chevron-down" style="width:14px;height:14px;" aria-hidden="true"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-white/10" style="background:rgba(11,23,16,0.95);">
                                <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? '' }}</p>
                                <p class="text-xs text-white/50">{{ Auth::user()->email ?? '' }}</p>
                                <span class="inline-flex mt-1.5 px-2 py-0.5 text-[10px] font-medium text-harvest-leaf" style="background:rgba(34,197,94,0.15);border-radius:6px;">Petani</span>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 text-white/70 hover:text-white hover:bg-white/5">
                                <i data-lucide="settings" style="width:14px;height:14px;" aria-hidden="true"></i> Profil
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2 text-white/70 hover:text-white hover:bg-white/5">
                                    <i data-lucide="log-out" style="width:14px;height:14px;" aria-hidden="true"></i> Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-10">
            @hasSection('header')
                <div class="max-w-7xl mx-auto w-full mb-6">
                    @yield('header')
                </div>
            @elseif(isset($header))
                <div class="max-w-7xl mx-auto w-full mb-6">
                    {{ $header }}
                </div>
            @endisset

            @hasSection('petani-content')
                @yield('petani-content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
    </div>
</div>

<script>
    let _petaniResizeHandler = null;
    function petaniLayout() {
        return {
            sidebarOpen: window.innerWidth >= 1024,
            init() {
                if (_petaniResizeHandler) window.removeEventListener('resize', _petaniResizeHandler);
                _petaniResizeHandler = () => {
                    if (window.innerWidth >= 1024) this.sidebarOpen = true;
                    else this.sidebarOpen = false;
                };
                window.addEventListener('resize', _petaniResizeHandler);
            }
        };
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>

<button class="back-to-top fixed bottom-6 right-6 z-50 w-10 h-10 rounded-full" style="background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 20px rgba(34,197,94,0.3);display:flex;align-items:center;justify-content:center;transition:all 0.3s;opacity:0;visibility:hidden;" aria-label="Kembali ke atas">
    <i data-lucide="chevron-up" class="h-5 w-5" aria-hidden="true"></i>
</button>

@if(session('success'))<div data-toast="success" data-message="{{ session('success') }}"></div>@endif
@if(session('error'))<div data-toast="error" data-message="{{ session('error') }}"></div>@endif
<x-toast />
</body>
</html>
