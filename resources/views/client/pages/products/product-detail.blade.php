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
                                            title="{{$variant->color->name}}"
                                            data-min="{{ $product->min_price_sale }}"
                                            style="background-color: {{ $variant->color->hex_code }}"
                                            onclick="HT.selectColor(this, '{{ $variant->color->hex_code }}')" title="{{ $variant->color->name }}">
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
                                        <input class="cart-plus-minus-box quatity_detail_shop" value="1" type="text" min="1">
                                        <div class="dec qtybutton"></div>
                                        <div class="inc qtybutton"></div>
                                    </div>
                                </div>



                                <div class="cart-wishlist-btn mb-4">
                                    <div class="addDeatil" style="margin-right: 0.8rem">
                                        <button class="btn btn-outline-dark btn-hover-primary">
                                            Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                    <div class="add-to-wishlist">
                                        <button class="btn btn-outline-dark btn-hover-primary favorite addFavorite" data-slug="{{$product->slug}}" data-id="{{$product->id}}">
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
                                    href="#connect-1" role="tab" aria-selected="true">Bình luận</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#connect-2"
                                    role="tab" aria-selected="false">Mô tả</a>
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
                            <div class="tab-pane fade show active" id="connect-1" role="tabpanel" aria-labelledby="home-tab">
                                <div class="comment-area-wrapper mt-5 aos-init" data-aos="fade-up" data-aos-delay="400">
                                    <h3 id="comment-title" class="title mb-6">{{ $totalComments }} bình luận</h3>
                                    @foreach ($comments as $item)
                                    <div class="single-comment-wrap">
                                        <a class="author-thumb" href="#">
                                            @if($item->user->avatar)
                                            <img src="{{ Storage::url($item->user->avatar) }}">
                                            @else
                                            <img src="{{ asset('/theme/client/assets/images/logo/avata.jpg') }}">
                                            @endif
                                        </a>
                                        <div class="comments-info">
                                            <div class="comment-footer d-flex justify-content-between">
                                                <span class="author"><a href="#"><strong>{{ $item->user->name }}</strong></a> - {{ $item->created_at->diffForHumans() }}</span>
                                                <a href="javascript:void(0);" class="btn-reply" onclick="showReplyForm({{ $item->id }})"><i class="fa fa-reply"></i> Trả lời</a>
                                            </div>
                                            <p class="mb-1">{{ $item->content }}</p>
                                        </div>
                                    </div>
                                    <div id="reply-form-{{ $item->id }}" class="reply-form d-none comment-box mb-2">
                                        <form class="reply-comment-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="parent_id" value="{{ $item->id }}">
                                            <textarea name="content" class="form-control mb-2" placeholder="Viết câu trả lời..."></textarea>
                                            <button type="submit" class="btn btn-sm btn-primary">Gửi</button>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="hideReplyForm({{ $item->id }})">Hủy</button>
                                        </form>
                                    </div>
                                    @foreach ($item->children as $child)
                                    <div class="single-comment-wrap mb-4 comment-reply">
                                        <a class="author-thumb" href="#">
                                            @if($child->user->avatar)
                                            <img src="{{ Storage::url($child->user->avatar) }}">
                                            @else
                                            <img src="{{ asset('/theme/client/assets/images/logo/avata.jpg') }}">
                                            @endif
                                        </a>
                                        <div class="comments-info">
                                            <div class="comment-footer d-flex justify-content-between">
                                                <span class="author"><a href="#"><strong>{{ $child->user->name }}</strong></a> - {{ $child->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mb-1">{{ $child->content }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endforeach
                                    <div>
                                        {{ $comments->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>

                                <div class="blog-comment-form-wrapper mt-10 aos-init" data-aos="fade-up" data-aos-delay="400">
                                    <div class="blog-comment-form-title">
                                        <h2 class="title">Để lại 1 bình luận</h2>
                                    </div>
                                    <div class="comment-box">
                                        <form id="main-comment-form">
                                            @csrf
                                            <div class="row">
                                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                                <div class="col-12 col-custom">
                                                    <div class="input-item mt-4">
                                                        <textarea cols="30" rows="5" name="content" class="rounded-0 w-100 custom-textarea input-area" placeholder="Bạn muốn viết gì?">{{ old('content') }}</textarea>
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
                            <div class="tab-pane fade" id="connect-2" role="tabpanel" aria-labelledby="profile-tab">

                                <div id="shortDescription" class="desc-content border p-3">
                                    {!! substr($product->description, 0, 200) !!}...
                                    <a href="javascript:void(0);" class="show-more">Xem thêm</a>
                                </div>
                                <div id="fullDescription" style="display:none;" class="desc-content border p-3 ml-2">
                                    {!! $product->description !!}
                                    <a href="javascript:void(0);" class="show-less">Ẩn bớt</a>
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
                                                        <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h5 class="title"><a href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a></h5>
                                            <span class="price">
                                                    <span class="new">{{ $item->min_price_sale == $item->max_price_sale
                                                        ? number_format($item->min_price_sale, 0, ',', '.') . ' đ'
                                                        : number_format($item->min_price_sale, 0, ',', '.') . 'đ - ' . number_format($item->max_price_sale, 0, ',', '.') . ' đ' }}</span>
                                            {{-- <span class="old"></span> --}}
                                            </span>
                                            <button
                                            class="btn btn-sm btn-outline-dark btn-hover-primary showProduct"
                                            data-slug="{{ $item->slug }}"
                                            data-id="{{ $item->id }}" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalCenter">Thêm vào giỏ hàng
                                        </button>
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

<script>
const userLoggedIn = {{ Auth::check() ? 'true' : 'false' }}; // Laravel kiểm tra người dùng

function showReplyForm(commentId) {
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!userLoggedIn) {
        // Nếu chưa đăng nhập, hiển thị thông báo yêu cầu đăng nhập
        swal.fire({
            title: "Vui lòng đăng nhập!",
            text: "Vui lòng đăng nhập để có thể trả lời bình luận.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Đăng nhập",
            cancelButtonText: "Hủy",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu người dùng nhấn "Đăng nhập", điều hướng họ đến trang đăng nhập
                window.location.href = '{{ route('login') }}'; // Chuyển đến trang đăng nhập
            }
        });
        return; // Dừng lại nếu người dùng chưa đăng nhập
    }

    document.querySelectorAll('.reply-form').forEach(form => {
        form.classList.add('d-none');

        const textarea = form.querySelector('textarea');
        if (textarea) {
            textarea.value = '';
        }
    });

    document.getElementById(`reply-form-${commentId}`).classList.remove('d-none');
}

function hideReplyForm(commentId) {
    const form = document.getElementById(`reply-form-${commentId}`);

    // Ẩn form
    form.classList.add('d-none');

    // Xóa nội dung trong textarea
    form.querySelector('textarea').value = '';
}

    // Xử lý bình luận chính
    document.getElementById('main-comment-form').addEventListener('submit', function (e) {
        e.preventDefault();

        if (!userLoggedIn) {
        // Nếu chưa đăng nhập, hiển thị thông báo SweetAlert
        Swal.fire({
            title: 'Vui lòng đăng nhập!',
            text: 'Bạn cần đăng nhập để có thể bình luận.',
            icon: 'warning',
            confirmButtonText: 'Đăng nhập',
            showCancelButton: true,
            cancelButtonText: 'Hủy',
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                // Chuyển hướng đến trang đăng nhập
                window.location.href = '/login'; // Thay đổi theo đường dẫn đăng nhập của bạn
            }
        });
        return; // Dừng việc gửi form nếu người dùng chưa đăng nhập
    }

        const formData = new FormData(this);

        fetch('{{ route("comments.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const avatarUrl = data.comment.user.avatar;
                // Thêm bình luận mới vào danh sách
                const commentHtml = `
                    <div class="single-comment-wrap">
                        <a class="author-thumb" href="#">
                            <img src="${avatarUrl}">
                        </a>
                        <div class="comments-info">
                            <div class="comment-footer d-flex justify-content-between">
                                <span class="author">
                                    <a href="#"><strong>${data.comment.user.name}</strong></a> - ${data.time}
                                </span>
                                <a href="javascript:void(0);" class="btn-reply" onclick="showReplyForm(${data.comment.id})">
                                    <i class="fa fa-reply"></i> Trả lời
                                </a>
                            </div>
                           <p class="mb-1">${data.comment.content}</p>
                        </div>
                    </div>
                    <div id="reply-form-${data.comment.id}" class="reply-form d-none comment-box mb-2">
                        <form class="reply-comment-form">
                            @csrf
                            <input type="hidden" name="product_id" value="${data.product_id}">
                            <input type="hidden" name="parent_id" value="${data.comment.id}">
                            <textarea name="content" class="form-control mb-2" placeholder="Viết câu trả lời..."></textarea>
                            <button type="submit" class="btn btn-sm btn-primary">Gửi</button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="hideReplyForm(${data.comment.id})">Hủy</button>
                        </form>
                    </div>
                `;
                // Chèn bình luận mới dưới tiêu đề bằng ID
                document.getElementById('comment-title').insertAdjacentHTML('afterend', commentHtml);

                // Cập nhật số lượng bình luận nếu cần
                const totalCommentsElement = document.getElementById('comment-title');
                totalCommentsElement.textContent = `${data.total} bình luận`;

                // Xóa nội dung trong form
                this.reset();
            } else {
                if (data.errors) {
                    let errorMessages = '';
                    for (let key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) {
                            errorMessages += `${data.errors[key].join(', ')}\n`;
                        }
                    }
                    swal.fire({
                        title: "Cảnh báo!",
                        text: errorMessages,
                        icon: "warning",
                        confirmButtonText: 'Đóng'
                    });
                } else if (data.message) {
                    swal.fire({
                        title: "Cảnh báo!",
                        text: data.message,
                        icon: "warning",
                        confirmButtonText: 'Đóng'
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi kết nối với máy chủ!');
        });
    });

    // Xử lý trả lời bình luận
    document.addEventListener('submit', function (e) {
        if (e.target.classList.contains('reply-comment-form')) {
            e.preventDefault(); // Ngăn tải lại trang
            const form = e.target;
            const formData = new FormData(form);
            const parentId = formData.get('parent_id');

            fetch('{{ route("comments.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const avatarUrl = data.comment.user.avatar;
                    // Thêm trả lời vào dưới bình luận cha
                    const replyHtml = `
                        <div class="single-comment-wrap mb-4 comment-reply">
                            <a class="author-thumb" href="#">
                                <img src="${avatarUrl}">
                            </a>
                            <div class="comments-info">
                                <div class="comment-footer d-flex justify-content-between">
                                    <span class="author">
                                        <a href="#"><strong>${data.comment.user.name}</strong></a> - ${data.time}
                                    </span>
                                </div>
                                <p class="mb-1">${data.comment.content}</p>
                            </div>
                        </div>
                    `;
                    document.querySelector(`#reply-form-${parentId}`).insertAdjacentHTML('afterend', replyHtml);

                    const totalCommentsElement = document.getElementById('comment-title');
                    totalCommentsElement.textContent = `${data.total} bình luận`;

                    // Ẩn form trả lời
                    hideReplyForm(parentId);
                    form.reset();
                } else {
                    if (data.errors) {
                        let errorMessages = '';
                        for (let key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) {
                                errorMessages += `${data.errors[key].join(', ')}\n`;
                            }
                        }
                        swal.fire({
                            title: "Cảnh báo!",
                            text: errorMessages,
                            icon: "warning",
                            confirmButtonText: 'Đóng'
                        });
                    } else if (data.message) {
                        swal.fire({
                            title: "Cảnh báo!",
                            text: data.message,
                            icon: "warning",
                            confirmButtonText: 'Đóng'
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi kết nối với máy chủ!');
            });
        };
    });
</script>
@endsection
