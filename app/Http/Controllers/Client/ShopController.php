<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', 1)
            ->whereHas('category', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->with([
                'variants' => function ($query) {
                    $query->whereHas('size', function ($query) {
                        $query->whereNull('deleted_at');
                    })->whereHas('color', function ($query) {
                        $query->whereNull('deleted_at');
                    });
                }
            ])
            ->paginate(6);

        //$totalPages = $product->lastPage();

        $products->transform(function ($product) {
            $price_sales = $product->variants->pluck('price_sale');
            $product->max_price_sale = $price_sales->max();
            $product->min_price_sale = $price_sales->min();

            return $product;
        });

        return view('client.pages.shop', compact('products'));
    }

    public function showByCategory($id)
    {
        $category = Category::where('id', $id)->where('is_active', 1)->whereNull('deleted_at')->firstOrFail();
        
        $products = Product::where('category_id', $id)
        ->where('is_active', 1)
        ->with(['variants' => function ($query) {
            $query->whereHas('size', function ($query) {
                $query->whereNull('deleted_at');
            })->whereHas('color', function ($query) {
                $query->whereNull('deleted_at');
            });
        }])->paginate(6);

        $products->transform(function ($product) {
            $price_sales = $product->variants->pluck('price_sale');
            $product->max_price_sale = $price_sales->max();
            $product->min_price_sale = $price_sales->min();

            return $product;
        });
        
        return view('client.pages.shop', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', 1)
            ->whereHas('category', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->with(['galleries', 'variants' => function ($query) {
                $query->whereHas('size', function ($query) {
                    $query->whereNull('deleted_at');
                })->whereHas('color', function ($query) {
                    $query->whereNull('deleted_at');
                });
            }])
            ->firstOrFail();

        return view('client.pages.product-detail', compact('product'));
    }

    public function getSizePrice(Request $request)
    {
        $productId = $request->input('idProduct');
        $colorId = $request->input('idColor');

        $variants = ProductVariant::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->with('size')
            ->get();

        $response = [];
        foreach ($variants as $variant) {
            $response[] = [
                'size' => $variant->size->name,
                'price' => $variant->price,
                'price_sale' => $variant->price_sale
            ];
        }

        return response()->json($response);
    }
}
