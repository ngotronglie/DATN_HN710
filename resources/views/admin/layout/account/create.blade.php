@extends('admin.dashboard')
@section('style')
    <link href="{{ asset('node_modules/toastr/build/toastr.min.css') }}" rel="stylesheet" />
@endsection
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
                        <a href="{{ route('accounts.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body card-block">
                        <form action="{{ route('accounts.store') }}" method="post">
                            @csrf
                        
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Tên người dùng</label>
                                <input type="text" id="name" name="name" placeholder="Nhập tên người dùng" class="form-control" value="{{ old('name') }}" requied>
                               
                            </div>
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Email</label>
                                <input type="text" id="email" name="email" placeholder="Nhập tên email người dùng" class="form-control" value="{{ old('email') }}" requied>
                               
                            </div>
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Address</label>
                                <input type="text" id="email" name="address" placeholder="Nhập tên địa chỉ người dùng" class="form-control" value="{{ old('address') }}" requied>
                               
                            </div>
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Điện Thoại</label>
                                <input type="text" id="phone" name="phone" placeholder="Nhập điện thoại người dùng" class="form-control" value="{{ old('phone') }}" requied>
                               
                            </div>

                            <div class="form-group">
                                <label for="name" class=" form-control-label">Ảnh</label>
                                <input type="file" id="avata" name="avata" placeholder="Nhập ảnh người dùng" class="form-control"  requied>
                               
                            </div>
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Mật Khẩu</label>
                                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu người dùng" class="form-control"  requied>
                               
                            </div>
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Ngày Sinh</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" placeholder="Nhập ngày sinh người dùng" class="form-control"  requied>
                               
                            </div>
                            
                           
                            <div class="form-group">
                                   <label for="name" class="form-control-label">Vai trò</label>
                                    <select name="role" id="select" class="form-control">
                                        <option selected disabled hidden>Chức Vụ</option>
                                        <option value="0">Người dùng</option>
                                        <option value="1">Nhân viên</option>
                                        <option value="2">Admin</option>
                                    </select>
                                
                            </div>
                            
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
@section('script')
    <!-- Thêm jQuery trước toastr -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
             //thành công 
            @if (session('success'))
                toastr.success('{{ session('success') }}', 'Thông báo');
            @endif

            //báo lỗi
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}', 'Lỗi');
                @endforeach
            @endif
        });
    </script>
@endsection
