<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductFilter extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    /*
    |--------------------------------------------------------------------------
    | Filters with URL Synchronisation
    |--------------------------------------------------------------------------
    */
    #[Url]
    public $search = '';

    #[Url]
    public array $selectedColors = [];

    #[Url]
    public array $selectedCategories = [];

    #[Url]
    public array $selectedBrands = [];

    #[Url]
    public $minPrice = '';

    #[Url]
    public $maxPrice = '';

    #[Url]
    public $minRating = ''; // e.g. 4 for 4+ stars

    #[Url]
    public bool $inStockOnly = false;

    #[Url]
    public bool $onSaleOnly = false;

    #[Url]
    public $selectedBadge = ''; // 'best_seller', 'limited_deal', 'new_arrival'

    #[Url]
    public $sortBy = 'latest';

    #[Url]
    public $perPage = 9;

    #[Url]
    public $viewType = 'grid';

    // Quick View Modal State
    public ?int $quickViewProductId = null;
    public $quickViewProduct = null;

    /*
    |--------------------------------------------------------------------------
    | Reset Pagination when any filter property changes
    |--------------------------------------------------------------------------
    */
    public function updated($property)
    {
        if (in_array($property, [
            'search', 'selectedColors', 'selectedCategories', 'selectedBrands',
            'minPrice', 'maxPrice', 'minRating', 'inStockOnly', 'onSaleOnly',
            'selectedBadge', 'sortBy', 'perPage'
        ])) {
            $this->resetPage();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Helpers for Color, Category & Brand Checkboxes
    |--------------------------------------------------------------------------
    */
    public function toggleColor(string $color)
    {
        if (in_array($color, $this->selectedColors)) {
            $this->selectedColors = array_values(array_diff($this->selectedColors, [$color]));
        } else {
            $this->selectedColors[] = $color;
        }
        $this->resetPage();
    }

    public function toggleCategory(int $catId)
    {
        if (in_array($catId, $this->selectedCategories)) {
            $this->selectedCategories = array_values(array_diff($this->selectedCategories, [$catId]));
        } else {
            $this->selectedCategories[] = $catId;
        }
        $this->resetPage();
    }

    public function toggleBrand(int $brandId)
    {
        if (in_array($brandId, $this->selectedBrands)) {
            $this->selectedBrands = array_values(array_diff($this->selectedBrands, [$brandId]));
        } else {
            $this->selectedBrands[] = $brandId;
        }
        $this->resetPage();
    }

    public function setRating($rating)
    {
        $this->minRating = ($this->minRating == $rating) ? '' : $rating;
        $this->resetPage();
    }

    public function setBadge($badge)
    {
        $this->selectedBadge = ($this->selectedBadge === $badge) ? '' : $badge;
        $this->resetPage();
    }

    public function setView($view)
    {
        $this->viewType = $view;
    }

    /*
    |--------------------------------------------------------------------------
    | Reset All Filters
    |--------------------------------------------------------------------------
    */
    public function resetFilters()
    {
        $this->reset([
            'search',
            'selectedColors',
            'selectedCategories',
            'selectedBrands',
            'minPrice',
            'maxPrice',
            'minRating',
            'inStockOnly',
            'onSaleOnly',
            'selectedBadge',
            'sortBy',
        ]);

        $this->sortBy = 'latest';
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Quick View Modal Actions
    |--------------------------------------------------------------------------
    */
    public function openQuickView($productId)
    {
        $this->quickViewProductId = $productId;
        $this->quickViewProduct = Product::with(['category', 'brand'])->find($productId);
    }

    public function closeQuickView()
    {
        $this->quickViewProductId = null;
        $this->quickViewProduct = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Render Method with Dynamic Counting & Multi-Filter Query
    |--------------------------------------------------------------------------
    */
    public function render()
    {
        $query = Product::with(['category', 'brand']);

        // 1. Keyword Search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');

                if (is_numeric($this->search)) {
                    $q->orWhere('price', $this->search);
                }
            });
        }

        // 2. Multi-Select Colors
        if (!empty($this->selectedColors)) {
            $query->whereIn('color', $this->selectedColors);
        }

        // 3. Multi-Select Categories (Including parent category child expansion)
        if (!empty($this->selectedCategories)) {
            // Find any child category ids if a parent category is selected
            $allCategoryIds = Category::whereIn('id', $this->selectedCategories)
                ->orWhereIn('parent_id', $this->selectedCategories)
                ->pluck('id')
                ->toArray();

            $query->whereIn('category_id', $allCategoryIds);
        }

        // 4. Multi-Select Brands
        if (!empty($this->selectedBrands)) {
            $query->whereIn('brand_id', $this->selectedBrands);
        }

        // 5. Price Range
        if ($this->minPrice !== '' && is_numeric($this->minPrice)) {
            $query->where('price', '>=', (float) $this->minPrice);
        }
        if ($this->maxPrice !== '' && is_numeric($this->maxPrice)) {
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        // 6. Star Ratings
        if ($this->minRating !== '' && is_numeric($this->minRating)) {
            $query->where('rating', '>=', (float) $this->minRating);
        }

        // 7. Stock Availability
        if ($this->inStockOnly) {
            $query->where('stock_quantity', '>', 0);
        }

        // 8. On Sale / Discount
        if ($this->onSaleOnly) {
            $query->where('discount_percent', '>', 0);
        }

        // 9. Badges
        if (!empty($this->selectedBadge)) {
            $query->where('badge', $this->selectedBadge);
        }

        // 10. Sorting
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
            case 'rating_high':
                $query->orderBy('rating', 'desc');
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

        // Pagination
        $perPageCount = in_array((int)$this->perPage, [9, 18, 36, 100]) ? (int)$this->perPage : 9;
        $products = $query->paginate($perPageCount);

        // Dashboard Statistics
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $averagePrice = Product::avg('price') ?? 0;
        $inStockCount = Product::where('stock_quantity', '>', 0)->count();

        // Distinct Colors with Live Counts
        $colorsList = Product::select('color', 'color_code')
            ->selectRaw('count(*) as count')
            ->groupBy('color', 'color_code')
            ->orderBy('color')
            ->get();

        // Category Tree with Live Counts (Hierarchical)
        $parentCategories = Category::whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->withCount('products');
            }])
            ->withCount('products')
            ->orderBy('name')
            ->get();

        // Brands with Live Counts
        $brandsList = Brand::withCount('products')->orderBy('name')->get();

        // Global min/max price for the slider
        $dbMinPrice = (int) floor(Product::min('price') ?? 0);
        $dbMaxPrice = (int) ceil(Product::max('price') ?? 5000);

        return view('livewire.product-filter', [
            'products' => $products,
            'colorsList' => $colorsList,
            'parentCategories' => $parentCategories,
            'brandsList' => $brandsList,
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'averagePrice' => $averagePrice,
            'inStockCount' => $inStockCount,
            'dbMinPrice' => $dbMinPrice,
            'dbMaxPrice' => $dbMaxPrice,
        ]);
    }
}