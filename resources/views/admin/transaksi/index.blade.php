@extends('layouts.admin')
@section('page', 'Transaksi')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
            <i data-lucide="credit-card" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Transaksi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola pembayaran pesanan</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-6 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="card overflow-hidden">
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
                                    <span class="badge {{ $trx->status_pembayaran === 'paid' ? 'badge-green' : ($trx->status_pembayaran === 'failed' ? 'badge-red' : 'badge-yellow') }}">
                                        {{ $trx->status_pembayaran }}
                                    </span>
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
                                    <a href="{{ route('admin.transaksi.show', $trx) }}" class="btn-secondary !px-3 !py-1.5 text-xs">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-400 italic">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-5 border-t border-slate-100">{{ $transaksi->links() }}</div>
        </div>
    </div>
@endsection
