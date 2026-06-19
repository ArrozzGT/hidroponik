<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'description', 'type', 'value', 'min_purchase', 'max_uses', 'used_count', 'valid_until', 'is_active'];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_until' => 'date',
    ];

    public function isValid($subtotal)
    {
        if (!$this->is_active) return false;
        if ($this->valid_until->isPast()) return false;
        if ($this->max_uses > 0 && $this->used_count >= $this->max_uses) return false;
        if ($subtotal < $this->min_purchase) return false;
        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if ($this->type === 'percentage') {
            return min($subtotal * $this->value / 100, $subtotal);
        }
        return min($this->value, $subtotal);
    }
}
