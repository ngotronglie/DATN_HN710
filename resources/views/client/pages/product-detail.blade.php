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

    .reply-box {
        display: none;
        margin-top: 10px;
        margin-left: 20px;
        margin-bottom: 20px;
        /* Để các comment trả lời cách nhau */
    }

    .author-thumb img {
        width: 30px;
        /* Kích thước ảnh nhỏ */
        height: 60px;
        /* border-radius: 100%; */
        /* Bo tròn ảnh */
        object-fit: cover;
        /* Giữ tỉ lệ hình ảnh */
        margin-right: 20px
            /* Dãn cách giữa các ảnh */
    }

    /* .active-form {
        display: block;
    } */
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
                                <img class="w-100" src="{{ Storage::url($gallery->image) }}" alt="{{ $product->name }}">
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
                                <label class="color-btn colorGetSize {{ $index === 0 ? 'selected' : '' }}"
                                    data-id="{{ $variant->color->id }}" data-productId="{{ $product->id }}"
                                    data-max="{{ $product->max_price_sale }}" data-min="{{ $product->min_price_sale }}"
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
                                role="tab" aria-selected="false">Bình Luận</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#connect-3"
                                role="tab" aria-selected="false">Chính Sách Giao Hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="review-tab" data-bs-toggle="tab" href="#connect-4"
                                role="tab" aria-selected="false">Bảng kích thước</a>
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

                        <div class="tab-pane fade show active" id="connect-2" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="comment-area-wrapper mt-5 aos-init" data-aos="fade-up" data-aos-delay="400">
                                <h3 class="title mb-6">5 Comments</h3>

                                @foreach ($comments as $comment)
                                <div class="single-comment-wrap mb-3" id="comment-{{$comment->id}}">
                                    <a class="author-thumb" href="#">
                                        <img src=" {{Storage::url(path: $comment->user->avatar)  }}"
                                            class=" rounded-circle" width="5px" alt="User Avatar" accept="image/*">
                                    </a>
                                    <div class="comments-info">
                                        <p>
                                        <p class="mb-1">{{$comment->content}}</p>
                                        </p>

                                        <div class="comment-footer d-flex justify-content-between">
                                            <span class="author"><a
                                                    href="#"><strong>{{$comment->user->name}}</strong></a>

                                                {{$comment->created_at->diffForHumans()}}
                                            </span>
                                            <button style="background-color: transparent; border:none; "
                                                data-id="{{$comment->id}}" data-user="{{$comment->user_id}}"
                                                id="replyBtn-{{$comment->id}}" class="btn-reply">
                                                <i class="fa fa-reply"></i> Reply
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vùng chèn textarea trả lời -->
                                <form id="replyBox-{{$comment->id}}" class="reply-box active-form"
                                    action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="parent_id" class="parent-id-field"
                                        id="parent-id-{{$comment->id}}">
                                    <textarea cols="30" rows="3" class="w-100 mt-2" placeholder="Your reply"
                                        id="box-reply-{{$comment->id}}" name="content"></textarea>
                                    <button type="submit" class="btn btn-primary btn-hover-dark mt-2">Submit
                                        Reply</button>
                                </form>

                                @if($comment->children != null)
                                @include('client.pages._comment-child', ['children' => $comment->children])
                                @endif
                                @endforeach

                            </div>

                            <!-- Form bình luận -->
                            @if (auth()->check())
                            <div class="blog-comment-form-wrapper mt-10 aos-init" data-aos="fade-up"
                                data-aos-delay="400">
                                <div class="blog-comment-form-title">
                                    <h2 class="title">Leave a comment</h2>
                                </div>
                                <div class="comment-box">
                                    <form id="commentForm" action="{{ route('comments.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                                            <div class="col-12 col-custom">
                                                <div class="input-item mt-4 mb-4">
                                                    @if(isset($error))
                                                    <script>
                                                        window.alert("{{ $error }}");
                                                    </script>
                                                    @endif


                                                    <input type="hidden" name="parent_id" id="id_parent">
                                                    <textarea cols="30" rows="5" name="content"
                                                        class="rounded-0 w-100 custom-textarea input-area"
                                                        placeholder="Message" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-custom mt-4">
                                                <button type="submit" class="btn btn-primary btn-hover-dark">Post
                                                    comment</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @else
                            <p>bạn cần <a href="{{route('login')}}">Đăng nhập </a> để có thể bình luận</p>
                            @endif
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
                                            <img class="first-image" src="assets/images/products/medium-size/1.jpg"
                                                alt="Product" />
                                            <img class="second-image" src="assets/images/products/medium-size/5.jpg"
                                                alt="Product" />
                                        </a>
                                        <div class="actions">
                                            <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                            <a href="#" class="action quickview" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                            <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title"><a href="single-product.html">Studio Design</a></h4>
                                        <h5 class="title"><a href="single-product.html">Brother Hoddies in Grey</a>
                                        </h5>
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
                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To
                                            Cart</button>
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
                                            <img class="first-image" src="assets/images/products/medium-size/4.jpg"
                                                alt="Product" />
                                            <img class="second-image" src="assets/images/products/medium-size/10.jpg"
                                                alt="Product" />
                                        </a>
                                        <span class="badges">
                                            <span class="sale">New</span>
                                        </span>
                                        <div class="actions">
                                            <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                            <a href="#" class="action quickview" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
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
                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To
                                            Cart</button>
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
                        <div class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none">
                            <i class="pe-7s-angle-right"></i>
                        </div>
                        <div class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none">
                            <i class="pe-7s-angle-left"></i>
                        </div>
                        <!-- Next Previous Button End -->

                    </div>

                </div>
            </div>

        </div>
        <!-- Products End -->

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var replyButtons = document.querySelectorAll('.btn-reply');
    var parentInputId = document.querySelector('#id_parent');

    console.log(parentInputId);

    for (const element of replyButtons) {


        element.addEventListener('click', () => {
            // event.preventDefault();
            console.log(parentInputId);



            let commentId = element.getAttribute('data-id');
            let user_id = element.getAttribute('data-user');
            parentInputId.value =
                commentId;


            $.ajax({
                url: "{{route('comments.user')}}",
                method: 'GET',

                data: {
                    user_id: user_id || '',
                    commentId: commentId || ''
                },

                success: function(data) {
                    console.log(data); // Kiểm tra cấu trúc của data-

                    if (data.comment_id && data.data && data.data.name) {
                        document.querySelector(`#box-reply-${data.comment_id}`).value =
                            `@${data.data.name}`;
                    } else {
                        console.error("Thiếu dữ liệu c");
                    }
                },

                error: function(xhr, error) {
                    console.debug(xhr);
                    console.debug(error);
                },
            })

        });
    }

    // Nếu người dùng muốn thêm bình luận mới thì giữ parent_id rỗng
    var commentForm = document.querySelector('.blog-comment-form-wrapper');
    commentForm.addEventListener('submit', function() {
        parentInputId.value = ''; // Xóa giá trị parent_id nếu không phải là trả lời
    });
</script>
<script>
    $(document).ready(function() {
        // Handle click event on the reply button
        $('.btn-reply').click(function(event) {
            // Prevent the button from submitting the form or reloading the page
            event.preventDefault();

            // Get the comment ID to reply to
            var commentId = $(this).data('id');
            var replyBox = $('#replyBox-' + commentId);

            // Hide all other reply boxes except the current one;
            let parent_Id_box = document.querySelector(`#parent-id-${commentId}`);
            parent_Id_box.value = commentId;
            // Toggle visibility of the current reply box
            replyBox.slideToggle();


            // Debugging output to check if the parent_id is set correctly
            // console.log("Replying to comment ID:", commentId);
            // console.log(parent_Id_box);

        });
    });
</script>



@endsection

@section('script')

<script src="{{ asset('plugins/js/getsizedetail.js') }}"></script>
@endsection