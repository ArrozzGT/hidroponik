<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())->with('product')->get();
        $total = $carts->sum(fn($c) => ($c->product?->price ?? 0) * $c->quantity);

        $coupon = null;
        $discount = 0;
        if ($code = session('coupon_code')) {
            $coupon = Coupon::where('code', $code)->first();
            if ($coupon && $coupon->isValid($total)) {
                $discount = $coupon->calculateDiscount($total);
            } else {
                session()->forget('coupon_code');
                $coupon = null;
            }
        }
        
        return view('cart.index', compact('carts', 'total', 'coupon', 'discount'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string|max:50']);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return back()->with('error', 'Kode kupon tidak ditemukan.');
        }

        $subtotal = Cart::where('user_id', auth()->id())->with('product')->get()
            ->sum(fn($c) => ($c->product?->price ?? 0) * $c->quantity);

        if (!$coupon->isValid($subtotal)) {
            return back()->with('error', 'Kupon tidak dapat digunakan. Periksa kembali syarat & ketentuan.');
        }

        session(['coupon_code' => $coupon->code]);
        return back()->with('success', "Kupon {$coupon->code} berhasil diterapkan!");
    }

    public function removeCoupon()
    {
        session()->forget('coupon_code');
        return back()->with('success', 'Kupon berhasil dihapus.');
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:' . $product->stock]);

        $cart = Cart::where('user_id', auth()->id())->where('product_id', $product->id)->first();

        if ($cart) {
            $newQty = $cart->quantity + $request->quantity;
            if ($newQty > $product->stock) $newQty = $product->stock;
            $cart->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);
        
        $request->validate(['quantity' => 'required|integer|min:1|max:' . $cart->product->stock]);
        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);
        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
