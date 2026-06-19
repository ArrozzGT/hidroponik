@extends('layouts.petani')

@section('title', 'Petani Dashboard')
@section('page', 'Dashboard')

@section('petani-content')
    <div class="space-y-8">

        <x-breadcrumb :crumbs="[['label' => 'Dashboard']]" />

        <div class="bg-green-800 rounded-xl p-8 text-white relative overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-heading font-bold">Petani Dashboard</h1>
                    <p class="text-green-300 text-sm mt-1">Kelola kebun dan produk hidroponik Anda</p>
                </div>
                <a href="{{ route('petani.products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 border border-white/30 text-white font-medium text-sm rounded-lg hover:bg-white/10 transition-colors">
                    <i data-lucide="plus" style="width:16px;height:16px;" aria-hidden="true"></i>
                    Tambah Produk
                </a>
            </div>
        </div>

        @if($stats['pending_verifikasi'])
            <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <i data-lucide="clock" style="width:20px;height:20px;color:#d97706;margin-top:2px;" aria-hidden="true"></i>
                    <div>
                        <p class="font-medium text-sm">Akun Menunggu Verifikasi Admin</p>
                        <p class="text-xs text-amber-700 mt-1">Admin sedang meninjau profil kebun Anda. Produk dapat ditambahkan, namun belum muncul di katalog sampai akun diaktifkan.</p>
                    </div>
                </div>
            </div>
        @endif

        @php $totalRevenue = $revenueTotal ?? 0; @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-ui.card class="p-6 bg-green-50 border-green-100">
                <div class="flex items-center gap-3">
                    <i data-lucide="package" style="width:20px;height:20px;color:#16a34a;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $stats['my_products'] }})" x-text="current">{{ $stats['my_products'] }}</p>
                        <p class="text-xs text-gray-500">Produk Saya</p>
                    </div>
                </div>
            </x-ui.card>
            <x-ui.card class="p-6 bg-blue-50 border-blue-100">
                <div class="flex items-center gap-3">
                    <i data-lucide="trending-up" style="width:20px;height:20px;color:#2563eb;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $stats['my_sales'] }})" x-text="current">{{ $stats['my_sales'] }}</p>
                        <p class="text-xs text-gray-500">Total Penjualan</p>
                    </div>
                </div>
            </x-ui.card>
            <x-ui.card class="p-6 bg-emerald-50 border-emerald-100 col-span-2">
                <p class="text-xs text-gray-500 mb-1">Pendapatan</p>
                <p class="text-3xl font-heading font-bold text-gray-900" x-data="countUp({{ $totalRevenue }})" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(current)">{{ $totalRevenue > 0 ? 'Rp ' . number_format($totalRevenue, 0, ',', '.') : 'Rp 0' }}</p>
                <div class="mt-3 h-1.5 w-full bg-emerald-200 rounded-full">
                    <div class="h-full rounded-full bg-emerald-600 transition-all" style="width:{{ $totalRevenue > 0 ? min(($totalRevenue / 10000000) * 100, 100) : 0 }}%"></div>
                </div>
            </x-ui.card>
            <x-ui.card class="p-6 bg-amber-50 border-amber-100">
                <div class="flex items-center gap-3">
                    <i data-lucide="star" style="width:20px;height:20px;color:#d97706;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900">
                            @if($avgRating > 0)
                                <span x-data="countUp({{ round($avgRating * 10) }})" x-text="(current / 10).toFixed(1)">{{ number_format($avgRating, 1) }}</span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">Rating</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div>
            <h2 class="font-heading font-semibold text-gray-900 mb-4">Pesanan Terbaru</h2>

            @if($recentOrders->isEmpty())
                <x-empty-state icon="shopping-cart" title="Belum ada pesanan masuk" description="Pesanan dari pembeli akan muncul di sini." />
            @else
                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                @php
                                    $sc = match($order->status) {
                                        'completed' => 'success',
                                        'processing' => 'info',
                                        'shipping' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'warning'
                                    };
                                @endphp
                                <tr>
                                    <td><span class="font-mono text-xs font-medium text-gray-800">{{ $order->order_number }}</span></td>
                                    <td><span class="text-sm text-gray-700">{{ $order->user?->name ?? 'Pembeli' }}</span></td>
                                    <td><span class="font-medium text-emerald-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></td>
                                    <td><x-ui.badge :variant="$sc">{{ ucfirst($order->status) }}</x-ui.badge></td>
                                    <td class="text-gray-400 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div>
            <h2 class="font-heading font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('petani.products.create') }}" class="bg-green-50 border border-green-100 rounded-xl p-6 flex items-center gap-4 hover:bg-green-100/50 transition-colors">
                    <i data-lucide="plus-circle" style="width:28px;height:28px;color:#16a34a;" aria-hidden="true"></i>
                    <div>
                        <p class="font-medium text-gray-900">Tambah Produk</p>
                        <p class="text-xs text-gray-500">Buat produk baru</p>
                    </div>
                </a>
                <a href="{{ route('petani.panen.create') }}" class="bg-teal-50 border border-teal-100 rounded-xl p-6 flex items-center gap-4 hover:bg-teal-100/50 transition-colors">
                    <i data-lucide="tractor" style="width:28px;height:28px;color:#0d9488;" aria-hidden="true"></i>
                    <div>
                        <p class="font-medium text-gray-900">Catat Panen</p>
                        <p class="text-xs text-gray-500">Input hasil panen</p>
                    </div>
                </a>
                <a href="{{ route('petani.stok-nutrisi.index') }}" class="bg-amber-50 border border-amber-100 rounded-xl p-6 flex items-center gap-4 hover:bg-amber-100/50 transition-colors">
                    <i data-lucide="flask-conical" style="width:28px;height:28px;color:#d97706;" aria-hidden="true"></i>
                    <div>
                        <p class="font-medium text-gray-900">Stok Nutrisi</p>
                        <p class="text-xs text-gray-500">Kelola nutrisi</p>
                    </div>
                </a>
                <a href="{{ route('petani.orders.index') }}" class="bg-blue-50 border border-blue-100 rounded-xl p-6 flex items-center gap-4 hover:bg-blue-100/50 transition-colors">
                    <i data-lucide="clipboard-list" style="width:28px;height:28px;color:#2563eb;" aria-hidden="true"></i>
                    <div>
                        <p class="font-medium text-gray-900">Lihat Pesanan</p>
                        <p class="text-xs text-gray-500">Riwayat & status</p>
                    </div>
                </a>
            </div>
        </div>

    </div>
@endsection
