<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get orders that contain products owned by this petani
        $orders = Order::whereHas('items.product', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with([
            'items' => function ($q) use ($userId) {
                $q->whereHas('product', fn($q) => $q->where('user_id', $userId));
            },
            'items.product',
            'user'
        ])
        ->latest()
        ->paginate(15);

        return view('petani.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:processing,shipping',
        ]);

        // Verify the order contains products from this petani
        $hasProduct = $order->items()->whereHas('product', function ($q) {
            $q->where('user_id', auth()->id());
        })->exists();

        if (!$hasProduct) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $validTransitions = [
            'pending' => ['processing'],
            'processing' => ['shipping'],
            'shipping' => [],
            'completed' => [],
            'cancelled' => [],
        ];

        $current = $order->status;
        if (!in_array($request->status, $validTransitions[$current] ?? [])) {
            return back()->with('error', "Tidak dapat mengubah status dari '$current' ke '{$request->status}'.");
        }

        $order->update(['status' => $request->status]);

        \App\Models\ActivityLog::log(
            'update_order_status',
            'Petani mengubah status pesanan #' . $order->order_number . ' menjadi ' . $request->status
        );

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
