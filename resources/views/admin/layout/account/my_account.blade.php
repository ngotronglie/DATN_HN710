@extends('admin.dashboard')

@section('content')
    <div class="content mb-5">
        <div class="animated fadeIn">
            <div class="row">
    
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Hồ sơ cá nhân</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                @if(auth()->user()->avatar)
                                    <img id="profile-image" src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img id="profile-image" src="https://via.placeholder.com/150" alt="Avatar" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                            </div>
                            <form action="{{ route('admin.accounts.updateMyAccount') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="#" class="col-sm-3 col-form-label">Họ và tên</label>
                                    <div class="col-sm-9">
                                        <p class="form-control-plaintext">{{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                    
                                <div class="form-group row">
                                    <label for="#" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <p class="form-control-plaintext">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                    
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-3 col-form-label">Số điện thoại</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nhập số điện thoại" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                    
                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 col-form-label">Địa chỉ</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nhập địa chỉ" id="address" name="address" value="{{ old('address', auth()->user()->address) }}">
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="date_of_birth" class="col-sm-3 col-form-label">Ngày sinh</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}">
                                        @error('date_of_birth')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                    
                                <div class="form-group row">
                                    <label for="image" class="col-sm-3 col-form-label">Ảnh đại diện</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="avatar" name="avatar" onchange="previewImage()" accept="image/*">
                                            <label class="custom-file-label" for="avatar">Chọn ảnh...</label>
                                            @error('avatar')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        <a href="{{ route('admin.accounts.showChangePasswordForm') }}" class="btn btn-secondary ml-2">Đổi mật khẩu</a>
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
    // Hiển thị ảnh đã chọn
    function previewImage() {
        var file = document.getElementById("avatar").files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            document.getElementById("profile-image").src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
