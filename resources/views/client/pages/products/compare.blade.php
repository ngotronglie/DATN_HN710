@extends('client.index')

@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">So sánh</h1>
                    <ul>
                        <li>
                            <a href="/">Trang chủ </a>
                        </li>
                        <li class="active"> So sánh</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Start -->
    <div class="section section-margin">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Compare Page Content Start -->
                    <div class="compare-page-content-wrap">
                        <div class="compare-table table-responsive">
                            <!-- Compare Table Start -->
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr  style="text-align: center">
                                        <th>Ảnh</th>
                                        <th>Sản phẩm</th>
                                        <th>kích cỡ, Màu</th>
                                        <th>Giá</th>
                                        <th>Thêm vào giỏ hàng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product as $item)
                                    <tr>
                                        <td style="width: 23%">
                                            <a href="{{ route('shops.show', $item->slug) }}">
                                                <img
                                                    class="img-fluid"
                                                    src="{{ Storage::url($item->img_thumb) }}"
                                                    alt="Product"
                                                    style="width: 100%; height: auto; object-fit: cover;" />
                                            </a>
                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            Kích cỡ:
                                            {{ implode(', ', $item->variants->pluck('size.name')->unique()->toArray()) }}
                                            <br>
                                            Màu:
                                            {{ implode(', ', $item->variants->pluck('color.name')->unique()->toArray()) }}
                                        </td>

                                        <td class="pro-price">
                                            <span class="price">
                                                <span
                                                    class="new">{{ $item->min_price_sale == $item->max_price_sale
                                                        ? number_format($item->min_price_sale, 0, ',', '.') . ' đ'
                                                        : number_format($item->min_price_sale, 0, ',', '.') . 'đ - ' . number_format($item->max_price_sale, 0, ',', '.') . ' đ' }}
                                                    </span>
                                            </span>
                                        </td>
                                        <td class="pro-cart">
                                            <span class="btn btn-dark btn-hover-primary showProduct rounded-0 @if($item->quantity == 0) disabled-btn @endif"
                                                data-id="{{$item->id}}"
                                                data-slug="{{$item->slug}}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#exampleModalCenter"
                                                >Thêm vào giỏ hàng</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/js/viewDetailProductModal.js') }}"></script>
    <script src="{{ asset('plugins/js/addCartAddFavorite.js') }}"></script>
@endsection
