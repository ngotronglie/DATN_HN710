@extends('client.index')


@section('main')
    <div class="section mb-5">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Quên mật khẩu</h1>
                    <ul>
                        <li>
                            <a href="/">Trang chủ</a>
                        </li>
                        <li class="active">Quên mật khẩu</li>
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
                                                <h2 class="title mb-2">Đặt lại mật khẩu</h2>
                                                <p class="desc-content">Vui lòng nhập thông tin bên dưới</p>
                                            </div>
                                            <!-- Login Title & Content End -->

                                            <!-- Form Action Start -->
                                            <form action="{{route('user.password.update')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <input type="hidden" name="email" value="{{ $email }}">

                                                <div class="form-group">
                                                    <label>Mật khẩu mới</label>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="********" >
                                                        @error('password')
                                                        <small class="text-danger">
                                                            {{$message}}
                                                        </small>
                                                        @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Nhập lại mật khẩu</label>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        placeholder="********" >
                                                        @error('password_confirmation')
                                                        <small class="text-danger">
                                                            {{$message}}
                                                        </small>
                                                        @enderror
                                                </div>

                                              
                                                <div class="single-input-item mb-3">
                                                    <button
                                                        class="btn btn btn-dark btn-hover-primary rounded-0 mt-2">Gửi</button>
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
@endsection
