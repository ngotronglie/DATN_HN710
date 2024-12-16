@extends('admin.dashboard')
@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Sửa tài khoản</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.accounts.index') }}">Quản lí tài khoản</a></li>
                            <li class="active">Sửa tài khoản</li>
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
                        <strong>Sửa tài khoản</strong>
                        <a href="{{ route('admin.accounts.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body card-block">
                        <form action="{{ route('admin.accounts.update', $account) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="font-weight-bold mb-2">Chức vụ của {{ $account->name }} ({{ $account->role == 0 ? 'Người dùng' : 'Nhân viên' }})</div>
                            <div class="form-group">
                                <label for="role">Chức vụ</label>
                                <select name="role" id="role" class="form-control select2">
                                    <option value="">--- Vui lòng chọn ---</option>
                                    <option value="0" {{ (old('role', $account->role) == 0) ? 'selected' : '' }}>Người dùng</option>
                                    <option value="1" {{ (old('role', $account->role) == 1) ? 'selected' : '' }}>Nhân viên</option>
                                </select>
                                @error('role')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group shift_work">
                                <label for="shift" class="form-control-label">Ca làm việc</label>
                                <select name="work_shift_id" class="form-control select2 shift">
                                    <option style="display: none" value="">--Vui lòng chọn--</option>
                                    @foreach ($shift as $item)
                                    <option value="{{ $item->id }}" {{ old('work_shift_id', $account->work_shift_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->shift_name }} ({{ $item->start_time }} - {{ $item->end_time }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('work_shift_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success mb-1">Cập nhật</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
  jQuery(document).ready(function () {
    jQuery('#role').on('change', function () {
        let selectedValue = jQuery(this).val();
        if (selectedValue == '1') {
            jQuery('.shift_work').fadeIn(100);
        } else {
            jQuery('.shift_work').fadeOut(100);
            jQuery('select[name="work_shift_id"]').val('');
        }
    });

    let initialValue = jQuery('#role').val();
    if (initialValue == '1') {
        jQuery('.shift_work').show();
    } else {
        jQuery('.shift_work').hide();
        jQuery('select[name="work_shift_id"]').val('');
    }
});
</script>
@endsection

