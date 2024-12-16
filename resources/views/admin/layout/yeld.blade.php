@extends('admin.dashboard')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
@endsection

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        @if (Auth::user()->role == 2)
        <!-- Widgets  -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="pe-7s-cash"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{ $totalRevenue }}</span></div>
                                    <div class="stat-heading">Doanh thu</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-2">
                                <i class="pe-7s-cart"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{ $ordersCount }}</span></div>
                                    <div class="stat-heading">Đơn hàng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-3">
                                <i class="pe-7s-browser"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{ $productCount }}</span></div>
                                    <div class="stat-heading">Sản phẩm</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-4">
                                <i class="pe-7s-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{ $usersCount }}</span></div>
                                    <div class="stat-heading">Khách hàng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Widgets -->
        <!--  Traffic  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Biểu đồ </h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card-body">
                                <div>
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-body">
                                @foreach ($dates as $index => $date)
                                <div class="progress-box progress-{{ $index + 1 }}">
                                    <h4 class="por-title">Ngày {{ $date }}</h4>
                                    <div class="por-txt">{{ number_format($revenues[$index], 0, ',', '.') }} VND</div>
                                    <div class="progress mb-2" style="height: 5px;">
                                        @php
                                        // Calculate percentage for progress bar based on the max revenue
                                        $maxRevenue = max($revenues);
                                        $percentage = $maxRevenue > 0 ? ($revenues[$index] / $maxRevenue) * 100 : 0;
                                        @endphp
                                        <div class="progress-bar bg-flat-color-{{ $index + 1 }}" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div> <!-- /.card-body -->
                        </div>
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic -->
        @elseif (Auth::user()->role == 1)
        <!-- Trang chủ cho Nhân viên -->
        <div class="row">
            <!-- Thông báo đơn hàng mới -->
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="pe-7s-cart"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <h4 class="stat-heading">Đơn hàng mới</h4>
                                    <p>Kiểm tra đơn hàng mới và bắt đầu xử lý</p>
                                    <a href="{{ route('admin.order.index') }}" class="btn btn-primary">Xem đơn hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thống kê cá nhân của nhân viên -->
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-2">
                                <i class="pe-7s-id"></i> <!-- Thay đổi icon thành biểu tượng người dùng -->
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <h4 class="stat-heading">Thống kê cá nhân</h4>
                                    <p>Số đơn hàng, doanh thu và sản phẩm bạn đã xử lý</p>
                                    <a href="{{ route('admin.statistics.index') }}" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Công việc hàng ngày -->
        <div class="row">
            <!-- Hướng dẫn sử dụng -->
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body">
                        <h4 class="box-title text-center text-primary mb-4">Hướng dẫn công việc</h4>
                        <ul class="list-unstyled">
                            <li class="media mb-3">
                                <div class="media-left">
                                    <i class="pe-7s-cart text-success" style="font-size: 40px;"></i> <!-- Icon giỏ hàng thay cho check-circle -->
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">Xử lý đơn hàng</h5>
                                    <p>Kiểm tra và xử lý các đơn hàng mới.</p>
                                </div>
                            </li>
                            <li class="media mb-3">
                                <div class="media-left">
                                    <i class="pe-7s-news-paper text-info" style="font-size: 40px;"></i> <!-- Icon báo chí thay cho box2 -->
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">Quản lý bài viết</h5>
                                    <p>Xem, duyệt và quản lý các bài viết từ người dùng.</p>
                                </div>
                            </li>
                            <li class="media mb-3">
                                <div class="media-left">
                                    <i class="pe-7s-display2 text-info" style="font-size: 40px;"></i> <!-- Icon màn hình thay cho box2 -->
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">Quản lý banner</h5>
                                    <p>Cập nhật và kiểm duyệt các banner quảng cáo trên website.</p>
                                </div>
                            </li>
                            <li class="media mb-3">
                                <div class="media-left">
                                    <i class="pe-7s-comment text-info" style="font-size: 40px;"></i> <!-- Icon bình luận -->
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">Quản lý bình luận</h5>
                                    <p>Xem và phê duyệt các bình luận của người dùng.</p>
                                </div>
                            </li>                         
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!-- Liên hệ và hỗ trợ -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Cần hỗ trợ?</h4>
                        <p>Nếu bạn gặp vấn đề gì trong công việc, hãy liên hệ với bộ phận hỗ trợ.</p>
                        <a href="mailto:support@yourcompany.com" class="btn btn-warning">Liên hệ hỗ trợ</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
@endsection

@section('script')
{{-- <!--  Chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

<!--Chartist Chart-->
<script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script> --}}

{{-- <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script> --}}

{{-- <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
<script src="{{ asset('theme/admin/assets/js/init/weather-init.js') }}"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
<script src="{{ asset('theme/admin/assets/js/init/fullcalendar-init.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</script>

@if (Auth::user()->role == 2)
<script>
    // Lấy dữ liệu từ backend
    const dates = @json($dates);
    const revenues = @json($revenues);

    // Tạo biểu đồ
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line', // Dạng biểu đồ: line
        data: {
            labels: dates, // Các ngày
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: revenues, // Dữ liệu doanh thu
                borderColor: 'rgba(75, 192, 192, 1)', // Màu đường
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu nền
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Biểu đồ Doanh thu theo Ngày',
                    font: {
                        size: 16
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Ngày'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Doanh thu (VNĐ)'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endif
@endsection
