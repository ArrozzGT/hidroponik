<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Panen;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanenControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'petani']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pembeli']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    }

    public function test_petani_can_log_harvest_for_their_own_product()
    {
        $petani = User::factory()->create();
        $petani->assignRole('petani');
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'status' => 'tersedia',
        ]);

        $response = $this->actingAs($petani)->post(route('petani.panen.store'), [
            'product_id' => $product->id,
            'jumlah_panen_kg' => 5.5,
            'tanggal_panen' => now()->format('Y-m-d'),
            'kualitas' => 'A',
            'keterangan' => 'Panen rutin mingguan',
        ]);

        $response->assertRedirect(route('petani.panen.index'));
        $this->assertDatabaseHas('panen', [
            'product_id' => $product->id,
            'user_id' => $petani->id,
            'jumlah_panen_kg' => 5.5,
        ]);
    }

    public function test_petani_cannot_log_harvest_for_another_petani_product()
    {
        $petani1 = User::factory()->create();
        $petani1->assignRole('petani');

        $petani2 = User::factory()->create();
        $petani2->assignRole('petani');

        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $petani1->id,
            'category_id' => $category->id,
            'status' => 'tersedia',
        ]);

        $response = $this->actingAs($petani2)->post(route('petani.panen.store'), [
            'product_id' => $product->id,
            'jumlah_panen_kg' => 3.0,
            'tanggal_panen' => now()->format('Y-m-d'),
            'kualitas' => 'B',
        ]);

        $response->assertSessionHasErrors('product_id');
        $this->assertDatabaseCount('panen', 0);
    }

    public function test_petani_can_view_their_own_panen_records()
    {
        $petani = User::factory()->create();
        $petani->assignRole('petani');
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'category_id' => $category->id,
            'status' => 'tersedia',
        ]);

        Panen::factory()->create([
            'product_id' => $product->id,
            'user_id' => $petani->id,
        ]);

        $response = $this->actingAs($petani)->get(route('petani.panen.index'));

        $response->assertStatus(200);
    }
}
