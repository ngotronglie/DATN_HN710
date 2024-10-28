(function ($) {
    "use strict";
    var HT = {};

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
        $('.quantity-product').empty();
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
                alert('Vui lòng chọn Màu');
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            if (!selectedVariant.length) {
                alert('Vui lòng chọn Size');
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));


            function validateInput(value) {
                if (!/^\d*$/.test(value)) {
                    alert('Vui lòng chỉ nhập số.');
                    return false;
                } else if (value == 0) {
                    alert('Vui lòng nhập số lượng nhiều hơn 0.');
                    return false;
                } else if (value > quantityProduct) {
                    alert('Vui lòng nhập số lượng ít hơn số lượng sản phẩm.');
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
            let productId = input.closest('.product').attr('data-product-id');

            updatePrice(quantity, productId);
        });


        $(document).on('keypress', 'input.cart-plus-minus-box', function (e) {
            let input = $(this);
            let inputValue = input.val();
            let previousQuantity = parseInt(input.data('previousQuantity')) || 1;
            let selectedVariant = input.closest('.product').find('.size-btn.active');
            let selectedColor = input.closest('.product-summery.position-relative').find('.color-btn.colorGetSize.active');

            if (!selectedColor.length) {
                alert('Vui lòng chọn Màu');
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            if (!selectedVariant.length) {
                alert('Vui lòng chọn Size');
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));


            if (e.which === 13) {
                function validateInput(value) {
                    if (!/^\d*$/.test(value)) {
                        alert('Vui lòng chỉ nhập số.');
                        return false;
                    } else if (value == 0) {
                        alert('Vui lòng nhập số lượng nhiều hơn 0.');
                        return false;
                    } else if (value > quantityProduct) {
                        alert('Vui lòng nhập số lượng ít hơn số lượng sản phẩm.');
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
                let productId = input.closest('.product').attr('data-product-id');

                input.data('previousQuantity', quantity);

                updatePrice(quantity, productId);
            }
        });
    };

    window.HT = HT;

    $(document).ready(function () {
        HT.getSizePrice();
        HT.updatePriceWithQuantity();
    });
})(jQuery);

