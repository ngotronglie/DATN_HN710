@extends('admin.dashboard')
@section('style')
    <style>
        .card-body {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .form-control {
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #5cb85c;
            box-shadow: 0 0 8px rgba(92, 184, 92, 0.6);
        }

        .form-control-label {
            font-weight: 600;
            color: #333;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .row {
            margin-bottom: 20px;
        }


        .col-lg-9 {
            padding-left: 0;
        }

        button {
            background-color: #28a745;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        .input-group {
            position: relative;
        }

        .input-group-append {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
        }

        .input-group-text i {
            font-size: 1.2rem;
        }

        small.text-danger {
            font-size: 0.875rem;
            color: #e74c3c;
        }

        .select2 {
            width: 100% !important;
        }

        .select2-container {
            border-radius: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumbs mb-5">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Thêm nhân viên</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Bảng điều khiển</a></li>
                                <li><a href="{{ route('admin.accounts.index') }}">Quản lí tài khoản</a></li>
                                <li class="active">Thêm nhân viên</li>
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
                            <strong>Thêm nhân viên</strong>
                            <a href="{{ route('admin.accounts.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-1"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{ route('admin.accounts.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h3>Thông tin chung</h3>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name" class=" form-control-label">Tên người dùng</label>
                                                    <input type="text" id="name" name="name"
                                                        placeholder="Nhập tên" class="form-control"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="password" class=" form-control-label">Mật khẩu</label>
                                                    <div class="input-group">
                                                        <input type="password" id="password" name="password"
                                                            placeholder="Nhập mật khẩu" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" onclick="togglePassword()">
                                                                <i class="fa fa-eye" id="eyeIcon"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @error('password')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="date_of_birth" class=" form-control-label">Ngày sinh</label>
                                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                                        class="form-control" value="{{ old('date_of_birth') }}">
                                                    @error('date_of_birth')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation" class="form-control-label">Nhập lại mật khẩu</label>
                                                    <div class="input-group">
                                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                                            placeholder="Nhập lại mật khẩu" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" onclick="togglePasswordCf()">
                                                                <i class="fa fa-eye" id="eyeIconcf"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @error('password_confirmation')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="avatar" class="form-control-label">Ảnh</label>
                                                    <input type="file" id="avatar" name="avatar"
                                                        class="form-control" accept="image/*">
                                                    <div style="margin-top: 10px;">
                                                        <img id="preview-avatar" src="#" alt="Ảnh xem trước"
                                                            style="display: none; width: 200px; height: 200px; border-radius: 50%; object-fit: cover;">
                                                    </div>
                                                    @error('avatar')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="shift" class="form-control-label">Ca làm việc</label>
                                                    <select name="work_shift_id" class="form-control select2 shift">
                                                        <option style="display: none" value="">--Vui lòng chọn--</option>
                                                        @foreach ($shift as $item)
                                                        <option value="{{$item->id}}" {{ old('work_shift_id') == $item->id ? 'selected' : '' }}>{{$item->shift_name}}                                    
                                                              ({{$item->start_time}} - {{$item->end_time}})
                                                        </option>
                    
                                                        @endforeach
                                                    </select>
                                                    @error('work_shift_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <h3>Thông tin liên hệ</h3>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email" class=" form-control-label">Email</label>
                                                    <input type="text" id="email" name="email"
                                                        placeholder="Nhập email" class="form-control"
                                                        value="{{ old('email') }}">
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="date_of_birth" class=" form-control-label">Chọn Tỉnh/Thành
                                                        phố</label>
                                                    <select class="select2 province form-control" name="provinces">
                                                        <option value="">[Chọn Tỉnh/Thành phố]</option>
                                                        @foreach ($provinces as $item)
                                                            <option value="{{ $item->code }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="date_of_birth" class=" form-control-label">Chọn
                                                        Phường/Xã</label>
                                                    <select class="select2 wards form-control" name="wards">
                                                        <option value="">[Chọn Phường/Xã]</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="phone" class=" form-control-label">Số điện thoại</label>
                                                    <input type="text" id="phone" name="phone"
                                                        placeholder="Nhập số điện thoại" class="form-control"
                                                        value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="date_of_birth" class=" form-control-label">Chọn
                                                        Quận/Huyện</label>
                                                    <select class="select2 districts form-control" name="districs">
                                                        <option value="">[Chọn Quận/Huyện]</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address" class=" form-control-label">Tên đường/tòa nhà/số
                                                        nhà</label>
                                                    <input type="text" id="address" name="address"
                                                        placeholder="Nhập Tên đường/tòa nhà/số nhà"
                                                        class="form-control input_address">
                                                </div>

                                                <input type="hidden" value="1" name="role">
                                            </div>
                                        </div>
                                        @if ($errors->has('provinces') || $errors->has('address') || $errors->has('wards') || $errors->has('districs'))
                                            <small class="text-danger mt-5">Vui lòng nhập đầy đủ các trường địa chỉ</small>
                                        @endif
                                    </div>
                                </div>

                                <button style="float: right" type="submit" class="btn btn-success mb-1">Thêm
                                    mới</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/js/location.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#avatar').on('change', function(e) {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        jQuery('#preview-avatar').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eyeIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
        function togglePasswordCf() {
            var passwordField = document.getElementById("password_confirmation");
            var eyeIcon = document.getElementById("eyeIconCf");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
