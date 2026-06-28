<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Transaksi;
use App\Models\LogTransaksi;
use App\Services\NotificationService;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function checkout()
    {
        $carts = Cart::where('user_id', auth()->id())->with('product')->get();
        if ($carts->isEmpty()) return redirect()->route('shop.index');

        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);
        $channels = PaymentGatewayService::getAvailableChannels();
        return view('orders.checkout', compact('carts', 'total', 'channels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'metode_pengiriman' => 'required|in:ambil_ditempat,antar_kurir,ekspedisi',
            'metode_pembayaran' => 'required|in:bca_va,mandiri_va,bri_va,bni_va,permata_va',
            'note' => 'nullable|string',
        ]);

        $carts = Cart::where('user_id', auth()->id())->with('product.user')->get();
        if ($carts->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Keranjang belanja kosong.');
        }

        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

        $discount = 0;
        $coupon = null;
        if ($code = session('coupon_code')) {
            $coupon = Coupon::where('code', $code)->first();
            if ($coupon && $coupon->isValid($total)) {
                $discount = $coupon->calculateDiscount($total);
            }
        }

        return DB::transaction(function() use ($request, $carts, $total, $discount, $coupon) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_price' => $total - $discount,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'metode_pengiriman' => $request->metode_pengiriman,
                'payment_status' => 'unpaid',
                'note' => $request->note,
            ]);

            if ($coupon) {
                $coupon->increment('used_count');
                session()->forget('coupon_code');
            }

            foreach ($carts as $cart) {
                $product = $cart->product;

                $affected = Product::where('id', $product->id)
                    ->where('stock', '>=', $cart->quantity)
                    ->decrement('stock', $cart->quantity);

                if ($affected === 0) {
                    throw new \RuntimeException("Stok {$product->name} tidak mencukupi.");
                }

                $product->refresh();
                if ($product->stock <= 0) {
                    $product->update(['status' => 'habis']);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);
            }

            // Generate Virtual Account
            $vaData = PaymentGatewayService::generateVA($order, $request->metode_pembayaran);

            // Create Transaction Record with VA info
            $transaksi = Transaksi::create(array_merge([
                'order_id' => $order->id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'unpaid',
            ], $vaData));

            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'aksi' => 'order_created',
                'detail_perubahan' => 'Pesanan baru dibuat, menunggu pembayaran',
                'user_id' => auth()->id(),
            ]);

            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'aksi' => 'va_generated',
                'detail_perubahan' => 'Virtual Account ' . $request->metode_pembayaran . ' : ' . $vaData['va_number'],
                'user_id' => auth()->id(),
            ]);

            // Notify petani
            $petaniIds = $carts->pluck('product.user_id')->unique();
            foreach ($petaniIds as $petaniId) {
                $this->notificationService->send(
                    $petaniId,
                    'order',
                    'Pesanan Baru Masuk',
                    'Ada pesanan baru dengan nomor ' . $order->order_number . ' yang berisi produk Anda.',
                    auth()->id()
                );
            }

            // Clear Cart
            Cart::where('user_id', auth()->id())->delete();

            \App\Models\ActivityLog::log('checkout', 'User membuat pesanan baru: ' . $order->order_number);

            return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran via Virtual Account.');
        });
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product', 'transaksi');
        $channel = null;
        $instructions = [];
        $channels = PaymentGatewayService::getAvailableChannels();
        if ($order->transaksi && $order->transaksi->payment_channel) {
            $channel = $order->transaksi->payment_channel;
            $instructions = PaymentGatewayService::getPaymentInstructions($channel);
        }
        return view('orders.show', compact('order', 'channel', 'instructions', 'channels'));
    }

    public function callback(Request $request, Order $order)
    {
        $transaksi = $order->transaksi;
        if (!$transaksi || $transaksi->status_pembayaran !== 'unpaid') {
            return back()->with('error', 'Transaksi tidak valid atau sudah dibayar.');
        }

        PaymentGatewayService::simulateCallback($transaksi);

        LogTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'aksi' => 'payment_confirmed',
            'detail_perubahan' => 'Pembayaran via Virtual Account dikonfirmasi',
            'user_id' => auth()->id(),
        ]);

        \App\Models\ActivityLog::log('callback_payment', 'Pembayaran dikonfirmasi untuk pesanan ' . $order->order_number);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}
