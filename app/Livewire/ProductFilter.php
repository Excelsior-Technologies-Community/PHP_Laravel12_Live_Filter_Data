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

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    public $selectedColor = '';
    public $selectedCategory = '';
    public $search = '';
    public $sortBy = 'latest';

    // NEW
    public $minPrice = '';
    public $maxPrice = '';

    // Grid or List
    public $viewType = 'grid';

    /*
    |--------------------------------------------------------------------------
    | Reset pagination when filters change
    |--------------------------------------------------------------------------
    */

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

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | View Toggle
    |--------------------------------------------------------------------------
    */

    public function setView($view)
    {
        $this->viewType = $view;
    }

    /*
    |--------------------------------------------------------------------------
    | Reset Filters
    |--------------------------------------------------------------------------
    */

    public function resetFilters()
    {
        $this->reset([
            'selectedColor',
            'selectedCategory',
            'search',
            'sortBy',
            'minPrice',
            'maxPrice',
        ]);

        $this->sortBy = 'latest';
        $this->viewType = 'grid';

        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

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
        | NEW Price Range Filter
        |--------------------------------------------------------------------------
        */

        if ($this->minPrice !== '' && is_numeric($this->minPrice)) {
            $query->where('price', '>=', $this->minPrice);
        }

        if ($this->maxPrice !== '' && is_numeric($this->maxPrice)) {
            $query->where('price', '<=', $this->maxPrice);
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
        | Dashboard
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $totalCategories = Category::count();

        $averagePrice = Product::avg('price');

        $latestProduct = Product::latest()->first();

        /*
        |--------------------------------------------------------------------------
        | Filter Data
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

            'viewType' => $this->viewType,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Product
    |--------------------------------------------------------------------------
    */

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();

        session()->flash('success', 'Product deleted successfully.');
    }
}