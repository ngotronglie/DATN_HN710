@extends('client.index')

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
                                    <a href="#dashboad" class="active" data-bs-toggle="tab" data-bs-target="#dashboad"><i
                                            class="fa fa-dashboard"></i> Thông tin chung</a>
                                    <a href="#orders" data-bs-toggle="tab" data-bs-target="#orders"><i
                                            class="fa fa-cart-arrow-down"></i>Đơn hàng</a>
                                    <a href="#download" data-bs-toggle="tab" data-bs-target="#download"><i
                                            class="fa fa-solid fa-lock"></i> Đổi mật khẩu</a>
                                    <a href="#payment-method" data-bs-toggle="tab" data-bs-target="#payment-method"><i
                                            class="fa fa-credit-card"></i> Payment Method</a>
                                    <a href="#address-edit" data-bs-toggle="tab" data-bs-target="#address-edit"><i
                                            class="fa fa-map-marker"></i> address</a>
                                    <a href="#account-info" data-bs-toggle="tab" data-bs-target="#account-info"><i
                                            class="fa fa-user"></i> Account Details</a>

                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Thông tin cá nhân</h3>
                                            <div class="account-details-form">
                                                <form action="{{ route('updateMyAcount', $user->id) }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="first-name" class="required mb-1">Tên</label>
                                                                <input type="text" id="first-name" name="name"
                                                                    placeholder="First Name" value="{{ $user->name }}">
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
                                                    <div class="single-input-item mb-3">
                                                        <label for="display-name" class="required mb-1">Địa chỉ</label>
                                                        <input type="text" id="display-name" placeholder="Địa chỉ"
                                                            name="address" value="{{ $user->address }}">
                                                            @error('address')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="single-input-item mb-3">
                                                        <label for="phone" class="required mb-1">Điện thoại</label>
                                                        <input type="text" id="phone" placeholder="Điện thoại"
                                                            name="phone" value="{{ $user->phone }}" >
                                                            @error('phone')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="single-input-item mb-3">
                                                        <label for="date_of_birth" class="required mb-1">Ngày sinh</label>
                                                        <input type="date" id="date_of_birth" name="date_of_birth"
                                                            placeholder="Ngày sinh" value="{{ $user->date_of_birth }}">
                                                            @error('date_of_birth')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="single-input-item mb-3">
                                                        <label for="avatar" class="required mb-1">Avatar</label>

                                                        <input type="file" id="avatar" name="avatar"
                                                            placeholder="Ảnh đại diện">
                                                        @if ($user->avatar)
                                                            <div
                                                                style="text-align: center; margin-top: 10px; margin-bottom: 15px">
                                                                <img width="100"
                                                                    src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                                                    style="border: 2px solid #ccc; border-radius: 50%; padding: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                            </div>
                                                        @endif
                                                        @error('avatar')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                    </div>

                                                    <div class="single-input-item single-item-button">
                                                        <button class="btn btn btn-dark btn-hover-primary rounded-0">Cập
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
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Aug 22, 2023</td>
                                                            <td>Pending</td>
                                                            <td>$3000</td>
                                                            <td><a href="cart.html"
                                                                    class="btn btn btn-dark btn-hover-primary btn-sm rounded-0">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>July 22, 2023</td>
                                                            <td>Approved</td>
                                                            <td>$200</td>
                                                            <td><a href="cart.html"
                                                                    class="btn btn btn-dark btn-hover-primary btn-sm rounded-0">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>June 12, 2019</td>
                                                            <td>On Hold</td>
                                                            <td>$990</td>
                                                            <td><a href="cart.html"
                                                                    class="btn btn btn-dark btn-hover-primary btn-sm rounded-0">View</a>
                                                            </td>
                                                        </tr>
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
                                                        <label for="current_password" class="required mb-1">Mật khẩu hiện tại</label>
                                                        <div class="input-group">
                                                            <input type="password" id="current_password" name="current_password" class="form-control"
                                                                   placeholder="********"  style="padding-right: 40px;">
                                                            <div class="input-group-append"
                                                                 style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                                <span class="input-group-text" onclick="togglePassword('current_password', 'eyeIconCurrent')" style="background: none; border: none;">
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
                                                                <label for="new_password" class="required mb-1">Mật khẩu mới</label>
                                                                <div class="input-group">
                                                                    <input type="password" id="new_password" name="new_password" class="form-control"
                                                                           placeholder="********" style="padding-right: 40px;">
                                                                    <div class="input-group-append"
                                                                         style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                                        <span class="input-group-text" onclick="togglePassword('new_password', 'eyeIconNew')" style="background: none; border: none;">
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
                                                                <label for="confirm_password" class="required mb-1">Nhập lại mật khẩu</label>
                                                                <div class="input-group">
                                                                    <input type="password" id="confirm_password" name="new_password_confirmation" class="form-control"
                                                                           placeholder="********" style="padding-right: 40px;">
                                                                    <div class="input-group-append"
                                                                         style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                                        <span class="input-group-text" onclick="togglePassword('confirm_password', 'eyeIconConfirm')" style="background: none; border: none;">
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
                                                        <button class="btn btn-dark btn-hover-primary rounded-0">Đổi mật khẩu</button>
                                                    </div>
                                                    
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Payment Method</h3>
                                            <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Billing Address</h3>
                                            <address>
                                                <p><strong>Alex Aya</strong></p>
                                                <p>1234 Market ##, Suite 900 <br>
                                                    Lorem Ipsum, ## 12345</p>
                                                <p>Mobile: (123) 123-456789</p>
                                            </address>
                                            <a href="#" class="btn btn btn-dark btn-hover-primary rounded-0"><i
                                                    class="fa fa-edit me-2"></i>Edit Address</a>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 class="title">Thông tin chung</h3>
                                            <div class="account-details-form">
                                                <form action="#">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="first-name" class="required mb-1">First
                                                                    Name</label>
                                                                <input type="text" id="first-name"
                                                                    placeholder="First Name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item mb-3">
                                                                <label for="last-name" class="required mb-1">Last
                                                                    Name</label>
                                                                <input type="text" id="last-name"
                                                                    placeholder="Last Name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-input-item mb-3">
                                                        <label for="display-name" class="required mb-1">Display
                                                            Name</label>
                                                        <input type="text" id="display-name"
                                                            placeholder="Display Name" />
                                                    </div>
                                                    <div class="single-input-item mb-3">
                                                        <label for="email" class="required mb-1">Email Addres</label>
                                                        <input type="email" id="email"
                                                            placeholder="Email Address" />
                                                    </div>
                                                    <fieldset>
                                                        <legend>Password change</legend>
                                                        <div class="single-input-item mb-3">
                                                            <label for="current-pwd" class="required mb-1">Current
                                                                Password</label>
                                                            <input type="password" id="current-pwd"
                                                                placeholder="Current Password" />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item mb-3">
                                                                    <label for="new-pwd" class="required mb-1">New
                                                                        Password</label>
                                                                    <input type="password" id="new-pwd"
                                                                        placeholder="New Password" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item mb-3">
                                                                    <label for="confirm-pwd" class="required mb-1">Confirm
                                                                        Password</label>
                                                                    <input type="password" id="confirm-pwd"
                                                                        placeholder="Confirm Password" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="single-input-item single-item-button">
                                                        <button class="btn btn btn-dark btn-hover-primary rounded-0">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div>
                    <!-- My Account Page End -->

                </div>
            </div>

        </div>
    </div>
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
@endsection
