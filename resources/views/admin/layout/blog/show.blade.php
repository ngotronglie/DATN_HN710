@extends('admin.dashboard')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/plugin/jquery-ui.css') }}">
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .blog-title {
            font-size: 36px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-align: center;
            line-height: 1.2;
        }

        .blog-meta {
            font-size: 14px;
            color: #777;
            text-align: center;
            margin-bottom: 20px;
        }


        .blog-image img {
            width: auto;
            max-width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
        }


        .blog-image img:hover {
            transform: scale(1.05);
        }

        .blog-content {
            font-size: 18px;
            line-height: 1.8;
            color: #444;
            text-align: justify;
            margin-bottom: 40px;
        }

        .blog-content h1,
        .blog-content h2,
        .blog-content h3 {
            font-family: 'Times New Roman', serif;
            color: #333;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .blog-content p {
            margin-bottom: 20px;
        }

        .blog-content blockquote {
            font-size: 20px;
            font-style: italic;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #f9f9f9;
            border-left: 5px solid #ccc;
            color: #666;
        }

        .blog-content figure {
            margin: 20px 0;
            text-align: center;
        }

        .blog-content img {
            width: 100%;
            border-radius: 8px;
        }

        .blog-footer {
            font-size: 14px;
            color: #555;
            border-top: 1px solid #eee;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .blog-footer p {
            margin: 0;
        }

        .blog-footer a {
            color: #3498db;
            text-decoration: none;
        }

        .blog-footer a:hover {
            text-decoration: underline;
        }

    </style>
@endsection

@section('content')
    <div class="breadcrumbs mb-5">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="{{ route('admin.blogs.index') }}">Chi tiết bài viết</a></li>
                                <li class="active">Thêm danh mục</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content mb-5">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Chi tiết bài viết</strong>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left mr-1"></i> Quay lại
                    </a>
                </div>
            </div>
            <div class="container">
                <h1 class="blog-title">{{ $blog->title }}</h1>

                <div class="blog-meta">
                    <span>Ngày tạo: {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y H:i') }}</span> |
                    <span>Lượt xem: {{ $blog->view }}</span> |
                    <span>Người viết: {{ $userName }}</span>
                </div>

                <div class="blog-image">
                    <img src="{{ asset('storage/' . $blog->img_avt) }}" alt="{{ $blog->title }}"
                        onerror="this.src='/path/to/default-image.jpg';">
                </div>

                <div class="blog-content">
                    {!! $blog->content !!}
                </div>

                <div class="blog-footer">
                    <p><strong>Danh mục:</strong> {{ $blog->category->name }}</p>
                    <p><strong>Trạng thái:</strong> {{ $blog->is_active ? 'Kích hoạt' : 'Ẩn' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('plugins/plugin/jquery-ui.js') }}"></script>
    <script src="{{ asset('plugins/plugin/ckfinder_2/ckfinder.js') }}"></script>
    <script src="{{ asset('plugins/plugin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('plugins/js/ckfinerblog.js') }}"></script>
@endsection
