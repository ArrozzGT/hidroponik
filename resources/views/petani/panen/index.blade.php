@extends('layouts.petani')
@section('page', 'Data Panen')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="tractor" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Data Panen</h2>
            <p class="text-sm text-gray-600 mt-0.5">Catat dan kelola hasil panen kebun Anda</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :crumbs="[['label' => 'Data Panen']]" />

        @php
            $totalPanen = $panen->sum('jumlah_panen_kg');
            $avgPanen = $panen->count() > 0 ? $totalPanen / $panen->count() : 0;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <x-ui.card class="p-5 bg-emerald-50 border-emerald-100">
                <p class="text-xs text-gray-600">Total Panen</p>
                <p class="text-2xl font-heading font-bold text-gray-900">{{ number_format($totalPanen, 2) }} <span class="text-sm font-medium text-gray-600">Kg</span></p>
            </x-ui.card>
            <x-ui.card class="p-5 bg-blue-50 border-blue-100">
                <p class="text-xs text-gray-600">Rata-rata per Panen</p>
                <p class="text-2xl font-heading font-bold text-gray-900">{{ number_format($avgPanen, 2) }} <span class="text-sm font-medium text-gray-600">Kg</span></p>
            </x-ui.card>
            <x-ui.card class="p-5 bg-amber-50 border-amber-100">
                <p class="text-xs text-gray-600">Total Catatan Panen</p>
                <p class="text-2xl font-heading font-bold text-gray-900">{{ $panen->count() }} <span class="text-sm font-medium text-gray-600">kali</span></p>
            </x-ui.card>
        </div>

        <div class="flex justify-end mb-6">
            <a href="{{ route('petani.panen.create') }}" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors inline-flex items-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i> Catat Panen Baru
            </a>
        </div>

        <x-ui.card>
            <div class="hidden md:block table-wrap overflow-x-auto">
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
                                    <span class="font-semibold text-gray-800 truncate max-w-[160px] inline-block">{{ $p->product->name ?? '—' }}</span>
                                </td>
                                <td class="font-bold text-gray-900">{{ number_format($p->jumlah_panen_kg, 2) }}</td>
                                <td class="text-gray-600">{{ $p->tanggal_panen->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $qVariant = $p->kualitas === 'A' ? 'success' : ($p->kualitas === 'B' ? 'warning' : 'danger');
                                    @endphp
                                    <x-ui.badge :variant="$qVariant">{{ $p->kualitas }}</x-ui.badge>
                                </td>
                                <td class="text-gray-600 text-sm max-w-xs truncate">{{ $p->keterangan ?? '—' }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('petani.panen.edit', $p) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Edit</a>
                                        <form action="{{ route('petani.panen.destroy', $p) }}" method="POST" onsubmit="return confirm('Yakin hapus data panen ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-empty-state icon="tractor" title="Belum ada data panen" description="Catat hasil panen pertama Anda.">
                                        <a href="{{ route('petani.panen.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                                            <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                                            Catat Panen Baru
                                        </a>
                                    </x-empty-state>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-3">
                @forelse($panen as $p)
                    @php
                        $qVariant = $p->kualitas === 'A' ? 'success' : ($p->kualitas === 'B' ? 'warning' : 'danger');
                    @endphp
                    <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between mb-2">
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">{{ $p->product->name ?? '—' }}</p>
                                <p class="text-xs text-gray-600">{{ $p->tanggal_panen->format('d/m/Y') }}</p>
                            </div>
                            <x-ui.badge :variant="$qVariant">{{ $p->kualitas }}</x-ui.badge>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-50 pt-3">
                            <div>
                                <p class="font-bold text-gray-900">{{ number_format($p->jumlah_panen_kg, 2) }} Kg</p>
                                <p class="text-xs text-gray-600 truncate max-w-[160px]">{{ $p->keterangan ?? '—' }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('petani.panen.edit', $p) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Edit</a>
                                <form action="{{ route('petani.panen.destroy', $p) }}" method="POST" onsubmit="return confirm('Yakin hapus data panen ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <x-empty-state icon="tractor" title="Belum ada data panen" description="Catat hasil panen pertama Anda.">
                        <a href="{{ route('petani.panen.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                            Catat Panen Baru
                        </a>
                    </x-empty-state>
                @endforelse
            </div>
        </x-ui.card>
    </div>
@endsection
