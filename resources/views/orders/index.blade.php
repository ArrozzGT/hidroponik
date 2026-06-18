<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#22c55e,#15803d);">
                <i data-lucide="clipboard-list" style="width:20px;height:20px;color:#fff;" aria-hidden="true"></i>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">{{ __('Riwayat Pesanan Saya') }}</h2>
                <p class="text-sm text-gray-400 mt-0.5">Semua pesanan yang pernah Anda buat</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
            <div class="card card-pad overflow-hidden">
                <div class="p-6">
                    @if($orders->isEmpty())
                        <div class="text-center py-16">
                            <div class="w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-5" style="background:#f0fdf4;">
                                <i data-lucide="clipboard-list" style="width:36px;height:36px;color:#86efac;" aria-hidden="true"></i>
                            </div>
                            <p class="text-gray-500 font-medium mb-5">Anda belum memiliki pesanan.</p>
                            <a href="{{ route('shop.index') }}" class="btn-primary">
                                <i data-lucide="store" style="width:16px;height:16px;" aria-hidden="true"></i>
                                Mulai Belanja
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Order #</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Total</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Status Pesanan</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Pembayaran</th>
                                        <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($orders as $oi => $order)
                                        <tr class="hover:bg-gray-50/50 transition-colors hover-lift {{ 'stagger-' . (($oi % 8) + 1) }}">
                                            <td class="px-5 py-4 font-bold text-sm text-gray-900">{{ $order->order_number }}</td>
                                            <td class="px-5 py-4 text-sm text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                                            <td class="px-5 py-4 text-sm font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td class="px-5 py-4">
                                                <span class="badge {{ $order->status === 'pending' ? 'badge-yellow' : ($order->status === 'cancelled' ? 'badge-red' : 'badge-green') }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4">
                                                <span class="badge {{ $order->payment_status === 'paid' ? 'badge-green' : 'badge-gray' }}">
                                                    {{ $order->payment_status }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4">
                                                <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center text-xs font-semibold text-primary-600 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition-colors">
                                                    Lihat Detail
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
