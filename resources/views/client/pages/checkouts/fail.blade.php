@extends('client.index')

@section('main')
<div class="section">
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Thanh toán</h1>
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="active">Đặt hàng thất bại</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="section section-margin">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h4 class="font-weight-bold mb-4 text-danger">Đặt Hàng Thất Bại</h4>
                </div>

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="alert alert-danger text-center">
                            <p style="font-size: 16px; font-weight: bold;">
                                Rất tiếc, đơn hàng của bạn không thể được hoàn tất
                            </p>
                            <p class="mt-2" style="font-size: 16px;">Vui lòng thử lại sau hoặc liên hệ với chúng tôi để được hỗ trợ</p>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-success rounded-pill px-4 py-2">Trở lại Trang Chủ</a>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-warning rounded-pill px-4 py-2">Xem lại giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
