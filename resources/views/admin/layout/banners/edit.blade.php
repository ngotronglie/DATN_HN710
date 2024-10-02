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
                            <li><a href="{{ route('admin.banners.index') }}">Danh sách banner</a></li>
                            <li class="active">Sửa banner</li>
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
                        <strong>Sửa banner</strong>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body card-block">
                        <form action="{{ route('admin.banners.update', $banner->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title" class="form-control-label">Tiêu đề</label>
                                <input type="text" id="title" name="title" placeholder="Nhập tiêu đề" class="form-control" value="{{ old('title', $banner->title) }}" required>
                                @error('title')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="link" class="form-control-label">Link</label>
                                <input type="url" id="link" name="link" placeholder="https://example.com" class="form-control" value="{{ old('link', $banner->link) }}" required>
                                @error('link')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-control-label">Banner</label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                <!-- Hiển thị ảnh hiện tại -->
                                @if($banner->image)
                                    <img id="preview" src="{{ asset('storage/' . $banner->image) }}" alt="Xem trước ảnh" style="max-width: 100%; height: auto; margin-top: 10px;">
                                @else
                                    <img id="preview" src="#" alt="Xem trước ảnh" style="display:none; max-width: 100%; height: auto; margin-top: 10px;">
                                @endif
                                @error('image')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-control-label">Mô tả</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="5" required>{{ old('description', $banner->description) }}</textarea>
                                @error('description')
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
    jQuery(document).ready(function(){
        jQuery('#image').on('change', function(e) {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    jQuery('#preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
@endsection
