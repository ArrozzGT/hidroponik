@extends('layouts.petani')
@section('page', 'Tambah Stok Nutrisi')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Tambah Stok Nutrisi</h2>
            <p class="text-sm text-gray-500 mt-0.5">Input nutrisi hidroponik baru</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :crumbs="[['label' => 'Stok Nutrisi', 'url' => route('petani.stok-nutrisi.index')], ['label' => 'Tambah Baru']]" />

        <x-ui.card padding="lg" class="max-w-2xl">
            <form action="{{ route('petani.stok-nutrisi.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="nama_nutrisi" class="form-label">Nama Nutrisi</label>
                    <input id="nama_nutrisi" name="nama_nutrisi" type="text" value="{{ old('nama_nutrisi') }}" class="form-input" required>
                    @error('nama_nutrisi') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stok_tersedia_liter" class="form-label">Stok Tersedia (Liter)</label>
                        <input id="stok_tersedia_liter" name="stok_tersedia_liter" type="number" step="0.01" value="{{ old('stok_tersedia_liter') }}" class="form-input" required>
                        @error('stok_tersedia_liter') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="stok_minimum_liter" class="form-label">Stok Minimum (Liter)</label>
                        <input id="stok_minimum_liter" name="stok_minimum_liter" type="number" step="0.01" value="{{ old('stok_minimum_liter', 1) }}" class="form-input" required>
                        @error('stok_minimum_liter') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('petani.stok-nutrisi.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 text-sm rounded-lg font-medium transition-colors">Batal</a>
                    <x-loading-button class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">
                        <i data-lucide="save" class="w-4 h-4" aria-hidden="true"></i>
                        Simpan
                    </x-loading-button>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection
