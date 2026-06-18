<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokNutrisi extends Model
{
    protected $table = 'stok_nutrisi';

    protected $fillable = [
        'user_id',
        'nama_nutrisi',
        'stok_tersedia_liter',
        'stok_minimum_liter',
    ];

    protected $casts = [
        'stok_tersedia_liter' => 'decimal:2',
        'stok_minimum_liter' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isLowStock(): bool
    {
        return $this->stok_tersedia_liter <= $this->stok_minimum_liter;
    }
}
