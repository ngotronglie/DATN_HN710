@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Chi tiết banner</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="{{ route('admin.banners.index') }}">Danh sách banner</a></li>
                            <li class="active">Chi tiết banner</li>
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
                        <strong>Chi tiết banner</strong>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tiêu đề</th>
                                    <td>{{ $banner->title }}</td>
                                </tr>
                                <tr>
                                    <th>Người thêm</th>
                                    <td>
                                        {{ $banner->creator->name }}
                                        @if (!$banner->creator->is_active)
                                        <span style="color: red;">(Bị khóa)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Người sửa lần cuối</th>
                                    <td>
                                        {{ $banner->updater->name ?? 'Chưa có sửa đổi' }}
                                        @if ($banner->updater && !$banner->updater->is_active)
                                        <span style="color: red;">(Bị khóa)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Link</th>
                                    <td>{{ $banner->link }}</td>
                                </tr>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <td>
                                        @if($banner->image)
                                        <img src="{{ Storage::url($banner->image) }}" alt="Banner Image" style="max-width: 200px; height: auto;">
                                        @else
                                        <span>Không có hình ảnh</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mô tả</th>
                                    <td>{{ $banner->description }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if($banner->is_active)
                                        <span class="badge badge-success">Hoạt động</span>
                                        @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td>{{ $banner->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td>{{ $banner->updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-warning btn-icon-split">
                                <i class="fa fa-edit"></i> Sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection