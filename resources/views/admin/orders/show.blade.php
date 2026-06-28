@extends('layouts.admin')
@section('page', 'Detail Pesanan')

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="clipboard-list" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Detail Pesanan #{{ $order->order_number }}
                </h2>
                <p class="text-sm text-gray-600 mt-0.5">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-2 text-sm rounded-lg font-medium transition-colors inline-flex items-center gap-1">
            <i data-lucide="arrow-left" style="width:14px;height:14px;" aria-hidden="true"></i> Kembali
        </a>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell reveal">
        <x-breadcrumb :crumbs="[['label' => 'Pesanan', 'url' => route('admin.orders.index')], ['label' => '#' . $order->order_number]]" />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Produk yang Dipesan</h3>
                    <div class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <div class="py-4 flex items-center space-x-4">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 rounded-xl object-cover" loading="lazy"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div class="w-14 h-14 rounded-xl hidden items-center justify-center bg-gray-100">
                                        <i data-lucide="sprout" style="width:20px;height:20px;color:#d1d5db;" aria-hidden="true"></i>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 truncate">{{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                                    <p class="text-xs text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-bold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-5 border-t flex items-center justify-between">
                        <span class="font-bold text-lg text-gray-900">Total</span>
                        <span class="font-bold text-2xl text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </x-ui.card>

                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Pengiriman</h3>
                    @php
                        $metodeLabels = ['ambil_ditempat' => 'Ambil di Tempat', 'antar_kurir' => 'Antar Kurir', 'ekspedisi' => 'Ekspedisi'];
                    @endphp
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="truck" class="w-4 h-4 text-emerald-600" aria-hidden="true"></i>
                        <span class="text-sm font-medium text-gray-700">{{ $metodeLabels[$order->metode_pengiriman] ?? $order->metode_pengiriman }}</span>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $order->shipping_address }}</p>
                    @if($order->note)
                        <div class="mt-4 p-4 bg-gray-50 rounded-xl text-sm text-gray-600 italic">{{ $order->note }}</div>
                    @endif
                </x-ui.card>

                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Pembeli</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar size="xl" :src="$order->user->foto ? asset('storage/' . $order->user->foto) : null" fallback="{{ substr($order->user->name, 0, 1) }}" />
                        <div class="min-w-0">
                            <p class="font-bold text-gray-900 truncate">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ $order->user->email }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ $order->user->no_hp }}</p>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <div class="space-y-6">
                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Update Status</h3>
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Status Pesanan</label>
                            <select name="status" class="form-input">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Shipping</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <x-loading-button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">
                            Perbarui Status
                        </x-loading-button>
                    </form>
                </x-ui.card>

                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Pembayaran</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-600">Status</span>
                        <x-ui.badge :variant="$order->payment_status === 'paid' ? 'success' : 'default'">
                            {{ $order->payment_status }}
                        </x-ui.badge>
                    </div>
                    @if($order->transaksi && $order->transaksi->va_number)
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm">
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-500">Metode</span>
                                <span class="font-medium">{{ $order->transaksi->metode_pembayaran ?? 'VA' }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-500">VA Number</span>
                                <span class="font-mono font-bold">{{ $order->transaksi->va_number }}</span>
                            </div>
                            @if($order->transaksi->expiry_time)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Berlaku</span>
                                <span class="text-gray-600">{{ $order->transaksi->expiry_time->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    @endif
                </x-ui.card>

                <x-ui.card class="p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Riwayat Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-600">Dibuat: {{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($order->payment_status === 'paid')
                            <div class="flex items-center space-x-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                                <span class="text-sm text-gray-600">Pembayaran: {{ $order->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </x-ui.card>
            </div>
        </div>
    </div>
@endsection
