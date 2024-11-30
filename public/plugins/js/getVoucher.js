(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    let mes = '';

    HT.getVoucher = () => {
        $(document).on('click', '.un-get', function () {
            let _this = $(this);
            let id = _this.attr('data-id');
            $.ajax({
                type: 'GET',
                url: '/ajax/getVoucher',
                data:
                {
                    'id': id,
                    'token': token
                },
                dataType: 'json',
                success: function (res) {
                    const mes = res?.message || 'Có lỗi xảy ra!';

                    if (res?.status) {
                        swalSuccess(mes);
                        $('.quantityAl-'+ id).html(`Còn lại: ${res?.countVoucher}`);
                        $('#my-point').html(`Điểm của bạn: ${res?.point}`);
                        _this.empty()
                            .html('Đã đổi')
                            .addClass('done-get')
                            .removeClass('get-voucher un-get');

                            $('#voucher-container').empty();
                            $('#voucher-container').html(res.html);
                    } else {
                        swalError(mes);
                    }
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
        HT.getVoucher();
    });
})(jQuery);
