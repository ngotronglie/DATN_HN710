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
        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        };

        $categories = Category::where('is_active', 1)
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', 1);
                }
            ])
            ->orderBy('products_count', 'desc')
            ->get();

        // Định nghĩa một callback tính giá min/max
        $calculatePriceRange = function ($product) {
            $price_sales = $product->variants->pluck('price_sale');
            $product->max_price_sale = $price_sales->max();
            $product->min_price_sale = $price_sales->min();
            return $product;
        };

        $products = Product::where('is_active', 1)
            ->whereHas('category', $condition)
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

        $producthot = Product::where('is_active', 1)
            ->whereHas('category', $condition)
            ->with([
                'variants' => function ($query) {
                    $query->whereHas('size', function ($query) {
                        $query->whereNull('deleted_at');
                    })->whereHas('color', function ($query) {
                        $query->whereNull('deleted_at');
                    });
                }
            ])
            ->orderBy('view', 'desc')
            ->take(7)
            ->get();

        // Tính toán giá min/max cho sản phẩm thường
        $products->getCollection()->transform($calculatePriceRange);

        // Tính toán giá min/max cho sản phẩm hot
        $producthot->transform($calculatePriceRange);

        return view('client.pages.shop', compact('products', 'categories', 'producthot'));
    }


    public function showByCategory($id)
    {
        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        };

        $categories = Category::where('is_active', 1)
            ->withCount([
                'products' => $condition
            ])
            ->orderBy('products_count', 'desc')
            ->get();

        $products = Product::where('category_id', $id)
            ->where('is_active', 1)
            ->whereHas('category', $condition) // Áp dụng điều kiện cho category
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

        $producthot = Product::where('is_active', 1)
            ->whereHas('category', $condition) // Áp dụng điều kiện cho category
            ->orderBy('view', 'desc')
            ->take(7)
            ->get();

        // Xử lý tính toán giá min/max cho cả sản phẩm và sản phẩm hot
        $calculatePrices = function ($product) {
            $price_sales = $product->variants->pluck('price_sale');
            $product->max_price_sale = $price_sales->max();
            $product->min_price_sale = $price_sales->min();
            return $product;
        };

        $products->transform($calculatePrices);
        $producthot->transform($calculatePrices);

        return view('client.pages.shop', compact('products', 'categories', 'producthot'));
    }


    public function show($slug)
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
                    });
                }
            ])
            ->firstOrFail();

        $product->increment('view');
        // $viewsKey = 'product_viewed_' . $product->id;

        // // if (!session()->has($viewsKey)) {
        //     $product->increment('view');
        //     // Đánh dấu rằng người dùng đã xem sản phẩm này trong phiên làm việc
        //     session([$viewsKey => true]);
        // }


        $price_sales = $product->variants->pluck('price_sale');
        $product->max_price_sale = $price_sales->max();
        $product->min_price_sale = $price_sales->min();

        return view('client.pages.product-detail', compact('product'));
    }

    public function search(Request $request)
    {
        $input = $request->input('searchProduct');

        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        };

        $categories = Category::where('is_active', 1)
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', 1);
                }
            ])
            ->orderBy('products_count', 'desc')
            ->get();

        // Định nghĩa một callback tính giá min/max
        $calculatePriceRange = function ($product) {
            $price_sales = $product->variants->pluck('price_sale');
            $product->max_price_sale = $price_sales->max();
            $product->min_price_sale = $price_sales->min();
            return $product;
        };

        $producthot = Product::where('is_active', 1)
            ->whereHas('category', $condition)
            ->with([
                'variants' => function ($query) {
                    $query->whereHas('size', function ($query) {
                        $query->whereNull('deleted_at');
                    })->whereHas('color', function ($query) {
                        $query->whereNull('deleted_at');
                    });
                }
            ])
            ->orderBy('view', 'desc')
            ->take(7)
            ->get();

        // Tìm kiếm sản phẩm dựa trên từ khóa
        $products = Product::where('is_active', 1)
            ->whereHas('category', $condition);

        $products = $products->where(function ($query) use ($input) {
            $query->where('name', 'LIKE', "%{$input}%");
        });

        // Tải các biến thể sản phẩm
        $products = $products->with([
            'variants' => function ($query) {
                $query->whereHas('size', function ($query) {
                    $query->whereNull('deleted_at');
                })->whereHas('color', function ($query) {
                    $query->whereNull('deleted_at');
                });
            }
        ])
            ->paginate(6);

        // Tính toán giá min/max cho sản phẩm thường
        $products->getCollection()->transform($calculatePriceRange);

        // Tính toán giá min/max cho sản phẩm hot
        $producthot->transform($calculatePriceRange);

        return view('client.pages.shop', compact('products', 'categories', 'producthot', 'input'));
    }


    public function getSizePrice(Request $request)
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
        $sizesSeen = []; // Mảng để theo dõi các kích thước đã thấy

        foreach ($variants as $variant) {
            // Kiểm tra xem kích thước đã được thêm chưa
            if (!in_array($variant->size->name, $sizesSeen)) {
                $response[] = [
                    'size' => $variant->size->name,
                    'price' => $variant->price,
                    'price_sale' => $variant->price_sale,
                ];
                // Thêm kích thước vào mảng đã thấy
                $sizesSeen[] = $variant->size->name;
            }
        }

        return response()->json([
            'variants' => $response,
            'min_price' => $minPrice,
            'max_price' => $maxPrice
        ]);
    }


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
