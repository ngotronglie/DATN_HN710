@extends('admin.dashboard')

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection

@section('content')

<div class="breadcrumbs">
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
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Quản lí Vouchers</a></li>
                            <li class="active">Thêm Voucher</li>
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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <strong>Thêm Voucher</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('vouchers.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="code" class="form-control-label">Mã Voucher</label>
                                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control"
                                    required>
                                @error('code')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="discount" class="form-control-label">Giảm giá</label>
                                <input type="text" id="discount" name="discount" value="{{ old('discount') }}"
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
                                <label for="min_money" class="form-control-label">Giá trị nhỏ nhất</label>
                                <input type="number" step="0.01" id="min_money" name="min_money"
                                    value="{{ old('min_money') }}" class="form-control" required>
                                @error('min_money')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="max_money" class="form-control-label">Giá trị lớn nhất</label>
                                <input type="number" step="0.01" id="max_money" name="max_money"
                                    value="{{ old('max_money') }}" class="form-control" required>
                                @error('max_money')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="is_active" class="form-control-label">Trạng thái</label>
                                <select id="is_active" name="is_active" class="form-control" required>
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Không hoạt động
                                    </option>
                                </select>
                                @error('is_active')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Thêm Voucher</button>
                            <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection