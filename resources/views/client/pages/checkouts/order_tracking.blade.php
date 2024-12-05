@extends('client.index')
@section('main')
<div class="section">
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Tra cứu đơn hàng</h1>
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="active">Tra cứu đơn hàng</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="section section-margin">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Search Form Start -->
                <div class="search-form-wrapper text-center mb-5">
                    <form action="{{ route('bill.search') }}" method="GET" class="search-form d-flex justify-content-center">
                        <input type="text" name="order_code" class="form-control" placeholder="Nhập mã đơn hàng" required>
                        <button type="submit" class="btn btn-primary" style="margin-left: 20px">Tra cứu</button>
                    </form>
                </div>
                <!-- Search Form End -->
                <!-- Order Results Start -->
                <div class="order-results">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="order-results-content">
                                @if (isset($message))
                                <div class="alert alert-danger" style="margin-top: 20px;">
                                    {{ $message }}
                                </div>
                                @elseif(isset($bills) && !$bills->isEmpty())
                                <h3 class="text-center">Kết quả tìm kiếm</h3>

                                @foreach ($bills as $bill)
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Mã đơn hàng: {{ $bill->order_code }}</h5>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <h5>Thông tin người nhận hàng</h5>
                                                <hr style="border-top: 2px solid #2c2727; margin: 20px 0;">
                                                <p><strong>Tên:</strong> {{ $bill->user_name }}</p>
                                                <p><strong>Số điện thoại:</strong> {{ $bill->user_phone }}</p>
                                                <p><strong>Email:</strong> {{ $bill->user_email }}</p>
                                                <p><strong>Địa chỉ:</strong>
                                                    {{ implode(', ', array_filter([
                                                        $addressData['addressDetail'],
                                                        $addressData['ward'],
                                                        $addressData['district'],
                                                        $addressData['province']
                                                    ], function($value) {
                                                        return !is_null($value) && $value !== '';
                                                    })) }}
                                                </p>
                                                <hr style="border-top: 2px solid #2c2727; margin: 20px 0;">
                                                <p><strong>Trạng thái:</strong>
                                                    @if ($bill->status == 1)
                                                    Chờ xác nhận
                                                    @elseif ($bill->status == 2)
                                                    Chờ lấy hàng
                                                    @elseif ($bill->status == 3)
                                                    Đang giao hàng
                                                    @elseif ($bill->status == 4)
                                                    Giao thành công
                                                    @elseif ($bill->status == 5)
                                                    Chờ hủy
                                                    @elseif ($bill->status == 6)
                                                    Đã hủy
                                                    @else
                                                    Không xác định
                                                    @endif
                                                </p>
                                                <p><strong>Ngày mua:</strong> {{ \Carbon\Carbon::parse($bill->created_at)->format('d-m-Y H:i:s') }}</p>
                                                <p><strong>Thanh toán:</strong> {{ $bill->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Đã thanh toán thành công' }}</p>
                                                @if($bill->voucher)
                                                <p><strong>Giảm giá:</strong> {{ $bill->discount}}%</p>
                                                @endif
                                                <p><strong>Tổng tiền:</strong> {{ number_format($bill->total_amount, 0, ',', '.') }} VND</p>
                                            </div>
                                            <!-- Vertical Divider -->
                                            <div class="col-md-1" style="border-left: 2px solid #ccc;"></div> <!-- Vertical Line -->
                                            <div class="col-md-6">
                                                <h5>Chi tiết đơn hàng</h5>
                                                <hr style="border-top: 2px solid #2c2727; margin: 20px 0;">
                                                <ul class="list-group">
                                                    @foreach ($billDetails as $index => $detail)
                                                    <li class="list-group-item border-0">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <img src="{{ Storage::url($detail->productVariant->product->img_thumb) }}" alt="{{ $detail->product_name }}" class="img-fluid">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p><strong>Sản phẩm:</strong> {{ $detail->product_name }}</p>
                                                                <p><strong>Số lượng:</strong> {{ $detail->quantity }}</p>
                                                                <p><strong>Giá:</strong> {{ number_format($detail->price, 0, ',', '.') }} VND</p>
                                                                <p><strong>Size:</strong> {{ $detail->size_name }}</p>
                                                                <p><strong>Màu:</strong> {{ $detail->color_name }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @if ($index < count($billDetails) - 1) <hr style="border: 1px solid #756f6f;">
                                                        @endif
                                                        @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order Results End -->
            </div>
        </div>
    </div>
</div>
@endsection
