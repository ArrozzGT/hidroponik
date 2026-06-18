<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTransaksi extends Model
{
    protected $table = 'log_transaksi';

    protected $fillable = [
        'transaksi_id',
        'aksi',
        'detail_perubahan',
        'user_id',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
