<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'petani']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pembeli']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    }

    public function test_authenticated_user_can_add_to_cart()
    {
        $user = User::factory()->create();
        $user->assignRole('pembeli');
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 50,
            'status' => 'tersedia',
        ]);

        $response = $this->actingAs($user)->post(route('cart.add', $product), [
            'quantity' => 3,
        ]);

        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }

    public function test_cart_quantity_updates_on_readd()
    {
        $user = User::factory()->create();
        $user->assignRole('pembeli');
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 50,
            'status' => 'tersedia',
        ]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->actingAs($user)->post(route('cart.add', $product), [
            'quantity' => 3,
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);
    }

    public function test_guest_cannot_add_to_cart()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 50,
            'status' => 'tersedia',
        ]);

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 1,
        ]);

        $response->assertRedirect(route('login'));
    }
}
