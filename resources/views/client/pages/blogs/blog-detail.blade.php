@extends('client.index')
@section('style')
    <style>
        .hidden-category {
            display: none;
        }

        #toggleCategories {
            text-decoration: underline;
            font-size: 0.8rem;
        }
    </style>
@endsection
@section('main')
    <div class="section">
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Nội dung bài viết</h1>
                    <ul>
                        <li>
                            <a href="/">Trang chủ </a>
                        </li>
                        <li class="active">Nội dung bài viết</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 order-2 order-lg-1">
                    <aside class="sidebar_widget mt-10 mt-lg-0">
                        <div class="widget_inner aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                            <div class="widget-list mb-10">
                                <h3 class="widget-title mb-4">Tìm kiếm</h3>
                                <div class="search-box">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm bài viết"
                                        aria-label="Search Our Store" fdprocessedid="xpyzpc">
                                    <button class="btn btn-dark btn-hover-primary" type="button" fdprocessedid="0a9xx">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="widget-list mb-10">
                                <h3 class="widget-title">Danh mục bài viết</h3>
                                <div class="sidebar-body">
                                    <ul class="sidebar-list" id="categoryList">
                                        @foreach ($categoryBlog as $index => $item)
                                            <li class="{{ $index >= 5 ? 'hidden-category' : '' }}">
                                                <a href="{{ route('blogs.category', $item->id) }}">
                                                    {{ $item->name }} ({{ $item->blogs_count }})
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <p id="toggleCategories" class="mt-3">Xem thêm</p>
                                </div>
                            </div>

                            <div class="widget-list">
                                <h3 class="widget-title mb-4">Top bài viết hot</h3>
                                <div class="sidebar-body product-list-wrapper mb-n6">
                                    @foreach ($hotblogs as $item)
                                        <div class="single-product-list product-hover mb-6">
                                            <div class="thumb">
                                                <a href="{{ route('blogs.show', $item) }}" class="image">
                                                    <img class="first-image" src="{{ Storage::url($item->img_avt) }}"
                                                        alt="Product">
                                                    <img class="second-image" src="{{ Storage::url($item->img_avt) }}"
                                                        alt="Product">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="title mt-4"><a
                                                        href="{{ route('blogs.show', $item) }}">{{ Str::limit(strip_tags($item->content), 36, '...') }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-lg-9 order-1 order-lg-2 overflow-hidden">
                    <div class="blog-details mb-10">
                        <div class="content aos-init" data-aos="fade-up" data-aos-delay="300">
                            <h2 class="title mb-3">{{ $blog->title }}</h2>
                            <div class="meta-list mb-3">
                                <span>Tác giả:
                                    <span style="font-weight: 600;color: black" class="meta-item author mr-1">{{ $blog->user->name }},</span>
                                </span>
                                <span class="meta-item date">{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</span>
                                <span class="meta-item comment"><a href="#">{{ $blog->view }} Lượt xem</a></span>
                                <span class="meta-item comment"><a href="#">03 Bình luận</a></span>
                            </div>
                            <div class="desc content aos-init aos-animate" data-aos="fade-right" data-aos-delay="300">
                                {!! $blog->content !!}
                            </div>
                        </div>
                        <hr>

                      
                    
                    
                        @if($voucher)
                        <div class="voucher-banner" style="margin-top: 30px; background-color: #f1f8e9; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <h4 style="font-weight: bold; color: #2e7d32;">🎉 Khuyến mãi đặc biệt dành cho bạn! 🎉</h4>
                            <div class="voucher-item" style="border: 2px dashed #4caf50; padding: 15px; border-radius: 12px; background-color: #ffffff; width: 280px; margin: 20px auto; text-align: left;">
                                <h5 style="font-weight: bold; text-align: center; color: #2e7d32;">Mã: <span style="color: #d32f2f;">{{ $voucher->code }}</span></h5>
                                <ul style="list-style: none; padding: 0; margin-top: 10px;">
                                    <li style="margin-bottom: 5px;"><strong>Giảm:</strong> {{ $voucher->discount }}%</li>
                                    <li style="margin-bottom: 5px;"><strong>Từ:</strong> {{ number_format($voucher->min_money, 0, ',', '.') }} VNĐ</li>
                                    <li style="margin-bottom: 5px;"><strong>Đến:</strong> {{ number_format($voucher->max_money, 0, ',', '.') }} VNĐ</li>
                                    <li style="margin-bottom: 5px;"><strong>Hạn sử dụng:</strong> {{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</li>
                                </ul>
                                <button class="btn btn-success apply-voucher-btn" style="margin-top: 15px; display: block; width: 100%; font-weight: bold;" data-voucher-code="{{ $voucher->code }}">
                                   Lưu
                                </button>
                            </div>
                        </div>
                    @endif
                                          
                    
                   
                    
                    </div>
                    



                    <div class="comment-area-wrapper mt-5 aos-init" data-aos="fade-up" data-aos-delay="400">
                        <h3 class="title mb-6">5 Bình luận</h3>
                        <div class="single-comment-wrap mb-10">
                            <a class="author-thumb" href="#">
                                <img
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmhF7UB6jv1t_oyGDzqSb_h0JPspDnfqohVA&sr">
                            </a>
                            <div class="comments-info">
                                <p class="mb-1">Bình luận 1.</p>
                                <div class="comment-footer d-flex justify-content-between">
                                    <span class="author"><a href="#"><strong>Duy</strong></a> - July 30, 2023</span>
                                    <a href="#" class="btn-reply"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                            </div>
                        </div>
                        <div class="single-comment-wrap mb-10 comment-reply">
                            <a class="author-thumb" href="#">
                                <img
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmhF7UB6jv1t_oyGDzqSb_h0JPspDnfqohVA&sr">
                            </a>
                            <div class="comments-info">
                                <p class="mb-1">Trả lời bình luận 1.</p>
                                <div class="comment-footer d-flex justify-content-between">
                                    <span class="author"><a href="#"><strong>Alex</strong></a> - August 30,
                                        2023</span>
                                </div>
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
                                        <div class="input-item mt-4 mb-4">
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
                                        <div class="input-item mb-4">
                                            <input class="rounded-0 w-100 input-area email" type="hidden"
                                                placeholder="Email" fdprocessedid="7z5f7l">
                                        </div>
                                    </div>
                                    <div class="col-12 col-custom mt-4">
                                        <button type="submit" class="btn btn-primary btn-hover-dark"
                                            fdprocessedid="iu5i8">Bình luận</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#toggleCategories").on("click", function() {
                var isHidden = $(".hidden-category").is(":hidden");

                if (isHidden) {
                    $(".hidden-category").slideDown();
                    $(this).text("Ẩn bớt");
                } else {
                    $(".hidden-category").slideUp();
                    $(this).text("Xem thêm");
                }
            });
        });
        $(document).ready(function() {
             // Lắng nghe sự kiện click vào nút "Sử dụng ngay"
             $('.apply-voucher-btn').on('click', function() {
                 var voucherCode = $(this).data('voucher-code');
     
                 $.ajax({
                     url: '{{ route('voucher.apply_code') }}', // Gọi route apply voucher
                     method: 'POST',
                     data: {
                         _token: '{{ csrf_token() }}', // CSRF token
                         voucher_code: voucherCode // Mã voucher
                     },
                     success: function(response) {
                         Swal.fire({
                             icon: 'success',
                             title: 'Thành công!',
                             text: response.message // Thông báo thành công
                         });
                     },
                     error: function(xhr) {
                         Swal.fire({
                             icon: 'error',
                             title: 'Lỗi!',
                             text: xhr.responseJSON.message // Thông báo lỗi
                         });
                     }
                 });
             });
         });

    </script>
  
     
     
    
@endsection