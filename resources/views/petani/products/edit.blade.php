@extends('layouts.petani')

@section('title', 'Edit Produk')
@section('page', 'Edit Produk')

@section('petani-content')
<div class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center gradient-green">
                    <i data-lucide="pencil" class="w-5 h-5 text-white" aria-hidden="true"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">Edit Produk</h1>
                    <p class="text-sm text-slate-500">Perbarui informasi produk</p>
                </div>
            </div>
            <span class="{{ $product->status === 'tersedia' ? 'badge-green' : 'badge-red' }}">{{ ucfirst($product->status) }}</span>
        </div>

        <div class="card p-6 sm:p-8">
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
                            <label for="image" class="form-label">Foto Produk</label>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover rounded-2xl mb-3 border border-slate-200" alt="{{ $product->name }}">
                            @endif
                            <label for="image" class="flex flex-col items-center justify-center px-6 py-8 border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50 hover:bg-green-50 cursor-pointer transition-colors">
                                <i data-lucide="upload-cloud" class="w-9 h-9 text-green-500 mb-2" aria-hidden="true"></i>
                                <span class="text-sm font-semibold text-slate-600">Klik untuk ganti foto</span>
                                <span class="form-help">Kosongkan jika tidak ingin mengubah foto</span>
                            </label>
                            <input id="image" name="image" type="file" class="hidden">
                            @error('image') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                    <a href="{{ route('petani.products.index') }}" class="btn-secondary"><i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i> Batal</a>
                    <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4" aria-hidden="true"></i> Perbarui Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
