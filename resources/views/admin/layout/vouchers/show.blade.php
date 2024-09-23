@extends('admin.dashboard')

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection

@section('content')

<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Chi tiết Voucher</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="{{ route('vouchers.index') }}">Danh sách Voucher</a></li>
                            <li class="active">Chi tiết Voucher</li>
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
                        <strong>Chi tiết Voucher</strong>
                        <a href="{{ route('vouchers.index') }}" class="btn btn-primary  ">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Mã Voucher</th>
                                    <td>{{ $voucher->code }}</td>
                                </tr>
                                <tr>
                                    <th>Giảm giá</th>
                                    <td>{{ $voucher->discount }}%</td>
                                </tr>
                                <tr>
                                    <th>Số lượng</th>
                                    <td>{{ $voucher->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày bắt đầu</th>
                                    <td>{{ \Carbon\Carbon::parse($voucher->start_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày kết thúc</th>
                                    <td>{{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Giá trị nhỏ nhất</th>
                                    <td>{{ number_format($voucher->min_money, 0, ',', '.') }} VNĐ</td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td>{{ \Carbon\Carbon::parse($voucher->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td>{{ \Carbon\Carbon::parse($voucher->updated_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if ($voucher->is_active == 1)
                                        <span class="badge bg-success text-white">Hoạt động</span>
                                        @elseif ($voucher->is_active == 0)
                                        <span class="badge bg-danger text-white">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('vouchers.edit', $voucher) }}" class="btn btn-warning btn-icon-split">
                                <i class="fa fa-edit"></i> Sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection