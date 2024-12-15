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

<div class="section section-margin" data-aos="fade-up" data-aos-delay="300">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fa fa-check-circle" style="font-size: 50px; color: #60ce47;"></i>
                            <h3 class="font-weight-bold mt-3">Đặt Hàng Thành Công</h3>
                            <p class="text-muted">Mã đơn hàng của bạn: <span class="text-primary">{{ $order->order_code }}<i id="copyIcon" title="Sao chép" class="fa fa-copy" style="cursor: pointer; color: blue; margin-left: 10px;" onclick="copyToClipboard('{{ $order->order_code }}')"></i></span>. </p>
                            <p>Bạn có thể dùng mã này để tra cứu trạng thái đơn hàng.<p>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-4">
                                <div class="card p-3 shadow-sm border-0 rounded-3">
                                    <h5 class="font-weight-bold" style="text-align: center">Thông tin giao hàng</h5>
                                    <p class="text-muted mb-1"><strong>Tên người nhận:</strong> {{ $order->user_name }}</p>
                                    <p class="text-muted mb-1"><strong>Điện thoại:</strong> {{ $order->user_phone }}</p>
                                    <p class="text-muted mb-1"><strong>Địa chỉ:</strong>
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
                                        {{ implode(', ', array_filter([$addressData['addressDetail'], $addressData['ward'], $addressData['district'], $addressData['province']])) }}
                                    </p>
                                    <p class="text-muted mb-1"><strong>Phương thức thanh toán:</strong> <br>
                                        <i class="fa {{ $order->payment_method === 'cod' ? 'fa-truck' : 'fa-credit-card' }}"></i>
                                        {{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán trực tuyến (Online)' }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card p-3 shadow-sm border-0 rounded-3">
                                    <h5 class="font-weight-bold" style="text-align: center">Thông tin thêm</h5>
                                    <p class="text-muted mb-1">Đơn hàng của bạn sẽ được giao trong vòng 3-7 ngày làm việc.</p>
                                    <p class="text-muted mb-1">Chúng tôi sẽ gửi thông báo qua Email khi đơn hàng có vấn đề.</p>
                                    <p class="text-muted mb-2">Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ qua Zalo: <strong class="text-primary">0376 900 771</strong>.</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('home') }}"  style="color: white;background: #2ca9fc" class="rounded-pill px-5 py-3 mx-2">
                                <i class="fa fa-shopping-cart"></i> Tiếp tục mua hàng
                            </a>
                            <a href="{{ route('bill.search') }}" style="color: white;background: #ff4949" class="rounded-pill px-5 py-3 mx-2">
                                <i class="fa fa-search"></i> Tra cứu đơn hàng
                            </a>
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
