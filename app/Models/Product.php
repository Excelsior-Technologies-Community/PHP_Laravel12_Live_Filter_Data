<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'discount_percent',
        'color',
        'color_code',
        'category_id',
        'brand_id',
        'rating',
        'reviews_count',
        'stock_quantity',
        'badge',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'rating' => 'decimal:2',
        'reviews_count' => 'integer',
        'stock_quantity' => 'integer',
    ];

    protected $appends = [
        'is_in_stock',
        'has_discount',
        'image_url',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_percent > 0 && $this->original_price > $this->price;
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        $nameInitial = strtoupper(substr($this->name ?? 'P', 0, 1));
        return "https://ui-avatars.com/api/?name=" . urlencode($nameInitial) . "&background=4F46E5&color=fff&size=300";
    }
}