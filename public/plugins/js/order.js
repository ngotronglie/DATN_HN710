(function ($) {
    "use strict";
    var token = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function () {
        $('.rules-order').on('click', function () {
            Swal.fire({
                title: '🎉 Quy tắc tích lũy điểm',
                html: `
                    <p>💰 <strong>Cứ mỗi 100,000đ</strong> tổng đơn hàng, bạn sẽ nhận được <strong>10 điểm thưởng</strong>.</p>
                    <p>🛍️ Điểm sẽ được cộng khi đơn hàng được giao thành công.</p>
                    <p>🔄 Điểm được dùng để đổi lấy mã giảm giá.</p>
                    <p style="color: #de1d1d;"><em>💡 Mua thêm một chút để tích lũy thật nhiều điểm thưởng nhé! 🚀</em></p>
                `,
                icon: 'info',
                showCloseButton: true,
                allowOutsideClick: true,
                showConfirmButton: false
            });
        });
    });


    $(document).ready(function () {

        $(document).on('input change', '.userName, .userEmail, .userPhone, .province, .districts, .wards, .input_address', function () {
            $(this).next('.error-message').html('');
            if ($(this).hasClass('province')) {
                $('.error-message-province').html('');
            }
            if ($(this).hasClass('districts')) {
                $('.error-message-districts').html('');
            }
            if ($(this).hasClass('wards')) {
                $('.error-message-wards').html('');
            }
            if ($(this).hasClass('input_address')) {
                $('.error-address').html('');
            }
        });

        $('#addressForm').submit(function (event) {
            let isValid = true;

            $('.error-message, .error-message-province, .error-message-districts, .error-message-wards, .error-address').html('');

            if ($('.userName').length && $('.userName').val().trim() === '') {
                $('.userName').next('.error-message').html('Tên không được bỏ trống.');
                isValid = false;
            }

            if ($('.userEmail').length) {
                let email = $('.userEmail').val().trim();
                if (email === '') {
                    $('.userEmail').next('.error-message').html('Email mail không được bỏ trống.');
                    isValid = false;
                } else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                    $('.userEmail').next('.error-message').html('Email không đúng định dạng.');
                    isValid = false;
                }
            }

            if ($('.userPhone').length) {
                let phone = $('.userPhone').val().trim();
                if (phone === '') {
                    $('.userPhone').next('.error-message').html('Số điện thoại không được bỏ trống.');
                    isValid = false;
                } else if (!/^(0(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9]))[0-9]{7}$/.test(phone)) {
                    $('.userPhone').next('.error-message').html('Số điện thoại không hợp lệ.');
                    isValid = false;
                }
            }

            if ($('.province').length && $('.province').val() === '') {
                $('.error-message-province').html('Vui lòng chọn tỉnh/thành phố.');
                isValid = false;
            }

            if ($('.districts').length && ($('.districts').val() === '' || $('.districts').val() == 0)) {
                $('.error-message-districts').html('Vui lòng chọn quận/huyện.');
                isValid = false;
            }

            if ($('.wards').length && $('.wards').val() === '') {
                $('.error-message-wards').html('Vui lòng chọn phường/xã.');
                isValid = false;
            }

            if ($('.input_address').length && $('.input_address').val().trim() === '') {
                $('.error-address').html('Vui lòng nhập tên đường/tòa nhà/số nhà.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
            else{
                Swal.fire({
                title: 'Đang xử lý...',
                text: 'Vui lòng chờ trong giây lát!',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
                });
                setTimeout(() => {
                    Swal.close();  // Đóng Swal sau 4 giây
                }, 4000);  //
                this.submit();
            }
        });
    });


    $(document).ready(function() {
        //Aps vourcher
        $(document).on('click', '.use-voucher', function() {
            let voucherButton = $(this);
            let voucherCode = voucherButton.data('code');
            $.ajax({
                url: '/apply-voucher',
                method: 'POST',
                data: {
                    '_token': token,
                    'voucher_code': voucherCode
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: response.message,
                        });

                        $('.use-voucher').each(function() {
                            $(this).data('used', 'false').text('Dùng').removeClass(
                                'disabled').attr('disabled', false);
                        });

                        voucherButton.data('used', 'true').text('Đã dùng').addClass(
                            'disabled').attr('disabled', true);

                        $('#total-amount').text(response.totalAmountWithDiscount
                            .toLocaleString() + ' đ');
                        $('#discount-amount').text('-' + response.discount
                            .toLocaleString() + ' đ');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Đã xảy ra lỗi khi áp dụng mã giảm giá.',
                    });
                }
            });
        });

        //  mô tả phương thức thanh toán
        document.querySelectorAll('input[name="payment_method"]').forEach((elem) => {
            elem.addEventListener('change', function() {
                document.querySelectorAll('.payment-description').forEach((desc) => {
                    desc.style.display = 'none';
                });
                this.closest('.form-check').querySelector('.payment-description').style
                    .display = 'block';
            });
        });
    });

})(jQuery)
