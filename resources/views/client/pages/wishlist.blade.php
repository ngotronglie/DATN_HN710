@extends('client.index')

@section('style')
<style>
    .disabled-btn {
    pointer-events: none; /* Ngừng việc bấm vào nút */
    opacity: 0.5; /* Thêm độ mờ để biểu thị nút không thể thao tác */
}

</style>
@endsection
@section('main')
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Sản phẩm yêu thích</h1>
                    <ul>
                        <li>
                            <a href="/">Trang chủ </a>
                        </li>
                        <li class="active"> Sản phẩm yêu thích</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Wishlist Section Start -->
    <div class="section section-margin">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="wishlist-table table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="pro-thumbnail">Ảnh</th>
                                    <th class="pro-title">Sản phẩm</th>
                                    <th class="pro-price">Giá</th>
                                    <th class="pro-stock">Trạng thái</th>
                                    <th class="pro-cart">Thêm vào giỏ hàng</th>
                                    <th class="pro-remove">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($favoriteProducts))
                                    @foreach ($favoriteProducts as $item)
                                        <tr class="remove-favorite">
                                            <td class="pro-thumbnail"><a href="#"><img class="img-fluid"
                                                        style="width: 45%"
                                                        src="{{ Storage::url($item->img_thumb) }}"
                                                        alt="Product" /></a></td>
                                            <td class="pro-title"><a
                                                    href="{{ route('shops.show', $item->slug) }}">{{ $item->name }}</a></td>
                                            <td class="pro-price" style="color: red;font-weight: 500">
                                                {{ $item->min_price == $item->max_price
                                                    ? number_format($item->min_price, 0, ',', '.') . ' đ'
                                                    : number_format($item->min_price, 0, ',', '.') . 'đ' . ' - ' . number_format($item->max_price, 0, ',', '.') . 'đ' }}                                            </td>
                                            <td class="pro-stock">
                                                <span>{{ $item->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                            </td>
                                            <td class="pro-cart">
                                                <span class="btn btn-dark btn-hover-primary showProduct rounded-0 @if($item->quantity == 0) disabled-btn @endif"
                                                    data-id="{{$item->id}}"
                                                    data-slug="{{$item->slug}}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalCenter"
                                                    >Thêm vào giỏ hàng</span>
                                            </td>
                                            <td class="pro-remove"><span data-id="{{ $item->idFavorite }}"
                                                    class="deleteFavorite"><i class="pe-7s-trash"
                                                        style="font-size: 1.5rem;"></i></span></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td id="favoriteNull" colspan="6">
                                            <p>Mục yêu thích của bạn hiện  đang trống.</p>
                                        </td>
                                    </tr>
                                @endif
                                <tr id="favoriteNull">
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('plugins/js/deleteFavorite.js') }}"></script>
    <script src="{{ asset('plugins/js/viewDetailProductModal.js') }}"></script>
    <script src="{{ asset('plugins/js/addCartAddFavorite.js') }}"></script>
@endsection
