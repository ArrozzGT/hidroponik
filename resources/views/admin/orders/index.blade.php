@extends('layouts.admin')
@section('page', 'Pesanan')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
            <i data-lucide="clipboard-list" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Manajemen Pesanan') }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola semua pesanan masuk</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell reveal">
        <div class="card overflow-hidden hover-lift">
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-100 text-green-700 px-5 py-3 rounded-2xl mb-5 text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="table-wrap overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="stagger-{{ $loop->iteration }}">
                                    <td class="font-bold text-sm text-gray-900">{{ $order->order_number }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td class="font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
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
                                    <td class="text-gray-400">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-ghost text-xs px-3 py-1.5">
                                            <i data-lucide="eye" style="width:12px;height:12px;" aria-hidden="true"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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
