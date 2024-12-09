@extends('admin.dashboard')
@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Sửa tài khoản</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.accounts.index') }}">Quản lí tài khoản</a></li>
                            <li class="active">Sửa tài khoản</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Sửa tài khoản</strong>
                        <a href="{{ route('admin.accounts.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body card-block">
                        <form action="{{ route('admin.accounts.update', $account) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="font-weight-bold mb-2">Chức vụ của {{ $account->name }} ({{ $account->role == 0 ? 'Người dùng' : 'Nhân viên' }})</div>
                            <div class="form-group">
                                <label for="role">Chức vụ</label>
                                <select name="role" id="role" class="form-control select2">
                                    <option value="">--- Vui lòng chọn ---</option>
                                    <option value="0" {{ (old('role', $account->role) == 0) ? 'selected' : '' }}>Người dùng
                                    </option>
                                    <option value="1" {{ (old('role', $account->role) == 1) ? 'selected' : '' }}>Nhân viên
                                    </option>
                                </select>
                                @error('role')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success mb-1">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
