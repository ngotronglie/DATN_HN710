@extends('admin.dashboard')

@section('content')
    <div class="breadcrumbs mb-5">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="{{ route('colors.index') }}">Danh sách màu</a></li>
                                <li class="active">Sửa màu</li>
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
                            <strong>Sửa màu</strong>
                            <a href="{{ route('colors.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-1"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{ route('colors.update', $color) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name" class=" form-control-label">Tên màu</label><input type="text" id="name" name="name" placeholder="Nhập tên màu" class="form-control" value="{{ old('name', $color->name) }}" requied>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="hex_code">Mã màu</label> <input type="color" id="hex_code" name="hex_code"  value="{{ old('hex_code', $color->hex_code) }}" requied>
                                    @error('hex_code')
                                    <div class="text-danger">{{ $message }}</div>
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
