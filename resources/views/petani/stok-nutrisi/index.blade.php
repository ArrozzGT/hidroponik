@extends('layouts.petani')
@section('page', 'Stok Nutrisi')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shadow-green-200" style="background:linear-gradient(135deg,#4ade80,#22c55e);">
            <i data-lucide="flask-conical" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Stok Nutrisi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola persediaan nutrisi hidroponik</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="reveal py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-6 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="flex justify-end mb-6">
            <a href="{{ route('petani.stok-nutrisi.create') }}" class="magnetic btn-primary">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i> Tambah Nutrisi
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @foreach($stok as $s)
                <div class="card p-5 hover-lift stagger-{{ $loop->iteration }} {{ $s->isLowStock() ? 'border-l-4 border-l-red-500' : '' }}">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $s->nama_nutrisi }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Stok Minimal: {{ number_format($s->stok_minimum_liter, 2) }} L</p>
                        </div>
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center {{ $s->isLowStock() ? 'bg-red-100' : 'bg-green-100' }}">
                            <i data-lucide="droplets" class="w-5 h-5 {{ $s->isLowStock() ? 'text-red-600' : 'text-green-600' }}" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p class="text-2xl font-extrabold {{ $s->isLowStock() ? 'text-red-600' : 'text-gray-900' }}">
                        {{ number_format($s->stok_tersedia_liter, 2) }} <span class="text-sm font-medium text-gray-400">L</span>
                    </p>
                    @if($s->isLowStock())
                        <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 px-3 py-1.5 rounded-xl">
                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5" aria-hidden="true"></i> Stok Menipis
                        </div>
                    @endif
                    <div class="mt-4 flex items-center gap-2">
                        <a href="{{ route('petani.stok-nutrisi.edit', $s) }}" class="btn-secondary !px-3 !py-1 text-xs">Edit</a>
                        <form action="{{ route('petani.stok-nutrisi.destroy', $s) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="badge-red normal-case text-xs">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if($stok->isEmpty())
            <div class="text-center py-16">
                <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center bg-green-50">
                    <i data-lucide="flask-conical" class="w-8 h-8 text-green-400" aria-hidden="true"></i>
                </div>
                <p class="text-gray-500 font-medium">Belum ada stok nutrisi.</p>
                <p class="text-xs text-gray-400 mt-1">Tambahkan nutrisi hidroponik yang Anda miliki.</p>
            </div>
        @endif

        <div class="mt-5">{{ $stok->links() }}</div>
    </div>
@endsection
