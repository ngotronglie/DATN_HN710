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
                            <h1>Danh sách bài viết</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Bảng điều khiển</a></li>
                                <li><a href="#">Quản lí bài viết</a></li>
                                <li class="active">Danh sách bài viết</li>
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
                            <strong class="card-title">Danh sách danh mục</strong>
                            <div class="d-flex">
                                <a class="btn btn-primary mr-2" href="{{ route('admin.blogs.create') }}">
                                    <i class="fa fa-plus"></i> Thêm mới
                                </a>
                                <a class="btn btn-danger countTrash" href="{{ route('admin.blogs.trashed') }}">
                                    <i class="fa fa-trash"></i> Thùng rác <span class="blogCout">({{ $trashedCount }})</span>
                                </a>
                                @if(Auth::user()->role == 2)
                                <div class="dropdown float-right ml-2">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-cogs"></i> Tùy chọn
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right shadow"
                                        aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item activeAll" data-is_active="0" href="#">
                                            <i class="fa fa-toggle-on text-success"></i> Bật các mục đã chọn
                                        </a>
                                        <a class="dropdown-item activeAll" data-is_active="1" href="#">
                                            <i class="fa fa-toggle-off text-danger"></i> Tắt các mục đã chọn
                                        </a>
                                        <a class="dropdown-item deleteAll" href="#">
                                            <i class="fa fa-trash text-danger"></i> Xóa các mục đã chọn
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered" data-disable-sort="false">
                                <thead>
                                    <tr>
                                        @if(Auth::user()->role == 2)
                                        <th>
                                            <input id="checkAllTable" type="checkbox">
                                        </th>
                                        @endif
                                        <th>STT</th>
                                        <th>Bài viết</th>
                                        <th>Người tạo</th>
                                        <th>Danh mục</th>
                                        <th>Trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    @if(Auth::user()->role == 2)
                                        <th></th>
                                    @endif
                                        <th>STT</th>
                                        <th>Bài viết</th>
                                        <th>Người tạo</th>
                                        <th>Danh mục</th>
                                        <th>Trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </tfoot>
                                <tbody class="null_Table">
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            @if(Auth::user()->role == 2)
                                            <td>
                                                <input type="checkbox" class="checkBoxItem" data-id="{{ $item->id }}">
                                            </td>
                                            @endif
                                            <td>{{ $key + 1 }}</td>
                                            <td style="white-space: nowrap">
                                                <div class="d-flex align-items-end">
                                                    <img src="{{Storage::url($item->img_avt)}}" alt="Thumbnail" class="mr-2" style="height: 80px; width: 100px; object-fit: cover;">
                                                    <div class="text-truncate" style="max-width: 200px;">
                                                        <span>{{ $item->title }}</span>
                                                        <div>{{ $item->created_at }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->user->name }}
                                                @if (!$item->user->is_active)
                                                    <div style="color: red;">(Bị khóa)</div>
                                                @endif
                                            </td>
                                            <td>
                                                {{$item->categoryBlog->name}}
                                                @if (!$item->categoryBlog->is_active)
                                                    <div style="color: red;">(Bị khóa)</div>
                                                @endif
                                            </td>
                                            <td style="width: 12%" class="text-center">
                                                <input type="checkbox" class="js-switch active"
                                                    data-model="{{ $item->is_active }}"
                                                    {{ $item->is_active == 1 ? 'checked' : '' }} data-switchery="true"
                                                    data-modelId="{{ $item->id }}" data-title="{{ $item->title }}" @if(Auth::user()->role != 2) disabled @endif />
                                            </td>
                                            <td class="d-flex">
                                                <a class="btn btn-primary mr-2"
                                                    href="{{ route('admin.blogs.show', $item) }}" title="Xem chi tiết"><i
                                                        class="fa fa-eye"></i></a>
                                                <a class="btn btn-warning mr-2"
                                                    href="{{ route('admin.blogs.edit', $item) }}" title="Sửa"><i
                                                        class="fa fa-edit"></i></a>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $item->id }}" title="Xóa">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Xóa -->
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex">
                                                        <h5 class="modal-title font-weight-bold"
                                                            id="deleteModalLabel{{ $item->id }}">XÁC NHẬN XÓA</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa danh mục "{{ $item->title }}" không?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                            data-dismiss="modal">Hủy</button>
                                                        <form action="{{ route('admin.blogs.destroy', $item) }}"
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

    <script src="{{ asset('plugins/js/checkall.js') }}"></script>

    <script src="{{ asset('plugins/js/changeActive/Blog/changeAllActiveBlog.js') }}"></script>

    <script src="{{ asset('plugins/js/changeActive/Blog/changeActiveBlog.js') }}"></script>

    <script src="{{ asset('plugins/js/ChangeActive/Blog/deleteAllBlog.js') }}"></script>

    <script>
        // Loại bỏ padding-right khi modal đóng
        jQuery(document).on('hidden.bs.modal', function () {
            jQuery('body').css('padding-right', '0');
        });
    </script>

@endsection
