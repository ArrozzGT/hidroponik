<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Enums\ProductStatus;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'unit',
        'image',
        'status',
        'lama_tanam_hari',
        'tanggal_tanam',
    ];

    protected $casts = [
        'price'  => 'decimal:2',
        'status' => ProductStatus::class,
        'tanggal_tanam' => 'date',
    ];

    /** Auto‑generate slug on creation */
    protected static function booted()
    {
        static::creating(function (self $product) {
            if (empty($product->slug) && !empty($product->name)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function panen()
    {
        return $this->hasMany(Panen::class);
    }
}
