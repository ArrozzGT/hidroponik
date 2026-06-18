<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())->with('product')->get();
        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);
        
        return view('cart.index', compact('carts', 'total'));
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
