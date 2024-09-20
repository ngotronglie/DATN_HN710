@extends('admin.dashboard')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Quản lí tài khoản</a></li>
                            <li class="active">Sửa tài khoản</li>
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
                            <div class="form-group">

                                <select name="role" id="select" class="form-control">
                                    <option selected disabled hidden>Chức Vụ</option>
                                    <option value="0" {{ $account->role == 0 ? 'selected' : '' }}>Người dùng
                                    </option>
                                    <option value="1" {{ $account->role == 1 ? 'selected' : '' }}>Nhân viên
                                    </option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    @checked($account->is_active)>
                                <label for="is_active">Hoạt động</label>
                            </div>
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
