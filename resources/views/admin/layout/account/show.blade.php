@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Chi tiết tài khoản</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="{{ route('admin.accounts.index') }}">Danh sách tài khoản</a></li>
                            <li class="active">Chi tiết tài khoản</li>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Chi tiết tài khoản</strong>
                        <a href="{{ route('admin.accounts.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tên người dùng</th>
                                    <td>{{ $account->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $account->email }}</td>
                                </tr>
                                <th>Địa chỉ</th>
                                <td>{{ $account->address }}</td>
                                <tr>
                                </tr>
                                <th>Điện Thoại</th>
                                <td>{{ $account->phone }}</td>
                                <tr>
                                </tr>
                                <th>Ảnh</th>
                                @if($account->avatar)
                                <td><img width="100px" src="{{Storage::url($account->avatar)}}" alt=""></td>
                                @else
                                <td><span>Chưa cập nhật</span></td>
                                @endif
                                <tr>
                                </tr>
                                <th>Ngày sinh</th>
                                <td>{{ \Carbon\Carbon::parse($account->date_of_birth)->format('d/m/Y') }}</td>                                <tr>
                                </tr>
                                <th>Chức vụ</th>
                                <td>
                                    @php
                                    $role = '';
                                    if ($account->role == 0) {
                                    $role = 'Người dùng';
                                    } elseif ($account->role == 1) {
                                    $role = 'Nhân viên';
                                    } elseif ($account->role == 2) {
                                    $role = 'Admin';
                                    }
                                    @endphp
                                    {{ $role }}
                                </td>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td>{{ \Carbon\Carbon::parse($account->created_at)->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td>{{ \Carbon\Carbon::parse($account->update_at)->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if ($account->is_active)
                                        <span class="badge badge-success">Hoạt động</span>
                                        @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.accounts.edit', $account) }}" class="btn btn-warning btn-icon-split">
                            <i class="fa fa-edit"></i> Sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
@endsection