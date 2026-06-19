<?php

namespace Database\Factories;

use App\Models\Panen;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PanenFactory extends Factory
{
    protected $model = Panen::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'jumlah_panen_kg' => fake()->randomFloat(2, 0.5, 50),
            'tanggal_panen' => now()->subDays(rand(1, 30)),
            'kualitas' => fake()->randomElement(['A', 'B', 'C']),
            'keterangan' => fake()->sentence(),
        ];
    }
}
