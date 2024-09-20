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
                                <li class="active">Thêm tài khoản</li>
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
                            <strong>Thêm tài khoản</strong>
                            <a href="{{ route('admin.accounts.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-1"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{ route('admin.accounts.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Tên người dùng</label>
                                    <input type="text" id="name" name="name" placeholder="Nhập tên người dùng"
                                        class="form-control" value="{{ old('name') }}" requied>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Email</label>
                                    <input type="text" id="email" name="email"
                                        placeholder="Nhập tên email người dùng" class="form-control"
                                        value="{{ old('email') }}" requied>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Địa chỉ</label>
                                    <input type="text" id="email" name="address"
                                        placeholder="Nhập tên địa chỉ người dùng" class="form-control"
                                        value="{{ old('address') }}" requied>
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Điện thoại</label>
                                    <input type="text" id="phone" name="phone"
                                        placeholder="Nhập điện thoại người dùng" class="form-control"
                                        value="{{ old('phone') }}" requied>
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name" class="form-control-label">Ảnh</label>
                                    <input type="file" id="avatar" name="avatar" placeholder="Nhập ảnh người dùng"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Mật khẩu</label>
                                    <input type="password" id="password" name="password"
                                        placeholder="Nhập mật khẩu người dùng" class="form-control" requied>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Ngày sinh</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                        placeholder="Nhập ngày sinh người dùng" class="form-control" requied>

                                </div>
                                <input type="hidden" value="1" name="role">
                                <div class="form-group">
                                    <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label for="is_active">Hoạt động</label>
                                </div>

                                <button type="submit" class="btn btn-success">Thêm mới</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
