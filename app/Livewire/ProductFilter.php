<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ProductFilter extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Filters
    public $selectedColor = '';
    public $selectedCategory = '';
    public $search = '';
    public $sortBy = 'latest';

    // Reset pagination whenever filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedColor()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    // Reset all filters
    public function resetFilters()
    {
        $this->reset([
            'selectedColor',
            'selectedCategory',
            'search',
            'sortBy'
        ]);

        $this->sortBy = 'latest';

        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with('category');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (!empty($this->search)) {
            $query->where(function ($q) {

                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');

                // Search by price
                if (is_numeric($this->search)) {
                    $q->orWhere('price', $this->search);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Color Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($this->selectedColor)) {
            $query->where('color', $this->selectedColor);
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($this->selectedCategory)) {
            $query->where('category_id', $this->selectedCategory);
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($this->sortBy) {

            case 'oldest':
                $query->oldest();
                break;

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            default:
                $query->latest();
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $products = $query->paginate(9);

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $totalCategories = Category::count();

        $averagePrice = Product::avg('price');

        $latestProduct = Product::latest()->first();

        /*
        |--------------------------------------------------------------------------
        | Filters Data
        |--------------------------------------------------------------------------
        */

        $colors = Product::select('color')
            ->distinct()
            ->orderBy('color')
            ->pluck('color');

        $categories = Category::orderBy('name')->get();

        return view('livewire.product-filter', [

            'products' => $products,

            'colors' => $colors,

            'categories' => $categories,

            'totalProducts' => $totalProducts,

            'totalCategories' => $totalCategories,

            'averagePrice' => $averagePrice,

            'latestProduct' => $latestProduct,

        ]);
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();

        session()->flash('success', 'Product deleted successfully.');
    }
}