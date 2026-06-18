<x-app-layout>
    <div class="py-8 min-h-screen" style="background:#f0fdf4;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 reveal">

            {{-- Flash success (promt4 #3) --}}
            @if(session('success'))
                <div id="flash-success"
                     class="mb-6 flex items-center gap-3 px-5 py-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl font-medium animate-fade-in">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(() => {
                        const el = document.getElementById('flash-success');
                        if(el) el.style.transition = 'opacity 0.5s', el.style.opacity = '0', setTimeout(() => el.remove(), 500);
                    }, 5000);
                </script>
            @endif

            {{-- Page title --}}
            <div class="mb-8 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                     style="background:linear-gradient(135deg,#16a34a,#15803d);">
                    <i data-lucide="shopping-bag" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Checkout Pesanan</h1>
                    <p class="text-sm text-gray-400 mt-0.5">Lengkapi informasi pengiriman Anda</p>
                </div>
            </div>

            @if($carts->isEmpty())
                {{-- ══ Empty Cart State (promt4 #2) ══ --}}
                <div class="flex flex-col items-center justify-center py-24 text-center card card-pad animate-fade-in">
                    <div class="w-20 h-20 rounded-3xl mx-auto mb-5 flex items-center justify-center bg-green-50">
                        <i data-lucide="shopping-cart" style="width:36px;height:36px;color:#86efac;" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-600 mb-2">Keranjangmu kosong</h3>
                    <p class="text-gray-400 mb-6 text-sm">Tambahkan produk ke keranjang terlebih dahulu sebelum checkout.</p>
                    <a href="{{ route('shop.index') }}" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Mulai Belanja
                    </a>
                </div>
            @else
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf

                    {{-- ══ 2-COLUMN LAYOUT (promt4 #1) ══ --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        {{-- ═══ LEFT: Shipping Form (2/3 wide) ═══ --}}
                        <div class="lg:col-span-2 space-y-6 reveal stagger-1">

                            {{-- Informasi Pengiriman --}}
                            <div class="card card-pad hover-lift">
                                <h2 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                                         style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);">
                                        <i data-lucide="package" style="width:16px;height:16px;color:#16a34a;" aria-hidden="true"></i>
                                    </div>
                                    Informasi Pengiriman
                                </h2>

                                {{-- Prefill / saved address button --}}
                                @if(auth()->user()->alamat)
                                    <button type="button"
                                            onclick="document.getElementById('shipping_address').value = '{{ addslashes(auth()->user()->alamat) }}'"
                                            class="mb-4 text-xs font-semibold text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                                        <i data-lucide="map-pin" style="width:12px;height:12px;" aria-hidden="true"></i>
                                        Gunakan Alamat Tersimpan
                                    </button>
                                @endif

                                {{-- Alamat Pengiriman --}}
                                <div class="mb-5">
                                    <label for="shipping_address" class="form-label">
                                        Alamat Pengiriman Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="shipping_address" name="shipping_address" rows="4" required
                                              placeholder="Contoh: Jl. Tanjung Harapan No. 12, RT 03/RW 01, Kelurahan Sambas, Kec. Sambas, Kalimantan Barat 79462"
                                              class="form-input min-h-[88px] resize-none {{ $errors->has('shipping_address') ? 'border-red-400 bg-red-50' : '' }}">{{ old('shipping_address', auth()->user()->alamat) }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1.5 text-xs text-red-600 font-medium flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Metode Pengiriman --}}
                                <div class="mb-5" x-data="{ metode: '{{ old('metode_pengiriman', 'ambil_ditempat') }}' }">
                                    <label class="form-label">
                                        Metode Pengiriman <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-1.5">
                                        <template x-for="(opt, i) in [
                                            { value: 'ambil_ditempat', label: 'Ambil di Tempat', desc: 'Ambil langsung ke kebun', icon: 'store', bg: 'bg-amber-50', color: '#d97706' },
                                            { value: 'antar_kurir', label: 'Antar Kurir', desc: 'Diantar kurir ke alamat', icon: 'bike', bg: 'bg-blue-50', color: '#2563eb' },
                                            { value: 'ekspedisi', label: 'Ekspedisi', desc: 'Via jasa kirim', icon: 'truck', bg: 'bg-purple-50', color: '#7c3aed' },
                                        ]" :key="i">
                                            <label class="relative flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                                   :class="metode === opt.value ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-white hover:border-green-300'">
                                                <input type="radio" name="metode_pengiriman" :value="opt.value"
                                                       class="sr-only" x-model="metode">
                                                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" :class="opt.bg">
                                                    <i :data-lucide="opt.icon" :style="`width:18px;height:18px;color:${opt.color};`" aria-hidden="true"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-gray-900" :class="metode === opt.value ? 'text-green-700' : ''" x-text="opt.label"></p>
                                                    <p class="text-[11px] text-gray-400" x-text="opt.desc"></p>
                                                </div>
                                                <div class="ml-auto shrink-0" x-show="metode === opt.value">
                                                    <i data-lucide="check-circle" style="width:18px;height:18px;color:#16a34a;" aria-hidden="true"></i>
                                                </div>
                                            </label>
                                        </template>
                                    </div>
                                    @error('metode_pengiriman')
                                        <p class="mt-1.5 text-xs text-red-600 font-medium flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Catatan --}}
                                <div>
                                    <label for="note" class="form-label">
                                        Catatan Pesanan <span class="text-gray-400 font-normal">(opsional)</span>
                                    </label>
                                    <textarea id="note" name="note" rows="2"
                                              placeholder="Contoh: Minta dikemas rapi, jangan dihancurkan"
                                              class="form-input min-h-[88px] resize-none">{{ old('note') }}</textarea>
                                </div>
                            </div>

                            {{-- Info Pembayaran --}}
                            <div class="rounded-2xl border border-green-200 bg-green-50 p-5">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);">
                                        <i data-lucide="landmark" style="width:18px;height:18px;color:#16a34a;" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-green-900 text-sm mb-2">Pembayaran via Transfer Bank</p>
                                        <div class="space-y-1 text-sm text-green-800">
                                            <p>BCA &nbsp;→&nbsp; <strong class="font-mono">1234567890</strong> &nbsp;a/n <strong>Sistem Hidroponik SIPSH</strong></p>
                                            <p>Mandiri →&nbsp; <strong class="font-mono">0987654321</strong> &nbsp;a/n <strong>Sistem Hidroponik SIPSH</strong></p>
                                        </div>
                                        <p class="text-xs text-green-600 mt-3 flex items-center gap-1">
                                            <i data-lucide="info" style="width:12px;height:12px;" aria-hidden="true"></i>
                                            Setelah checkout, silakan upload bukti transfer di halaman pesanan Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ═══ RIGHT: Order Summary sticky (promt4 col kanan) ═══ --}}
                        <div class="lg:col-span-1 reveal stagger-2">
                            <div class="sticky top-24 hover-lift" style="background:rgba(255,255,255,0.9);backdrop-filter:blur(16px);border-radius:24px;border:1px solid #dcfce7;box-shadow:0 8px 32px rgba(22,163,74,0.12);padding:24px;">
                                <h2 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                                    <span class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#16a34a,#15803d);"></span>
                                    Ringkasan Pesanan
                                </h2>

                                {{-- Items list --}}
                                <div class="space-y-3 mb-5">
                                    @foreach($carts as $cart)
                                        <div class="flex items-center gap-3">
                                            {{-- Thumbnail --}}
                                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                                @if($cart->product->image)
                                                    <img src="{{ asset('storage/' . $cart->product->image) }}"
                                                         alt="{{ $cart->product->name }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-green-50">
                                                        <i data-lucide="sprout" style="width:20px;height:20px;color:#86efac;" aria-hidden="true"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $cart->product->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $cart->quantity }} × Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                            </div>
                                            <p class="text-sm font-bold text-gray-900 shrink-0">
                                                Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="mb-5 border-gray-100">

                                {{-- Total --}}
                                <div class="flex justify-between items-center mb-6">
                                    <span class="font-semibold text-gray-600">Total Pembayaran</span>
                                    <span class="text-xl font-extrabold text-primary-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>

                                {{-- Submit button --}}
                                <button type="submit" class="btn-primary w-full py-3.5 mt-2 magnetic">
                                    <i data-lucide="arrow-right" style="width:16px;height:16px;" aria-hidden="true"></i>
                                    Buat Pesanan
                                </button>
                                <p class="text-[11px] text-gray-400 mt-3 text-center leading-relaxed">
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
