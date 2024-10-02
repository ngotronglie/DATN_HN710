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
                            <li><a href="{{ route('admin.products.index') }}">Danh sách sản phẩm</a></li>
                            <li class="active">Thêm sản phẩm</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content mb-5">
    <div class="animated fadeIn">
        <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-8 col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <strong>Thông tin sản phẩm</strong>
                        </div>
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="name" class=" form-control-label">Tên sản phẩm</label>
                                <input type="text" id="name" name="name" placeholder="Nhập tên sản phẩm" class="form-control" value="{{ old('name') }}">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div style="display: flex; justify-content: space-between">
                                    <label for="description" class="form-control-label">Mô tả</label>
                                    <a href="#" class="mutiimg" data-target="description">Thêm nhiều ảnh</a>
                                </div>
                                <textarea name="description" class="ckedit form-control" id="description">{{ old('description') }}</textarea>
                                @error('description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-4 col-sm-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong class="card-title">Danh mục sản phẩm</strong>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-1"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_id" class=" form-control-label">Danh mục sản phẩm</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">--Vui lòng chọn--</option>
                                    @foreach($categories as $item)
                                    <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="img_thumb" class="form-control-label">Ảnh đại diện</label>
                                <!-- Khung chứa hình ảnh -->
                                <div style="width: 100%; height: auto;">
                                    <img id="img-preview"
                                        src="https://tse4.mm.bing.net/th?id=OIP.EkljFHN5km7kZIZpr96-JwAAAA&pid=Api&P=0&h=220"
                                        alt="Ảnh đại diện"
                                        class="img-thumbnail"
                                        style="width: 100%; height: auto; object-fit: cover; cursor: pointer;">
                                </div>
                                <!-- Input file ẩn -->
                                <input type="file" id="img_thumb" name="img_thumb" class="form-control d-none" accept="image/*">
                                @error('img_thumb')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thêm ảnh vào thư viện -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Thêm thư viện ảnh</strong>
                        </div>
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="product_galleries" class="form-control-label">Thêm nhiều ảnh</label>
                                <input type="file" name="product_galleries[]" class="form-control" id="product_galleries" multiple accept="image/*">
                                @error('product_galleries')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <!-- Hiển thị lỗi cho từng ảnh -->
                                @if ($errors->has('product_galleries.*'))
                                @foreach ($errors->get('product_galleries.*') as $key => $messages)
                                @foreach ($messages as $message)
                                <small class="text-danger">{{ $message }}</small><br>
                                @endforeach
                                @endforeach
                                @endif
                                <!-- Xem trước các ảnh được chọn -->
                                <div id="image-preview" class="row mt-3">
                                    <!-- Ảnh được chọn sẽ hiển thị tại đây -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thêm biến thể -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Thêm biến thể</strong>
                            <button type="button" id="add-variant" class="btn btn-primary">Thêm biến thể</button>
                        </div>
                        <div class="card-body">
                            <div id="variant-container">
                                <!-- Nếu có dữ liệu old (người dùng đã nhập và submit lỗi) -->
                                @if(old('variants'))
                                @foreach(old('variants', []) as $index => $variant)
                                <div class="form-row align-items-start mb-3" id="variant-{{ $index }}" data-index="{{ $index }}">
                                    <div class="form-group col-md">
                                        <label for="variants[{{ $index }}][size_id]" class="form-control-label">Kích thước</label>
                                        <select name="variants[{{ $index }}][size_id]" id="variants[{{ $index }}][size_id]" class="form-control">
                                            <option value="">--Chọn kích thước--</option>
                                            @foreach($sizes as $size)
                                            <option value="{{ $size->id }}" {{ $size->id == $variant['size_id'] ? 'selected' : '' }}>
                                                {{ $size->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error("variants.{$index}.size_id")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="variants[{{ $index }}][color_id]" class="form-control-label">Màu sắc</label>
                                        <select name="variants[{{ $index }}][color_id]" id="variants[{{ $index }}][color_id]" class="form-control">
                                            <option value="">--Chọn màu sắc--</option>
                                            @foreach($colors as $color)
                                            <option value="{{ $color->id }}" {{ $color->id == $variant['color_id'] ? 'selected' : '' }}>
                                                {{ $color->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error("variants.{$index}.color_id")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="variants[{{ $index }}][price]" class="form-control-label">Giá</label>
                                        <input type="number" name="variants[{{ $index }}][price]" id="variants[{{ $index }}][price]" class="form-control" value="{{ $variant['price'] }}" placeholder="Nhập giá sản phẩm">
                                        @error("variants.{$index}.price")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="variants[{{ $index }}][price_sale]" class="form-control-label">Giá khuyến mãi</label>
                                        <input type="number" name="variants[{{ $index }}][price_sale]" id="variants[{{ $index }}][price_sale]" class="form-control" value="{{ $variant['price_sale'] }}" placeholder="Nhập giá khuyến mãi">
                                        @error("variants.{$index}.price_sale")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="variants[{{ $index }}][quantity]" class="form-control-label">Số lượng</label>
                                        <input type="number" name="variants[{{ $index }}][quantity]" id="variants[{{ $index }}][quantity]" class="form-control" value="{{ $variant['quantity'] }}" placeholder="Nhập số lượng">
                                        @error("variants.{$index}.quantity")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-auto">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger remove-variant-btn w-100">Xóa</button>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <!-- Hiển thị mặc định nếu không có biến thể nào trước đó -->
                                <div class="form-row align-items-start mb-3" id="variant-0" data-index="0">
                                    <div class="form-group col-md">
                                        <label for="variants[0][size_id]" class="form-control-label">Kích thước</label>
                                        <select name="variants[0][size_id]" id="variants[0][size_id]" class="form-control">
                                            <option value="">--Chọn kích thước--</option>
                                            @foreach($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="variants[0][color_id]" class="form-control-label">Màu sắc</label>
                                        <select name="variants[0][color_id]" id="variants[0][color_id]" class="form-control">
                                            <option value="">--Chọn màu sắc--</option>
                                            @foreach($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="variants[0][price]" class="form-control-label">Giá</label>
                                        <input type="number" name="variants[0][price]" id="variants[0][price]" class="form-control" placeholder="Nhập giá sản phẩm">
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="variants[0][price_sale]" class="form-control-label">Giá khuyến mãi</label>
                                        <input type="number" name="variants[0][price_sale]" id="variants[0][price_sale]" class="form-control" placeholder="Nhập giá khuyến mãi">
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="variants[0][quantity]" class="form-control-label">Số lượng</label>
                                        <input type="number" name="variants[0][quantity]" id="variants[0][quantity]" class="form-control" placeholder="Nhập số lượng">
                                    </div>
                                    <div class="form-group col-md-auto">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger remove-variant-btn w-100">Xóa</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-success mb-1">Thêm mới</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/plugin/ckfinder_2/ckfinder.js') }}"></script>
<script src="{{ asset('plugins/plugin/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('plugins/js/finder.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        //Thêm biến thể
        jQuery('#add-variant').on('click', function() {
            var currentRows = jQuery('#variant-container .form-row');
            var newIndex = 0;

            // Tìm chỉ số mới không trùng từ thuộc tính data-index
            if (currentRows.length > 0) {
                var existingIndexes = currentRows.map(function() {
                    return parseInt(jQuery(this).attr('data-index'));
                }).get();
                newIndex = Math.max.apply(Math, existingIndexes) + 1;
            }

            var newVariantRow = jQuery('.form-row:first').clone(); // Sao chép hàng đầu tiên

            // Xóa giá trị của các input và select
            newVariantRow.find('input, select').val('');

            // Xóa thông báo lỗi nếu có
            newVariantRow.find('small.text-danger').remove();

            // Cập nhật data-index và id cho variant row
            newVariantRow.attr('data-index', newIndex);
            newVariantRow.attr('id', 'variant-' + newIndex); // Cập nhật id cho div variant

            // Cập nhật các input, select với chỉ số mới từ data-index
            newVariantRow.find('label[for]').each(function() {
                var oldFor = jQuery(this).attr('for');
                var newFor = oldFor.replace(/\[\d+\]/, '[' + newIndex + ']');
                jQuery(this).attr('for', newFor);
            });

            newVariantRow.find('input, select').each(function() {
                var oldName = jQuery(this).attr('name');
                var newName = oldName.replace(/\[\d+\]/, '[' + newIndex + ']');
                var oldId = jQuery(this).attr('id');
                var newId = oldId.replace(/\[\d+\]/, '[' + newIndex + ']');

                jQuery(this).attr({
                    'name': newName,
                    'id': newId
                });
            });

            jQuery('#variant-container').append(newVariantRow); // Thêm hàng mới vào container
        });

        // Xóa biến thể
        jQuery(document).on('click', '.remove-variant-btn', function() {
            if (jQuery('.form-row').length > 1) {
                jQuery(this).closest('.form-row').remove(); // Xóa hàng hiện tại
            } else {
                alert('Bạn cần ít nhất một biến thể');
            }
        });


        // Abum ảnh
        jQuery('#product_galleries').on('change', function() {
            var files = this.files;
            var previewContainer = jQuery('#image-preview');
            previewContainer.html('');

            if (files) {
                jQuery.each(files, function(index, file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imageCol = jQuery('<div class="col-md-2 mb-3"></div>');
                        var imageElement = jQuery('<img class="img-thumbnail" style="width:100%;">');
                        imageElement.attr('src', e.target.result);
                        imageCol.append(imageElement);
                        previewContainer.append(imageCol);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });

        // Ảnh đại diện
        jQuery('#img-preview').on('click', function() {
            jQuery('#img_thumb').click();
        });

        // Hiển thị hình ảnh đã chọn
        jQuery('#img_thumb').on('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    jQuery('#img-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

    });
</script>
@endsection