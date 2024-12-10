@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Thống kê</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li class="active">Thống kê</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content mb-5">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Nhập khoảng thời gian để xem thống kê</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.statistics.show') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="start-date" class="col-sm-2 col-form-label">Ngày bắt đầu:</label>
                                <div class="col-sm-4">
                                  <input type="date" class="form-control" id="start-date" name="start-date" value="{{ session('startDate', old('start-date')) }}">
                                  @error('start-date')
                                    <small class="text-danger">{{ $message }}</small>
                                  @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="end-date" class="col-sm-2 col-form-label">Ngày kết thúc:</label>
                                <div class="col-sm-4">
                                  <input type="date" class="form-control" id="end-date" name="end-date" value="{{ session('endDate', old('end-date')) }}">
                                  @error('end-date')
                                    <small class="text-danger">{{ $message }}</small>
                                  @enderror
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success">Xem thống kê</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            

            @if(Auth::user()->role == 2)
            <!-- Doanh thu theo khoảng thời gian -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Doanh thu theo tháng</strong>
                        <div>
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="{{$monthlyRevenue->isEmpty() ? '' : '#chartModal'}}" onclick="showChart('monthlyRevenue')">
                                <i class="fa fa-signal"></i> Xem biểu đồ
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tháng</th>
                                    <th>Doanh thu</th>
                                    <th>Tăng trưởng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($monthlyRevenue->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center"><strong>Không có dữ liệu</strong></td>
                                </tr>
                                @else
                                @foreach($monthlyRevenue as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $data->month)->format('m/Y') }}</td>
                                    <td>{{ number_format($data->total_revenue, 0, ',', '.') }} VNĐ</td>
                                    @if(isset($growthRates[$key]))
                                    <td>{{ $growthRates[$key]['growth_rate'] }}%</td>
                                    @else
                                    <td>N/A</td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Số lượng của từng trạng thái đơn hàng -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Số lượng đơn hàng</strong>
                        <div>
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="{{$orderStatistics->isEmpty() ? '' : '#chartModal'}}" onclick="showChart('orderStatistics')">
                                <i class="fa fa-signal"></i> Xem biểu đồ
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tháng</th>
                                    <th>Số đơn hàng đã đặt</th>
                                    <th>Số đơn hàng hoàn thành</th>
                                    <th>Số đơn hàng bị hủy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orderStatistics->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center"><strong>Không có dữ liệu</strong></td>
                                </tr>
                                @else
                                @foreach($orderStatistics as $key => $stat)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $stat->month)->format('m/Y') }}</td>
                                    <td>{{ $stat->total_orders }}</td> <!-- Hiển thị số đơn hàng đã đặt -->
                                    <td>{{ $stat->completed_orders }}</td>
                                    <td>{{ $stat->canceled_orders }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm bán chạy nhất -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Sản phẩm bán chạy nhất</strong>
                        <div>
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="{{$bestSellingProducts->isEmpty() ? '' : '#chartModal'}}" onclick="showChart('bestSellingProducts')">
                                <i class="fa fa-signal"></i> Xem biểu đồ
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Doanh thu</th>
                                    <th>Phần trăm đóng góp doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($bestSellingProducts->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center"><strong>Không có dữ liệu</strong></td>
                                </tr>
                                @else
                                @foreach($bestSellingProducts as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                    <td>{{ number_format($product->total_revenue, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $product->revenue_percentage }}%</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Sản phẩm không bán chạy</strong>
                        <div>
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="{{$leastSellingProducts->isEmpty() ? '' : '#chartModal'}}" onclick="showChart('leastSellingProducts')">
                                <i class="fa fa-signal"></i> Xem biểu đồ
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Doanh thu</th>
                                    <th>Phần trăm đóng góp doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($leastSellingProducts->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center"><strong>Không có dữ liệu</strong></td>
                                </tr>
                                @else
                                @foreach($leastSellingProducts as $key => $product)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                    <td>{{ number_format($product->total_revenue, 0, ',', '.') }} VND</td>
                                    <td>{{ $product->revenue_percentage }}%</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @elseif(Auth::user()->role == 1)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Sản phẩm không bán chạy</strong>
                        <div>
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="{{$leastSellingProducts->isEmpty() ? '' : '#chartModal'}}" onclick="showChart('leastSellingProducts')">
                                <i class="fa fa-signal"></i> Xem biểu đồ
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Doanh thu</th>
                                    <th>Phần trăm đóng góp doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($leastSellingProducts->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center"><strong>Không có dữ liệu</strong></td>
                                </tr>
                                @else
                                @foreach($leastSellingProducts as $key => $product)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                    <td>{{ number_format($product->total_revenue, 0, ',', '.') }} VND</td>
                                    <td>{{ $product->revenue_percentage }}%</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Modal chung để hiển thị biểu đồ -->
            <div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex">
                            <h5 class="modal-title" id="chartModalLabel">Biểu đồ thống kê</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <canvas id="chartCanvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- .animated -->
</div><!-- .content -->
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartInstance;

    function showChart(type) {
        const ctx = document.getElementById('chartCanvas').getContext('2d');

        // Xóa biểu đồ cũ nếu có
        if (chartInstance) {
            chartInstance.destroy();
        }

        let chartData = {};

        // Dữ liệu cho từng loại biểu đồ
        if (type === 'monthlyRevenue') {
            if ({!! json_encode($monthlyRevenue->isEmpty()) !!}) {
                alert('Không có dữ liệu để hiển thị biểu đồ doanh thu!');
                return;
            }
            chartData = {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyRevenue->pluck('month')->map(function($month) {
                        return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('m/Y');
                    })) !!},
                    datasets: [
                        {
                            label: 'Doanh thu (VNĐ)',
                            data: {!! json_encode($monthlyRevenue->pluck('total_revenue')) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Màu đỏ nhạt cho doanh thu
                            borderColor: 'rgba(255, 99, 132, 1)', // Đường viền đỏ đậm cho doanh thu
                            borderWidth: 1
                        },
                        {
                            label: 'Tăng trưởng (%)',
                            data: {!! json_encode($monthlyRevenue->map(function($month, $key) use($growthRates) {
                                return isset($growthRates[$key]) ? $growthRates[$key]['growth_rate'] : 0;
                            })) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Màu xanh dương nhạt cho tăng trưởng
                            borderColor: 'rgba(54, 162, 235, 1)', // Đường viền xanh dương đậm cho tăng trưởng
                            borderWidth: 1,
                            yAxisID: 'y-axis-growth' // Thêm ID trục cho cột tăng trưởng
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Doanh thu (VNĐ)'
                            }
                        },
                        'y-axis-growth': {
                            beginAtZero: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Tăng trưởng (%)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%'; // Hiển thị % cho trục tăng trưởng
                                }
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Biểu đồ Doanh thu và Tăng trưởng',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            };
        } else if (type === 'orderStatistics') {
            if ({!! json_encode($orderStatistics->isEmpty()) !!}) {
                alert('Không có dữ liệu để hiển thị biểu đồ số lượng đơn hàng!');
                return;
            }
            chartData = {
    type: 'line', // Chọn loại biểu đồ là line (đường)
    data: {
        labels: {!! json_encode($orderStatistics->pluck('month')->map(function($month) {
            return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('m/Y');
        })) !!},
        datasets: [
            {
                label: 'Hoàn thành',
                data: {!! json_encode($orderStatistics->pluck('completed_orders')) !!}, // Dữ liệu số đơn hàng hoàn thành
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false,
                tension: 0.1,
                borderWidth: 2
            },
            {
                label: 'Bị hủy',
                data: {!! json_encode($orderStatistics->pluck('canceled_orders')) !!}, // Dữ liệu số đơn hàng bị hủy
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: false,
                tension: 0.1,
                borderWidth: 2
            },
            {
                label: 'Đơn hàng đã đặt',
                data: {!! json_encode($orderStatistics->pluck('total_orders')) !!}, // Dữ liệu tổng số đơn hàng đã đặt
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                fill: false,
                tension: 0.1,
                borderWidth: 2
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Số lượng đơn hàng'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Tháng'
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Biểu đồ Số lượng Đơn hàng',
                font: {
                    size: 16
                }
            },
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
};
        } else if (type === 'bestSellingProducts') {
            if ({!! json_encode($bestSellingProducts->isEmpty()) !!}) {
                alert('Không có dữ liệu để hiển thị biểu đồ sản phẩm bán chạy!');
                return;
            }
            chartData = {
                type: 'bar',
                data: {
                    labels: {!! json_encode($bestSellingProducts->pluck('product_name')) !!},
                    datasets: [
                        {
                            label: 'Số lượng bán',
                            data: {!! json_encode($bestSellingProducts->pluck('total_sold')) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Doanh thu (VNĐ)',
                            data: {!! json_encode($bestSellingProducts->pluck('total_revenue')) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            yAxisID: 'y-axis-revenue'
                        },
                        {
                            label: 'Phần trăm đóng góp doanh thu',
                            data: {!! json_encode($bestSellingProducts->pluck('revenue_percentage')) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            yAxisID: 'y-axis-percentage'
                        }
                    ]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, position: 'left', title: { display: true, text: 'Số lượng bán' } },
                        'y-axis-revenue': {
                            beginAtZero: true,
                            position: 'right',
                            title: { display: true, text: 'Doanh thu (VNĐ)' },
                            ticks: { callback: function(value) { return value.toLocaleString() + ' VNĐ'; } }
                        },
                        'y-axis-percentage': {
                            beginAtZero: true,
                            position: 'right',
                            title: { display: true, text: 'Phần trăm đóng góp' },
                            ticks: { callback: function(value) { return value + '%'; } }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Biểu đồ Sản phẩm bán chạy',
                            font: { size: 16 }
                        }
                    }
                }
            };
        } else if (type === 'leastSellingProducts') {
            if ({!! json_encode($leastSellingProducts->isEmpty()) !!}) {
                alert('Không có dữ liệu để hiển thị biểu đồ sản phẩm không bán chạy!');
                return;
            }
            chartData = {
                type: 'bar',
                data: {
                    labels: {!! json_encode($leastSellingProducts->pluck('product_name')) !!},
                    datasets: [
                        {
                            label: 'Số lượng bán',
                            data: {!! json_encode($leastSellingProducts->pluck('total_sold')) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Doanh thu (VNĐ)',
                            data: {!! json_encode($leastSellingProducts->pluck('total_revenue')) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            yAxisID: 'y-axis-revenue'
                        },
                        {
                            label: 'Phần trăm đóng góp doanh thu',
                            data: {!! json_encode($leastSellingProducts->pluck('revenue_percentage')) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            yAxisID: 'y-axis-percentage'
                        }
                    ]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, position: 'left', title: { display: true, text: 'Số lượng bán' } },
                        'y-axis-revenue': {
                            beginAtZero: true,
                            position: 'right',
                            title: { display: true, text: 'Doanh thu (VNĐ)' },
                            ticks: { callback: function(value) { return value.toLocaleString() + ' VNĐ'; } }
                        },
                        'y-axis-percentage': {
                            beginAtZero: true,
                            position: 'right',
                            title: { display: true, text: 'Phần trăm đóng góp' },
                            ticks: { callback: function(value) { return value + '%'; } }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Biểu đồ Sản phẩm không bán chạy',
                            font: { size: 16 }
                        }
                    }
                }
            };
        }

        // Tạo biểu đồ
        chartInstance = new Chart(ctx, chartData);
        
    }
</script>

<script>
    // Loại bỏ padding-right khi modal đóng
    jQuery(document).on('hidden.bs.modal', function() {
        jQuery('body').css('padding-right', '0');
    });
</script>
@endsection