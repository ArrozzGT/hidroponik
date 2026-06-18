<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    protected $table = 'panen';

    protected $fillable = [
        'product_id',
        'user_id',
        'jumlah_panen_kg',
        'tanggal_panen',
        'kualitas',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_panen' => 'date',
        'jumlah_panen_kg' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
