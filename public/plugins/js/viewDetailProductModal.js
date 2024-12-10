(function ($) {
    "use strict";
    var HT = {};

    HT.view = () => {
        $(document).on('click', '.showProduct[data-slug]', function () {
            $('#sizes-prices').empty();
            let slug = $(this).attr('data-slug');
            let id = $(this).attr('data-id');

            $.ajax({
                url: '/ajax/shops/' + slug,
                method: 'GET',
                success: function (res) {
console.log(res);

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

                    if (res.galleries.length == 1) {
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
                                '<label class="color-btn colorGetSize ' + (index === 0 ? 'selected' : '') + '" ' +
                                'title="' + variant.color.name + '"'+
                                'data-id="' + variant.color.id + '" ' +
                                'data-productId="' + idProduct + '" ' +
                                'data-max="' + maxPrice + '" ' +
                                'data-min="' + minPrice + '" ' +
                                'style="background-color:' + colorName + ';" ' +
                                'onclick="HT.selectColor(this)">' +
                                '</label>' +
                                '</li>'
                            );
                        }
                    });


                    const firstColorButton = $('.color-btn.selected');
                    if (firstColorButton.length) {
                        firstColorButton.trigger('click');
                    }

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
    }

    HT.selectColor = (label) => {

        $('.color-btn').removeClass('active');
        $('.color-btn').removeClass('select');

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
        $('.size-btn').removeClass('disabled');

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

                $('#sizes-prices').empty();

                res.variants.forEach(function (variant, index) {
                    $('#sizes-prices').append(
                        '<li>' +
                        '<label class="remove_at size-btn ' + (index === 0 ? 'selected' : '') + '" ' +
                        'data-quantity="' + variant.quantity + '" ' +
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

                $('.size-btn').off('click').on('click', function () {
                    let selectedSize = $(this).text();
                    let selectedVariant = res.variants.find(function (variant) {
                        return variant.size === selectedSize;
                    });

                    if (selectedVariant) {
                        $('.quantity_prd_modal').empty();

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

    window.HT = HT;

    $(document).ready(function () {
        HT.view();
        HT.getSizePrice();
    });
})(jQuery);

