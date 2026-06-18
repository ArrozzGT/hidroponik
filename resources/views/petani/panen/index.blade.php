@extends('layouts.petani')
@section('page', 'Data Panen')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shadow-green-200" style="background:linear-gradient(135deg,#4ade80,#22c55e);">
            <i data-lucide="tractor" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Data Panen</h2>
            <p class="text-sm text-gray-400 mt-0.5">Catat dan kelola hasil panen kebun Anda</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-6 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="flex justify-end mb-6">
            <a href="{{ route('petani.panen.create') }}" class="btn-primary">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i> Catat Panen Baru
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="p-6">
                <div class="table-wrap overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah (Kg)</th>
                                <th>Tanggal Panen</th>
                                <th>Kualitas</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($panen as $p)
                                <tr>
                                    <td>
                                        <span class="font-semibold text-gray-800">{{ $p->product->name ?? '—' }}</span>
                                    </td>
                                    <td class="font-bold text-gray-900">{{ number_format($p->jumlah_panen_kg, 2) }}</td>
                                    <td class="text-gray-600">{{ $p->tanggal_panen->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge {{ $p->kualitas === 'A' ? 'badge-green' : ($p->kualitas === 'B' ? 'badge-yellow' : 'badge-red') }}">
                                            {{ $p->kualitas }}
                                        </span>
                                    </td>
                                    <td class="text-gray-500 text-sm max-w-xs truncate">{{ $p->keterangan ?? '—' }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('petani.panen.edit', $p) }}" class="btn-secondary !px-3 !py-1.5 text-xs">Edit</a>
                                            <form action="{{ route('petani.panen.destroy', $p) }}" method="POST" onsubmit="return confirm('Yakin hapus data panen ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="badge-red normal-case text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-400 italic">Belum ada data panen.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">{{ $panen->links() }}</div>
            </div>
        </div>
    </div>
@endsection
