@extends('layouts.admin')

@section('page', 'Dashboard')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
            <i data-lucide="layout-dashboard" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Admin Dashboard</h2>
            <p class="text-sm text-gray-400 mt-0.5">Ringkasan sistem SIPSH</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell reveal">

        {{-- ══ STATS CARDS — 4 kartu dengan gradient accent ══ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 animate-fade-in">

            {{-- Total Users --}}
            <div class="stat-card relative overflow-hidden group reveal hover-lift stagger-1">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 bg-green-100 text-green-700 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="users" style="width:26px;height:26px;" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total User</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $stats['total_users'] }}</p>
                    </div>
                    <span class="ml-auto text-[10px] font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-700">+8%</span>
                </div>
            </div>

            {{-- Total Produk --}}
            <div class="stat-card relative overflow-hidden group reveal hover-lift stagger-2">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 bg-blue-100 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="package" style="width:26px;height:26px;" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Produk</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $stats['total_products'] }}</p>
                    </div>
                    <span class="ml-auto text-[10px] font-bold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700">+5%</span>
                </div>
            </div>

            {{-- Total Pesanan --}}
            <div class="stat-card relative overflow-hidden group reveal hover-lift stagger-3">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 bg-amber-100 text-amber-600 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="clipboard-list" style="width:26px;height:26px;" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Pesanan</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $stats['total_orders'] }}</p>
                    </div>
                    <span class="ml-auto text-[10px] font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700">+12%</span>
                </div>
            </div>

            {{-- Total Petani --}}
            <div class="stat-card relative overflow-hidden group reveal hover-lift stagger-4">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 bg-purple-100 text-purple-700 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="sprout" style="width:26px;height:26px;" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Petani</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $stats['total_petani'] }}</p>
                    </div>
                    <span class="ml-auto text-[10px] font-bold px-2.5 py-1 rounded-full bg-purple-100 text-purple-700">+3%</span>
                </div>
            </div>
        </div>

        {{-- ══ CHART + RECENT ORDERS GRID ══ --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Revenue Chart (CSS Bar Chart Mockup) --}}
            <div class="card p-6 xl:col-span-1 hover-lift">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-5 bg-green-700 rounded-full"></span>
                        Pendapatan Bulanan
                    </h3>
                    <span class="badge-green text-[10px]">+12.5%</span>
                </div>

                <div class="flex items-end justify-between gap-2 h-40 mb-3" style="padding:0 4px;" role="img" aria-label="Grafik pendapatan bulanan">
                    @php
                        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                        $values = [35, 48, 42, 58, 62, 55, 70, 78, 65, 82, 90, 85];
                        $maxVal = max($values);
                    @endphp
                    @foreach($values as $i => $val)
                        <div class="flex flex-col items-center gap-1.5 flex-1 group cursor-pointer">
                            <span class="text-[9px] font-bold text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity">Rp {{ $val }}jt</span>
                            <div class="w-full relative flex justify-center" style="height:120px;">
                                <div class="absolute bottom-0 w-full max-w-[28px] rounded-t-lg transition-all duration-500 ease-out
                                            {{ $i === array_key_last($values) ? 'bg-green-600' : ($i % 2 === 0 ? 'bg-green-400' : 'bg-green-500') }}"
                                     style="height:{{ ($val / $maxVal) * 100 }}%;"
                                     @mouseenter="$el.style.opacity='0.8'"
                                     @mouseleave="$el.style.opacity='1'">
                                </div>
                            </div>
                            <span class="text-[10px] font-medium text-gray-400 mt-1">{{ $months[$i % 12] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <span class="w-3 h-3 rounded inline-block bg-green-500"></span> Bulan Ini
                    </div>
                    <p class="text-sm font-bold text-green-700">Rp 850 Juta</p>
                </div>
            </div>

            {{-- Recent Orders Table --}}
            <div class="card overflow-hidden xl:col-span-2 hover-lift">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-5 bg-green-700 rounded-full"></span>
                        Pesanan Terbaru
                    </h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-xs text-green-700 font-semibold hover:underline flex items-center gap-1">
                        Lihat Semua
                        <i data-lucide="arrow-right" style="width:12px;height:12px;" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="table-wrap overflow-x-auto" style="border:none;border-radius:0;box-shadow:none;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th scope="col">No. Pesanan</th>
                                <th scope="col">Pembeli</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['recent_orders'] as $order)
                                <tr class="stagger-{{ $loop->iteration }}">
                                    <td>
                                        <span class="font-mono font-bold text-gray-800 text-xs">{{ $order->order_number }}</span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold text-white bg-green-700">
                                                {{ strtoupper(substr($order->user?->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $order->user?->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-bold text-green-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'completed' => 'badge-green',
                                                'processing' => 'badge-blue',
                                                'shipping'  => 'badge-purple',
                                                'cancelled'  => 'badge-red',
                                                default      => 'badge-yellow',
                                            };
                                        @endphp
                                        <span class="{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="btn-secondary text-xs px-3 py-1">
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr role="status">
                                    <td colspan="6" class="text-center py-8 text-gray-400 italic">Belum ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ══ PETANI PENDING & QUICK ACCESS ══ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Petani Pending Verifikasi --}}
            <div class="card p-6 hover-lift">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-5 bg-amber-500 rounded-full"></span>
                        Petani Pending Verifikasi
                    </h3>
                    <span class="badge-yellow">Menunggu</span>
                </div>
                <div class="space-y-3">
                    @forelse(($pendingPetani ?? collect()) as $petani)
                        <div class="flex items-center gap-3 py-2 px-3 rounded-xl hover:bg-gray-50 transition-colors -mx-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 bg-green-100 text-green-700">
                                {{ strtoupper(substr($petani->name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-900">{{ $petani->name }}</p>
                                <p class="text-xs text-gray-400 truncate">
                                    🏡 {{ $petani->petaniProfile->nama_kebun ?? '—' }} &nbsp;•&nbsp;
                                    📍 {{ $petani->petaniProfile->lokasi_kebun ?? '—' }}
                                </p>
                            </div>
                            <div class="flex gap-1.5 shrink-0">
                                <form action="{{ route('admin.users.verify', $petani) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button class="btn-primary text-xs px-3 py-1 magnetic">Approve</button>
                                </form>
                                <form action="{{ route('admin.users.verify', $petani) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <button class="btn-danger text-xs px-3 py-1">Reject</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 italic py-4 text-center">🎉 Tidak ada petani yang menunggu verifikasi.</p>
                    @endforelse
                    @if($pendingPetani->count() > 0)
                        <a href="{{ route('admin.users.petani-pending') }}" class="block text-center text-xs text-green-700 font-semibold mt-3 hover:underline">
                            Lihat Semua →
                        </a>
                    @endif
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="card p-6 hover-lift">
                <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-1 h-5 bg-blue-500 rounded-full"></span>
                    Aksi Cepat
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.users.petani-pending') }}"
                       class="flex flex-col items-center p-4 rounded-2xl hover:-translate-y-1 transition-all text-sm font-semibold bg-green-50 text-green-700 hover:bg-green-100 hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2 bg-green-200 text-green-700"><i data-lucide="user-check" style="width:20px;height:20px;" aria-hidden="true"></i></div>
                        Verifikasi Petani
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                       class="flex flex-col items-center p-4 rounded-2xl hover:-translate-y-1 transition-all text-sm font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2 bg-blue-200 text-blue-600"><i data-lucide="package" style="width:20px;height:20px;" aria-hidden="true"></i></div>
                        Kelola Pesanan
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                       class="flex flex-col items-center p-4 rounded-2xl hover:-translate-y-1 transition-all text-sm font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2 bg-amber-200 text-amber-600"><i data-lucide="tag" style="width:20px;height:20px;" aria-hidden="true"></i></div>
                        Kelola Kategori
                    </a>
                    <a href="{{ route('admin.reports.index') }}"
                       class="flex flex-col items-center p-4 rounded-2xl hover:-translate-y-1 transition-all text-sm font-semibold bg-purple-50 text-purple-700 hover:bg-purple-100 hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2 bg-purple-200 text-purple-700"><i data-lucide="bar-chart-2" style="width:20px;height:20px;" aria-hidden="true"></i></div>
                        Laporan
                    </a>
                    <a href="{{ route('admin.logs.index') }}"
                       class="flex flex-col items-center col-span-2 p-4 rounded-2xl hover:-translate-y-1 transition-all text-sm font-semibold bg-gray-50 text-gray-700 hover:bg-gray-100 hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2 bg-gray-200 text-gray-600"><i data-lucide="scroll-text" style="width:20px;height:20px;" aria-hidden="true"></i></div>
                        Log Aktivitas
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
