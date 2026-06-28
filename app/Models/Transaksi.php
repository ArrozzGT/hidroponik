<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'order_id',
        'metode_pembayaran',
        'status_pembayaran',
        'payment_channel',
        'va_number',
        'bill_key',
        'biller_code',
        'transaction_id',
        'expiry_time',
        'payment_details',
        'bukti_pembayaran',
        'tanggal_konfirmasi',
        'confirmed_by',
    ];

    protected $casts = [
        'tanggal_konfirmasi' => 'datetime',
        'expiry_time' => 'datetime',
        'payment_details' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function logs()
    {
        return $this->hasMany(LogTransaksi::class, 'transaksi_id');
    }
}
