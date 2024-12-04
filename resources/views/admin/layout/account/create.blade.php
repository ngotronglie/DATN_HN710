@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Thêm tài khoản</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
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
                        <form id="addressForm" action="{{ route('admin.accounts.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Tên người dùng</label>
                                <input type="text" id="name" name="name" placeholder="Nhập tên"
                                    class="form-control nameUser" value="{{ old('name') }}" requied>
                                    <small class="error-message text-danger"></small>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class=" form-control-label">Email</label>
                                <input type="text" id="email" name="email"
                                    placeholder="Nhập email" class="form-control userEmail"
                                    value="{{ old('email') }}" requied>
                                    <small class="error-message text-danger"></small>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone" class=" form-control-label">Số điện thoại</label>
                                <input type="text" id="phone" name="phone"
                                    placeholder="Nhập số điện thoại" class="form-control userPhone"
                                    value="{{ old('phone') }}" requied>
                                    <small class="error-message text-danger"></small>
                                @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="avatar" class="form-control-label">Ảnh</label>
                                <input type="file" id="avatar" name="avatar"
                                    class="form-control userAvt" requied accept="image/*">
                                    <small class="error-message text-danger"></small>
                                    <div style="margin-top: 10px;">
                                        <img id="preview-avatar" src="#" alt="Ảnh xem trước" style="display: none; width: 200px; height: 200px; border-radius: 50%; object-fit: cover;">
                                    </div>
                                @error('avatar')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class=" form-control-label">Mật khẩu</label>
                                <div class="input-group">
                                <input type="password" id="password" name="password"
                                    placeholder="Nhập mật khẩu" class="form-control userPass" requied>
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePassword()">
                                            <i class="fa fa-eye" id="eyeIcon"></i>
                                        </span>
                                    </div>
                                </div>
                                <small class="passErr text-danger"></small>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth" class=" form-control-label">Ngày sinh</label>
                                <input type="date" id="date_of_birth" name="date_of_birth"
                                    class="form-control userBirth" value="{{ old('date_of_birth') }}" requied>
                                    <small class="error-message text-danger"></small>
                                @error('date_of_birth')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth" class=" form-control-label">Chọn Tỉnh/Thành phố</label>
                                <select class="select2 province form-control"  name="provinces">
                                    <option value="">[Chọn Tỉnh/Thành phố]</option>
                                    @foreach ($provinces as $item)
                                        <option value="{{ $item->code }}">
                                          {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="error-message-province text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth" class=" form-control-label">Chọn Quận/Huyện</label>
                                <select class="select2 districts form-control"  name="districs">
                                    <option value="">[Chọn Quận/Huyện]</option>
                                </select>
                                <small class="error-message-districts text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth" class=" form-control-label">Chọn Phường/Xã</label>
                                <select class="select2 wards form-control" name="wards">
                                    <option value="">[Chọn Phường/Xã]</option>
                                </select>
                                <small class="error-message-wards text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="address" class=" form-control-label">Tên đường/tòa nhà/số nhà</label>
                                <input type="text" id="address" name="address"
                                    placeholder="Nhập Tên đường/tòa nhà/số nhà" class="form-control input_address" requied>
                                    <small class="error-address text-danger"></small>
                                    @if($errors->has('provinces') || $errors->has('address') || $errors->has('wards') || $errors->has('districs'))
                                    <small class="text-danger mt-5">Vui lòng nhập đầy đủ các trường địa chỉ.</small>
                                    @endif
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
<script src="{{ asset('plugins/js/location.js') }}"></script>
<script>
    jQuery(document).ready(function () {

        function showError(selector, message) {
            jQuery(selector).next('.error-message').html(message);
        }

        jQuery('.nameUser').on('input', function () {
                    jQuery('.nameUser').next('.error-message').html('');
                });

                jQuery('.userEmail').on('input', function () {
                    jQuery('.userEmail').next('.error-message').html('');
                });

                jQuery('.userPhone').on('input', function () {
                    jQuery('.userPhone').next('.error-message').html('');
                });

                jQuery('.userAvt').on('input', function () {
                    jQuery('.userAvt').next('.error-message').html('');
                });

                jQuery('.userPass').on('input', function () {
                    jQuery('.passErr').html('');
                });

                jQuery('.userBirth').on('input', function () {
                    jQuery('.userBirth').next('.error-message').html('');
                });

        jQuery('#addressForm').submit(function (event) {
            let isValid = true;
            jQuery('.error-message').text('');

            if (jQuery('.nameUser').val() == '') {
                showError('.nameUser', 'Vui lòng nhập tên người dùng.');
                isValid = false;
            }

            let email = jQuery('.userEmail').val();
            if (email == '') {
                showError('.userEmail', 'Vui lòng nhập email.');
                isValid = false;
            } else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                showError('.userEmail', 'Vui lòng nhập email hợp lệ.');
                isValid = false;
            }

            let phone = jQuery('.userPhone').val();
            if (phone == '') {
                showError('.userPhone', 'Vui lòng nhập số điện thoại.');
                isValid = false;
            } else if (!/^(0(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9]))[0-9]{7}$/.test(phone)) {
                showError('.userPhone', 'Vui lòng nhập số điện thoại di động hợp lệ.');
                isValid = false;
            }

            if (jQuery('.userAvt').val() == '') {
                showError('.userAvt', 'Vui lòng chọn ảnh đại diện.');
                isValid = false;
            }

            let userPassValue = jQuery('.userPass').val();
            if (userPassValue == '') {
                jQuery('.passErr').html('Vui lòng nhập mật khẩu.');
                isValid = false;
            } else if (userPassValue.length < 8) {
                jQuery('.passErr').html('Mật khẩu phải có ít nhất 8 ký tự.');
                isValid = false;
            } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/.test(userPassValue)) {
                jQuery('.passErr').html('Mật khẩu phải chứa ít nhất một chữ cái in hoa, một chữ cái in thường và một số.');
                isValid = false;
            }

            let birthDate = new Date(jQuery('.userBirth').val());
            let today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            let monthDiff = today.getMonth() - birthDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (jQuery('.userBirth').val() == '') {
                showError('.userBirth', 'Vui lòng chọn ngày sinh.');
                isValid = false;
            } else if (age < 18) {
                showError('.userBirth', 'Bạn phải đủ 18 tuổi.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    });

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
</script>
@endsection
