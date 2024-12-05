@extends('admin.dashboard')
@section('style')
<style>
    th, td {
        width: 20%;
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
                            <li><a href="{{ route('admin.categories.index') }}">Danh sách danh mục</a></li>
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
                        <strong>Chi tiết danh mục</strong>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tên danh mục</th>
                                    <td colspan="3">{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Số lượng sản phẩm</th>
                                    <td colspan="3">{{ $productCount }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td colspan="3">
                                        @if($category->is_active)
                                        <span class="badge badge-success">Hoạt động</span>
                                        @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td colspan="3">{{ $category->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td colspan="3">{{ $category->updated_at }}</td>
                                </tr>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Ảnh</th>
                                    <th>Số lượng</th>
                                </tr>
                                @foreach ($products as $index => $item)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        <img src="{{ Storage::url($item->img_thumb) }}" alt="{{ $item->name }}" style="width: 100px; height: 150px; object-fit: contain;">
                                    </td>
                                    <td>Tổng: {{ $item->total_quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection
