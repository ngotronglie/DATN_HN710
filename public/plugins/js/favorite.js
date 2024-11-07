(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    let idFavorite = null;

    HT.deleleFavorite = () => {
        $('.deleteFavorite').click(function () {

            let id = $(this).attr('data-id');
            idFavorite = id;

            let option = {
                'id': id,
                '_token': token
            }
            $.ajax({
                type: 'DELETE',
                url: '/ajax/deleteToFavorite',
                data: option,
                dataType: 'json',
                success: function (res) {
                    console.log(res);

                    if (res.favoriteItems && res.favoriteItems.length > 0) {
                        $('#cart-'+ idFavorite).empty();

                        $('span[data-id="' + id + '"]').closest('tr').remove();

                        } else {

                            $('.remove-favorite').empty();

                            $('#favoriteNull').append('<td colspan="6"><p>Mục yêu thích của bạn hiện đang trống.</p></td>');
                        }
                        swal({
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "<h1 style='font-size: 1.3rem;'>Đã xóa sản phẩm khỏi mục yêu thích!</h1>",
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

    HT.addCart = () => {
        $('.btn-hover-primary').each(function () {
            let btn = $(this);
            let id = btn.attr('data-id');
            let idcart = btn.attr('data-id');

            console.log(id);


            $('#addcart-' + id).click(function () {
                let quantityPrd = btn.attr('data-quantity');
                let idpro = btn.attr('data-idpro');

                let quantity = 1;
                let option = {
                    'product_variant_id': idpro,
                    'quantity': quantity,
                    'quantityProduct': quantityPrd,
                    '_token': token
                };

                $.ajax({
                    type: 'POST',
                    url: '/ajax/addToCart',
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);

                        if (res.success == false) {
                            swal({
                                content: {
                                    element: "span",
                                    attributes: {
                                        innerHTML: "<h1 style='font-size: 1.3rem;'>Số lượng sản phẩm trong giỏ hàng vượt quá giới hạn cho phép!</h1>",
                                    },
                                },
                                text: "",
                                icon: "error",
                                button: "Đóng",
                            });
                        }else{
                        swal({
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "<h1 style='font-size: 1.3rem;'>Đã thêm sản phẩm vào giỏ hàng!</h1>",
                                },
                            },
                            text: "",
                            icon: "success",
                            button: "Đóng",
                        });
                        $('.header-action-num').html(res.uniqueVariantCount);

                        const cartContent = $('.offcanvas-cart-content');
                        cartContent.empty();

                        if (res.cartItems.length > 0) {
                            console.log(res);
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
                                                    <span class="new">${new Intl.NumberFormat('vi-VN').format(item.price_sale)} đ</span>
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
                            console.log(id);
                            idcart = id;
                            console.log(idcart);

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
                                        $('#cart-header-' + idcart).remove();
                                    } else {
                                        $('.header-action-num').html(res.uniqueVariantCount);
                                        $('.cart-product-wrapper').empty();
                                        $('.cartNull').append('<p >Giỏ hàng của bạn hiện đang trống.</p>');
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
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    };



    $(document).ready(function () {
        HT.deleleFavorite();
        HT.addCart();
    });
})(jQuery);
