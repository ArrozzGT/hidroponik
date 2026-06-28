@extends('layouts.petani')
@section('page', 'Pesanan Masuk')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="clipboard-list" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Pesanan Masuk') }}</h2>
            <p class="text-sm text-gray-600 mt-0.5">Kelola pesanan pembeli untuk produk Anda</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="reveal py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :crumbs="[['label' => 'Pesanan Masuk']]" />

        @php
            $tabs = ['all' => 'Semua', 'pending' => 'Pending', 'processing' => 'Diproses', 'shipping' => 'Dikirim', 'completed' => 'Selesai'];
            $currentTab = request('status', 'all');
        @endphp

        <div class="flex items-center gap-2 mb-5 overflow-x-auto scrollbar-hide">
            @foreach($tabs as $key => $label)
                <a href="{{ route('petani.orders.index', ['status' => $key === 'all' ? null : $key]) }}"
                   class="whitespace-nowrap px-4 py-2 text-sm font-medium rounded-lg transition-colors
                          {{ $currentTab === $key ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:text-gray-700 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <x-ui.card>
            <div class="hidden md:block table-wrap overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Pembeli</th>
                            <th>Produk Anda</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="font-bold text-sm text-gray-900 font-mono">{{ $order->order_number }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <x-ui.avatar size="sm" fallback="{{ strtoupper(substr($order->user->name, 0, 1)) }}" />
                                        <div class="min-w-0">
                                            <span class="font-medium text-gray-800 truncate block">{{ $order->user->name }}</span>
                                            <p class="text-[10px] text-gray-600 truncate max-w-[120px]">{{ $order->shipping_address }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="space-y-1">
                                        @foreach($order->items as $item)
                                <div class="text-xs text-gray-700 truncate">
                                    {{ $item->product->name ?? 'Produk Dihapus' }} (x{{ $item->quantity }})
                                </div>
                            @endforeach
                                        </div>
                                    </td>
                                <td>
                                    @php $os = match($order->status) { 'completed' => 'success', 'processing' => 'info', 'shipping' => 'primary', 'cancelled' => 'danger', default => 'warning' }; @endphp
                                    <x-ui.badge :variant="$os">{{ $order->status }}</x-ui.badge>
                                </td>
                                <td>
                                    <x-ui.badge :variant="$order->payment_status === 'paid' ? 'success' : 'default'">{{ $order->payment_status }}</x-ui.badge>
                                </td>
                                <td class="text-gray-600 text-xs">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        @if($order->status === 'pending')
                                            <form action="{{ route('petani.orders.update-status', $order) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="bg-emerald-600 text-white hover:bg-emerald-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors inline-flex items-center gap-1">
                                                    <i data-lucide="play" style="width:12px;height:12px;" aria-hidden="true"></i> Proses
                                                </button>
                                            </form>
                                        @elseif($order->status === 'processing')
                                            <form action="{{ route('petani.orders.update-status', $order) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="shipping">
                                                <button type="submit" class="bg-purple-600 text-white hover:bg-purple-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors inline-flex items-center gap-1">
                                                    <i data-lucide="truck" style="width:12px;height:12px;" aria-hidden="true"></i> Kirim
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-600 italic">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <x-empty-state icon="clipboard-list" title="Belum ada pesanan masuk" description="Pesanan dari pembeli akan muncul di sini." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-3">
                @forelse($orders as $order)
                    @php $os = match($order->status) { 'completed' => 'success', 'processing' => 'info', 'shipping' => 'primary', 'cancelled' => 'danger', default => 'warning' }; @endphp
                    <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="font-bold text-sm text-gray-900 font-mono">{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-600">{{ $order->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <x-ui.badge :variant="$os">{{ $order->status }}</x-ui.badge>
                                <x-ui.badge :variant="$order->payment_status === 'paid' ? 'success' : 'default'">{{ $order->payment_status }}</x-ui.badge>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 border-t border-gray-50 pt-3">
                            <x-ui.avatar size="sm" fallback="{{ strtoupper(substr($order->user->name, 0, 1)) }}" />
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 text-sm">{{ $order->user->name }}</p>
                                <p class="text-[10px] text-gray-600 truncate">{{ $order->shipping_address }}</p>
                            </div>
                        </div>
                        <div class="mt-2 space-y-1">
                            @foreach($order->items as $item)
                                <div class="text-xs text-gray-700">
                                    {{ $item->product->name ?? 'Produk Dihapus' }} (x{{ $item->quantity }})
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            @if($order->status === 'pending')
                                <form action="{{ route('petani.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="w-full bg-emerald-600 text-white hover:bg-emerald-700 px-3 py-2 rounded-lg text-xs font-medium transition-colors inline-flex items-center justify-center gap-1">
                                        <i data-lucide="play" style="width:12px;height:12px;" aria-hidden="true"></i> Proses Pesanan
                                    </button>
                                </form>
                            @elseif($order->status === 'processing')
                                <form action="{{ route('petani.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="shipping">
                                    <button type="submit" class="w-full bg-purple-600 text-white hover:bg-purple-700 px-3 py-2 rounded-lg text-xs font-medium transition-colors inline-flex items-center justify-center gap-1">
                                        <i data-lucide="truck" style="width:12px;height:12px;" aria-hidden="true"></i> Kirim Pesanan
                                    </button>
                                </form>
                            @else
                                <p class="text-xs text-gray-600 italic text-center">—</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <x-empty-state icon="clipboard-list" title="Belum ada pesanan masuk" description="Pesanan dari pembeli akan muncul di sini." />
                @endforelse
            </div>
        </x-ui.card>
    </div>
@endsection
