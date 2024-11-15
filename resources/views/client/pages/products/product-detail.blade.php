@extends('client.index')
@section('style')
    <style>
        .desc-content img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
@endsection
@section('main')
    <div class="section">
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Chi tiết sản phẩm</h1>
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ </a>
                        </li>
                        <li class="active"> Chi tiết sản phẩm</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-margin">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-5 offset-lg-0 col-md-8 offset-md-2 col-custom" >
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
                    <div class="product-summery position-relative" data-aos="fade-up" data-aos-delay="200">

                        <div class="product-head mb-3" >
                            <h2 class="product-title">{{ $product->name }}</h2>
                        </div>

                        <div></div>
                        <div class="price-box mb-2">
                            <span id="product-price-sale-{{ $product->id }}" class="show-price">
                            </span>
                            <span style="text-decoration: line-through;font-size: 1.0rem;font-weight: 500" id="old-price"></span>
                        </div>

                         <div class="sku mb-3">
                            <span class="quantity-product" id="quantity-display-{{ $product->id }}">Số lượng: </span>
                        </div>


                        <div class="sku mb-3">
                            <span>Lượt xem: {{ $product->view }}</span>
                        </div>


                        <div class="color-options">
                            <ul class="color-buttons">
                                @foreach ($product->variants->unique('color_id') as $index => $variant)
                                    <li>
                                        <label class="color-btn colorGetSize {{ $index === 0 ? 'selected' : '' }}" data-id="{{ $variant->color->id }}"
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
                                        <button class="btn btn-outline-dark btn-hover-primary">
                                            Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                    <div class="add-to-wishlist">
                                        <button class="btn btn-outline-dark btn-hover-primary favorite">
                                            Thêm vào sản phẩm yêu thích
                                        </button>
                                    </div>
                                </div>



                                <!-- Product Delivery Policy Start -->
                                <ul class="product-delivery-policy border-top pt-4 mt-4 border-bottom pb-4">
                                    <li><i class="fa fa-check-square"></i><span>Chính sách bảo mật - Bảo vệ thông tin khách
                                            hàng</span></li>
                                    <li><i class="fa fa-truck"></i><span>Chính sách giao hàng - Nhanh chóng, tiện lợi</span>
                                    </li>
                                    <li><i class="fa fa-refresh"></i><span>Chính sách đổi trả - Đảm bảo quyền lợi khách
                                            hàng</span></li>
                                    <li><i class="fa fa-credit-card"></i><span>Chính sách thanh toán - Linh hoạt, an
                                            toàn</span></li>
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
                                <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#connect-2"
                                    role="tab" aria-selected="false">Bình luận</a>
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
                                <div id="fullDescription" style="display:none;" class="desc-content border p-3 ml-2">
                                    {!! $product->description !!}
                                    <a href="javascript:void(0);" class="show-less">Ẩn bớt</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="connect-2" role="tabpanel" aria-labelledby="profile-tab">


                                {{-- Bình luận cũ --}}
                                {{-- <div class="product_tab_content  border p-3">
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
                                                                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                                            </div>

                                                            <div class="col-md-6 col-custom comment-form-email mb-3">
                                                                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
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

                                </div> --}}

                                {{-- Bình luận mới --}}
                                <div class="comment-area-wrapper mt-5 aos-init" data-aos="fade-up" data-aos-delay="400">
                                    <h3 class="title mb-6">5 Comments</h3>
                                    <div class="single-comment-wrap mb-10">
                                        <a class="author-thumb" href="#">
                                            <img
                                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmhF7UB6jv1t_oyGDzqSb_h0JPspDnfqohVA&sr">
                                        </a>
                                        <div class="comments-info">
                                            <div class="comment-footer d-flex justify-content-between">
                                                <span class="author"><a href="#"><strong>Duy</strong></a> - July 30, 2023</span>
                                                <a href="#" class="btn-reply"><i class="fa fa-reply"></i> Reply</a>
                                            </div>
                                            <p class="mb-1">Bình luận 1</p>
                                        </div>
                                    </div>
                                    <div class="single-comment-wrap mb-10 comment-reply">
                                        <a class="author-thumb" href="#">
                                            <img
                                                src="https://tse1.mm.bing.net/th?id=OIP.KdRE7KHqL-46M8nrvOX2CgHaHa&pid=Api&P=0&h=220">
                                        </a>
                                        <div class="comments-info">
                                            <div class="comment-footer d-flex justify-content-between">
                                                <span class="author"><a href="#"><strong>Alex</strong></a> - August 30,
                                                    2023</span>
                                            </div>
                                            <p class="mb-1">Trả lời bình luận 1</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="blog-comment-form-wrapper mt-10 aos-init" data-aos="fade-up" data-aos-delay="400">
                                    <div class="blog-comment-form-title">
                                        <h2 class="title">Để lại 1 bình luận</h2>
                                    </div>
                                    <div class="comment-box">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-12 col-custom">
                                                    <div class="input-item mt-4">
                                                        <textarea cols="30" rows="5" name="comment" class="rounded-0 w-100 custom-textarea input-area"
                                                            placeholder="Bình luận"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-custom">
                                                    <div class="input-item mb-4">
                                                        <input class="rounded-0 w-100 input-area name" type="hidden"
                                                            placeholder="Name" fdprocessedid="rg7vs">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-custom">
                                                    <div class="input-item">
                                                        <input class="rounded-0 w-100 input-area email" type="hidden"
                                                            placeholder="Email" fdprocessedid="7z5f7l">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-custom">
                                                    <button type="submit" class="btn btn-primary btn-hover-dark"
                                                        fdprocessedid="iu5i8">Bình luận</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane fade" id="connect-3" role="tabpanel" aria-labelledby="contact-tab">
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

                                @foreach($relatedProducts as $key => $item)
                                <!-- Product Start -->
                                <div class="swiper-slide product-wrapper">

                                    <!-- Single Product Start -->
                                    <div class="product product-border-left" data-aos="fade-up" data-aos-delay="{{ 300 + ($key * 100) }}">
                                        <div class="thumb">
                                            <a href="{{ route('shops.show', $item->slug) }}" class="image">
                                                <img class="first-image" src="{{ Storage::url($item->img_thumb) }}" alt="Product" />
                                                <img class="second-image" src="{{ Storage::url($item->first_image) }}" alt="Product" />
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
                                            <h5 class="title"><a href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a></h5>
                                            <span class="price">
                                                    <span class="new">{{ number_format($item->min_price_sale, 0, ',', '.') }}đ - {{ number_format($item->max_price_sale, 0, ',', '.') }}đ</span>
                                            {{-- <span class="old"></span> --}}
                                            </span>
                                            <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To Cart</button>
                                        </div>
                                    </div>
                                    <!-- Single Product End -->

                                </div>
                                <!-- Product End -->
                                @endforeach

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
