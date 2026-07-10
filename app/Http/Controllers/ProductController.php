<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Delete Product
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('products')
            ->with('success', 'Product deleted successfully.');
    }
}