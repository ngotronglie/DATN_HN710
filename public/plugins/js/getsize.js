(function ($) {
    "use strict";
    var HT = {};

    HT.selectColor = (label) => {
        $('.color-btn').removeClass('active');
        $('.size-btn').removeClass('active');


        $(label).addClass('active');
        let _this = $(label);
        let idProduct = _this.attr('data-productId');
        let idColor = _this.attr('data-id');
        $('.old-price-' + idProduct).empty();

        HT.getSizePrice(idProduct, idColor);
    };

    HT.h = (label) => {
        $('.size-btn').removeClass('active');
        $(label).addClass('active');
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
                console.log(res);

                if (res) {
                    $('#sizes-prices-' + idProduct).empty();

                    let minPrice = res.min_price;
                    let maxPrice = res.max_price;
                    let formattedMinPrice = Math.floor(minPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + 'đ';
                    let formattedMaxPrice = Math.floor(maxPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + 'đ';

                    if (minPrice === maxPrice) {
                        $('#product-price-sale-' + idProduct).text(`${formattedMaxPrice}`);
                    } else {
                        $('#product-price-sale-' + idProduct).text(`${formattedMinPrice} - ${formattedMaxPrice}`);
                    }

                    res.variants.forEach(function (variant) {
                        $('#sizes-prices-' + idProduct).append(
                            '<li><label class="size-btn" data-price="' + variant.price_sale + '" onclick="HT.h(this)">' +
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
                $('.old-price-' + idProduct).text(formattedPrice +'đ');


            }
        });
    }

    window.HT = HT;

    $(document).ready(function () {
        //$('.color-btn').on('click', function () {
        HT.selectColor();
        //});
    });
})(jQuery);
