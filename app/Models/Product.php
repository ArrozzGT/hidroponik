<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Enums\ProductStatus;

class Product extends Model
{
    use HasFactory;

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
        'price' => 'decimal:2',
        'stock' => 'integer',
        'status' => ProductStatus::class,
        'tanggal_tanam' => 'date',
        'lama_tanam_hari' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function (self $product) {
            if (empty($product->slug) && !empty($product->name)) {
                $base = Str::slug($product->name);
                $slug = $base;
                $counter = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $counter++;
                }
                $product->slug = $slug;
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
