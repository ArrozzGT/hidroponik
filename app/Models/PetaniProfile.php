<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetaniProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nama_kebun',
        'lokasi_kebun',
        'deskripsi_kebun',
        'status_verifikasi',
        'alasan_reject',
        'verified_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
