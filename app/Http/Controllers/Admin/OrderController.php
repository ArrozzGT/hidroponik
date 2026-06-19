<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled',
        ]);

        $validTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['shipping', 'cancelled'],
            'shipping' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
        ];

        $current = $order->status;
        if (!in_array($request->status, $validTransitions[$current] ?? [])) {
            return back()->with('error', "Tidak dapat mengubah status dari '$current' ke '{$request->status}'.");
        }

        $order->update(['status' => $request->status]);

        \App\Models\ActivityLog::log('update_order_status', 'Admin mengubah status pesanan ' . $order->order_number . ' menjadi ' . $request->status);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}