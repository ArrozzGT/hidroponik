<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'petani']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pembeli']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    }

    public function test_guest_cannot_access_checkout()
    {
        $response = $this->get(route('checkout'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_checkout_with_valid_data()
    {
        $petani = User::factory()->create();
        $petani->assignRole('petani');

        $pembeli = User::factory()->create();
        $pembeli->assignRole('pembeli');

        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'stock' => 100,
            'price' => 10000,
            'status' => 'tersedia',
        ]);

        Cart::create([
            'user_id' => $pembeli->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($pembeli)->post(route('order.store'), [
            'shipping_address' => 'Jl. Test No. 123',
            'metode_pengiriman' => 'ambil_ditempat',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'user_id' => $pembeli->id,
            'shipping_address' => 'Jl. Test No. 123',
        ]);
    }

    public function test_stock_decrements_after_order()
    {
        $petani = User::factory()->create();
        $petani->assignRole('petani');

        $pembeli = User::factory()->create();
        $pembeli->assignRole('pembeli');

        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'stock' => 100,
            'price' => 10000,
            'status' => 'tersedia',
        ]);

        Cart::create([
            'user_id' => $pembeli->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $this->actingAs($pembeli)->post(route('order.store'), [
            'shipping_address' => 'Jl. Test No. 123',
            'metode_pengiriman' => 'ambil_ditempat',
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 95,
        ]);
    }

    public function test_empty_cart_redirects_without_error()
    {
        $user = User::factory()->create();
        $user->assignRole('pembeli');

        $response = $this->actingAs($user)->get(route('checkout'));

        $response->assertRedirect(route('shop.index'));
    }
}
