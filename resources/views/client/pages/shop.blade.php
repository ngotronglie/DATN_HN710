@extends('client.index')

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
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Start -->
    <div class="section section-margin">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9 col-12 col-custom">

                    <!--shop toolbar start-->
                    <div class="shop_toolbar_wrapper flex-column flex-md-row mb-10">

                        <!-- Shop Top Bar Left start -->
                        <div class="shop-top-bar-left mb-md-0 mb-2">
                            <div class="shop-top-show">
                                <span>Showing 1–12 of 39 results</span>
                            </div>
                        </div>
                        <!-- Shop Top Bar Left end -->

                        <!-- Shopt Top Bar Right Start -->
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
                        <!-- Shopt Top Bar Right End -->

                    </div>
                    <!--shop toolbar end-->

                    <!-- Shop Wrapper Start -->
                    <div class="row shop_wrapper grid_3">


                        @foreach ($SanPham as $key => $item)
                            <!-- Single Product Start -->
                            <div class="col-lg-4 col-md-4 col-sm-6 product" data-aos="fade-up" data-aos-delay="400">
                                <div class="product-inner">
                                    <div class="thumb">
                                        <a href="single-product.html" class="hinh_anh">
                                            <img src="
                                            @if (strpos($item->hinh_anh, 'http') === 0) {{ $item->hinh_anh }} 
                                            @else 
                                                {{ Storage::url($item->hinh_anh) }} @endif"
                                                alt="Slider hinh_anh" />

                                        </a>
                                        <div class="actions">
                                            <a href="wishlist.html" title="Wishlist" class="action wishlist"><i
                                                    class="pe-7s-like"></i></a>
                                            <a href="#" title="Quickview" class="action quickview"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i
                                                    class="pe-7s-search"></i></a>
                                            <a href="compare.html" title="Compare" class="action compare"><i
                                                    class="pe-7s-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title"><a href="single-product.html">Studio Design</a></h4>
                                        <h5 class="title"><a href="single-product.html">{{ $item->ten_san_pham }}</a></h5>
                                        <span class="ratings">
                                            <span class="rating-wrap">
                                                <span class="star" style="width: 100%"></span>
                                            </span>
                                            <span class="rating-num">(4)</span>
                                        </span>
                                        <P>{{ $item->mo_ta_ngan }}</P>
                                        <span class="price">
                                            <span class="old">{{ $item->gia_san_pham }}</span>
                                            <span class="new">{{ $item->gia_khuyen_mai }}</span>
                                        </span>
                                        <div class="shop-list-btn">
                                            <a title="Wishlist" href="#"
                                                class="btn btn-sm btn-outline-dark btn-hover-primary wishlist"><i
                                                    class="fa fa-heart"></i></a>
                                            <button class="btn btn-sm btn-outline-dark btn-hover-primary"
                                                title="Add To Cart">Add To Cart</button>
                                            <a title="Compare" href="#"
                                                class="btn btn-sm btn-outline-dark btn-hover-primary compare"><i
                                                    class="fa fa-random"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Product End -->
                        @endforeach


                    </div>
                    <!-- Shop Wrapper End -->

                    <!--shop toolbar start-->
                    <div class="shop_toolbar_wrapper mt-10">

                        <!-- Shop Top Bar Left start -->
                        <div class="shop-top-bar-left">
                            <div class="shop-short-by mr-4">
                                <select class="nice-select rounded-0" aria-label=".form-select-sm example">
                                    <option selected>Show 12 Per Page</option>
                                    <option value="1">Show 12 Per Page</option>
                                    <option value="2">Show 24 Per Page</option>
                                    <option value="3">Show 15 Per Page</option>
                                    <option value="3">Show 30 Per Page</option>
                                </select>
                            </div>
                        </div>
                        <!-- Shop Top Bar Left end -->

                        <!-- Shopt Top Bar Right Start -->
                        <div class="shop-top-bar-right">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Shopt Top Bar Right End -->

                    </div>
                    <!--shop toolbar end-->

                </div>
                <div class="col-lg-3 col-12 col-custom">
                    <!-- Sidebar Widget Start -->
                    <aside class="sidebar_widget mt-10 mt-lg-0">
                        <div class="widget_inner" data-aos="fade-up" data-aos-delay="200">
                            <div class="widget-list mb-10">
                                <h3 class="widget-title mb-4">Search</h3>
                                <div class="search-box">
                                    <input type="text" class="form-control" placeholder="Search Our Store"
                                        aria-label="Search Our Store">
                                    <button class="btn btn-dark btn-hover-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="widget-list mb-10">
                                <h3 class="widget-title mb-5">Price Filter</h3>
                                <!-- Widget Menu Start -->
                                <form action="#">
                                    <div id="slider-range"></div>
                                    <button class="slider-range-submit" type="submit">Filter</button>
                                    <input class="slider-range-amount" type="text" name="text" id="amount" />
                                </form>
                                <!-- Widget Menu End -->
                            </div>
                            <div class="widget-list mb-10">
                                <h3 class="widget-title">Categories</h3>
                                {{-- danh muc ở đây --}}

                                <div class="sidebar-body">
                                    <ul class="sidebar-list">
                                        @foreach ($DanhMuc as $key => $item)
                                            <li><a
                                                    href="{{ route('shop_danh_muc', $item->id) }}">{{ $item->ten_danh_muc }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
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
