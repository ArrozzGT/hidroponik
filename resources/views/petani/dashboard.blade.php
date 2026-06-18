@extends('layouts.petani')

@section('title', 'Petani Dashboard')
@section('page', 'Dashboard')

@section('petani-content')
<div class="reveal py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header with Gradient Banner --}}
        <div class="gradient-green rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden">
            <div class="absolute inset-0" style="background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:44px 44px;"></div>
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-white/15 backdrop-blur shadow-lg">
                        <i data-lucide="sprout" class="w-7 h-7 text-white" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Petani Dashboard</h1>
                        <p class="text-white/70 text-sm mt-1">Kelola kebun dan produk hidroponik Anda</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('petani.products.create') }}" class="magnetic inline-flex items-center gap-2 px-5 py-2.5 bg-white text-green-900 font-bold text-sm rounded-xl hover:opacity-90 transition-all shadow-lg active:scale-95">
                        <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                        Tambah Produk
                    </a>
                </div>
            </div>
            <div class="absolute right-6 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none hidden sm:block">
                <i data-lucide="sprout" class="w-28 h-28 text-white" aria-hidden="true"></i>
            </div>
        </div>

        {{-- Pending Verification Alert --}}
        @if($stats['pending_verifikasi'])
            <div class="card p-5 border-l-4 border-amber-500 bg-amber-50/70 animate-[fadeIn_0.5s_ease-out]">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-100 flex-shrink-0">
                        <i data-lucide="clock" class="w-5 h-5 text-amber-600" aria-hidden="true"></i>
                    </div>
                    <div class="flex-1">
                        <span class="badge-yellow text-[11px]">Menunggu Verifikasi</span>
                        <h3 class="mt-2 font-bold text-amber-900 text-sm">Akun Menunggu Verifikasi Admin</h3>
                        <p class="text-sm text-amber-700 mt-1 leading-relaxed">Admin sedang meninjau profil kebun Anda. Produk dapat ditambahkan, namun belum muncul di katalog sampai akun diaktifkan.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Stats Grid --}}
        @php $totalRevenue = $revenueTotal ?? 0; @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="stat-card hover-lift stagger-1 animate-[fadeIn_0.4s_ease-out]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Produk Saya</span>
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-green-50 shadow-sm">
                        <i data-lucide="package" class="w-5 h-5 text-green-700" aria-hidden="true"></i>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900" x-data="countUp({{ $stats['my_products'] }})" x-text="current">{{ $stats['my_products'] }}</p>
                <p class="text-xs text-slate-500 mt-1.5 font-medium">produk terdaftar</p>
                <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-green-500 transition-all duration-700" style="width:{{ min($stats['my_products'] * 10, 100) }}%"></div>
                </div>
            </div>

            <div class="stat-card hover-lift stagger-2 animate-[fadeIn_0.5s_ease-out]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Penjualan</span>
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-blue-50 shadow-sm">
                        <i data-lucide="trending-up" class="w-5 h-5 text-blue-600" aria-hidden="true"></i>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900" x-data="countUp({{ $stats['my_sales'] }})" x-text="current">{{ $stats['my_sales'] }}</p>
                <p class="text-xs text-slate-500 mt-1.5 font-medium">pesanan selesai</p>
                <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-blue-500 transition-all duration-700" style="width:{{ min($stats['my_sales'] * 15, 100) }}%"></div>
                </div>
            </div>

            <div class="stat-card hover-lift stagger-3 animate-[fadeIn_0.6s_ease-out]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Pendapatan</span>
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-emerald-50 shadow-sm">
                        <i data-lucide="wallet" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900" x-data="countUp({{ $totalRevenue }})" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(current)">{{ $totalRevenue > 0 ? 'Rp ' . number_format($totalRevenue, 0, ',', '.') : 'Rp 0' }}</p>
                <p class="text-xs text-slate-500 mt-1.5 font-medium">dari pesanan selesai</p>
                <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-emerald-500 transition-all duration-700" style="width:{{ $totalRevenue > 0 ? min(($totalRevenue / 10000000) * 100, 100) : 0 }}%"></div>
                </div>
            </div>

            <div class="stat-card hover-lift stagger-4 animate-[fadeIn_0.7s_ease-out]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Rating</span>
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-amber-50 shadow-sm">
                        <i data-lucide="star" class="w-5 h-5 text-amber-500" aria-hidden="true"></i>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900">
                    @if($avgRating > 0)
                        <span x-data="countUp({{ round($avgRating * 10) }})" x-text="(current / 10).toFixed(1)">{{ number_format($avgRating, 1) }}</span>
                    @else
                        <span class="text-slate-300">—</span>
                    @endif
                </p>
                <p class="text-xs text-slate-500 mt-1.5 font-medium">rata-rata ulasan</p>
                <div class="mt-3 flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($avgRating))
                            <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400" aria-hidden="true"></i>
                        @else
                            <i data-lucide="star" class="w-4 h-4 text-slate-200" aria-hidden="true"></i>
                        @endif
                    @endfor
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="card p-6 hover-lift animate-[fadeIn_0.6s_ease-out]">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2.5">
                    <div class="w-1.5 h-6 rounded-full bg-gradient-to-b from-green-500 to-green-700"></div>
                    <h2 class="text-lg font-bold text-slate-900">Pesanan Terbaru</h2>
                </div>
                <span class="badge-green text-[10px]">{{ $recentOrders->count() }} pesanan</span>
            </div>

            @if($recentOrders->isEmpty())
                <div class="text-center py-12">
                    <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center bg-green-50">
                        <i data-lucide="shopping-cart" class="w-8 h-8 text-green-400" aria-hidden="true"></i>
                    </div>
                    <p class="text-slate-500 font-medium text-sm">Belum ada pesanan masuk.</p>
                    <p class="text-xs text-slate-400 mt-1">Pesanan akan muncul di sini setelah pembeli melakukan checkout.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        @php
                            $progress = match($order->status) { 'pending'=>20, 'processing'=>50, 'shipping'=>80, 'completed'=>100, default=>10 };
                            $progressColor = match($order->status) { 'completed'=>'#16a34a', 'shipping'=>'#7c3aed', 'processing'=>'#2563eb', 'cancelled'=>'#ef4444', default=>'#f59e0b' };
                            $statusBadge = match($order->status) { 'completed'=>'badge-green', 'shipping'=>'badge-purple', 'processing'=>'badge-blue', 'cancelled'=>'badge-red', default=>'badge-yellow' };
                        @endphp
                        <div class="p-4 rounded-2xl border border-slate-100 hover:border-green-200 hover:bg-green-50/40 transition-all bg-white">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-slate-50 border border-slate-100">
                                        <i data-lucide="receipt" class="w-4 h-4 text-slate-600" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-slate-900 font-mono">{{ $order->order_number }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $order->created_at->diffForHumans() }} • <span class="font-medium">{{ $order->user?->name ?? 'Pembeli' }}</span></p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1.5">
                                    <span class="{{ $statusBadge }} text-[10px]">{{ ucfirst($order->status) }}</span>
                                    <p class="font-bold text-sm text-green-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if($order->status !== 'cancelled')
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-700 ease-out" style="width:{{ $progress }}%;background:{{ $progressColor }};"></div>
                                </div>
                                <div class="flex justify-between text-[10px] text-slate-400 font-medium mt-1.5">
                                    <span>Dipesan</span>
                                    @if($order->status === 'processing')<span class="text-blue-600">Diproses</span>@endif
                                    @if($order->status === 'shipping')<span class="text-purple-600">Dikirim</span>@endif
                                    @if($order->status === 'completed')<span class="text-green-600">Selesai</span>@endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="card p-6 hover-lift animate-[fadeIn_0.8s_ease-out]">
            <div class="flex items-center gap-2.5 mb-5">
                <div class="w-1.5 h-6 rounded-full bg-gradient-to-b from-green-500 to-green-700"></div>
                <h2 class="text-lg font-bold text-slate-900">Aksi Cepat</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('petani.products.create') }}" class="magnetic group flex items-center gap-4 p-4 rounded-2xl border border-slate-200 bg-white hover:border-green-300 hover:bg-green-50/60 transition-all shadow-sm hover:shadow-md active:scale-[0.98]">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-br from-green-400 to-green-700 shadow-md shadow-green-200">
                        <i data-lucide="plus-circle" class="w-6 h-6 text-white" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-slate-900 group-hover:text-green-700 transition-colors">Tambah Produk</p>
                        <p class="text-xs text-slate-500 mt-0.5">Buat produk baru</p>
                    </div>
                </a>
                <a href="{{ route('petani.panen.create') }}" class="magnetic group flex items-center gap-4 p-4 rounded-2xl border border-slate-200 bg-white hover:border-green-300 hover:bg-green-50/60 transition-all shadow-sm hover:shadow-md active:scale-[0.98]">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-br from-amber-400 to-amber-700 shadow-md shadow-amber-200">
                        <i data-lucide="tractor" class="w-6 h-6 text-white" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-slate-900 group-hover:text-green-700 transition-colors">Catat Panen</p>
                        <p class="text-xs text-slate-500 mt-0.5">Input hasil panen</p>
                    </div>
                </a>
                <a href="{{ route('petani.stok-nutrisi.index') }}" class="magnetic group flex items-center gap-4 p-4 rounded-2xl border border-slate-200 bg-white hover:border-green-300 hover:bg-green-50/60 transition-all shadow-sm hover:shadow-md active:scale-[0.98]">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-700 shadow-md shadow-blue-200">
                        <i data-lucide="flask-conical" class="w-6 h-6 text-white" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-slate-900 group-hover:text-green-700 transition-colors">Stok Nutrisi</p>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola nutrisi</p>
                    </div>
                </a>
                <a href="{{ route('petani.orders.index') }}" class="magnetic group flex items-center gap-4 p-4 rounded-2xl border border-slate-200 bg-white hover:border-green-300 hover:bg-green-50/60 transition-all shadow-sm hover:shadow-md active:scale-[0.98]">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-br from-purple-400 to-purple-700 shadow-md shadow-purple-200">
                        <i data-lucide="truck" class="w-6 h-6 text-white" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-slate-900 group-hover:text-green-700 transition-colors">Lihat Pesanan</p>
                        <p class="text-xs text-slate-500 mt-0.5">Riwayat & status</p>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
