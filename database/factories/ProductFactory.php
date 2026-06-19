<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(5000, 50000),
            'stock' => fake()->numberBetween(10, 100),
            'unit' => 'gram',
            'status' => 'tersedia',
        ];
    }
}
