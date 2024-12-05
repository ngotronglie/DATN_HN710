@extends('admin.dashboard')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link rel="stylesheet" href="{{ asset('theme/admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection

@section('content')
    <div class="breadcrumbs mb-5">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Danh sách đơn hàng</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Bảng điều khiển</a></li>
                                <li><a href="#">Quản lí đơn hàng</a></li>
                                <li class="active">Danh sách đơn hàng</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content mb-5">
        <div id="alert-container" class="alert d-none" role="alert"></div>

        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong class="card-title">Danh sách đơn hàng</strong>
                            <div>
                                <select id="filterStatus" class="form-control" onchange="filterOrders()">
                                    <option value="">Tất cả ({{$statusCounts['all'] }})</option>
                                    <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Chờ xác nhận ({{ $statusCounts['pending'] }})</option>
                                    <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Chờ lấy hàng ({{ $statusCounts['processing'] }})</option>
                                    <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Đang giao hàng ({{ $statusCounts['shipping'] }})</option>
                                    <option value="4" {{ request('status') == 4 ? 'selected' : '' }}>Giao hàng thành công ({{ $statusCounts['completed'] }})</option>
                                    <option value="5" {{ request('status') == 5 ? 'selected' : '' }}>Chờ hủy ({{ $statusCounts['pending_cancel'] }})</option>
                                    <option value="6" {{ request('status') == 6 ? 'selected' : '' }}>Đã hủy ({{ $statusCounts['canceled'] }})</option>
                                </select>

                            </div>

                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered" data-disable-sort="true">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Tính năng</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt </th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Tính năng</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($order as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->order_code }}</td>
                                            @if ($item->user_id)
                                                <td>{{ $item->user->name }}</td>
                                            @else
                                                <td>Khách vãng lai</td>
                                            @endif
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}</td>
                                            <td>
                                                {{ number_format($item->total_amount, 0, ',', '.') }} VND
                                            </td>
                                            <td>
                                                @if ($item->status == 1)
                                                    <span class="badge badge-warning">Chờ xác nhận</span>
                                                @elseif($item->status == 2)
                                                    <span class="badge badge-info">Chờ lấy hàng</span>
                                                @elseif($item->status == 3)
                                                    <span class="badge badge-primary">Đang giao hàng</span>
                                                @elseif($item->status == 4)
                                                    <span class="badge badge-success">Giao hàng thành công</span>
                                                @elseif($item->status == 5)
                                                    <span class="badge badge-secondary">Chờ hủy</span>
                                                @elseif($item->status == 6)
                                                    <span class="badge badge-danger">Đã hủy</span>
                                                @endif
                                            </td>
                                            <td class="d-flex">
                                                <a class="btn btn-primary" href="{{ route('admin.order.detail', $item) }}" title="Xem chi tiết">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if ($item->status != 6 && $item->status != 4)
                                                    @if($item->status == 1)
                                                        <a class="btn btn-success ml-2" href="{{ route('admin.order.confirmOrder', $item->id) }}"
                                                           onclick="return confirm('Bạn có chắc chắn muốn xác nhận đơn hàng này không?');" title="Chờ lấy hàng">
                                                           <i class="fa fa-check"></i>
                                                        </a>
                                                    @elseif($item->status == 2)
                                                        <a class="btn btn-info ml-2" href="{{ route('admin.order.shipOrder', $item->id) }}"
                                                           onclick="return confirm('Bạn có chắc chắn muốn giao đơn hàng này không?');" title="Đang giao hàng">
                                                           <i class="fa fa-truck"></i>
                                                        </a>
                                                    @elseif($item->status == 3)
                                                        <a class="btn btn-success ml-2" href="{{ route('admin.order.confirmShipping', $item->id) }}"
                                                           onclick="return confirm('Bạn có chắc chắn đơn hàng này đã được giao không?');" title="Giao hàng thành công">
                                                           <i class="fa fa-check-circle-o"></i>
                                                        </a>
                                                    @elseif($item->status == 5)
                                                        <a class="btn btn-danger ml-2" href="{{ route('admin.order.cancelOrder', $item->id) }}"
                                                           onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');" title="Đã hủy">
                                                           <i class="fa fa-times-circle"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                                @if ($item->status == 2 || $item->status == 4)
                                                <a class="btn btn-hover-d btn-dark ml-2" onclick="return confirm('Bạn có muốn in hóa đơn, đơn hàng này không?');" target="_blank" href="{{route('admin.order.printOrder', $item->order_code)}}" title="In đơn hàng">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                @endif
                                            </td>                                      
                                        </tr>
                                    @endforeach

                                </tbody>



                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->


@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/lib/data-table/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/init/datatables-init.js') }}"></script>

   <script>
    function filterOrders() {
    const status = document.getElementById('filterStatus').value;
    const url = new URL(window.location.href);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location.href = url.href;
    }
   </script>
@endsection
