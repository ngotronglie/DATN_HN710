@extends('client.index')

@section('main')
<div class="section">
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Thanh toán</h1>
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="active">Thanh toán</li>
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
                    <h4 class="font-weight-bold mb-4">Đặt Hàng Thành Công</h4>
                </div>

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="alert alert-success text-center">
                            <p style="font-size: 16px; font-weight: bold;">
                                Mã đơn hàng #<span id="orderCode">{{ $order->order_code }}</span>
                                <i id="copyIcon" title="Sao chép" class="fa fa-copy" style="cursor: pointer; color: blue; margin-left: 10px;" onclick="copyToClipboard('{{ $order->order_code }}')"></i>
                            </p>
                            <p class="text-muted">
                                <strong>Thông tin giao hàng:</strong><br>
                                Tên: {{ $order->user_name }}<br>
                                Điện thoại: {{ $order->user_phone }}<br>
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
                                Địa chỉ: {{ implode(
                                    ', ',
                                    array_filter(
                                        [$addressData['addressDetail'], $addressData['ward'], $addressData['district'], $addressData['province']],
                                        function ($value) {
                                            return !is_null($value) && $value !== '';
                                        }
                                    )
                                ) }}
                            </p>
                            <p class="text-muted">
                                <strong>Phương thức thanh toán:</strong><br>
                                <i class="fa {{ $order->payment_method === 'cod' ? 'fa-truck' : 'fa-credit-card' }}"></i>
                                {{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán trực tuyến (Online)' }}
                            </p>
                            <p class="mt-4" style="font-size: 16px;">Cảm ơn bạn đã mua hàng!</p>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-success rounded-pill px-4 py-2">Tiếp tục mua hàng</a>
                            <a href="{{ route('bill.search') }}" class="btn btn-outline-warning rounded-pill px-4 py-2">Tra cứu đơn hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')
<script>
    // sao chép mã đơn hàng
    function copyToClipboard(text) {
        var tempInput = document.createElement("input");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        var copyIcon = document.getElementById("copyIcon");
        if (copyIcon) {
            copyIcon.className = "fa fa-check";
            copyIcon.style.color = "green";
            copyIcon.title = "Đã sao chép!";

            // Reset lại biểu tượng
            setTimeout(() => {
                copyIcon.className = "fa fa-copy";
                copyIcon.style.color = "blue";
                copyIcon.title = "Sao chép";
            }, 3000);
        }
    }
</script>
@endsection
