@extends('layouts.pembeli')

@section('title', 'Dashboard Pembeli')
@section('page', 'Dashboard')

@section('pembeli-content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 reveal">

        {{-- Welcome + Hero --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-[fadeIn_0.3s_ease-out]">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center gradient-green shadow-lg shadow-green-200">
                    <i data-lucide="shopping-bag" class="w-6 h-6 text-white" aria-hidden="true"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">Selamat datang, {{ auth()->user()->name }}!</h1>
                    <p class="text-sm text-slate-500">Kelola pesanan dan belanja sayuran segar hari ini</p>
                </div>
            </div>
            <a href="{{ route('shop.index') }}" class="btn-primary shadow-md active:scale-95">
                <i data-lucide="store" class="w-4 h-4" aria-hidden="true"></i> Mulai Belanja
            </a>
        </div>

        {{-- Hero Banner --}}
        <div class="gradient-green rounded-3xl p-8 text-white relative overflow-hidden animate-[fadeIn_0.4s_ease-out]">
            <div class="absolute inset-0" style="background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:44px 44px;"></div>
            <div class="relative z-10">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-4 bg-white/20 backdrop-blur">
                    <i data-lucide="leaf" class="w-3 h-3" aria-hidden="true"></i>
                    Marketplace Hidroponik
                </span>
                <h2 class="text-3xl font-extrabold mb-2">Sayuran Segar Menanti!</h2>
                <p class="text-white/75 mb-6 max-w-sm text-sm leading-relaxed">Dapatkan produk hidroponik kualitas terbaik langsung dari petani lokal.</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm bg-white text-green-900 hover:opacity-90 transition-all shadow-lg active:scale-95">
                    Mulai Belanja
                    <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
            </div>
            <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none">
                <i data-lucide="sprout" class="w-32 h-32 text-white" aria-hidden="true"></i>
            </div>
        </div>

        {{-- Order Status Cards --}}
        @php
            $userId = auth()->id();
            $countBelumBayar  = \App\Models\Order::where('user_id', $userId)->where('payment_status','unpaid')->where('status','pending')->count();
            $countDiproses    = \App\Models\Order::where('user_id', $userId)->where('status','processing')->count();
            $countDikirim     = \App\Models\Order::where('user_id', $userId)->where('status','shipping')->count();
            $countSelesai     = \App\Models\Order::where('user_id', $userId)->where('status','completed')->count();
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-card text-center hover:-translate-y-1.5 transition-all duration-200 animate-[fadeIn_0.3s_ease-out] hover-lift">
                <div class="w-12 h-12 rounded-2xl mx-auto mb-3 flex items-center justify-center bg-amber-100 shadow-sm">
                    <i data-lucide="clock" class="w-5 h-5 text-amber-600" aria-hidden="true"></i>
                </div>
                <p class="text-2xl font-extrabold text-amber-600">{{ $countBelumBayar }}</p>
                <p class="text-xs text-slate-500 font-semibold mt-1">Belum Bayar</p>
            </div>
            <div class="stat-card text-center hover:-translate-y-1.5 transition-all duration-200 animate-[fadeIn_0.4s_ease-out] hover-lift">
                <div class="w-12 h-12 rounded-2xl mx-auto mb-3 flex items-center justify-center bg-blue-50 shadow-sm">
                    <i data-lucide="settings" class="w-5 h-5 text-blue-600" aria-hidden="true"></i>
                </div>
                <p class="text-2xl font-extrabold text-blue-600">{{ $countDiproses }}</p>
                <p class="text-xs text-slate-500 font-semibold mt-1">Diproses</p>
            </div>
            <div class="stat-card text-center hover:-translate-y-1.5 transition-all duration-200 animate-[fadeIn_0.5s_ease-out] hover-lift">
                <div class="w-12 h-12 rounded-2xl mx-auto mb-3 flex items-center justify-center bg-purple-50 shadow-sm">
                    <i data-lucide="truck" class="w-5 h-5 text-purple-600" aria-hidden="true"></i>
                </div>
                <p class="text-2xl font-extrabold text-purple-600">{{ $countDikirim }}</p>
                <p class="text-xs text-slate-500 font-semibold mt-1">Dikirim</p>
            </div>
            <div class="stat-card text-center hover:-translate-y-1.5 transition-all duration-200 animate-[fadeIn_0.6s_ease-out] hover-lift">
                <div class="w-12 h-12 rounded-2xl mx-auto mb-3 flex items-center justify-center bg-green-50 shadow-sm">
                    <i data-lucide="package-check" class="w-5 h-5 text-green-700" aria-hidden="true"></i>
                </div>
                <p class="text-2xl font-extrabold text-green-700">{{ $countSelesai }}</p>
                <p class="text-xs text-slate-500 font-semibold mt-1">Selesai</p>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="card p-6 animate-[fadeIn_0.5s_ease-out]">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-1.5 h-6 rounded-full bg-gradient-to-b from-green-500 to-green-700"></div>
                    <h2 class="text-lg font-bold text-slate-900">Pesanan Terakhir</h2>
                </div>
                <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-green-700 hover:text-green-800 hover:underline transition-colors flex items-center gap-1">
                    Lihat Semua <i data-lucide="chevron-right" class="w-3.5 h-3.5" aria-hidden="true"></i>
                </a>
            </div>

            @if($stats['recent_orders']->isEmpty())
                <div class="text-center py-14">
                    <div class="w-20 h-20 rounded-3xl mx-auto mb-4 flex items-center justify-center bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100">
                        <i data-lucide="shopping-cart" class="w-10 h-10 text-green-300" aria-hidden="true"></i>
                    </div>
                    <p class="text-slate-600 font-medium text-sm">Belum ada riwayat pesanan.</p>
                    <p class="text-xs text-slate-400 mt-1">Mulai belanja untuk melihat pesanan Anda di sini.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-1.5 mt-4 text-xs font-semibold text-green-700 bg-green-50 px-4 py-2 rounded-xl hover:bg-green-100 transition-colors">
                        Mulai Belanja <i data-lucide="arrow-right" class="w-3 h-3" aria-hidden="true"></i>
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($stats['recent_orders'] as $order)
                        @php
                            $progress = match($order->status) { 'pending'=>20,'processing'=>50,'shipping'=>80,'completed'=>100,default=>10 };
                            $progressColor = match($order->status) { 'completed'=>'#16a34a','shipping'=>'#7c3aed','processing'=>'#2563eb','cancelled'=>'#ef4444',default=>'#f59e0b' };
                            $statusBadge = match($order->status) { 'completed'=>'badge-green','shipping'=>'badge-purple','processing'=>'badge-blue','cancelled'=>'badge-red',default=>'badge-yellow' };
                        @endphp
                        <a href="{{ route('orders.show', $order) }}"
                           class="block p-5 rounded-2xl border border-slate-100 hover:border-green-200 hover:bg-green-50/40 transition-all bg-white shadow-sm hover:shadow-md active:scale-[0.99] group">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-slate-50 border border-slate-100">
                                        <i data-lucide="receipt" class="w-4 h-4 text-slate-600" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-slate-900 font-mono group-hover:text-green-700 transition-colors">{{ $order->order_number }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="{{ $statusBadge }} text-[10px]">{{ ucfirst($order->status) }}</span>
                                    <p class="font-bold text-sm text-green-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if($order->status !== 'cancelled')
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-1.5 rounded-full transition-all duration-700 ease-out" style="width:{{ $progress }}%;background:{{ $progressColor }};"></div>
                                </div>
                            @endif
                            @if($order->payment_status === 'unpaid' && $order->status !== 'cancelled')
                                <div class="mt-3" onclick="event.stopPropagation()">
                                    <a href="{{ route('orders.show', $order) }}" class="badge-yellow normal-case !text-[11px] gap-1.5">
                                        <i data-lucide="upload" class="w-3 h-3" aria-hidden="true"></i> Upload Bukti Bayar
                                    </a>
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
