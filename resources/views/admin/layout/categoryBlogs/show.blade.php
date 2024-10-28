@extends('admin.dashboard')

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
                                    <td>{{ $categoryBlog->name }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if($categoryBlog->is_active)
                                        <span class="badge badge-success">Hoạt động</span>
                                        @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td>{{ $categoryBlog->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td>{{ $categoryBlog->updated_at }}</td>
                                </tr>
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