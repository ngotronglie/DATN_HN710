@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Chi tiết bài viết</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.blogs.index') }}">Danh sách bài viết</a></li>
                            <li class="active">Chi tiết bài viết</li>
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
                        <strong>Chi tiết bài viết</strong>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tên bài viết</th>
                                    <td>{{ $blog->title }}</td>
                                </tr>
                                <tr>
                                    <th>Tác giả:</th>
                                    <td>
                                        {{ $blog->user->name }}
                                        @if (!$blog->user->is_active)
                                            <span style="color: red;">(Bị khóa)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Danh mục:</th>
                                    <td>
                                        {{ $blog->categoryBlog->name }}
                                        @if (!$blog->categoryBlog->is_active)
                                            <span style="color: red;">(Bị khóa)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ảnh đại diện</th>
                                    <td>
                                        @if($blog->img_avt)
                                        <img src="{{ Storage::url($blog->img_avt) }}" alt="Blog Image" style="width: 200px; height: 130px; object-fit: contain;">
                                        @else
                                        <span>Không có hình ảnh</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mô tả sản phẩm</th>
                                    <td>
                                        <div id="shortDescription" class="ml-2">
                                            {!! substr($blog->content, 0, 200) !!}...
                                            <a href="javascript:void(0);" onclick="showMore()">Xem thêm</a>
                                        </div>
                                        <div id="fullDescription" style="display:none;" class="ml-2">
                                            {!! $blog->content !!}
                                            <a href="javascript:void(0);" onclick="showLess()">Ẩn bớt</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lượt xem</th>
                                    <td>{{ $blog->view }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if($blog->is_active)
                                        <span class="badge badge-success">Hoạt động</span>
                                        @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td>{{ $blog->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td>{{ $blog->updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning btn-icon-split">
                                <i class="fa fa-edit"></i> Sửa
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

@endsection

@section('script')
<script>
    function showMore() {
        document.getElementById('shortDescription').style.display = 'none'; // Hide short description
        document.getElementById('fullDescription').style.display = 'block'; // Show full description
    }
    
    function showLess() {
        document.getElementById('shortDescription').style.display = 'block'; // Show short description
        document.getElementById('fullDescription').style.display = 'none'; // Hide full description
    }
</script>
@endsection