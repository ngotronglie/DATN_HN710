@extends('client.index')
@section('style')
    <style>
        .size-buttons {
            display: flex;
            justify-content: center;
            /* Căn giữa theo chiều ngang */
            align-items: center;
            /* Căn giữa theo chiều dọc (nếu cần) */
            flex-wrap: wrap;
            /* Cho phép các nút xuống dòng khi không đủ không gian */
            gap: 0.5rem;
            /* Khoảng cách giữa các nút, sử dụng rem */
            padding: 1rem 0;
            /* Tùy chọn: thêm khoảng trống ở trên và dưới để tạo không gian */
        }

        .size-buttons li {
            list-style: none;
            /* Bỏ kiểu đánh dấu của danh sách */
            margin: 0;
            /* Bỏ margin mặc định */
        }

        .size-btn {
            display: inline-block;
            /* Cho phép hiển thị như inline-block */
            padding: 0.625rem 0.9375rem;
            /* Thêm padding cho kích thước (10px 15px) */
            border: 0.0625rem solid #ccc;
            /* Thêm viền cho nút (1px) */
            border-radius: 0.3125rem;
            /* Bo góc cho nút (5px) */
            cursor: pointer;
            /* Thay đổi con trỏ khi hover */
            transition: background-color 0.3s;
            /* Hiệu ứng chuyển đổi màu nền */
            flex: 1 1 auto;
            /* Đặt kích thước co giãn */
            min-width: 5rem;
            /* Đặt chiều rộng tối thiểu cho các nút */
            max-width: 8rem;
            /* Đặt chiều rộng tối đa cho các nút */
        }

        .size-btn:hover {
            background-color: #f0f0f0;
            /* Thay đổi màu nền khi hover */
        }

        .size-btn.active {
            background-color: #3498db;
            /* Màu nền khi kích hoạt */
            color: white;
            /* Màu chữ khi kích hoạt */
            border-color: #2980b9;
            /* Đường viền khi kích hoạt */
        }

        .color-buttons {
            list-style-type: none;
            /* Bỏ các dấu chấm */
            padding: 0;
            margin: 0;
            display: flex;
            /* Hiển thị hàng ngang */
            justify-content: center;
            /* Căn giữa theo chiều ngang */
            align-items: center;
            /* Căn giữa theo chiều dọc (nếu cần) */
            gap: 0.625rem;
            /* Khoảng cách giữa các nút */
        }

        .color-buttons li {
            display: inline-block;
            /* Hiển thị các nút theo hàng ngang */
        }

        .color-btn {
            width: 1.875rem;
            /* 30px */
            height: 1.875rem;
            /* 30px */
            border-radius: 50%;
            cursor: pointer;
            border: 0.125rem solid transparent;
            /* 2px */
            transition: border-color 0.3s;
        }

        .color-btn.active {
            border-color: #000;
            /* Đường viền màu đen khi được chọn */
        }

        .price {
            color: #333;
            /* Màu chữ */
            font-weight: bold;
            /* Đậm chữ */
        }

        .show-price {
            color: #dc3545;
            /* Màu đỏ cho giá tối đa */
        }

        .price span {
            padding: 0 0.125rem;
            /* Khoảng cách giữa các phần tử (2px) */
        }

        .price {
            display: flex;
            /* Sử dụng flexbox để căn chỉnh */
            align-items: center;
            /* Căn giữa theo chiều dọc */
            gap: 0.375rem;
            /* Khoảng cách giữa giá tối thiểu và tối đa (6px) */
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
                    <h1 class="title">Shop</h1>
                    <ul>
                        <li>
                            <a href="/">Home </a>
                        </li>
                        <li class="active"> shop</li>
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
                                <span>Showing 1–39 of 39 results</span>

                            </div>
                        </div>

                        <div class="shop-top-bar-right">
                            <div class="shop-short-by mr-4">
                                <select class="nice-select" aria-label=".form-select-sm example">
                                    <option selected>Show 24</option>
                                    <option value="1">Show 24</option>
                                    <option value="2">Show 12</option>
                                    <option value="3">Show 15</option>
                                    <option value="3">Show 30</option>
                                </select>
                            </div>

                            <div class="shop-short-by mr-4">
                                <select class="nice-select" aria-label=".form-select-sm example">
                                    <option selected>Short by Default</option>
                                    <option value="1">Short by Popularity</option>
                                    <option value="2">Short by Rated</option>
                                    <option value="3">Short by Latest</option>
                                    <option value="3">Short by Price</option>
                                    <option value="3">Short by Price</option>
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
                        {{-- DO SAN PHAM --}}
                        @foreach ($product as $item)
                            <div class="col-lg-4 col-md-4 col-sm-6 product" data-aos="fade-up" data-aos-delay="200">
                                <div class="product-inner">
                                    <div class="thumb">
                                        <a href="{{route('shops.show', $item)}}" class="image">
                                            <img class="first-image" src="{{ Storage::url($item->img_thumb) }}"
                                                alt="Product" />
                                            <img class="second-image" src="{{ Storage::url($item->img_thumb) }}"
                                                alt="Product" />
                                        </a>
                                        <div class="actions">
                                            <a href="wishlist.html" title="Wishlist" class="action wishlist">
                                            <i class="pe-7s-like"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="{{route('shops.show', $item)}}">{{ $item->name }}</a></h5>

                                        {{--  MAU --}}
                                        <div class="color-options">
                                            <label>Color:</label>
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

                                        {{-- DO DU LIEU SIZE GIA --}}
                                        <div class="product" data-product-id="{{ $item->id }}">
                                            <div class="product-options">
                                                <div class="size-options">
                                                    <div id="lable-change-{{ $item->id }}"></div>
                                                    <ul id="sizes-prices-{{ $item->id }}" class="size-buttons">
                                                    </ul>
                                                </div>

                                                <div class="price price-options">
                                                    <label>Giá:</label>
                                                    <span id="product-price-sale-{{ $item->id }}" class="show-price">
                                                        {{ $item->min_price_sale == $item->max_price_sale
                                                        ? number_format($item->min_price_sale) . ' VNĐ'
                                                        : number_format($item->min_price_sale) . ' - ' .
                                                        number_format($item->max_price_sale) . ' VNĐ' }}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="shop-list-btn">
                                            <a title="Wishlist" href="#"
                                                class="btn btn-sm btn-outline-dark btn-hover-primary wishlist"><i
                                                    class="fa fa-heart"></i></a>
                                            <button class="btn btn-sm btn-outline-dark btn-hover-primary"
                                                title="Add To Cart" fdprocessedid="djqltl">Add To Cart</button>
                                            <a title="Compare" href="#"
                                                class="btn btn-sm btn-outline-dark btn-hover-primary compare">
                                                <i class="fa fa-random"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="shop_toolbar_wrapper mt-10">
                        <div class="shop-top-bar-left">
                            {{-- <div class="shop-short-by mr-4">
                                <select class="nice-select rounded-0" aria-label=".form-select-sm example">
                                    <option selected>Show 12 Per Page</option>
                                    <option value="1">Show 12 Per Page</option>
                                    <option value="2">Show 24 Per Page</option>
                                    <option value="3">Show 15 Per Page</option>
                                    <option value="3">Show 30 Per Page</option>
                                </select>
                            </div> --}}
                        </div>

                        <div class="shop-top-bar-right">
                            <nav>
                                <ul class="pagination">
                                    @if ($product->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $product->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    @endif

                                    @for ($i = 1; $i <= $product->lastPage(); $i++)
                                        <li class="page-item {{ $product->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $product->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if ($product->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $product->nextPageUrl() }}" aria-label="Next">
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
                                <h3 class="widget-title mb-4">Search</h3>
                                <div class="search-box">
                                    <input type="text" class="form-control" placeholder="Search Our Store"
                                        aria-label="Search Our Store" fdprocessedid="brq7c">
                                    <button class="btn btn-dark btn-hover-primary" type="button" fdprocessedid="yf7q8c">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="widget-list mb-10">
                                <h3 class="widget-title mb-5">Price Filter</h3>
                                <!-- Widget Menu Start -->
                                <form action="#">
                                    <div id="slider-range"
                                        class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                        <div class="ui-slider-range ui-corner-all ui-widget-header"
                                            style="left: 0%; width: 100%;"></div><span tabindex="0"
                                            class="ui-slider-handle ui-corner-all ui-state-default"
                                            style="left: 0%;"></span><span tabindex="0"
                                            class="ui-slider-handle ui-corner-all ui-state-default"
                                            style="left: 100%;"></span>
                                    </div>
                                    <button class="slider-range-submit" type="submit"
                                        fdprocessedid="dfq28k">Filter</button>
                                    <input class="slider-range-amount" type="text" name="text" id="amount"
                                        fdprocessedid="wcqd7o">
                                </form>
                                <!-- Widget Menu End -->
                            </div>


                            <div class="widget-list mb-10">
                                <h3 class="widget-title">Danh mục</h3>
                                <div class="sidebar-body">
                                    <ul class="sidebar-list">
                                        <li><a href="#">Best Seller (5)</a></li>
                                        <li><a href="#">Featured (4)</a></li>
                                        <li><a href="#">New Products (6)</a></li>
                                    </ul>
                                </div>
                            </div>


                            <div class="widget-list">
                                <h3 class="widget-title mb-4">Sản phẩm hot</h3>
                                <div class="sidebar-body product-list-wrapper mb-n6">
                                    @for ($i = 0; $i < 7; $i++)
                                    <div class="single-product-list product-hover mb-6">
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img class="first-image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmhF7UB6jv1t_oyGDzqSb_h0JPspDnfqohVA&s"
                                                    alt="Product">
                                                <img class="second-image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmhF7UB6jv1t_oyGDzqSb_h0JPspDnfqohVA&s"
                                                    alt="Product">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="title"><a href="single-product.html">Brother Hoddies in Grey</a></h5>
                                            <span class="price">
													<span class="new">$38.00</span>
                                                <span class="old">$42.50</span>
                                            </span>

                                        </div>
                                    </div>
                                    @endfor
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
