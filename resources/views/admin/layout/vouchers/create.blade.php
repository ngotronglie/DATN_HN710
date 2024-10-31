@extends('admin.dashboard')

@section('content')

<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Thêm Voucher</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.vouchers.index') }}">Quản lí Vouchers</a></li>
                            <li class="active">Thêm Voucher</li>
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
                        <strong>Thêm mới</strong>
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.vouchers.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="code" class="form-control-label">Mã Voucher</label>
                                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control" required>
                                @error('code')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="discount" class="form-control-label">Giảm giá (%)</label>
                                <input type="number" id="discount" name="discount" value="{{ old('discount') }}"
                                    class="form-control" required>
                                @error('discount')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="quantity" class="form-control-label">Số lượng</label>
                                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                                    class="form-control" required>
                                @error('quantity')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="start_date" class="form-control-label">Ngày bắt đầu</label>
                                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                                    class="form-control" required>
                                @error('start_date')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="end_date" class="form-control-label">Ngày kết thúc</label>
                                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                                    class="form-control" required>
                                @error('end_date')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="min_money" class="form-control-label">Số tiền tối thiểu</label>
                                <input type="number" id="min_money" name="min_money" value="{{ old('min_money') }}"
                                    class="form-control" min="0" required>
                                @error('min_money')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="max_money" class="form-control-label">Số tiền tối đa</label>
                                <input type="number" id="max_money" name="max_money" value="{{ old('max_money') }}"
                                    class="form-control" min="0" required>
                                @error('max_money')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Phần trạng thái đã được loại bỏ. Nếu cần thiết, có thể thêm lại sau -->
                            <button type="submit" class="btn btn-success mb-1">Thêm Voucher</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection