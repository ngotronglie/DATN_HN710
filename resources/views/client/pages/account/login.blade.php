@extends('client.index')


@section('main')
<div class="section mb-5">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Login</h1>
                <ul>
                    <li>
                        <a href="/">Trang chủ </a>
                    </li>
                    <li class="active">Đăng nhập</li>
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
                            <div id="lg1" class="tab-pane active">
                                <div class="section section-margin">
                                    <div class="container">
                            
                                        {{-- <div class="row mb-n10">
                                            <div class="col-lg-6 col-md-8 m-auto m-lg-0 pb-10"> --}}
                                                <!-- Login Wrapper Start -->
                                                <div class="login-wrapper">
                            
                                                    <!-- Login Title & Content Start -->
                                                    <div class="section-content text-center mb-5">
                                                        <h2 class="title mb-2">Đăng nhập</h2>
                                                        <p class="desc-content">Vui lòng đăng nhập bằng thông tin tài khoản bên dưới</p>
                                                    </div>
                                                    <!-- Login Title & Content End -->
                            
                                                    <!-- Form Action Start -->
                                                    <form action="{{route('login')}}" method="post">
                                                            @csrf
                                                        <!-- Input Email Start -->
                                                        <div class=" mb-5">
                                                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                                                            @error('email')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        <!-- Input Email End -->
                            
                                                        <!-- Input Password Start -->
                                                        <div class="mb-5" style="position: relative;">
                                                            <div class="input-group">
                                                                <input type="password" id="password" name="password" class="form-control" 
                                                                       placeholder="Mật khẩu" required style="padding-right: 40px;">
                                                                <div class="input-group-append" 
                                                                     style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                                    <span class="input-group-text" onclick="togglePassword()" style="background: none; border: none;">
                                                                        <i class="fa fa-eye" id="eyeIcon"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            @error('password')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        
                                                        <!-- Input Password End -->
                                                        @error('error')
                                                        <small class="text-danger">
                                                            {{$message}}
                                                        </small>
                                                        @enderror
                                                        <!-- Checkbox/Forget Password Start -->
                                                        <div class="single-input-item mb-3">
                                                            <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                                                <div class="remember-meta mb-3">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="rememberMe">
                                                                        <label class="custom-control-label" for="rememberMe">Nhớ tôi</label>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between mb-3">
                                                                    <a href="{{route('register')}}" class="forget-pwd">Bạn chưa có tài khoản?</a>
                                                                    <a href="{{route('forgot')}}" class="forget-pwd">Quên mật khẩu?</a>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <!-- Checkbox/Forget Password End -->
                            
                                                        <!-- Login Button Start -->
                                                        <div class="single-input-item mb-3">
                                                            <button class="btn btn btn-dark btn-hover-primary rounded-0">Đăng nhập</button>
                                                        </div>
                                                        <!-- Login Button End -->
                            
                                                        <!-- Lost Password & Creat New Account Start -->
                                                        {{-- <div class="lost-password">
                                                            <a href="{{route('register')}}">Create Account</a>
                                                        </div> --}}
                                                        <!-- Lost Password & Creat New Account End -->
                                                    </form>
                                                    <!-- Form Action End -->
                            
                                                </div>
                                                <!-- Login Wrapper End -->
                                            {{-- </div>
                                           
                                        </div> --}}
                            
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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