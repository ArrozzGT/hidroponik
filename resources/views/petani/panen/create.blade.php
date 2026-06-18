@extends('layouts.petani')
@section('page', 'Catat Panen Baru')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shadow-green-200" style="background:linear-gradient(135deg,#4ade80,#22c55e);">
            <i data-lucide="plus-circle" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Catat Panen Baru</h2>
            <p class="text-sm text-gray-400 mt-0.5">Input hasil panen dari kebun Anda</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-6 sm:p-8 max-w-2xl">
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
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('petani.panen.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary"><i data-lucide="save" class="w-4 h-4" aria-hidden="true"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
