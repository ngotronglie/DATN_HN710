(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');


    let selectedVariantId = null;
    let idProAddCart = null;
    let idcart = null;


    HT.selectColor = (label) => {
        idProAddCart = null;
        selectedVariantId = null;

        $('.color-btn').removeClass('active');
        $('.size-btn').removeClass('active');

        $(label).addClass('active');
        let _this = $(label);
        let idProduct = _this.attr('data-productId');
        let idColor = _this.attr('data-id');
        $('.old-price-' + idProduct).empty();
        $('.size-buttons').empty();

        HT.getSizePrice(idProduct, idColor);
    };

    HT.h = (label) => {
        $('.size-btn').removeClass('active');
        $(label).addClass('active');

        let id = $(label).attr('data-id');
        let idpro = $(label).attr('data-idpro');

        selectedVariantId = id;
        idProAddCart = idpro;

    };


    HT.getSizePrice = (idProduct, idColor) => {
        $.ajax({
            type: 'get',
            url: '/shop/ajax/getSizePrice',
            data: {
                'idColor': idColor,
                'idProduct': idProduct
            },
            dataType: 'json',
            success: function (res) {
                if (res) {
                    $('#sizes-prices-' + idProduct).empty();

                    let minPrice = res.min_price;
                    let maxPrice = res.max_price;
                    let formattedMinPrice = Math.floor(minPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + 'đ';
                    let formattedMaxPrice = Math.floor(maxPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + 'đ';

                    if (minPrice == maxPrice) {
                        $('#product-price-sale-' + idProduct).text(`${formattedMaxPrice}`);
                    } else {
                        $('#product-price-sale-' + idProduct).text(`${formattedMinPrice} - ${formattedMaxPrice}`);
                    }

                    res.variants.forEach(function (variant) {
                        $('#sizes-prices-' + idProduct).append(
                            '<li><label class="size-btn" data-id="' + variant.id + '" data-quantity="' + variant.quantity + '" data-idpro="' + variant.product_id + '" data-price="' + variant.price_sale + '" onclick="HT.h(this)">' +
                            variant.size + '</label></li>'
                        );
                    });

                    priceMySize(res, idProduct);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    };

    function priceMySize(res, idProduct) {
        $('.size-btn').off('click').on('click', function () {
            let selectedSize = $(this).text();
            let selectedVariant = res.variants.find(function (variant) {
                return variant.size === selectedSize;
            });

            if (selectedVariant) {
                let sizePriceSale = selectedVariant.price_sale && !isNaN(selectedVariant.price_sale)
                    ? parseFloat(selectedVariant.price_sale) : 0;

                let sizePrice = selectedVariant.price && !isNaN(selectedVariant.price)
                    ? parseFloat(selectedVariant.price) : 0;

                let formattedPriceSale = sizePriceSale.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                let formattedPrice = sizePrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                $('#product-price-sale-' + idProduct).text(formattedPriceSale + 'đ');
                $('.old-price-' + idProduct).text(formattedPrice + 'đ');


            }
        });
    }

    HT.addCart = () => {
        $('.btn-hover-primary').each(function () {
            let btn = $(this);
            let id = btn.attr('data-id');
            $('#addcart-' + id).click(function () {
                let quantityCart = $('.size-btn').attr('data-quantity');

                if (selectedVariantId) {
                    if (id == idProAddCart) {

                        let quantity = 1;

                        let option = {
                            'product_variant_id': selectedVariantId,
                            'quantity': quantity,
                            'quantityProduct': quantityCart,
                            '_token': token
                        }

                        $.ajax({
                            type: 'POST',
                            url: '/ajax/addToCart',
                            data: option,
                            dataType: 'json',
                            success: function (res) {
                                swal({
                                    content: {
                                        element: "span",
                                        attributes: {
                                            innerHTML: "<h1 style='font-size: 1.3rem;'>Đã thêm sản phẩm vào giỏ hàng!</h1>",
                                        },
                                    },
                                    text: "",
                                    icon: "success",
                                    button: "Đóng",
                                });
                                $('.header-action-num').html(res.uniqueVariantCount);

                                const cartContent = $('.offcanvas-cart-content');
                                cartContent.empty();

                                if (res.cartItems.length > 0) {
                                    console.log(res);
                                    const productHtml = `
                                        <h2 class="offcanvas-cart-title mb-6">Giỏ hàng</h2>` +
                                        res.cartItems.map(item => `
                                            <div id="cart-header-${item.id}" class="cart-product-wrapper mb-2">
                                                <div class="single-cart-product">
                                                    <div class="cart-product-thumb">
                                                        <a href="single-product.html">
                                                            <img src="/storage/${item.img_thumb}" alt="Cart Product">
                                                        </a>
                                                    </div>
                                                    <div class="cart-product-content">
                                                        <h3 class="title">
                                                            <a href="/shops/${item.slug}">${item.productVariant.product.name}
                                                                <br> ${item.size_name} / ${item.color_name}
                                                            </a>
                                                        </h3>
                                                        <span class="price">
                                                            <span class="new">${new Intl.NumberFormat('vi-VN').format(item.price_sale)} đ</span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="cart-product-remove">
                                                    <span class="deleteCart" data-id="${item.id}">
                                                        <i class="fa fa-trash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        `).join('') + `
                                        <div class="cartNull" style="text-align: center"></div>

                                        <div class="cart-product-btn mt-4">
                                            <a href="/cart" class="btn btn-dark btn-hover-primary rounded-0 w-100">Giỏ hàng</a>
                                            <a href="/checkout" class="btn btn-dark btn-hover-primary rounded-0 w-100 mt-4">Thanh toán</a>
                                        </div>`;

                                    cartContent.html(productHtml);
                                } else {
                                    cartContent.html('<p>Giỏ hàng của bạn hiện đang trống.</p>');
                                }

                                $('.deleteCart').click(function () {

                                    let id = $(this).attr('data-id');
                                    console.log(id);
                                    idcart = id;
                                    console.log(idcart);

                                    let option = {
                                        'id': id,
                                        '_token': token
                                    }
                                    $.ajax({
                                        type: 'DELETE',
                                        url: '/ajax/deleteToCartHeader',
                                        data: option,
                                        dataType: 'json',
                                        success: function (res) {
                                            if (res.cartItems && res.cartItems.length > 0) {
                                                $('.header-action-num').html(res.uniqueVariantCount);
                                                $('#cart-header-' + idcart).remove();
                                            } else {
                                                $('.header-action-num').html(res.uniqueVariantCount);
                                                $('.cart-product-wrapper').empty();
                                                $('.cartNull').append('<p >Giỏ hàng của bạn hiện đang trống.</p>');
                                            }
                                            swal({
                                                content: {
                                                    element: "span",
                                                    attributes: {
                                                        innerHTML: "<h1 style='font-size: 1.3rem;'>Đã xóa sản phẩm khỏi giỏ hàng!</h1>",
                                                    },
                                                },
                                                text: "",
                                                icon: "success",
                                                button: "Đóng",
                                            });

                                        },
                                        error: function (xhr, status, error) {
                                            console.log(error);
                                        }
                                    });

                                })


                            },
                            error: function (xhr, status, error) {
                                swal({
                                    content: {
                                        element: "span",
                                        attributes: {
                                            innerHTML: "<h1 style='font-size: 1.3rem;'>Số lượng sản phẩm trong giỏ hàng vượt quá giới hạn cho phép!</h1>",
                                        },
                                    },
                                    text: "",
                                    icon: "error",
                                    button: "Đóng",
                                });
                            }
                        });
                    } else {
                        swal({
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng thêm đúng sản phẩm đã chọn!</h1>",
                                },
                            },
                            text: "",
                            icon: "error",
                            button: "Đóng",
                        });
                        // $('.color-btn').removeClass('active');
                        // $('.size-buttons').empty();
                    }
                } else {
                    swal({
                        content: {
                            element: "span",
                            attributes: {
                                innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng chọn biến thể trước khi thêm vào giỏ hàng!</h1>",
                            },
                        },
                        text: "",
                        icon: "error",
                        button: "Đóng",
                    });
                }
            });


        });
    };


    window.HT = HT;

    $(document).ready(function () {
        HT.selectColor();
        HT.addCart();
    });
})(jQuery);
