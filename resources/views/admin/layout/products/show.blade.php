@extends('admin.dashboard')

@section('content')
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Chi tiết sản phẩm</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="{{ route('admin.products.index') }}">Danh sách sản phẩm</a></li>
                            <li class="active">Chi tiết sản phẩm</li>
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
                        <strong>Chi tiết sản phẩm</strong>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $product->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Ảnh đại diện</th>
                                    <td>
                                        @if($product->img_thumb)
                                        <img src="{{ Storage::url($product->img_thumb) }}" alt="Product Image" style="width: 200px; height: 250px; object-fit: contain;">
                                        @else
                                        <span>Không có hình ảnh</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mô tả sản phẩm</th>
                                    <td>
                                        <div id="shortDescription" class="ml-2">
                                            {!! substr($product->description, 0, 200) !!}...
                                            <a href="javascript:void(0);" onclick="showMore()">Xem thêm</a>
                                        </div>
                                        <div id="fullDescription" style="display:none;" class="ml-2">
                                            {!! $product->description !!}
                                            <a href="javascript:void(0);" onclick="showLess()">Ẩn bớt</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td>
                                        {{ $product->category->name }}
                                        @if (!$product->category->is_active)
                                            <span style="color: red;">(Bị khóa)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lượt xem</th>
                                    <td>{{ $product->view }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if($product->is_active)
                                        <span class="badge badge-success">Hoạt động</span>
                                        @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thời gian tạo</th>
                                    <td>{{ $product->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian sửa</th>
                                    <td>{{ $product->updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Hiển thị thư viện ảnh -->
                <div class="card mt-4">
                    <div class="card-header">
                        <strong>Thư viện ảnh</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($product->galleries as $gallery)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ Storage::url($gallery->image) }}" alt="Gallery Image" style="width: 200px; height: 250px; object-fit: contain;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Hiển thị bảng biến thể sản phẩm -->
                <div class="card mt-4">
                    <div class="card-header">
                        <strong>Biến thể sản phẩm</strong>
                    </div>
                    <div class="card-body">
                        @if($product->variants->isEmpty())
                            <div class="alert alert-warning text-danger text-center">Không có sản phẩm biến thể vì màu và size bị xóa!</div>
                        @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kích thước</th>
                                    <th>Màu sắc</th>
                                    <th>Giá</th>
                                    <th>Giá khuyến mãi</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variants as $variant)
                                    <tr>
                                        <td>{{ $variant->size->name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="rounded-circle mr-2" style="width: 20px; height: 20px; background-color: {{ $variant->color->hex_code }};"></div>
                                                <span>{{ $variant->color->hex_code }}</span> <span class="ml-1">({{ $variant->color->name }})</span>
                                            </div>
                                        </td>
                                        <td>{{ number_format($variant->price, 0, ',', '.') }} VND</td>
                                        <td>{{ number_format($variant->price_sale, 0, ',', '.') }} VND</td>
                                        <td>{{ $variant->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-icon-split">
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