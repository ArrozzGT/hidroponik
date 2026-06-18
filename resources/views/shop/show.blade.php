<x-app-layout>
    <div class="py-8 min-h-screen" style="background:#f0fdf4;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ══ BREADCRUMB (promt3 #1) ══ --}}
            <nav class="flex items-center gap-1.5 text-sm text-gray-400 mb-8 reveal">
                <a href="{{ route('shop.index') }}" class="hover:text-primary-700 transition-colors font-medium">Toko</a>
                <span>/</span>
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-primary-700 transition-colors">
                    {{ $product->category->name }}
                </a>
                <span>/</span>
                <span class="text-gray-700 font-medium truncate max-w-xs">{{ $product->name }}</span>
            </nav>

            {{-- ══ MAIN LAYOUT (promt3 #2) — 2 col ══ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-12">

                {{-- LEFT: Photo --}}
                <div class="relative reveal tilt-3d">
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-soft-lg bg-green-50 relative group">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-green-50">
                                <i data-lucide="sprout" style="width:64px;height:64px;color:#86efac;" aria-hidden="true"></i>
                                <span class="text-sm text-green-400 mt-3 font-medium">Foto belum tersedia</span>
                            </div>
                        @endif

                        {{-- Status badge --}}
                        <div class="absolute top-3 left-3">
                            @if($product->stock > 0)
                                <span class="px-3 py-1 text-white text-xs font-bold uppercase rounded-full shadow flex items-center gap-1"
                                      style="background:linear-gradient(135deg,#16a34a,#15803d);">
                                    <i data-lucide="check" style="width:11px;height:11px;" aria-hidden="true"></i> Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-600 text-white text-xs font-bold uppercase rounded-full shadow flex items-center gap-1">
                                    <i data-lucide="x" style="width:11px;height:11px;" aria-hidden="true"></i> Habis
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Info --}}
                <div class="flex flex-col reveal stagger-2">
                    {{-- Category pill --}}
                    <div class="mb-3">
                        <span class="inline-flex items-center px-3 py-1 bg-primary-100 text-primary-700 text-xs font-bold uppercase tracking-wider rounded-full">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    {{-- Product name --}}
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-3 leading-tight">{{ $product->name }}</h1>

                    {{-- Price --}}
                    <div class="flex items-baseline gap-2 mb-1">
                        <span class="text-2xl font-bold text-primary-700">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-400">/ {{ $product->unit }}</span>
                    </div>

                    {{-- Growing Info --}}
                    @if($product->lama_tanam_hari || $product->tanggal_tanam)
                        <div class="flex items-center gap-4 mt-4 text-sm text-gray-500">
                            @if($product->lama_tanam_hari)
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="calendar" style="width:14px;height:14px;" class="text-green-600" aria-hidden="true"></i>
                                    {{ $product->lama_tanam_hari }} hari panen
                                </span>
                            @endif
                            @if($product->tanggal_tanam)
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="plant" style="width:14px;height:14px;" class="text-green-600" aria-hidden="true"></i>
                                    Tanam: {{ $product->tanggal_tanam->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <hr class="my-5 border-gray-100">

                    {{-- Stock indicator --}}
                    <div class="mb-5">
                        <span class="text-sm text-gray-500 font-medium">Stok tersisa: </span>
                        @if($product->stock == 0)
                            <span class="font-bold text-red-600">Habis</span>
                        @elseif($product->stock <= 20)
                            <span class="font-bold text-amber-600">{{ $product->stock }} {{ $product->unit }}</span>
                            <span class="ml-1 text-xs text-amber-500">(segera habis!)</span>
                        @else
                            <span class="font-bold text-emerald-600">{{ $product->stock }} {{ $product->unit }}</span>
                        @endif
                    </div>

                    {{-- Quantity + Cart Button --}}
                    @if($product->stock > 0)
                        @auth
                            @if(auth()->user()->role === 'pembeli')
                                <form action="{{ route('cart.add', $product) }}" method="POST" x-data="{ qty: 1, max: {{ $product->stock }} }">
                                    @csrf
                                    {{-- Quantity Input --}}
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50 h-11">
                                            <button type="button" @click="if(qty > 1) qty--"
                                                    class="w-11 h-full flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors font-bold text-lg">−</button>
                                            <input type="number" name="quantity" x-model="qty" min="1" :max="max"
                                                   class="w-14 h-full border-0 text-center font-bold text-gray-900 bg-transparent focus:ring-0 text-sm">
                                            <button type="button" @click="if(qty < max) qty++"
                                                    class="w-11 h-full flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors font-bold text-lg">+</button>
                                        </div>
                                        <span class="text-sm text-gray-400">maks. {{ $product->stock }} {{ $product->unit }}</span>
                                    </div>
                                    <button type="submit"
                                            class="btn-primary w-full py-3.5">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('shop.index') }}" class="btn-secondary w-full justify-center py-3 text-center">
                                    Kembali ke Toko
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="btn-secondary w-full justify-center py-3.5 text-center">
                                🔐 Login untuk Membeli
                            </a>
                        @endauth
                    @else
                        <button disabled class="w-full py-3.5 bg-gray-100 text-gray-400 rounded-xl font-bold text-sm cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif

                    {{-- ══ INFO PETANI box ══ --}}
                    <div class="mt-5 p-4 bg-green-50 border border-green-100 rounded-2xl">
                        <p class="text-xs text-green-700/60 font-semibold uppercase tracking-wider mb-3">Penjual</p>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-base shrink-0"
                                 style="background:linear-gradient(135deg,#16a34a,#15803d);">
                                {{ strtoupper(substr($product->user->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-900 text-sm">{{ $product->user->name }}</p>
                                <p class="text-xs text-gray-500 truncate flex items-center gap-1">
                                    <i data-lucide="home" style="width:11px;height:11px;color:#16a34a;" aria-hidden="true"></i>
                                    {{ $product->user->petaniProfile->nama_kebun ?? 'Kebun Hidroponik' }}
                                </p>
                                <p class="text-xs text-gray-400 truncate mt-0.5 flex items-center gap-1">
                                    <i data-lucide="map-pin" style="width:11px;height:11px;color:#86efac;" aria-hidden="true"></i>
                                    {{ $product->user->petaniProfile->lokasi_kebun ?? 'Lokasi tidak tersedia' }}
                                </p>
                            </div>
                            @if(isset($product->user->petaniProfile->status_verifikasi) && $product->user->petaniProfile->status_verifikasi === 'approved')
                                <div class="ml-auto shrink-0">
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full flex items-center gap-1">
                                        <i data-lucide="shield-check" style="width:10px;height:10px;" aria-hidden="true"></i> Terverifikasi
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ DESKRIPSI PRODUK (promt3 #4) ══ --}}
            <div class="card card-pad mb-12 reveal">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-5 bg-primary-700 rounded-full"></span>
                    Deskripsi Produk
                </h2>
                <div class="prose prose-sm text-gray-600 leading-relaxed max-w-none">
                    {!! nl2br(e($product->description ?? 'Tidak ada deskripsi produk yang tersedia.')) !!}
                </div>
            </div>

            {{-- ══ PRODUK TERKAIT (promt3 #5) ══ --}}
            @if($relatedProducts->count() > 0)
                <div class="mb-10 reveal">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-1 h-5 bg-primary-700 rounded-full"></span>
                        Produk dari Kategori Sama
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                        @foreach($relatedProducts->take(4) as $ri => $rel)
                            <a href="{{ route('shop.show', $rel->slug) }}"
                               class="card overflow-hidden group transition-all duration-200 hover:shadow-lg hover:-translate-y-1 img-zoom reveal {{ 'stagger-' . (($ri % 4) + 1) }}">
                                <div class="aspect-square overflow-hidden bg-green-50">
                                    @if($rel->image)
                                        <img src="{{ asset('storage/' . $rel->image) }}"
                                             alt="{{ $rel->name }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                    <div class="w-full h-full flex items-center justify-center bg-green-50">
                                        <i data-lucide="sprout" style="width:36px;height:36px;color:#86efac;" aria-hidden="true"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <h4 class="font-bold text-gray-900 text-sm truncate group-hover:text-primary-700 transition-colors">{{ $rel->name }}</h4>
                                    <p class="text-primary-700 font-bold text-sm mt-1">Rp {{ number_format($rel->price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-400">/ {{ $rel->unit }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
