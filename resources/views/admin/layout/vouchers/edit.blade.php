@extends('admin.dashboard')

@section('style')
<link rel="stylesheet" href="{{ asset('/public/admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<!-- <link rel="stylesheet" href="{{asset('/public/admin/assets/css/main.css')}}"> -->
@endsection


@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Chỉnh sửa Voucher</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Quản lí Vouchers</a></li>
                            <li class="active">Chỉnh sửa Voucher</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Chỉnh sửa Voucher</strong>
                        <a href="{{ route('vouchers.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="code" class="form-control-label">Mã Voucher</label>
                                <input type="text" id="code" name="code" value="{{ old('code', $voucher->code) }}"
                                    class="form-control">
                                @error('code')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="discount" class="form-control-label">Giảm giá (%)</label>
                                <input type="number" id="discount" name="discount"
                                    value="{{ old('discount', $voucher->discount) }}" class="form-control">
                                @error('discount')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="quantity" class="form-control-label">Số lượng</label>
                                <input type="number" id="quantity" name="quantity"
                                    value="{{ old('quantity', $voucher->quantity) }}" class="form-control" min="1">
                                @error('quantity')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="start_date" class="form-control-label">Ngày bắt đầu</label>
                                <input type="date" id="start_date" name="start_date"
                                    value="{{ old('start_date', $voucher->start_date) }}" class="form-control">
                                @error('start_date')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="end_date" class="form-control-label">Ngày kết thúc</label>
                                <input type="date" id="end_date" name="end_date"
                                    value="{{ old('end_date', $voucher->end_date) }}" class="form-control">
                                @error('end_date')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="min_money" class="form-control-label">Giá trị nhỏ nhất</label>
                                <input type="number" step="0.01" id="min_money" name="min_money"
                                    value="{{ old('min_money', $voucher->min_money) }}" class="form-control" min="0">
                                @error('min_money')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group text-left">
                                <button type="submit" class="btn btn-success btn-icon-split">Cập nhật</button>
                                <!-- <a href="{{ route('vouchers.index') }}" class="fa fa-edit">Hủy</a> -->
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection