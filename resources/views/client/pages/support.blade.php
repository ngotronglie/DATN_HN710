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
    <!-- Contact Map Start -->
    <div class="section" data-aos="fade-up" data-aos-delay="300">
        <!-- Google Map Area Start -->
        <div class="google-map-area w-100">
            <iframe class="contact-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.4047397677914!2d105.72713207503217!3d21.056490980599765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134545729ea82e5%3A0x64b227e0e9d649b6!2zMTMyIFh1w6JuIFBoxrDGoW5nLCBC4bqvYyBU4burIExpw6ptLCBIw6AgTuG7mWksIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1734155080845!5m2!1svi!2s"></iframe>
        </div>
        <!-- Google Map Area Start -->
    </div>
    <!-- Contact Map End -->
@endsection
