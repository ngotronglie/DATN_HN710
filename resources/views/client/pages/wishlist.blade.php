@extends('client.index')


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
                                                        src="{{ Storage::url($item->productVariant->product->img_thumb) }}"
                                                        alt="Product" /></a></td>
                                            <td class="pro-title"><a
                                                    href="{{ route('shops.show', $item->productVariant->product->slug) }}">{{ $item->productVariant->product->name }}
                                                    <br> {{ $item->productVariant->size->name }} /
                                                    {{ $item->productVariant->color->name }}</a></td>
                                            <td class="pro-price">
                                                <span>{{ number_format($item->productVariant->price_sale) }}</span>
                                            </td>
                                            <td class="pro-stock">
                                                <span>{{ $item->productVariant->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                            </td>
                                            <td class="pro-cart"><span id="addcart-{{$item->id}}"
                                                    class="btn btn-dark btn-hover-primary rounded-0"
                                                    data-idpro="{{$item->productVariant->id}}"
                                                    data-id="{{$item->id}}"
                                                    data-quantity="{{$item->productVariant->quantity}}"
                                                    >Thêm vào giỏ hàng</span>
                                            </td>
                                            <td class="pro-remove"><span data-id="{{ $item->id }}"
                                                    class="deleteFavorite"><i class="pe-7s-trash"
                                                        style="font-size: 1.5rem;"></i></span></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td id="favoriteNull" colspan="6">
                                            <p>Mục yêu thích của bạn hiện đang trống.</p>
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
    <script src="{{ asset('plugins/js/favorite.js') }}"></script>
@endsection
