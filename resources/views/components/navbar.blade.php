@props([
    'showSearch' => true,
])

<nav x-data="{ mobileOpen: false }" class="navbar-scroll sticky top-0 z-50 w-full bg-white border-b border-gray-100/0 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-14 items-center justify-between gap-4">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 hover:opacity-80 transition-opacity shrink-0">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-600">
                    <i data-lucide="leaf" class="h-4 w-4 text-white" aria-hidden="true"></i>
                </div>
                <span class="font-heading font-bold text-base text-gray-900 hidden sm:block">{{ config('app.name', 'SIPSH') }}</span>
            </a>

            {{-- Right --}}
            <div class="flex items-center gap-1">
                @auth
                    <div class="flex items-center gap-1">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors hidden sm:inline-flex items-center gap-1.5">
                            <i data-lucide="layout-dashboard" class="h-4 w-4" aria-hidden="true"></i>
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">Keluar</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition-colors rounded-lg">Daftar</a>
                @endauth

                {{-- Mobile toggle --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-gray-600 hover:text-gray-900 transition-colors" :aria-expanded="mobileOpen" aria-label="Menu">
                    <i data-lucide="menu" class="h-5 w-5" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Overlay --}}
        <div x-show="mobileOpen"
             x-transition:enter="transition duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 bg-white sm:hidden"
             x-cloak>
            <div class="flex justify-end p-4">
                <button @click="mobileOpen = false" class="p-2 text-gray-600 hover:text-gray-900">
                    <i data-lucide="x" class="h-6 w-6" aria-hidden="true"></i>
                </button>
            </div>
            <div class="flex flex-col items-center justify-center min-h-[60vh] gap-6 px-8">
                @auth
                    <a href="{{ route('dashboard') }}" @click="mobileOpen = false" class="text-xl font-heading font-semibold text-gray-900 hover:text-emerald-600 transition-colors">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xl font-heading font-semibold text-red-600 hover:text-red-700 transition-colors">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" @click="mobileOpen = false" class="text-xl font-heading font-semibold text-gray-900 hover:text-emerald-600 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" @click="mobileOpen = false" class="text-xl font-heading font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
