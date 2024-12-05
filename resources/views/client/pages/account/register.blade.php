@extends('client.index')


@section('main')
<div class="section mb-5">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Đăng ký</h1>
                <ul>
                    <li>
                        <a href="/">Trang chủ </a>
                    </li>
                    <li class="active">Đăng ký</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

</div>
    <div class="login-register-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ms-auto me-auto">
                    <div class="login-register-wrapper">

                        <div class="tab-content">

                            <div id="lg2" class="tab-pane active">
                                <div class="section section-margin">
                                    <div class="container">

                                        <div class="row mb-n10">


                                                <!-- Register Wrapper Start -->
                                                <div class="register-wrapper">

                                                    <!-- Login Title & Content Start -->
                                                    <div class="section-content text-center mb-5">
                                                        <h2 class="title mb-2">Đăng ký</h2>
                                                        <p class="desc-content">Vui lòng đăng ký bằng thông tin tài khoản bên dưới</p>
                                                    </div>
                                                    <!-- Login Title & Content End -->

                                                    <!-- Form Action Start -->
                                                    <form action="{{route('register')}}" method="post">
                                                        @csrf

                                                        <div class="mb-5">

                                                            <input type="text" class="form-control userName" placeholder="Tên người dùng" name="name" value="{{ old('name') }}">
                                                            <small class="error-message text-danger"></small>
                                                            @error('name')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        <!-- Input Last Name End -->

                                                        <!-- Input Email Or Username Start -->
                                                        <div class=" mb-5">
                                                            <input type="email" class="form-control userEmail" placeholder="Email" name="email" value="{{ old('email') }}">
                                                            <small class="error-message text-danger"></small>
                                                            @error('email')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        <!-- Input Email Or Username End -->

                                                        <!-- Input Password Start -->
                                                        <div class=" mb-5">
                                                            <input type="password" class="form-control userPass" placeholder="Mật khẩu" name="password" value="{{ old('password') }}">
                                                            <small class="error-password text-danger"></small>
                                                            @error('password')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        <div class=" mb-5">
                                                            <input type="password" class="form-control userPassConfirmation" placeholder="Nhập lại mật khẩu" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                                            <small class="error-passwordConfirmation text-danger"></small>
                                                            @error('password_confirmation')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>

                                                        <!-- Input Password End -->

                                                        <!-- Checkbox & Subscribe Label Start -->
                                                        <div class="single-input-item mb-3">
                                                            <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                                                <div class="remember-meta mb-3">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="rememberMe-2">
                                                                        <label class="custom-control-label" for="rememberMe-2">Đăng ký nhận bản tin của chúng tôi</label>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between mb-3">
                                                                    <a href="{{route('login')}}" class="forget-pwd">Bạn đã có tài khoản ?</a>

                                                                    {{-- <a href="{{route('register')}}" class="forget-pwd">Bạn chưa có tài khoản?</a>
                                                                    <a href="{{route('forgotpassword')}}" class="forget-pwd">Quên mật khẩu?</a> --}}

                                                                </div>
                                                                {{-- <div class="single-input-item text-end">
                                                                    <a href="{{route('login')}}" class="text-decoration-none">Bạn đã có tài khoản?</a>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        <!-- Checkbox & Subscribe Label End -->

                                                        <!-- Register Button Start -->
                                                        <div class="single-input-item mb-3">
                                                            <button class="btn btn btn-dark btn-hover-primary rounded-0">Đăng ký</button>
                                                        </div>
                                                        <!-- Register Button End -->

                                                    </form>
                                                    <!-- Form Action End -->

                                                </div>
                                                <!-- Register Wrapper End -->

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('.userName').on('input', function () {
                $('.userName').next('.error-message').html('');
            });

            $('.userEmail').on('input', function () {
                $('.userEmail').next('.error-message').html('');
            });

            $('.userPass').on('input', function () {
                $('.error-password').html('');
            });

            $('.userPassConfirmation').on('input', function () {
                $('.error-passwordConfirmation').html('');
            });


            $('form').submit(function (event) {
                let isValid = true;

                $('.error-message').text('');

                if ($('.userName').val() == '') {
                    $('.userName').next('.error-message').html('Vui lòng nhập tên người nhận.');
                    isValid = false;
                }

                if ($('.userEmail').val() == '') {
                    $('.userEmail').next('.error-message').html('Vui lòng nhập email.');
                    isValid = false;
                }else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test($('.userEmail').val())) {
                     $('.userEmail').next('.error-message').html('Vui lòng nhập email hợp lệ.');
                     isValid = false;
                }

                     if ($('.userPass').val() == '') {
                         $('.error-password').html('Vui lòng nhập mật khẩu.');
                         isValid = false;
                    } else {

                    const userPassValue = $('.userPass').val();

                    if (userPassValue && userPassValue.split('').length < 8) {
                        $('.error-password').text('Mật khẩu phải có ít nhất 8 ký tự.');
                        isValid = false;
                    }

                    if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/.test(userPassValue)) {
                        $('.error-password').text('Mật khẩu phải chứa ít nhất một chữ cái in hoa, một chữ cái in thường và một số.');
                        isValid = false;
                    }
                }

                if ($('.userPassConfirmation').val() == '') {
                    $('.error-passwordConfirmation').html('Vui lòng nhập mật khẩu.');
                    isValid = false;
                }
                else if ($('.userPass').val() != $('.userPassConfirmation').val()) {
                    $('.error-passwordConfirmation').html('Mật khẩu của bạn chưa trùng khớp.');
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
    });
</script>
@endsection
