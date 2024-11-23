<!-- Header-->
<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="./"><img src="{{ asset('theme/admin/images/logo.png') }}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{ asset('theme/admin/images/logo2.png') }}"
                    alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
            <div class="header-left">
                <button class="search-trigger"><i class="fa fa-search"></i></button>
                <div class="form-inline">
                    <form class="search-form">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                        <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                    </form>
                </div>

                <div class="dropdown for-notification">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="count bg-danger">{{ $unreadNotifications->count() }}</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="notification">
                        @if ($notifications->isEmpty())
                            <p style="width: 180px">Không có thông báo</p>
                        @else
                            @foreach ($notifications as $index => $notification)
                                <a class="dropdown-item media {{ $notification->read_at == null ? 'read-noti' : '' }}"
                                    href="{{ route('admin.order.detailNotication', ['order_id' => $notification->data['order_id'], 'noti_id' => $notification->id]) }}">
                                    <p>
                                        {{ $notification->data['message'] }} -
                                        <strong>Tổng đơn:</strong>
                                        {{ number_format($notification->data['total_amount'], 0, ',', '.') }} đ
                                    </p>
                                </a>
                                <hr style="margin: 0px">
                            @endforeach
                            <a href="{{ route('admin.notification') }}" class="read-noti"
                                style="display: flex;justify-content: center;text-decoration: underline;color: rgb(84, 87, 99)">
                                Xem tất cả thông báo
                            </a>
                        @endif
                    </div>
                </div>

                <div class="dropdown for-message">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="message"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                        <span class="count bg-primary">4</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="message">
                        <p class="red">You have 4 Mails</p>
                        <a class="dropdown-item media" href="#">
                            <span class="photo media-left"><img alt="avatar" src="images/avatar/1.jpg"></span>
                            <div class="message media-body">
                                <span class="name float-left">Jonathan Smith</span>
                                <span class="time float-right">Just now</span>
                                <p>Hello, this is an example msg</p>
                            </div>
                        </a>
                        <a class="dropdown-item media" href="#">
                            <span class="photo media-left"><img alt="avatar" src="images/avatar/2.jpg"></span>
                            <div class="message media-body">
                                <span class="name float-left">Jack Sanders</span>
                                <span class="time float-right">5 minutes ago</span>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </div>
                        </a>
                        <a class="dropdown-item media" href="#">
                            <span class="photo media-left"><img alt="avatar" src="images/avatar/3.jpg"></span>
                            <div class="message media-body">
                                <span class="name float-left">Cheryl Wheeler</span>
                                <span class="time float-right">10 minutes ago</span>
                                <p>Hello, this is an example msg</p>
                            </div>
                        </a>
                        <a class="dropdown-item media" href="#">
                            <span class="photo media-left"><img alt="avatar" src="images/avatar/4.jpg"></span>
                            <div class="message media-body">
                                <span class="name float-left">Rachel Santos</span>
                                <span class="time float-right">15 minutes ago</span>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    @if (Auth::check() && Auth::user()->avatar)
                        <img class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" src="{{ Storage::url(Auth::user()->avatar) }}"
                            alt="User Avatar">
                    @else
                        <i class="bi bi-person-circle" style="font-size: 1.75rem;"></i>
                    @endif
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="{{ route('admin.accounts.myAccount') }}"><i
                            class="fa fa-user"></i> Hồ sơ cá nhân</a>
                    <a class="nav-link" href="#"><i class="fa fa-bell"></i> Notifications <span
                            class="count">13</span></a>
                    <a class="nav-link" href="{{ route('admin.accounts.showChangePasswordForm') }}"><i class="fa fa-cog"></i> Đổi mật khẩu</a>

                    <form action="{{ route('admin.logout') }}" method="post" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link"
                            style="background: none; border: none; padding: 0; margin: 0; color: inherit; cursor: pointer;">
                            <i class="fa fa-power-off"></i> Đăng xuất
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</header>
<!-- /#header -->
