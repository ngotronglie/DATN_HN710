@extends('client.index')

@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section">
        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Hỗ trợ</h1>
                    <ul>
                        <li><a href="/">Trang chủ</a></li>
                        <li class="active">Hỗ trợ</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Contact Us Section Start -->
    <div class="section section-margin">
        <div class="container">
            <div class="row mb-n10">
                <div class="col-12 col-lg-8 mb-10">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h2 class="title pb-3">Hỗ trợ ngay</h2>
                        <span></span>
                        <div class="title-border-bottom"></div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('chat.createRoom') }}" class="btn btn-primary">Bắt đầu ngay</a>
                    </div>
                </div>

                <div class="col-12 col-lg-4 mb-10">
                    <!-- Contact Info Section -->
                    <div class="section-title">
                        <h2 class="title pb-3">Thông tin khác</h2>
                        <span></span>
                        <div class="title-border-bottom"></div>
                    </div>
                    <div class="contact-info-wrapper mb-n6">
                        <div class="single-contact-info mb-6">
                            <div class="single-contact-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="single-contact-title-content">
                                <h4 class="title">Địa chỉ</h4>
                                <p>132 Xuân Phương - Hà Nội</p>
                            </div>
                        </div>
                        <div class="single-contact-info mb-6">
                            <div class="single-contact-icon">
                                <i class="fa fa-mobile"></i>
                            </div>
                            <div class="single-contact-title-content">
                                <h4 class="title">Điện Thoại</h4>
                                <p>Nhân viên:<br>0376900771<br>0379478204</p>
                            </div>
                        </div>
                        <div class="single-contact-info mb-6">
                            <div class="single-contact-icon">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div class="single-contact-title-content">
                                <h4 class="title">Email</h4>
                                <p><a href="mailto:fashionwave@gmail.com">fashionwave@gmail.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Us Section End -->
@endsection
