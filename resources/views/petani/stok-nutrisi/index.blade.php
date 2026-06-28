@extends('layouts.petani')
@section('page', 'Stok Nutrisi')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="flask-conical" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Stok Nutrisi</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola persediaan nutrisi hidroponik</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="reveal py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :crumbs="[['label' => 'Stok Nutrisi']]" />

        <div class="flex justify-end mb-6">
            <a href="{{ route('petani.stok-nutrisi.create') }}" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors inline-flex items-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i> Tambah Nutrisi
            </a>
        </div>

        @if($stok->isEmpty())
            <x-empty-state icon="flask-conical" title="Belum ada stok nutrisi" description="Tambahkan nutrisi hidroponik yang Anda miliki.">
                <a href="{{ route('petani.stok-nutrisi.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                    Tambah Nutrisi
                </a>
            </x-empty-state>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @foreach($stok as $s)
                    @php
                        $pct = $s->stok_minimum_liter > 0 ? min(100, ($s->stok_tersedia_liter / $s->stok_minimum_liter) * 100) : 100;
                        $isLow = $s->isLowStock();
                    @endphp
                    <x-ui.card padding="lg" class="{{ $isLow ? 'border-l-4 border-l-red-500' : '' }}">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $s->nama_nutrisi }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Stok Minimal: {{ number_format($s->stok_minimum_liter, 2) }} L</p>
                            </div>
                            <span class="w-9 h-9 rounded-xl flex items-center justify-center {{ $isLow ? 'bg-red-100' : 'bg-green-100' }}">
                                <i data-lucide="droplets" class="w-5 h-5 {{ $isLow ? 'text-red-600' : 'text-green-600' }}" aria-hidden="true"></i>
                            </span>
                        </div>
                        <p class="text-2xl font-extrabold {{ $isLow ? 'text-red-600' : 'text-gray-900' }}">
                            {{ number_format($s->stok_tersedia_liter, 2) }} <span class="text-sm font-medium text-gray-500">L</span>
                        </p>
                        <div class="mt-3 h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $isLow ? 'bg-red-500' : ($pct > 50 ? 'bg-emerald-500' : 'bg-amber-500') }}" style="width: {{ $pct }}%"></div>
                        </div>
                        @if($isLow)
                            <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 px-3 py-1.5 rounded-xl">
                                <i data-lucide="alert-triangle" class="w-3.5 h-3.5" aria-hidden="true"></i> Stok Menipis
                            </div>
                        @endif
                        <div class="mt-4 flex items-center gap-2">
                            <a href="{{ route('petani.stok-nutrisi.edit', $s) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Edit</a>
                            <form action="{{ route('petani.stok-nutrisi.destroy', $s) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>

            <div class="mt-5">{{ $stok->links() }}</div>
        @endif
    </div>
@endsection
