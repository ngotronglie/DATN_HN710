@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Quản lý bình luận</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Quản lý bình luận</a></li>
                            <li class="active">Danh sách bình luận</li>
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
                        <strong class="card-title">Danh sách bình luận</strong>
                        <div class="dropdown float-right ml-2">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cogs"></i> Tùy chọn
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item activeAll" data-is_active="0" href="#">
                                    <i class="fa fa-toggle-on text-success"></i> Bật các mục đã chọn
                                </a>
                                <a class="dropdown-item activeAll" data-is_active="1" href="#">
                                    <i class="fa fa-toggle-off text-danger"></i> Tắt các mục đã chọn
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-trash text-danger"></i> Xóa các mục đã chọn
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <input id="checkAllTable" type="checkbox">
                                    </th>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Sản phẩm</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Sản phẩm</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($comments as $comment)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkBoxItem" data-id="{{ $comment->id }}">
                                    </td>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{ $comment->product->name }}</td>
                                    <td>{{ Str::limit($comment->content, 50) }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" class="js-switch active"
                                            data-model="{{ $comment->is_active }}"
                                            {{ $comment->is_active ? 'checked' : '' }} data-switchery="true"
                                            data-modelId="{{ $comment->id }}" />
                                    </td>
                                    <td class="d-flex">
                                        <a href="{{ route('admin.comments.show', $comment->id) }}"
                                            class="btn btn-info mr-2" title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.comments.toggleStatus', $comment->id) }}"
                                            class="btn btn-warning mr-2" title="Đổi trạng thái">
                                            <i class="fa fa-toggle-on"></i>
                                        </a>

                                    </td>
                                </tr>

                                <!-- Modal Xóa -->
                                <!-- <div class="modal fade" id="deleteModal{{ $comment->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel{{ $comment->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex">
                                                <h5 class="modal-title font-weight-bold"
                                                    id="deleteModalLabel{{ $comment->id }}">XÁC NHẬN XÓA</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa bình luận từ "{{ $comment->user->name }}"
                                                không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Hủy</button>
                                                <form action="{{ route('admin.comments.destroy', $comment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script src="{{asset('plugins/js/checkall.js')}}"></script>
<script src="{{asset('plugins/js/changeActive/Account/changeActiveAccount.js')}}"></script>
<script src="{{asset('plugins/js/changeActive/Account/changeAllActiveAccount.js')}}"></script>
@endsection