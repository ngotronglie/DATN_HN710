@extends('admin.dashboard')

@section('style')
    <link href="{{ asset('node_modules/toastr/build/toastr.min.css') }}" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection

@section('content')
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Chi Tiết Tài Khoản</div>
                       
                        <div class="card-body card-block" style="display: flex; justify-content: center;">
                            <form action="" method="post" class="" style="width: 50%;"
                                enctype="multipart/form-data">
                                @csrf
                                <!-- Form Fields -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                        <input type="text" id="name" name="name" 
                                            class="form-control" value="{{$user->name}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                        <input type="email" id="email" name="email" placeholder="Email"
                                            class="form-control"  value="{{$user->email}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
                                        <input type="text" id="address" name="address" placeholder="Địa Chỉ"
                                            class="form-control"  value="{{$user->address}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                        <input type="text" id="phone" name="phone" placeholder="Điện Thoại"
                                            class="form-control"  value="{{$user->phone}}" disabled>
                                    </div>
                                </div>
                                @if($user->avatar)
                                <div class="text-center mb-4">
                
                                            <img width="100" src="{{Storage::url($user->avatar)}}" alt="">
                                </div>
                              
                                @endif
                               
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="date" id="date_of_birth" name="date_of_birth"
                                            placeholder="Ngày Sinh" class="form-control"  value="{{$user->date_of_birth}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <select name="role" id="select" class="form-control" disabled>
                                            <option selected disabled hidden>Chức Vụ</option>
                                            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Người dùng</option>
                                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Nhân viên</option>
                                            <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-unlock"></i>
                                        </div>
                                        <div style="margin-left: 40px;margin-top: 10px">
                                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                                class="form-check-input" @checked($user->is_active) disabled>
                                            <label for="is_active">Hoạt Động</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions form-group">
                                    <a href="{{route('accounts.index')}}" class="btn btn-success">Quay Lại</a>
                                    <a href="{{route('accounts.edit',$user->id)}}" class="btn btn-warning">Sửa</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
@endsection
@section('script')
    <!-- Thêm jQuery trước toastr -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
             //thành công 
            @if (session('success'))
                toastr.success('{{ session('success') }}', 'Thông báo');
            @endif

            //báo lỗi
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}', 'Lỗi');
                @endforeach
            @endif
        });
    </script>
@endsection

