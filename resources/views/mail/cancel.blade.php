<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xin lỗi quý khách</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="background-color: #dc3545; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">Thông báo</h1>
            <p style="margin: 5px 0; font-size: 14px;">Cửa hàng: Fashion Wave</p>
            <p style="margin: 5px 0; font-size: 14px;">Địa chỉ: 132 Xuân Phương - Hà Nội</p>
            <p style="margin: 5px 0; font-size: 14px;">Số điện thoại: 0376 900 771</p>
        </div>
        <div style="padding: 20px;">
            <p style="margin: 0 0 10px 0;">Xin chào <strong>{{ $order->user_name }}</strong>,</p>
            <p style="margin: 10px 0;"><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</p>
            <p style="margin: 10px 0;"><strong>Người đặt hàng:</strong> {{ $order->user_name }}</p>
            <p style="margin: 10px 0;"><strong>Email:</strong> {{ $order->user_email }}</p>
            <p style="margin: 10px 0;"><strong>Số điện thoại:</strong> {{ $order->user_phone }}</p>
            @php
            use App\Models\Province;
            use App\Models\District;
            use App\Models\Ward;

            $addressParts = explode(',', $order->user_address);
            $addressData = [
            'province' => isset($addressParts[3])
            ? Province::where('code', trim($addressParts[3]))->value('full_name')
            : null,
            'district' => isset($addressParts[2])
            ? District::where('code', trim($addressParts[2]))->value('full_name')
            : null,
            'ward' => isset($addressParts[1])
            ? Ward::where('code', trim($addressParts[1]))->value('full_name')
            : null,
            'addressDetail' => isset($addressParts[0]) ? $addressParts[0] : null,
            ];
            @endphp
            <p style="margin: 10px 0;">
                <strong>Địa chỉ giao hàng:</strong> {{ implode(
                                    ', ',
                                    array_filter(
                                        [$addressData['addressDetail'], $addressData['ward'], $addressData['district'], $addressData['province']],
                                        function ($value) {
                                            return !is_null($value) && $value !== '';
                                        }
                                    )
                                ) }}
            </p>
            <p style="margin: 10px 0;"><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
            <p style="margin: 0 0 10px 0; font-size: 14px; color: #555;"><strong>Lý do:</strong> Rất tiếc, đơn hàng của bạn không thể xử lý vì các sản phẩm sau đã vượt quá số lượng tồn kho:</p> 
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
                        @if($detail->quantity > $detail->stock_quantity)
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->product_name }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->size_name }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->color_name }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $detail->quantity }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($detail->price) }} VND</td>    
                        </tr>
                        @endif
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