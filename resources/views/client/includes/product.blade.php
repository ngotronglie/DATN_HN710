<div class="section section-padding mt-0">
    <div class="container">
        <!-- Section Title & Tab Start -->
        <div class="row">
            <!-- Tab Start -->
            <div class="col-12">
                <ul class="product-tab-nav nav justify-content-center mb-10 title-border-bottom mt-n3">
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="300"><a class="nav-link active mt-3"
                            data-bs-toggle="tab" href="#tab-product-all">Sản phẩm mới</a></li>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="400"><a class="nav-link mt-3"
                            data-bs-toggle="tab" href="#tab-product-clothings">Sản phẩm hot</a></li>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="500"><a class="nav-link mt-3"
                            data-bs-toggle="tab" href="#tab-product-best-sellers">Bán chạy</a></li>
                </ul>
            </div>
            <!-- Tab End -->
        </div>
        <!-- Section Title & Tab End -->

        <!-- Products Tab Start -->
        <div class="row">
            <div class="col">
                <div class="tab-content position-relative">
                    <div class="tab-pane fade show active" id="tab-product-all">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper mb-n10">
                                    @foreach ($newProducts->chunk(2) as $chunk)
                                        <!-- Product Start -->
                                        <div class="swiper-slide product-wrapper">
                                            @foreach ($chunk as $item)
                                                <!-- Single Product Start -->
                                                <div class="product product-border-left mb-10" data-aos="fade-up"
                                                    data-aos-delay="300">
                                                    <div class="thumb">
                                                        <a href="{{ route('shops.show', $item->slug) }}" class="image">
                                                            <img class="first-image"
                                                                src="{{ Storage::url($item->img_thumb) }}"
                                                                alt="Product" />
                                                            <img class="second-image"
                                                                src="{{ Storage::url($item->first_image) }}"
                                                                alt="Product" />
                                                        </a>
                                                        <span class="badges">
                                                            <span class="sale">Mới</span>
                                                        </span>
                                                        <div class="actions">
                                                            <span class="action addFavorite"
                                                                data-slug="{{ $item->slug }}"
                                                                data-id="{{ $item->id }}">
                                                                <i class="pe-7s-like"></i>
                                                            </span>
                                                            {{-- <span title="Wishlist addFavorite" data-id="{{ $item->id }}"
                                                                id="favorite-{{ $item->id }}"
                                                                class="action favorite wishlist">
                                                                <i class="pe-7s-like"></i></span> --}}
                                                            <span class="action quickview showProduct"
                                                                data-slug="{{ $item->slug }}"
                                                                data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModalCenter">
                                                                <i class="pe-7s-search"></i>
                                                            </span>
                                                            <a href="#" class="action compare"><i
                                                                    class="pe-7s-shuffle"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <h5 class="title"><a
                                                                href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}ss</a>
                                                        </h5>
                                                        <span class="price">
                                                            <span
                                                                class="new">{{ $item->min_price_sale == $item->max_price_sale
                                                                    ? number_format($item->min_price_sale) . 'đ'
                                                                    : number_format($item->min_price_sale) . 'đ' . ' - ' . number_format($item->max_price_sale) . 'đ' }}</span>
                                                            {{-- <span class="old"></span> --}}
                                                        </span>
                                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary showProduct"
                                                        data-slug="{{ $item->slug }}"
                                                        data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter">Thêm vào giỏ hàng
                                                    </button>
                                                    </div>
                                                </div>
                                                <!-- Single Product End -->
                                            @endforeach

                                        </div>
                                        <!-- Product End -->
                                    @endforeach

                                </div>

                                <!-- Swiper Pagination Start -->
                                <div class="swiper-pagination d-md-none"></div>
                                <!-- Swiper Pagination End -->

                                <!-- Next Previous Button Start -->
                                <div
                                    class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-right"></i>
                                </div>
                                <div
                                    class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-left"></i>
                                </div>
                                <!-- Next Previous Button End -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-product-clothings">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper mb-n10">

                                    @foreach ($productViews->chunk(2) as $chunk)
                                        <!-- Product Start -->
                                        <div class="swiper-slide product-wrapper">
                                            @foreach ($chunk as $item)
                                                <!-- Single Product Start -->
                                                <div class="product product-border-left mb-10">
                                                    <div class="thumb">
                                                        <a href="{{ route('shops.show', $item->slug) }}"
                                                            class="image">
                                                            <img class="first-image"
                                                                src="{{ Storage::url($item->img_thumb) }}"
                                                                alt="Product" />
                                                            <img class="second-image"
                                                                src="{{ Storage::url($item->first_image) }}"
                                                                alt="Product" />
                                                        </a>
                                                        <span class="badges">
                                                            <span class="sale">Sold</span>
                                                        </span>
                                                        <div class="actions">
                                                            <span class="action addFavorite"
                                                                data-slug="{{ $item->slug }}"
                                                                data-id="{{ $item->id }}">
                                                                <i class="pe-7s-like"></i>
                                                            </span>
                                                            <span class="action quickview showProduct"
                                                                data-slug="{{ $item->slug }}"
                                                                data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModalCenter">
                                                                <i class="pe-7s-search"></i>
                                                            </span>
                                                            <a href="#" class="action compare"><i
                                                                    class="pe-7s-shuffle"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <h5 class="title"><a
                                                                href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a>
                                                        </h5>
                                                        <span class="price">
                                                            <span
                                                                class="new">{{ number_format($item->min_price_sale, 0, ',', '.') }}đ
                                                                -
                                                                {{ number_format($item->max_price_sale, 0, ',', '.') }}đ</span>
                                                            {{-- <span class="old"></span> --}}
                                                        </span>
                                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary showProduct"
                                                        data-slug="{{ $item->slug }}"
                                                        data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter">Thêm vào giỏ hàng
                                                    </button>

                                                    </div>
                                                </div>
                                                <!-- Single Product End -->
                                            @endforeach

                                        </div>
                                        <!-- Product End -->
                                    @endforeach

                                </div>

                                <!-- Swiper Pagination Start -->
                                <div class="swiper-pagination d-md-none"></div>
                                <!-- Swiper Pagination End -->

                                <!-- Next Previous Button Start -->
                                <div
                                    class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-right"></i>
                                </div>
                                <div
                                    class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-left"></i>
                                </div>
                                <!-- Next Previous Button End -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-product-best-sellers">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper mb-n10">

                                    @foreach ($bestSellingProducts->chunk(2) as $chunk)
                                        <!-- Product Start -->
                                        <div class="swiper-slide product-wrapper">
                                            @foreach ($chunk as $item)
                                                <!-- Single Product Start -->
                                                <div class="product product-border-left mb-10">
                                                    <div class="thumb">
                                                        <a href="{{ route('shops.show', $item->slug) }}"
                                                            class="image">
                                                            <img class="first-image"
                                                                src="{{ Storage::url($item->img_thumb) }}"
                                                                alt="Product" />
                                                            <img class="second-image"
                                                                src="{{ Storage::url($item->first_image) }}"
                                                                alt="Product" />
                                                        </a>
                                                        <span class="badges">
                                                            <span class="sale">New</span>
                                                        </span>
                                                        <div class="actions">
                                                            <span class="action addFavorite"
                                                                data-slug="{{ $item->slug }}"
                                                                data-id="{{ $item->id }}">
                                                                <i class="pe-7s-like"></i>
                                                            </span>
                                                            <span class="action quickview showProduct"
                                                                data-slug="{{ $item->slug }}"
                                                                data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModalCenter">
                                                                <i
                                                                    class="pe-7s-search"></i>
                                                            </span>
                                                            <a href="#" class="action compare"><i
                                                                    class="pe-7s-shuffle"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <h5 class="title"><a
                                                                href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a>
                                                        </h5>
                                                        <span class="price">
                                                            <span
                                                                class="new">{{ number_format($item->min_price_sale, 0, ',', '.') }}đ
                                                                -
                                                                {{ number_format($item->max_price_sale, 0, ',', '.') }}đ</span>
                                                            <span class="old"></span>
                                                        </span>
                                                        <button
                                                            class="btn btn-sm btn-outline-dark addCartPro btn-hover-primary"
                                                            data-slug="{{ $item->slug }}"
                                                            data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalCenter">Thêm vào giỏ
                                                            hàng</button>

                                                    </div>
                                                </div>
                                                <!-- Single Product End -->
                                            @endforeach

                                        </div>
                                        <!-- Product End -->
                                    @endforeach

                                </div>

                                <!-- Swiper Pagination Start -->
                                <div class="swiper-pagination d-md-none"></div>
                                <!-- Swiper Pagination End -->

                                <!-- Next Previous Button Start -->
                                <div
                                    class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-right"></i>
                                </div>
                                <div
                                    class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-left"></i>
                                </div>
                                <!-- Next Previous Button End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Products Tab End -->
    </div>
</div>

@section('script')
    <script src="{{ asset('plugins/js/addCartAndDetaiPrd.js') }}"></script>
@endsection
