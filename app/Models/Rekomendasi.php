<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    protected $table = 'rekomendasi';

    protected $fillable = [
        'user_id',
        'jenis_rekomendasi',
        'deskripsi',
        'status_diterapkan',
    ];

    protected $casts = [
        'status_diterapkan' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
