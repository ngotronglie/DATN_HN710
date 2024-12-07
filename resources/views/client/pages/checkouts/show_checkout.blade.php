@extends('client.index')
@section('style')
    <style>
        .checkbox-form {
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .checkbox-form .title {
            margin-top: 9px !important;

            margin-bottom: 42px !important;
            color: #333;
        }

        .checkout-form-list label {
            font-weight: 500;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .checkout-form-list {
            margin-bottom: 24px !important;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
        }

        /* Select2 Styles */
        .select2-container--default .select2-selection--single {
            height: 40px !important;
            border: 1px solid #dfdcdc !important;
            border-radius: 4px;
            transition: all 0.3s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
            font-size: 14px;
            color: #716f6f !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
        }

        textarea.form-control {
            resize: none;
        }

        .required {
            color: rgb(247, 49, 49);
        }
    </style>
@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section">
        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Thanh toán</h1>
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ</a>
                        </li>
                        <li class="active">Thanh toán</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Start -->
    <div class="section section-margin">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (Auth::check())
                        <!-- Coupon Accordion Start -->
                        <div class="coupon-accordion">
                            <!-- Title Start -->
                            <h3 class="title">Có phiếu giảm giá? <span id="showcoupon">Nhấp vào đây để nhập mã của
                                    bạn</span></h3>
                            <!-- Title End -->

                            <!-- Checkout Coupon Start -->
                            <div id="checkout_coupon" class="coupon-checkout-content">
                                <div class="coupon-info">
                                    <div id="saved-vouchers" class="mt-4">
                                        <div class="row">
                                            @foreach ($validVouchers as $voucher)
                                                <div class="col-md-4 mb-3">
                                                    <div class="card shadow-sm border-0">
                                                        <div class="card-body d-flex align-items-center">
                                                            <!-- Icon voucher -->
                                                            <div class="voucher-icon mr-3 text-primary"
                                                                style="font-size: 24px;">
                                                                <i class="fa fa-tags"></i>
                                                            </div>
                                                            <!-- Mã voucher -->
                                                            <div class="voucher-details flex-grow-1">
                                                                <h6 class="mb-1 text-dark font-weight-bold">
                                                                    {{ $voucher->code }}</h6>
                                                                <small class="text-muted">Giảm giá:
                                                                    {{ $voucher->discount ?? 0 }}%</small>
                                                                <br>
                                                                @php
                                                                    $minMoney = $voucher->min_money;
                                                                    $maxMoney = $voucher->max_money;
                                                                    $formattedMinMoney =  $minMoney >= 1_000_000 ? number_format ( $minMoney / 1_000_000, 0, ',','', )
                                                                    . 'tr' : number_format( $minMoney / 1_000, 0,',','',) . 'k';
                                                                    $formattedMaxMoney =
                                                                        $maxMoney >= 1_000_000 ? number_format( $maxMoney / 1_000_000, 0,',','', )
                                                                    . 'tr' : number_format(   $maxMoney / 1_000, 0,',', '', ) . 'k';
                                                                @endphp
                                                                <small>Tối thiểu: {{ $formattedMinMoney }} - Tối đa:
                                                                    {{ $formattedMaxMoney }}</small>
                                                                <br>
                                                                <small>HSD:
                                                                    {{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</small>
                                                            </div>
                                                            <!-- Nút sử dụng -->
                                                            <button class="btn btn-outline-primary btn-sm use-voucher"
                                                                data-code="{{ $voucher->code }}"
                                                                data-used="{{ session('active_voucher') === $voucher->code ? 'true' : 'false' }}">
                                                                @if (session('active_voucher') === $voucher->code)
                                                                    Đã dùng
                                                                @else
                                                                    Dùng
                                                                @endif
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Checkout Coupon End -->
                        </div>
                        <!-- Coupon Accordion End -->
                    @endif
                </div>

            </div>
            <form id="addressForm" action="{{ route('placeOrder') }}" method="post">
                @csrf
                <div class="row mb-n4">

                    <div class="col-lg-6 col-12 mb-4">
                        <!-- User Information Form Start -->
                        <div class="checkbox-form">
                            <h3 class="title">Thông tin người nhận</h3>
                            <div class="row">
                                <!-- Name Input Start -->
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label for="name">Tên người nhận <span class="required">(*)</span></label>
                                        <input id="name" placeholder="Nhập tên người nhận" type="text"
                                            name="name" value="{{ old('name', Auth::user()->name ?? '') }}"
                                            class="form-control userName">
                                        <small class="error-message text-danger"></small>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label for="email">Email <span class="required">(*)</span></label>
                                        <input id="email" placeholder="Nhập email" type="email" name="email"
                                            value="{{ old('email', Auth::user()->email ?? '') }}" class="form-control userEmail">
                                            <small class="error-message text-danger"></small>
                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label for="phone">Số điện thoại <span class="required">(*)</span></label>
                                        <input id="phone" type="text" name="phone" placeholder="Nhập số điện thoại"
                                            value="{{ old('phone', Auth::user()->phone ?? '') }}" class="form-control userPhone">
                                            <small class="error-message text-danger"></small>
                                            @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                @php
                                    $user = Auth::user();
                                    if (!empty($user->address)) {
                                        $addressParts = explode(',', $user->address);
                                        $city = isset($addressParts[count($addressParts) - 1])
                                            ? trim($addressParts[count($addressParts) - 1])
                                            : null;
                                        $district = isset($addressParts[count($addressParts) - 2])
                                            ? trim($addressParts[count($addressParts) - 2])
                                            : null;
                                        $ward = isset($addressParts[count($addressParts) - 3])
                                            ? trim($addressParts[count($addressParts) - 3])
                                            : null;
                                        $adressDetail = isset($addressParts[count($addressParts) - 4])
                                            ? trim($addressParts[count($addressParts) - 4])
                                            : null;
                                    } else {
                                        $city = $district = $ward = $adressDetail = null;
                                    }
                                @endphp

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label for="province">Tỉnh/Thành phố <span class="required">(*)</span></label>
                                        <select class="form-control province select2" data-id="{{ $city }}"
                                            name="provinces">
                                            <option value="">[Chọn thành phố]</option>
                                            @foreach ($provinces as $item)
                                                <option value="{{ $item->code }}"
                                                    {{ $city == $item->code ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="error-message-province text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label for="district">Quận/Huyện <span class="required">(*)</span></label>
                                        <select class="form-control districts select2" data-id="{{ $district }}"
                                            name="districs">
                                            <option value="">[Chọn Quận/Huyện]</option>
                                        </select>
                                        <small class="error-message-districts text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label for="ward">Phường/Xã <span class="required">(*)</span></label>
                                        <select class="form-control wards select2" data-id="{{ $ward }}"
                                            name="wards">
                                            <option value="">[Chọn Phường/Xã]</option>
                                        </select>
                                        <small class="error-message-wards text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label for="address">Tên đường/tòa nhà/số nhà <span
                                                class="required">(*)</span></label>
                                        <input id="address" type="text" name="address" class="form-control input_address"
                                            placeholder="Tên đường/tòa nhà/số nhà" value="{{ $adressDetail }}">
                                            <small class="error-address text-danger"></small>
                                    </div>
                                </div>

                                @if ($errors->has('provinces') || $errors->has('address') || $errors->has('wards') || $errors->has('districs'))
                                    <small class="text-danger">Vui lòng nhập đầy đủ các trường địa chỉ</small>
                                @endif


                                <!-- Notes Input Start -->
                                <div class="order-notes mt-3 mb-n2">
                                    <div class="checkout-form-list checkout-form-list-2">
                                        <label for="note">Ghi chú</label>
                                        <textarea id="note" name="note" class="form-control" placeholder="Ghi chú về đơn hàng của bạn">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                                <!-- Notes Input End -->
                            </div>
                        </div>
                        <!-- User Information Form End -->
                    </div>


                    <div class="col-lg-6 col-12 mb-4">
                        <!-- Order Summary Start -->
                        <div class="your-order-area border">
                            <h3 class="title">Đơn hàng của bạn</h3>

                            <!-- Order Table Start -->
                            <div class="your-order-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="cart-product-head">
                                            <th class="cart-product-name text-start">Sản phẩm</th>
                                            <th class="cart-product-total text-end">Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    {{ $product->name }} /
                                                    <span>
                                                        {{ $product->size->name }} /
                                                        {{ $product->color->name }} /
                                                        x{{ $product->quantity }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format($product->sumtotal, 0, ',', '.') }} đ
                                                </td>
                                            </tr>

                                            <input type="hidden" name="product_name[]" value="{{ $product->name }}">
                                            <input type="hidden" name="size_name[]" value="{{ $product->size->name }}">
                                            <input type="hidden" name="color_name[]"
                                                value="{{ $product->color->name }}">
                                            <input type="hidden" name="quantity[]" value="{{ $product->quantity }}">
                                            <input type="hidden" name="price[]" value="{{ $product->price }}">
                                            <input type="hidden" name="product_variant_ids[]"
                                                value="{{ $product->id }}">
                                        @endforeach

                                        <input type="hidden" name="total_amount" value="{{ $total }}">


                                    </tbody>
                                    <tfoot>

                                        <tr class="cart-subtotal">
                                            <th class="text-start ps-0">Tổng Cộng</th>
                                            <td class="text-end pe-0">
                                                <span class="amount">{{ number_format($total, 0, ',', '.') }} đ</span>
                                            </td>
                                        </tr>
                                        <tr class="cart-subtotal">
                                            <th class="text-start ps-0">Phí vận chuyển</th>
                                            <td class="text-end pe-0">
                                                <span class="amount">+30,000 đ</span>
                                            </td>
                                        </tr>
                                        @if (Auth::check())
                                            <tr class="cart-subtotal">
                                                <th class="text-start ps-0">Giảm giá</th>
                                                <td class="text-end pe-0">

                                                    <span class="amount" id="discount-amount">
                                                        -
                                                        {{ session('voucher_id') ? number_format(session('discount')) : 0 }}
                                                        đ
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr class="order-total">
                                            <th class="text-start ps-0">Tổng Tiền</th>
                                            <td class="text-end pe-0">
                                                <strong>
                                                    <span class="amount" id="total-amount">
                                                        {{ session('voucher_id') ? number_format(session('totalAmountWithDiscount')) : number_format($total + 30000, 0, ',', '.') }}
                                                        đ
                                                    </span>
                                                </strong>
                                            </td>
                                        </tr>
                                        @php
                                            $pointsToAdd = floor($total / 100000) * 10;
                                        @endphp
                                        @if (Auth::check())
                                        <tr class="cart-subtotal">
                                            <th class="text-start ps-0" style="font-size: 17px">Nhận điểm</th>
                                            <td class="text-end pe-0">
                                                <span class="amount">+{{ $pointsToAdd }} điểm sau khi đơn hàng được giao
                                                    thành công
                                                </span>
                                            </td>
                                        </tr>
                                        @else
                                        <tr class="cart-subtotal">
                                            <th class="text-start ps-0" style="font-size: 17px">Nhận điểm</th>
                                            <td class="text-end pe-0">
                                                <a style="color: #de1d1d;" href="/login">Đăng nhập</a>
                                                <span class="amount"> để nhận +{{ $pointsToAdd }} điểm và đổi lấy ưu đãi hấp dẫn
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                            <!-- Order Table End -->

                            <!-- Payment Options Start -->
                            <div class="payment-accordion-order-button">
                                <div class="payment-options">
                                    @error('payment_method')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="bankTransfer" value="cod" checked>
                                        <label class="form-check-label" for="bankTransfer">
                                            Thanh toán khi nhận hàng (COD)
                                        </label>
                                        <div class="payment-description mt-2">
                                            <p>Vui lòng thanh toán cho người giao hàng.</p>
                                        </div>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="cheque" value="online">
                                        <label class="form-check-label" for="cheque">
                                            Thanh toán online
                                        </label>
                                        <div class="payment-description mt-2" style="display: none;">
                                            <p>Chuyển khoản trực tiếp vào tài khoản ngân hàng của chúng tôi. Vui lòng sử
                                                dụng Mã Đơn hàng làm tham chiếu. Đơn hàng của bạn sẽ không được vận chuyển
                                                cho đến khi tiền đã được chuyển vào tài khoản của chúng tôi.</p>
                                        </div>
                                    </div>
                                </div>



                                <div class="order-button-payment">
                                    <button type="submit" class="btn btn-dark btn-hover-primary rounded-0 w-100">Đặt
                                        hàng</button>
                                </div>
                            </div>
                            <!-- Payment Options End -->
                        </div>

                        <!-- Order Summary End -->
                    </div>

                </div>
            </form>
        </div>
    </div>



@endsection
@section('script')
    <script src="{{ asset('plugins/js/location.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.userName').on('input', function () {
                $('.userName').next('.error-message').html('');
            });

            $('.userEmail').on('input', function () {
                $('.userEmail').next('.error-message').html('');
            });

            $('.userPhone').on('input', function () {
                $('.userPhone').next('.error-message').html('');
            });

            $('#addressForm').submit(function (event) {
                let isValid = true;

                $('.error-message').text('');

                if ($('.userName').val() == '') {
                    $('.userName').next('.error-message').html('Vui lòng nhập tên người nhận.');
                    isValid = false;
                }

                if ($('.userEmail').val() == '') {
                    $('.userEmail').next('.error-message').html('Vui lòng nhập email.');
                    isValid = false;
                }else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test($('.userEmail').val())) {
                     $('.userEmail').next('.error-message').html('Vui lòng nhập email hợp lệ.');
                     isValid = false;
                }

                if ($('.userPhone').val() == '') {
                    $('.userPhone').next('.error-message').html('Vui lòng nhập số điện thoại.');
                    isValid = false;
                } else if (!/^(0(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9]))[0-9]{7}$/.test($('.userPhone').val())) {
                    $('.userPhone').next('.error-message').html('Vui lòng nhập số điện thoại di động hợp lệ.');
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });

        $(document).ready(function() {
            //Aps vourcher
            $(document).on('click', '.use-voucher', function() {
                let voucherButton = $(this);
                let voucherCode = voucherButton.data('code');
                $.ajax({
                    url: '{{ route('voucher.apply') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        voucher_code: voucherCode
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.message,
                            });

                            $('.use-voucher').each(function() {
                                $(this).data('used', 'false').text('Dùng').removeClass(
                                    'disabled').attr('disabled', false);
                            });

                            voucherButton.data('used', 'true').text('Đã dùng').addClass(
                                'disabled').attr('disabled', true);

                            $('#total-amount').text(response.totalAmountWithDiscount
                                .toLocaleString() + ' đ');
                            $('#discount-amount').text('-' + response.discount
                                .toLocaleString() + ' đ');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: response.message,
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Đã xảy ra lỗi khi áp dụng mã giảm giá.',
                        });
                    }
                });
            });

            //  mô tả phương thức thanh toán
            document.querySelectorAll('input[name="payment_method"]').forEach((elem) => {
                elem.addEventListener('change', function() {
                    document.querySelectorAll('.payment-description').forEach((desc) => {
                        desc.style.display = 'none';
                    });
                    this.closest('.form-check').querySelector('.payment-description').style
                        .display = 'block';
                });
            });
        });
    </script>
@endsection
