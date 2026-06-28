<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
                <i data-lucide="shopping-cart" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">{{ __('Keranjang Belanja') }}</h2>
                <p class="text-sm text-gray-600 mt-0.5">Review pesanan Anda sebelum checkout</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-back-button class="mb-4" />

            <x-breadcrumb :crumbs="[['label' => 'Keranjang']]" />

            @if($carts->isEmpty())
                <x-empty-state icon="shopping-cart" title="Keranjang Anda kosong" description="Belum ada produk ditambahkan. Jelajahi toko untuk menemukan sayuran segar hidroponik.">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                        <i data-lucide="store" class="w-4 h-4" aria-hidden="true"></i>
                        Mulai Belanja
                    </a>
                </x-empty-state>
            @else
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="flex-1 space-y-4">
                        <h2 class="font-heading font-semibold text-gray-900 mb-2">Produk Dipilih ({{ $carts->count() }} item)</h2>

                        @foreach($carts as $ci => $cart)
                            @php $subtotal = $cart->product->price * $cart->quantity; @endphp
                            <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
                                <div class="flex gap-4">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden flex-shrink-0 bg-gray-50">
                                        @if($cart->product->image)
                                            <img src="{{ asset('storage/' . $cart->product->image) }}" 
                                                 alt="{{ $cart->product->name }}"
                                                 class="w-full h-full object-cover" loading="lazy"
                                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                            <div class="w-full h-full hidden items-center justify-center">
                                                <i data-lucide="package" class="w-8 h-8 text-gray-600" aria-hidden="true"></i>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i data-lucide="package" class="w-8 h-8 text-gray-600" aria-hidden="true"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="min-w-0">
                                                <a href="{{ route('shop.show', $cart->product->slug) }}" class="font-heading font-semibold text-sm sm:text-base text-gray-900 truncate block hover:text-emerald-600 transition-colors">{{ $cart->product->name }}</a>
                                                <p class="text-xs text-gray-600 mt-0.5">Stok: {{ $cart->product->stock }}</p>
                                            </div>
                                            <form action="{{ route('cart.remove', $cart) }}" method="POST" class="flex-shrink-0"
                                                  onsubmit="return confirm('Hapus {{ $cart->product->name }} dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-600 hover:text-red-500 hover:bg-red-50 transition-colors" title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="mt-3 flex items-center justify-between gap-4">
                                            <div class="flex items-center gap-1 border border-gray-200 rounded-md">
                                                <form action="{{ route('cart.update', $cart) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ max(1, $cart->quantity - 1) }}">
                                                    <button type="submit" class="w-8 h-8 rounded-md flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors {{ $cart->quantity <= 1 ? 'opacity-30 cursor-not-allowed' : '' }}" {{ $cart->quantity <= 1 ? 'disabled' : '' }}>
                                                        <i data-lucide="minus" class="w-4 h-4" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                <span class="w-10 text-center text-sm font-medium text-gray-900 select-none">{{ $cart->quantity }}</span>
                                                <form action="{{ route('cart.update', $cart) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ min($cart->product->stock, $cart->quantity + 1) }}">
                                                    <button type="submit" class="w-8 h-8 rounded-md flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors {{ $cart->quantity >= $cart->product->stock ? 'opacity-30 cursor-not-allowed' : '' }}" {{ $cart->quantity >= $cart->product->stock ? 'disabled' : '' }}>
                                                        <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="text-right">
                                                <p class="text-xs text-gray-600 font-medium">Subtotal</p>
                                                <p class="font-heading font-semibold text-sm sm:text-base text-emerald-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <p class="text-xs text-gray-600 mt-2">Rp {{ number_format($cart->product->price, 0, ',', '.') }} / {{ $cart->product->unit }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-emerald-600 hover:text-emerald-700 transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                            Lanjut Belanja
                        </a>
                    </div>

                    <div class="w-full lg:w-96 flex-shrink-0">
                        <div class="bg-white border border-gray-100 rounded-xl p-6 sticky top-20">
                            <h2 class="font-heading font-semibold text-gray-900 mb-5">Ringkasan Pesanan</h2>

                            <div class="space-y-4">
                                @php
                                    $subtotalTotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
                                    $shipping = 0;
                                    $grandTotal = $subtotalTotal - $discount + $shipping;
                                @endphp

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Subtotal ({{ $carts->count() }} item)</span>
                                    <span class="font-medium text-gray-900">Rp {{ number_format($subtotalTotal, 0, ',', '.') }}</span>
                                </div>

                                @if($discount > 0)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Diskon Kupon</span>
                                        <span class="font-medium text-red-600">-Rp {{ number_format($discount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Pengiriman</span>
                                    <span class="font-medium text-emerald-600 text-xs">GRATIS</span>
                                </div>

                                <div class="border-t border-gray-100 pt-4"></div>

                                <div class="flex items-center justify-between">
                                    <span class="font-heading font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-heading font-bold text-emerald-700">Rp {{ number_format(max(0, $grandTotal), 0, ',', '.') }}</span>
                                </div>

                                <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                                    @if($coupon)
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-xs font-semibold text-amber-800 flex items-center gap-1.5">
                                                    <i data-lucide="tag" class="w-3.5 h-3.5" aria-hidden="true"></i>
                                                    {{ $coupon->code }}
                                                </p>
                                                <p class="text-xs text-amber-600 mt-0.5">Diskon {{ $coupon->type === 'percentage' ? $coupon->value . '%' : 'Rp ' . number_format($coupon->value, 0, ',', '.') }}</p>
                                            </div>
                                            <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-medium">Hapus</button>
                                            </form>
                                        </div>
                                    @else
                                        <form action="{{ route('cart.coupon') }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <div class="flex-1">
                                                <input type="text" name="code" placeholder="Kode kupon"
                                                       class="w-full px-3 py-1.5 text-xs border border-amber-300 rounded-md focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                                            </div>
                                            <button type="submit" class="shrink-0 px-3 py-1.5 text-xs font-medium text-amber-800 bg-amber-100 hover:bg-amber-200 rounded-md transition-colors">Pakai</button>
                                        </form>
                                    @endif
                                </div>

                                <a href="{{ route('checkout') }}" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-lg font-medium transition-colors mt-2">
                                    Checkout Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
