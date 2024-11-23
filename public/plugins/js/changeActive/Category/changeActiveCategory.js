(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    HT.changeStt = () => {
        if ($('.active').length) {
            $(document).on('change', '.active', function () {
                let _this = $(this)

                if (_this.hasClass('processing')) {
                    return;
                }

                _this.addClass('processing').prop('disabled', true);

                let option = {
                    'id': _this.attr('data-modelId'),
                    'is_active': _this.attr('data-model'),
                    '_token': token
                }

                Swal.fire({
                    title: 'Đang xử lý...',
                    text: 'Vui lòng đợi trong giây lát.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                    $.ajax({
                        type: 'POST',
                        url: 'categories/ajax/changeActiveCategory',
                        data: option,
                        dataType: 'json',
                        success: function (res) {
                            if (res.status == true) {
                                Swal.close();
                                swalSuccessAd(res.message);

                                _this
                                    .data('model', res.newStatus)
                                    .attr('data-model', res.newStatus);
                            } else {
                                swalErrorAd(res.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            let message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                            console.log('Đã xảy ra lỗi: ' + message);
                            console.error('Error:', error);
                            console.error('XHR:', xhr);
                            console.error('Status:', xhr.status);
                            console.error('Response Text:', xhr.responseText);
                            console.error('Status Description:', status)
                        },
                        complete: function () {
                            _this.removeClass('processing').prop('disabled', false);
                        }
                    });
            });
        }
    };

    $(document).ready(function () {
        HT.changeStt();
    });

})(jQuery);
