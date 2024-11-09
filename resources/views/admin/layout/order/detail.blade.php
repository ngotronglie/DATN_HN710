@extends('admin.dashboard')

@section('content')
    <div class="breadcrumbs mb-5">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Chi tiết đơn hàng</h1>
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
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Thông tin người dùng</strong>
                            <a href="{{ route('admin.order.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-1"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    @if ($order->user)
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
                                    @else
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
                                    @endif
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
                                        <td>{{ $order->note }}</td>
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
                                                @if ($orderDetail->productVariant)
                                                    <td><img width="100"
                                                            src="{{ Storage::url($orderDetail->productVariant->product->img_thumb) }}"
                                                            alt=""></td>
                                                    <td>{{ $orderDetail->productVariant->product->name }}</td>
                                                    <td>{{ $orderDetail->quantity }}</td>
                                                    <td>{{ number_format($orderDetail->productVariant->price_sale) }} VND
                                                    </td>
                                                    <td>{{ $orderDetail->productVariant->size->name }}</td>
                                                    <td>{{ $orderDetail->productVariant->color->name }}</td>
                                                    <td>{{ number_format($orderDetail->quantity * $orderDetail->productVariant->price_sale) }}
                                                        VND</td>
                                                @else
                                                    <td>
                                                        <span>Không tồn tại</span>
                                                    </td>
                                                    <td>{{ $orderDetail->product_name }}</td>
                                                    <td>{{ $orderDetail->quantity }}</td>
                                                    <td>{{ number_format($orderDetail->price) }} VND</td>
                                                    <td>{{ $orderDetail->size_name }}</td>
                                                    <td>{{ $orderDetail->color_name }}</td>
                                                    <td>{{ number_format($orderDetail->quantity * $orderDetail->price) }}
                                                        VND</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6">
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
                                            <td colspan="2"  class="text-center">
                                                {{ number_format($totalPrice, 0, ',', '.') }} VND
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <strong>Mã giảm giá:</strong>
                                            </td>
                                            <td colspan="2"  class="text-center">
                                                @if ($order->voucher)
                                                    {{ $order->voucher->code }} (-{{ $order->voucher->discount }}%)
                                                @else
                                                    Không có mã giảm giá
                                                @endif
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="6">
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
                                                @endphp
                                                <strong>Tổng tiền cuối cùng:</strong>
                                            </td>
                                            <td colspan="2"  class="text-center">
                                                {{ number_format($totalPrice, 0, ',', '.') }} VND
                                            </td>

                                        </tr>



                                    </tbody>
                                </table>
                                <div style="float: right">


                                    @if ($order->status != 6 && $order->status !=4)
                                        Cập nhật đơn hàng:
                                        @if ($order->status == 1)
                                            <a class="btn btn-success"
                                                href="{{ route('admin.order.confirmOrder', $order->id) }}"><i
                                                    class="fa fa-check"></i></a>
                                        @elseif($order->status == 2)
                                            <a class="btn btn-info"
                                                href="{{ route('admin.order.shipOrder', $order->id) }}"><i
                                                    class="fa fa-truck"></i></a>
                                        @elseif($order->status == 3)
                                            <a class="btn btn-success"
                                                href="{{ route('admin.order.confirmShipping', $order->id) }}"><i
                                                    class="fa fa-check-circle-o"></i></a>
                                        @elseif($order->status == 5)
                                            <a class="btn btn-danger"
                                                href="{{ route('admin.order.cancelOrder', $order->id) }}"><i
                                                    class="fa fa-times-circle"></i></a>
                                        @endif
                                    @endif
                                    @if ($order->status == 2 || ($order->payment_status == 'paid' && $order->payment_method == 'cod'))
                                    <a class="btn btn-hover-d btn-dark ml-2" target="_blank" href="{{route('admin.order.printOrder', $order->order_code)}}" title="In đơn hàng">
                                        <i class="fa fa-print"></i>
                                    </a>
                                @endif
                                </div>
                            @endif

                        </div>

                    </div>

                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

@endsection
