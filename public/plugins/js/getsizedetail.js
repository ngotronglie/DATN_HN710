(function ($) {
    "use strict";
    var HT = {};
    let selectedVariantId = null;

    HT.showProductView = () => {
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
                    $('#alumProduct').empty(); // Xóa slide cũ

                    if (res.galleries.length === 1) {
                        $('.next_product').empty();
                        $('.prev_product').empty();
                    }
                    res.galleries.forEach(function (gallery) {
                        let imageUrlAlbum = http + "storage/" + gallery;
                        imageUrls.push(imageUrlAlbum);

                        $('#alumProduct').append(
                            '<a class="swiper-slide" href="#">' +
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
                                '<label id="color-btn" class="color-btn colorGetSize ' + (index === 0 ? 'selectedActive' : '') + '" ' +
                                'data-id="' + variant.color.id + '" ' +
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
                    console.log('Error fetching product data:', error);
                }
            });
        });
    };

    HT.handleColorSelection = (label) => {
        $('#color-btn').removeClass('active');
        $('#color-btn').removeClass('selectedModal');
        $('#color-btn').removeClass('select');

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
                console.log('Error: ' + error);
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

                            let quantity = selectedVariant.quantity; // Lấy số lượng từ biến thể đã chọn
                            $('#quantity-display-' + idProduct).text('Số lượng: ' + quantity); // Hiển thị số lượng
                            let input = $(this).closest('.product').find('input.cart-plus-minus-box');
                            input.val(1);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    };

    window.HT = HT;

    $(document).ready(function () {
        HT.showProductView();
        HT.fetchSizeAndPrice();
        HT.getSizePrice();
    });
})(jQuery);

