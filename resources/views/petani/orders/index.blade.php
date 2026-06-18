@extends('layouts.petani')
@section('page', 'Pesanan Masuk')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shadow-green-200" style="background:linear-gradient(135deg,#4ade80,#22c55e);">
            <i data-lucide="clipboard-list" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Pesanan Masuk') }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola pesanan pembeli untuk produk Anda</p>
        </div>
    </div>
@endsection

@section('petani-content')
    <div class="reveal py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-6 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="card overflow-hidden hover-lift">
            <div class="p-6">
                <div class="table-wrap overflow-x-auto">
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
                                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold text-white bg-green-700">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-800">{{ $order->user->name }}</span>
                                                <p class="text-[10px] text-gray-400">{{ $order->shipping_address }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="space-y-1">
                                            @foreach($order->items as $item)
                                                <div class="text-xs text-gray-700">
                                                    {{ $item->product->name ?? 'Produk Dihapus' }} (x{{ $item->quantity }})
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge
                                            {{ $order->status === 'pending' ? 'badge-yellow' : '' }}
                                            {{ $order->status === 'processing' ? 'badge-blue' : '' }}
                                            {{ $order->status === 'shipping' ? 'badge-purple' : '' }}
                                            {{ $order->status === 'completed' ? 'badge-green' : '' }}
                                            {{ $order->status === 'cancelled' ? 'badge-red' : '' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $order->payment_status === 'paid' ? 'badge-green' : 'badge-gray' }}">
                                            {{ $order->payment_status }}
                                        </span>
                                    </td>
                                    <td class="text-gray-400 text-xs">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            @if($order->status === 'pending')
                                                <form action="{{ route('petani.orders.update-status', $order) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="magnetic btn-primary text-xs px-3 py-1.5 flex items-center gap-1">
                                                        <i data-lucide="play" style="width:12px;height:12px;" aria-hidden="true"></i> Proses
                                                    </button>
                                                </form>
                                            @elseif($order->status === 'processing')
                                                <form action="{{ route('petani.orders.update-status', $order) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="shipping">
                                                    <button type="submit" class="magnetic btn-primary !bg-purple-600 hover:!bg-purple-700 text-xs px-3 py-1.5 flex items-center gap-1">
                                                        <i data-lucide="truck" style="width:12px;height:12px;" aria-hidden="true"></i> Kirim
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400 italic">No Action</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8 text-gray-400 italic">Belum ada pesanan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
