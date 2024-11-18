<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>
<!-- Scroll Top End -->

<!-- Modal Start -->
<div class="modalquickview modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button class="btn close" data-bs-dismiss="modal">×</button>
            <div class="row">
                <!-- Left Side (Product Carousel) -->
                <div class="col-md-6 col-12">
                    <div class="modal-product-carousel">
                        <div class="swiper-container swiper-myModal">
                            <div class="swiper-wrapper" id="alumProduct">
                                <!-- Các ảnh sẽ được thêm vào đây -->
                            </div>
                            <div class="swiper-button-next next_product swiper-product-button-next"><i class="pe-7s-angle-right"></i></div>
                            <div class="swiper-button-prev prev_product swiper-product-button-prev"><i class="pe-7s-angle-left"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Right Side (Product Summery) -->
                <div class="col-md-6 col-12">
                    <div class="product-summery position-relative" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-head mb-3">
                            <h2 class="product-title" id="name-prd"></h2>
                        </div>
                        <div class="price-box mb-2">
                            <span id="product-price-sale-modal" class="show-price" style="color: #dc3545;font-size: 1.4rem;font-weight: 700;"></span>
                            <span id="old-price-modal" style="text-decoration: line-through;font-size: 1.0rem;font-weight: 500"></span>
                        </div>

                        <div class="sku mb-3">
                            <span class="quantity_prd_modal" id="quantity_prd_modal"></span>
                        </div>

                        <div class="sku mb-3">
                            <span id="view_prd"></span>
                        </div>

                        <div class="color-options">
                            <ul class="color-buttons" id="color_prd">
                            </ul>
                        </div>

                        <div class="product">
                            <div class="product-options">
                                <div class="size-options">
                                    <ul id="sizes-prices" class="size-buttons">
                                    </ul>
                                </div>

                                <div class="quantity mb-5">
                                    <div class="cart-plus-minus">
                                        <input class="quatity_add_cart cart-plus-minus-box" value="1" type="text" min="1">
                                        <div class="dec qtybutton"></div>
                                        <div class="inc qtybutton"></div>
                                    </div>
                                </div>

                                <div class="cart-wishlist-btn mb-4">
                                    <div class="add-to_cart">
                                        <button class="btn btn-outline-dark btn-hover-primary">
                                            Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                    <div class="add-to-wishlist">
                                        <button class="btn btn-outline-dark btn-hover-primary favoritePro addFavorite">
                                            Thêm vào sản phẩm yêu thích
                                        </button>
                                    </div>
                                </div>



                                <!-- Product Delivery Policy Start -->
                                <ul class="product-delivery-policy border-top pt-4 mt-4 border-bottom pb-4">
                                    <li><i class="fa fa-check-square"></i><span>Chính sách bảo mật - Bảo vệ thông tin khách
                                            hàng</span></li>
                                    <li><i class="fa fa-truck"></i><span>Chính sách giao hàng - Nhanh chóng, tiện lợi</span>
                                    </li>
                                    <li><i class="fa fa-refresh"></i><span>Chính sách đổi trả - Đảm bảo quyền lợi khách
                                            hàng</span></li>
                                    <li><i class="fa fa-credit-card"></i><span>Chính sách thanh toán - Linh hoạt, an
                                            toàn</span></li>
                                    <li><i class="fa fa-headphones"></i><span>Hỗ trợ khách hàng - Tư vấn 24/7</span></li>
                                </ul>


                                <!-- Product Delivery Policy End -->

                            </div>
                            <!-- Product Summery End -->

                        </div>
                        <!-- Product Delivery Policy End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->
