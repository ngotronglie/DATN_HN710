


@extends('admin.dashboard')

@section('style')
<link href="{{ asset('node_modules/toastr/build/toastr.min.css') }}" rel="stylesheet" />
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
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Quản lí tài khoản</a></li>
                            <li class="active">Thùng rác</li>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong class="card-title">Danh sách thùng rác</strong>
                        <a href="{{ route('accounts.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th></th>
                                    <th style="white-space: nowrap;">Tên</th>
                                    <th style="white-space: nowrap;">Ảnh</th>
                                    <th style="white-space: nowrap;">Email</th>
                                    <th style="white-space: nowrap;">Địa chỉ</th>
                                    <th style="white-space: nowrap;">Điện thoại</th>
                                    <th style="white-space: nowrap;">Chức vụ</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashedUsers as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->name }}</td>
                                            <td><img width="50" src="{{Storage::url($item->avatar)}}" alt=""></td>
                                            <td>{{ $item->email }}</td>
                                            <td
                                                style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                                {{ $item->address }}
                                            </td>
                                            <td>{{ $item->phone }}</td>
                                            <td style="white-space: nowrap;">
                                                @if ($item->role == 0)
                                                    Người dùng
                                                @elseif($item->role == 1)
                                                    Nhân viên
                                                @elseif($item->role == 2)
                                                    Admin
                                                @else
                                                    Không xác định
                                                @endif
                                            </td>
                                    <td>
                                        {{-- <form action="{{ route('categories.restore', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success" onclick="return confirm('Bạn muốn khôi phục?')" title="Khôi phục"><i class="fa fa-repeat"></i></button>
                                        </form> --}}
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#restoreModal{{ $item->id }}" title="Khôi phục">
                                            <i class="fa fa-repeat"></i>
                                        </button>
                                        {{-- <form action="{{ route('categories.forceDelete', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa vĩnh viễn?')" title="Xóa vĩnh viễn"><i class="fa fa-trash"></i></button>
                                        </form> --}}
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $item->id }}" title="Xóa">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Khôi phục -->
                                <div class="modal fade" id="restoreModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex">
                                                <h5 class="modal-title font-weight-bold" id="restoreModalLabel{{ $item->id }}">XÁC NHẬN KHÔI PHỤC</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn khôi phục danh mục "{{ $item->name }}" không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                                                <form action="{{ route('accounts.restore', $item->id) }}" method="POST">
                                                    @csrf
                                                    
                                                    <button type="submit" class="btn btn-success">Xác nhận khôi phục</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                                Bạn có muốn xóa vĩnh viễn danh mục "{{ $item->name }}" không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                                                <form action="{{ route('accounts.forceDelete', $item->id) }}" method="POST">
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
<script src="{{ asset('node_modules/toastr/build/toastr.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    });
</script>
@endsection
