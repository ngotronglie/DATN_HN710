@extends('admin.dashboard')
@section('style')
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
                                        <th style="white-space: nowrap;">Avata</th>
                                        <th style="white-space: nowrap;">Ngày sinh</th>
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
                                            <td>{{ $user->avata }}</td>
                                            <td>{{ $user->date_of_birth }}</td>
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
                                            <td style="white-space: nowrap;">
                                                {{ $user->is_active == 0 ? 'Không hoạt động' : 'Hoạt động' }}</td>
                                            <td style="white-space: nowrap;">
                                                <a href="{{route('accounts.show',$user)}}" class="btn btn-primary">Xem</a>
                                                <a href="{{route('accounts.edit',$user)}}" class="btn btn-success">Sửa</a>
                                                <form action="{{route('accounts.destroy',$user)}}" method="post" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-warning">Xóa</button>
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


    <script type="text/javascript">
        $(document).ready(function() {
            $('#bootstrap-data-table-export').DataTable();
        });
    </script>
@endsection
