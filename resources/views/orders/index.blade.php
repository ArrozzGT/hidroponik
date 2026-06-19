<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
                <i data-lucide="clipboard-list" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">{{ __('Riwayat Pesanan Saya') }}</h2>
                <p class="text-sm text-gray-400 mt-0.5">Semua pesanan yang pernah Anda buat</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="[['label' => 'Pesanan Saya']]" />

            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
                <div class="p-6">

                    @php
                        $statuses = ['all' => 'Semua', 'pending' => 'Pending', 'processing' => 'Diproses', 'shipping' => 'Dikirim', 'completed' => 'Selesai'];
                        $currentStatus = request('status', 'all');
                    @endphp

                    <div class="flex items-center gap-2 mb-5 overflow-x-auto scrollbar-hide">
                        @foreach($statuses as $key => $label)
                            <a href="{{ route('orders.index', ['status' => $key === 'all' ? null : $key]) }}"
                               class="whitespace-nowrap px-4 py-2 text-sm font-medium rounded-lg transition-colors
                                      {{ $currentStatus === $key ? 'bg-emerald-100 text-emerald-700' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                    <form method="GET" action="{{ route('orders.index') }}" class="mb-5">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" aria-hidden="true"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pesanan..."
                                   class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                        </div>
                    </form>

                    @if($orders->isEmpty())
                        <x-empty-state icon="clipboard-list" title="Tidak ada pesanan" description="Anda belum memiliki pesanan dengan filter ini.">
                            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                                <i data-lucide="store" class="w-4 h-4" aria-hidden="true"></i>
                                Mulai Belanja
                            </a>
                        </x-empty-state>
                    @else
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3.5 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Order #</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status Pesanan</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Pembayaran</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-5 py-4 font-mono font-medium text-sm text-gray-900">{{ $order->order_number }}</td>
                                            <td class="px-5 py-4 text-sm text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                                            <td class="px-5 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td class="px-5 py-4">
                                                @php
                                                    $sc = match($order->status) {
                                                        'completed' => 'success',
                                                        'processing' => 'info',
                                                        'shipping' => 'primary',
                                                        'cancelled' => 'danger',
                                                        default => 'warning',
                                                    };
                                                @endphp
                                                <x-ui.badge :variant="$sc">{{ ucfirst($order->status) }}</x-ui.badge>
                                            </td>
                                            <td class="px-5 py-4">
                                                @php $ps = $order->payment_status === 'paid' ? 'success' : 'default'; @endphp
                                                <x-ui.badge :variant="$ps">{{ ucfirst($order->payment_status) }}</x-ui.badge>
                                            </td>
                                            <td class="px-5 py-4">
                                                <a href="{{ route('orders.show', $order) }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 transition-colors">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="md:hidden space-y-3">
                            @foreach($orders as $order)
                                @php
                                    $sc = match($order->status) {
                                        'completed' => 'success',
                                        'processing' => 'info',
                                        'shipping' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'warning',
                                    };
                                    $ps = $order->payment_status === 'paid' ? 'success' : 'default';
                                @endphp
                                <div class="border border-gray-100 rounded-xl p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <p class="font-mono font-medium text-sm text-gray-900">{{ $order->order_number }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y') }}</p>
                                        </div>
                                        <p class="font-medium text-sm text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 mb-3">
                                        <x-ui.badge :variant="$sc">{{ ucfirst($order->status) }}</x-ui.badge>
                                        <x-ui.badge :variant="$ps">{{ ucfirst($order->payment_status) }}</x-ui.badge>
                                    </div>
                                    <a href="{{ route('orders.show', $order) }}" class="block w-full text-center text-xs font-medium text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-3 py-2 rounded-lg transition-colors">
                                        Lihat Detail
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-5">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
