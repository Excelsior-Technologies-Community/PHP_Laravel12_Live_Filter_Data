<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductFilter;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Livewire Product Filter
|--------------------------------------------------------------------------
*/

Route::get('/products', ProductFilter::class)
    ->name('products');

/*
|--------------------------------------------------------------------------
| Product View (Optional)
|--------------------------------------------------------------------------
*/

Route::get('/products-view', function () {
    return view('products');
})->name('products.view');


/*
|--------------------------------------------------------------------------
| Product CSV Export
|--------------------------------------------------------------------------
*/

Route::get('/products/export', [ProductController::class, 'export'])
    ->name('products.export');


/*
|--------------------------------------------------------------------------
| Product Delete
|--------------------------------------------------------------------------
*/

Route::get('/products/delete/{id}', [ProductController::class, 'destroy'])
    ->name('products.delete');