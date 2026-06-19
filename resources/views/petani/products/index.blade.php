@extends('layouts.petani')

@section('title', 'Daftar Produk Saya')
@section('page', 'Produk Saya')

@section('petani-content')
<div class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <x-breadcrumb :crumbs="[['label' => 'Produk Saya']]" />

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
                    <i data-lucide="package" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-heading font-bold text-gray-900">Daftar Produk Saya</h1>
                    <p class="text-sm text-gray-500">Kelola produk kebun Anda</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('petani.products.index') }}">
                    <select name="status" onchange="this.form.submit()" class="form-input text-sm py-2">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </form>
                <a href="{{ route('petani.products.create') }}" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                    Tambah Produk
                </a>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover" alt="{{ $product->name }}" loading="lazy"
                                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                            <div class="w-12 h-12 rounded-lg hidden items-center justify-center bg-gray-50">
                                                <i data-lucide="image-off" class="w-5 h-5 text-gray-300" aria-hidden="true"></i>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-gray-50">
                                                <i data-lucide="image-off" class="w-5 h-5 text-gray-300" aria-hidden="true"></i>
                                            </div>
                                        @endif
                                        <span class="font-heading font-semibold text-gray-900 truncate max-w-[180px]">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td class="font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <span>{{ $product->stock }} {{ $product->unit }}</span>
                                        <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            @php
                                                $pct = $product->stock > 0 ? min(100, $product->stock / 100 * 100) : 0;
                                                $barColor = $pct > 50 ? 'bg-emerald-500' : ($pct > 20 ? 'bg-amber-500' : 'bg-red-500');
                                            @endphp
                                            <div class="h-full {{ $barColor }} rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <x-ui.badge :variant="$product->status->value === 'tersedia' ? 'success' : 'danger'">{{ ucfirst($product->status->value) }}</x-ui.badge>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('petani.products.edit', $product) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Edit</a>
                                        <form action="{{ route('petani.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-empty-state icon="package" title="Belum ada produk" description="Mulai dengan menambahkan produk baru.">
                                        <a href="{{ route('petani.products.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                                            <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                                            Tambah Produk
                                        </a>
                                    </x-empty-state>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden p-4 space-y-3">
                @forelse($products as $product)
                    <div class="border border-gray-100 rounded-xl p-4">
                        <div class="flex items-start gap-3 mb-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-14 h-14 rounded-lg object-cover shrink-0" alt="{{ $product->name }}" loading="lazy"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="w-14 h-14 rounded-lg hidden items-center justify-center bg-gray-50 shrink-0">
                                    <i data-lucide="image-off" class="w-6 h-6 text-gray-300" aria-hidden="true"></i>
                                </div>
                            @else
                                <div class="w-14 h-14 rounded-lg flex items-center justify-center bg-gray-50 shrink-0">
                                    <i data-lucide="image-off" class="w-6 h-6 text-gray-300" aria-hidden="true"></i>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="font-heading font-semibold text-gray-900 text-sm truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->category->name ?? '-' }}</p>
                            </div>
                            <x-ui.badge :variant="$product->status->value === 'tersedia' ? 'success' : 'danger'">{{ ucfirst($product->status->value) }}</x-ui.badge>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                            <div>
                                <p class="font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">Stok: {{ $product->stock }} {{ $product->unit }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('petani.products.edit', $product) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Edit</a>
                                <form action="{{ route('petani.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <x-empty-state icon="package" title="Belum ada produk" description="Mulai dengan menambahkan produk baru.">
                        <a href="{{ route('petani.products.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                            Tambah Produk
                        </a>
                    </x-empty-state>
                @endforelse
            </div>
            <div class="p-5 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
