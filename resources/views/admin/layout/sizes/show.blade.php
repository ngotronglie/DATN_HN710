@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Chi tiết kích cỡ</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.sizes.index') }}">Danh sách kích cỡ</a></li>
                            <li class="active">Chi tiết kích cỡ</li>
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
                        <strong>Chi tiết kích cỡ</strong>
                        <a href="{{ route('admin.sizes.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tên kích cỡ</th>
                                    <td>{{ $size->name }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td>{{ $size->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td>{{ $size->updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-warning btn-icon-split">
                                <i class="fa fa-edit"></i> Sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection
