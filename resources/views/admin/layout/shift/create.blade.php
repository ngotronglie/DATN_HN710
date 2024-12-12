@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Thêm ca làm việc</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.shift.index') }}">Danh sách ca làm việc</a></li>
                            <li class="active">Thêm ca làm việc</li>
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
                        <strong>Thêm ca làm việc</strong>
                        <a href="{{ route('admin.shift.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                  
              
                    <div class="card-body card-block">
                        <form action="{{ route('admin.shift.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Ca làm việc</label>
                                <input type="text" id="name" name="shift_name" placeholder="Nhập tên ca làm việc" class="form-control" value="{{ old('shift_name') }}">
                                @error('shift_name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Thời gian bắt đầu</label>
                                <input type="time" id="name" name="start_time" placeholder="Nhập ca làm việc" class="form-control" value="{{ old('shift_name') }}">
                                @error('start_time')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Thời gian kết thúc</label>
                                <input type="time" id="name" name="end_time" placeholder="Nhập ca làm việc" class="form-control" value="{{ old('shift_name') }}">
                                @error('end_time')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Phần trạng thái đã được loại bỏ. Nếu cần thiết, có thể thêm lại sau -->
                            <button type="submit" class="btn btn-success mb-1">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection