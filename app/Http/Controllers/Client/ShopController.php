<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $condition = function ($query) {
            $query->where('is_active', 1)
                ->whereNull('deleted_at');
        };

        $categories = $this->getCategori();
        $calculatePriceRange = $this->getPriceProduct();
        $perPage = $request->input('perPage', 6);
        $sort = $request->input('sort', 'newest');

        $query = Product::where('is_active', 1)
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

        if ($sort == 'price_asc') {
            $query->orderBy(DB::raw("(SELECT MIN(price_sale) FROM product_variants WHERE product_id = products.id)"), 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy(DB::raw("(SELECT MIN(price_sale) FROM product_variants WHERE product_id = products.id)"), 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $producthot = $this->productHot();

        $producthot->transform($calculatePriceRange);

        $maxPrice = $this->getMaxPrice();
        if ($perPage != 'all') {
            $products = $query->paginate($perPage);
            $products->getCollection()->transform($calculatePriceRange);
            return view('client.pages.products.shop', compact('products', 'categories', 'producthot', 'maxPrice'));
        } else {
            $products = $query->get();
            $products->transform($calculatePriceRange);
            $total = $products->count();
            $lastItem = $products->last();
            return view('client.pages.products.shop', compact('products', 'categories', 'producthot', 'maxPrice', 'total', 'lastItem'));
        }
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

        $comments = Comment::where('product_id', $product->id)
            ->where('is_active', 1)
            ->whereNull('parent_id')
            ->with([
                'children' => function ($query) {
                    $query->where('is_active', 1) // Chỉ lấy bình luận con có is_active = 1
                        ->orderBy('created_at', 'desc');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(2);

        $totalComments = Comment::where('product_id', $product->id)
            ->where('is_active', 1)
            ->count();

        return view('client.pages.products.product-detail', compact('product', 'relatedProducts', 'comments', 'totalComments'));
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
            ->take(6)
            ->get();

        return $producthot;
    }
}
