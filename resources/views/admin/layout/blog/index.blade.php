@extends('admin.dashboard')

@section('style')
<link rel="stylesheet" href="{{ asset('admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
{{-- swcr --}}
<link rel="stylesheet" href="{{asset('plugins/css/plugins/switchery/switchery.css')}}">
@endsection

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
                            <li><a href="#">Quản lí danh mục</a></li>
                            <li class="active">Danh sách danh mục</li>
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
                        <strong class="card-title">Danh sách danh mục</strong>
                        <div>
                            <a class="btn btn-primary mr-2" href="{{ route('category_blogs.create') }}">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                            <a class="btn btn-danger" href="{{ route('category_blogs.trashed') }}">
                                <i class="fa fa-trash"></i> Thùng rác ({{ $trashedCount }})
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <input id="checkallus" type="checkbox">
                                    </th>
                                    <th>STT</th>
                                    <th>Tên danh mục bài viết</th>
                                    <th>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>
                                        <input id="checkallus" type="checkbox">
                                    </th>
                                    <th>STT</th>
                                    <th>Tên danh mục bài viết</th>
                                    <th>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data as $key => $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkBoxItem" data-id="{{ $item->id }}">
                                    </td>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td style="width: 8%" class="text-center">
                                    <input type="checkbox" class="js-switch active" data-model="{{ $item->is_active }}"
                                        {{ $item->is_active == 1 ? 'checked' : '' }} data-switchery="true"
                                        data-modelId="{{ $item->id }}" />
                                </td>
                                <td class="d-flex">
                                    <a class="btn btn-primary mr-2" href="{{route('category_blogs.show', $item)}}" title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-warning mr-2" href="{{route('category_blogs.edit', $item)}}" title="Sửa"><i class="fa fa-edit"></i></a>
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
                                                Bạn có chắc chắn muốn xóa danh mục "{{ $item->name }}" không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                                                <form action="{{ route('category_blogs.destroy', $item) }}" method="POST">
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
{{-- swcr --}}
<script src="{{asset('plugins/js/plugins/switchery/switchery.js')}}"></script>
<script src="{{asset('plugins/js/swk.js')}}"></script>
<script src="{{asset('plugins/js/checkall.js')}}"></script>
<script src="{{asset('plugins/js/changeAcCtgrbl.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    });
</script>
@endsection

