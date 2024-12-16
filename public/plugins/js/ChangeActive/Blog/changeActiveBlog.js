(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    HT.changeStt = () => {
        if ($('.active').length) {
            $(document).on('change', '.active', function () {
                let _this = $(this);

                if (_this.hasClass('processing')) {
                    return;
                }

                _this.addClass('processing').prop('disabled', true);

                let option = {
                    id: _this.attr('data-modelId'),
                    _token: token
                };

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
                    url: '/blogs/ajax/changeActiveBlog',
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        if (res.status) {
                            swalSuccessAd(res.message);
                        } else {
                            swalErrorAd(res.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        let message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                        console.error('Error:', message);
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
