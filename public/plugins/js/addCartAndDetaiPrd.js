(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    let selectedVariantId = null;
    let idcart = null;
    let debounceTimeout;
    let mes = '';

    function swalSuccess(mes) {

    }

    function swalError(mes) {
        swal({
            content: {
                element: "span",
                attributes: {
                    innerHTML: mes,
                },
            },
            text: "",
            icon: "error",
            button: "Đóng",
        });
    }


    HT.view = () => {
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



                    $('.album_img').empty();
                    $('#alumProduct').empty(); // Xóa slide cũ

                    if (res.galleries.length == 1) {
                        $('.next_product').empty();
                        $('.prev_product').empty();

                    }
                    res.galleries.forEach(function (gallery) {
                        let imageUrlAlbum = http + "storage/" + gallery;
                        imageUrls.push(imageUrlAlbum);

                        $('#alumProduct').append(  // Thêm ảnh vào swiper-wrapper
                            '<a class="swiper-slide" href="#">' +
                            '<img class="w-100" src="' + imageUrlAlbum + '" alt="Product">' +
                            '</a>'
                        );

                    });

                    // Khởi tạo swiper nếu chưa có
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

                    $('#sizes-prices').empty();

                    res.variants.forEach(function (variant, index) {
                        $('#sizes-prices').append(
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
                            $('#quantity_prd').empty();
                            selectedVariantId = selectedVariant.id;
                            let sizePriceSale = selectedVariant.price_sale && !isNaN(selectedVariant.price_sale)
                                ? parseFloat(selectedVariant.price_sale) : 0;

                            let sizePrice = selectedVariant.price && !isNaN(selectedVariant.price)
                                ? parseFloat(selectedVariant.price) : 0;

                            let formattedPriceSale = sizePriceSale.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            let formattedPrice = sizePrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                            $('#product-price-sale').text(formattedPriceSale + 'đ');

                            $('#old-price').text(formattedPrice + 'đ');

                            // Hiển thị số lượng của kích thước đã chọn
                            let quantity = selectedVariant.quantity; // Lấy số lượng từ biến thể đã chọn
                            $('#quantity_prd').text('Số lượng: ' + quantity); // Hiển thị số lượng
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
                swal({
                    content: {
                        element: "span",
                        attributes: {
                            innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng chọn Màu!</h1>",
                        },
                    },
                    text: "",
                    icon: "error",
                    button: "Đóng",
                });
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            if (!selectedVariant.length) {
                swal({
                    content: {
                        element: "span",
                        attributes: {
                            innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng chọn Size!</h1>",
                        },
                    },
                    text: "",
                    icon: "error",
                    button: "Đóng",
                });
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));


            function validateInput(value) {
                if (!/^\d*$/.test(value)) {
                    swal({
                        content: {
                            element: "span",
                            attributes: {
                                innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng chỉ nhập số.!</h1>",
                            },
                        },
                        text: "",
                        icon: "error",
                        button: "Đóng",
                    });
                    return false;
                } else if (value == 0) {
                    mes = "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng nhập số lượng nhiều hơn 0.!</h1>";

                    swalError(mes);
                    return false;
                } else if (value > quantityProduct) {
                    swal({
                        content: {
                            element: "span",
                            attributes: {
                                innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng nhập số lượng ít hơn số lượng sản phẩm!</h1>",
                            },
                        },
                        text: "",
                        icon: "error",
                        button: "Đóng",
                    });
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
                swal({
                    content: {
                        element: "span",
                        attributes: {
                            innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng chọn Màu!</h1>",
                        },
                    },
                    text: "",
                    icon: "error",
                    button: "Đóng",
                });
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            if (!selectedVariant.length) {
                swal({
                    content: {
                        element: "span",
                        attributes: {
                            innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng chọn Size!</h1>",
                        },
                    },
                    text: "",
                    icon: "error",
                    button: "Đóng",
                });
                input.val(1);
                input.data('previousQuantity', 1);
                return;
            }

            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));


            if (e.which === 13) {
                function validateInput(value) {
                    if (!/^\d*$/.test(value)) {
                        swal({
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng chỉ nhập số!</h1>",
                                },
                            },
                            text: "",
                            icon: "error",
                            button: "Đóng",
                        });
                        return false;
                    } else if (value == 0) {
                        mes = "<h1 style='font-size: 1.3rem;margin-top: 33px'>Số lượng phải lớn hơn hoặc bằng 1!</h1>";
                        swalError(mes);
                        return false;
                    } else if (value > quantityProduct) {
                        swal({
                            content: {
                                element: "span",
                                attributes: {
                                    innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Vui lòng nhập số lượng ít hơn số lượng sản phẩm!</h1>",
                                },
                            },
                            text: "",
                            icon: "error",
                            button: "Đóng",
                        });
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

    // HT.addCartPublic = () => {
    //     $(document).on('click', '.addCartPro[data-slug]', function () {
    //         $('#sizes-prices').empty();
    //         let slug = $(this).attr('data-slug');
    //         let id = $(this).attr('data-id');

    //         $.ajax({
    //             url: '/ajax/shops/' + slug,
    //             method: 'GET',
    //             success: function (res) {
    //                 console.log(res);
    //                 let idProduct = res.id;
    //                 let http = 'http://datn_hn710.test/';
    //                 let imageUrl = http + "storage/" + res.img_thumb;
    //                 let imageUrls = [];
    //                 let minPrice = res.min_price_sale;
    //                 let maxPrice = res.max_price_sale;

    //                 $('#imgthumb').attr('src', imageUrl);

    //                 $('.album_img').empty();
    //                 res.galleries.forEach(function (gallery) {
    //                     let imageUrlAlbum = http + "storage/" + gallery.image;
    //                     imageUrls.push(imageUrlAlbum);

    //                     $('.album_img').append(
    //                         '<a class="swiper-slide" href="#">' +
    //                         '<img class="w-100 album_img" src="' + imageUrlAlbum + '" alt="Product">' +
    //                         '</a>'
    //                     );
    //                 });

    //                 $('#name-prd').text(res.name);

    //                 $('#color_prd').empty();
    //                 const uniqueColors = new Set();

    //                 res.variants.forEach(function (variant, index) {
    //                     let colorName = variant.color.hex_code;

    //                     if (!uniqueColors.has(colorName)) { // Kiểm tra nếu màu chưa có trong Set
    //                         uniqueColors.add(colorName); // Thêm màu vào Set để tránh trùng lặp

    //                         $('#color_prd').append(
    //                             '<li>' +
    //                             '<label class="color-btn colorGetSize ' + (index === 0 ? 'selected' : '') + '" ' +
    //                             'data-id="' + variant.color.id + '" ' +
    //                             'data-productId="' + idProduct + '" ' +
    //                             'data-max="' + maxPrice + '" ' +
    //                             'data-min="' + minPrice + '" ' +
    //                             'style="background-color:' + colorName + ';" ' +
    //                             'onclick="HT.selectColor(this)">' +
    //                             '</label>' +
    //                             '</li>'
    //                         );
    //                     }
    //                 });


    //                 const firstColorButton = $('.color-btn.selected'); // Chọn nút màu đầu tiên
    //                 if (firstColorButton.length) {
    //                     firstColorButton.trigger('click'); // Tự động click màu đầu tiên
    //                 }

    //                 $('#view_prd').text('Lượt xem: ' + res.view);
    //             },
    //             error: function (error) {
    //                 console.log('Error fetching product data:', error);
    //             }
    //         });
    //     });
    // }

    HT.addToCart = () => {

        $('.add-to_cart').click(function () {
            let input = $('.qtybutton').siblings('input.cart-plus-minus-box');
            let selectedVariant = input.closest('.product').find('.size-btn.active');
            let quantityProduct = parseFloat(selectedVariant.attr('data-quantity'));
            let quantity = input.val();

            let option = {
                'product_variant_id': selectedVariantId,
                'quantity': quantity,
                'quantityProduct': quantityProduct,
                '_token': token
            }

            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                $.ajax({
                    type: 'POST',
                    url: '/ajax/addToCart',
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        if (res.success == false) {
                            swal({
                                content: {
                                    element: "span",
                                    attributes: {
                                        innerHTML: `<h1 style='font-size: 1.3rem;margin-top: 33px'>${res.message}</h1>`,
                                    },
                                },
                                text: "",
                                icon: "error",
                                button: "Đóng",
                            });
                        } else {
                            swal({
                                content: {
                                    element: "span",
                                    attributes: {
                                        innerHTML: `<h1 style='font-size: 1.3rem;margin-top: 33px'>${res.message}</h1>`,
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
                                                    innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Đã xóa sản phẩm khỏi giỏ hàng!</h1>",
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
                    error: function (xhr) {
                        let hasShownErrorMessage = false;

                        $(document).ajaxError(function (event, xhr) {
                            if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                                // Lấy tất cả các thông báo lỗi và in ra từng cái
                                let errorMessages = xhr.responseJSON.errors;
                                for (let key in errorMessages) {
                                    if (errorMessages.hasOwnProperty(key)) {
                                        swal({
                                            content: {
                                                element: "span",
                                                attributes: {
                                                    innerHTML: `<h1 style='font-size: 1.3rem;margin-top: 33px'>${errorMessages[key][0]}</h1>`,
                                                },
                                            },
                                            text: "",
                                            icon: "error",
                                            button: "Đóng",
                                        });
                                    }
                                }
                                hasShownErrorMessage = true; // Đặt cờ để không in lại
                            }
                        });
                        let input = $('.cart-plus-minus-box');
                        input.val(1);
                    }
                });
            }, 400);
        })
    }


    // HT.addToFavoritePublic = () => {
    //     $(document).on('click', '.addFavorite[data-slug]', function () {
    //         let idpro = $(this).attr('data-id');

    //         let option = {
    //             'product_id': idpro,
    //             '_token': token
    //         }

    //         clearTimeout(debounceTimeout);
    //         debounceTimeout = setTimeout(() => {
    //             $.ajax({
    //                 type: 'POST',
    //                 url: '/ajax/addToFavorite',
    //                 data: option,
    //                 dataType: 'json',
    //                 success: function (res) {
    //                     if (res.success == false) {
    //                         swal({
    //                             content: {
    //                                 element: "span",
    //                                 attributes: {
    //                                     innerHTML: `<h1 style='font-size: 1.3rem;margin-top: 33px'>Sản phẩm đã thêm vào mục yêu thích rồi!</h1>`,
    //                                 },
    //                             },
    //                             text: "",
    //                             icon: "error",
    //                             button: "Đóng",
    //                         });
    //                     }
    //                     else if (res.status == false) {
    //                         swal({
    //                             title: "Bạn muốn thêm vào mục yêu thích?",
    //                             text: "Bạn cần phải đăng nhập để xử dụng chức năng này!",
    //                             icon: "warning",
    //                             buttons: {
    //                                 cancel: "Hủy",
    //                                 confirm: {
    //                                     text: "Đăng nhập",
    //                                     value: true,
    //                                     visible: true,
    //                                     className: "swal-link-button",
    //                                     closeModal: false
    //                                 }
    //                             },
    //                             dangerMode: true,
    //                         })
    //                             .then((willDelete) => {
    //                                 if (willDelete) {
    //                                     window.location.href = "/login"; // Chuyển đến trang đăng nhập
    //                                 }
    //                             });
    //                     }
    //                     else {
    //                         swal({
    //                             content: {
    //                                 element: "span",
    //                                 attributes: {
    //                                     innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Đã thêm vào mục yêu thích!</h1>",
    //                                 },
    //                             },
    //                             text: "",
    //                             icon: "success",
    //                             button: "Đóng",
    //                         });
    //                     }

    //                 },
    //                 error: function (xhr, status, error) {
    //                     console.log(error);
    //                 }
    //             });
    //         }, 400);
    //     });
    // }
    // HT.addToFavorite = () => {
    //     $('.favorite').click(function () {

    //         let option = {
    //             'product_variant_id': selectedVariantId,
    //             '_token': token
    //         }

    //         clearTimeout(debounceTimeout);
    //         debounceTimeout = setTimeout(() => {
    //             $.ajax({
    //                 type: 'POST',
    //                 url: '/ajax/addToFavorite',
    //                 data: option,
    //                 dataType: 'json',
    //                 success: function (res) {
    //                     if (res.success == false) {
    //                         swal({
    //                             content: {
    //                                 element: "span",
    //                                 attributes: {
    //                                     innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Sản phẩm đã thêm vào mục yêu thích rồi!</h1>",
    //                                 },
    //                             },
    //                             text: "",
    //                             icon: "error",
    //                             button: "Đóng",
    //                         });
    //                     }
    //                     else if (res.status == false) {
    //                         swal({
    //                             title: "Bạn muốn thêm vào mục yêu thích?",
    //                             text: "Bạn Cần phải đăng nhập để xử dụng chức năng này!",
    //                             icon: "warning",
    //                             buttons: {
    //                                 cancel: "Hủy",
    //                                 confirm: {
    //                                     text: "Đăng nhập",
    //                                     value: true,
    //                                     visible: true,
    //                                     className: "swal-link-button",
    //                                     closeModal: false
    //                                 }
    //                             },
    //                             dangerMode: true,
    //                         })
    //                             .then((willDelete) => {
    //                                 if (willDelete) {
    //                                     window.location.href = "/login"; // Chuyển đến trang đăng nhập
    //                                 }
    //                             });
    //                     }
    //                     else {
    //                         swal({
    //                             content: {
    //                                 element: "span",
    //                                 attributes: {
    //                                     innerHTML: "<h1 style='font-size: 1.3rem;margin-top: 33px'>Đã thêm vào mục yêu thích!</h1>",
    //                                 },
    //                             },
    //                             text: "",
    //                             icon: "success",
    //                             button: "Đóng",
    //                         });
    //                     }

    //                 },
    //                 error: function (xhr, status, error) {
    //                     console.log(error);
    //                 }
    //             });
    //         }, 400);
    //     })
    // }

    window.HT = HT;

    $(document).ready(function () {
        HT.view();
        HT.getSizePrice();
        HT.updatePriceWithQuantity();
        HT.addToCart();
        //HT.addCartPublic();
        // HT.addToFavoritePublic();
        // HT.addToFavorite();
    });
})(jQuery);

