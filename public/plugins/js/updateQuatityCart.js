(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    let mes = '';

    HT.upQuatity = () => {
        let debounceTimeout;

        function validateInput(value, maxQuantity, input, quantityOld) {
            input = $(input);
            if (!/^\d+$/.test(value)) {
                mes = 'Vui lòng chỉ nhập số';
                swalError(mes);
                input.val(quantityOld);
                return false;
            } else if (value === 0) {
                mes = "Số lượng phải lớn hơn hoặc bằng 1";
                swalError(mes);
                input.val(quantityOld);
                return false;
            } else if (value > maxQuantity) {
                mes = 'Số lượng phải nhỏ hơn số lượng có sẵn',
                    swalError(mes);
                input.val(quantityOld);
                return false;
            }
            return true;
        }

        function sendAjax(id, quantity) {
            let option = {
                'id': id,
                'quantity': quantity,
                '_token': token
            };

            $.ajax({
                type: 'POST',
                url: '/ajax/updateQuantityCart',
                data: option,
                dataType: 'json',
                success: function (res) {
                    let formatTotalItem = new Intl.NumberFormat('vi-VN').format(res.total_price) + ' đ';
                    let formatTotal = new Intl.NumberFormat('vi-VN').format(res.total_cart_price) + ' đ';
                    let formatTotalShip = new Intl.NumberFormat('vi-VN').format(res.total_cart_price + 30000) + ' đ';

                    $('#total-' + id).empty().html(formatTotalItem);
                    $('.totalAll').empty().html(formatTotal);
                    $('.total-amount').empty().html(formatTotalShip);


                },
                error: function (xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }

        $(document).on('click', '.qtybutton', function () {
            let $this = $(this);
            let id = $this.closest('tr').find('.deleteCart').data('id');
            let input = $this.siblings('input.cart-plus-minus-box');
            let maxQuantity = $this.closest('tr').find('.deleteCart').data('quantity') || 10;
            let previousQuantity = parseInt(input.val()) || 1;
            let quantityOld = parseInt(input.data('previousQuantity') || previousQuantity - 1);

            let quantity = previousQuantity;

            if ($this.hasClass('inc')) {
                quantity = previousQuantity++;
                input.data('previousQuantity');
                console.log(id);


            } else if ($this.hasClass('dec') && previousQuantity > 1) {
                quantity = previousQuantity--;
                input.data('previousQuantity');
            }

            if (!validateInput(quantity, maxQuantity, input, quantityOld)) {
                return;
            }

            input.val(quantity).data('previousQuantity', quantity);

            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                sendAjax(id, quantity);
            }, 400);
        });

        $(document).on('focus', 'input.cart-plus-minus-box', function () {
            let input = $(this);
            input.data('previousQuantity', parseInt(input.val()) || 1);
        });

        $(document).on('keypress', 'input.cart-plus-minus-box', function (e) {
            if (e.which === 13) {
                let input = $(this);
                let id = input.closest('tr').find('.deleteCart').data('id');
                let quantity = parseInt(input.val());
                let maxQuantity = input.closest('tr').find('.deleteCart').data('quantity') || 10;
                let previousQuantity = input.data('previousQuantity') || 1;


                if (quantity > maxQuantity) {
                    mes = "Số lượng phải nhỏ hơn số lượng có sẵn";
                    swalError(mes)
                    input.val(previousQuantity);
                    return;
                }

                if (!/^\d*$/.test(input.val())) {
                    mes = "Vui lòng chỉ nhập số";
                    swalError(mes);
                    input.val(previousQuantity);
                    return;
                }

                if (quantity == 0) {
                    mes = "Số lượng phải lớn hơn hoặc bằng 1";
                    swalError(mes);
                    input.val(previousQuantity);
                    return;
                }

                input.data('previousQuantity', quantity);

                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    sendAjax(id, quantity);
                }, 400);
            }
        });
    };


    $(document).ready(function () {
        HT.upQuatity();
    });
})(jQuery);
