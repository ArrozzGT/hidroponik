<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
                <i data-lucide="shopping-cart" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Keranjang Belanja') }}</h2>
                <p class="text-sm text-gray-400 mt-0.5">Review pesanan Anda sebelum checkout</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
            @if(session('success'))
                <div class="max-w-7xl mx-auto mb-6 px-4 sm:px-0">
                    <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl text-sm font-medium flex items-center gap-3 animate-[fadeIn_0.3s_ease-out]">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0" aria-hidden="true"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($carts->isEmpty())
                {{-- Empty State --}}
                <div class="max-w-lg mx-auto text-center py-16 px-4 reveal">
                    <div class="w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 bg-gradient-to-br from-green-50 to-emerald-50 shadow-sm border border-green-100 animate-float-y">
                        <i data-lucide="shopping-cart" class="w-12 h-12 text-green-300" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Keranjang Anda kosong</h3>
                    <p class="text-sm text-slate-500 mb-8 max-w-xs mx-auto leading-relaxed">Belum ada produk ditambahkan. Jelajahi toko untuk menemukan sayuran segar hidroponik.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold text-sm rounded-xl hover:bg-green-800 active:scale-95 transition-all shadow-md shadow-green-200 magnetic">
                        <i data-lucide="store" class="w-4 h-4" aria-hidden="true"></i>
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-8">
                    {{-- Cart Items --}}
                    <div class="flex-1 space-y-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-1.5 h-6 rounded-full bg-gradient-to-b from-green-500 to-green-700"></div>
                                <h2 class="text-lg font-bold text-slate-900">Produk Dipilih</h2>
                            </div>
                            <span class="badge-green text-[10px]">{{ $carts->count() }} item</span>
                        </div>

                        @foreach($carts as $ci => $cart)
                            @php
                                $subtotal = $cart->product->price * $cart->quantity;
                            @endphp
                            <div class="card p-4 sm:p-5 hover:shadow-md transition-all duration-200 border-slate-200/80 animate-[fadeIn_0.3s_ease-out] {{ 'stagger-' . (($ci % 8) + 1) }} hover-lift">
                                <div class="flex gap-4">
                                    {{-- Product Image --}}
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden flex-shrink-0 bg-slate-50 border border-slate-100">
                                        @if($cart->product->image)
                                            <img src="{{ asset('storage/' . $cart->product->image) }}" 
                                                 alt="{{ $cart->product->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i data-lucide="package" class="w-8 h-8 text-slate-300" aria-hidden="true"></i>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Product Info + Controls --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="min-w-0">
                                                <h3 class="font-bold text-sm sm:text-base text-slate-900 truncate">{{ $cart->product->name }}</h3>
                                                <p class="text-xs text-slate-500 mt-0.5">Stok: {{ $cart->product->stock }}</p>
                                            </div>
                                            <form action="{{ route('cart.remove', $cart) }}" method="POST" class="flex-shrink-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="mt-3 flex items-center justify-between gap-4">
                                            {{-- Quantity Controls --}}
                                            <div class="flex items-center gap-1 bg-slate-50 border border-slate-200 rounded-xl p-0.5">
                                                <form action="{{ route('cart.update', $cart) }}" method="POST" class="inline" id="decrease-form-{{ $cart->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ max(1, $cart->quantity - 1) }}">
                                                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-600 hover:bg-white hover:shadow-sm transition-all {{ $cart->quantity <= 1 ? 'opacity-30 cursor-not-allowed' : '' }}" {{ $cart->quantity <= 1 ? 'disabled' : '' }}>
                                                        <i data-lucide="minus" class="w-4 h-4" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                <span class="w-10 text-center text-sm font-bold text-slate-900 select-none">{{ $cart->quantity }}</span>
                                                <form action="{{ route('cart.update', $cart) }}" method="POST" class="inline" id="increase-form-{{ $cart->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ min($cart->product->stock, $cart->quantity + 1) }}">
                                                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-600 hover:bg-white hover:shadow-sm transition-all {{ $cart->quantity >= $cart->product->stock ? 'opacity-30 cursor-not-allowed' : '' }}" {{ $cart->quantity >= $cart->product->stock ? 'disabled' : '' }}>
                                                        <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- Subtotal --}}
                                            <div class="text-right">
                                                <p class="text-xs text-slate-400 font-medium">Subtotal</p>
                                                <p class="font-bold text-sm sm:text-base text-green-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        {{-- Unit Price --}}
                                        <p class="text-xs text-slate-400 mt-2">Rp {{ number_format($cart->product->price, 0, ',', '.') }} / pcs</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Continue Shopping --}}
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-green-700 hover:text-green-800 transition-colors group magnetic">
                            <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" aria-hidden="true"></i>
                            Lanjut Belanja
                        </a>
                    </div>

                    {{-- Order Summary Sidebar --}}
                    <div class="w-full lg:w-96 flex-shrink-0">
                        <div class="card p-6 sticky top-6 animate-[fadeIn_0.5s_ease-out] reveal hover-lift">
                            <div class="flex items-center gap-2.5 mb-6">
                                <div class="w-1.5 h-6 rounded-full bg-gradient-to-b from-green-500 to-green-700"></div>
                                <h2 class="text-lg font-bold text-slate-900">Ringkasan Pesanan</h2>
                            </div>

                            <div class="space-y-4">
                                @php
                                    $subtotalTotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
                                    $shipping = 0; // Free shipping or calculate as needed
                                    $grandTotal = $subtotalTotal + $shipping;
                                @endphp

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600">Subtotal ({{ $carts->count() }} item)</span>
                                    <span class="font-semibold text-slate-900">Rp {{ number_format($subtotalTotal, 0, ',', '.') }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600">Pengiriman</span>
                                    <span class="font-semibold text-green-700 bg-green-50 px-2.5 py-0.5 rounded-lg text-xs">GRATIS</span>
                                </div>

                                {{-- Divider --}}
                                <div class="border-t border-slate-100 pt-4"></div>

                                <div class="flex items-center justify-between">
                                    <span class="text-base font-bold text-slate-900">Total</span>
                                    <span class="text-xl font-extrabold text-green-700">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>

                                <a href="{{ route('checkout') }}" class="btn-primary w-full justify-center py-3 mt-2 magnetic">
                                    <i data-lucide="credit-card" class="w-4 h-4" aria-hidden="true"></i>
                                    Checkout Sekarang
                                </a>

                                <div class="flex items-center justify-center gap-2 text-xs text-slate-400 mt-3">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-green-500" aria-hidden="true"></i>
                                    <span>Pembayaran aman & terpercaya</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
