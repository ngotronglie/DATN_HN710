<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="background-color: #007bff; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">Hóa đơn</h1>
            <p style="margin: 5px 0; font-size: 14px;">Cửa hàng: Fashion Wave</p>
            <p style="margin: 5px 0; font-size: 14px;">Địa chỉ: 132 Xuân Phương - Hà Nội</p>
            <p style="margin: 5px 0; font-size: 14px;">Số điện thoại: 0123 456 789</p>
        </div>

        <!-- Thông tin khách hàng -->
        <div style="padding: 20px;">
            <p style="margin: 0 0 10px 0;">Xin chào <strong>{{ $order->user_name }}</strong>,</p>
            <p style="margin: 0 0 10px 0;">Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Dưới đây là thông tin đơn hàng:</p>
            <p style="margin: 10px 0;"><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</p>
            <p style="margin: 10px 0;"><strong>Người đặt hàng:</strong> {{ $order->user_name }}</p>
            <p style="margin: 10px 0;"><strong>Email:</strong> {{ $order->user_email }}</p>
            <p style="margin: 10px 0;"><strong>Số điện thoại:</strong> {{ $order->user_phone }}</p>
            <p style="margin: 10px 0;"><strong>Địa chỉ giao hàng:</strong> {{ $order->user_address }}</p>
            <p style="margin: 10px 0;"><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</p>

        </div>

        <!-- Thông tin đơn hàng -->
        <div style="padding: 20px;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f4f4f4;">Sản phẩm</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f4f4f4;">Kích cỡ</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f4f4f4;">Màu sắc</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f4f4f4;">Số lượng</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f4f4f4;">Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $detail)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->product_name }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->size_name }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->color_name }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->quantity }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($detail->price) }} VND</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="margin: 10px 0;"><strong>Phí vận chuyển</strong> {{ number_format(30000) }} VND</p>
            <p style="margin: 10px 0;">
                <strong>Mã giảm giá:</strong> 
                {{ $order->voucher ? $order->voucher->discount .'%' : 'Không áp dụng' }}
            </p>
            
            <p style="margin: 10px 0;"><strong>Tổng tiền:</strong> {{ number_format($order->total_amount) }} VND</p>
            <p style="margin: 10px 0;"><strong>Phương thức thanh toán:</strong> {{ ucfirst($order->payment_method) }}</p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f1f1f1; text-align: center; padding: 10px; font-size: 14px; color: #555;">
            <p style="margin: 0;">Cảm ơn bạn đã mua sắm tại <strong>Fashion Wave</strong>!</p>
            <p style="margin: 0;">&copy; {{ date('Y') }} Fashion Wave. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
