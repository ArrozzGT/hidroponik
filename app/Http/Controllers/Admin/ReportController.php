<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Laporan;
use App\Exports\OrdersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with('user')->latest()->paginate(10);
        return view('admin.reports.index', compact('laporan'));
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $fileName = 'laporan-transaksi-' . now()->format('Ymd-His') . '.xlsx';

        Laporan::create([
            'jenis_laporan' => 'excel',
            'periode_awal' => $request->start_date,
            'periode_akhir' => $request->end_date,
            'file_path' => $fileName,
            'user_id' => auth()->id(),
        ]);

        return Excel::download(new OrdersExport($request->start_date, $request->end_date), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = Order::with(['user', 'items.product']);
        
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $orders = $query->latest()->get();
        $total_revenue = $orders->sum('total_price');

        $fileName = 'laporan-transaksi-' . now()->format('Ymd-His') . '.pdf';

        Laporan::create([
            'jenis_laporan' => 'pdf',
            'periode_awal' => $request->start_date,
            'periode_akhir' => $request->end_date,
            'file_path' => $fileName,
            'user_id' => auth()->id(),
        ]);

        $pdf = Pdf::loadView('admin.reports.pdf', compact('orders', 'total_revenue'));
        return $pdf->download($fileName);
    }
}
