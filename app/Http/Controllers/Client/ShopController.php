<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index()
{
    $product = Product::with('variants.size', 'variants.color')->paginate(6);
    //$totalPages = $product->lastPage();

    $product->transform(function ($product) {
        $price_sales = $product->variants->pluck('price_sale');
        $product->max_price_sale = $price_sales->max();
        $product->min_price_sale = $price_sales->min();

        return $product;
    });

    return view('client.pages.shop', compact('product'));
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
