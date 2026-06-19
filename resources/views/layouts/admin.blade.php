<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title') @yield('title') – @endif{{ config('app.name', 'SIPSH') }} — Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased bg-gray-50">

<div x-data="adminLayout()" x-init="init()" class="min-h-screen flex">

    {{-- Sidebar Overlay (mobile) --}}
    <div x-show="sidebarOpen" x-transition.opacity.duration.200ms
         class="fixed inset-0 z-30 bg-black/30 lg:hidden"
         @click="sidebarOpen = false" x-cloak></div>

    {{-- Sidebar --}}
    <aside id="sidebar"
           class="fixed top-0 left-0 z-40 h-full w-56 flex flex-col
                  bg-white border-r border-gray-100
                  transition-transform duration-300 ease-in-out"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           x-cloak>

        {{-- Brand --}}
        <div class="flex items-center gap-2.5 px-4 h-14 shrink-0 border-b border-gray-100">
            <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center">
                <i data-lucide="leaf" style="width:15px;height:15px;color:#fff;" aria-hidden="true"></i>
            </div>
            <span class="font-heading font-bold text-base text-gray-900">{{ config('app.name', 'SIPSH') }}</span>
            <span class="ml-auto text-[10px] font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Admin</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-3 px-2 space-y-0.5">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',     'label' => 'Dashboard',  'icon' => 'layout-dashboard'],
                    ['route' => 'admin.users.index',    'label' => 'Users',      'icon' => 'users'],
                    ['route' => 'admin.orders.index',   'label' => 'Pesanan',    'icon' => 'clipboard-list'],
                    ['route' => 'admin.transaksi.index','label' => 'Transaksi',  'icon' => 'credit-card'],
                    ['route' => 'admin.categories.index','label' => 'Kategori',  'icon' => 'tag'],
                    ['route' => 'admin.reports.index',  'label' => 'Laporan',    'icon' => 'bar-chart-2'],
                    ['route' => 'admin.logs.index',     'label' => 'Log',        'icon' => 'scroll-text'],
                    ['route' => 'notifications.index',  'label' => 'Notifikasi', 'icon' => 'bell'],
                ];
            @endphp

            <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider px-3 pt-3 pb-1.5">Menu</div>

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-colors
                          {{ request()->routeIs($item['route']) ? 'bg-emerald-50 text-emerald-700 font-medium border-l-2 border-emerald-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    <i data-lucide="{{ $item['icon'] }}" style="width:16px;height:16px;" aria-hidden="true"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider px-3 pt-5 pb-1.5">Lainnya</div>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('profile.edit') ? 'bg-emerald-50 text-emerald-700 font-medium border-l-2 border-emerald-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                <i data-lucide="settings" style="width:16px;height:16px;" aria-hidden="true"></i>
                Pengaturan
            </a>

            <a href="{{ route('shop.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg transition-colors text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                <i data-lucide="store" style="width:16px;height:16px;" aria-hidden="true"></i>
                Lihat Toko
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-1">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2.5 w-full px-3 py-2 text-sm rounded-lg transition-colors text-gray-600 hover:text-red-600 hover:bg-red-50">
                    <i data-lucide="log-out" style="width:16px;height:16px;" aria-hidden="true"></i>
                    Keluar
                </button>
            </form>
        </nav>

        {{-- Sidebar Footer --}}
        <div class="px-4 py-3 border-t border-gray-100 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs font-medium">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-700 truncate">{{ Auth::user()->name ?? '' }}</p>
                    <p class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
                <span class="px-1.5 py-0.5 text-[10px] font-medium text-emerald-600 bg-emerald-50 rounded-md">Admin</span>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col min-w-0 min-h-screen lg:ml-56">
        {{-- Topbar --}}
        <header class="sticky top-0 z-20 bg-white border-b border-gray-100">
            <div class="flex items-center justify-between h-14 px-4 sm:px-6 lg:px-10">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="text-gray-400 hover:text-gray-600 transition-colors lg:mr-1"
                            :title="sidebarOpen ? 'Tutup sidebar' : 'Buka sidebar'"
                            aria-controls="sidebar">
                        <i data-lucide="panel-left-close" x-show="sidebarOpen" style="width:18px;height:18px;" aria-hidden="true"></i>
                        <i data-lucide="panel-left-open" x-show="!sidebarOpen" style="width:18px;height:18px;" aria-hidden="true"></i>
                    </button>
                    <div class="hidden sm:flex items-center gap-1.5 text-sm text-gray-400">
                        <span>Admin</span>
                        <span>/</span>
                        <span class="text-gray-700 font-medium">@yield('page', 'Dashboard')</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('notifications.index') }}"
                       class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors rounded-lg hover:bg-gray-50"
                       title="Notifikasi">
                        <i data-lucide="bell" style="width:18px;height:18px;" aria-hidden="true"></i>
                        @if(($notifCount ?? 0) > 0)
                            <span class="absolute top-1 right-1 w-3.5 h-3.5 bg-red-500 text-white text-[8px] font-bold rounded-full flex items-center justify-center">{{ min($notifCount, 9) }}</span>
                        @endif
                    </a>
                    <x-dropdown align="right" width="52">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 transition-colors">
                                <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs font-medium">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="hidden md:block">{{ Auth::user()->name ?? '' }}</span>
                                <i data-lucide="chevron-down" style="width:14px;height:14px;color:#9ca3af;" aria-hidden="true"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? '' }}</p>
                                <p class="text-xs text-gray-400">{{ Auth::user()->email ?? '' }}</p>
                                <span class="inline-flex mt-1.5 px-2 py-0.5 text-[10px] font-medium bg-emerald-50 text-emerald-700 rounded-md">Admin</span>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <i data-lucide="settings" style="width:14px;height:14px;" aria-hidden="true"></i> Profil
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2">
                                    <i data-lucide="log-out" style="width:14px;height:14px;" aria-hidden="true"></i> Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6 lg:p-10">
            @hasSection('header')
                <div class="max-w-7xl mx-auto w-full mb-6">
                    @yield('header')
                </div>
            @elseif(isset($header))
                <div class="max-w-7xl mx-auto w-full mb-6">
                    {{ $header }}
                </div>
            @endisset

            @hasSection('admin-content')
                @yield('admin-content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
    </div>
</div>

<script>
    function adminLayout() {
        return {
            sidebarOpen: window.innerWidth >= 1024,
            init() {
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) this.sidebarOpen = true;
                });
            }
        };
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>

@if(session('success'))<div data-toast="success" data-message="{{ session('success') }}"></div>@endif
@if(session('error'))<div data-toast="error" data-message="{{ session('error') }}"></div>@endif
<x-toast />
</body>
</html>
