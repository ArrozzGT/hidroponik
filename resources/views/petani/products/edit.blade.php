@extends('layouts.petani')

@section('title', 'Edit Produk')
@section('page', 'Edit Produk')

@section('petani-content')
<div class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <x-breadcrumb :crumbs="[['label' => 'Produk Saya', 'url' => route('petani.products.index')], ['label' => 'Edit ' . $product->name]]" />

        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
                    <i data-lucide="pencil" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Produk</h1>
                    <p class="text-sm text-gray-500">Perbarui informasi produk</p>
                </div>
            </div>
            <x-ui.badge :variant="$product->status->value === 'tersedia' ? 'success' : 'danger'">{{ ucfirst($product->status->value) }}</x-ui.badge>
        </div>

        <x-ui.card padding="lg">
            <form action="{{ route('petani.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="form-label">Nama Produk</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" class="form-input" required autofocus>
                            @error('name') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" class="form-input" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea id="description" name="description" class="form-input" rows="5">{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="price" class="form-label">Harga (Rp)</label>
                            <input id="price" name="price" type="number" value="{{ old('price', $product->price) }}" class="form-input" required>
                            @error('price') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="stock" class="form-label">Stok</label>
                                <input id="stock" name="stock" type="number" value="{{ old('stock', $product->stock) }}" class="form-input" required>
                                @error('stock') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="unit" class="form-label">Satuan</label>
                                <input id="unit" name="unit" type="text" value="{{ old('unit', $product->unit) }}" class="form-input" required>
                                @error('unit') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="lama_tanam_hari" class="form-label">Lama Tanam (Hari)</label>
                                <input id="lama_tanam_hari" name="lama_tanam_hari" type="number" value="{{ old('lama_tanam_hari', $product->lama_tanam_hari) }}" class="form-input" placeholder="30">
                                @error('lama_tanam_hari') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tanggal_tanam" class="form-label">Tanggal Tanam</label>
                                <input id="tanggal_tanam" name="tanggal_tanam" type="date" value="{{ old('tanggal_tanam', $product->tanggal_tanam?->format('Y-m-d')) }}" class="form-input">
                                @error('tanggal_tanam') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Foto Produk</label>
                            @if($product->image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover rounded-xl border border-gray-200" alt="{{ $product->name }}" loading="lazy">
                                </div>
                            @endif
                            <label for="image" class="flex flex-col items-center justify-center px-6 py-8 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 hover:bg-emerald-50 hover:border-emerald-300 cursor-pointer transition-colors">
                                <i data-lucide="upload-cloud" class="w-9 h-9 text-emerald-500 mb-2" aria-hidden="true"></i>
                                <span class="text-sm font-semibold text-gray-600">Klik untuk ganti foto</span>
                                <span class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah foto</span>
                            </label>
                            <input id="image" name="image" type="file" class="hidden">
                            @error('image') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('petani.products.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 text-sm rounded-lg font-medium transition-colors inline-flex items-center gap-1.5">
                        <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                        Batal
                    </a>
                    <x-loading-button class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">
                        <i data-lucide="save" class="w-4 h-4" aria-hidden="true"></i>
                        Perbarui Produk
                    </x-loading-button>
                </div>
            </form>
        </x-ui.card>
    </div>
</div>
@endsection
