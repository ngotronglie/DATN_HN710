@extends('client.index')

@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section">
        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Contact Us</h1>
                    <ul>
                        <li><a href="/">Home </a></li>
                        <li class="active"> Contact Us</li>
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
                        <h2 class="title pb-3">Get In Touch</h2>
                        <span></span>
                        <div class="title-border-bottom"></div>
                    </div>
                    <!-- Section Title End -->

                    <!-- Contact Form Wrapper Start -->
                    <div class="contact-form-wrapper contact-form">
                        <!-- Hiển thị thông báo nếu có -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Hiển thị lỗi nếu có -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form Liên Hệ -->
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-item mb-4">
                                        <input type="text" name="name" placeholder="Your Name *"
                                            value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item mb-4">
                                        <input type="email" name="email" placeholder="Email *"
                                            value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-item mb-4">
                                        <input type="text" name="title" placeholder="Subject *"
                                            value="{{ old('title') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-item mb-8">
                                        <textarea name="messager" placeholder="Messager" required>{{ old('messager') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-dark btn-hover-primary rounded-0">Send A
                                        Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Contact Form Wrapper End -->
                </div>

                <div class="col-12 col-lg-4 mb-10">
                    <!-- Contact Info Section -->
                    <div class="section-title">
                        <h2 class="title pb-3">Contact Info</h2>
                        <span></span>
                        <div class="title-border-bottom"></div>
                    </div>
                    <div class="contact-info-wrapper mb-n6">
                        <div class="single-contact-info mb-6">
                            <div class="single-contact-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="single-contact-title-content">
                                <h4 class="title">Postal Address</h4>
                                <p>PO Box 123456, Street/Road <br>Country-State</p>
                            </div>
                        </div>
                        <div class="single-contact-info mb-6">
                            <div class="single-contact-icon">
                                <i class="fa fa-mobile"></i>
                            </div>
                            <div class="single-contact-title-content">
                                <h4 class="title">Contact Us Anytime</h4>
                                <p>Mobile: 0376278382 <br>Fax: 123 456 789</p>
                            </div>
                        </div>
                        <div class="single-contact-info mb-6">
                            <div class="single-contact-icon">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div class="single-contact-title-content">
                                <h4 class="title">Support Overall</h4>
                                <p><a href="mailto:Support24/7@example.com">Support24/7@example.com</a> <br><a
                                        href="mailto:info@example.com">info@example.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Us Section End -->
@endsection
