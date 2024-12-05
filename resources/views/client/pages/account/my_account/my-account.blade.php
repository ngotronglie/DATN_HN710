@extends('client.index')
@section('style')
<style>

.select2-container--default .select2-selection--single {
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #495057;
    line-height: 1.5;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%;
    top: 0;
    right: 10px;
    width: 2rem;
}

.select2-container .select2-dropdown {
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
}

.select2-results__option--highlighted[aria-selected] {
    background-color: #007bff;
    color: white;
}

.input_address{
    outline: none;
    height: 39px;
    border-radius: 0.25rem;
    border: 1px solid #c4c2c2 !important;
}

</style>
@endsection
@section('main')
    <!-- my account wrapper start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Tài khoản của tôi</h1>
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ</a>
                        </li>
                        <li class="active">Tài khoản của tôi</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- My Account Section Start -->
    <div class="section section-margin">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">

                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" data-bs-toggle="tab" data-bs-target="#dashboad"><i
                                            class="fa fa-dashboard"></i> Thông tin chung</a>
                                    <a href="#orders" data-bs-toggle="tab" data-bs-target="#orders"><i
                                            class="fa fa-cart-arrow-down"></i>Đơn hàng</a>
                                    <a href="#download" data-bs-toggle="tab" data-bs-target="#download"><i
                                            class="fa fa-solid fa-lock"></i> Đổi mật khẩu</a>
                                    <a href="#payment-method" data-bs-toggle="tab" data-bs-target="#payment-method"><i
                                            class="fa fa-credit-card"></i> Mã giảm giá của tôi</a>
                                    <a href="#point" data-bs-toggle="tab" data-bs-target="#point"><i
                                            class="fa fa-credit-card"></i> Đổi điểm</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Thông tin cá nhân</h3>
                                            <div class="account-details-form">
                                                <form id="addressForm" action="{{ route('updateMyAcount', $user->id) }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-lg-12 text-center">
                                                        <div class="mb-3">
                                                        @if($user->avatar)
                                                            <img id="profile-image" src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                                        @else
                                                            <img id="profile-image" src="https://via.placeholder.com/150" alt="Avatar" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="single-input-item mb-3">
                                                            <label for="avatar" class="required mb-1">Avatar</label>
                                                        <input type="file" id="avatar" name="avatar" placeholder="Ảnh đại diện" onchange="previewImage()" accept="image/*">
                                                        @error('avatar')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="first-name" class="required mb-1">Tên</label>
                                                                <input type="text" id="first-name1" name="name"
                                                                    placeholder="First Name"
                                                                    value="{{ old('name', $user->name) }}">
                                                                @error('name')
                                                                    <small class="text-danger">
                                                                        {{ $message }}
                                                                    </small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="last-name" class="required mb-1">Email</label>
                                                                <input type="email" id="last-name" placeholder="Email"
                                                                    value="{{ $user->email }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="phone" class="required mb-1">Điện
                                                                    thoại</label>
                                                                <input type="text" id="phone" class="userPhone"
                                                                    placeholder="Điện thoại" name="phone"
                                                                    value="{{ old('phone', $user->phone) }}">
                                                                    <small class="error-message text-danger"></small>
                                                                @error('phone')
                                                                    <small class="text-danger">
                                                                        {{ $message }}
                                                                    </small>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="date_of_birth" class="required mb-1">Ngày
                                                                    sinh</label>
                                                                <input type="date" id="date_of_birth"
                                                                    name="date_of_birth" placeholder="Ngày sinh"
                                                                    value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @php
                                                    if (!empty($user->address)) {
                                                        $addressParts = explode(',', $user->address);
                                                        $city = isset($addressParts[count($addressParts) - 1]) ? trim($addressParts[count($addressParts) - 1]) : null;
                                                        $district = isset($addressParts[count($addressParts) - 2]) ? trim($addressParts[count($addressParts) - 2]) : null;
                                                        $ward = isset($addressParts[count($addressParts) - 3]) ? trim($addressParts[count($addressParts) - 3]) : null;
                                                        $adressDetail = isset($addressParts[count($addressParts) - 4]) ? trim($addressParts[count($addressParts) - 4]) : null;
                                                    } else {
                                                        $city = $district = $ward = $adressDetail= null;
                                                    }
                                                    @endphp

                                                    <h3 class="title">Địa chỉ</h3>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="province" class="required mb-1">Tỉnh/Thành
                                                                    phố</label>
                                                                <select class="select2 province" data-id="{{$city}}" name="provinces">
                                                                    <option value="">[Chọn Thành Phố]</option>
                                                                    @foreach ($provinces as $item)
                                                                        <option value="{{ $item->code }}" {{ $city == $item->code ? 'selected' : '' }}>
                                                                          {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="error-message-province text-danger"></small>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="district"
                                                                    class="required mb-1">Quận/Huyện</label>
                                                                <select class="select2 districts" data-id="{{$district}}" name="districs">
                                                                    <option value="">[Chọn Quận/Huyện]</option>
                                                                </select>
                                                                <small class="error-message-districts text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="ward"
                                                                    class="required mb-1">Phường/Xã</label>
                                                                <select class="select2 wards" data-id="{{$ward}}" name="wards">
                                                                    <option value="">[Chọn Phường/Xã]</option>
                                                                </select>
                                                                <small class="error-message-wards text-danger"></small>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="address" class="required mb-1">Tên đường/tòa
                                                                    nhà/số nhà</label>
                                                                <input style="color: rgb(112, 110, 110)" class="input_address" type="text"
                                                                    placeholder="Tên đường/tòa nhà/số nhà" name="address"
                                                                    value="{{ old('address', $adressDetail) }}">
                                                                    <small class="error-address text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($errors->has('provinces') || $errors->has('address') || $errors->has('wards') || $errors->has('districs'))
                                                    <small class="text-danger">Vui lòng nhập đầy đủ các trường địa chỉ</small>
                                                    @endif

                                                    <div class="single-input-item single-item-button mt-4">
                                                        <button class="btn btn-dark btn-hover-primary rounded-0">Cập
                                                            nhật</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Đơn hàng của tôi</h3>

                                            <!-- Bộ lọc trạng thái -->
                                            <div class="order-status-filter mb-4">
                                                <button class="btn btn-sm btn-primary filter-btn" data-status="all">Tất
                                                    cả</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="1">Chờ xác nhận</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="2">Chờ lấy hàng</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="3">Đang giao hàng</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="4">Giao thành công</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="5">Chờ hủy</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="6">Đã hủy</button>
                                            </div>

                                            <!-- Bảng hiển thị đơn hàng -->
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Mã đơn hàng</th>
                                                            <th>Ngày mua</th>
                                                            <th>Trạng thái</th>
                                                            <th>Tổng tiền</th>
                                                            <th>Hành động</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="order-list">
                                                        @if ($bills->count() > 0)
                                                            @foreach ($bills as $key => $item)
                                                                <tr class="order-card" data-status="{{ $item->status }}">
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>{{ $item->order_code }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                                    </td>
                                                                    <td>
                                                                        @switch($item->status)
                                                                            @case(1)
                                                                                Chờ xác nhận
                                                                            @break

                                                                            @case(2)
                                                                                Chờ lấy hàng
                                                                            @break

                                                                            @case(3)
                                                                                Đang giao hàng
                                                                            @break

                                                                            @case(4)
                                                                                Giao thành công
                                                                            @break

                                                                            @case(5)
                                                                                Chờ hủy
                                                                            @break

                                                                            @case(6)
                                                                                Đã hủy
                                                                            @break

                                                                            @default
                                                                                Không xác định
                                                                        @endswitch
                                                                    </td>
                                                                    <td>{{ number_format($item->total_amount, 0, ',', '.') }}
                                                                        VND</td>
                                                                    <td>
                                                                        <a
                                                                            href="{{ route('viewBillDetail', $item->id) }}">Xem</a>
                                                                        @if ($item->status == 1)
                                                                            | <a href="{{ route('cancelOrder', $item->id) }}"
                                                                                onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">Hủy</a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="6">Không có đơn hàng nào trong trạng thái
                                                                    này.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="download" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Đổi mật khẩu</h3>
                                            <div class="account-details-form">
                                                <form
                                                    action="{{ route('user.updatePassword', ['id' => Auth::user()->id]) }}"
                                                    method="post">
                                                    @csrf

                                                    <div class="single-input-item mb-3">
                                                        <label for="current_password" class="required mb-1">Mật khẩu hiện
                                                            tại</label>
                                                        <div class="input-group">
                                                            <input type="password" id="current_password"
                                                                name="current_password" class="form-control"
                                                                placeholder="Nhập mật khẩu cũ"
                                                                style="padding-right: 40px;">
                                                            <div class="input-group-append"
                                                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                                <span class="input-group-text"
                                                                    onclick="togglePassword('current_password', 'eyeIconCurrent')"
                                                                    style="background: none; border: none;">
                                                                    <i class="fa fa-eye" id="eyeIconCurrent"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        @error('current_password')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="new_password" class="required mb-1">Mật khẩu
                                                                    mới</label>
                                                                <div class="input-group">
                                                                    <input type="password" id="new_password"
                                                                        name="new_password" class="form-control"
                                                                        placeholder="Nhập mật khẩu mới"
                                                                        style="padding-right: 40px;">
                                                                    <div class="input-group-append"
                                                                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                                        <span class="input-group-text"
                                                                            onclick="togglePassword('new_password', 'eyeIconNew')"
                                                                            style="background: none; border: none;">
                                                                            <i class="fa fa-eye" id="eyeIconNew"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                @error('new_password')
                                                                    <small class="text-danger">
                                                                        {{ $message }}
                                                                    </small>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="confirm_password" class="required mb-1">Nhập
                                                                    lại mật khẩu</label>
                                                                <div class="input-group">
                                                                    <input type="password" id="confirm_password"
                                                                        name="new_password_confirmation"
                                                                        class="form-control"
                                                                        placeholder="Nhập lại mật khẩu mới"
                                                                        style="padding-right: 40px;">
                                                                    <div class="input-group-append"
                                                                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                                        <span class="input-group-text"
                                                                            onclick="togglePassword('confirm_password', 'eyeIconConfirm')"
                                                                            style="background: none; border: none;">
                                                                            <i class="fa fa-eye" id="eyeIconConfirm"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                @error('new_password_confirmation')
                                                                    <small class="text-danger">
                                                                        {{ $message }}
                                                                    </small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="single-input-item single-item-button">
                                                        <button class="btn btn-dark btn-hover-primary rounded-0">Đổi mật
                                                            khẩu</button>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Tất cả mã giảm giá</h3>
                                            <div class="btn-group mb-3">
                                                <button class="btn btn-sm btn-primary filter-btn" data-status="all">Tất
                                                    cả</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="used">Đã dùng</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="not_used">Chưa dùng</button>
                                                <button class="btn btn-sm btn-outline-primary filter-btn"
                                                    data-status="expired">Hết hạn</button>
                                            </div>

                                            <div class="row" id="voucher-container">
                                                @if ($vouchers->isNotEmpty())
                                                @foreach ($vouchers as $uservoucher)
                                                <div class="col-md-4 mb-3 voucher-card" data-status="{{ $uservoucher->status }}">
                                                    <div class="card shadow-sm border-0">
                                                        <div class="card-body d-flex align-items-center">
                                                            <div class="voucher-icon text-primary me-3" style="font-size: 24px;">
                                                                <i class="fa fa-tags"></i>
                                                            </div>
                                                            <div class="voucher-details flex-grow-1">
                                                                {{-- <h6 class="mb-1 text-dark fw-bold">{{ $uservoucher->voucher->code }}</h6> --}}
                                                                <small class="text-muted">Giảm giá: {{ $uservoucher->voucher->discount ?? 0 }}%</small>
                                                                <br>
                                                                @php
                                                                    $minMoney = $uservoucher->voucher->min_money;
                                                                    $maxMoney = $uservoucher->voucher->max_money;
                                                                    $formattedMinMoney = $minMoney >= 1_000_000
                                                                        ? number_format($minMoney / 1_000_000, 0, ',', '') . 'tr'
                                                                        : number_format($minMoney / 1_000, 0, ',', '') . 'k';
                                                                    $formattedMaxMoney = $maxMoney >= 1_000_000
                                                                        ? number_format($maxMoney / 1_000_000, 0, ',', '') . 'tr'
                                                                        : number_format($maxMoney / 1_000, 0, ',', '') . 'k';
                                                                @endphp
                                                                <small>Áp dụng: {{ $formattedMinMoney }} - {{ $formattedMaxMoney }}</small>
                                                                <br>
                                                                <small>HSD: {{ \Carbon\Carbon::parse($uservoucher->voucher->end_date)->format('d/m/Y') }}</small>
                                                                <br>
                                                                <span class="badge
                                                                    @if ($uservoucher->status === 'used') bg-success
                                                                    @elseif ($uservoucher->status === 'not_used') bg-primary
                                                                    @elseif ($uservoucher->status === 'expired') bg-danger @endif">
                                                                            @if ($uservoucher->status === 'used')
                                                                                Đã dùng
                                                                            @elseif ($uservoucher->status === 'not_used')
                                                                                Chưa dùng
                                                                            @elseif ($uservoucher->status === 'expired')
                                                                                Hết hạn
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>Không có mã giảm giá nào.</p>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <div class="tab-pane fade" id="point" role="tabpanel">
                                        <div class="myaccount-content">
                                            @php $user = Auth::user() @endphp
                                            <div style="display: flex;justify-content: space-between">
                                                <h3 class="title">Tất cả mã giảm giá</h3>
                                                <h6 id="my-point">Điểm của bạn: {{$user->points}} </h6>
                                            </div>

                                            <div class="row" id="voucher-container2">
                                                @if ($voucherPoint->isNotEmpty())
                                                    @foreach ($voucherPoint as $item)
                                                        <div class="col-md-4 mb-3 voucher-card" data-status="{{ $item->status }}">
                                                            <div class="card shadow-sm border-0">
                                                                <div class="card-body d-flex align-items-center">
                                                                    <div class="voucher-icon text-primary me-3" style="font-size: 24px;">
                                                                        <i class="fa fa-tags"></i>
                                                                    </div>
                                                                    <div class="voucher-details flex-grow-1">
                                                                        <small class="text-muted">Giảm giá: {{ $item->discount ?? 0 }}%</small><br>
                                                                        @php
                                                                            $minMoney = $item->min_money;
                                                                            $maxMoney = $item->max_money;
                                                                            $formattedMinMoney = $minMoney >= 1_000_000
                                                                                ? number_format($minMoney / 1_000_000, 0, ',', '') . 'tr'
                                                                                : number_format($minMoney / 1_000, 0, ',', '') . 'k';
                                                                            $formattedMaxMoney = $maxMoney >= 1_000_000
                                                                                ? number_format($maxMoney / 1_000_000, 0, ',', '') . 'tr'
                                                                                : number_format($maxMoney / 1_000, 0, ',', '') . 'k';
                                                                        @endphp
                                                                        <small>Áp dụng: {{ $formattedMinMoney }} - {{ $formattedMaxMoney }}</small><br>
                                                                        <small>HSD: {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</small><br>
                                                                        <small>Điểm: {{ $item->points_required }}</small> <br>

                                                                        <small class="quantityAl-{{$item->id}}">Còn lại: {{ $item->quantity }}</small> <br>
                                                                        @php
                                                                            $voucherClaimed = false;
                                                                            foreach ($item->users as $user) {
                                                                                if ($user->pivot->voucher_id == $item->id) {
                                                                                    $voucherClaimed = true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                        @endphp

                                                                        @if ($voucherClaimed)
                                                                            <span class="done-get">Đã đổi</span>
                                                                        @elseif ($item->quantity == 0)
                                                                        <span class="done-get">Đã hết</span>
                                                                        @else
                                                                            <span class="get-voucher un-get" data-id="{{$item->id}}">Đổi</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>Không có mã giảm giá nào.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div>
                    <!-- My Account Page End -->

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('plugins/js/getVoucher.js') }}"></script>
<script src="{{ asset('plugins/js/location.js') }}"></script>
    {{-- <script>
        $(document).ready(function() {
            $('.userPhone').on('input', function () {
                $('.userPhone').next('.error-message').html('');
            });

            $('#addressForm').submit(function (event) {
                let isValid = true;

                $('.error-message').text('');

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

            $('#avatar').on('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-avatar').attr('src', e.target.result);
                        $('#preview-container').show(); // Hiển thị container chứa ảnh đã chọn
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#preview-container').hide(); // Ẩn container nếu không có ảnh nào được chọn
                }
            });
        });
    </script> --}}

<script>
    // Hiển thị ảnh đã chọn
    function previewImage() {
        var file = document.getElementById("avatar").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            document.getElementById("profile-image").src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
<script>
    function togglePassword(inputId, iconId) {
        var passwordInput = document.getElementById(inputId);
        var eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            var triggerEl = document.querySelector(`a[data-bs-target="${activeTab}"]`);
            var tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
        var tabLinks = document.querySelectorAll('.myaccount-tab-menu a');
        tabLinks.forEach(function(tabLink) {
            tabLink.addEventListener('click', function(event) {
                localStorage.setItem('activeTab', this.getAttribute('data-bs-target'));
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const voucherCards = document.querySelectorAll('.voucher-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Lấy trạng thái cần lọc
                const status = this.getAttribute('data-status');

                // Thay đổi trạng thái nút
                filterButtons.forEach(btn => btn.classList.remove('btn-primary'));
                filterButtons.forEach(btn => btn.classList.add('btn-outline-primary'));
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');

                // Hiển thị/hide các voucher dựa trên trạng thái
                voucherCards.forEach(card => {
                    if (status === 'all' || card.getAttribute('data-status') === status) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const orderCards = document.querySelectorAll('.order-card');

        // Xử lý sự kiện khi nhấn vào nút bộ lọc
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Lấy trạng thái của nút vừa được nhấn
                const status = this.getAttribute('data-status');

                // Thay đổi kiểu nút đã chọn
                filterButtons.forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                });
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');

                orderCards.forEach(card => {
                    if (status === 'all' || card.getAttribute('data-status') === status) {
                        card.style.display = 'table-row';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection
