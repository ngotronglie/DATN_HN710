@extends('admin.dashboard')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/plugin/jquery-ui.css') }}">
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
                                <li><a href="{{ route('admin.blogs.index') }}">Danh sách danh mục</a></li>
                                <li class="active">Thêm danh mục</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')
        <div class="content mb-5">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Cập nhật bài viết</strong>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-8 col-sm-8">
                        <div class="card">
                            <div class="card-header">
                                <strong>Nội dung</strong>
                            </div>
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Tên bài viết</label><input
                                        type="text" id="name" name="title" placeholder="Nhập tên bài viết"
                                        class="form-control" value="{{ old('name', $blog->title) }}">
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div style="display: flex; justify-content: space-between">
                                        <label for="name" class="form-control-label">Nội dung</label>
                                        <a href="#" class="mutiimg" data-target="content">Thêm nhiều ảnh</a>
                                    </div>
                                    <textarea name="content" class="ckedit form-control" id="content">{!! old('content', $blog->content) !!}</textarea>
                                    @error('content')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title ">Danh mục và ảnh</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Danh mục bài viết</label>
                                    <select name="category_blog_id" class="form-control">
                                        <option value="">--Vui lòng chọn--</option>
                                        @foreach ($ctgrbl as $bl)
                                            <option @selected(old('category_blog_id', $blog->category_blog_id) == $bl->id) value="{{ $bl->id }}">
                                                {{ $bl->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_blog_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Ảnh đại diện bài viết</label>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <input type="file" name="img_avt" class="form-control" value="{{old('img_avt', $blog->img_avt)}}">
                                                    <img src="{{ old('img_avt', Storage::url($blog->img_avt ?? '')) ?: 'https://tse4.mm.bing.net/th?id=OIP.EkljFHN5km7kZIZpr96-JwAAAA&pid=Api&P=0&h=220' }}" style="width: 100%; text-align: center" class="image-target img-thumbnail" alt="Ảnh đại diện">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('img_avt')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mb-1 ml-3">Cập nhật</button>

                </div>
            </div>
        </div>
    </form>


@endsection
@section('script')
    <script src="{{ asset('plugins/plugin/jquery-ui.js') }}"></script>
    <script src="{{ asset('plugins/plugin/ckfinder_2/ckfinder.js') }}"></script>
    <script src="{{ asset('plugins/plugin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('plugins/js/ckfinerblog.js') }}"></script>
@endsection
