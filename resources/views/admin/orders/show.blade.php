@extends('layouts.admin')
@section('page', 'Detail Pesanan')

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
                <i data-lucide="clipboard-list" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Detail Pesanan #{{ $order->order_number }}
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">Informasi lengkap pesanan</p>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-ghost text-sm flex items-center gap-1">
            <i data-lucide="arrow-left" style="width:14px;height:14px;" aria-hidden="true"></i> Kembali
        </a>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell reveal">
        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-6 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div class="card p-6 hover-lift">
                    <h3 class="font-bold text-gray-900 mb-4">Produk yang Dipesan</h3>
                    <div class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <div class="py-4 flex items-center space-x-4 stagger-{{ $loop->iteration }}">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 rounded-xl object-cover">
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                                    <p class="text-xs text-gray-400">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-bold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-5 border-t flex items-center justify-between">
                        <span class="font-bold text-lg text-gray-900">Total</span>
                        <span class="font-bold text-2xl text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="card p-6 hover-lift">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Pengiriman</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $order->shipping_address }}</p>
                    @if($order->note)
                        <div class="mt-4 p-4 bg-gray-50 rounded-2xl text-sm text-gray-500 italic">{{ $order->note }}</div>
                    @endif
                </div>

                <div class="card p-6 hover-lift">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Pembeli</h3>
                    <div class="flex items-center space-x-4">
                        @if($order->user->foto)
                            <img src="{{ asset('storage/' . $order->user->foto) }}" class="w-14 h-14 rounded-2xl object-cover">
                        @else
                            <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 font-bold text-lg">{{ substr($order->user->name, 0, 1) }}</div>
                        @endif
                        <div>
                            <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-400">{{ $order->user->email }}</p>
                            <p class="text-sm text-gray-400">{{ $order->user->no_hp }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6 hover-lift">
                    <h3 class="font-bold text-gray-900 mb-4">Update Status</h3>
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status Pesanan')" />
                            <select name="status" id="status" class="form-input mt-1">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Shipping</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary w-full magnetic">Perbarui Status</button>
                    </form>
                </div>

                <div class="card p-6 hover-lift">
                    <h3 class="font-bold text-gray-900 mb-4">Pembayaran</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="badge {{ $order->payment_status === 'paid' ? 'badge-green' : 'badge-gray' }}">{{ $order->payment_status }}</span>
                    </div>
                    @if($order->payment_proof)
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="flex items-center justify-center p-4 bg-gray-50 rounded-2xl text-sm text-green-600 font-semibold hover:bg-green-50 transition-colors">
                            <i data-lucide="image" style="width:18px;height:18px;margin-right:8px;" aria-hidden="true"></i>
                            Lihat Bukti Transfer
                        </a>
                    @endif
                </div>

                <div class="card p-6 hover-lift">
                    <h3 class="font-bold text-gray-900 mb-4">Riwayat Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-500">Dibuat: {{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($order->payment_status === 'paid')
                            <div class="flex items-center space-x-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                                <span class="text-sm text-gray-500">Pembayaran: {{ $order->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
