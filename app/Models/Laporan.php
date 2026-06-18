<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'jenis_laporan',
        'periode_awal',
        'periode_akhir',
        'file_path',
        'user_id',
    ];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
