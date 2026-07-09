<x-app-layout dark>
    <script>
        document.addEventListener('turbo:before-render', () => {
            Alpine.store('skeleton').loading = true;
        });
        document.addEventListener('turbo:render', () => {
            setTimeout(() => Alpine.store('skeleton').loading = false, 100);
        });
    </script>

    {{-- HERO SECTION --}}
    <div class="bg-gradient-to-b from-surface-950 to-surface-900">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 text-white/80">
            <x-breadcrumb :crumbs="[['label' => 'Belanja']]" />
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium text-produce-lettuce mb-6 bg-produce-lettuce/10">
                <span class="w-1.5 h-1.5 rounded-full bg-produce-lettuce"></span> Marketplace Hidroponik Terpercaya
            </span>
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-5 leading-tight">
                Sayuran Hidroponik Segar,<br class="hidden sm:block">
                <span class="text-produce-lettuce">Langsung dari Petani</span>
            </h1>
            <p class="text-[#F5F5F0]/50 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
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
                    <div class="flex items-center bg-surface-800 rounded-xl overflow-hidden border border-white/10">
                        <div class="flex items-center pl-5 text-[#F5F5F0]/40">
                            <i data-lucide="search" style="width:18px;height:18px;" aria-hidden="true"></i>
                        </div>
                        <input
                            name="search"
                            value="{{ request('search') }}"
                            type="text"
                            placeholder="Cari sayuran, microgreens, selada..."
                            class="flex-1 py-4 px-4 text-white placeholder-[#F5F5F0]/30 text-base border-0 focus:ring-0 bg-transparent"
                            x-model="query"
                            @input.debounce.300ms="search"
                        >
                        <button type="submit" class="bg-produce-lettuce text-surface-950 hover:brightness-110 px-6 py-3 text-sm font-medium transition-all m-1.5 rounded-lg">
                            Cari
                        </button>
                    </div>

                    <div x-show="results.length > 0"
                         x-cloak
                         class="absolute top-full left-0 right-0 mt-2 bg-surface-900 rounded-lg border border-white/10 overflow-hidden z-50"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <template x-for="p in results" :key="p.id">
                            <a :href="'/shop/' + p.slug"
                               class="flex items-center gap-4 px-5 py-3 hover:bg-surface-800 transition-colors border-b border-white/5 last:border-0">
                                <div class="w-12 h-12 rounded-lg bg-surface-800 flex items-center justify-center shrink-0 overflow-hidden">
                                    <img x-show="p.image" :src="'/storage/' + p.image" alt=""
                                         class="w-full h-full object-cover" loading="lazy"
                                         onerror="this.style.display='none'">
                                    <i x-show="!p.image" data-lucide="sprout" class="w-6 h-6 text-produce-lettuce/50" aria-hidden="true"></i>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-semibold text-white text-sm truncate" x-text="p.name"></p>
                                    <p class="text-xs text-[#F5F5F0]/40 mt-0.5">
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
    <div class="sticky top-14 z-40 bg-surface-900/95 backdrop-blur border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 py-3 overflow-x-auto scrollbar-hide">
                <a href="{{ route('shop.index', array_merge(request()->except('category','page'), [])) }}"
                   class="shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-colors
                          {{ !request('category') ? 'bg-produce-lettuce text-surface-950' : 'border border-white/10 text-[#F5F5F0]/60 hover:bg-surface-800' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('shop.index', array_merge(request()->except('category','page'), ['category' => $cat->slug])) }}"
                       class="shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-colors whitespace-nowrap
                              {{ request('category') == $cat->slug ? 'bg-produce-lettuce text-surface-950' : 'border border-white/10 text-[#F5F5F0]/60 hover:bg-surface-800' }}">
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
                            class="text-sm font-medium py-1.5 pl-3 pr-8 border border-white/10 rounded-lg cursor-pointer bg-surface-800 text-[#F5F5F0]/70 focus:border-produce-lettuce focus:ring-1 focus:ring-produce-lettuce">
                        <option value="" class="bg-surface-900">Urutkan</option>
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }} class="bg-surface-900">Terbaru</option>
                        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }} class="bg-surface-900">Termurah</option>
                        <option value="stok" {{ request('sort') == 'stok' ? 'selected' : '' }} class="bg-surface-900">Stok Terbanyak</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    {{-- PRODUCT GRID --}}
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(request('search') || request('category'))
                <p class="text-sm text-[#F5F5F0]/50 mb-5">
                    Menampilkan <strong class="text-white"> {{ $products->total() }} </strong> produk
                    @if(request('search')) untuk "<strong class="text-white">{{ request('search') }}</strong>" @endif
                    @if(request('category')) dalam kategori <strong class="text-white">{{ $categories->firstWhere('slug', request('category'))?->name }}</strong> @endif
                </p>
            @endif

            @if($products->isEmpty())
                <x-empty-state icon="sprout" title="Belum ada produk tersedia" description="Coba ubah kata kunci atau pilih kategori lain.">
                    <a href="{{ route('shop.index') }}" class="bg-produce-lettuce text-surface-950 hover:brightness-110 px-5 py-2.5 rounded-lg text-sm font-medium transition-all">
                        Lihat Semua Produk
                    </a>
                </x-empty-state>
            @else
                <x-skeleton :count="8" :cols="4" />
                <div x-show="!($store.skeleton?.loading ?? false)" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
                    @foreach($products as $i => $product)
                        <div class="product-card-dark tilt-3d reveal" style="transition-delay: {{ $i * 60 }}ms; transition-duration: 0.5s">

                            <a href="{{ route('shop.show', $product->slug) }}" class="block relative aspect-square rounded-2xl overflow-hidden bg-surface-800 mb-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-contain drop-shadow-xl"
                                         loading="lazy"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div class="w-full h-full hidden items-center justify-center bg-surface-800">
                                        <i data-lucide="sprout" style="width:40px;height:40px;color:#7ED957;" aria-hidden="true"></i>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-surface-800">
                                        <i data-lucide="sprout" style="width:40px;height:40px;color:#7ED957;" aria-hidden="true"></i>
                                    </div>
                                @endif

                                {{-- Category Badge --}}
                                <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-surface-900/80 text-[#F5F5F0]/70 border border-white/5 truncate max-w-[calc(100%-1.5rem)]">
                                    {{ $product->category->name }}
                                </span>

                                {{-- Status Badges --}}
                                <div class="absolute top-3 right-3 flex flex-col gap-1">
                                    @if($product->stock == 0)
                                        <span class="badge-produce-tomato px-2 py-0.5 rounded-full text-[10px] font-semibold">HABIS</span>
                                    @elseif($product->created_at->diffInDays(now()) < 7)
                                        <span class="badge-produce-lemon px-2 py-0.5 rounded-full text-[10px] font-semibold">BARU</span>
                                    @endif
                                </div>
                            </a>

                            <div class="px-1">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <h3 class="font-heading font-semibold text-white truncate hover:text-produce-lettuce transition-colors text-sm">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <p class="text-xs text-[#F5F5F0]/40 mt-0.5 truncate">
                                    {{ $product->user->petaniProfile->nama_kebun ?? $product->user->name }}
                                </p>

                                <div class="mt-3 flex items-baseline gap-1">
                                    <span class="text-base font-bold text-produce-carrot">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-[#F5F5F0]/40">/ {{ $product->unit }}</span>
                                </div>

                                <div class="mt-4">
                                    @if($product->stock == 0)
                                        <button disabled class="w-full py-2.5 bg-surface-800 text-[#F5F5F0]/30 rounded-xl text-xs font-medium cursor-not-allowed">
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
                                                            class="w-full py-2.5 bg-produce-lettuce/10 text-produce-lettuce hover:bg-produce-lettuce hover:text-surface-950 rounded-xl text-xs font-medium transition-all border border-produce-lettuce/30">
                                                        + Keranjang
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('shop.show', $product->slug) }}"
                                                   class="block w-full py-2.5 bg-surface-800 text-[#F5F5F0]/50 hover:bg-surface-700 rounded-xl text-xs font-medium text-center transition-all">
                                                    Lihat Detail
                                                </a>
                                            @endif
                                        @else
                                            @guest
                                                <a href="{{ route('login') }}"
                                                   class="block w-full py-2.5 bg-surface-800 text-[#F5F5F0]/50 hover:bg-surface-700 rounded-xl text-xs font-medium text-center transition-all">
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
                                <span class="px-3 py-2 rounded-md text-[#F5F5F0]/30 bg-surface-800 border border-white/5 cursor-not-allowed text-sm">
                                    ← Prev
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}"
                                   class="px-3 py-2 rounded-md text-[#F5F5F0]/60 bg-surface-800 border border-white/10 hover:bg-surface-700 transition-colors text-sm font-medium">
                                    ← Prev
                                </a>
                            @endif

                            @foreach ($products->getUrlRange(max(1, $products->currentPage()-2), min($products->lastPage(), $products->currentPage()+2)) as $page => $url)
                                @if($page == $products->currentPage())
                                    <span class="px-3.5 py-2 rounded-md bg-produce-lettuce text-surface-950 font-medium text-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                       class="px-3.5 py-2 rounded-md bg-surface-800 border border-white/10 text-[#F5F5F0]/60 hover:bg-surface-700 transition-colors text-sm font-medium">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}"
                                   class="px-3 py-2 rounded-md text-[#F5F5F0]/60 bg-surface-800 border border-white/10 hover:bg-surface-700 transition-colors text-sm font-medium">
                                    Next →
                                </a>
                            @else
                                <span class="px-3 py-2 rounded-md text-[#F5F5F0]/30 bg-surface-800 border border-white/5 cursor-not-allowed text-sm">
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
