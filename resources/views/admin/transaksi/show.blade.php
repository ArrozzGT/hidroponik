@extends('layouts.admin')
@section('page', 'Detail Transaksi')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.transaksi.index') }}" class="w-9 h-9 rounded-xl flex items-center justify-center border border-gray-200 hover:bg-gray-50 transition-colors">
            <i data-lucide="arrow-left" style="width:18px;height:18px;" aria-hidden="true"></i>
        </a>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Detail Transaksi</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $transaksi->order->order_number ?? '—' }}</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell">
        <x-breadcrumb :crumbs="[['label' => 'Transaksi', 'url' => route('admin.transaksi.index')], ['label' => 'Detail']]" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 bg-green-700 rounded-full"></span>
                        Informasi Pesanan
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Order #</span>
                            <p class="font-bold text-gray-900 font-mono">{{ $transaksi->order->order_number }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Pembeli</span>
                            <p class="font-semibold text-gray-900 truncate">{{ $transaksi->order->user->name }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Total</span>
                            <p class="font-bold text-green-700">Rp {{ number_format($transaksi->order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Status Pesanan</span>
                            <p><x-ui.badge :variant="$transaksi->order->status === 'completed' ? 'success' : 'warning'">{{ $transaksi->order->status }}</x-ui.badge></p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-sm text-gray-700 mb-3">Item Pesanan</h4>
                        <table class="data-table">
                            <thead>
                                <tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->order->items as $item)
                                    <tr>
                                        <td><span class="truncate max-w-[200px] inline-block">{{ $item->product->name ?? '—' }}</span></td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="font-bold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-ui.card>

                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 bg-blue-500 rounded-full"></span>
                        Riwayat Log Transaksi
                    </h3>
                    <div class="space-y-3">
                        @forelse($transaksi->logs as $log)
                            <div class="flex items-start gap-3 text-sm">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-gray-100 shrink-0">
                                    <i data-lucide="activity" class="w-3.5 h-3.5 text-gray-600" aria-hidden="true"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-800 truncate">{{ $log->aksi }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $log->detail_perubahan ?? '' }}</p>
                                    <p class="text-[10px] text-gray-500 mt-0.5 truncate">{{ $log->created_at->format('d/m/Y H:i') }} • {{ $log->user->name ?? 'Sistem' }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">Belum ada log transaksi.</p>
                        @endforelse
                    </div>
                </x-ui.card>
            </div>

            <div class="space-y-6">
                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 bg-purple-500 rounded-full"></span>
                        Pembayaran
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Metode</span>
                            <span class="font-semibold">{{ $transaksi->metode_pembayaran ?? '—' }}</span>
                        </div>
                        @if($transaksi->va_number)
                        <div class="flex justify-between">
                            <span class="text-gray-500">VA Number</span>
                            <span class="font-mono font-bold text-gray-800">{{ $transaksi->va_number }}</span>
                        </div>
                        @endif
                        @if($transaksi->expiry_time)
                        <div class="flex justify-between">
                            <span class="text-gray-500">VA Expiry</span>
                            <span class="text-gray-600">{{ $transaksi->expiry_time->format('d/m/Y H:i') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status</span>
                            @php $pv = $transaksi->status_pembayaran === 'paid' ? 'success' : ($transaksi->status_pembayaran === 'failed' ? 'danger' : 'warning'); @endphp
                            <x-ui.badge :variant="$pv">{{ $transaksi->status_pembayaran }}</x-ui.badge>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Konfirmasi</span>
                            <span class="text-gray-600">{{ $transaksi->tanggal_konfirmasi ? $transaksi->tanggal_konfirmasi->format('d/m/Y H:i') : '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Oleh</span>
                            <span class="font-semibold">{{ $transaksi->confirmedBy->name ?? '—' }}</span>
                        </div>
                    </div>

                    @if($transaksi->status_pembayaran === 'unpaid')
                        <div class="mt-6 space-y-2">
                            <form action="{{ route('admin.transaksi.confirm', $transaksi) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status_pembayaran" value="paid">
                                <x-loading-button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                    <i data-lucide="check-circle" class="w-4 h-4" aria-hidden="true"></i> Konfirmasi Dibayar
                                </x-loading-button>
                            </form>
                            <form action="{{ route('admin.transaksi.confirm', $transaksi) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status_pembayaran" value="failed">
                                <x-loading-button class="w-full bg-red-600 hover:bg-red-700 text-white rounded-lg" onclick="return confirm('Tandai pembayaran gagal?')">
                                    <i data-lucide="x-circle" class="w-4 h-4" aria-hidden="true"></i> Tandai Gagal
                                </x-loading-button>
                            </form>
                        </div>
                    @endif

                </x-ui.card>
            </div>
        </div>
    </div>
@endsection
