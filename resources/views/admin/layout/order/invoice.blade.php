<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    
    <style>
        body {
            font-family: DejaVu Sans;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .info, .details {
            margin: 20px 0;
        }
        .info h2, .details h2 {
            font-size: 20px;
            color: #444;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 5px;
        }
        .info table, .details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .info th, .details th, .info td, .details td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .info th, .details th {
            background-color: #f2f2f2;
            color: #555;
        }
        .info td, .details td {
            color: #666;
        }
        .summary {
            text-align: right;
            margin-top: 20px;
        }
        .summary h3 {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>HÓA ĐƠN</h1>
            <p><strong>Website:</strong> www.example.com</p>
            <p><strong>Email:</strong> support@example.com | <strong>Điện thoại:</strong> 0123456789</p>
            <p><strong>Ngày tạo:</strong> {{ $date }}</p>
        </div>

        <div class="info">
            <h2>Thông Tin Khách Hàng</h2>
            <table>
                <tr>
                    <th>Họ và tên</th>
                    <td>{{ $order->user ? $order->user->name : $order->user_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $order->user ? $order->user->email : $order->user_email }}</td>
                </tr>
                <tr>
                    <th>Điện thoại</th>
                    <td>{{ $order->user ? $order->user->phone : $order->user_phone }}</td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td>{{ $order->address ? $order->user->address : $order->user_address }}</td>
                </tr>
                <tr>
                    <th>Ngày đặt hàng</th>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>

        <div class="details">
            <h2>Chi Tiết Đơn Hàng</h2>
            <div style="text-align: left;">
                <p><strong>Mã Hóa Đơn:</strong> {{ $order->order_code }}</p>
                <p><strong>Phương Thức Thanh Toán:</strong> {{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Thanh toán online' }}</p>
                <p><strong>Trạng Thái Thanh Toán:</strong> {{ $order->payment_method === 'cod' ? 'Chưa thanh toán' : 'Đã thanh toán' }}</p>
            </div>
            <table>
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
                @foreach ($order->orderDetails as $detail)
                    @php
                        $productName = $detail->productVariant ? $detail->productVariant->product->name : $detail->product_name;
                        $quantity = $detail->quantity;
                        $size = $detail->productVariant ? $detail->productVariant->size->name : $detail->size_name;
                        $color = $detail->productVariant ? $detail->productVariant->color->name : $detail->color_name;
                        $price = number_format($detail->productVariant ? $detail->productVariant->price_sale : $detail->price, 0, ',', '.');
                        $total = number_format(($detail->productVariant ? $detail->productVariant->price_sale : $detail->price) * $quantity, 0, ',', '.');
                    @endphp
                    <tr>
                        <td>{{ $productName }}</td>
                        <td>{{ $size }}</td>
                        <td>{{ $color }}</td>
                        <td>{{ $quantity }}</td>
                        <td>{{ $price }} VND</td>
                        <td>{{ $total }} VND</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5"><strong>Tổng tiền</strong></td>
                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                </tr>
                <tr>
                    <td colspan="5"><strong>Thành Tiền</strong></td>
                    <td>{{ $order->payment_method === 'cod' ? number_format($order->total_amount, 0, ',', '.') : '0' }} VND</td>
                </tr>
            </table>
        </div>

        <div class="summary">
            <h3>Cảm ơn bạn đã đặt hàng!</h3>
