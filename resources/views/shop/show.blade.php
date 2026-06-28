<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-back-button class="mb-4" />

            <x-breadcrumb :crumbs="[
                ['label' => 'Shop', 'url' => route('shop.index')],
                ['label' => $product->category->name, 'url' => route('shop.index', ['category' => $product->category->slug])],
                ['label' => $product->name],
            ]" />

            {{-- MAIN LAYOUT --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 mb-12 animate-fade-in-up">

                {{-- LEFT: Photo --}}
                <div class="lg:col-span-3">
                    <div class="rounded-xl overflow-hidden bg-gray-50 relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-[500px] lg:h-[600px] object-cover" loading="lazy"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            <div class="w-full h-[500px] lg:h-[600px] hidden flex-col items-center justify-center bg-gray-50">
                                <i data-lucide="sprout" style="width:64px;height:64px;color:#d1d5db;" aria-hidden="true"></i>
                                <span class="text-sm text-gray-600 mt-3 font-medium">Foto belum tersedia</span>
                            </div>
                        @else
                            <div class="w-full h-[500px] lg:h-[600px] flex flex-col items-center justify-center bg-gray-50">
                                <i data-lucide="sprout" style="width:64px;height:64px;color:#d1d5db;" aria-hidden="true"></i>
                                <span class="text-sm text-gray-600 mt-3 font-medium">Foto belum tersedia</span>
                            </div>
                        @endif

                        <div class="absolute top-3 right-3">
                            @if($product->stock > 0)
                                <x-ui.badge variant="primary">Tersedia</x-ui.badge>
                            @else
                                <x-ui.badge variant="danger">Habis</x-ui.badge>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Info --}}
                <div class="lg:col-span-2 flex flex-col">
                    <span class="text-xs font-medium text-emerald-600 uppercase tracking-wider truncate block">
                        {{ $product->category->name }}
                    </span>

                    <h1 class="text-2xl lg:text-3xl font-heading font-bold text-gray-900 mt-2 mb-3 leading-tight truncate">{{ $product->name }}</h1>

                    <div class="flex items-baseline gap-2 mb-1">
                        <span class="text-2xl font-bold text-gray-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-600">/ {{ $product->unit }}</span>
                    </div>

                    @if($product->lama_tanam_hari || $product->tanggal_tanam)
                        <div class="flex items-center gap-4 mt-4 text-sm text-gray-600">
                            @if($product->lama_tanam_hari)
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="calendar" style="width:14px;height:14px;" class="text-emerald-600" aria-hidden="true"></i>
                                    {{ $product->lama_tanam_hari }} hari panen
                                </span>
                            @endif
                            @if($product->tanggal_tanam)
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="plant" style="width:14px;height:14px;" class="text-emerald-600" aria-hidden="true"></i>
                                    Tanam: {{ $product->tanggal_tanam->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <hr class="my-5 border-gray-100">

                    <div class="mb-5 flex items-center gap-2">
                        @if($product->stock == 0)
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            <span class="text-sm text-red-600 font-medium">Stok Habis</span>
                        @elseif($product->stock <= 20)
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            <span class="text-sm text-gray-600">Segera Habis — {{ $product->stock }} {{ $product->unit }} tersisa</span>
                        @else
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            <span class="text-sm text-gray-600">Tersedia — {{ $product->stock }} {{ $product->unit }}</span>
                        @endif
                    </div>

                    @if($product->stock > 0)
                        @auth
                            @if(auth()->user()->hasRole('pembeli'))
                                <form action="{{ route('cart.add', $product) }}" method="POST"
                                      @submit.prevent="fetch($event.target.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }, body: new FormData($event.target) }).then(r => { if(r.ok) { $dispatch('notify', { type: 'success', message: 'Produk ditambahkan ke keranjang!' }); } })"
                                      x-data="{ qty: 1, max: {{ $product->stock }} }">
                                    @csrf
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="flex items-center border border-gray-200 rounded-md overflow-hidden">
                                            <button type="button" @click="if(qty > 1) qty--"
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-50 transition-colors">−</button>
                                            <span class="px-4 py-1 font-medium text-gray-900 text-sm" x-text="qty">1</span>
                                            <button type="button" @click="if(qty < max) qty++"
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-50 transition-colors">+</button>
                                        </div>
                                        <span class="text-sm text-gray-600">maks. {{ $product->stock }} {{ $product->unit }}</span>
                                    </div>
                                    <input type="hidden" name="quantity" x-model="qty">
                                    <button type="submit"
                                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-lg font-medium transition-colors">
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('shop.index') }}" class="w-full block text-center py-3 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                                    Kembali ke Toko
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="w-full block text-center py-3 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                                Login untuk Membeli
                            </a>
                        @endauth
                    @else
                        <button disabled class="w-full py-3 bg-gray-100 text-gray-600 rounded-lg font-medium text-sm cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif

                    <x-ui.card variant="default" padding="md" class="mt-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-heading font-bold text-sm shrink-0">
                                {{ strtoupper(substr($product->user->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-heading font-semibold text-gray-900 text-sm truncate">{{ $product->user->name }}</p>
                                <p class="text-xs text-gray-600 truncate">
                                    {{ $product->user->petaniProfile->nama_kebun ?? 'Kebun Hidroponik' }}
                                </p>
                                <p class="text-xs text-gray-600 truncate">
                                    {{ $product->user->petaniProfile->lokasi_kebun ?? 'Lokasi tidak tersedia' }}
                                </p>
                            </div>
                            @if(isset($product->user->petaniProfile->status_verifikasi) && $product->user->petaniProfile->status_verifikasi === 'approved')
                                <x-ui.badge variant="primary" class="shrink-0">
                                    <i data-lucide="shield-check" style="width:12px;height:12px;" aria-hidden="true"></i>
                                    Verified Farmer
                                </x-ui.badge>
                            @endif
                        </div>
                    </x-ui.card>
                </div>
            </div>

            {{-- DESKRIPSI PRODUK --}}
            <div class="mb-12">
                <h2 class="text-lg font-heading font-semibold text-gray-900 mb-4">Deskripsi</h2>
                <div class="text-gray-600 leading-relaxed text-sm">
                    {!! nl2br(e($product->description ?? 'Tidak ada deskripsi produk yang tersedia.')) !!}
                </div>
            </div>

            {{-- PRODUK TERKAIT --}}
            @if($relatedProducts->count() > 0)
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-heading font-semibold text-gray-900">Produk Lainnya</h2>
                        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="text-sm text-emerald-600 font-medium hover:underline">Lihat Semua</a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                        @foreach($relatedProducts->take(4) as $ri => $rel)
                            <a href="{{ route('shop.show', $rel->slug) }}"
                               class="tilt-3d bg-white border border-gray-100 rounded-xl overflow-hidden group transition-colors hover:border-gray-200 animate-fade-in-up stagger-{{ $ri + 1 }}">
                                <div class="aspect-square overflow-hidden bg-gray-50">
                                    @if($rel->image)
                                        <img src="{{ asset('storage/' . $rel->image) }}"
                                             alt="{{ $rel->name }}"
                                             class="w-full h-full object-cover" loading="lazy"
                                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                        <div class="w-full h-full hidden items-center justify-center bg-gray-50">
                                            <i data-lucide="sprout" style="width:36px;height:36px;color:#d1d5db;" aria-hidden="true"></i>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                            <i data-lucide="sprout" style="width:36px;height:36px;color:#d1d5db;" aria-hidden="true"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <h4 class="font-heading font-semibold text-gray-900 text-sm truncate group-hover:text-emerald-600 transition-colors">{{ $rel->name }}</h4>
                                    <p class="text-emerald-700 font-bold text-sm mt-1">Rp {{ number_format($rel->price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-600">/ {{ $rel->unit }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
