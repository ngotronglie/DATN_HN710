(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    let selectedVariantId = null;
    let idcart = null;

    $(document).ready(function() {
        const firstColorButton = $('.color-buttons .color-btn.selected');
        if (firstColorButton.length) {
            firstColorButton.trigger('click');
        }
    });

    $(document).ready(function() {
        $('.show-more').on('click', function() {
            $('#shortDescription').hide();
            $('#fullDescription').show();
        });

        $('.show-less').on('click', function() {
            $('#fullDescription').hide();
            $('#shortDescription').show();
        });
    });

    HT.selectColor = (label) => {
        //$('.quantity-product').empty();
        $('.color-btn').removeClass('active');
        $(label).addClass('active');

        let input = $('.cart-plus-minus-box');
        input.val(1);
        input.data('previousQuantity', 1);

        let _this = $(label);
        let idProduct = _this.attr('data-productId');
        let idColor = _this.attr('data-id');

        HT.getSizePrice(idProduct, idColor);
    };

    HT.getSize = (label) => {
        $('.size-btn').removeClass('active');
        $(label).addClass('active');
    };

    HT.getSizePrice = (idProduct, idColor) => {
        $.ajax({
            type: 'get',
            url: '/shop/ajax/getSizePriceDetail',
            data: {
                'idColor': idColor,
                'idProduct': idProduct
            },
            dataType: 'json',
            success: function (res) {
                if (res) {

                    let minPrice = res.min_price;
                    let maxPrice = res.max_price;

                    let formattedMinPrice = Math.floor(minPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    let formattedMaxPrice = Math.floor(maxPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + 'đ';

                    if (minPrice == maxPrice) {
                        $('#product-price-sale-' + idProduct).text(`${formattedMaxPrice}`);
                    } else {
                        $('#product-price-sale-' + idProduct).text(`${formattedMinPrice} - ${formattedMaxPrice}`);
                    }

                    $('#sizes-prices-' + idProduct).empty();

                    res.variants.forEach(function (variant, index) {
                        $('#sizes-prices-' + idProduct).append(
                            '<li>' +
                                '<label class="size-btn ' + (index === 0 ? 'selected' : '') + '" ' +
                                'data-quantity="' + variant.quantity + '" ' +
                                'data-price="' + variant.price_sale + '" ' +
                                'onclick="HT.getSize(this, \'' + variant.size + '\', ' + idProduct + ')">' +
                                variant.size +
                                '</label>' +
                            '</li>'
                        );
                    });

                    $(document).ready(function() {
                        const firstColorButton = $('.size-btn.selected');
                        if (firstColorButton.length) {
                            firstColorButton.trigger('click');
                        }
                    });

                    $('.size-btn').off('click').on('click', function () {
                        let selectedSize = $(this).text();
                        let selectedVariant = res.variants.find(function (variant) {
                            return variant.size === selectedSize;
                        });

                        if (selectedVariant) {
                            selectedVariantId = selectedVariant.id;
                            let sizePriceSale = selectedVariant.price_sale && !isNaN(selectedVariant.price_sale)
                                ? parseFloat(selectedVariant.price_sale) : 0;

                                let sizePrice = selectedVariant.price && !isNaN(selectedVariant.price)
                                ? parseFloat(selectedVariant.price) : 0;

                            let formattedPriceSale = sizePriceSale.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            let formattedPrice = sizePrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                            $('#product-price-sale-' + idProduct).text(formattedPriceSale + 'đ');

                            $('#old-price').text(formattedPrice + 'đ');

                            // Hiển thị số lượng của kích thước đã chọn
                            let quantity = selectedVariant.quantity; // Lấy số lượng từ biến thể đã chọn
                            $('#quantity-display-' + idProduct).text('Số lượng: ' + quantity); // Hiển thị số lượng
                            let input = $(this).closest('.product').find('input.cart-plus-minus-box');
                            input.val(1);
                            input.data('previousQuantity', 1);

                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    };



    HT.updatePriceWithQuantity = () => {
        $(document).on('click', '.qtybutton', function () {
            let $this = $(this);
            let input = $this.siblings('input.cart-plus-minus-box');

            let previousQuantity = parseInt(input.data('previousQuantity')) || 1;

            let selectedVariant = input.closest('.product').find('.size-btn.active');
            let selectedColor = input.closest('.product-summery.position-relative').find('.color-btn.colorGetSize.active');

            if (!selectedColor.length) {
                swal({
                    content: {
                        element: "span",
                        attributes: {
                            innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng chọn Màu!</h1>",
                        },
                    },
                    text: "",
                    icon: "error",
                    button: "Đóng",
                });
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            if (!selectedVariant.length) {
                swal({
                    content: {
                        element: "span",
                        attributes: {
                            innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng chọn Size!</h1>",
                        },
                    },
                    text: "",
                    icon: "error",
                    button: "Đóng",
                });
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));


            function validateInput(value) {
                if (!/^\d*$/.test(value)) {
                    swal({
                        content: {
                            element: "span",
                            attributes: {
                                innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng chỉ nhập số.!</h1>",
                            },
                        },
                        text: "",
                        icon: "error",
                        button: "Đóng",
                    });
                    return false;
                } else if (value == 0) {
                    swal({
                        content: {
                            element: "span",
                            attributes: {
                                innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng nhập số lượng nhiều hơn 0.!</h1>",
                            },
                        },
                        text:"",
                        icon: "error",
                        button: "Đóng",
                    });
                    return false;
                } else if (value > quantityProduct) {
                    swal({
                        content: {
                            element: "span",
                            attributes: {
                                innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng nhập số lượng ít hơn số lượng sản phẩm!</h1>",
                            },
                        },
                        text: "",
                        icon: "error",
                        button: "Đóng",
                    });
                    return false;
                }
                return true;
            }

            let quantity;

            if ($this.hasClass('inc')) {
                quantity = previousQuantity + 1;
            } else if ($this.hasClass('dec')) {
                quantity = previousQuantity > 1 ? previousQuantity - 1 : previousQuantity;
            }

            if (!validateInput(quantity)) {
                input.val(previousQuantity);
                return;
            }

            input.val(quantity);
            input.data('previousQuantity', quantity);

        });


        $(document).on('keypress', 'input.cart-plus-minus-box', function (e) {
            let input = $(this);
            let inputValue = input.val();
            let previousQuantity = parseInt(input.data('previousQuantity')) || 1;
            let selectedVariant = input.closest('.product').find('.size-btn.active');
            let selectedColor = input.closest('.product-summery.position-relative').find('.color-btn.colorGetSize.active');

            if (!selectedColor.length) {
                swal({
                    content: {
                        element: "span",
                        attributes: {
                            innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng chọn Màu!</h1>",
                        },
                    },
                    text: "",
                    icon: "error",
                    button: "Đóng",
                });
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            if (!selectedVariant.length) {
                swal({
                    content: {
                        element: "span",
                        attributes: {
                            innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng chọn Size!</h1>",
                        },
                    },
                    text: "",
                    icon: "error",
                    button: "Đóng",
                });
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));


            if (e.which === 13) {
                function validateInput(value) {
                    if (!/^\d*$/.test(value)) {
                        swal({
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng chỉ nhập số!</h1>",
                                },
                            },
                            text: "",
                            icon: "error",
                            button: "Đóng",
                        });
                        return false;
                    } else if (value == 0) {
                        swal({
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng nhập số lượng nhiều hơn 0!</h1>",
                                },
                            },
                            text: "",
                            icon: "error",
                            button: "Đóng",
                        });
                        return false;
                    } else if (value > quantityProduct) {
                        swal({
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "<h1 style='font-size: 1.3rem;'>Vui lòng nhập số lượng ít hơn số lượng sản phẩm!</h1>",
                                },
                            },
                            text: "",
                            icon: "error",
                            button: "Đóng",
                        });
                        return false;
                    }
                    return true;
                }

                if (!validateInput(inputValue)) {
                    input.val(previousQuantity);
                    return;
                }

                e.preventDefault();
                let quantity = parseInt(input.val()) || 1;
                input.data('previousQuantity', quantity);
            }
        });
    };

    HT.addToCart = () =>{
        $('.add-to_cart').click(function(){
            let input = $('.qtybutton').siblings('input.cart-plus-minus-box');
            let selectedVariant = input.closest('.product').find('.size-btn.active');

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));


            console.log(selectedVariantId);
            let quantity = input.val();

            let option = {
                'product_variant_id': selectedVariantId,
                'quantity': quantity,
                'quantityProduct' : quantityProduct,
                '_token': token
            }
            console.log(option);


            $.ajax({
                type: 'POST',
                url: '/ajax/addToCart',
                data: option,
                dataType: 'json',
                success: function (res) {
                    console.log(res);

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
                    console.log(error);

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


        })
    }

    window.HT = HT;

    $(document).ready(function () {
        HT.getSizePrice();
        HT.updatePriceWithQuantity();
        HT.addToCart();
    });
})(jQuery);

