@extends('client.index')
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
                                @if (request('perPage') != 'all')
                                <span>Hiển thị {{ $products->firstItem() }} - {{ $products->lastItem() }} của tổng cộng {{ $products->total() }} sản phẩm</span>
                                @else
                                <span>Hiển thị {{ $lastItem ? $products->search($lastItem) + 1 : $total }}/{{ $total }} sản phẩm</span>
                                @endif
                            </div>
                        </div>

                        <div class="shop-top-bar-right">

                            <div class="shop-short-by mr-4">
                                <form method="GET" action="{{ route('shops.index') }}">
                                    <div class="form-group">
                                        <select name="perPage" class="nice-select" aria-label=".form-select-sm example" onchange="this.form.submit()">
                                            <option value="6" {{ request('perPage') == 6 ? 'selected' : '' }}>Hiển thị 6</option>
                                            <option value="12" {{ request('perPage') == 12 ? 'selected' : '' }}>Hiển thị 12</option>
                                            <option value="24" {{ request('perPage') == 24 ? 'selected' : '' }}>Hiển thị 24</option>
                                            <option value="all" {{ request('perPage') == 'all' ? 'selected' : '' }}>Hiển thị tất cả</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="sort" value="{{ request('sort') == null ? 'newest' : request('sort')}}">
                                </form>
                            </div>

                            <div class="shop-short-by mr-4">
                                <form method="GET" action="{{ route('shops.index') }}">
                                    <select name="sort" class="nice-select" aria-label="Select sort order" onchange="this.form.submit()">
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                    </select>
                                    <input type="hidden" name="perPage" value="{{ request('perPage') == null ? 6 : request('perPage') }}">
                                </form>
                            </div>

                            <div class="shop_toolbar_btn">
                                <button data-role="grid_3" type="button" class="active btn-grid-4" title="Grid"><i class="fa fa-th"></i></button>
                                <button data-role="grid_list" type="button" class="btn-list" title="List"><i class="fa fa-th-list"></i></button>
                            </div>
                        </div>

                    </div>

                    <div class="row shop_wrapper grid_3">

                        @if ($products->isEmpty())
                            <h1 class="text-center">Hiện không có sản phẩm!</h1>
                            <span class="show-price maxPrice"data-maxPrice="{{ $maxPrice }}">
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

                                            <div class="actions">
                                                <span class="action addFavorite" data-slug="{{ $item->slug }}"
                                                    data-id="{{ $item->id }}">
                                                    <i class="pe-7s-like"></i>
                                                </span>
                                                <span class="action quickview showProduct" data-slug="{{ $item->slug }}"
                                                    data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalCenter">
                                                    <i class="pe-7s-search"></i>
                                                </span>
                                                <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                            </div>
                                        </div>

                                        <div class="content">
                                            <h5 class="title"><a
                                                    href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a>
                                            </h5>

                                            <div class="product" data-product-id="{{ $item->id }}">
                                                <div class="product-options">
                                                    <span class="price">
                                                        <span class="new maxPrice" data-filpro="{{ $item->id ?? 0 }}"
                                                            data-maxPrice="{{ $maxPrice }}">
                                                            {{ $item->min_price_sale == $item->max_price_sale
                                                                ? number_format($item->min_price_sale, 0, ',', '.') . ' đ'
                                                                : number_format($item->min_price_sale, 0, ',', '.') . 'đ - ' . number_format($item->max_price_sale, 0, ',', '.') . ' đ' }}
                                                            </span>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="shop-list-btn">
                                                <span title="Wishlist"
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary wishlist addFavorite"
                                                    data-slug="{{ $item->slug }}" data-id="{{ $item->id }}"><i
                                                        class="fa fa-heart"></i></span>
                                                <button class="btn btn-sm btn-outline-dark btn-hover-primary showProduct"
                                                    data-slug="{{ $item->slug }}" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalCenter">Thêm vào giỏ
                                                    hàng
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
                                <form method="GET" action="{{ route('shops.index') }}">
                                    <div class="form-group">
                                        <select name="perPage" class="nice-select" aria-label=".form-select-sm example" onchange="this.form.submit()">
                                            <option value="6" {{ request('perPage') == 6 ? 'selected' : '' }}>Hiển thị 6</option>
                                            <option value="12" {{ request('perPage') == 12 ? 'selected' : '' }}>Hiển thị 12</option>
                                            <option value="24" {{ request('perPage') == 24 ? 'selected' : '' }}>Hiển thị 24</option>
                                            <option value="all" {{ request('perPage') == 'all' ? 'selected' : '' }}>Hiển thị tất cả</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if (request('perPage') != 'all')
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
                                            <a class="page-link"
                                                href="{{ $products->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    @endif

                                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                                        <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $products->url($i) . '&' . http_build_query(request()->except('page')) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endfor

                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $products->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"
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
                        @else
                        <div class="shop-top-bar-right">
                            <nav>
                                <ul class="pagination">
                                    <li style="cursor: pointer;" class="page-item disabled">
                                        <span class="page-link" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </span>
                                    </li>

                                    <li style="cursor: pointer;" class="page-item active">
                                        <span class="page-link">1</span>
                                    </li>


                                    <li style="cursor: pointer;" class="page-item">
                                        <span class="page-link" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </span>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        @endif

                    </div>
                </div>

                <div class="col-lg-3 col-12 col-custom">

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
                                    <div id="slider-range"
                                        class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                        <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"
                                            aria-label="Minimum price handle"></span>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"
                                            aria-label="Maximum price handle"></span>
                                    </div>
                                    <input class="slider-range-amount" type="text" id="amount" readonly
                                        value="₫{{ request('min_price', 0) }} - ₫{{ request('max_price', $maxPrice) }}">
                                    <input type="hidden" name="min_price" id="min-price"
                                        value="{{ request('min_price', 0) }}">
                                    <input type="hidden" name="max_price" id="max-price"
                                        value="{{ request('max_price', $maxPrice) }}">
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
                                <h3 class="widget-title mb-4">Sản phẩm nổi bật</h3>
                                <div class="sidebar-body product-list-wrapper mb-n6">
                                    @foreach ($producthot as $index => $item)
                                        <div class="single-product-list product-hover mb-6">
                                            <div class="thumb">
                                                <a href="{{ route('shops.show', $item->slug) }}" class="image">
                                                    <img class="first-image" src="{{ Storage::url($item->img_thumb) }}"
                                                        alt="Product">
                                                    <img class="second-image"
                                                        src="{{ Storage::url($item->first_image) }}" alt="Product">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="title">
                                                    <a
                                                        href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a>
                                                </h5>
                                                <span class="price">
                                                    <span class="new">
                                                        {{ $item->min_price_sale == $item->max_price_sale
                                                            ? number_format($item->min_price_sale, 0, ',', '.') . ' đ'
                                                            : number_format($item->min_price_sale, 0, ',', '.') . 'đ - ' . number_format($item->max_price_sale, 0, ',', '.') . ' đ' }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/js/shop.js') }}"></script>
    <script src="{{ asset('plugins/js/viewDetailProductModal.js') }}"></script>
    <script src="{{ asset('plugins/js/addCartAddFavorite.js') }}"></script>
@endsection
