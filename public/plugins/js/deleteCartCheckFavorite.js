(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    let isSwalOpen = false;
    let idRemove = null;
    let mes = '';

    HT.checkFavorite = () => {

        $('.header-action-btn-wishlist').click(function () {
            $.ajax({
                url: '/san-pham-yeu-thich',
                method: 'GET',
                success: function (res) {

                    if (!res.status && res.script) {
                        eval(res.script);
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Có lỗi xảy ra:', error);
                }
            });
        })
    };

    HT.deleleCart = () => {
        $('.deleteCart').click(function () {

            let id = $(this).attr('data-id');
            idRemove = id;

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

                        $('#cart-' + idRemove).empty();

                        $('span[data-id="' + id + '"]').closest('tr').remove();

                        let formatTotal = new Intl.NumberFormat('vi-VN').format(res.totalCartAmount) + ' đ';
                        let formatTotalShip = new Intl.NumberFormat('vi-VN').format(res.totalCartAmount + 30000) + ' đ';

                        $('.totalAll').empty().html(formatTotal);
                        $('.total-amount').empty().html(formatTotalShip);

                    } else {
                        $('.header-action-num').html(res.uniqueVariantCount);

                        $('.remove-cart').empty();

                        $('.cart-product-wrapper').empty();

                        $('.cartNull').append('<p >Giỏ hàng của bạn hiện đang trống.</p>');

                        $('#cart-null').append('<td colspan="6"><p>Giỏ hàng của bạn hiện đang trống.</p></td>');

                        $('.totalAll').empty().html('0 đ');

                        $('.total-amount').empty().html('30,000 đ');
                    }
                    mes = res.message;
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

    $(document).ready(function () {

        $('#openModalButton').on('click', function () {
            $('#exampleModalCenter').removeAttr('aria-hidden').prop('inert', true);

            $('#exampleModalCenter').modal('show');

            $('#exampleModalCenter').find('button').first().focus();
        });

        $('#exampleModalCenter').on('hidden.bs.modal', function () {
            $(this).attr('aria-hidden', 'true').prop('inert', false);
        });

        $('#closeModalButton').on('click', function () {
            $('#exampleModalCenter').modal('hide');
        });

    });


    $(document).ready(function () {
        HT.checkFavorite();
        HT.deleleCart();
    });
})(jQuery);
