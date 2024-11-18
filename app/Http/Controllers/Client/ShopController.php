<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class ShopController extends Controller
{
    public function index()
    {
        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        };

        $categories = $this->getCategori();

        $calculatePriceRange = $this->getPriceProduct();

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
            ->orderBy('id', 'desc')
            ->paginate(6);

        $producthot = $this->productHot();

        $products->getCollection()->transform($calculatePriceRange);
        $producthot->transform($calculatePriceRange);

        $maxPrice = $this->getMaxPrice();

        return view('client.pages.products.shop', compact('products', 'categories', 'producthot', 'maxPrice'));
    }

    private function getMaxPrice()
    {
        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        };

        $calculatePriceRange = $this->getPriceProduct();

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
            ->orderBy('id', 'desc')
            ->get();

        $products->transform($calculatePriceRange);

        $maxPrice = $products->pluck('max_price_sale')->max();

        return $maxPrice;
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
            ->orderBy('view', 'desc')
            ->take(7)
            ->get();


        $calculatePrices = $this->getPriceProduct();

        $products->transform($calculatePrices);
        $producthot->transform($calculatePrices);
        $maxPrice = $this->getMaxPrice();


        return view('client.pages.products.shop', compact('products', 'categories', 'producthot', 'maxPrice'));
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


        $price_sales = $product->variants->pluck('price_sale');
        $product->max_price_sale = $price_sales->max();
        $product->min_price_sale = $price_sales->min();


        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
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
            ->get();

        return view('client.pages.products.product-detail', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $input = $request->input('searchProduct');

        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        };

        $categories = $this->getCategori();
        $calculatePriceRange = $this->getPriceProduct();
        $producthot = $this->productHot();

        $products = Product::where('is_active', 1)
            ->whereHas('category', $condition)
            ->where(function ($query) use ($input) {
                $query->where('name', 'LIKE', "%{$input}%");
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
            ->orderBy('id', 'desc')
            ->paginate(6);

        $products->getCollection()->transform($calculatePriceRange);
        $producthot->transform($calculatePriceRange);

        $maxPrice = $this->getMaxPrice();

        return view('client.pages.products.shop', compact('products', 'categories', 'producthot', 'input', 'maxPrice'));
    }


    public function filter(Request $request)
    {
        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        };

        $categories = $this->getCategori();
        $calculatePriceRange = $this->getPriceProduct();
        $maxPrice = $this->getMaxPrice();

        $min_price = $request->get('min_price', 0);
        $max_price = $request->get('max_price', $maxPrice);

        $productsQuery = Product::where('is_active', 1)
            ->whereHas('category', $condition)
            ->with([
                'variants' => function ($query) {
                    $query->whereHas('size', function ($query) {
                        $query->whereNull('deleted_at');
                    })->whereHas('color', function ($query) {
                        $query->whereNull('deleted_at');
                    });
                }
            ]);

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $productsQuery->whereHas('variants', function ($query) use ($min_price, $max_price) {
                $query->whereBetween('price_sale', [$min_price, $max_price]);
            });
        }

        // Phân trang và bảo toàn giá trị lọc
        $products = $productsQuery->paginate(6)->appends($request->all());

        $products->getCollection()->transform($calculatePriceRange);

        $producthot = $this->productHot();
        $producthot->transform($calculatePriceRange);

        return view('client.pages.products.shop', compact(
            'products',
            'categories',
            'producthot',
            'min_price',
            'max_price',
            'maxPrice'
        ));
    }


    private function getPriceProduct()
    {
        $calculatePriceRange = function ($product) {
            $price_sales = $product->variants->pluck('price_sale');
            $product->max_price_sale = $price_sales->max();
            $product->min_price_sale = $price_sales->min();
            return $product;
        };
        return $calculatePriceRange;
    }

    private function getCategori()
    {
        $categories = Category::where('is_active', 1)
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', 1);
                }
            ])
            ->orderBy('products_count', 'desc')
            ->get();
        return $categories;
    }

    private function productHot()
    {
        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
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

        return $producthot;
    }



    // public function getSizePrice(Request $request)
    // {
    //     $productId = $request->input('idProduct');
    //     $colorId = $request->input('idColor');

    //     $variants = ProductVariant::where('product_id', $productId)
    //         ->where('color_id', $colorId)
    //         ->with('size')
    //         ->get();

    //     $minPrice = $variants->min('price_sale');
    //     $maxPrice = $variants->max('price_sale');

    //     $response = [];
    //     $sizesSeen = [];

    //     foreach ($variants as $variant) {

    //         if (!in_array($variant->size->name, $sizesSeen)) {
    //             $response[] = [
    //                 'id' => $variant->id,
    //                 'size' => $variant->size->name,
    //                 'price' => $variant->price,
    //                 'price_sale' => $variant->price_sale,
    //                 'product_id' => $variant->product_id,
    //                 'quantity' => $variant->quantity
    //             ];

    //             $sizesSeen[] = $variant->size->name;
    //         }
    //     }

    //     return response()->json([
    //         'variants' => $response,
    //         'min_price' => $minPrice,
    //         'max_price' => $maxPrice
    //     ]);
    // }


    // public function getSizePriceDetail(Request $request)
    // {
    //     Route::get('/check-db', function () {
    //         try {
    //             DB::connection()->getPdo();
    //             return 'Kết nối thành công!';
    //         } catch (\Exception $e) {
    //             return 'Không thể kết nối: ' . $e->getMessage();
    //         }
    //     });
    //     $productId = $request->input('idProduct');
    //     $colorId = $request->input('idColor');

    //     $variants = ProductVariant::where('product_id', $productId)
    //         ->where('color_id', $colorId)
    //         ->with('size')
    //         ->get();

    //     $minPrice = $variants->min('price_sale');
    //     $maxPrice = $variants->max('price_sale');

    //     $response = [];
    //     foreach ($variants as $variant) {
    //         $response[] = [
    //             'id' => $variant->id,
    //             'size' => $variant->size->name,
    //             'price' => $variant->price,
    //             'price_sale' => $variant->price_sale,
    //             'quantity' => $variant->quantity
    //         ];
    //     }

    //     return response()->json([
    //         'variants' => $response,
    //         'min_price' => $minPrice,
    //         'max_price' => $maxPrice
    //     ]);
    // }
}
