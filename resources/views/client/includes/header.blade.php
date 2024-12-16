<div class="header section">
    <!-- Header Bottom Start -->
    <div class="header-bottom">
        <div class="header-sticky">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Header Logo Start -->
                    <div class="col-xl-2 col-6">
                        <div class="header-logo">
                            <a href="/"><img width="100px" src="{{ asset('theme/client/assets/images/logo/logo2.jpg') }}"
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
                                    <a href="{{ route('shops.index') }}"><span>Cửa hàng</span> <i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        @foreach ($clientCategories as $item)
                                            <li>
                                                <a href="{{ route('shops.category', $item->id) }}">{{ $item->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a href="{{ route('blogs.index') }}"><span>Bài viết</span></a>
                                </li>
                                <li><a href="/support"> <span>Hỗ trợ</span></a></li>
                                <li><a href="{{ route('bill.search') }}"> <span>Tra cứu</span></a></li>

                            </ul>
                        </div>
                    </div>
                    <!-- Header Menu End -->

                    <!-- Header Action Start -->
                    <div class="col-xl-2 col-6">
                        <div class="header-actions">
                            
                            <a href="javascript:void(0)" class="header-action-btn header-action-btn-search"><i
                                class="pe-7s-search"></i></a>

                            @if (Auth::check())
                                <div class="main-menu position-relative">
                                    <ul>

                                        <li class="has-children position-static">
                                            <a href="javascript:void(0);" class="header-action-btn">
                                                @if (Auth::check() && Auth::user()->avatar)
                                                <a href="header-action-btn d-none d-md-block"></a>
                                                    <img class="rounded-circle" width="30px" height="30px" style="object-fit: cover;"
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
                                                        <button class="logoutClient" type="submit">Thoát</button>
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

                            @if (Auth::check())
                                <a href="{{ route('favorite_Prd.index') }}"
                                    class="header-action-btn header-action-btn-wishlist d-none d-md-block">
                                    <i class="pe-7s-like"></i>
                                </a>
                            @else
                                <span class="header-action-btn header-action-btn-wishlist d-none d-md-block">
                                    <i class="pe-7s-like"></i>
                                </span>
                            @endif

                            <a href="javascript:void(0)" class="header-action-btn header-action-btn-cart">
                                <i class="pe-7s-shopbag"></i>
                                <span style="position: absolute; top:-4 "
                                    class="header-action-num">{{ $uniqueVariantCount }}</span>
                            </a>

                            <a href="javascript:void(0)"
                                class="header-action-btn header-action-btn-menu d-xl-none d-lg-block">
                                <i class="fa fa-bars"></i>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="mobile-menu-wrapper">
        <div class="offcanvas-overlay"></div>

        <div class="mobile-menu-inner">

            <div class="offcanvas-btn-close">
                <i class="pe-7s-close"></i>
            </div>

            <div class="mobile-navigation">
                <nav>
                    <ul class="mobile-menu">
                        <li class="has-children">
                            <a href="{{ route('home') }}">Trang chủ</a>

                        </li>
                        <li class="has-children">
                            <a href="/shop">Cửa hàng <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <ul class="sub-menu">
                                @foreach ($clientCategories as $item)
                                <li><a href="{{ route('shops.category', $item->id) }}">{{ $item->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="has-children">
                            <a href="{{ route('blogs.index') }}">Bài viết</a>
                        </li>
                        <li class="has-children">
                            <a href="/support"> Hỗ trợ</a>
                        </li>
                        <li class="has-children">
                            <a href="{{ route('bill.search') }}">Tra cứu</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="mt-auto">

                <ul class="contact-links">
                    <li><i class="fa fa-phone"></i><a href="#"> 0376900771</a></li>
                    <li><i class="fa fa-envelope-o"></i><a href="#"> fashionwave@gmail.com</a></li>
                    <li><i class="fa fa-clock-o"></i> <span>Thứ Hai - Chủ Nhật 9h00 - 18h00</span> </li>
                </ul>

                <div class="widget-social">
                    <a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                    <a title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                    <a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                    <a title="Youtube" href="#"><i class="fa fa-youtube"></i></a>
                    <a title="Vimeo" href="#"><i class="fa fa-vimeo"></i></a>
                </div>

            </div>

        </div>

    </div>

    <div class="offcanvas-search">
        <div class="offcanvas-search-inner">

            <div class="offcanvas-btn-close">
                <i class="pe-7s-close"></i>
            </div>

            <form class="offcanvas-search-form" action="#">
                <input type="text" placeholder="Tìm Kiếm..." class="offcanvas-search-input">
            </form>

        </div>
    </div>

    <div class="cart-offcanvas-wrapper">
        <div class="offcanvas-overlay"></div>

        <div class="cart-offcanvas-inner">

            <div class="offcanvas-btn-close">
                <i class="pe-7s-close"></i>
            </div>

            <div class="offcanvas-cart-content">

                <h2 class="offcanvas-cart-title mb-5">Giỏ hàng</h2>

                @if (!empty($processedItems))
                    @foreach ($processedItems as $item)
                        <div id="cart-{{ $item->id }}" class="cart-product-wrapper mb-2">

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
                                        <span
                                            class="new">{{ number_format($item->productVariant->price_sale, 0, ',', '.') . ' đ' }}</span>
                                    </span>
                                </div>
                            </div>

                            <div class="cart-product-remove">
                                <span class="deleteCart" data-id="{{ $item->id }}"><i class="fa fa-trash"
                                        style="font-size: 1.3rem;"></i></span>
                            </div>

                        </div>
                    @endforeach
                @else
                    <p>Giỏ hàng của bạn hiện đang trống.</p>
                @endif
                <div class="cartNull" style="text-align: center"></div>

                <div class="cart-product-btn mt-4">
                    <a href="{{ route('cart.index') }}" class="btn btn-dark btn-hover-primary rounded-0 w-100">Giỏ
                        hàng</a>
                </div>

            </div>

        </div>

    </div>

</div>
