<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductFilter;

Route::get('/', function () {
    return view('welcome');
});

// Option 1: Use Livewire component directly
Route::get('/products', ProductFilter::class);

// Option 2: Or wrap it in a view (recommended)
Route::get('/products-view', function () {
    return view('products');
});