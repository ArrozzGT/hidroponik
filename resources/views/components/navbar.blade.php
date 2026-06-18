@props([
    'showSearch' => true,
])

<nav x-data="{ mobileOpen: false }" class="sticky top-0 z-50 w-full border-b border-green-200/50 bg-white/80 backdrop-blur-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-4">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 hover:opacity-80 transition-opacity shrink-0">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-green-600 to-emerald-500 shadow-lg shadow-green-600/30">
                    <i data-lucide="leaf" class="h-5 w-5 text-white" aria-hidden="true"></i>
                </div>
                <span class="font-extrabold text-lg text-green-900 hidden sm:block">{{ config('app.name', 'SIPSH') }}</span>
            </a>

            {{-- Right --}}
            <div class="flex items-center gap-2">
                @auth
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-green-700 hover:bg-green-50 transition-colors hidden sm:inline-flex items-center gap-1.5">
                            <i data-lucide="layout-dashboard" class="h-4 w-4" aria-hidden="true"></i>
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-green-900 hover:bg-green-50 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 rounded-xl text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors shadow-lg shadow-green-600/30">Daftar</a>
                @endauth

                {{-- Mobile toggle --}}
                <button @click="mobileOpen = !mobileOpen" class="sm:hidden p-2 rounded-xl hover:bg-green-50 transition-colors text-green-900" :aria-expanded="mobileOpen" aria-label="Menu">
                    <i data-lucide="menu" class="h-5 w-5" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-collapse.duration.200ms class="sm:hidden pb-4" x-cloak>
            <div class="flex flex-col gap-1 pt-2 border-t border-green-100">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-3 py-2.5 rounded-xl text-sm font-semibold text-green-900 hover:bg-green-50 transition-colors">
                        <i data-lucide="layout-dashboard" class="h-4 w-4 inline mr-2" aria-hidden="true"></i>Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-1">
                        @csrf
                        <button type="submit" class="w-full px-3 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors text-left">
                            <i data-lucide="log-out" class="h-4 w-4 inline mr-2" aria-hidden="true"></i>Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2.5 rounded-xl text-sm font-semibold text-green-900 hover:bg-green-50 transition-colors">
                        <i data-lucide="log-in" class="h-4 w-4 inline mr-2" aria-hidden="true"></i>Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-3 py-2.5 rounded-xl text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-colors text-center mt-1">
                        <i data-lucide="user-plus" class="h-4 w-4 inline mr-2" aria-hidden="true"></i>Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
