<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100">
                    <i data-lucide="clipboard-list" style="width:20px;height:20px;color:#059669;" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">Detail Pesanan #{{ $order->order_number }}</h2>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $order->created_at->format('d M Y H:i') }}</p>
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
            <x-back-button class="mb-4" />

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
                                        {{ $active ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' : ($done ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-500') }}">
                                        @if($done && !$active)
                                            <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i>
                                        @else
                                            <span>{{ $idx + 1 }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-center {{ $active ? 'text-emerald-700 font-semibold' : 'text-gray-500' }}">{{ $label }}</span>
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
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate">{{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                                        <p class="text-xs text-gray-500">{{ $item->quantity }} {{ $item->product->unit ?? 'pcs' }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
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
                                <p class="text-xs text-gray-500">Metode pengiriman</p>
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
                            @if($order->transaksi && $order->transaksi->va_number)
                                @php $va = $order->transaksi; @endphp
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-4">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i data-lucide="building-2" style="width:16px;height:16px;color:#2563eb;" aria-hidden="true"></i>
                                        <span class="text-sm font-medium text-gray-700">{{ $channels[$va->payment_channel]['name'] ?? 'Virtual Account' }}</span>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-blue-100">
                                        <p class="text-xs text-gray-500 mb-1">Nomor Virtual Account</p>
                                        <div class="flex items-center gap-2">
                                            <p class="text-xl font-mono font-bold text-gray-900 tracking-wider select-all" id="va-number">{{ $va->va_number }}</p>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ $va->va_number }}').then(() => { this.innerHTML = '<i data-lucide=\'check\' class=\'w-4 h-4 text-emerald-600\'></i>'; setTimeout(() => { this.innerHTML = '<i data-lucide=\'copy\' class=\'w-4 h-4 text-gray-500\'></i>'; lucide.createIcons(); }, 2000); })" class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors shrink-0" title="Salin nomor VA">
                                                <i data-lucide="copy" class="w-4 h-4 text-gray-500" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @if($va->expiry_time)
                                        <div class="flex items-center gap-1.5 mt-3 text-xs text-amber-700">
                                            <i data-lucide="clock" style="width:12px;height:12px;" aria-hidden="true"></i>
                                            <span>Bayar sebelum: <strong>{{ $va->expiry_time->format('d/m/Y H:i') }} WIB</strong></span>
                                        </div>
                                    @endif
                                </div>

                                @if(!empty($instructions))
                                    <div class="mb-4">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ $instructions['title'] }}</p>
                                        <ol class="space-y-1.5">
                                            @foreach($instructions['steps'] as $step)
                                                <li class="text-xs text-gray-600 flex items-start gap-2">
                                                    <span class="w-4 h-4 rounded-full bg-gray-100 flex items-center justify-center shrink-0 mt-0.5">
                                                        <span class="text-[9px] font-medium text-gray-600">{{ $loop->iteration }}</span>
                                                    </span>
                                                    {{ $step }}
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                @endif

                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Total Pembayaran</span>
                                        <span class="text-lg font-heading font-bold text-amber-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i data-lucide="loader" class="w-8 h-8 text-gray-400 mx-auto mb-3 animate-spin" aria-hidden="true"></i>
                                    <p class="text-sm text-gray-500">Memproses Virtual Account...</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="check-circle" class="w-8 h-8 text-emerald-600" aria-hidden="true"></i>
                                </div>
                                <p class="font-heading font-semibold text-emerald-600 text-lg">Pembayaran Berhasil</p>
                                @if($order->transaksi && $order->transaksi->va_number)
                                    <p class="text-xs text-gray-500 mt-2">
                                        VA {{ $order->transaksi->va_number }} · {{ $channels[$order->transaksi->payment_channel]['name'] ?? '' }}
                                    </p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">Pesanan sedang diproses oleh petani.</p>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('orders.index') }}" class="flex items-center justify-center gap-1.5 text-sm text-gray-500 hover:text-gray-600 font-medium transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                        Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
