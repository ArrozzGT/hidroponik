<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\LogTransaksi;
use App\Models\ActivityLog;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['order.user', 'confirmedBy'])->latest()->paginate(15);
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['order.user', 'order.items.product', 'confirmedBy', 'logs.user']);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function confirm(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:paid,failed',
        ]);

        $oldStatus = $transaksi->status_pembayaran;

        if ($request->status_pembayaran === 'paid') {
            PaymentGatewayService::simulateCallback($transaksi);
        } else {
            $transaksi->update([
                'status_pembayaran' => 'failed',
                'tanggal_konfirmasi' => now(),
                'confirmed_by' => auth()->id(),
            ]);
        }

        LogTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'aksi' => 'confirm_payment',
            'detail_perubahan' => "Status pembayaran: {$oldStatus} → {$request->status_pembayaran}",
            'user_id' => auth()->id(),
        ]);

        ActivityLog::log('confirm_transaksi', "Admin konfirmasi pembayaran #{$transaksi->order->order_number}");

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}
