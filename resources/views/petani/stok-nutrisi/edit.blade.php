@extends('layouts.petani')
@section('page', 'Edit Stok Nutrisi')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shadow-green-200" style="background:linear-gradient(135deg,#4ade80,#22c55e);">
            <i data-lucide="edit" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Edit Stok Nutrisi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Perbarui data stok nutrisi</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-6 sm:p-8 max-w-2xl">
            <form action="{{ route('petani.stok-nutrisi.update', $stokNutrisi) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <label for="nama_nutrisi" class="form-label">Nama Nutrisi</label>
                    <input id="nama_nutrisi" name="nama_nutrisi" type="text" value="{{ old('nama_nutrisi', $stokNutrisi->nama_nutrisi) }}" class="form-input" required>
                    @error('nama_nutrisi') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stok_tersedia_liter" class="form-label">Stok Tersedia (Liter)</label>
                        <input id="stok_tersedia_liter" name="stok_tersedia_liter" type="number" step="0.01" value="{{ old('stok_tersedia_liter', $stokNutrisi->stok_tersedia_liter) }}" class="form-input" required>
                        @error('stok_tersedia_liter') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="stok_minimum_liter" class="form-label">Stok Minimum (Liter)</label>
                        <input id="stok_minimum_liter" name="stok_minimum_liter" type="number" step="0.01" value="{{ old('stok_minimum_liter', $stokNutrisi->stok_minimum_liter) }}" class="form-input" required>
                        @error('stok_minimum_liter') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('petani.stok-nutrisi.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4" aria-hidden="true"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
