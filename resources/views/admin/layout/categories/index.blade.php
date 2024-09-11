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

<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Danh sách danh mục</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{!! $item->is_active ? '<span class="badge bg-success text-white">Hoạt động</span>' : '<span class="badge bg-danger text-white">Không hoạt động</span>' !!}</td>
                                    <td class="d-flex">
                                        <a class="btn btn-primary mr-2" href="{{route('categories.show', $item)}}" title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-warning mr-2" href="{{route('categories.edit', $item)}}" title="Sửa"><i class="fa fa-edit"></i></a>
                                        <form action="{{route('categories.destroy', $item)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" title="Xóa"><i class="fa fa-trash"></i></button>
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
        $('#bootstrap-data-table-export').DataTable();
    });
</script>
@endsection