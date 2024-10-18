@extends('client.index')
@section('style')
    <style>
        .size-buttons {
            display: flex;

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
            font-size: 1.4rem;
            font-weight: 700;
        }

        .price span {
            padding: 0 2px;
        }

        .price {
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>
@endsection
@section('main')
    <div class="section">
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Single Product</h1>
                    <ul>
                        <li>
                            <a href="index.html">Home </a>
                        </li>
                        <li class="active"> Single Product</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 offset-lg-0 col-md-8 offset-md-2 col-custom">
                    <div class="product-details-img">
                        <div
                            class="single-product-img swiper-container gallery-top swiper-container-initialized swiper-container-horizontal">
                            <div class="swiper-wrapper popup-gallery">
                                <!-- Hình ảnh chính của sản phẩm -->
                                <a class="swiper-slide w-100 swiper-slide-active"
                                    href="{{ Storage::url($product->img_thumb) }}" data-swiper-slide-index="0">
                                    <img class="w-100" src="{{ Storage::url($product->img_thumb) }}"
                                        alt="{{ $product->name }}">
                                </a>

                                @foreach ($product->galleries as $gallery)
                                    <a class="swiper-slide w-100" href="{{ Storage::url($gallery->image) }}"
                                        data-swiper-slide-index="{{ $loop->index + 1 }}">
                                        <img class="w-100" src="{{ Storage::url($gallery->image) }}"
                                            alt="{{ $product->name }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div
                            class="single-product-thumb swiper-container gallery-thumbs swiper-container-initialized swiper-container-horizontal swiper-container-free-mode swiper-container-thumbs">
                            <div class="swiper-wrapper">
                                <!-- Thumbnail của hình ảnh chính -->
                                <div
                                    class="swiper-slide swiper-slide-visible swiper-slide-active swiper-slide-thumb-active">
                                    <img src="{{ Storage::url($product->img_thumb) }}" alt="{{ $product->name }}">
                                </div>

                                @foreach ($product->galleries as $gallery)
                                    <div class="swiper-slide">
                                        <img src="{{ Storage::url($gallery->image) }}" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>

                            <div class="swiper-button-horizental-next  swiper-button-next">
                                <i class="pe-7s-angle-right"></i>
                            </div>
                            <div class="swiper-button-horizental-prev swiper-button-prev">
                                <i class="pe-7s-angle-left"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-custom">
                    <div class="product-summery position-relative">

                        <div class="product-head mb-3">
                            <h2 class="product-title">{{ $product->name }}</h2>
                        </div>

                        <div class="price-box mb-2">
                            <span id="product-price-sale-{{ $product->id }}" class="show-price">
                                {{ $product->min_price_sale == $product->max_price_sale
                                    ? number_format($product->min_price_sale) . ' VNĐ'
                                    : number_format($product->min_price_sale) . ' - ' . number_format($product->max_price_sale) . ' VNĐ' }}
                            </span>
                        </div>

                        {{-- số lượng từng biến thể --}}
                        <div class="sku mb-3">
                            <span class="quantity-product" id="quantity-display-{{ $product->id }}"></span>
                        </div>

                        <div class="sku mb-3">
                            <span>Lượt xem: {{ $product->view }}</span>
                        </div>


                        <div class="color-options">
                            <ul class="color-buttons">
                                @foreach ($product->variants->unique('color_id') as $index => $variant)
                                    <li>
                                        <label class="color-btn colorGetSize" data-id="{{ $variant->color->id }}"
                                            data-productId="{{ $product->id }}" data-max="{{ $product->max_price_sale }}"
                                            data-min="{{ $product->min_price_sale }}"
                                            style="background-color: {{ $variant->color->hex_code }}"
                                            onclick="HT.selectColor(this, '{{ $variant->color->hex_code }}')">
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="product" data-product-id="{{ $product->id }}">
                            <div class="product-options">
                                <div class="size-options">
                                    <ul id="sizes-prices-{{ $product->id }}" class="size-buttons">
                                    </ul>
                                </div>

                                <div class="quantity mb-5">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" value="1" type="text" min="1">
                                        <div class="dec qtybutton"></div>
                                        <div class="inc qtybutton"></div>
                                    </div>
                                </div>



                                <div class="cart-wishlist-btn mb-4">
                                    <div class="add-to_cart">
                                        <a class="btn btn-outline-dark btn-hover-primary" href="cart.html">Thêm vào giỏ
                                            hàng</a>
                                    </div>
                                    <div class="add-to-wishlist">
                                        <a class="btn btn-outline-dark btn-hover-primary" href="wishlist.html">Thêm vào
                                            sản phẩm yêu thích
                                        </a>
                                    </div>
                                </div>



                                <!-- Product Delivery Policy Start -->
                                <ul class="product-delivery-policy border-top pt-4 mt-4 border-bottom pb-4">
                                    <li><i class="fa fa-check-square"></i><span>Chính sách bảo mật - Bảo vệ thông tin khách hàng</span></li>
                                    <li><i class="fa fa-truck"></i><span>Chính sách giao hàng - Nhanh chóng, tiện lợi</span></li>
                                    <li><i class="fa fa-refresh"></i><span>Chính sách đổi trả - Đảm bảo quyền lợi khách hàng</span></li>
                                    <li><i class="fa fa-credit-card"></i><span>Chính sách thanh toán - Linh hoạt, an toàn</span></li>
                                    <li><i class="fa fa-headphones"></i><span>Hỗ trợ khách hàng - Tư vấn 24/7</span></li>
                                </ul>


                                <!-- Product Delivery Policy End -->

                            </div>
                            <!-- Product Summery End -->

                        </div>
                    </div>
                </div>

                <div class="row section-margin">
                    <!-- Single Product Tab Start -->
                    <div class="col-lg-12 col-custom single-product-tab">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab"
                                    href="#connect-1" role="tab" aria-selected="true">Mô tả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab"
                                    href="#connect-2" role="tab" aria-selected="false">Đánh giá</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab"
                                    href="#connect-3" role="tab" aria-selected="false">Chính Sách Giao Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase" id="review-tab" data-bs-toggle="tab"
                                    href="#connect-4" role="tab" aria-selected="false">Bảng kích thước</a>
                            </li>
                        </ul>
                        <div class="tab-content mb-text" id="myTabContent">
                            <div class="tab-pane fade show active" id="connect-1" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div id="shortDescription" class="desc-content border p-3">
                                    {!! substr($product->description, 0, 200) !!}...
                                    <a href="javascript:void(0);" class="show-more">Xem thêm</a>
                                </div>
                                <div id="fullDescription" style="display:none;" class="ml-2">
                                    {!! $product->description !!}
                                    <a href="javascript:void(0);" class="show-less">Ẩn bớt</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="connect-2" role="tabpanel" aria-labelledby="profile-tab">
                                <!-- Start Single Content -->
                                <div class="product_tab_content  border p-3">
                                    <!-- Start Single Review -->
                                    <div class="single-review d-flex mb-4">

                                        <!-- Review Thumb Start -->
                                        <div class="review_thumb">
                                            <img alt="review images"
                                                src="{{ asset('theme/client/assets/images/review/1.jpg') }}">
                                        </div>
                                        <!-- Review Thumb End -->

                                        <!-- Review Details Start -->
                                        <div class="review_details">
                                            <div class="review_info mb-2">


                                                <!-- Review Title & Date Start -->
                                                <div class="review-title-date d-flex">
                                                    <h5 class="title">Admin - </h5><span> January 19, 2023</span>
                                                </div>
                                                <!-- Review Title & Date End -->

                                            </div>
                                            <p>Nội dung bình luận</p>
                                        </div>
                                        <!-- Review Details End -->

                                    </div>
                                    <!-- End Single Review -->

                                    <!-- Rating Wrap Start -->
                                    <div class="rating_wrap">
                                        <h5 class="rating-title mb-2">Thêm bình luận</h5>
                                        <p class="mb-2">Địa chỉ email của bạn sẽ không được công bố. Các trường quan
                                            trọng được đánh dấu
                                            <span style="color: red">*</span>
                                        </p>
                                        <h6 class="rating-sub-title mb-2">Đánh giá của bạn</h6>



                                    </div>
                                    <!-- Rating Wrap End -->

                                    <!-- Comments ans Replay Start -->
                                    <div class="comments-area comments-reply-area">
                                        <div class="row">
                                            <div class="col-lg-12 col-custom">

                                                <!-- Comment form Start -->
                                                <form action="#" class="comment-form-area">
                                                    @if (!Auth::user())
                                                        <div class="row comment-input">
                                                            <div class="col-md-6 col-custom comment-form-author mb-3">
                                                                <label>Name <span style="color: red"
                                                                        class="required">*</span></label>
                                                                <input type="text" required="required" name="name">
                                                            </div>

                                                            <div class="col-md-6 col-custom comment-form-email mb-3">
                                                                <label>Email<span style="color: red"
                                                                        class="required">*</span></label>
                                                                <input type="email" required="required" name="email">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="row comment-input">
                                                            <div class="col-md-6 col-custom comment-form-author mb-3">
                                                                {{-- <label>Name: <strong>{{ Auth::user()->name }}</strong></label> --}}
                                                                <input type="hidden" name="name"
                                                                    value="{{ Auth::user()->name }}">
                                                            </div>

                                                            <div class="col-md-6 col-custom comment-form-email mb-3">
                                                                {{-- <label>Email: <strong>{{ Auth::user()->email }}</strong></label> --}}
                                                                <input type="hidden" name="email"
                                                                    value="{{ Auth::user()->email }}">
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Comment Texarea Start -->
                                                    <div class="comment-form-comment mb-3">
                                                        <label>Bình luận <span style="color: red">*</span></label>
                                                        <textarea class="comment-notes" required="required"></textarea>
                                                    </div>
                                                    <!-- Comment Texarea End -->

                                                    <!-- Comment Submit Button Start -->
                                                    <div class="comment-form-submit">
                                                        <button class="btn btn-dark btn-hover-primary">Gửi</button>
                                                    </div>
                                                    <!-- Comment Submit Button End -->

                                                </form>
                                                <!-- Comment form End -->

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Comments ans Replay End -->

                                </div>
                                <!-- End Single Content -->
                            </div>
                            <div class="tab-pane fade" id="connect-3" role="tabpanel" aria-labelledby="contact-tab">
                                <!-- Chính Sách Giao Hàng Bắt Đầu -->
                                <div class="shipping-policy mb-n2">
                                    <h4 class="title-3 mb-4">Chính Sách Giao Hàng Của Chúng Tôi</h4>

                                    <ul class="policy-list mb-2">
                                        <li>Thời gian giao hàng: **1-2 ngày làm việc** (Thường sẽ hoàn thành vào cuối
                                            ngày)</li>
                                        <li><a href="#">Cam kết hoàn tiền trong vòng 30 ngày</a></li>
                                        <li>Hỗ trợ khách hàng trực tuyến 24/7</li>
                                        <li>Chúng tôi cam kết mang đến cho bạn trải nghiệm mua sắm tốt nhất.</li>
                                        <li>Đội ngũ hỗ trợ luôn sẵn sàng giúp đỡ bạn trong mọi tình huống khó khăn.</li>
                                        <li>Mỗi khách hàng đều xứng đáng nhận được sự chăm sóc và hỗ trợ tận tâm từ
                                            chúng tôi.</li>
                                    </ul>

                                    <p class="desc-content mb-2">
                                        Chúng tôi cung cấp nhiều lựa chọn linh hoạt để đáp ứng nhu cầu của bạn. Mọi sản
                                        phẩm và dịch vụ đều được kiểm tra kỹ lưỡng nhằm đảm bảo chất lượng và độ tin
                                        cậy.
                                    </p>

                                    <p class="desc-content mb-2">
                                        Sự minh bạch trong quy trình và cam kết chất lượng là những tiêu chí hàng đầu mà
                                        chúng tôi hướng tới. Chúng tôi luôn nỗ lực không ngừng để đáp ứng và vượt qua
                                        mong đợi của bạn.
                                    </p>

                                    <p class="desc-content mb-2">
                                        Với thiết kế tinh tế và tính năng tiện ích, chúng tôi tự tin rằng bạn sẽ tìm
                                        thấy những sản phẩm phù hợp với nhu cầu của mình.
                                    </p>

                                    <p class="desc-content mb-2">
                                        Hãy cùng chúng tôi khám phá những điều tuyệt vời đang chờ đón bạn!
                                    </p>
                                </div>
                                <!-- Chính Sách Giao Hàng Kết Thúc -->
                            </div>

                            <div class="tab-pane fade" id="connect-4" role="tabpanel" aria-labelledby="review-tab">
                                <div class="size-tab table-responsive-lg">
                                    <h4 class="title-3 mb-4">Bảng kích thước</h4>
                                    <table class="table border mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="cun-name"><span>UK</span></td>
                                                <td>18</td>
                                                <td>20</td>
                                                <td>22</td>
                                                <td>24</td>
                                                <td>26</td>
                                            </tr>
                                            <tr>
                                                <td class="cun-name"><span>European</span></td>
                                                <td>46</td>
                                                <td>48</td>
                                                <td>50</td>
                                                <td>52</td>
                                                <td>54</td>
                                            </tr>
                                            <tr>
                                                <td class="cun-name"><span>usa</span></td>
                                                <td>14</td>
                                                <td>16</td>
                                                <td>18</td>
                                                <td>20</td>
                                                <td>22</td>
                                            </tr>
                                            <tr>
                                                <td class="cun-name"><span>Australia</span></td>
                                                <td>28</td>
                                                <td>10</td>
                                                <td>12</td>
                                                <td>14</td>
                                                <td>16</td>
                                            </tr>
                                            <tr>
                                                <td class="cun-name"><span>Canada</span></td>
                                                <td>24</td>
                                                <td>18</td>
                                                <td>14</td>
                                                <td>42</td>
                                                <td>36</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Product Tab End -->
                </div>


            </div>
            <!-- Products Start -->
            <div class="row">

                <div class="col-12">
                    <!-- Section Title Start -->
                    <div class="section-title aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="title pb-3">Sản phẩm liên quan</h2>
                        <span></span>
                        <div class="title-border-bottom"></div>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col">
                    <div class="product-carousel">

                        <div class="swiper-container">
                            <div class="swiper-wrapper">

                                <!-- Product Start -->
                                <div class="swiper-slide product-wrapper">

                                    <!-- Single Product Start -->
                                    <div class="product product-border-left" data-aos="fade-up" data-aos-delay="300">
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img class="first-image" src="assets/images/products/medium-size/1.jpg" alt="Product" />
                                                <img class="second-image" src="assets/images/products/medium-size/5.jpg" alt="Product" />
                                            </a>
                                            <div class="actions">
                                                <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="sub-title"><a href="single-product.html">Studio Design</a></h4>
                                            <h5 class="title"><a href="single-product.html">Brother Hoddies in Grey</a></h5>
                                            <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                            </span>
                                            <span class="rating-num">(4)</span>
                                            </span>
                                            <span class="price">
                                                    <span class="new">$38.50</span>
                                            <span class="old">$42.85</span>
                                            </span>
                                            <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To Cart</button>
                                        </div>
                                    </div>
                                    <!-- Single Product End -->

                                </div>
                                <!-- Product End -->

                                <!-- Product Start -->
                                <div class="swiper-slide product-wrapper">

                                    <!-- Single Product Start -->
                                    <div class="product product-border-left" data-aos="fade-up" data-aos-delay="400">
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img class="first-image" src="assets/images/products/medium-size/4.jpg" alt="Product" />
                                                <img class="second-image" src="assets/images/products/medium-size/10.jpg" alt="Product" />
                                            </a>
                                            <span class="badges">
                                                    <span class="sale">New</span>
                                            </span>
                                            <div class="actions">
                                                <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="sub-title"><a href="single-product.html">Studio Design</a></h4>
                                            <h5 class="title"><a href="single-product.html">Simple Woven Fabrics</a></h5>
                                            <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 67%"></span>
                                            </span>
                                            <span class="rating-num">(2)</span>
                                            </span>
                                            <span class="price">
                                                    <span class="new">$45.50</span>
                                            <span class="old">$48.85</span>
                                            </span>
                                            <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To Cart</button>
                                        </div>
                                    </div>
                                    <!-- Single Product End -->

                                </div>
                                <!-- Product End -->

                            </div>

                            <!-- Swiper Pagination Start -->
                            <div class="swiper-pagination d-md-none"></div>
                            <!-- Swiper Pagination End -->

                            <!-- Next Previous Button Start -->
                            <div class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none"><i class="pe-7s-angle-right"></i></div>
                            <div class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none"><i class="pe-7s-angle-left"></i></div>
                            <!-- Next Previous Button End -->

                        </div>

                    </div>
                </div>

            </div>
            <!-- Products End -->

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/js/getsizedetail.js') }}"></script>
@endsection
