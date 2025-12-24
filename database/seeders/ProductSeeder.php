<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $colors = ['Red', 'Blue', 'Green', 'Black', 'White', 'Yellow'];
        $categories = Category::all();

        for ($i = 1; $i <= 50; $i++) {
            Product::create([
                'name' => 'Product ' . $i,
                'description' => 'Description for product ' . $i,
                'price' => rand(100, 10000) / 100,
                'color' => $colors[array_rand($colors)],
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}