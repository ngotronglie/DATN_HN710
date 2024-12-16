@extends('admin.dashboard')

@section('style')
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
                        <h1>Danh sách kích cỡcỡ</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="#">Quản lí kích cỡ</a></li>
                            <li class="active">Danh sách kích cỡ</li>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Danh sách kích cỡ</strong>
                        <div>
                            <a class="btn btn-primary mr-1" href="{{ route('admin.sizes.create') }}">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                            <a class="btn btn-danger" href="{{ route('admin.sizes.trashed') }}">
                                <i class="fa fa-trash"></i> Thùng rác <span class="countTrash">({{ $trashedCount }})</span>
                            </a>
                            <div class="dropdown float-right ml-2">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cogs"></i> Tùy chọn
                                </button>
                                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item deleteAll" href="#">
                                        <i class="fa fa-trash text-danger"></i> Xóa các mục đã chọn
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered" data-disable-sort="false">
                            <thead>
                                <tr>
                                    <th>
                                        <input id="checkAllTable" type="checkbox">
                                    </th>
                                    <th>STT</th>
                                    <th>Kích cỡ</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>STT</th>
                                    <th>Kích cỡ</th>
                                    <th>Chức năng</th>
                                </tr>
                            </tfoot>
                            <tbody class="null_Table">
                                @foreach ($sizes as $key => $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkBoxItem" data-id="{{ $item->id }}">
                                    </td>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="d-flex">
                                        <a class="btn btn-primary mr-2" href="{{route('admin.sizes.show', $item)}}" title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-warning mr-2" href="{{route('admin.sizes.edit', $item)}}" title="Sửa"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $item->id }}" title="Xóa">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Xóa -->
                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex">
                                                <h5 class="modal-title font-weight-bold" id="deleteModalLabel{{ $item->id }}">XÁC NHẬN XÓA</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa kích cỡ "{{ $item->name }}" không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                                                <form action="{{ route('admin.sizes.destroy', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<script src="{{asset('plugins/js/checkall.js')}}"></script>
<script src="{{asset('plugins/js/ChangeActive/Size/deleteCheckedSize.js')}}"></script>


<script>
    // Loại bỏ padding-right khi modal đóng
    jQuery(document).on('hidden.bs.modal', function () {
        jQuery('body').css('padding-right', '0');
    });
</script>
@endsection
