    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">UI elements</li><!-- /.menu-title -->
                    {{-- category --}}
                    <li class="menu-item-has-children {{ Request::is('admin/categories*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-cube"></i>Quản lý sản phẩm
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{ route('admin.products.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.products.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end product --}}
                    {{-- color --}}
                    <li class="menu-item-has-children {{ Request::is('admin/colors*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-text-height"></i>Quản lý size
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{ route('admin.sizes.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.sizes.create') }}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end size --}}
                    {{-- account --}}
                    <li class="menu-item-has-children {{ Request::is('admin/accounts*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Quản lý tài khoản</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{route('admin.accounts.index')}}">Danh sách</a></li>
                            <li><a href="{{route('admin.accounts.create')}}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end account --}}
                    {{-- voucher --}}
                    <li class="menu-item-has-children {{ Request::is('admin/vouchers*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-ticket"></i>Quản lý vouchers</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li></i><a href="{{route('admin.vouchers.index')}}">Danh sách</a></li>
                            <li></i><a href="{{route('admin.vouchers.create')}}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end voucher --}}
                    {{-- category blog --}}
                    <li class="menu-item-has-children {{ Request::is('admin/category_blogs*') || Request::is('admin/blogs*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Quản lý bài viết</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li></i><a href="{{route('admin.category_blogs.index')}}">Danh mục bài viết</a></li>
                            <li></i><a href="{{route('admin.category_blogs.create')}}">Thêm mới</a></li>
                            <li></i><a href="{{route('admin.blogs.index')}}">Danh sách bài viết</a></li>
                            <li></i><a href="{{route('admin.blogs.create')}}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end category blog --}}
                    {{-- banner --}}
                    <li class="menu-item-has-children {{ Request::is('admin/banners*') ? 'active' : '' }} dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-photo"></i>Quản lý banner</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li></i><a href="{{route('admin.banners.index')}}">Danh sách</a></li>
                            <li></i><a href="{{route('admin.banners.create')}}">Thêm mới</a></li>
                        </ul>
                    </li>
                    {{-- end banner --}}

                    <li class="menu-title">Icons</li><!-- /.menu-title -->

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Icons</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="font-fontawesome.html">Font
                                    Awesome</a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="font-themify.html">Themefy Icons</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="widgets.html"> <i class="menu-icon ti-email"></i>Widgets </a>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-bar-chart"></i>Charts</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-line-chart"></i><a href="charts-chartjs.html">Chart JS</a>
                            </li>
                            <li><i class="menu-icon fa fa-area-chart"></i><a href="charts-flot.html">Flot Chart</a>
                            </li>
                            <li><i class="menu-icon fa fa-pie-chart"></i><a href="charts-peity.html">Peity Chart</a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-area-chart"></i>Maps</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-map-o"></i><a href="maps-gmap.html">Google Maps</a></li>
                            <li><i class="menu-icon fa fa-street-view"></i><a href="maps-vector.html">Vector Maps</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title">Extras</li><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>Pages</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="page-login.html">Login</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="page-register.html">Register</a></li>
                            <li><i class="menu-icon fa fa-paper-plane"></i><a href="pages-forget.html">Forget Pass</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->