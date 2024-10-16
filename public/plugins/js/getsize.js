(function($) {
    "use strict";
    var HT = {};
    
    HT.selectColor = (label, color) => {
        $('.color-btn').removeClass('active');
        $(label).addClass('active');
    };

    HT.h = (label, sizeName) => {
        $('.size-btn').removeClass('active');
        $(label).addClass('active');
    };

    HT.getSizePrice = () => {
        $(document).on('click', '.colorGetSize', function(){
            let _this = $(this);
            let idColor = _this.attr('data-id');
            let idProduct = _this.attr('data-productId');

            $.ajax({
                type: 'get',
                url: '/shop/ajax/getSizePrice',
                data: {
                    'idColor': idColor,
                    'idProduct': idProduct
                },
                dataType: 'json',
                success: function(res) {
                    if (res && res.length > 0) {
                        $('#sizes-prices-' + idProduct).empty();

                        // if ($('#lable-change-' + idProduct).find('label').length === 0) {
                        //     $('#lable-change-' + idProduct).append('<label>Size:</label>');
                        // }

                        res.forEach(function(variant) {
                            $('#sizes-prices-' + idProduct).append(
                                '<li><label class="size-btn" onclick="HT.h(this, \'' + variant.size + '\', ' + idProduct + ')">' +
                                variant.size + '</label></li>'
                            );
                        });

                        $('.size-btn').on('click', function() {
                            let selectedSize = $(this).text();
                            let selectedVariant = res.find(function(variant) {
                                return variant.size === selectedSize;
                            });

                            if (selectedVariant) {
                                let sizePriceSale = selectedVariant.price_sale && !isNaN(selectedVariant.price_sale)
                                    ? parseFloat(selectedVariant.price_sale).toFixed(0) : '0.00';
                                $('#product-price-sale-' + idProduct).text(sizePriceSale + ' VNĐ');
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        });
    };
    window.HT = HT;
    $(document).ready(function () {
        HT.getSizePrice();
    });
})(jQuery);
