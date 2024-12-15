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
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fa fa-times-circle text-danger" style="font-size: 50px;"></i>
                            <h3 class="font-weight-bold mt-3">Đặt Hàng Thất Bại</h3>
                            <p class="text-muted">Rất tiếc, đơn hàng của bạn không thể được hoàn tất. </p>
                            <p>Vui lòng thử lại sau hoặc liên hệ với chúng tôi qua Zalo: <strong class="text-primary">0376 900 771</strong> để được hỗ trợ.<p>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('home') }}"  style="color: white;background: #2ca9fc" class="rounded-pill px-3 py-3 mx-2">
                                <i class="fa fa-shopping-cart"></i> Tiếp tục mua hàng
                            </a>
                            <a href="{{ route('cart.index') }}" style="color: white;background: #ff4949" class="rounded-pill px-3 py-3 mx-2">
                                <i class="fa fa-arrow-left"></i> Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
