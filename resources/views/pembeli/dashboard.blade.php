@extends('layouts.pembeli')

@section('title', 'Dashboard Pembeli')
@section('page', 'Dashboard')

@section('pembeli-content')
    <div class="space-y-8">

        <x-breadcrumb :crumbs="[['label' => 'Dashboard']]" />

        <div class="bg-teal-700 rounded-xl p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl font-heading font-bold">Selamat datang, {{ auth()->user()->name }}!</h1>
                <p class="text-teal-200 text-sm mt-1 max-w-md">Kelola pesanan dan belanja sayuran segar hari ini</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-2.5 bg-white text-teal-800 font-medium text-sm rounded-lg hover:bg-teal-50 transition-colors">
                    Mulai Belanja
                    <i data-lucide="arrow-right" style="width:16px;height:16px;" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        @php
            $userId = auth()->id();
            $countBelumBayar  = \App\Models\Order::where('user_id', $userId)->where('payment_status','unpaid')->where('status','pending')->count();
            $countDiproses    = \App\Models\Order::where('user_id', $userId)->where('status','processing')->count();
            $countDikirim     = \App\Models\Order::where('user_id', $userId)->where('status','shipping')->count();
            $countSelesai     = \App\Models\Order::where('user_id', $userId)->where('status','completed')->count();
        @endphp

        <div>
            <h2 class="font-heading font-semibold text-gray-900 mb-4">Status Pesanan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-5 flex items-center gap-4">
                    <i data-lucide="clock" style="width:24px;height:24px;color:#d97706;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $countBelumBayar }})" x-text="current">{{ $countBelumBayar }}</p>
                        <p class="text-xs text-gray-500">Belum Bayar</p>
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 flex items-center gap-4">
                    <i data-lucide="settings" style="width:24px;height:24px;color:#2563eb;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $countDiproses }})" x-text="current">{{ $countDiproses }}</p>
                        <p class="text-xs text-gray-500">Diproses</p>
                    </div>
                </div>
                <div class="bg-purple-50 border border-purple-100 rounded-xl p-5 flex items-center gap-4">
                    <i data-lucide="truck" style="width:24px;height:24px;color:#7c3aed;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $countDikirim }})" x-text="current">{{ $countDikirim }}</p>
                        <p class="text-xs text-gray-500">Dikirim</p>
                    </div>
                </div>
                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-5 flex items-center gap-4">
                    <i data-lucide="package-check" style="width:24px;height:24px;color:#059669;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $countSelesai }})" x-text="current">{{ $countSelesai }}</p>
                        <p class="text-xs text-gray-500">Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-heading font-semibold text-gray-900">Pesanan Terakhir</h2>
                <a href="{{ route('orders.index') }}" class="text-xs text-teal-600 font-medium hover:underline">Lihat Semua</a>
            </div>

            @if($stats['recent_orders']->isEmpty())
                <x-empty-state icon="shopping-cart" title="Belum ada riwayat pesanan" description="Anda belum memiliki riwayat pesanan. Mulai belanja sekarang!">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                        <i data-lucide="store" class="w-4 h-4" aria-hidden="true"></i>
                        Mulai Belanja
                    </a>
                </x-empty-state>
            @else
                <div class="space-y-3">
                    @foreach($stats['recent_orders'] as $order)
                        @php
                            $statusBadge = match($order->status) {
                                'completed' => 'success',
                                'shipping' => 'primary',
                                'processing' => 'info',
                                'cancelled' => 'danger',
                                default => 'warning'
                            };
                        @endphp
                        <a href="{{ route('orders.show', $order) }}" class="block bg-white border border-gray-100 rounded-xl p-5 hover:border-gray-200 transition-colors">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-medium text-sm text-gray-900">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <x-ui.badge :variant="$statusBadge">{{ ucfirst($order->status) }}</x-ui.badge>
                                    <p class="font-medium text-sm text-emerald-700 mt-1">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if($order->payment_status === 'unpaid' && $order->status !== 'cancelled')
                                <div class="mt-3 bg-amber-50 border border-amber-200 text-amber-800 text-xs rounded-lg px-4 py-2">
                                    Upload bukti pembayaran untuk melanjutkan pesanan.
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection
