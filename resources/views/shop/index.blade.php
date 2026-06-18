<x-app-layout>
    {{-- ══════════════════════════════════════════
         HERO SECTION (promt1 #1)
    ══════════════════════════════════════════ --}}
    <div class="relative overflow-hidden" style="background: linear-gradient(135deg, #14532d 0%, #166534 60%, #15803d 100%);">
        <div class="absolute inset-0" style="background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:52px 52px;"></div>
        <div class="leaf-float" style="top:12%;left:5%;color:rgba(255,255,255,.15);"><i data-lucide="leaf" style="width:40px;height:40px;" aria-hidden="true"></i></div>
        <div class="leaf-float-delay" style="top:20%;right:8%;color:rgba(255,255,255,.12);"><i data-lucide="sprout" style="width:28px;height:28px;" aria-hidden="true"></i></div>
        <div class="leaf-float-slow" style="bottom:15%;left:15%;color:rgba(255,255,255,.1);"><i data-lucide="wheat" style="width:32px;height:32px;" aria-hidden="true"></i></div>
        <div class="leaf-float" style="bottom:20%;right:20%;animation-delay:3s;color:rgba(255,255,255,.1);"><i data-lucide="leaf" style="width:22px;height:22px;" aria-hidden="true"></i></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold text-white/90 mb-6" style="background:rgba(255,255,255,.18);backdrop-filter:blur(8px);">
                <i data-lucide="leaf" style="width:13px;height:13px;" aria-hidden="true"></i> Marketplace Hidroponik Terpercaya
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-5 leading-tight tracking-tight">
                Sayuran Hidroponik Segar,<br class="hidden sm:block">
                <span class="text-emerald-300">Langsung dari Petani</span>
            </h1>
            <p class="text-white/75 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
                Produk berkualitas tinggi, bebas pestisida, dikirim langsung dari kebun ke meja makan Anda.
            </p>

            {{-- Search Bar --}}
            <form action="{{ route('shop.index') }}" method="GET" class="max-w-2xl mx-auto"
                  x-data="searchSuggestions()"
                  @click.away="results = []"
                  @keydown.escape.prevent="results = []">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <div class="relative">
                    <div class="flex items-center bg-white rounded-2xl shadow-soft-lg overflow-hidden border border-white/20">
                        <div class="flex items-center pl-5 text-gray-400">
                            <i data-lucide="search" style="width:18px;height:18px;" aria-hidden="true"></i>
                        </div>
                        <input
                            name="search"
                            value="{{ request('search') }}"
                            type="text"
                            placeholder="Cari sayuran, microgreens, selada..."
                            class="flex-1 py-4 px-4 text-gray-800 placeholder-gray-400 text-base border-0 focus:ring-0 bg-transparent font-medium"
                            x-model="query"
                            @input.debounce.300ms="search"
                        >
                        <button type="submit" class="btn-primary m-1.5 px-6 py-3 text-sm">
                            <i data-lucide="search" class="w-4 h-4 mr-1" aria-hidden="true"></i>Cari
                        </button>
                    </div>

                    {{-- Live Search Dropdown --}}
                    <div x-show="results.length > 0"
                         x-cloak
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <template x-for="p in results" :key="p.id">
                            <a :href="'/shop/' + p.slug"
                               class="flex items-center gap-4 px-5 py-3 hover:bg-green-50 transition-colors border-b border-gray-50 last:border-0">
                                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center shrink-0 overflow-hidden">
                                    <img x-show="p.image" :src="'/storage/' + p.image" alt=""
                                         class="w-full h-full object-cover"
                                         onerror.once="this.style.display='none'">
                                    <i x-show="!p.image" data-lucide="sprout" class="w-6 h-6 text-green-300" aria-hidden="true"></i>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-semibold text-gray-900 text-sm truncate" x-text="p.name"></p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(p.price)"></span>
                                        <span x-text="'/ ' + p.unit"></span>
                                    </p>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </form>

            <script>
                function searchSuggestions() {
                    return {
                        query: '{{ request('search') }}',
                        results: [],
                        async search() {
                            if (this.query.length < 2) { this.results = []; return; }
                            try {
                                const res = await fetch('/api/products/search?q=' + encodeURIComponent(this.query));
                                this.results = await res.json();
                            } catch {
                                this.results = [];
                            }
                        }
                    };
                }
            </script>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         FILTER BAR (promt1 #2) — sticky
    ══════════════════════════════════════════ --}}
    <div class="sticky top-16 z-40 bg-white shadow border-b border-gray-100 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 py-3 overflow-x-auto scrollbar-hide">
                {{-- Category Pills --}}
                <a href="{{ route('shop.index', array_merge(request()->except('category','page'), [])) }}"
                   class="shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold transition-all
                          {{ !request('category') ? 'bg-primary-700 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('shop.index', array_merge(request()->except('category','page'), ['category' => $cat->slug])) }}"
                       class="shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold transition-all whitespace-nowrap
                              {{ request('category') == $cat->slug ? 'bg-primary-700 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $cat->icon ?? '' }} {{ $cat->name }}
                        <span class="ml-1 text-[10px] font-medium opacity-70">({{ $cat->products_count }})</span>
                    </a>
                @endforeach

                {{-- Spacer --}}
                <div class="flex-1"></div>

                {{-- Sort Dropdown --}}
                <form action="{{ route('shop.index') }}" method="GET" class="shrink-0">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="sort" onchange="this.form.submit()"
                            class="form-input text-sm font-semibold py-1.5 pl-3 pr-8 cursor-pointer">
                        <option value="">Urutkan</option>
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>🕒 Terbaru</option>
                        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>💰 Termurah</option>
                        <option value="stok" {{ request('sort') == 'stok' ? 'selected' : '' }}>📦 Stok Terbanyak</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         PRODUCT GRID (promt1 #3)
    ══════════════════════════════════════════ --}}
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Result info --}}
            @if(request('search') || request('category'))
                <p class="text-sm text-gray-500 mb-5">
                    Menampilkan <strong class="text-gray-800">{{ $products->total() }}</strong> produk
                    @if(request('search')) untuk "<strong class="text-gray-800">{{ request('search') }}</strong>" @endif
                    @if(request('category')) dalam kategori <strong class="text-gray-800">{{ $categories->firstWhere('slug', request('category'))?->name }}</strong> @endif
                </p>
            @endif

            @if($products->isEmpty())
                {{-- ══ EMPTY STATE (promt1 #4) ══ --}}
                <div class="flex flex-col items-center justify-center py-24 text-center animate-fade-in">
                    <div class="w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-5" style="background:#f0fdf4;">
                        <i data-lucide="sprout" style="width:36px;height:36px;color:#86efac;" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-600 mb-2">Belum ada produk tersedia</h3>
                    <p class="text-gray-400 mb-6 max-w-sm">Coba ubah kata kunci atau pilih kategori lain.</p>
                    <a href="{{ route('shop.index') }}" class="btn-primary">
                        <i data-lucide="refresh-cw" style="width:15px;height:15px;" aria-hidden="true"></i>
                        Lihat Semua Produk
                    </a>
                </div>
            @else
                {{-- 4-col grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
                    @foreach($products as $i => $product)
                        <div class="card overflow-hidden group transition-all duration-200 ease-in-out hover:shadow-lg hover:-translate-y-1 reveal tilt-3d {{ 'stagger-' . (($i % 8) + 1) }}">

                            {{-- Product Image --}}
                            <a href="{{ route('shop.show', $product->slug) }}" class="block relative aspect-square overflow-hidden bg-green-50">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-green-50">
                                        <i data-lucide="sprout" style="width:40px;height:40px;color:#86efac;" aria-hidden="true"></i>
                                    </div>
                                @endif

                                {{-- Dark overlay on hover --}}
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-200"></div>

                                {{-- Category badge top-left --}}
                                <span class="absolute top-2 left-2 px-2.5 py-1 text-white text-[10px] font-bold uppercase tracking-wide rounded-lg"
                                      style="background:linear-gradient(135deg,#16a34a,#15803d);backdrop-filter:blur(4px);">
                                    {{ $product->category->name }}
                                </span>

                                {{-- Status badges top-right --}}
                                <div class="absolute top-2 right-2 flex flex-col gap-1">
                                    @if($product->stock == 0)
                                        <span class="px-2 py-0.5 bg-red-600 text-white text-[10px] font-bold uppercase rounded-lg">
                                            HABIS
                                        </span>
                                    @elseif($product->created_at->diffInDays(now()) < 7)
                                        <span class="px-2 py-0.5 bg-emerald-500 text-white text-[10px] font-bold uppercase rounded-lg animate-pulse">
                                            BARU
                                        </span>
                                    @endif
                                </div>
                            </a>

                            {{-- Product Info --}}
                            <div class="p-4">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <h3 class="font-semibold text-gray-900 truncate group-hover:text-primary-700 transition-colors text-sm">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="sprout" style="width:11px;height:11px;color:#86efac;" aria-hidden="true"></i> {{ $product->user->petaniProfile->nama_kebun ?? $product->user->name }}
                                </p>

                                <div class="mt-3 flex items-baseline gap-1">
                                    <span class="text-base font-bold text-primary-700">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-400">/ {{ $product->unit }}</span>
                                </div>

                                {{-- Add to Cart button --}}
                                <div class="mt-3">
                                    @if($product->stock == 0)
                                        <button disabled class="w-full py-2 bg-gray-100 text-gray-400 rounded-xl text-xs font-semibold cursor-not-allowed">
                                            Stok Habis
                                        </button>
                                    @else
                                        @auth
                                            @if(auth()->user()->role === 'pembeli')
                                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit"
                                                             class="btn-primary w-full py-2 text-xs magnetic">
                                                        <i data-lucide="shopping-cart" style="width:13px;height:13px;" aria-hidden="true"></i>
                                                        Tambah ke Keranjang
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('shop.show', $product->slug) }}"
                                                   class="btn-secondary w-full py-2 text-xs text-center magnetic">
                                                    Lihat Detail
                                                </a>
                                            @endif
                                        @else
                                            @guest
                                                <a href="{{ route('login') }}"
                                                   class="btn-secondary w-full py-2 text-xs text-center magnetic">
                                                    Login untuk Membeli
                                                </a>
                                            @endguest
                                        @endauth
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ══ PAGINATION (promt1 #5) ══ --}}
                @if($products->hasPages())
                    <div class="mt-10 flex justify-center">
                        <div class="flex items-center gap-1">
                            {{-- Previous --}}
                            @if($products->onFirstPage())
                                <span class="px-3 py-2 rounded-xl text-gray-300 bg-white border border-gray-100 cursor-not-allowed text-sm">
                                    ← Prev
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}"
                                   class="px-3 py-2 rounded-xl text-gray-600 bg-white border border-gray-200 hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 transition-all text-sm font-medium">
                                    ← Prev
                                </a>
                            @endif

                            {{-- Page numbers --}}
                            @foreach ($products->getUrlRange(max(1, $products->currentPage()-2), min($products->lastPage(), $products->currentPage()+2)) as $page => $url)
                                @if($page == $products->currentPage())
                                    <span class="px-3.5 py-2 rounded-xl bg-primary-700 text-white font-bold text-sm shadow">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                       class="px-3.5 py-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 transition-all text-sm font-medium">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}"
                                   class="px-3 py-2 rounded-xl text-gray-600 bg-white border border-gray-200 hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 transition-all text-sm font-medium">
                                    Next →
                                </a>
                            @else
                                <span class="px-3 py-2 rounded-xl text-gray-300 bg-white border border-gray-100 cursor-not-allowed text-sm">
                                    Next →
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
