@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Thống kê</a></li>
                            <li class="active">Danh sách</li>
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

            <!-- Doanh thu 4 tháng gần nhất -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Doanh thu 4 tháng gần nhất</strong>
                        <div>
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="#chartModal" onclick="showChart('monthlyRevenue')">
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

            <!-- Số lượng đơn hàng theo trạng thái -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Số lượng sản phẩm</strong>
                        <div>
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="#chartModal" onclick="showChart('categoryStatistics')">
                                <i class="fa fa-signal"></i> Xem biểu đồ
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên danh mục</th>
                                    <th>Số lượng sản phẩm</th>
                                    <th>Giá thấp nhất</th>
                                    <th>Giá cao nhất</th>
                                    <th>Giá trung bình</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($categoryStatistics->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center"><strong>Không có dữ liệu</strong></td>
                                </tr>
                                @else
                                @foreach($categoryStatistics as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->total_products }}</td>
                                    <td>{{ $category->lowest_price ? number_format($category->lowest_price, 0, ',', '.') : 'N/A' }} @if($category->lowest_price)VNĐ@endif</td>
                                    <td>{{ $category->highest_price ? number_format($category->highest_price, 0, ',', '.') : 'N/A' }} @if($category->highest_price)VNĐ@endif</td>
                                    <td>{{ $category->average_price ? number_format($category->average_price, 0, ',', '.') : 'N/A' }} @if($category->average_price)VNĐ@endif</td>
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
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="#chartModal" onclick="showChart('bestSellingProducts')">
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
                            <a class="btn btn-primary mr-1" href="#" data-toggle="modal" data-target="#chartModal" onclick="showChart('leastSellingProducts')">
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
                            text: 'Biểu đồ Doanh thu và Tăng trưởng theo tháng',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            };
        } else if (type === 'categoryStatistics') {
            chartData = {
                type: 'bar',
                data: {
                    labels: {!! json_encode($categoryStatistics->pluck('name')) !!}, // Lấy tên danh mục từ dữ liệu
                    datasets: [
                        {
                            label: 'Giá thấp nhất',
                            data: {!! json_encode($categoryStatistics->pluck('lowest_price')) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Màu đỏ nhạt
                            borderColor: 'rgba(255, 99, 132, 1)', // Viền màu đỏ
                            borderWidth: 1
                        },
                        {
                            label: 'Giá cao nhất',
                            data: {!! json_encode($categoryStatistics->pluck('highest_price')) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Màu xanh dương nhạt
                            borderColor: 'rgba(54, 162, 235, 1)', // Viền màu xanh dương
                            borderWidth: 1
                        },
                        {
                            label: 'Giá trung bình',
                            data: {!! json_encode($categoryStatistics->pluck('average_price')) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu xanh ngọc nhạt
                            borderColor: 'rgba(75, 192, 192, 1)', // Viền màu xanh ngọc
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            enabled: true
                        },
                        title: {
                            display: true,
                            text: 'Biểu đồ so sánh giá theo danh mục sản phẩm',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            };
        } else if (type === 'bestSellingProducts') {
            chartData = {
                type: 'pie',
                data: {
                    labels: {!! json_encode($bestSellingProducts->pluck('product_name')) !!},
                    datasets: [
                        {
                            label: 'Phần trăm đóng góp doanh thu (%)',
                            data: {!! json_encode($bestSellingProducts->pluck('revenue_percentage')) !!},
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                            hoverOffset: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.5,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    var dataset = context.chart.data.datasets[context.datasetIndex];
                                    var index = context.dataIndex;
                                    var productName = context.chart.data.labels[index];
                                    var percentage = dataset.data[index];
                                    var revenue = {!! json_encode($bestSellingProducts->pluck('total_revenue')) !!}[index];
                                    var quantity = {!! json_encode($bestSellingProducts->pluck('total_sold')) !!}[index];
                                    var roundedRevenue = Math.round(revenue);
                                    var formattedRevenue = new Intl.NumberFormat('vi-VN').format(roundedRevenue);
                                    return productName + ': ' +
                                        'Doanh thu: ' + formattedRevenue + ' VND, ' +
                                        'Số lượng: ' + quantity + ', ' +
                                        'Phần trăm: ' + percentage + '%';
                                }
                            }
                        },
                        title: {
                display: true, // Hiển thị tiêu đề
                text: 'Biểu đồ sản phẩm bán chạy', // Nội dung tiêu đề
                font: {
                    size: 16 // Kích thước font của tiêu đề
                }
            }
                    }
                }
            };
        } else if (type === 'leastSellingProducts') {
            chartData = {
                type: 'pie',
                data: {
                    labels: {!! json_encode($leastSellingProducts->pluck('product_name')) !!},
                    datasets: [
                        {
                            label: 'Phần trăm đóng góp doanh thu (%)',
                            data: {!! json_encode($leastSellingProducts->pluck('revenue_percentage')) !!},
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                            hoverOffset: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.5,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    var dataset = context.chart.data.datasets[context.datasetIndex];
                                    var index = context.dataIndex;
                                    var productName = context.chart.data.labels[index];
                                    var percentage = dataset.data[index];
                                    var revenue = {!! json_encode($leastSellingProducts->pluck('total_revenue')) !!}[index];
                                    var quantity = {!! json_encode($leastSellingProducts->pluck('total_sold')) !!}[index];
                                    var roundedRevenue = Math.round(revenue);
                                    var formattedRevenue = new Intl.NumberFormat('vi-VN').format(roundedRevenue);
                                    return productName + ': ' +
                                        'Doanh thu: ' + formattedRevenue + ' VND, ' +
                                        'Số lượng: ' + quantity + ', ' +
                                        'Phần trăm: ' + percentage + '%';
                                }
                            }
                        },
                        title: {
                display: true, // Hiển thị tiêu đề
                text: 'Biểu đồ sản phẩm không bán chạy', // Nội dung tiêu đề
                font: {
                    size: 16 // Kích thước font của tiêu đề
                }
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