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

                    if (res.galleries.length == 1) {
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

                        if (!uniqueColors.has(colorName)) { // Kiểm tra nếu màu chưa có trong Set
                            uniqueColors.add(colorName); // Thêm màu vào Set để tránh trùng lặp

                            $('#color_prd').append(
                                '<li>' +
                                '<label class="color-btn colorGetSize ' + (index === 0 ? 'selected' : '') + '" ' +
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


                    const firstColorButton = $('.color-btn.selected'); // Chọn nút màu đầu tiên
                    if (firstColorButton.length) {
                        firstColorButton.trigger('click'); // Tự động click màu đầu tiên
                    }

                    $('#view_prd').text('Lượt xem: ' + res.view);
                },
                error: function (error) {
                    console.log('Error fetching product data:', error);
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
        // $('.size-btn').removeClass('active');
        // $(label).addClass('active');

        $('.size-btn').removeClass('active');
        $('.size-btn').removeClass('disabled');

        $(label).addClass('active');
        let quantity = $(label).attr('data-quantity');
        if (quantity == 0) {
            let button = $(label);
            button.addClass('disabled'); // Vô hiệu hóa nút
            // Lưu tham chiếu đến nút

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

                        let quantity = selectedVariant.quantity; // Lấy số lượng từ biến thể đã chọn
                        $('.quantity_prd_modal').text('Số lượng: ' + quantity); // Hiển thị số lượng
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

    window.HT = HT;

    $(document).ready(function () {
        HT.view();
        HT.getSizePrice();
    });
})(jQuery);

