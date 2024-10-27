@extends('admin.dashboard')

@section('content')
    <div class="container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="row" style="width: 100%; max-width: 1200px;">
            <!-- Cập nhật thông tin cá nhân -->
            <div class="col-md-6">
                <div class="card" style="width: 100%;">
                    <div class="card-header">Thông Tin Cá Nhân</div>
                    <div class="card-body card-block">
                        <form action="{{ route('admin.accounts.updateMyAccount', $user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    <input type="text" id="username" name="name" placeholder="Username" class="form-control" value="{{ $user->name }}" >
                                    
                                </div>
                                @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                    <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
                                    <input type="text" id="address" name="address" placeholder="Địa chỉ" class="form-control" value="{{ $user->address }}">
                                    
                                </div>
                                @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                    <input type="text" id="phone" name="phone" placeholder="Phone" class="form-control" value="{{ $user->phone }}">
                                    
                                </div>
                                @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="date" id="date_of_birth" name="date_of_birth" placeholder="Date_of_birth" class="form-control" value="{{ $user->date_of_birth }}">
                                  
                                </div>
                                @error('date_of_birth')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="menu-icon fa fa-photo"></i></div>
                                    <input type="file" id="avatar" name="avatar" placeholder="Avatar" class="form-control">
                                </div>
                                @if ($user->avatar)
                                    <div class="text-center mt-2 mb-3">
                                        <img width="100" src="{{ Storage::url($user->avatar) }}" alt="Avatar" style="border: 2px solid #ccc; border-radius: 50%; padding: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                    </div>
                                @endif
                                @error('avatar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div>
                                <button class="btn btn-success" type="submit">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Đổi mật khẩu -->
            <div class="col-md-6">
                <div class="card" style="width: 100%;">
                    <div class="card-header">Đổi Mật Khẩu</div>
                    <div class="card-body card-block">
                        <form action="{{ route('admin.accounts.updatePassword', $user->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                    <input type="password" id="current_password" name="current_password" placeholder="Mật khẩu hiện tại" class="form-control" >
                                   
                                </div>
                                @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                    <input type="password" id="new_password" name="new_password" placeholder="Mật khẩu mới" class="form-control" >
                                   
                                </div>
                                @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Xác nhận mật khẩu mới" class="form-control" >
                                   
                                </div>
                                @error('new_password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            </div>

                            <div>
                                <button class="btn btn-primary" type="submit">Đổi mật khẩu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
