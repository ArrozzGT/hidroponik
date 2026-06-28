<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaksi;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    const CHANNELS = [
        'bca_va' => ['name' => 'BCA Virtual Account', 'bank' => 'BCA'],
        'mandiri_va' => ['name' => 'Mandiri Virtual Account', 'bank' => 'Mandiri'],
        'bri_va' => ['name' => 'BRI Virtual Account', 'bank' => 'BRI'],
        'bni_va' => ['name' => 'BNI Virtual Account', 'bank' => 'BNI'],
        'permata_va' => ['name' => 'Permata Virtual Account', 'bank' => 'Permata'],
    ];

    public static function getAvailableChannels(): array
    {
        return self::CHANNELS;
    }

    public static function generateVA(Order $order, string $channel): array
    {
        $orderId = str_pad($order->id, 8, '0', STR_PAD_LEFT);
        $prefix = match ($channel) {
            'bca_va' => '8',
            'mandiri_va' => '9',
            'bri_va' => '6',
            'bni_va' => '7',
            'permata_va' => '5',
            default => '0',
        };

        $vaNumber = $prefix . $orderId . strtoupper(Str::random(4));
        $transactionId = 'VA-' . strtoupper(Str::random(12));
        $expiryTime = now()->addHours(24);

        $paymentDetails = [
            'channel' => $channel,
            'bank' => self::CHANNELS[$channel]['bank'] ?? 'Unknown',
            'amount' => $order->total_price,
            'created_at' => now()->toIso8601String(),
            'expires_at' => $expiryTime->toIso8601String(),
        ];

        if ($channel === 'mandiri_va') {
            $paymentDetails['bill_key'] = '911' . $orderId;
            $paymentDetails['biller_code'] = '700' . $orderId;
        }

        $data = [
            'payment_channel' => $channel,
            'va_number' => $vaNumber,
            'transaction_id' => $transactionId,
            'expiry_time' => $expiryTime,
            'payment_details' => $paymentDetails,
        ];

        if ($channel === 'mandiri_va') {
            $data['bill_key'] = $paymentDetails['bill_key'];
            $data['biller_code'] = $paymentDetails['biller_code'];
        }

        return $data;
    }

    public static function getPaymentInstructions(string $channel): array
    {
        $common = [
            '1. Buka aplikasi mobile banking' . ' ' . (self::CHANNELS[$channel]['bank'] ?? 'bank Anda') . '.',
            '2. Pilih menu "Virtual Account" atau "Pembayaran".',
            '3. Masukkan nomor Virtual Account yang tertera di atas.',
            '4. Periksa detail pembayaran dan nominal yang harus dibayar.',
            '5. Konfirmasi pembayaran.',
            '6. Simpan bukti pembayaran untuk referensi.',
        ];

        return [
            'title' => 'Cara Pembayaran ' . (self::CHANNELS[$channel]['name'] ?? 'Virtual Account'),
            'steps' => $common,
        ];
    }

    public static function simulateCallback(Transaksi $transaksi): Transaksi
    {
        $transaksi->update([
            'status_pembayaran' => 'paid',
            'tanggal_konfirmasi' => now(),
        ]);

        if ($transaksi->order) {
            $transaksi->order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);
        }

        return $transaksi->fresh();
    }
}
