@extends('client.index')
@section('style')
<style>
    /* Ẩn các danh mục ban đầu */
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
                <h1 class="title">Blog Details</h1>
                <ul>
                    <li>
                        <a href="index.html">Home </a>
                    </li>
                    <li class="active"> Blog Details</li>
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
                                <input type="text" class="form-control" placeholder="Search Our Store"
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
                                    <li class="{{ $index >= 5 ? 'hidden-category' : '' }}"><a
                                            href="#">{{ $item->name }}</a></li>
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
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="{{ Storage::url($item->img_avt) }}"
                                                alt="Product">
                                            <img class="second-image" src="{{ Storage::url($item->img_avt) }}"
                                                alt="Product">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="title mt-4"><a
                                                href="single-product.html">{{ Str::limit(strip_tags($item->content), 36, '...') }}</a>
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
                            <span>By <a href="#" class="meta-item author mr-1">{{ $blog->user->name }},</a></span>
                            <span
                                class="meta-item date">{{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}</span>
                            <span class="meta-item comment"><a href="#">03 Comments</a></span>
                        </div>
                        <div class="desc content aos-init aos-animate" data-aos="fade-right" data-aos-delay="300">
                            {!! $blog->content !!}
                        </div>
                    </div>
                    <hr>
                </div>



                <div class="comment-area-wrapper mt-5 aos-init" data-aos="fade-up" data-aos-delay="400">
                    <h3 class="title mb-6">5 Comments</h3>
                    <div class="single-comment-wrap mb-10">
                        <a class="author-thumb" href="#">
                            <img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmhF7UB6jv1t_oyGDzqSb_h0JPspDnfqohVA&sr">
                        </a>
                        <div class="comments-info">
                            <p class="mb-1">This book is a treatise on the theory of ethics, very popular during the
                                Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet</p>
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
                            <p class="mb-1">Praesent bibendum risus pellentesque faucibus rhoncus. Etiam a mollis
                                odio. Integer urna nisl, fermentum eu mollis et, gravida eu elit.</p>
                            <div class="comment-footer d-flex justify-content-between">
                                <span class="author"><a href="#"><strong>Alex</strong></a> - August 30,
                                    2023</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog-comment-form-wrapper mt-10 aos-init" data-aos="fade-up" data-aos-delay="400">
                    <div class="blog-comment-form-title">
                        <h2 class="title">Leave a comment</h2>
                    </div>
                    <div class="comment-box">
                        <form action="#">
                            <div class="row">
                                <div class="col-12 col-custom">
                                    <div class="input-item mt-4 mb-4">
                                        <textarea cols="30" rows="5" name="comment" class="rounded-0 w-100 custom-textarea input-area"
                                            placeholder="Message"></textarea>
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
                                        fdprocessedid="iu5i8">Post comment</button>
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
</script>
@endsection