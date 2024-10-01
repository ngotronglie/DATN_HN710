@extends('client.index')


@section('main')
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Wishlist</h1>
                    <ul>
                        <li>
                            <a href="/">Home </a>
                        </li>
                        <li class="active"> Wishlist</li>
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
                                    <th class="pro-thumbnail">Image</th>
                                    <th class="pro-title">Product</th>
                                    <th class="pro-price">Price</th>
                                    <th class="pro-stock">Stock Status</th>
                                    <th class="pro-cart">Add to Cart</th>
                                    <th class="pro-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pro-thumbnail"><a href="#"><img class="img-fluid"
                                                src="{{ asset('theme/client/assets/images/products/small-product/1.jpg') }}"
                                                alt="Product" /></a></td>
                                    <td class="pro-title"><a href="#">Brother Hoddies in Grey <br> s / green</a></td>
                                    <td class="pro-price"><span>$95.00</span></td>
                                    <td class="pro-stock"><span>In Stock</span></td>
                                    <td class="pro-cart"><a href="cart.html"
                                            class="btn btn-dark btn-hover-primary rounded-0">Add to Cart</a></td>
                                    <td class="pro-remove"><a href="#"><i class="pe-7s-trash"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="pro-thumbnail"><a href="#"><img class="img-fluid"
                                                src="{{ asset('theme/client/assets/images/products/small-product/2.jpg') }}"
                                                alt="Product" /></a></td>
                                    <td class="pro-title"><a href="#">Basic Jogging Shorts <br> Blue</a></td>
                                    <td class="pro-price"><span>$75.00</span></td>
                                    <td class="pro-stock"><span>In Stock</span></td>
                                    <td class="pro-cart"><a href="cart.html"
                                            class="btn btn-dark btn-hover-primary rounded-0">Add to Cart</a></td>
                                    <td class="pro-remove"><a href="#"><i class="pe-7s-trash"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="pro-thumbnail"><a href="#"><img class="img-fluid"
                                                src="{{ asset('theme/client/assets/images/products/small-product/10.jpg') }}"
                                                alt="Product" /></a></td>
                                    <td class="pro-title"><a href="#">Lust For Life <br> Bulk/S</a></td>
                                    <td class="pro-price"><span>$295.00</span></td>
                                    <td class="pro-stock"><span>In Stock</span></td>
                                    <td class="pro-cart"><a href="cart.html"
                                            class="btn btn-dark btn-hover-primary rounded-0">Add to Cart</a></td>
                                    <td class="pro-remove"><a href="#"><i class="pe-7s-trash"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="pro-thumbnail"><a href="#"><img class="img-fluid"
                                                src="{{ asset('theme/client/assets/images/products/small-product/4.jpg') }}"
                                                alt="Product" /></a></td>
                                    <td class="pro-title"><a href="#">Simple Woven Fabrics</a></td>
                                    <td class="pro-price"><span>$30.00</span></td>
                                    <td class="pro-stock"><span>In Stock</span></td>
                                    <td class="pro-cart"><a href="cart.html"
                                            class="btn btn-dark btn-hover-primary rounded-0">Add to Cart</a></td>
                                    <td class="pro-remove"><a href="#"><i class="pe-7s-trash"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
