<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-back-button class="mb-4" />

            <x-breadcrumb :crumbs="[['label' => 'Keranjang', 'url' => route('cart.index')], ['label' => 'Checkout']]" />

            <div class="mb-8 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-emerald-100">
                    <i data-lucide="shopping-bag" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-heading font-bold text-gray-900">Checkout Pesanan</h1>
                    <p class="text-sm text-gray-600 mt-0.5">Lengkapi informasi pengiriman Anda</p>
                </div>
            </div>

            @if($carts->isEmpty())
                <x-empty-state icon="shopping-cart" title="Keranjangmu kosong" description="Tambahkan produk ke keranjang terlebih dahulu sebelum checkout.">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                        <i data-lucide="store" class="w-4 h-4" aria-hidden="true"></i>
                        Mulai Belanja
                    </a>
                </x-empty-state>
            @else
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <div class="lg:col-span-2 space-y-6">

                            <div class="bg-white border border-gray-100 rounded-xl p-6">
                                <h2 class="font-heading font-semibold text-gray-900 mb-5">Informasi Pengiriman</h2>

                                @if(auth()->user()->alamat)
                                    <button type="button"
                                            x-data
                                            x-on:click="$el.nextElementSibling.value = @js(auth()->user()->alamat)"
                                            class="mb-4 text-xs font-medium text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                                        <i data-lucide="map-pin" style="width:12px;height:12px;" aria-hidden="true"></i>
                                        Gunakan Alamat Tersimpan
                                    </button>
                                @endif

                                <div class="mb-5">
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Alamat Pengiriman Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="shipping_address" name="shipping_address" rows="4" required
                                              placeholder="Contoh: Jl. Tanjung Harapan No. 12, RT 03/RW 01, Kelurahan Sambas, Kec. Sambas, Kalimantan Barat 79462"
                                              class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:ring-offset-0 transition-colors min-h-[88px] resize-none {{ $errors->has('shipping_address') ? 'border-red-400' : '' }}">{{ old('shipping_address', auth()->user()->alamat) }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5" x-data="{ metode: '{{ old('metode_pengiriman', 'ambil_ditempat') }}' }">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Metode Pengiriman <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-1.5">
                                        <template x-for="(opt, i) in [
                                            { value: 'ambil_ditempat', label: 'Ambil di Tempat', desc: 'Ambil langsung ke kebun', icon: 'store' },
                                            { value: 'antar_kurir', label: 'Antar Kurir', desc: 'Diantar kurir ke alamat', icon: 'bike' },
                                            { value: 'ekspedisi', label: 'Ekspedisi', desc: 'Via jasa kirim', icon: 'truck' },
                                        ]" :key="i">
                                            <label class="relative flex items-center gap-3 p-4 border rounded-lg cursor-pointer transition-colors"
                                                   :class="metode === opt.value ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 bg-white hover:border-gray-300'">
                                                <input type="radio" name="metode_pengiriman" :value="opt.value"
                                                       class="sr-only" x-model="metode">
                                                <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 bg-gray-50">
                                                    <i :data-lucide="opt.icon" style="width:18px;height:18px;color:#6b7280;" aria-hidden="true"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900" :class="metode === opt.value ? 'text-emerald-700' : ''" x-text="opt.label"></p>
                                                    <p class="text-[11px] text-gray-600" x-text="opt.desc"></p>
                                                </div>
                                                <div class="ml-auto shrink-0" x-show="metode === opt.value">
                                                    <i data-lucide="check-circle" style="width:18px;height:18px;color:#059669;" aria-hidden="true"></i>
                                                </div>
                                            </label>
                                        </template>
                                    </div>
                                    @error('metode_pengiriman')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="note" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Catatan Pesanan <span class="text-gray-600 font-normal">(opsional)</span>
                                    </label>
                                    <textarea id="note" name="note" rows="2"
                                              placeholder="Contoh: Minta dikemas rapi, jangan dihancurkan"
                                              class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:ring-offset-0 transition-colors min-h-[88px] resize-none {{ $errors->has('note') ? 'border-red-400' : '' }}">{{ old('note') }}</textarea>
                                    @error('note')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="border border-emerald-200 bg-emerald-50 rounded-lg p-5" x-data="{ metode: '{{ old('metode_pembayaran', '') }}' }">
                                <div class="flex items-start gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-emerald-100">
                                        <i data-lucide="landmark" style="width:18px;height:18px;color:#059669;" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <p class="font-heading font-semibold text-emerald-900 text-sm mb-1">Pilih Virtual Account</p>
                                        <p class="text-xs text-emerald-700">Pilih bank untuk mendapatkan nomor Virtual Account</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($channels as $key => $ch)
                                        <label class="relative flex items-center gap-3 p-3 border rounded-lg cursor-pointer transition-colors"
                                               :class="metode === '{{ $key }}' ? 'border-emerald-500 bg-emerald-100' : 'border-emerald-200 bg-white hover:border-emerald-300'">
                                            <input type="radio" name="metode_pembayaran" value="{{ $key }}"
                                                   class="sr-only" x-model="metode" required>
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 bg-emerald-100">
                                                <i data-lucide="building-2" style="width:16px;height:16px;color:#059669;" aria-hidden="true"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900" x-text="'{{ $ch['name'] }}'"></p>
                                                <p class="text-[10px] text-gray-600">Bayar via mobile banking</p>
                                            </div>
                                            <div x-show="metode === '{{ $key }}'">
                                                <i data-lucide="check-circle" style="width:16px;height:16px;color:#059669;" aria-hidden="true"></i>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('metode_pembayaran')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-white border border-gray-100 rounded-xl p-6 sticky top-20">
                                <h2 class="font-heading font-semibold text-gray-900 mb-5">Ringkasan Pesanan</h2>

                                <div class="space-y-3 mb-5">
                                    @foreach($carts as $cart)
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                                                @if($cart->product->image)
                                                    <img src="{{ asset('storage/' . $cart->product->image) }}"
                                                         alt="{{ $cart->product->name }}"
                                                         class="w-full h-full object-cover" loading="lazy"
                                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                                    <div class="w-full h-full hidden items-center justify-center bg-gray-50">
                                                        <i data-lucide="sprout" style="width:20px;height:20px;color:#d1d5db;" aria-hidden="true"></i>
                                                    </div>
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                                        <i data-lucide="sprout" style="width:20px;height:20px;color:#d1d5db;" aria-hidden="true"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800 truncate">{{ $cart->product->name }}</p>
                                                <p class="text-xs text-gray-600">{{ $cart->quantity }} × Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                            </div>
                                            <p class="text-sm font-medium text-gray-900 shrink-0">
                                                Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="mb-5 border-gray-100">

                                @php
                                    $checkoutDiscount = 0;
                                    $checkoutCoupon = session('coupon_code') ? \App\Models\Coupon::where('code', session('coupon_code'))->first() : null;
                                    if ($checkoutCoupon && $checkoutCoupon->isValid($total)) {
                                        $checkoutDiscount = $checkoutCoupon->calculateDiscount($total);
                                    }
                                @endphp

                                @if($checkoutDiscount > 0)
                                    <div class="flex justify-between items-center mb-2 text-sm">
                                        <span class="text-gray-600">Diskon Kupon</span>
                                        <span class="font-medium text-red-600">-Rp {{ number_format($checkoutDiscount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center mb-6">
                                    <span class="font-medium text-gray-600">Total Pembayaran</span>
                                    <span class="text-xl font-heading font-bold text-emerald-700">Rp {{ number_format(max(0, $total - $checkoutDiscount), 0, ',', '.') }}</span>
                                </div>

                                <x-loading-button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">
                                    <i data-lucide="shopping-bag" class="w-4 h-4" aria-hidden="true"></i>
                                    Buat Pesanan
                                </x-loading-button>

                                <p class="text-[11px] text-gray-600 mt-3 text-center leading-relaxed">
                                    Dengan menekan tombol ini, kamu menyetujui syarat &amp; ketentuan kami.
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
