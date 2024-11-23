@extends('admin.dashboard')

@section('content')
    <div class="content mb-5">
        <div class="animated fadeIn">
            <div class="row">
    
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Thay đổi mật khẩu</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.accounts.updatePassword') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="current_password" class="col-sm-4 col-form-label">Mật khẩu hiện tại</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="password" class="form-control" placeholder="Nhập mật khẩu cũ" id="current_password" name="current_password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('current_password', 'eyeIconCurrent')">
                                                    <i class="fa fa-eye" id="eyeIconCurrent"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('current_password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="new_password" class="col-sm-4 col-form-label">Mật khẩu mới</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="password" class="form-control" placeholder="Nhập mật khẩu mới" id="new_password" name="new_password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('new_password', 'eyeIconNew')">
                                                    <i class="fa fa-eye" id="eyeIconNew"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('new_password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>            
                    
                                <div class="form-group row">
                                    <label for="new_password_confirmation" class="col-sm-4 col-form-label">Xác nhận mật khẩu mới</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="password" class="form-control" placeholder="Nhập lại mật khẩu mới" id="new_password_confirmation" name="new_password_confirmation">
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('new_password_confirmation', 'eyeIconConfirm')">
                                                    <i class="fa fa-eye" id="eyeIconConfirm"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('new_password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>            
                    
                                <div class="form-group row">
                                    <div class="col-sm-8 offset-sm-4">
                                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    
    
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection

@section('script')
<script>
    function togglePassword(inputId, iconId) {
        var passwordField = document.getElementById(inputId);
        var eyeIcon = document.getElementById(iconId);
    
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
@endsection
