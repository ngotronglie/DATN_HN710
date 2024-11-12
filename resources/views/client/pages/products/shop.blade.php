@extends('client.index')
@section('style')
    <style>
        .size-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            padding: 8px 0;
        }

        .size-buttons li {
            list-style: none;
            margin: 0;
        }

        .size-btn {
            display: inline-block;
            padding: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            flex: 1 1 auto;
        }

        .size-btn:hover {
            background-color: #f0f0f0;
        }

        .size-btn.active {
            background-color: #3498db;
            color: white;
            border-color: #2980b9;
        }

        .color-buttons {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .color-buttons li {
            display: inline-block;
        }

        .color-btn {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .color-btn.active {
            border-color: #000;
        }

        .price {
            color: #333;
            font-weight: bold;
        }

        .show-price {
            color: #dc3545;
        }

        .price span {
            padding: 0 2px;
        }

        #old-price {
                color: gray;
                display: inline;
                margin: 0;
                margin-left: 5px;
                font-weight: 500;
                padding: 0;
                text-decoration: line-through;
            }

            #old-pricee {
                color: gray;
                display: inline;
                margin: 0;
                font-weight: 500;
                padding: 0;
            }

        .hidden-category {
            display: none;
        }

        #toggleCategories {
            text-decoration: underline;
            font-size: 0.8rem;
        }
    </style>
