@extends('layouts.admin')
@section('page', 'Pesanan')

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
            <i data-lucide="clipboard-list" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
        </div>
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Manajemen Pesanan') }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola semua pesanan masuk</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="page-shell reveal">
        <x-breadcrumb :crumbs="[['label' => 'Pesanan']]" />

        <x-ui.card>
            <div class="p-6">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-end gap-3 mb-5">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input text-sm" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipping" {{ request('status') === 'shipping' ? 'selected' : '' }}>Shipping</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Dari</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-input text-sm">
                    </div>
                    <div>
                        <label class="form-label">Sampai</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-input text-sm">
                    </div>
                    <div>
                        <label class="form-label">User</label>
                        <input type="text" name="user" value="{{ request('user') }}" placeholder="Nama pembeli..." class="form-input text-sm">
                    </div>
                    <button type="submit" class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 text-sm rounded-lg font-medium transition-colors">Filter</button>
                </form>

                <div class="hidden md:block table-wrap overflow-x-auto">
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
                            @forelse($orders as $order)
                                @php
                                    $os = match($order->status) { 'completed' => 'success', 'processing' => 'info', 'shipping' => 'primary', 'cancelled' => 'danger', default => 'warning' };
                                    $ps = $order->payment_status === 'paid' ? 'success' : 'default';
                                @endphp
                                <tr class="stagger-{{ $loop->iteration }}">
                                    <td class="font-bold text-sm text-gray-900 font-mono">{{ $order->order_number }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <x-ui.avatar size="sm" fallback="{{ strtoupper(substr($order->user->name, 0, 1)) }}" />
                                            <span class="text-sm text-gray-700 truncate max-w-[140px]">{{ $order->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td><x-ui.badge :variant="$os">{{ $order->status }}</x-ui.badge></td>
                                    <td><x-ui.badge :variant="$ps">{{ $order->payment_status }}</x-ui.badge></td>
                                    <td class="text-gray-400 text-xs">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors inline-flex items-center gap-1">
                                            <i data-lucide="eye" style="width:12px;height:12px;" aria-hidden="true"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <x-empty-state icon="clipboard-list" title="Tidak ada pesanan" description="Tidak ada pesanan yang cocok dengan filter Anda." />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden space-y-3">
                    @forelse($orders as $order)
                        @php
                            $os = match($order->status) { 'completed' => 'success', 'processing' => 'info', 'shipping' => 'primary', 'cancelled' => 'danger', default => 'warning' };
                            $ps = $order->payment_status === 'paid' ? 'success' : 'default';
                        @endphp
                        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="font-bold text-sm text-gray-900 font-mono">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d/m/Y') }}</p>
                                </div>
                                <p class="font-bold text-sm text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center gap-1.5 mb-2">
                                <x-ui.badge :variant="$os">{{ $order->status }}</x-ui.badge>
                                <x-ui.badge :variant="$ps">{{ $order->payment_status }}</x-ui.badge>
                            </div>
                            <div class="flex items-center gap-2 border-t border-gray-50 pt-3">
                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                    <x-ui.avatar size="sm" fallback="{{ strtoupper(substr($order->user->name, 0, 1)) }}" />
                                    <span class="text-sm text-gray-800 truncate">{{ $order->user->name }}</span>
                                </div>
                                <a href="{{ route('admin.orders.show', $order) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors inline-flex items-center gap-1">
                                    <i data-lucide="eye" style="width:12px;height:12px;" aria-hidden="true"></i> Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <x-empty-state icon="clipboard-list" title="Tidak ada pesanan" description="Tidak ada pesanan yang cocok dengan filter Anda." />
                    @endforelse
                </div>
                <div class="mt-5">
                    {{ $orders->links() }}
                </div>
            </div>
        </x-ui.card>
    </div>
@endsection
