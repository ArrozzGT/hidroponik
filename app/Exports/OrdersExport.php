<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Order::with('user');
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Order #',
            'Pembeli',
            'Total Harga',
            'Status',
            'Pembayaran',
            'Tanggal',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->user->name,
            $order->total_price,
            $order->status,
            $order->payment_status,
            $order->created_at->format('d/m/Y H:i'),
        ];
    }
}