@endsection
@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Cửa hàng</h1>
                    <ul>
                        <li>
                            <a href="/">Trang chủ </a>
                        </li>
                        <li class="active"> Cửa hàng</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="section section-margin">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9 col-12 col-custom">

                    <div class="shop_toolbar_wrapper flex-column flex-md-row mb-10">

                        <div class="shop-top-bar-left mb-md-0 mb-2">
                            <div class="shop-top-show">
                                {{-- <span>Showing 1–{{$totalPages}} of 39 results</span> --}}
                                <span>Hiển thị 6/40 của 40 sản phẩm</span>

                            </div>
                        </div>

                        <div class="shop-top-bar-right">
                            <div class="shop-short-by mr-4">
                                <select class="nice-select" aria-label=".form-select-sm example">
                                    <option selected>Hiển thị 6</option>
                                    <option value="1">Show 12</option>
                                    <option value="2">Show 24</option>
                                    <option value="3">Hiển thị tất cả</option>
                                </select>
                            </div>

                            <div class="shop-short-by mr-4">
                                <select class="nice-select" aria-label=".form-select-sm example">
                                    <option selected>Mới nhất</option>
                                    <option value="1">Giá thấp đến cao</option>
                                    <option value="2">Giá cao đến thấp</option>
                                </select>
                            </div>

                            <div class="shop_toolbar_btn">
                                <button data-role="grid_3" type="button" class="active btn-grid-4" title="Grid"><i
                                        class="fa fa-th"></i></button>
                                <button data-role="grid_list" type="button" class="btn-list" title="List"><i
                                        class="fa fa-th-list"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row shop_wrapper grid_3">
                        {{-- Product --}}
                        @if ($products->isEmpty())
                            <h1 class="text-center">Hiện không có sản phẩm!</h1>
                            <span class="show-price maxPrice"data-maxPrice="{{$maxPrice}}">
                            </span>
                        @else
                            @foreach ($products as $item)
                                <div class="col-lg-4 col-md-4 col-sm-6 product" data-aos="fade-up" data-aos-delay="200">
                                    <div class="product-inner">
                                        <div class="thumb">
                                            <a href="{{ route('shops.show', $item->slug) }}" class="image">
                                                <img class="first-image" src="{{ Storage::url($item->img_thumb) }}"
                                                    alt="Product" />
                                                <img class="second-image" src="{{ Storage::url($item->first_image) }}"
                                                    alt="Product" />
                                            </a>
                                            {{-- lam tu day them san pham vao db san pham yeu thich --}}
                                            <div class="actions">
                                                <span title="Wishlist" data-id="{{$item->id}}" id="favorite-{{$item->id}}" class="action favorite wishlist">
                                                    <i class="pe-7s-like"></i></span>
                                                <a href="#" class="action quickview" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h5 class="title"><a
                                                    href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a>
                                            </h5>

                                            {{-- Color --}}
                                            <div class="color-options">
                                                <ul class="color-buttons">
                                                    @foreach ($item->variants->unique('color_id') as $index => $variant)
                                                        <li>
                                                            <label class="color-btn colorGetSize"
                                                                data-id="{{ $variant->color->id }}"
                                                                data-productId="{{ $item->id }}"
                                                                style="background-color: {{ $variant->color->hex_code }}"
                                                                onclick="HT.selectColor(this, '{{ $variant->color->hex_code }}')">
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            {{-- Size --}}
                                            <div class="product" data-product-id="{{ $item->id }}">
                                                <div class="product-options">
                                                    <div class="size-options">
                                                        <ul id="sizes-prices-{{ $item->id }}" class="size-buttons">
                                                        </ul>
                                                    </div>

                                                    <div class="price price-options">
                                                        <label style="margin-right:5px"></label>
                                                        <span id="product-price-sale-{{ $item->id }}"
                                                            class="show-price maxPrice" data-filpro="{{$item->id ?? 0}}" data-maxPrice="{{$maxPrice}}">
                                                            {{ $item->min_price_sale == $item->max_price_sale
                                                                ? number_format($item->min_price_sale) . 'đ'
                                                                : number_format($item->min_price_sale).'đ' . ' - ' . number_format($item->max_price_sale) . 'đ' }}
                                                        </span>
                                                        <span id="old-price" class="old-price-{{ $item->id }}"></span>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="shop-list-btn">
                                                <span title="Wishlist" data-id="{{$item->id}}" id="favorite2-{{$item->id}}"
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary wishlist favorite2"><i
                                                        class="fa fa-heart"></i></span>
                                                <button id="addcart-{{$item->id}}"
                                                    data-id="{{$item->id}}"
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary"
                                                    title="Thêm vào giỏ hàng">Thêm vào giỏ hàng
                                                </button>
                                                <a title="Compare" href="#"
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary compare">
                                                    <i class="fa fa-random"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>


                    <div class="shop_toolbar_wrapper mt-10">
                        <div class="shop-top-bar-left">
                            <div class="shop-short-by mr-4">
                                <select class="nice-select rounded-0" aria-label=".form-select-sm example">
                                    <option selected>Hiển thị 6</option>
                                    <option value="1">Hiển thị 12</option>
                                    <option value="2">Hiển thị 24</option>
                                    <option value="3">Hiển thị tất cả</option>
                                </select>
                            </div>
                        </div>

                        <div class="shop-top-bar-right">
                            <nav>
                                <ul class="pagination">
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    @endif

                                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                                        <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->nextPageUrl() }}"
                                                aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-12 col-custom">
                    <!-- Sidebar Widget Start -->
                    <aside class="sidebar_widget mt-10 mt-lg-0">
                        <div class="widget_inner aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                            <div class="widget-list mb-10">
                                <h3 class="widget-title mb-4">Tìm kiếm</h3>
                                <form action="{{ route('shop.search') }}" method="get">
                                    <div class="search-box">
                                        <input type="text" class="form-control" name="searchProduct"
                                            placeholder="Tìm kiếm sản phẩm" value={{ $input ?? '' }}>
                                        <button class="btn btn-dark btn-hover-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="widget-list mb-10">
                                <h3 class="widget-title mb-5">Lọc giá</h3>
                                <form action="{{ route('shop.filter') }}" method="GET">
                                    <div id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                        <div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
                                    </div>
                                    <input class="slider-range-amount" type="text" id="amount" readonly>
                                    <input type="hidden" name="min_price" id="min-price">
                                    <input type="hidden" name="max_price" id="max-price">
                                    <button class="slider-range-submit" type="submit">Lọc</button>
                                </form>
                            </div>


                            <div class="widget-list mb-10">
                                <h3 class="widget-title">Danh mục</h3>
                                <div class="sidebar-body">
                                    <ul class="sidebar-list" id="categoryList">
                                        @foreach ($categories as $index => $item)
                                            <li class="{{ $index >= 5 ? 'hidden-category' : '' }}">
                                                <a href="{{ route('shops.category', $item) }}">
                                                    {{ $item->name }} ({{ $item->products_count }})
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if ($categories->count() > 5)
                                        <p id="toggleCategories" class="mt-3 text-primary" style="cursor: pointer;">Xem
                                            thêm</p>
                                    @endif
                                </div>

                            </div>


                            <div class="widget-list">
                                <h3 class="widget-title mb-4">Sản phẩm hot</h3>
                                <div class="sidebar-body product-list-wrapper mb-n6">
                                    @foreach ($producthot as $index => $item)
                                        <div class="single-product-list product-hover mb-6">
                                            <div class="thumb">
                                                <a href="{{ route('shops.show', $item->slug) }}" class="image">
                                                    <img class="first-image" src="{{ Storage::url($item->img_thumb) }}"
                                                        alt="Product">
                                                    <img class="second-image" src="{{ Storage::url($item->first_image) }}"
                                                        alt="Product">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="title">
                                                    <a
                                                        href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a>
                                                </h5>
                                                <span style="font-size: 0.9rem" id="product-price-sale-{{ $item->id }}" class="show-price">
                                                    {{ $item->min_price_sale == $item->max_price_sale
                                                        ? number_format($item->min_price_sale) . 'đ'
                                                        : number_format($item->min_price_sale) .'đ' . ' - ' . number_format($item->max_price_sale) . 'đ' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- Sidebar Widget End -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/js/getsize.js') }}"></script>
@endsection
