@extends('client.index')

@section('main')
    <!-- my account wrapper start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Tài khoản của tôi</h1>
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ</a>
                        </li>
                        <li class="active">Tài khoản của tôi</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- My Account Section Start -->
    {{-- <div class="section section-margin">
        <div class="container"> --}}

            <div class="row" style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
                <div class="col-lg-12" style="width: 100%; max-width: 1200px;">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        
                            <!-- My Account Tab Menu End -->
            
                            <!-- My Account Tab Content Start -->
                            <div class="container">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <div class="myaccount-content" style="padding: 20px;">
                                            <!-- Title and Back Link -->
                                            <div style="display: flex; justify-content: center; align-items: center; position: relative; margin-bottom: 20px;">
                                                <!-- Title -->
                                                <h3 style="font-size: 24px; font-weight: bold; text-align: center; margin: 0;">Chi tiết đơn hàng #{{ $order->order_code }}</h3>
                                                
                                                <!-- Close Icon -->
                                                <a href="{{ route('my_account') }}" 
                                                   style="position: absolute; right: 0; text-decoration: none; color: #8ed4f7; font-weight: 500; font-size: 24px; display: flex; align-items: center; transition: color 0.3s ease;"
                                                   onmouseover="this.style.color='#0056b3'" onmouseout="this.style.color='#8ed4f7'">
                                                    <i class="fa fa-times-circle" style="font-size: 24px;"></i>
                                                </a>
                                            </div>
                                            
                                            
            
                                            <!-- Receiver Info -->
                                            <div class="bill-card-body">
                                                <div class="bill-info" style="display: flex; flex-direction: column; gap: 12px;">
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Người nhận:</strong> <span>{{ $order->user_name }}</span>
                                                    </div>
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Email:</strong> <span>{{ $order->user_email }}</span>
                                                    </div>
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Điện thoại:</strong> <span>{{ $order->user_phone }}</span>
                                                    </div>
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Địa chỉ:</strong> <span>{{ $order->user_address }}</span>
                                                    </div>
                                                    <!-- Total Amount Before Discount -->
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Tổng tiền trước khi giảm:</strong>
                                                        <span>
                                                            @php
                                                                $totalBeforeDiscount = $order->orderDetails->sum(function($detail) {
                                                                    return $detail->quantity * $detail->price;
                                                                });
                                                            @endphp
                                                            {{ number_format($totalBeforeDiscount, 0, ',', '.') }} VND
                                                        </span>
                                                    </div>
                                                    <!-- Voucher Discount -->
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Giảm:</strong>
                                                        <span>
                                                            @if ($order->discount)
                                                                {{ $order->discount }}%
                                                            @else
                                                                Không áp dụng
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Phí vận chuyển:</strong> <span>{{ number_format(30000, 0, ',','.') }} VNĐ</span>
                                                    </div>
                                                    <!-- Total Amount -->
                                                    <div class="info-row" style="display: flex; justify-content: space-between;">
                                                        <strong style="font-weight: 600;">Tổng tiền:</strong> <span>{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                                                    </div>
                                                </div>
                                            </div>
            
                                            <!-- Horizontal Divider -->
                                            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
            
                                            <!-- Order Details -->
                                            <div class="myaccount-table"
                                                 style="display: grid; grid-template-columns: {{ $order->orderDetails->count() === 1 ? '1fr' : 'repeat(auto-fit, minmax(300px, 1fr))' }}; gap: 20px;">
                                                @foreach ($order->orderDetails as $detail)
                                                    <div class="bill-card"
                                                         style="background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                                        <!-- Product Name -->
                                                        <div class="info-row"
                                                             style="display: flex; justify-content: space-between;">
                                                            <strong style="font-weight: 600;">Tên Sản Phẩm:</strong>
                                                            <span style="max-width: 300px; word-wrap: break-word; white-space: normal;">{{ $detail->product_name }}</span>
                                                        </div>
                                                        <!-- Size -->
                                                        <div class="info-row"
                                                             style="display: flex; justify-content: space-between;">
                                                            <strong style="font-weight: 600;">Kích cỡ:</strong>
                                                            <span>{{ $detail->size_name }}</span>
                                                        </div>
                                                        <!-- Color -->
                                                        <div class="info-row"
                                                             style="display: flex; justify-content: space-between;">
                                                            <strong style="font-weight: 600;">Màu sắc:</strong>
                                                            <span>{{ $detail->color_name }}</span>
                                                        </div>
                                                        <!-- Quantity -->
                                                        <div class="info-row"
                                                             style="display: flex; justify-content: space-between;">
                                                            <strong style="font-weight: 600;">Số Lượng:</strong>
                                                            <span>{{ $detail->quantity }}</span>
                                                        </div>
                                                        <!-- Price -->
                                                        <div class="info-row"
                                                             style="display: flex; justify-content: space-between;">
                                                            <strong style="font-weight: 600;">Giá:</strong>
                                                            <span>{{ number_format($detail->price, 0, ',', '.') }} VND</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- My Account Tab Content End -->
                      
                    </div>
                    <!-- My Account Page End -->
                </div>
            </div>
            

        </div>
    </div>
   
@endsection
