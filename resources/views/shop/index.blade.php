<x-app-layout>
    <script>
        document.addEventListener('turbo:before-render', () => {
            Alpine.store('skeleton').loading = true;
        });
        document.addEventListener('turbo:render', () => {
            setTimeout(() => Alpine.store('skeleton').loading = false, 100);
        });
    </script>

    {{-- HERO SECTION --}}
    <div class="bg-emerald-700">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 text-white/80">
            <x-breadcrumb :crumbs="[['label' => 'Belanja']]" />
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium text-emerald-200 mb-6 bg-white/10">
                <i data-lucide="leaf" style="width:13px;height:13px;" aria-hidden="true"></i> Marketplace Hidroponik Terpercaya
            </span>
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-5 leading-tight">
                Sayuran Hidroponik Segar,<br class="hidden sm:block">
                <span class="text-emerald-300">Langsung dari Petani</span>
            </h1>
            <p class="text-emerald-200/80 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
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
                    <div class="flex items-center bg-white rounded-lg overflow-hidden border border-white/20">
                        <div class="flex items-center pl-5 text-gray-600">
                            <i data-lucide="search" style="width:18px;height:18px;" aria-hidden="true"></i>
                        </div>
                        <input
                            name="search"
                            value="{{ request('search') }}"
                            type="text"
                            placeholder="Cari sayuran, microgreens, selada..."
                            class="flex-1 py-4 px-4 text-gray-800 placeholder-gray-400 text-base border-0 focus:ring-0 bg-transparent"
                            x-model="query"
                            @input.debounce.300ms="search"
                        >
                        <button type="submit" class="bg-emerald-600 text-white hover:bg-emerald-700 px-6 py-3 text-sm font-medium transition-colors m-1.5 rounded-lg">
                            Cari
                        </button>
                    </div>

                    <div x-show="results.length > 0"
                         x-cloak
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg border border-gray-200 overflow-hidden z-50"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <template x-for="p in results" :key="p.id">
                            <a :href="'/shop/' + p.slug"
                               class="flex items-center gap-4 px-5 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                <div class="w-12 h-12 rounded-lg bg-gray-50 flex items-center justify-center shrink-0 overflow-hidden">
                                    <img x-show="p.image" :src="'/storage/' + p.image" alt=""
                                         class="w-full h-full object-cover" loading="lazy"
                                         onerror.once="this.style.display='none'">
                                    <i x-show="!p.image" data-lucide="sprout" class="w-6 h-6 text-gray-500" aria-hidden="true"></i>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-semibold text-gray-900 text-sm truncate" x-text="p.name"></p>
                                    <p class="text-xs text-gray-600 mt-0.5">
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
                                const res = await fetch('{{ route('api.products.search') }}?q=' + encodeURIComponent(this.query));
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

    {{-- FILTER BAR --}}
    <div class="sticky top-14 z-40 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 py-3 overflow-x-auto scrollbar-hide">
                <a href="{{ route('shop.index', array_merge(request()->except('category','page'), [])) }}"
                   class="shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-colors
                          {{ !request('category') ? 'bg-emerald-600 text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('shop.index', array_merge(request()->except('category','page'), ['category' => $cat->slug])) }}"
                       class="shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-colors whitespace-nowrap
                              {{ request('category') == $cat->slug ? 'bg-emerald-600 text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                        {{ $cat->icon ?? '' }} {{ $cat->name }}
                        <span class="ml-1 text-[10px] opacity-70">({{ $cat->products_count }})</span>
                    </a>
                @endforeach

                <div class="flex-1"></div>

                <form action="{{ route('shop.index') }}" method="GET" class="shrink-0">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="sort" onchange="this.form.submit()"
                            class="text-sm font-medium py-1.5 pl-3 pr-8 border border-gray-200 rounded-lg cursor-pointer focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                        <option value="">Urutkan</option>
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                        <option value="stok" {{ request('sort') == 'stok' ? 'selected' : '' }}>Stok Terbanyak</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    {{-- PRODUCT GRID --}}
    <div class="py-10 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(request('search') || request('category'))
                <p class="text-sm text-gray-600 mb-5">
                    Menampilkan <strong class="text-gray-700">{{ $products->total() }}</strong> produk
                    @if(request('search')) untuk "<strong class="text-gray-700">{{ request('search') }}</strong>" @endif
                    @if(request('category')) dalam kategori <strong class="text-gray-700">{{ $categories->firstWhere('slug', request('category'))?->name }}</strong> @endif
                </p>
            @endif

            @if($products->isEmpty())
                <x-empty-state icon="sprout" title="Belum ada produk tersedia" description="Coba ubah kata kunci atau pilih kategori lain.">
                    <a href="{{ route('shop.index') }}" class="bg-emerald-600 text-white hover:bg-emerald-700 px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                        Lihat Semua Produk
                    </a>
                </x-empty-state>
            @else
                <x-skeleton :count="8" :cols="4" />
                <div x-show="!($store.skeleton?.loading ?? false)" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
                    @foreach($products as $i => $product)
                        <div class="tilt-3d bg-white border border-gray-100 rounded-xl overflow-hidden group transition-colors hover:border-gray-200 reveal" style="transition-delay: {{ $i * 60 }}ms; transition-duration: 0.5s">

                            <a href="{{ route('shop.show', $product->slug) }}" class="block relative aspect-square overflow-hidden bg-gray-50">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover" loading="lazy"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div class="w-full h-full hidden items-center justify-center bg-gray-50">
                                        <i data-lucide="sprout" style="width:40px;height:40px;color:#d1d5db;" aria-hidden="true"></i>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                        <i data-lucide="sprout" style="width:40px;height:40px;color:#d1d5db;" aria-hidden="true"></i>
                                    </div>
                                @endif

                                <span class="absolute top-3 left-3 bg-white/90 text-xs px-2 py-1 rounded-md font-medium text-gray-700 truncate max-w-[calc(100%-1.5rem)]">
                                    {{ $product->category->name }}
                                </span>

                                <div class="absolute top-3 right-3 flex flex-col gap-1">
                                    @if($product->stock == 0)
                                        <x-ui.badge variant="danger">HABIS</x-ui.badge>
                                    @elseif($product->created_at->diffInDays(now()) < 7)
                                        <x-ui.badge variant="primary">BARU</x-ui.badge>
                                    @endif
                                </div>
                            </a>

                            <div class="p-4">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <h3 class="font-heading font-semibold text-gray-900 truncate group-hover:text-emerald-600 transition-colors text-sm">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <p class="text-xs text-gray-600 mt-0.5 truncate">
                                    {{ $product->user->petaniProfile->nama_kebun ?? $product->user->name }}
                                </p>

                                <div class="mt-3 flex items-baseline gap-1">
                                    <span class="text-base font-bold text-emerald-700">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-600">/ {{ $product->unit }}</span>
                                </div>

                                <div class="mt-3">
                                    @if($product->stock == 0)
                                        <button disabled class="w-full py-2 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium cursor-not-allowed">
                                            Stok Habis
                                        </button>
                                    @else
                                        @auth
                                            @if(auth()->user()->hasRole('pembeli'))
                                                <form action="{{ route('cart.add', $product) }}" method="POST"
                                                      @submit.prevent="fetch($event.target.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }, body: new FormData($event.target) }).then(r => { if(r.ok) { $dispatch('notify', { type: 'success', message: 'Produk ditambahkan ke keranjang!' }); } })">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit"
                                                             class="w-full py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-lg text-xs font-medium transition-colors">
                                                        Tambah ke Keranjang
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('shop.show', $product->slug) }}"
                                                   class="block w-full py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-medium text-center transition-colors">
                                                    Lihat Detail
                                                </a>
                                            @endif
                                        @else
                                            @guest
                                                <a href="{{ route('login') }}"
                                                   class="block w-full py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-medium text-center transition-colors">
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

                @if($products->hasPages())
                    <div class="mt-10 flex justify-center">
                        <div class="flex items-center gap-1">
                            @if($products->onFirstPage())
                                <span class="px-3 py-2 rounded-md text-gray-600 bg-gray-50 border border-gray-100 cursor-not-allowed text-sm">
                                    ← Prev
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}"
                                   class="px-3 py-2 rounded-md text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors text-sm font-medium">
                                    ← Prev
                                </a>
                            @endif

                            @foreach ($products->getUrlRange(max(1, $products->currentPage()-2), min($products->lastPage(), $products->currentPage()+2)) as $page => $url)
                                @if($page == $products->currentPage())
                                    <span class="px-3.5 py-2 rounded-md bg-emerald-600 text-white font-medium text-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                       class="px-3.5 py-2 rounded-md bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors text-sm font-medium">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}"
                                   class="px-3 py-2 rounded-md text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors text-sm font-medium">
                                    Next →
                                </a>
                            @else
                                <span class="px-3 py-2 rounded-md text-gray-600 bg-gray-50 border border-gray-100 cursor-not-allowed text-sm">
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
