@extends('layouts.petani')
@section('page', 'Catat Panen Baru')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Catat Panen Baru</h2>
            <p class="text-sm text-gray-400 mt-0.5">Input hasil panen dari kebun Anda</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :crumbs="[['label' => 'Data Panen', 'url' => route('petani.panen.index')], ['label' => 'Catat Baru']]" />

        <x-ui.card padding="lg" class="max-w-2xl">
            <form action="{{ route('petani.panen.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="product_id" class="form-label">Produk</label>
                    <select name="product_id" id="product_id" class="form-input" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jumlah_panen_kg" class="form-label">Jumlah Panen (Kg)</label>
                        <input id="jumlah_panen_kg" name="jumlah_panen_kg" type="number" step="0.01" value="{{ old('jumlah_panen_kg') }}" class="form-input" required>
                        @error('jumlah_panen_kg') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="tanggal_panen" class="form-label">Tanggal Panen</label>
                        <input id="tanggal_panen" name="tanggal_panen" type="date" value="{{ old('tanggal_panen', date('Y-m-d')) }}" class="form-input" required>
                        @error('tanggal_panen') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label for="kualitas" class="form-label">Kualitas</label>
                    <select name="kualitas" id="kualitas" class="form-input" required>
                        <option value="A" @selected(old('kualitas') === 'A')>A - Premium</option>
                        <option value="B" @selected(old('kualitas') === 'B')>B - Standar</option>
                        <option value="C" @selected(old('kualitas') === 'C')>C - Ekonomis</option>
                    </select>
                    @error('kualitas') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="form-input" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('petani.panen.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 text-sm rounded-lg font-medium transition-colors">Batal</a>
                    <x-loading-button class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">
                        <i data-lucide="save" class="w-4 h-4" aria-hidden="true"></i>
                        Simpan
                    </x-loading-button>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection
