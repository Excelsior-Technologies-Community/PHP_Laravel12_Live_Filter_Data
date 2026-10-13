<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Livewire\ProductFilter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EnhancedProductFilterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic Category Tree and Brands
        $electronics = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        $laptops = Category::create(['name' => 'Laptops', 'slug' => 'laptops', 'parent_id' => $electronics->id]);

        $apple = Brand::create(['name' => 'Apple', 'slug' => 'apple']);
        $dell = Brand::create(['name' => 'Dell', 'slug' => 'dell']);

        Product::create([
            'name' => 'MacBook Pro 16 M3',
            'description' => 'Fast Apple Silicon chip',
            'price' => 3000.00,
            'original_price' => 3500.00,
            'discount_percent' => 14.28,
            'color' => 'Black',
            'color_code' => '#000000',
            'category_id' => $laptops->id,
            'brand_id' => $apple->id,
            'rating' => 4.9,
            'reviews_count' => 50,
            'stock_quantity' => 10,
            'badge' => 'best_seller',
        ]);

        Product::create([
            'name' => 'Dell XPS 15',
            'description' => 'Windows creator laptop',
            'price' => 2000.00,
            'color' => 'Silver',
            'color_code' => '#CCCCCC',
            'category_id' => $laptops->id,
            'brand_id' => $dell->id,
            'rating' => 4.2,
            'reviews_count' => 20,
            'stock_quantity' => 0, // Out of stock
        ]);
    }

    /**
     * Test page render and Livewire component mounting
     */
    public function test_component_mounts_successfully()
    {
        Livewire::test(ProductFilter::class)
            ->assertStatus(200)
            ->assertSee('MacBook Pro 16 M3')
            ->assertSee('Dell XPS 15')
            ->assertSee('Filters')
            ->assertSee('Color Swatches');
    }

    /**
     * Test Multi-Select Color filtering
     */
    public function test_multi_select_color_filter()
    {
        Livewire::test(ProductFilter::class)
            ->call('toggleColor', 'Black')
            ->assertSee('MacBook Pro 16 M3')
            ->assertDontSee('Dell XPS 15');
    }

    /**
     * Test Brand filtering
     */
    public function test_brand_filtering()
    {
        $apple = Brand::where('slug', 'apple')->first();

        Livewire::test(ProductFilter::class)
            ->call('toggleBrand', $apple->id)
            ->assertSee('MacBook Pro 16 M3')
            ->assertDontSee('Dell XPS 15');
    }

    /**
     * Test In Stock Only toggle
     */
    public function test_in_stock_toggle()
    {
        Livewire::test(ProductFilter::class)
            ->set('inStockOnly', true)
            ->assertSee('MacBook Pro 16 M3')
            ->assertDontSee('Dell XPS 15'); // Dell is stock_quantity = 0
    }

    /**
     * Test Star Ratings filtering
     */
    public function test_star_ratings_filter()
    {
        Livewire::test(ProductFilter::class)
            ->call('setRating', 4.5)
            ->assertSee('MacBook Pro 16 M3') // 4.9 >= 4.5
            ->assertDontSee('Dell XPS 15'); // 4.2 < 4.5
    }

    /**
     * Test Price range filtering
     */
    public function test_price_range_filter()
    {
        Livewire::test(ProductFilter::class)
            ->set('maxPrice', 2500)
            ->assertSee('Dell XPS 15')
            ->assertDontSee('MacBook Pro 16 M3');
    }

    /**
     * Test Quick View modal open and close
     */
    public function test_quick_view_modal()
    {
        $product = Product::first();

        Livewire::test(ProductFilter::class)
            ->call('openQuickView', $product->id)
            ->assertSet('quickViewProductId', $product->id)
            ->assertSee('Selected Color')
            ->call('closeQuickView')
            ->assertSet('quickViewProductId', null);
    }
}
