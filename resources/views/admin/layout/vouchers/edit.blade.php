@extends('admin.dashboard')

@section('content')

<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Sửa khuyến mại</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.vouchers.index') }}">Quản lí khuyến mại</a></li>
                            <li class="active">Sửa khuyến mại</li>
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
                        <strong>Sửa khuyến mại</strong>
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.vouchers.update', $voucher) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="code" class="form-control-label">Mã giảm giá</label>
                                <input type="text" id="code" name="code" placeholder="Nhập mã giảm giá" value="{{ old('code', $voucher->code) }}"
                                    class="form-control">
                                @error('code')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="discount" class="form-control-label">Giảm giá (%)</label>
                                <input type="number" id="discount" name="discount"
                                    value="{{ old('discount', $voucher->discount) }}" placeholder="Nhập % giảm giá" class="form-control">
                                @error('discount')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="quantity" class="form-control-label">Số lượng</label>
                                <input type="number" id="quantity" name="quantity"
                                    value="{{ old('quantity', $voucher->quantity) }}" placeholder="Nhập số lượng" class="form-control" min="1">
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
                                <label for="min_money" class="form-control-label">Số tiền tối thiểu</label>
                                <input type="number" id="min_money" name="min_money" placeholder="Nhập số tiền"
                                    value="{{ old('min_money', number_format($voucher->min_money, 0, '.', '')) }}" class="form-control" min="0">
                                @error('min_money')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="max_money" class="form-control-label">Số tiền tối đa</label>
                                <input type="number" id="max_money" name="max_money" placeholder="Nhập số tiền"
                                    value="{{ old('max_money', number_format($voucher->max_money, 0, '.', '')) }}" class="form-control" min="0">
                                @error('max_money')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="max_money" class="form-control-label">Điểm đổi</label>
                                <input type="number" id="points" name="points_required" placeholder="Nhập điểm đổi (có thể bỏ trống)" value="{{ old('points_required', $voucher->points_required) }}"
                                    class="form-control" min="0">
                            </div>

                            <button type="submit" class="btn btn-success mb-1">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection
