@extends('admin.dashboard')

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection

@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Danh sách Voucher đã xóa</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Quản lí Vouchers</a></li>
                            <li class="active">Danh sách Voucher đã xóa</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Danh sách Voucher đã xóa</strong>
                        <a href="{{ route('vouchers.index') }}" class="btn btn-primary float-right">Quay lại</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Code</th>
                                    <th>Giảm giá</th>
                                    <th>Số lượng</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Giá nhỏ nhất</th>
                                    <!-- <th>Trạng thái</th> -->
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->discount }}%</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</td>
                                    <td>{{ number_format($item->min_money, 0, ',', '.') }} VNĐ</td>
                                    <!-- <td>
                                        @if ($item->status == 0)
                                        <span class="badge bg-success text-white">Hoạt động</span>
                                        @elseif ($item->status == 1)
                                        <span class="badge bg-danger text-white">Không hoạt động</span>
                                        @endif
                                    </td> -->
                                    <td class="d-flex">
                                        <form action="{{ route('vouchers.restore', $item) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success mr-2" title="Khôi phục"><i
                                                    class="fa fa-undo"></i></button>
                                        </form>
                                        <form action="{{ route('vouchers.forceDelete', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Xóa vĩnh viễn sẽ mất hết dữ liệu! Bạn có chắc chắn không?')"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Xóa vĩnh viễn">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
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
<script src="{{ asset('admin/assets/js/lib/data-table/datatables.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/lib/data-table/jszip.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/lib/data-table/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/assets/js/lib/data-table/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/lib/data-table/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/lib/data-table/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/init/datatables-init.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#bootstrap-data-table').DataTable();
});
</script>
@endsection