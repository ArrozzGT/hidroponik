<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_slug_auto_generated_on_create()
    {
        $category = Category::create(['name' => 'Sayuran Segar']);

        $this->assertEquals('sayuran-segar', $category->slug);
    }

    public function test_category_slug_not_overwritten_if_manually_set()
    {
        $category = Category::create([
            'name' => 'Sayuran Segar',
            'slug' => 'custom-slug-saya',
        ]);

        $this->assertEquals('custom-slug-saya', $category->slug);
    }
}
