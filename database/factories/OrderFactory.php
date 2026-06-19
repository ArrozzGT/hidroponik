<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_price' => fake()->numberBetween(10000, 100000),
            'status' => 'pending',
            'shipping_address' => fake()->address(),
            'payment_status' => 'unpaid',
        ];
    }
}
