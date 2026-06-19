@extends('layouts.admin')
@section('page', 'Transaksi')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="credit-card" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Transaksi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola pembayaran pesanan</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <x-breadcrumb :crumbs="[['label' => 'Transaksi']]" />

        @php
            $totalTransaksi = $transaksi->sum(fn($t) => $t->order->total_price ?? 0);
            $paidCount = $transaksi->where('status_pembayaran', 'paid')->count();
            $unpaidCount = $transaksi->where('status_pembayaran', 'unpaid')->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <x-ui.card class="p-5 bg-emerald-50 border-emerald-100">
                <p class="text-xs text-gray-500">Total Transaksi</p>
                <p class="text-2xl font-heading font-bold text-gray-900">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</p>
            </x-ui.card>
            <x-ui.card class="p-5 bg-green-50 border-green-100">
                <p class="text-xs text-gray-500">Lunas</p>
                <p class="text-2xl font-heading font-bold text-green-700">{{ $paidCount }}</p>
            </x-ui.card>
            <x-ui.card class="p-5 bg-amber-50 border-amber-100">
                <p class="text-xs text-gray-500">Belum Dibayar</p>
                <p class="text-2xl font-heading font-bold text-amber-700">{{ $unpaidCount }}</p>
            </x-ui.card>
        </div>

        <x-ui.card>
            <div class="table-wrap overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Pembeli</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Dikonfirmasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $trx)
                            <tr>
                                <td><span class="font-mono font-bold text-gray-800">{{ $trx->order->order_number ?? '—' }}</span></td>
                                <td>{{ $trx->order->user->name ?? '—' }}</td>
                                <td class="text-gray-600">{{ $trx->metode_pembayaran ?? '—' }}</td>
                                <td>
                                    @php $pv = $trx->status_pembayaran === 'paid' ? 'success' : ($trx->status_pembayaran === 'failed' ? 'danger' : 'warning'); @endphp
                                    <x-ui.badge :variant="$pv">{{ $trx->status_pembayaran }}</x-ui.badge>
                                </td>
                                <td class="font-bold text-gray-900">Rp {{ number_format($trx->order->total_price ?? 0, 0, ',', '.') }}</td>
                                <td class="text-xs text-gray-400">
                                    @if($trx->tanggal_konfirmasi)
                                        {{ $trx->tanggal_konfirmasi->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.transaksi.show', $trx) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <x-empty-state icon="credit-card" title="Belum ada transaksi" description="Transaksi akan muncul di sini." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-5 border-t border-gray-100">{{ $transaksi->links() }}</div>
        </x-ui.card>
    </div>
@endsection
