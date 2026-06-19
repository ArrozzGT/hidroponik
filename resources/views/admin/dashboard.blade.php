@extends('layouts.admin')

@section('page', 'Dashboard')

@section('header')
    <div>
        <h2 class="font-heading font-bold text-xl text-gray-900">Admin Dashboard</h2>
        <p class="text-sm text-gray-400 mt-0.5">Ringkasan sistem SIPSH</p>
    </div>
@endsection

@section('admin-content')
    <div class="space-y-6">

        <x-breadcrumb :crumbs="[['label' => 'Dashboard']]" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-ui.card class="p-6 col-span-2 bg-white">
                <p class="text-sm text-gray-400 font-medium">Total Pendapatan</p>
                <p class="text-4xl font-heading font-bold text-gray-900 mt-1">Rp 850 Jt</p>
                <div class="mt-4 flex items-end gap-1 h-16">
                    @php
                        $vals = [35, 48, 42, 58, 62, 55, 70, 78, 65, 82, 90, 85];
                        $max = max($vals);
                    @endphp
                    @foreach($vals as $v)
                        <div class="flex-1 bg-emerald-100 rounded-t" style="height: {{ ($v/$max)*100 }}%"></div>
                    @endforeach
                    <div class="flex-1 bg-emerald-600 rounded-t" style="height: 100%"></div>
                </div>
            </x-ui.card>

            <x-ui.card class="p-6 bg-blue-50 border-blue-100">
                <div class="flex items-center gap-3">
                    <i data-lucide="users" style="width:20px;height:20px;color:#2563eb;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $stats['total_users'] }})" x-text="current">{{ $stats['total_users'] }}</p>
                        <p class="text-xs text-gray-500">Total User</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card class="p-6 bg-emerald-50 border-emerald-100">
                <div class="flex items-center gap-3">
                    <i data-lucide="package" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $stats['total_products'] }})" x-text="current">{{ $stats['total_products'] }}</p>
                        <p class="text-xs text-gray-500">Total Produk</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card class="p-6 bg-amber-50 border-amber-100">
                <div class="flex items-center gap-3">
                    <i data-lucide="clipboard-list" style="width:20px;height:20px;color:#d97706;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $stats['total_orders'] }})" x-text="current">{{ $stats['total_orders'] }}</p>
                        <p class="text-xs text-gray-500">Total Pesanan</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card class="p-6 bg-green-50 border-green-100">
                <div class="flex items-center gap-3">
                    <i data-lucide="sprout" style="width:20px;height:20px;color:#16a34a;" aria-hidden="true"></i>
                    <div>
                        <p class="text-2xl font-heading font-bold text-gray-900" x-data="countUp({{ $stats['total_petani'] }})" x-text="current">{{ $stats['total_petani'] }}</p>
                        <p class="text-xs text-gray-500">Total Petani</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <x-ui.card>
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-heading font-semibold text-gray-900">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-xs text-emerald-600 font-medium hover:underline">
                    Lihat Semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pembeli</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['recent_orders'] as $order)
                            @php
                                $sc = match($order->status) {
                                    'completed' => 'success',
                                    'processing' => 'info',
                                    'shipping'  => 'primary',
                                    'cancelled'  => 'danger',
                                    default      => 'warning',
                                };
                            @endphp
                            <tr>
                                <td><span class="font-mono font-medium text-gray-800 text-xs">{{ $order->order_number }}</span></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <x-ui.avatar size="sm" fallback="{{ strtoupper(substr($order->user?->name, 0, 1)) }}" />
                                        <span class="text-sm text-gray-700">{{ $order->user?->name }}</span>
                                    </div>
                                </td>
                                <td><span class="font-medium text-emerald-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></td>
                                <td><x-ui.badge :variant="$sc">{{ ucfirst($order->status) }}</x-ui.badge></td>
                                <td class="text-gray-400 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs text-emerald-600 font-medium hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-ui.card class="p-6">
                <h3 class="font-heading font-semibold text-gray-900 mb-4">Petani Pending Verifikasi</h3>
                <div class="space-y-3">
                    @forelse(($pendingPetani ?? collect()) as $petani)
                        <div class="flex items-center gap-3 py-2">
                            <x-ui.avatar size="md" fallback="{{ strtoupper(substr($petani->name, 0, 2)) }}" />
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $petani->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $petani->email }}</p>
                            </div>
                            <div class="flex gap-1.5">
                                <form action="{{ route('admin.users.verify', $petani) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button class="bg-emerald-600 text-white px-3 py-1 text-xs rounded-md hover:bg-emerald-700 transition-colors">Approve</button>
                                </form>
                                <form action="{{ route('admin.users.verify', $petani) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1 text-xs rounded-md hover:bg-gray-50 transition-colors">Reject</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 py-4 text-center">Tidak ada petani yang menunggu verifikasi.</p>
                    @endforelse
                </div>
            </x-ui.card>

            <x-ui.card class="p-6">
                <h3 class="font-heading font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.users.petani-pending') }}" class="bg-white border border-gray-100 rounded-xl p-6 text-center hover:border-gray-200 transition-colors">
                        <i data-lucide="user-check" style="width:24px;height:24px;color:#059669;" class="mb-2" aria-hidden="true"></i>
                        <p class="text-sm font-medium text-gray-700">Verifikasi Petani</p>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="bg-white border border-gray-100 rounded-xl p-6 text-center hover:border-gray-200 transition-colors">
                        <i data-lucide="package" style="width:24px;height:24px;color:#059669;" class="mb-2" aria-hidden="true"></i>
                        <p class="text-sm font-medium text-gray-700">Kelola Pesanan</p>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="bg-white border border-gray-100 rounded-xl p-6 text-center hover:border-gray-200 transition-colors">
                        <i data-lucide="tag" style="width:24px;height:24px;color:#059669;" class="mb-2" aria-hidden="true"></i>
                        <p class="text-sm font-medium text-gray-700">Kategori</p>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="bg-white border border-gray-100 rounded-xl p-6 text-center hover:border-gray-200 transition-colors">
                        <i data-lucide="bar-chart-2" style="width:24px;height:24px;color:#059669;" class="mb-2" aria-hidden="true"></i>
                        <p class="text-sm font-medium text-gray-700">Laporan</p>
                    </a>
                    <a href="{{ route('admin.logs.index') }}" class="bg-white border border-gray-100 rounded-xl p-6 text-center col-span-2 hover:border-gray-200 transition-colors">
                        <i data-lucide="scroll-text" style="width:24px;height:24px;color:#059669;" class="mb-2" aria-hidden="true"></i>
                        <p class="text-sm font-medium text-gray-700">Log Aktivitas</p>
                    </a>
                </div>
            </x-ui.card>
        </div>

    </div>
@endsection
