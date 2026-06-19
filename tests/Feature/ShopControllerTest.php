<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'petani']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pembeli']);
    }

    public function test_guest_can_view_shop_index()
    {
        $response = $this->get(route('shop.index'));

        $response->assertStatus(200);
    }

    public function test_guest_can_view_product_detail()
    {
        $category = Category::factory()->create();
        $petani = User::factory()->create(['status' => 'aktif']);
        $petani->assignRole('petani');

        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'status' => 'tersedia',
        ]);

        $response = $this->get(route('shop.show', $product));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_search_filter_works()
    {
        $category = Category::factory()->create();
        $petani = User::factory()->create(['status' => 'aktif']);
        $petani->assignRole('petani');

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Selada Hijau Unik',
            'status' => 'tersedia',
        ]);

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Kangkung Biasa',
            'status' => 'tersedia',
        ]);

        $response = $this->get(route('shop.index', ['search' => 'Selada']));

        $response->assertStatus(200);
        $response->assertSee('Selada Hijau Unik');
        $response->assertDontSee('Kangkung Biasa');
    }

    public function test_category_filter_works()
    {
        $category1 = Category::create(['name' => 'Sayuran Daun', 'slug' => 'sayuran-daun']);
        $category2 = Category::create(['name' => 'Sayuran Buah', 'slug' => 'sayuran-buah']);
        $petani = User::factory()->create(['status' => 'aktif']);
        $petani->assignRole('petani');

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category1->id,
            'name' => 'Produk Daun Hijau',
            'status' => 'tersedia',
        ]);

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category2->id,
            'name' => 'Tomat Segar',
            'status' => 'tersedia',
        ]);

        $response = $this->get(route('shop.index', ['category' => 'sayuran-daun']));

        $response->assertStatus(200);
        $response->assertSee('Produk Daun Hijau');
        $response->assertDontSee('Tomat Segar');
    }

    public function test_sort_by_terbaru()
    {
        $category = Category::factory()->create();
        $petani = User::factory()->create(['status' => 'aktif']);
        $petani->assignRole('petani');

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Produk Pertama',
            'status' => 'tersedia',
            'created_at' => now()->subDays(2),
        ]);

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Produk Terbaru',
            'status' => 'tersedia',
            'created_at' => now(),
        ]);

        $response = $this->get(route('shop.index', ['sort' => 'terbaru']));

        $response->assertStatus(200);
    }

    public function test_sort_by_termurah()
    {
        $category = Category::factory()->create();
        $petani = User::factory()->create(['status' => 'aktif']);
        $petani->assignRole('petani');

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Produk Mahal',
            'price' => 50000,
            'status' => 'tersedia',
        ]);

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Produk Murah',
            'price' => 5000,
            'status' => 'tersedia',
        ]);

        $response = $this->get(route('shop.index', ['sort' => 'termurah']));

        $response->assertStatus(200);
    }

    public function test_sort_by_stok()
    {
        $category = Category::factory()->create();
        $petani = User::factory()->create(['status' => 'aktif']);
        $petani->assignRole('petani');

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Stok Banyak',
            'stock' => 100,
            'status' => 'tersedia',
        ]);

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Stok Sedikit',
            'stock' => 10,
            'status' => 'tersedia',
        ]);

        $response = $this->get(route('shop.index', ['sort' => 'stok']));

        $response->assertStatus(200);
    }

    public function test_suggestions_returns_json_for_valid_search()
    {
        $category = Category::factory()->create();
        $petani = User::factory()->create(['status' => 'aktif']);
        $petani->assignRole('petani');

        Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'name' => 'Kangkung Segar',
            'status' => 'tersedia',
        ]);

        $response = $this->getJson(route('api.products.search', ['q' => 'Kangkung']));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Kangkung Segar']);
    }

    public function test_suggestions_returns_empty_for_no_match()
    {
        $response = $this->getJson(route('api.products.search', ['q' => 'xyzabc123nonexistent']));

        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
