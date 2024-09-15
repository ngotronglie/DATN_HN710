@extends('admin.dashboard')
@section('style')
<link href="{{ asset('node_modules/toastr/build/toastr.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('admin/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection

@section('content')
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Tài Khoản</strong>
                        </div>
                        <div class="card-body">

                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap;">Tên</th>
                                        <th style="white-space: nowrap;">Email</th>
                                        <th style="white-space: nowrap;">Địa chỉ</th>
                                        <th style="white-space: nowrap;">Điện thoại</th>
                                        <th style="white-space: nowrap;">Ảnh</th>
                                        <th style="white-space: nowrap;">Chức vụ</th>
                                        <th style="white-space: nowrap;">Trạng thái</th>
                                        <th style="white-space: nowrap;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td
                                                style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                                {{ $user->address }}
                                            </td>
                                            <td>{{ $user->phone }}</td>
                                            <td><img width="100px" src="{{Storage::url($user->avatar)}}" alt=""></td>
                                            <td style="white-space: nowrap;">
                                                @if ($user->role == 0)
                                                    Người dùng
                                                @elseif($user->role == 1)
                                                    Nhân viên
                                                @elseif($user->role == 2)
                                                    Admin
                                                @else
                                                    Không xác định
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                <input type="checkbox" class="js-switch"  {{ $user->is_active ? 'checked' : '' }} disabled>
                                            </td>
                                                <td class="d-flex">
                                                    <a class="btn btn-primary mr-2" href="{{route('accounts.show', $user->id)}}" title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-warning mr-2" href="{{route('accounts.edit', $user->id)}}" title="Sửa"><i class="fa fa-edit"></i></a>
                                                    <form action="{{route('accounts.softDelete', $user->id)}}" method="POST">
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
    <script src="{{ asset('node_modules/toastr/build/toastr.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#bootstrap-data-table-export').DataTable();
        });
    </script>
    
@endsection
