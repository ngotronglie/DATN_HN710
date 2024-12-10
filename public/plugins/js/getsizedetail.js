(function ($) {
    "use strict";
    var HT = {};
    let selectedVariantId = null;
    var token = $('meta[name="csrf-token"]').attr('content');
    let mes = '';
    let idcart = null;

    HT.showProductView = () => {
        $(document).on('click', '.showProduct[data-slug]', function () {
            $('#sizes-prices').empty();
            let slug = $(this).attr('data-slug');
            let id = $(this).attr('data-id');

            $.ajax({
                url: '/ajax/shops/' + slug,
                method: 'GET',
                success: function (res) {

                    let idProduct = res.id;
                    let http = 'http://datn_hn710.test/';
                    let imageUrls = [];
                    let minPrice = res.min_price_sale;
                    let maxPrice = res.max_price_sale;
                    let swiper;

                    $('.favoritePro').attr('data-slug', res.slug);
                    $('.favoritePro').attr('data-id', res.id);

                    $('.album_img').empty();
                    $('#alumProduct').empty();

                    if (res.galleries.length === 1) {
                        $('.next_product').empty();
                        $('.prev_product').empty();
                    }
                    res.galleries.forEach(function (gallery) {
                        let imageUrlAlbum = http + "storage/" + gallery;
                        imageUrls.push(imageUrlAlbum);

                        $('#alumProduct').append(
                            '<a class="swiper-slide" href="' + imageUrlAlbum + '">' +
                            '<img class="w-100" src="' + imageUrlAlbum + '" alt="Product">' +
                            '</a>'
                        );
                    });

                    swiper = new Swiper('.swiper-myModal', {
                        loop: true,
                        navigation: {
                            nextEl: '.next_product',
                            prevEl: '.prev_product',
                        },
                    });

                    $('#name-prd').text(res.name);

                    $('#color_prd').empty();
                    const uniqueColors = new Set();

                    res.variants.forEach(function (variant, index) {
                        let colorName = variant.color.hex_code;

                        if (!uniqueColors.has(colorName)) {
                            uniqueColors.add(colorName);

                            $('#color_prd').append(
                                '<li>' +
                                '<label id="color-btn" class="color-btn_click color-btn colorGetSize ' + (index === 0 ? 'selectedActive' : '') + '" ' +
                                'data-id="' + variant.color.id + '" ' +
                                'title="' + variant.color.name + '"'+
                                'data-productId="' + idProduct + '" ' +
                                'data-max="' + maxPrice + '" ' +
                                'data-min="' + minPrice + '" ' +
                                'style="background-color:' + colorName + ';" ' +
                                'onclick="HT.handleColorSelection(this)">' +
                                '</label>' +
                                '</li>'
                            );
                        }
                    });

                    $('#color-btn').first().click();


                    $('#view_prd').text('Lượt xem: ' + res.view);
                },
                error: function (error) {
                    let hasShownErrorMessage = false;
                    $(document).ajaxError(function (event, xhr) {
                        if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMessages = xhr.responseJSON.errors;
                            for (let key in errorMessages) {
                                if (errorMessages.hasOwnProperty(key)) {
                                    swalError(errorMessages[key][0]);
                                }
                            }
                            hasShownErrorMessage = true;
                        }
                    });
                }
            });
        });
    };

    HT.handleColorSelection = (label) => {
        $('.color-btn_click').removeClass('active');
        $('.color-btn_click').removeClass('selectedModal');
        $('.color-btn_click').removeClass('select');

        $(label).addClass('active');

        let input = $('.cart-plus-minus-box');
        input.val(1);

        let _this = $(label);
        let idProduct = _this.attr('data-productId');
        let idColor = _this.attr('data-id');

        HT.fetchSizeAndPrice(idProduct, idColor);
    };

    HT.handleSizeSelection = (label) => {

        $('.remove_at').removeClass('active');
        $('.remove_at').removeClass('disabled');

        $(label).addClass('active');
        let quantity = $(label).attr('data-quantity');
        if (quantity == 0) {
            let button = $(label);
            button.addClass('disabled');
        }

    };

    HT.fetchSizeAndPrice = (idProduct, idColor) => {
        $.ajax({
            type: 'get',
            url: '/shop/ajax/getSizePriceDetail2',
            data: {
                'idColor': idColor,
                'idProduct': idProduct
            },
            dataType: 'json',
            success: function (res) {
                $('#sizes-prices').empty();

                res.variants.forEach(function (variant, index) {
                    $('#sizes-prices').append(
                        '<li>' +
                        '<label class="remove_at size-btn ' + (index === 0 ? 'selectedModal' : '') + '" ' +
                        'data-quantity="' + variant.quantity + '" ' +
                        'data-id="' + variant.id + '" ' +
                        'data-price="' + variant.price_sale + '" ' +
                        'onclick="HT.handleSizeSelection(this)">' +
                        variant.size +
                        '</label>' +
                        '</li>'
                    );
                });

                $(document).ready(function () {
                    const firstColorButton = $('.size-btn.selectedModal');
                    if (firstColorButton.length) {
                        firstColorButton.trigger('click');
                    }
                });

                $('.size-btn').click(function () {
                    let selectedSize = $(this).text();
                    let selectedVariant = res.variants.find(function (variant) {
                        return variant.size === selectedSize;
                    });

                    if (selectedVariant) {

                        $('.quantity_prd_modal').empty();

                        selectedVariantId = selectedVariant.id;

                        let sizePriceSale = selectedVariant.price_sale && !isNaN(selectedVariant.price_sale)
                            ? parseFloat(selectedVariant.price_sale) : 0;

                        let sizePrice = selectedVariant.price && !isNaN(selectedVariant.price)
                            ? parseFloat(selectedVariant.price) : 0;

                        let formattedPriceSale = sizePriceSale.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        let formattedPrice = sizePrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                        $('#product-price-sale-modal').text(formattedPriceSale + ' đ');

                        $('#old-price-modal').text(formattedPrice + ' đ');

                        let quantity = selectedVariant.quantity;
                        $('.quantity_prd_modal').text('Số lượng: ' + quantity);
                        let input = $(this).closest('.product').find('input.cart-plus-minus-box');
                        input.val(1);
                    }
                });
            },
            error: function (xhr, status, error) {
                let hasShownErrorMessage = false;
                $(document).ajaxError(function (event, xhr) {
                    if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorMessages = xhr.responseJSON.errors;
                        for (let key in errorMessages) {
                            if (errorMessages.hasOwnProperty(key)) {
                                swalError(errorMessages[key][0]);
                            }
                        }
                        hasShownErrorMessage = true;
                    }
                });
            }
        });
    };

    $(document).ready(function () {
        $('.colorGetSize').first().click();
    });


    $(document).ready(function () {
        $('.show-more').on('click', function () {
            $('#shortDescription').hide();
            $('#fullDescription').show();
        });

        $('.show-less').on('click', function () {
            $('#fullDescription').hide();
            $('#shortDescription').show();
        });
    });

    HT.selectColor = (label) => {
        $('.color-btn').removeClass('active');
        $(label).addClass('active');

        let input = $('.cart-plus-minus-box');
        input.val(1);

        let _this = $(label);
        let idProduct = _this.attr('data-productId');
        let idColor = _this.attr('data-id');

        HT.getSizePrice(idProduct, idColor);
    };

    HT.getSize = (label) => {

        $('.size_detail').removeClass('active');
        $('.size_detail').removeClass('disabled');

        $(label).addClass('active');
        let quantity = $(label).attr('data-quantity');
        if (quantity == 0) {
            let button = $(label);
            button.addClass('disabled');
        }

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

                    $('#sizes-prices-' + idProduct).empty();

                    res.variants.forEach(function (variant, index) {
                        $('#sizes-prices-' + idProduct).append(
                            '<li>' +
                            '<label class="size_detail size-btn ' + (index === 0 ? 'selected' : '') + '" ' +
                            'data-quantity="' + variant.quantity + '" ' +
                            'title="' + variant.color.name + '"'+
                            'data-id="' + variant.id + '" ' +
                            'data-price="' + variant.price_sale + '" ' +
                            'onclick="HT.getSize(this, \'' + variant.size + '\', ' + idProduct + ')">' +
                            variant.size +
                            '</label>' +
                            '</li>'
                        );
                    });

                    $(document).ready(function () {
                        const firstColorButton = $('.size-btn.selected');
                        if (firstColorButton.length) {
                            firstColorButton.trigger('click');
                        }
                    });

                    $('.size-btn').on('click', function () {
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

                            let quantity = selectedVariant.quantity;
                            $('#quantity-display-' + idProduct).text('Số lượng: ' + quantity);
                            let input = $(this).closest('.product').find('input.cart-plus-minus-box');
                            input.val(1);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                let hasShownErrorMessage = false;
                $(document).ajaxError(function (event, xhr) {
                    if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorMessages = xhr.responseJSON.errors;
                        for (let key in errorMessages) {
                            if (errorMessages.hasOwnProperty(key)) {
                                swalError(errorMessages[key][0]);
                            }
                        }
                        hasShownErrorMessage = true;
                    }
                });
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
                mes = "Vui lòng chọn màu";
                swalError(mes);
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            if (!selectedVariant.length) {
                mes = 'Vui lòng chọn size';
                swalError(mes);
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));


            function validateInput(value) {
                if (!/^\d*$/.test(value)) {
                    mes = "Vui lòng chỉ nhập số";
                    swalError(mes);
                    return false;
                } else if (value == 0) {
                    mes = "Số lượng phải lớn hơn hoặc bằng 1";
                    swalError(mes);
                    return false;
                } else if (value > quantityProduct) {
                    mes = "Số lượng phải nhỏ hơn số lượng có sẵn";
                    swalError(mes)
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
                mes = "Vui lòng chọn màu";
                swalError(mes);
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            if (!selectedVariant.length) {
                mes = 'Vui lòng chọn size';
                swalError(mes);
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));

            if (e.which === 13) {
                function validateInput(value) {
                    if (!/^\d*$/.test(value)) {
                        mes = "Vui lòng nhập số";
                        swalError(mes);
                        return false;
                    } else if (value == 0) {
                        mes = "Số lượng phải lớn hơn hoặc bằng 1";
                        swalError(mes);
                        return false;
                    } else if (value > quantityProduct) {
                        mes = "Số lượng phải nhỏ hơn số lượng có sẵn";
                        swalError(mes)
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

    HT.addToCartDetail = () => {
        let isSwalOpen = false;
        let isProcessing = false;
        $('.addDeatil').click(function () {

            if ($('.size_detail').hasClass('disabled')) {
                mes = "Sản phẩm đã tạm hết hàng";
                swalError(mes);
                let input = $('.cart-plus-minus-box');
                input.val(1);
                return
            };

            let id = $('.size_detail.active').attr('data-id');
            let button = $(this);
            if (isSwalOpen || isProcessing) return;

            isProcessing = true;
            button.addClass('disabled');

            let input = $('.qtybutton').siblings('input.quatity_detail_shop');
            let selectedVariant = input.closest('.product').find('.size_detail.active');
            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));
            let quantity = input.val();

            if (quantity > quantityProduct) {
                mes = "Số lượng phải nhỏ hơn số lượng có sẵn";
                swalError(mes)
                isProcessing = false;  // Đặt lại trạng thái khi có lỗi
                button.removeClass('disabled');  // Cho phép nhấn lại nút
                let input = $('.cart-plus-minus-box');
                input.val(1);
                return false;
            }

            let option = {
                'product_variant_id': id,
                'quantity': quantity,
                'quantityProduct': quantityProduct,
                '_token': token
            }

            $.ajax({
                type: 'POST',
                url: '/ajax/addToCart',
                data: option,
                dataType: 'json',
                success: function (res) {
                    mes = res.message;

                    if (res.success == false) {
                        swalError(mes);
                    } else {
                        swalSuccess(mes);
                        $('.header-action-num').html(res.uniqueVariantCount);

                        const cartContent = $('.offcanvas-cart-content');
                        cartContent.empty();

                        if (res.cartItems.length > 0) {

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
                                                                        <span class="new">${new Intl.NumberFormat('vi-VN').format(item.price_sale)}  đ</span>
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
                                                    </div>`;

                            cartContent.html(productHtml);
                        } else {
                            cartContent.html('<p>Giỏ hàng của bạn hiện đang trống.</p>');
                        }

                        $('.deleteCart').click(function () {

                            let id = $(this).attr('data-id');
                            idcart = id;

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
                                    mes = res.message;

                                    if (res.cartItems && res.cartItems.length > 0) {
                                        $('.header-action-num').html(res.uniqueVariantCount);
                                        $('#cart-header-' + idcart).remove();
                                    } else {
                                        $('.header-action-num').html(res.uniqueVariantCount);
                                        $('.cart-product-wrapper').empty();
                                        $('.cartNull').append('<p >Giỏ hàng của bạn hiện đang trống.</p>');
                                    }
                                    swalSuccess(mes);
                                },
                                error: function (xhr, status, error) {
                                    let hasShownErrorMessage = false;
                                    $(document).ajaxError(function (event, xhr) {
                                        if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                                            let errorMessages = xhr.responseJSON.errors;
                                            for (let key in errorMessages) {
                                                if (errorMessages.hasOwnProperty(key)) {
                                                    swalError(errorMessages[key][0]);
                                                }
                                            }
                                            hasShownErrorMessage = true;
                                        }
                                    });
                                }
                            });

                        })
                    }
                },
                error: function (xhr) {
                    let hasShownErrorMessage = false;

                    $(document).ajaxError(function (event, xhr) {
                        if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMessages = xhr.responseJSON.errors;
                            for (let key in errorMessages) {
                                if (errorMessages.hasOwnProperty(key)) {
                                    swalError(errorMessages[key][0]);
                                }
                            }
                            hasShownErrorMessage = true;
                        }
                    });
                    let input = $('.cart-plus-minus-box');
                    input.val(1);
                },
                complete: function () {
                    isProcessing = false;
                    button.removeClass('disabled');
                }
            });
        })
    }

    HT.addToCartModal = () => {
        let isSwalOpen = false;
        let isProcessing = false;
        $('.add-to_cart').click(function () {
            if ($('.remove_at').hasClass('disabled')) {
                mes = "Sản phẩm đã tạm hết hàng";

                swalError(mes);
                let input = $('.cart-plus-minus-box');
                input.val(1);
                return

            }

            let id = $('.remove_at.active').attr('data-id');
            let button = $(this);
            if (isSwalOpen || isProcessing) return;

            isProcessing = true;
            button.addClass('disabled');

            let input = $('.qtybutton').siblings('input.quatity_add_cart');
            let selectedVariant = input.closest('.product').find('.remove_at.active');
            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));
            let quantity = input.val();

            if (quantity > quantityProduct) {
                mes = "Số lượng phải nhỏ hơn số lượng có sẵn";
                swalError(mes)
                isProcessing = false;
                button.removeClass('disabled');
                let input = $('.cart-plus-minus-box');
                input.val(1);
                return false;
            }

            let option = {
                'product_variant_id': id,
                'quantity': quantity,
                'quantityProduct': quantityProduct,
                '_token': token
            }

            $.ajax({
                type: 'POST',
                url: '/ajax/addToCart',
                data: option,
                dataType: 'json',
                success: function (res) {
                    mes = res.message;

                    if (res.success == false) {
                        swalError(mes);
                    } else {
                        swalSuccess(mes);
                        $('.header-action-num').html(res.uniqueVariantCount);

                        const cartContent = $('.offcanvas-cart-content');
                        cartContent.empty();

                        if (res.cartItems.length > 0) {

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
                                                                        <span class="new">${new Intl.NumberFormat('vi-VN').format(item.price_sale)}  đ</span>
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
                                                    </div>`;

                            cartContent.html(productHtml);
                        } else {
                            cartContent.html('<p>Giỏ hàng của bạn hiện đang trống.</p>');
                        }

                        $('.deleteCart').click(function () {

                            let id = $(this).attr('data-id');
                            idcart = id;

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
                                    mes = res.message;

                                    if (res.cartItems && res.cartItems.length > 0) {
                                        $('.header-action-num').html(res.uniqueVariantCount);
                                        $('#cart-header-' + idcart).remove();
                                    } else {
                                        $('.header-action-num').html(res.uniqueVariantCount);
                                        $('.cart-product-wrapper').empty();
                                        $('.cartNull').append('<p >Giỏ hàng của bạn hiện đang trống.</p>');
                                    }
                                    swalSuccess(mes);
                                },
                                error: function (xhr, status, error) {
                                    let hasShownErrorMessage = false;
                                    $(document).ajaxError(function (event, xhr) {
                                        if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                                            let errorMessages = xhr.responseJSON.errors;
                                            for (let key in errorMessages) {
                                                if (errorMessages.hasOwnProperty(key)) {
                                                    swalError(errorMessages[key][0]);
                                                }
                                            }
                                            hasShownErrorMessage = true;
                                        }
                                    });
                                }
                            });

                        })
                    }
                },
                error: function (xhr) {
                    let hasShownErrorMessage = false;

                    $(document).ajaxError(function (event, xhr) {
                        if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMessages = xhr.responseJSON.errors;
                            for (let key in errorMessages) {
                                if (errorMessages.hasOwnProperty(key)) {
                                    swalError(errorMessages[key][0]);
                                }
                            }
                            hasShownErrorMessage = true;
                        }
                    });
                    let input = $('.cart-plus-minus-box');
                    input.val(1);
                },
                complete: function () {
                    isProcessing = false;
                    button.removeClass('disabled');
                }
            });
        })
    }


    HT.addToFavoriteDetail = () => {
        let isSwalOpen = false;
        let isProcessing = false;

        $(document).on('click', '.addFavorite[data-slug]', function () {
            let button = $(this);

            if (isSwalOpen || isProcessing) return;

            isProcessing = true;
            button.addClass('disabled');

            let idpro = button.attr('data-id');
            let option = {
                'product_id': idpro,
                '_token': token
            };

            $.ajax({
                type: 'POST',
                url: '/ajax/addToFavorite',
                data: option,
                dataType: 'json',
                success: function (res) {
                    let mes = res.message;

                    if (res.success === false) {
                        swalError(mes);
                    } else if (res.status === false) {
                        isSwalOpen = true;
                        Swal.fire({
                            title: "<h1 style='font-size:1.5rem;'>Bạn cần phải đăng nhập</h1>",
                            text: "Vui lòng đăng nhập để vào mục yêu thích",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Đăng nhập",
                            cancelButtonText: "Hủy",
                            customClass: {
                                confirmButton: 'swal-link-button',
                                cancelButton: 'swal-link-button',
                            },
                            buttonsStyling: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/login";
                            }
                        }).finally(() => {
                            isSwalOpen = false;
                        });

                        Swal.getConfirmButton().style.backgroundColor = '#3085d6';
                        Swal.getConfirmButton().style.color = '#fff';
                        Swal.getCancelButton().style.backgroundColor = '#d33';
                        Swal.getCancelButton().style.color = '#fff';
                    } else {
                        swalSuccess(mes);
                    }
                },
                error: function (xhr, status, error) {
                    let hasShownErrorMessage = false;
                    $(document).ajaxError(function (event, xhr) {
                        if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMessages = xhr.responseJSON.errors;
                            for (let key in errorMessages) {
                                if (errorMessages.hasOwnProperty(key)) {
                                    swalError(errorMessages[key][0]);
                                }
                            }
                            hasShownErrorMessage = true;
                        }
                    });
                },
                complete: function () {
                    isProcessing = false;
                    button.removeClass('disabled');
                }
            });
        });
    };

    window.HT = HT;

    $(document).ready(function () {
        HT.showProductView();
        HT.fetchSizeAndPrice();
        HT.getSizePrice();
        HT.updatePriceWithQuantity();
        HT.addToCartDetail();
        HT.addToCartModal();
        HT.addToFavoriteDetail();
    });
})(jQuery);

