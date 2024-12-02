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
                            @if (auth()->user()->avatar)
                                <img id="profile-image" src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar"
                                    class="img-thumbnail rounded-circle"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img id="profile-image" src="https://via.placeholder.com/150" alt="Avatar"
                                    class="img-thumbnail rounded-circle"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @endif
                        </div>
                        <form action="{{ route('admin.accounts.updateMyAccount') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Họ và tên -->
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Họ và tên</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ auth()->user()->name }}</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="form-group row">
                                <label for="phone" class="col-sm-3 col-form-label">Số điện thoại</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Nhập số điện thoại"
                                        id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Ngày sinh -->
                            <div class="form-group row">
                                <label for="date_of_birth" class="col-sm-3 col-form-label">Ngày sinh</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}">
                                    @error('date_of_birth')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            @php
                            $user = Auth::user();
                            if (!empty($user->address)) {
                                $addressParts = explode(',', $user->address);
                                $city = isset($addressParts[count($addressParts) - 1]) ? trim($addressParts[count($addressParts) - 1]) : null;
                                $district = isset($addressParts[count($addressParts) - 2]) ? trim($addressParts[count($addressParts) - 2]) : null;
                                $ward = isset($addressParts[count($addressParts) - 3]) ? trim($addressParts[count($addressParts) - 3]) : null;
                                $adressDetail = isset($addressParts[count($addressParts) - 4]) ? trim($addressParts[count($addressParts) - 4]) : null;
                            } else {
                                $city = $district = $ward = $adressDetail= null;
                            }
                            @endphp

                            <!-- Thành phố -->
                            <div class="form-group row">
                                <label for="province" class="col-sm-3 col-form-label">Tỉnh/Thành Phố</label>
                                <div class="col-sm-9">
                                    <select class="select2 province form-control" data-id="{{$city}}" name="provinces">
                                        <option value="">[Chọn Tỉnh/Thành phố]</option>
                                        @foreach ($provinces as $item)
                                            <option value="{{ $item->code }}" {{ $city == $item->code ? 'selected' : '' }}>
                                              {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Quận/Huyện -->
                            <div class="form-group row">
                                <label for="district" class="col-sm-3 col-form-label">Quận/Huyện</label>
                                <div class="col-sm-9">
                                    <select class="select2 districts form-control" data-id="{{$district}}" name="districs">
                                        <option value="">[Chọn Quận/Huyện]</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Phường/Xã -->
                            <div class="form-group row">
                                <label for="ward" class="col-sm-3 col-form-label">Phường/Xã</label>
                                <div class="col-sm-9">
                                    <select class="select2 wards form-control" data-id="{{$ward}}" name="wards">
                                        <option value="">[Chọn Phường/Xã]</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tên đường/tòa nhà/số nhà -->
                            <div class="form-group row">
                                <label for="address-detail" class="col-sm-3 col-form-label">Tên đường/tòa nhà/số nhà</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Tên đường/tòa nhà/số nhà"
                                        id="address-detail" name="address" value="{{ old('address', $adressDetail) }}">
                                        @if($errors->has('provinces') || $errors->has('address') || $errors->has('wards') || $errors->has('districs'))
                                        <span class="text-danger mt-5">Vui lòng nhập đầy đủ các trường địa chỉ.</span>
                                        @endif
                                </div>
                            </div>

                            <!-- Buttons -->
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
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('plugins/js/location.js') }}"></script>

    <script>
        // Hiển thị ảnh đã chọn
        function previewImage() {
            var file = document.getElementById("avatar").files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                document.getElementById("profile-image").src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
