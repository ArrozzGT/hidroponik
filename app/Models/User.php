<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'alamat',
        'foto',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function petaniProfile()
    {
        return $this->hasOne(PetaniProfile::class);
    }

    public function pembeliProfile()
    {
        return $this->hasOne(PembeliProfile::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function panen()
    {
        return $this->hasMany(Panen::class);
    }

    public function stokNutrisi()
    {
        return $this->hasMany(StokNutrisi::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function rekomendasi()
    {
        return $this->hasMany(Rekomendasi::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isPetani(): bool
    {
        return $this->hasRole('petani');
    }

    public function isPembeli(): bool
    {
        return $this->hasRole('pembeli');
    }

    public function getRoleLabelAttribute(): string
    {
        if ($this->isAdmin()) return 'Admin';
        if ($this->isPetani()) return 'Petani';
        if ($this->isPembeli()) return 'Pembeli';
        return 'Pengguna';
    }
}
