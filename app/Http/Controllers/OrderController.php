<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\LogTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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
        return view('orders.checkout', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $carts = Cart::where('user_id', auth()->id())->with('product')->get();
        if ($carts->isEmpty()) return redirect()->route('shop.index');

        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

        return DB::transaction(function() use ($request, $carts, $total) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'payment_status' => 'unpaid',
                'note' => $request->note,
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);

                // Reduce stock
                $cart->product->decrement('stock', $cart->quantity);
                if ($cart->product->stock <= 0) {
                    $cart->product->update(['status' => 'habis']);
                }
            }

            // Create Transaction Record
            $transaksi = Transaksi::create([
                'order_id' => $order->id,
                'status_pembayaran' => 'unpaid',
            ]);

            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'aksi' => 'order_created',
                'detail_perubahan' => 'Pesanan baru dibuat, menunggu pembayaran',
                'user_id' => auth()->id(),
            ]);

            // Clear Cart
            Cart::where('user_id', auth()->id())->delete();

            \App\Models\ActivityLog::log('checkout', 'User membuat pesanan baru: ' . $order->order_number);

            return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
        });
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function uploadPayment(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');
        $order->update([
            'payment_proof' => $path,
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        // Update transaksi
        $transaksi = Transaksi::where('order_id', $order->id)->first();
        if ($transaksi) {
            $transaksi->update([
                'status_pembayaran' => 'paid',
                'bukti_pembayaran' => $path,
            ]);
            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'aksi' => 'payment_uploaded',
                'detail_perubahan' => 'Pembeli upload bukti pembayaran',
                'user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}
