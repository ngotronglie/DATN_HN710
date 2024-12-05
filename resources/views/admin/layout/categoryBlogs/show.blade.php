@extends('admin.dashboard')
@section('style')
<style>
    th, td {
        width: 1%;
        text-align: center;
        vertical-align: middle !important;
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
                        <h1>Chi tiết danh mục</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.category_blogs.index') }}">Danh sách danh mục</a></li>
                            <li class="active">Chi tiết danh mục</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content mb-5">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Chi tiết danh mục bài viết</strong>
                        <a href="{{ route('admin.category_blogs.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tên danh mục bài viết</th>
                                    <td colspan="2">{{ $categoryBlog->name }}</td>
                                </tr>
                                <tr>
                                    <th>Số lượng bài viết</th>
                                    <td colspan="2">{{ $blogCount }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td colspan="2">
                                        @if($categoryBlog->is_active)
                                        <span class="badge badge-success">Hoạt động</span>
                                        @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td colspan="2">{{ $categoryBlog->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td colspan="2">{{ $categoryBlog->updated_at }}</td>
                                </tr>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Ảnh</th>
                                </tr>
                                @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->title}}</td>
                                    <td>
                                        <img src="{{ Storage::url($item->img_avt) }}" alt="{{ $item->name }}" style="width: 100px; height: 150px; object-fit: contain;">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.category_blogs.edit', $categoryBlog) }}" class="btn btn-warning btn-icon-split">
                                <i class="fa fa-edit"></i> Sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection
