(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    let idcart = null;

    HT.deleleCart = () => {
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
                    if (res.cartItems && res.cartItems.length > 0) {
                        $('.header-action-num').html(res.uniqueVariantCount);

                        $('#cart-'+ idcart).empty();

                        $('span[data-id="' + id + '"]').closest('tr').remove();

                        let formatTotal = new Intl.NumberFormat('vi-VN').format(res.totalCartAmount) + ' đ';
                        let formatTotalShip = new Intl.NumberFormat('vi-VN').format(res.totalCartAmount+30000) + ' đ';

                        $('.totalAll').empty().html(formatTotal);
                        $('.total-amount').empty().html(formatTotalShip);

                        } else {
                            $('.header-action-num').html(res.uniqueVariantCount);

                            $('.remove-cart').empty();

                            $('.cart-product-wrapper').empty();

                            $('.cartNull').append('<p >Giỏ hàng của bạn hiện đang trống.</p>');

                            $('#cart-null').append('<td colspan="6"><p>Giỏ hàng của bạn hiện đang trống.</p></td>');

                            $('.totalAll').empty();

                            $('.total-amount').empty();
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
    }

    $(document).ready(function () {
        HT.deleleCart();
    });
})(jQuery);
