@extends('layouts.petani')

@section('title', 'Daftar Produk Saya')
@section('page', 'Produk Saya')

@section('petani-content')
<div class="reveal py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center gradient-green">
                    <i data-lucide="package" class="w-5 h-5 text-white" aria-hidden="true"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">Daftar Produk Saya</h1>
                    <p class="text-sm text-slate-500">Kelola produk kebun Anda</p>
                </div>
            </div>
            <a href="{{ route('petani.products.create') }}" class="magnetic btn-primary">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="card p-4 border-green-200 bg-green-50 text-green-800 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="card overflow-hidden hover-lift">
            <div class="overflow-x-auto">
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
                            <tr class="stagger-{{ $loop->iteration }}">
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-xl object-cover img-zoom" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-green-50">
                                                <i data-lucide="image-off" class="w-5 h-5 text-green-300" aria-hidden="true"></i>
                                            </div>
                                        @endif
                                        <span class="font-bold text-slate-900">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td class="font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }} {{ $product->unit }}</td>
                                <td>
                                    <span class="{{ $product->status->value === 'tersedia' ? 'badge-green' : 'badge-red' }}">{{ ucfirst($product->status->value) }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('petani.products.edit', $product) }}" class="btn-secondary !px-3 !py-1.5 text-xs">Edit</a>
                                        <form action="{{ route('petani.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge-red normal-case">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-slate-500 py-10">Belum ada produk. Mulai dengan menambahkan produk baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-5 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
