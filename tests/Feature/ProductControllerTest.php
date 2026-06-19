<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'petani']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pembeli']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    }

    public function test_petani_can_create_product()
    {
        $petani = User::factory()->create();
        $petani->assignRole('petani');
        $category = Category::factory()->create();

        $response = $this->actingAs($petani)->post(route('petani.products.store'), [
            'category_id' => $category->id,
            'name' => 'Selada Baru',
            'description' => 'Selada segar hasil panen',
            'price' => 10000,
            'stock' => 50,
            'unit' => 'gram',
        ]);

        $response->assertRedirect(route('petani.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Selada Baru',
            'user_id' => $petani->id,
        ]);
    }

    public function test_petani_can_update_their_own_product()
    {
        $petani = User::factory()->create();
        $petani->assignRole('petani');
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($petani)->put(route('petani.products.update', $product), [
            'category_id' => $category->id,
            'name' => 'Nama Diubah',
            'description' => 'Deskripsi baru',
            'price' => 15000,
            'stock' => 30,
            'unit' => 'gram',
        ]);

        $response->assertRedirect(route('petani.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Nama Diubah',
        ]);
    }

    public function test_petani_cannot_update_another_petani_product()
    {
        $category = Category::factory()->create();

        $petani1 = User::factory()->create();
        $petani1->assignRole('petani');

        $petani2 = User::factory()->create();
        $petani2->assignRole('petani');

        $product = Product::factory()->create([
            'user_id' => $petani1->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($petani2)->put(route('petani.products.update', $product), [
            'category_id' => $category->id,
            'name' => 'Dicoba Ubah',
            'description' => 'test',
            'price' => 10000,
            'stock' => 10,
            'unit' => 'gram',
        ]);

        $response->assertStatus(403);
    }

    public function test_mass_assignment_protection_cannot_set_user_id_via_update()
    {
        $category = Category::factory()->create();

        $petani1 = User::factory()->create();
        $petani1->assignRole('petani');

        $petani2 = User::factory()->create();
        $petani2->assignRole('petani');

        $product = Product::factory()->create([
            'user_id' => $petani1->id,
            'category_id' => $category->id,
        ]);

        $this->actingAs($petani1)->put(route('petani.products.update', $product), [
            'category_id' => $category->id,
            'name' => 'Tetap Milik Petani1',
            'description' => 'test',
            'price' => 10000,
            'stock' => 10,
            'unit' => 'gram',
            'user_id' => $petani2->id,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'user_id' => $petani1->id,
        ]);
    }

    public function test_product_slug_auto_generated_on_create()
    {
        $petani = User::factory()->create();
        $petani->assignRole('petani');
        $category = Category::factory()->create();

        $this->actingAs($petani)->post(route('petani.products.store'), [
            'category_id' => $category->id,
            'name' => 'Produk Slug Test',
            'description' => 'test',
            'price' => 10000,
            'stock' => 10,
            'unit' => 'gram',
        ]);

        $product = Product::where('name', 'Produk Slug Test')->first();

        $this->assertNotNull($product);
        $this->assertStringContainsString('produk-slug-test', $product->slug);
    }
}
