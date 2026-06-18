<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Panen;
use App\Models\StokNutrisi;
use App\Models\Notifikasi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'total_users' => User::where('role', '!=', 'admin')->count(),
            'total_petani' => User::where('role', 'petani')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_transaksi' => Transaksi::count(),
            'pending_transaksi' => Transaksi::where('status_pembayaran', 'unpaid')->count(),
            'recent_orders' => Order::with('user')->latest()->limit(5)->get(),
        ];

        $pendingPetani = User::where('role', 'petani')
            ->whereHas('petaniProfile', fn($q) => $q->where('status_verifikasi', 'pending'))
            ->with('petaniProfile')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingPetani'));
    }

    public function petani()
    {
        $user = Auth::user();
        $userId = $user->id;

        $revenueTotal = Order::whereHas('items.product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'completed')->sum('total_price');

        $recentOrders = Order::whereHas('items.product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with('user')->latest()->limit(5)->get();

        $avgRating = 0;

        $stats = [
            'my_products' => Product::where('user_id', $userId)->count(),
            'my_sales' => Order::whereHas('items.product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->count(),
            'total_panen' => Panen::where('user_id', $userId)->count(),
            'total_nutrisi' => StokNutrisi::where('user_id', $userId)->count(),
            'low_stok_nutrisi' => StokNutrisi::where('user_id', $userId)->get()->filter(fn($s) => $s->isLowStock())->count(),
            'unread_notifications' => Notifikasi::where('user_id', $userId)->unread()->count(),
            'pending_verifikasi' => $user->petaniProfile->status_verifikasi === 'pending',
        ];
        return view('petani.dashboard', compact('stats', 'revenueTotal', 'recentOrders', 'avgRating'));
    }

    public function pembeli()
    {
        $user = Auth::user();
        $stats = [
            'my_orders' => Order::where('user_id', $user->id)->count(),
            'recent_orders' => Order::where('user_id', $user->id)->latest()->limit(3)->get(),
            'unread_notifications' => Notifikasi::where('user_id', $user->id)->unread()->count(),
        ];
        return view('pembeli.dashboard', compact('stats'));
    }
}
