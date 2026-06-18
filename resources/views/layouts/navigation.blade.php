<nav x-data="{ open: false }" class="bg-white/85 backdrop-blur-xl border-b border-gray-200/50 sticky top-0 z-50 shadow-soft">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- ══ LEFT: Logo + Nav Links ══ --}}
            <div class="flex items-center gap-6">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0 group">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-glow transition-all duration-300 group-hover:scale-105"
                        style="background:linear-gradient(135deg,#22c55e,#15803d);">
                        <i data-lucide="leaf" style="width:18px;height:18px;color:#fff;" aria-hidden="true"></i>
                    </div>
                    <span class="font-extrabold text-lg tracking-tight hidden sm:block"
                          style="background:linear-gradient(135deg,#15803d,#22c55e);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                        {{ config('app.name', 'SIPSH') }}
                    </span>
                </a>

                {{-- Desktop Nav --}}
                @auth
                <div class="hidden sm:flex items-center gap-0.5 -my-px">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i data-lucide="layout-dashboard" style="width:15px;height:15px;display:inline;" aria-hidden="true"></i>
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                        <i data-lucide="store" style="width:15px;height:15px;display:inline;" aria-hidden="true"></i>
                        Toko
                    </x-nav-link>

                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            <i data-lucide="users" style="width:15px;height:15px;display:inline;" aria-hidden="true"></i>
                            User
                        </x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            <i data-lucide="package" style="width:15px;height:15px;display:inline;" aria-hidden="true"></i>
                            Pesanan
                        </x-nav-link>
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            <i data-lucide="tag" style="width:15px;height:15px;display:inline;" aria-hidden="true"></i>
                            Kategori
                        </x-nav-link>
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                            <i data-lucide="bar-chart-2" style="width:15px;height:15px;display:inline;" aria-hidden="true"></i>
                            Laporan
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role === 'petani')
                        <x-nav-link :href="route('petani.products.index')" :active="request()->routeIs('petani.products.*')">
                            <i data-lucide="sprout" style="width:15px;height:15px;display:inline;" aria-hidden="true"></i>
                            Produk Saya
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role === 'pembeli')
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            <i data-lucide="clipboard-list" style="width:15px;height:15px;display:inline;" aria-hidden="true"></i>
                            Pesanan
                        </x-nav-link>
                    @endif
                </div>
                @endauth
            </div>

            {{-- ══ RIGHT: Cart + User dropdown ══ --}}
            <div class="hidden sm:flex items-center gap-3">

                @auth
                    {{-- Cart icon (pembeli) --}}
                    @if(auth()->user()->role === 'pembeli')
                        @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
                        <a href="{{ route('cart.index') }}"
                           class="relative w-9 h-9 flex items-center justify-center rounded-xl text-gray-500 hover:text-green-700 hover:bg-green-50 transition-all">
                            <i data-lucide="shopping-cart" style="width:19px;height:19px;" aria-hidden="true"></i>
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 text-white text-[9px] font-bold rounded-full flex items-center justify-center leading-none"
                                    style="background:linear-gradient(135deg,#22c55e,#15803d);">
                                    {{ $cartCount > 9 ? '9+' : $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- User Dropdown --}}
                    <x-dropdown align="right" width="52">
                        <x-slot name="trigger">
                            <button class="group inline-flex items-center px-3 py-2 border border-gray-200/60 rounded-full text-sm font-medium text-gray-600 bg-white/70 hover:bg-white hover:border-green-200 hover:text-gray-800 focus:outline-none transition-all duration-200 shadow-soft hover:shadow-soft-md gap-2">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                    style="background:linear-gradient(135deg,#22c55e,#15803d);">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:block">{{ Auth::user()->name }}</span>
                                <i data-lucide="chevron-down" style="width:14px;height:14px;color:#9ca3af;" aria-hidden="true"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-xs font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                                <span class="inline-flex mt-1.5 px-2 py-0.5 text-[10px] font-bold uppercase rounded-full
                                    {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-700' :
                                       (Auth::user()->role === 'petani' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ Auth::user()->role }}
                                </span>
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

                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition-colors px-3 py-2">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2 text-white text-sm font-semibold rounded-full hover:opacity-90 transition-all shadow-glow"
                            style="background:linear-gradient(135deg,#22c55e,#15803d);">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

            {{-- ══ Mobile hamburger ══ --}}
            <div class="-me-2 flex items-center sm:hidden">
                @auth
                @if(auth()->user()->role === 'pembeli')
                    @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
                    <a href="{{ route('cart.index') }}" class="relative mr-2 w-9 h-9 flex items-center justify-center rounded-xl text-gray-500">
                        <i data-lucide="shopping-cart" style="width:19px;height:19px;" aria-hidden="true"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-600 text-white text-[9px] font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                @endif
                @endauth
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 hover:text-green-700 hover:bg-green-50 focus:outline-none transition-all duration-200">
                    <i data-lucide="menu" :class="{'hidden': open}" style="width:22px;height:22px;" aria-hidden="true"></i>
                    <i data-lucide="x" :class="{'hidden': ! open}" class="hidden" style="width:22px;height:22px;" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ══ Mobile Menu ══ --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100 bg-white/95 backdrop-blur-xl">
        <div class="pt-2 pb-3 space-y-1 px-3">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <i data-lucide="layout-dashboard" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Dashboard
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                    <i data-lucide="store" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Toko
                </x-responsive-nav-link>

                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        <i data-lucide="users" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>User
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                        <i data-lucide="package" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Pesanan
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        <i data-lucide="tag" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Kategori
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                        <i data-lucide="bar-chart-2" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Laporan
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.logs.index')" :active="request()->routeIs('admin.logs.*')">
                        <i data-lucide="scroll-text" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Log
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->role === 'petani')
                    <x-responsive-nav-link :href="route('petani.products.index')" :active="request()->routeIs('petani.products.*')">
                        <i data-lucide="sprout" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Produk Saya
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->role === 'pembeli')
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        <i data-lucide="shopping-cart" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Keranjang
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        <i data-lucide="clipboard-list" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Pesanan
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('login')">
                    <i data-lucide="log-in" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Masuk
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    <i data-lucide="user-plus" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Daftar
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
        <div class="pt-3 pb-4 border-t border-gray-100 px-3">
            <div class="px-3 pb-3 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm"
                    style="background:linear-gradient(135deg,#22c55e,#15803d);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-sm text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <x-responsive-nav-link :href="route('profile.edit')">
                <i data-lucide="settings" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Profil
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i data-lucide="log-out" style="width:15px;height:15px;display:inline;margin-right:6px;" aria-hidden="true"></i>Keluar
                </x-responsive-nav-link>
            </form>
        </div>
        @endauth
    </div>
</nav>
