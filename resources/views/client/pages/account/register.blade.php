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
                                                            
                                                            <input type="text" class="form-control" placeholder="Tên người dùng" name="name" value="{{ old('name') }}">
                                                            @error('name')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        <!-- Input Last Name End -->
                            
                                                        <!-- Input Email Or Username Start -->
                                                        <div class=" mb-5">
                                                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                                                            @error('email')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        <!-- Input Email Or Username End -->
                            
                                                        <!-- Input Password Start -->
                                                        <div class=" mb-5">
                                                            <input type="password" class="form-control" placeholder="Mật khẩu" name="password" value="{{ old('password') }}">
                                                            @error('password')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        <div class=" mb-5">
                                                            <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="password_confirmation" value="{{ old('password_confirmation') }}">
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
                                                                    <a href="{{route('login')}}" class="forget-pwd">Bạn đã có tài khoản?</a>

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