<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ShopAjaxController extends Controller
{
    public function getSizePriceDetail(Request $request)
    {
        $productId = $request->input('idProduct');
        $colorId = $request->input('idColor');

        $variants = ProductVariant::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->with('size')
            ->get();

        $minPrice = $variants->min('price_sale');
        $maxPrice = $variants->max('price_sale');

        $response = [];
        foreach ($variants as $variant) {
            $response[] = [
                'id' => $variant->id,
                'size' => $variant->size->name,
                'price' => $variant->price,
                'price_sale' => $variant->price_sale,
                'quantity' => $variant->quantity
            ];
        }

        return response()->json([
            'variants' => $response,
            'min_price' => $minPrice,
            'max_price' => $maxPrice
        ]);
    }

    public function showAjax($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', 1)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1)
                    ->whereNull('deleted_at');
            })
            ->with([
                'galleries',
                'variants' => function ($query) {
                    $query->whereHas('size', function ($query) {
                        $query->whereNull('deleted_at');
                    })->whereHas('color', function ($query) {
                        $query->whereNull('deleted_at');
                    })
                        ->with(['size', 'color']);
                }
            ])
            ->firstOrFail();

        $price_sales = $product->variants->pluck('price_sale');
        $product->max_price_sale = $price_sales->max();
        $product->min_price_sale = $price_sales->min();

        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'view' => $product->view,
            'img_thumb' => $product->img_thumb,
            'galleries' => array_merge(
                [$product->img_thumb],
                array_map(function ($gallery) {
                    return $gallery['image'];
                }, $product->galleries->toArray())
            ),
            'min_price_sale' => $product->min_price_sale,
            'max_price_sale' => $product->max_price_sale,
            'variants' => $product->variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'price' => $variant->price,
                    'price_sale' => $variant->price_sale,
                    'quantity' => $variant->quantity,
                    'size' => [
                        'id' => $variant->size->id,
                        'name' => $variant->size->name,
                    ],
                    'color' => [
                        'id' => $variant->color->id,
                        'name' => $variant->color->name,
                        'hex_code' => $variant->color->hex_code,
                    ]
                ];
            })
        ];

        return response()->json($productData);
    }

}
