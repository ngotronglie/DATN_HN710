(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    let mes = '';
    let idcart = null;

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
            console.log(quantityProduct);



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

    HT.addToCart = () => {

        $('.add-to_cart').click(function () {
            if ($('.remove_at').hasClass('disabled')) {
                mes = "Sản phẩm đã tạm hết hàng";

                swalError(mes); return
            }

            else if ($('.size_detail').hasClass('disabled')) {
                mes = "Sản phẩm đã tạm hết hàng";

                swalError(mes); return
            };


            let id = $('.size-btn.active').attr('data-id');
            let button = $(this);
            if (button.hasClass('disabled')) return;

            button.addClass('disabled');



            let input = $('.qtybutton').siblings('input.cart-plus-minus-box');
            let selectedVariant = input.closest('.product').find('.size-btn.active');
            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));
            let quantity = input.val();

            if (quantity > quantityProduct) {
                mes = "Số lượng phải nhỏ hơn số lượng có sẵn";
                swalError(mes)
                return false;
            }

            let option = {
                'product_variant_id': id,
                'quantity': quantity,
                'quantityProduct': quantityProduct,
                '_token': token
            }

            console.log(option);


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
                                                        <a href="/checkout" class="btn btn-dark btn-hover-primary rounded-0 w-100 mt-4">Thanh toán</a>
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
                                    console.log(res);
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
                                    console.log(error);
                                }
                            });

                        })
                    }
                },
                error: function (xhr) {
                    let hasShownErrorMessage = false;

                    $(document).ajaxError(function (event, xhr) {
                        if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                            // Lấy tất cả các thông báo lỗi và in ra từng cái
                            let errorMessages = xhr.responseJSON.errors;
                            for (let key in errorMessages) {
                                if (errorMessages.hasOwnProperty(key)) {
                                    swalError(errorMessages[key][0]);
                                }
                            }
                            hasShownErrorMessage = true; // Đặt cờ để không in lại
                        }
                    });
                    let input = $('.cart-plus-minus-box');
                    input.val(1);
                },
                complete: function () {
                    button.removeClass('disabled'); // Bật lại nút sau khi xử lý xong
                }
            });
        })
    }


    HT.addToFavorite = () => {
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
                    console.log(res);
                    let mes = res.message;

                    if (res.success === false) {
                        swalError(mes);
                    } else if (res.status === false) {
                        isSwalOpen = true;
                        swal({
                            title: "Bạn muốn thêm vào mục yêu thích",
                            text: "Bạn cần phải đăng nhập để sử dụng chức năng này",
                            icon: "warning",
                            buttons: {
                                cancel: "Hủy",
                                confirm: {
                                    text: "Đăng nhập",
                                    value: true,
                                    visible: true,
                                    className: "swal-link-button",
                                    closeModal: false
                                }
                            },
                            dangerMode: true,
                        }).then((willLogin) => {
                            if (willLogin) {
                                window.location.href = "/login";
                            }
                        }).finally(() => {
                            isSwalOpen = false;
                        });
                    } else {
                        swalSuccess(mes);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
                complete: function () {
                    isProcessing = false;
                    button.removeClass('disabled');
                }
            });
        });
    };

    $(document).ready(function () {
        HT.addToCart();
        HT.updatePriceWithQuantity();
        HT.addToFavorite();
    });
})(jQuery);
