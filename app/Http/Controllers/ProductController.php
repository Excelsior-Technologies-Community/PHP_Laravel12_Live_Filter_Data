<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function export(Request $request)
    {

        $products = Product::with('category')
            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');

                });

            })

            ->when($request->color, function ($query) use ($request) {

                $query->where('color', $request->color);

            })

            ->when($request->category, function ($query) use ($request) {

                $query->where('category_id', $request->category);

            })

            ->when($request->minPrice, function ($query) use ($request) {

                $query->where('price', '>=', $request->minPrice);

            })

            ->when($request->maxPrice, function ($query) use ($request) {

                $query->where('price', '<=', $request->maxPrice);

            })

            ->get();

        $fileName = 'filtered_products_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($products) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [

                'ID',
                'Product Name',
                'Category',
                'Color',
                'Price',
                'Description',
                'Created Date'

            ]);

            foreach ($products as $product) {


                fputcsv($file, [

                    $product->id,

                    $product->name,

                    $product->category->name ?? 'N/A',

                    $product->color,

                    $product->price,

                    $product->description,

                    $product->created_at->format('d M Y')

                ]);

            }

            fclose($file);

        };

        return response()->stream(
            $callback,
            200,
            $headers
        );

    }

    public function destroy($id)
    {

        Product::findOrFail($id)->delete();


        return redirect()
            ->route('products')
            ->with('success','Product deleted successfully.');

    }

}