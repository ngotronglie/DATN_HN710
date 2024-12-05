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
                            <strong>Thông tin người mua</strong>
                            <a href="{{ route('admin.order.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-1"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body">
                            @if($order->user_id != null)
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
                                        <td>
                                            @if($order->user->phone)
                                            {{ $order->user->phone }}
                                            @else
                                            Chưa cập nhật!
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ</th>
                                        <td>
                                            @if($order->user->address)
                                            {{ implode(', ', array_filter([
                                                        $addressData['addressDetail'],
                                                        $addressData['ward'],
                                                        $addressData['district'],
                                                        $addressData['province']
                                                    ], function($value) {
                                                        return !is_null($value) && $value !== '';
                                                    })) }}
                                            @else
                                            Chưa cập nhật!
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @elseif($order->user_id == null)
                            <strong>Khách vãng lai</strong>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Thông tin người nhận</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <td>{{ $order->order_code }}</td>
                                    </tr>
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
                                        <td>{{ implode(', ', array_filter([
                                            $addressData['addressDetail'],
                                            $addressData['ward'],
                                            $addressData['district'],
                                            $addressData['province']
                                        ], function($value) {
                                            return !is_null($value) && $value !== '';
                                        })) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Đơn hàng</th>
                                        <td>
                                            @if ($order->status == 1)
                                                <span class="badge badge-warning">Chờ xác nhận</span>
                                            @elseif($order->status == 2)
                                                <span class="badge badge-info">Chờ lấy hàng</span>
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
                                          <td>Không có ghi chú!</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>Ngày đặt hàng</th>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật đơn hàng gần nhất</th>
                                        <td>{{ \Carbon\Carbon::parse($order->updated_at)->format('d/m/Y H:i:s') }}</td>
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh</th>
                                        <th>Tên SP hiện tại</th>
                                        <th>Tên SP lúc mua</th>
                                        <th>Size</th>
                                        <th>Màu</th>
                                        <th>Số lượng</th>
                                        <th>Giá bán</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $orderDetail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($orderDetail->product_variant_id)
                                                <img src="{{ Storage::url($orderDetail->productVariant->product->img_thumb) }}" alt="Product" style="width: 100px; height: 150px; object-fit: contain;">
                                                @else
                                                <span>Không tìm thấy ảnh!</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($orderDetail->product_variant_id)
                                                {{ $orderDetail->productVariant->product->name }}
                                                @else
                                                Sản phẩm hiện tại đã bị xóa
                                                @endif
                                            </td>
                                            <td>{{ $orderDetail->product_name }}</td>
                                            <td>{{ $orderDetail->size_name }}</td>
                                            <td>{{ $orderDetail->color_name }}</td>
                                            <td>{{ $orderDetail->quantity }}</td>
                                            <td>{{ number_format($orderDetail->price, 0, ',', '.') }} VND</td>
                                            <td>{{ number_format($orderDetail->quantity * $orderDetail->price, 0, ',', '.')  }} VND</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6">
                                            @php
                                            // Tính tổng tiền
                                            $totalPrice = $order->orderDetails->sum(function($orderDetail) {
                                            return $orderDetail->quantity * $orderDetail->price;
                                            });
                                            @endphp
                                            <strong>Tổng tiền:</strong>
                                        </td>
                                        <td colspan="3" class="text-center">
                                            {{ number_format($totalPrice, 0, ',', '.') }} VND
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <strong>Giảm {{ $order->discount }}%</strong>
                                        </td>
                                        <td colspan="3" class="text-center">
                                            @if($order->discount)
                                            {{ '- ' . number_format(($totalPrice * $order->discount) / 100, 0, ',', '.') }} VND
                                            @else
                                                Không áp dụng voucher
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <strong>Phí vận chuyển:</strong>
                                        </td>
                                        <td colspan="3" class="text-center">
                                            {{ '+ '.number_format(30000, 0, ',', '.') }} VND
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <strong>Tổng tiền cuối cùng:</strong>
                                        </td>
                                        <td colspan="3" class="text-center">
                                            {{ number_format($order->total_amount, 0, ',', '.') }} VND
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center">
                            <p><strong>Mã Voucher:</strong>
                                @if($order->voucher_id && $order->discount)
                                    {{ $order->voucher->code ?? 'Không xác định' }}
                                    ({{ $order->voucher->discount ?? 'N/A' }}% giảm giá)
                                @elseif(!$order->voucher_id && !$order->discount)
                                    Không áp dụng voucher
                                @elseif($order->voucher_id == null && $order->discount != null)
                                    Voucher đã bị xóa!
                                @else
                                    Không xác định!
                                @endif
                            </p>
                            <div>
                            <div>
                                @if ($order->status != 6 && $order->status != 4)
                                    Cập nhật đơn hàng:
                                    @if ($order->status == 1)
                                        <a class="btn btn-success" onclick="return confirm('Bạn có chắc chắn muốn xác nhận đơn hàng này không?');" title="Chờ lấy hàng"
                                            href="{{ route('admin.order.confirmOrder', $order->id) }}"><i
                                                class="fa fa-check"></i></a>
                                    @elseif($order->status == 2)
                                        <a class="btn btn-info" onclick="return confirm('Bạn có chắc chắn muốn giao đơn hàng này không?');" title="Đang giao hàng"
                                            href="{{ route('admin.order.shipOrder', $order->id) }}"><i
                                                class="fa fa-truck"></i></a>
                                    @elseif($order->status == 3)
                                        <a class="btn btn-success" onclick="return confirm('Bạn có chắc chắn đơn hàng này đã được giao không?');" title="Giao hàng thành công"
                                            href="{{ route('admin.order.confirmShipping', $order->id) }}"><i
                                                class="fa fa-check-circle-o"></i></a>
                                    @elseif($order->status == 5)
                                        <a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');" title="Đã hủy"
                                            href="{{ route('admin.order.cancelOrder', $order->id) }}"><i
                                                class="fa fa-times-circle"></i></a>
                                    @endif
                                @endif
                            </div>
                            <div>
                                @if ($order->status == 2 || $order->status == 4)
                                In hóa đơn:
                                    <a class="btn btn-hover-d btn-dark ml-2" target="_blank" onclick="return confirm('Bạn có muốn in hóa đơn, đơn hàng này không?');"
                                        href="{{ route('admin.order.printOrder', $order->order_code) }}"
                                        title="In đơn hàng">
                                        <i class="fa fa-print"></i>
                                    </a>
                                @endif
                            </div>
                            </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

@endsection
