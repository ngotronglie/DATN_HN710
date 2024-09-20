@extends('admin.dashboard')

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<!-- Custom styles for the modal -->

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
                            <li><a href="#">Quản lí Blogs</a></li>
                            <li class="active">Danh sách Blogs</li>
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
                        <!-- Tiêu đề card -->
                        <strong class="card-title">Danh sách Blogs</strong>

                        <!-- Nhóm các nút hành động bên phải -->
                        <div>
                            <!-- Nút Thêm mới -->
                            <a href="{{ route('blogs.create') }}" class="btn btn-primary mr-2">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>

                            <!-- Nút Thùng rác với số lượng blogs bị xóa -->
                            <a href="{{ route('blogs.trashed') }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i> Thùng rác
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>

                                    <th>Ngày đăng</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>

                                    <td>{{ \Carbon\Carbon::parse($item->published_at)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($item->status == 0)
                                        <span class="badge bg-success text-white">Đã xuất bản</span>
                                        @elseif ($item->status == 1)
                                        <span class="badge bg-danger text-white">Nháp</span>
                                        @endif
                                    </td>
                                    <td class="d-flex">
                                        <a class="btn btn-primary mr-2" href="{{ route('blogs.show', $item) }}"
                                            title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-warning mr-2" href="{{ route('blogs.edit', $item) }}"
                                            title="Sửa"><i class="fa fa-edit"></i></a>

                                        <!-- Trigger modal -->
                                        <button type="button" class="btn btn-danger mr-2" data-toggle="modal"
                                            data-target="#deleteModal{{ $item->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-bold"
                                                            id="deleteModalLabel{{ $item->id }}">XÁC NHẬN XÓA</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa blog "{{ $item->title }}" không?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="{{ route('blogs.destroy', $item) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Xác nhận
                                                                xóa</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

<!-- Beautiful Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-custom">
                Bạn có chắc chắn muốn xóa blog này không?
            </div>
            <div class="modal-footer modal-footer-custom">
                <button type="button" class="btn btn-secondary-custom" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger-custom" id="confirm-delete">Xóa</button>
            </div>
        </div>
    </div>
</div>

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

    // Trigger delete modal with blog id
    let deleteFormId;
    $('.btn-delete').on('click', function() {
        deleteFormId = $(this).data('id');
    });

    // Handle modal confirmation
    $('#confirm-delete').on('click', function() {
        $('#delete-form-' + deleteFormId).submit();
    });
});
</script>
@endsection