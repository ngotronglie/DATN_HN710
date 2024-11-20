@extends('admin.dashboard')

@section('content')
    <div class="breadcrumbs mb-5">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Chi tiết đơn hàng kien</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Bảng điều khiển</a></li>
                                <li><a href="{{ route('admin.products.index') }}">Danh sách đơn hàng</a></li>
                                <li class="active">Chi tiết đơn hàng</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content mb-5">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    @if($order->user)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Thông tin người mua</strong>
                            <a href="{{ route('admin.order.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-1"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>

                                        <tr>
                                            <th>Tên người đặt</th>
                                            <td>{{ $order->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $order->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Điện Thoại</th>
                                            <td>{{ $order->user->phone }}</td>
                                        </tr>

                                        <tr>
                                            <th>Địa chỉ</th>
                                            <td>{{ $order->user->address }}</td>
                                        </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Thông tin người nhận</strong>

                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>

                                        <tr>
                                            <th>Tên</th>
                                            <td>{{ $order->user_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $order->user_email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Điện Thoại</th>
                                            <td>{{ $order->user_phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Địa chỉ</th>
                                            <td>{{ $order->user_address }}</td>
                                        </tr>

                                    <tr>
                                        <th>Đơn hàng</th>
                                        <td>
                                            @if ($order->status == 1)
                                                <span class="badge badge-info">Chờ xác nhận</span>
                                            @elseif($order->status == 2)
                                                <span class="badge badge-warning">Chờ lấy hàng</span>
                                            @elseif($order->status == 3)
                                                <span class="badge badge-primary">Đang giao hàng</span>
                                            @elseif($order->status == 4)
                                                <span class="badge badge-success">Giao hàng thành công</span>
                                            @elseif($order->status == 5)
                                                <span class="badge badge-secondary">Chờ hủy</span>
                                            @elseif($order->status == 6)
                                                <span class="badge badge-danger">Đã hủy</span>
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>

                                        <th>Trạng thái đơn hàng</th>
                                        <td>
                                            @switch($order->payment_status)
                                                @case('unpaid')
                                                    <span>Chưa thanh toán</span>
                                                @break

                                                @case('paid')
                                                    <span>Đã thanh toán</span>
                                                @break

                                                @case('failed')
                                                    <span>Giao dịch thanh toán không thành công</span>
                                                @break

                                                @case('refunded')
                                                    <span>Hoàn tiền</span>
                                                @break

                                                @default
                                                    <span>Trạng thái không xác định</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phương thức thanh toán</th>
                                        <td>
                                            {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Thanh toán online' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Ghi chú</th>
                                        @if($order->note)
                                        <td>{{ $order->note }}</td>

                                        @else
                                          <td>Không có ghi chú</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <th>Thời gian đặt hàng</th>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header">
                            <strong>Thông tin sản phẩm</strong>
                        </div>
                        <div class="card-body">
                            @if ($order->orderDetails->isEmpty())
                                <div class="alert alert-warning text-danger text-center">Không tìm thấy đơn hàng nào</div>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá bán</th>
                                            <th>Màu</th>
                                            <th>Size</th>
                                            <th>Tổng tiền từng sản phẩm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetails as $orderDetail)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if($orderDetail->product_variant_id)
                                                    <img width="100"
                                                        src="{{ Storage::url($orderDetail->productVariant->product->img_thumb) }}"
                                                        alt="">
                                                    @else
                                                    <span>Sản phẩm không tồn tại</span>
                                                    @endif
                                                </td>


                                                    <td>{{ $orderDetail->product_name }}</td>
                                                    <td>{{ $orderDetail->quantity }}</td>
                                                    <td>{{ number_format($orderDetail->price) }} VND</td>
                                                    <td>{{ $orderDetail->size_name }}</td>
                                                    <td>{{ $orderDetail->color_name }}</td>
                                                    <td>{{ number_format($orderDetail->quantity * $orderDetail->price )  }}
                                                        VND</td>

                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="7">
                                                @php
                                                    $totalPrice = 0;
                                                    if ($order->orderDetails) {
                                                        foreach ($order->orderDetails as $detail) {
                                                            if ($detail->productVariant) {
                                                                $totalPrice +=
                                                                    $detail->quantity *
                                                                    $detail->productVariant->price_sale;
                                                            } else {
                                                                $totalPrice += $detail->quantity * $detail->price;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <strong>Tổng tiền:</strong>
                                            </td>
                                            <td colspan="2" class="text-center">
                                                {{ number_format($totalPrice, 0, ',', '.') }} VND
                                            </td>

                                        </tr>
                                        <tr>
                                            @if ($order->voucher)
                                            <td colspan="7">
                                                <strong>Giảm {{ $order->voucher->discount }}%</strong>
                                            </td>
                                            <td colspan="2" class="text-center">

                                                {{ '- ' . number_format(($totalPrice * $order->voucher->discount) / 100, 0, ',', '.') }} VND

                                            </td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <strong>Phí vận chuyển:</strong>
                                            </td>
                                            <td colspan="2" class="text-center">
                                                {{ '+ '.number_format(30000, 0, ',', '.') }} VND
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                @php
                                                    $totalPrice = 0;
                                                    if ($order->orderDetails) {
                                                        foreach ($order->orderDetails as $detail) {
                                                            if ($detail->productVariant) {
                                                                $totalPrice +=
                                                                    $detail->quantity *
                                                                    $detail->productVariant->price_sale;
                                                            } else {
                                                                $totalPrice += $detail->quantity * $detail->price;
                                                            }
                                                        }

                                                        $totalPrice -= $order->voucher
                                                            ? ($totalPrice * $order->voucher->discount) / 100
                                                            : 0;
                                                    }
                                                    $totalPrice += 30000;
                                                @endphp
                                                <strong>Tổng đơn:</strong>
                                            </td>
                                            <td colspan="2" class="text-center">
                                                {{ number_format($totalPrice, 0, ',', '.') }} VND
                                            </td>

                                        </tr>



                                    </tbody>
                                </table>
                            @endif

                        </div>

                    </div>

                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

@endsection
