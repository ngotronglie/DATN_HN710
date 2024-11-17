<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
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
}
