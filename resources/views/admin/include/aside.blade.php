    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                @php $user = auth()->user(); @endphp
                <ul class="nav navbar-nav">
                    <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Bảng điều khiển</a>
                    </li>
                    <li class="menu-title">Sản phẩm & Khuyến mãi</li><!-- /.menu-title -->
                    {{-- category --}}
                    <li class="menu-item-has-children {{ Request::is('admin/categories*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="menu-icon fa fa-list-alt"></i>Quản lý danh mục
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{ route('admin.categories.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.categories.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end category --}}
                    {{-- product --}}
                    <li class="menu-item-has-children {{ Request::is('admin/products*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="menu-icon fa fa-cube"></i>Quản lý sản phẩm
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{ route('admin.products.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.products.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end product --}}
                    @if ($user->role == 2)
                    {{-- color --}}
                    <li class="menu-item-has-children {{ Request::is('admin/colors*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="menu-icon fa fa-paint-brush"></i>Quản lý màu
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{ route('admin.colors.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.colors.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end color --}}
                    {{-- size --}}
                    <li class="menu-item-has-children {{ Request::is('admin/sizes*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="menu-icon fa fa-text-height"></i>Quản lý kích cỡ
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{ route('admin.sizes.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.sizes.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end size --}}
                    {{-- voucher --}}
                    <li class="menu-item-has-children {{ Request::is('admin/vouchers*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-ticket"></i>Quản lý khuyến mại</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li></i><a href="{{ route('admin.vouchers.index') }}">Danh sách</a></li>
                            <li></i><a href="{{ route('admin.vouchers.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end voucher --}}
                    @endif
                    <li class="menu-title">Khách hàng & Nội dung</li><!-- /.menu-title -->
                    @if ($user->role == 2)
                    {{-- account --}}
                    <li class="menu-item-has-children {{ Request::is('admin/accounts*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Quản lý tài khoản</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{ route('admin.accounts.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.accounts.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children {{ Request::is('admin/shift*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-clipboard"></i>Quản lý ca làm</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{ route('admin.shift.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.shift.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end account --}}
                    @endif
                    {{-- comment --}}
                    <li class="menu-item-has-children {{ Request::is('admin/comments*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-comment"></i>Quản lý bình luận</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li></i><a href="{{ route('admin.comments.index') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    {{-- end comment --}}
                    {{-- category blog --}}
                    <li
                        class="menu-item-has-children {{ Request::is('admin/category_blogs*') || Request::is('admin/blogs*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Quản lý bài viết</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li></i><a href="{{ route('admin.category_blogs.index') }}">Danh mục bài viết</a></li>
                            <li></i><a href="{{ route('admin.category_blogs.create') }}">Thêm mới</a></li>
                            <li></i><a href="{{ route('admin.blogs.index') }}">Danh sách bài viết</a></li>
                            <li></i><a href="{{ route('admin.blogs.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end category blog --}}
                    {{-- banner --}}
                    <li class="menu-item-has-children {{ Request::is('admin/banners*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-photo"></i>Quản lý banner</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li></i><a href="{{ route('admin.banners.index') }}">Danh sách</a></li>
                            <li></i><a href="{{ route('admin.banners.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end banner --}}
                    <li class="menu-title">Đơn hàng & Thống kê</li><!-- /.menu-title -->
                    {{-- order --}}
                    <li class="menu-item-has {{ Request::is('admin/order*') ? 'active' : '' }} ">
                        <a href="{{route('admin.order.index')}}">
                            <i class="menu-icon fa fa-shopping-cart"></i>Quản lý đơn hàng</a>
                    </li>
                    {{-- end order --}}
                    {{-- statistics --}}
                    <li class="menu-item-has {{ Request::is('admin/statistics*') ? 'active' : '' }} ">
                        <a href="{{route('admin.statistics.index')}}">
                            <i class="menu-icon fa fa-bar-chart-o"></i>Thống kê</a>
                    </li>
                    {{-- end statistics --}}
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
