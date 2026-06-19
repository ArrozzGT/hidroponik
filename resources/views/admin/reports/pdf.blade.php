<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi SIPSH</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #111827; }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #059669; }
        .header h2 { color: #065f46; margin-bottom: 4px; font-size: 18px; }
        .header p { color: #6b7280; font-size: 11px; }
        .logo { width: 50px; height: 50px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #059669; color: #fff; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) td { background: #f9fafb; }
        .total { margin-top: 20px; text-align: right; font-weight: bold; font-size: 14px; color: #059669; padding-top: 15px; border-top: 2px solid #059669; }
        .footer { text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 9px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Transaksi Penjualan Sayuran Hidroponik (SIPSH)</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order #</th>
                <th>Pembeli</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Pendapatan: Rp {{ number_format($total_revenue, 0, ',', '.') }}
    </div>

    <div class="footer">
        Sistem Informasi Pertanian Sayuran Hidroponik (SIPSH) — {{ date('Y') }}
    </div>
</body>
</html>
