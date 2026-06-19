<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
                    <i data-lucide="clipboard-list" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">Detail Pesanan #{{ $order->order_number }}</h2>
                    <p class="text-sm text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            @php
                $sc = match($order->status) {
                    'completed' => 'success',
                    'processing' => 'info',
                    'shipping' => 'primary',
                    'cancelled' => 'danger',
                    default => 'warning',
                };
            @endphp
            <x-ui.badge :variant="$sc" pill>{{ ucfirst($order->status) }}</x-ui.badge>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="[['label' => 'Pesanan Saya', 'url' => route('orders.index')], ['label' => '#' . $order->order_number]]" />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">

                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <h3 class="font-heading font-semibold text-gray-900 mb-5">Status Pesanan</h3>
                        @php
                            $steps = [
                                'pending' => 'Pesanan Dibuat',
                                'processing' => 'Diproses',
                                'shipping' => 'Dikirim',
                                'completed' => 'Selesai',
                            ];
                            $orderStatus = $order->status;
                            $stepKeys = array_keys($steps);
                            $currentIdx = array_search($orderStatus, $stepKeys);
                            if ($orderStatus === 'cancelled') $currentIdx = -1;
                        @endphp
                        <div class="flex items-center gap-2">
                            @foreach($steps as $key => $label)
                                @php
                                    $idx = array_search($key, $stepKeys);
                                    $done = $idx <= ($currentIdx ?? -1);
                                    $active = $key === $orderStatus;
                                @endphp
                                <div class="flex-1 flex flex-col items-center gap-1.5">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                        {{ $active ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' : ($done ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-400') }}">
                                        @if($done && !$active)
                                            <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i>
                                        @else
                                            <span>{{ $idx + 1 }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-center {{ $active ? 'text-emerald-700 font-semibold' : 'text-gray-400' }}">{{ $label }}</span>
                                </div>
                                @if(!$loop->last)
                                    <div class="flex-1 h-px {{ $done ? 'bg-emerald-300' : 'bg-gray-200' }}"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <h3 class="font-heading font-semibold text-gray-900 mb-5">Produk yang Dipesan</h3>
                        <div class="divide-y divide-gray-50">
                            @foreach($order->items as $item)
                                <div class="py-4 flex items-center space-x-4">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 rounded-lg object-cover" loading="lazy"
                                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                        <div class="w-14 h-14 rounded-lg hidden items-center justify-center bg-gray-50">
                                            <i data-lucide="sprout" style="width:20px;height:20px;color:#d1d5db;" aria-hidden="true"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                                        <p class="text-xs text-gray-400">{{ $item->quantity }} {{ $item->product->unit ?? 'pcs' }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="font-medium text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between">
                            <span class="font-heading font-semibold text-lg text-gray-900">Total</span>
                            <span class="font-heading font-bold text-2xl text-emerald-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <h3 class="font-heading font-semibold text-gray-900 mb-4">Informasi Pengiriman</h3>
                        @php
                            $metodeLabels = [
                                'ambil_ditempat' => ['label' => 'Ambil di Tempat', 'icon' => 'store'],
                                'antar_kurir' => ['label' => 'Antar Kurir', 'icon' => 'bike'],
                                'ekspedisi' => ['label' => 'Ekspedisi', 'icon' => 'truck'],
                            ];
                            $m = $metodeLabels[$order->metode_pengiriman] ?? ['label' => ucfirst($order->metode_pengiriman), 'icon' => 'package'];
                        @endphp
                        <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 bg-emerald-100">
                                <i data-lucide="{{ $m['icon'] }}" style="width:16px;height:16px;color:#059669;" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $m['label'] }}</p>
                                <p class="text-xs text-gray-400">Metode pengiriman</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $order->shipping_address }}</p>
                        @if($order->note)
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg text-sm text-gray-600 italic">{{ $order->note }}</div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <h3 class="font-heading font-semibold text-gray-900 mb-4">Pembayaran</h3>
                        @if($order->payment_status === 'unpaid')
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-5 mb-5">
                                <p class="text-xs text-gray-600 font-medium mb-2">Silakan transfer ke rekening berikut:</p>
                                <p class="text-sm font-medium text-gray-800">Bank BRI: 1234-5678-9012-345</p>
                                <p class="text-sm font-medium text-gray-800">A/N: SIPSH Hidroponik</p>
                                <p class="text-sm mt-3 text-amber-700 font-bold border-t border-amber-200 pt-3">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>

                            <form action="{{ route('orders.payment', $order) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload Bukti Transfer</label>
                                    <label for="payment_proof" class="flex flex-col items-center justify-center px-4 py-8 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100 hover:border-emerald-300 transition-colors cursor-pointer">
                                        <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-300 mb-2" aria-hidden="true"></i>
                                        <span class="text-xs text-gray-400 font-medium">Klik untuk upload</span>
                                        <span class="text-[10px] text-gray-300 mt-1">JPG, PNG, WebP maks 2MB</span>
                                    </label>
                                    <input id="payment_proof" name="payment_proof" type="file" class="hidden" required accept="image/jpeg,image/png,image/webp" />
                                    @error('payment_proof') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <x-loading-button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">
                                    <i data-lucide="check-circle" class="w-4 h-4" aria-hidden="true"></i>
                                    Konfirmasi Pembayaran
                                </x-loading-button>
                            </form>
                        @else
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="check-circle" class="w-8 h-8 text-emerald-600" aria-hidden="true"></i>
                                </div>
                                <p class="font-heading font-semibold text-emerald-600 text-lg">Terbayar</p>
                                <p class="text-xs text-gray-400 mt-2">Bukti pembayaran telah diunggah dan sedang diproses.</p>
                                @if($order->payment_proof)
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="mt-4 inline-flex items-center gap-1.5 text-xs text-emerald-600 hover:underline font-medium">
                                        <i data-lucide="image" class="w-3.5 h-3.5" aria-hidden="true"></i>
                                        Lihat Bukti Transfer
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('orders.index') }}" class="flex items-center justify-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 font-medium transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                        Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
