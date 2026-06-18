<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">Detail Pesanan #{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-400 mt-0.5">Informasi lengkap pesanan Anda</p>
            </div>
            <span class="badge {{ $order->status === 'pending' ? 'badge-yellow' : ($order->status === 'cancelled' ? 'badge-red' : 'badge-green') }}">{{ $order->status }}</span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 reveal">
            @if(session('success'))
                <div class="bg-primary-50 border border-primary-100 text-primary-700 px-5 py-3 rounded-2xl mb-6 text-sm font-medium">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6 reveal stagger-1">
                    <div class="card card-pad hover-lift">
                        <h3 class="font-bold text-gray-900 mb-5">Produk yang Dipesan</h3>
                        <div class="divide-y divide-gray-50">
                            @foreach($order->items as $ii => $item)
                                <div class="py-4 flex items-center space-x-4 {{ 'stagger-' . (($ii % 4) + 1) }}">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 rounded-xl object-cover">
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $item->product->name }}</h4>
                                        <p class="text-xs text-gray-400">{{ $item->quantity }} {{ $item->product->unit }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="font-bold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 pt-5 border-t flex items-center justify-between">
                            <span class="font-bold text-lg text-gray-900">Total</span>
                            <span class="font-bold text-2xl text-primary-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="card card-pad hover-lift">
                        <h3 class="font-bold text-gray-900 mb-4">Informasi Pengiriman</h3>
                        @php
                            $metodeLabels = [
                                'ambil_ditempat' => ['label' => 'Ambil di Tempat', 'icon' => 'store', 'color' => '#d97706'],
                                'antar_kurir' => ['label' => 'Antar Kurir', 'icon' => 'bike', 'color' => '#2563eb'],
                                'ekspedisi' => ['label' => 'Ekspedisi', 'icon' => 'truck', 'color' => '#7c3aed'],
                            ];
                            $m = $metodeLabels[$order->metode_pengiriman] ?? ['label' => ucfirst($order->metode_pengiriman), 'icon' => 'package', 'color' => '#6b7280'];
                        @endphp
                        <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-2xl">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background:{{ $m['color'] }}22;">
                                <i data-lucide="{{ $m['icon'] }}" style="width:16px;height:16px;color:{{ $m['color'] }};" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $m['label'] }}</p>
                                <p class="text-xs text-gray-400">Metode pengiriman</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $order->shipping_address }}</p>
                        @if($order->note)
                            <div class="mt-4 p-4 bg-gray-50 rounded-2xl text-sm text-gray-500 italic">{{ $order->note }}</div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6 reveal stagger-2">
                    <div class="card card-pad hover-lift">
                        <h3 class="font-bold text-gray-900 mb-4">Pembayaran</h3>
                        @if($order->payment_status === 'unpaid')
                            <div class="bg-primary-50/50 rounded-2xl p-5 mb-5 space-y-2">
                                <p class="text-xs text-gray-500 font-semibold">Silakan transfer ke rekening berikut:</p>
                                <p class="text-sm font-bold text-gray-800">🏦 Bank BRI: 1234-5678-9012-345</p>
                                <p class="text-sm font-bold text-gray-800">A/N: SIPSH Hidroponik</p>
                                <p class="text-sm mt-3 text-primary-600 font-bold border-t border-primary-100 pt-3">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>

                            <form action="{{ route('orders.payment', $order) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="payment_proof" :value="__('Upload Bukti Transfer')" />
                                    <div class="mt-1 flex items-center justify-center px-4 py-6 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-gray-100/50 transition-colors cursor-pointer">
                                        <label for="payment_proof" class="flex flex-col items-center cursor-pointer">
                                            <svg class="w-6 h-6 text-gray-300 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                            <span class="text-xs text-gray-400 font-medium">Klik untuk upload</span>
                                        </label>
                                        <input id="payment_proof" name="payment_proof" type="file" class="hidden" required />
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('payment_proof')" />
                                </div>
                                <button type="submit" class="btn-primary w-full py-3 magnetic">Konfirmasi Pembayaran</button>
                            </form>
                        @else
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="font-bold text-primary-600 text-lg">Terbayar</p>
                                <p class="text-xs text-gray-400 mt-2">Bukti pembayaran telah diunggah dan sedang diproses.</p>
                                @if($order->payment_proof)
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="mt-4 inline-flex items-center text-xs text-primary-600 hover:underline font-semibold">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat Bukti Transfer
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('orders.index') }}" class="flex items-center justify-center text-sm text-gray-400 hover:text-gray-600 font-medium transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
