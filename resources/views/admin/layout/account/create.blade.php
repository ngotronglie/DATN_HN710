@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
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
                            <li><a href="{{ route('admin.accounts.index') }}">Quản lí tài khoản</a></li>
                            <li class="active">Thêm tài khoản</li>
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
                                <input type="text" id="name" name="name" placeholder="Nhập tên"
                                    class="form-control" value="{{ old('name') }}" requied>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class=" form-control-label">Email</label>
                                <input type="text" id="email" name="email"
                                    placeholder="Nhập email" class="form-control"
                                    value="{{ old('email') }}" requied>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address" class=" form-control-label">Địa chỉ</label>
                                <input type="text" id="address" name="address"
                                    placeholder="Nhập địa chỉ" class="form-control"
                                    value="{{ old('address') }}" requied>
                                @error('address')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone" class=" form-control-label">Điện thoại</label>
                                <input type="text" id="phone" name="phone"
                                    placeholder="Nhập số điện thoại" class="form-control"
                                    value="{{ old('phone') }}" requied>
                                @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="avatar" class="form-control-label">Ảnh</label>
                                <input type="file" id="avatar" name="avatar"
                                    class="form-control" requied accept="image/*">
                                    <div style="margin-top: 10px;">
                                        <img id="preview-avatar" src="#" alt="Ảnh xem trước" style="display: none; max-width: 200px; height: auto; border-radius: 50%; border: 2px solid #ccc;">
                                    </div>
                                @error('avatar')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class=" form-control-label">Mật khẩu</label>
                                <input type="password" id="password" name="password"
                                    placeholder="Nhập mật khẩu" class="form-control" requied>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth" class=" form-control-label">Ngày sinh</label>
                                <input type="date" id="date_of_birth" name="date_of_birth"
                                    class="form-control" value="{{ old('date_of_birth') }}" requied>
                                @error('date_of_birth')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <input type="hidden" value="1" name="role">

                            <button type="submit" class="btn btn-success mb-1">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    jQuery(document).ready(function() {
    jQuery('#avatar').on('change', function(e) {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                jQuery('#preview-avatar').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]); // Đọc file ảnh
        }
    });
});
</script>
@endsection