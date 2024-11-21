<div class="header section">
    <!-- Header Bottom Start -->
    <div class="header-bottom">
        <div class="header-sticky">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Header Logo Start -->
                    <div class="col-xl-2 col-6">
                        <div class="header-logo">
                            <a href="/"><img src="{{ asset('theme/client/assets/images/logo/logo.png') }}"
                                    alt="Site Logo" /></a>
                        </div>
                    </div>
                    <!-- Header Logo End -->

                    <!-- Header Menu Start -->
                    <div class="col-xl-8 d-none d-xl-block">
                        <div class="main-menu position-relative">
                            <ul>
                                <li class="has-children">
                                    <a href="{{ route('home') }}"><span>Trang chủ</span></a>
                                </li>
                                <li class="has-children position-static">
                                    <a href="{{route('shops.index')}}"><span>Cửa hàng</span> <i class="fa fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        @foreach ($clientCategories as $item)
                                            <li>
                                                <a href="{{ route('shops.category', $item->id) }}">{{ $item->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="{{route('blogs.index')}}"><span>Bài viết</span></a>
                                </li>
                                <li><a href="/contact"> <span>Liên hệ</span></a></li>
                                <li><a href="{{route('bill.search')}}"> <span>Tra cứu</span></a></li>

                            </ul>
                        </div>
                    </div>
                    <!-- Header Menu End -->

                    <!-- Header Action Start -->
                    <div class="col-xl-2 col-6">
                        <div class="header-actions">

                            @if (Auth::check())
                                <div class="main-menu position-relative">
                                    <ul>

                                        <li class="has-children position-static">
                                            <a href="javascript:void(0);">
                                                @if (Auth::check() && Auth::user()->avatar)
                                                    <i class="bi bi-person-circle" style="font-size: 1.75rem;"></i>

                                                    <img class="rounded-circle" style="margin-top: -10px" width="30px"
                                                        src="{{ Storage::url(Auth::user()->avatar) }}"
                                                        alt="User Avatar">
                                                @else
                                                    <a href="javascript:void(0);"
                                                        class="header-action-btn d-none d-md-block">
                                                        <i class="pe-7s-user"></i>
                                                    </a>
                                                @endif
                                            </a>
                                            <ul class="sub-menu">
                                                <li><a href="my_account">Thông tin cá nhân</a></li>
                                                <li><a href="">Thông báo</a></li>
                                                <li><a href="">Trung tâm trợ giúp</a></li>
                                                @if ((Auth::check() && Auth::user()->role == 1) || Auth::user()->role == 2)
                                                    <li><a href="{{ route('admin.dashboard') }}">Quản trị viên</a></li>
                                                @endif
                                                <li>

                                                    <form id="logout-form" action="{{ route('user.logout') }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            style="background: none; border: none; color: inherit; font: inherit; cursor: pointer; padding: 0; ">Thoát</button>
                                                    </form>
                                                </li>
                                            </ul>

                                        </li>

                                    </ul>
                                </div>
                            @else
                                <a href="/login" class="header-action-btn d-none d-md-block">
                                    <i class="pe-7s-user"></i>
                                </a>
                            @endif



                            <!-- User Account Header Action Button End -->

                            <!-- Wishlist Header Action Button Start -->
                            @if (Auth::check())
                            <a href="{{route('favorite_Prd.index')}}" class="header-action-btn header-action-btn-wishlist d-none d-md-block">
                                <i class="pe-7s-like"></i>
                            </a>
                            @else
                            <span class="header-action-btn header-action-btn-wishlist d-none d-md-block">
                                <i class="pe-7s-like"></i>
                            </span>
                            @endif

                            <!-- Wishlist Header Action Button End -->

                            <!-- Shopping Cart Header Action Button Start -->
                            <a href="javascript:void(0)" class="header-action-btn header-action-btn-cart">
                                <i class="pe-7s-shopbag"></i>
                                <span style="position: absolute; top:-4 "
                                    class="header-action-num">{{ $uniqueVariantCount }}</span>
                            </a>
                            <!-- Shopping Cart Header Action Button End -->

                            <!-- Mobile Menu Hambarger Action Button Start -->
                            <a href="javascript:void(0)"
                                class="header-action-btn header-action-btn-menu d-xl-none d-lg-block">
                                <i class="fa fa-bars"></i>
                            </a>
                            <!-- Mobile Menu Hambarger Action Button End -->

                        </div>
                    </div>
                    <!-- Header Action End -->

                </div>
            </div>
        </div>
    </div>
    <!-- Header Bottom End -->

    <!-- Mobile Menu Start -->
    <div class="mobile-menu-wrapper">
        <div class="offcanvas-overlay"></div>

        <!-- Mobile Menu Inner Start -->
        <div class="mobile-menu-inner">

            <!-- Button Close Start -->
            <div class="offcanvas-btn-close">
                <i class="pe-7s-close"></i>
            </div>
            <!-- Button Close End -->

            <!-- Mobile Menu Start -->
            <div class="mobile-navigation">
                <nav>
                    <ul class="mobile-menu">
                        <li class="has-children">
                            <a href="/">Home <i class="fa fa-angle-down"></i></a>

                        </li>
                        <li class="has-children">
                            <a href="/shop">Shop <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <ul class="sub-menu">
                                <li><a href="/cart">Cart</a></li>
                                <li><a href="/checkout">Checkout</a></li>
                                <li><a href="/wishlist">wishlist</a></li>
                            </ul>
                        </li>

                        <li class="has-children">
                            <a href="/contact">contact</a>
                        </li>
                        <li class="has-children">
                            <a href="/blog">blog</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Mobile Menu End -->
            <!-- Contact Links/Social Links Start -->
            <div class="mt-auto">

                <!-- Contact Links Start -->
                <ul class="contact-links">
                    <li><i class="fa fa-phone"></i><a href="#"> +012 3456 789 123</a></li>
                    <li><i class="fa fa-envelope-o"></i><a href="#"> info@example.com</a></li>
                    <li><i class="fa fa-clock-o"></i> <span>Monday - Sunday 9.00 - 18.00</span> </li>
                </ul>
                <!-- Contact Links End -->

                <!-- Social Widget Start -->
                <div class="widget-social">
                    <a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                    <a title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                    <a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                    <a title="Youtube" href="#"><i class="fa fa-youtube"></i></a>
                    <a title="Vimeo" href="#"><i class="fa fa-vimeo"></i></a>
                </div>
                <!-- Social Widget Ende -->
            </div>
            <!-- Contact Links/Social Links End -->
        </div>
        <!-- Mobile Menu Inner End -->
    </div>
    <!-- Mobile Menu End -->

    <!-- Offcanvas Search Start -->
    <div class="offcanvas-search">
        <div class="offcanvas-search-inner">

            <!-- Button Close Start -->
            <div class="offcanvas-btn-close">
                <i class="pe-7s-close"></i>
            </div>
            <!-- Button Close End -->

            <!-- Offcanvas Search Form Start -->
            <form class="offcanvas-search-form" action="#">
                <input type="text" placeholder="Search Here..." class="offcanvas-search-input">
            </form>
            <!-- Offcanvas Search Form End -->

        </div>
    </div>
    <!-- Offcanvas Search End -->

    <!-- Cart Offcanvas Start -->
    <div class="cart-offcanvas-wrapper">
        <div class="offcanvas-overlay"></div>

        <!-- Cart Offcanvas Inner Start -->
        <div class="cart-offcanvas-inner">

            <!-- Button Close Start -->
            <div class="offcanvas-btn-close">
                <i class="pe-7s-close"></i>
            </div>
            <!-- Button Close End -->

            <!-- Offcanvas Cart Content Start -->
            <div class="offcanvas-cart-content">
                <!-- Offcanvas Cart Title Start -->
                <h2 class="offcanvas-cart-title mb-5">Giỏ hàng</h2>
                <!-- Offcanvas Cart Title End -->

                @if (!empty($processedItems))
                    @foreach ($processedItems as $item)
                        <div id="cart-{{ $item->id }}" class="cart-product-wrapper mb-2">

                            <!-- Single Cart Product Start -->
                            <div class="single-cart-product">
                                <div class="cart-product-thumb">
                                    <a href="single-product.html"><img
                                            src="{{ Storage::url($item->productVariant->product->img_thumb) }}"
                                            alt="Cart Product"></a>
                                </div>
                                <div class="cart-product-content">
                                    <h3 class="title"><a
                                            href="{{ route('shops.show', $item->productVariant->product->slug) }}">{{ $item->productVariant->product->name }}
                                            <br> {{ $item->productVariant->size->name }} /
                                            {{ $item->productVariant->color->name }}</a></h3>
                                    <span class="price">
                                        <span class="new">{{ number_format($item->productVariant->price_sale, 0, ',', '.') . ' đ' }}</span>
                                    </span>
                                </div>
                            </div>
                            <!-- Single Cart Product End -->

                            <!-- Product Remove Start -->
                            <div class="cart-product-remove">
                                <span class="deleteCart" data-id="{{ $item->id }}"><i class="fa fa-trash" style="font-size: 1.3rem;"></i></span>
                            </div>
                            <!-- Product Remove End -->

                        </div>
                    @endforeach
                @else
                <p>Giỏ hàng của bạn hiện đang trống.</p>
                @endif
                <div class="cartNull" style="text-align: center"></div>

                <!-- Cart Product/Price Start -->

                <!-- Cart Product/Price End -->


                <!-- Cart Product Button Start -->
                <div class="cart-product-btn mt-4">
                    <a href="{{ route('cart.index') }}" class="btn btn-dark btn-hover-primary rounded-0 w-100">Giỏ
                        hàng</a>
                </div>
                <!-- Cart Product Button End -->

            </div>
            <!-- Offcanvas Cart Content End -->

        </div>
        <!-- Cart Offcanvas Inner End -->
    </div>
    <!-- Cart Offcanvas End -->

</div>
