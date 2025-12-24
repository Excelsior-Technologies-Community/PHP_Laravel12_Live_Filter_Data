<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class ProductFilter extends Component
{
    public $selectedColor = '';
    public $selectedCategory = '';
    public $search = '';

    // Remove the layout property or comment it out
    // public $layout = 'components.layouts.app'; // Remove this line

    public function render()
    {
        $query = Product::with('category');

        // Apply color filter
        if ($this->selectedColor) {
            $query->where('color', $this->selectedColor);
        }

        // Apply category filter
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $products = $query->latest()->get();
        
        // Get unique colors for dropdown
        $colors = Product::select('color')->distinct()->pluck('color');
        $categories = Category::all();

        return view('livewire.product-filter', [
            'products' => $products,
            'colors' => $colors,
            'categories' => $categories,
        ]);
    }

    // Reset all filters
    public function resetFilters()
    {
        $this->reset(['selectedColor', 'selectedCategory', 'search']);
    }
}