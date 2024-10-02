(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    HT.changeStt = () => {

        //ket hop swk de thay doi tt tai khoan
        if ($('.active').length) {
            $(document).on('change', '.active', function () {
                let _this = $(this)

                let option = {
                    'id': _this.attr('data-modelId'),
                    'is_active': _this.attr('data-model'),
                    '_token': token
                }

                $.ajax({
                    type: 'POST',
                    url: 'products/ajax/changeActiveProduct',
                    success: function (res) {
                        if (res.status) {
                            _this.attr('data-model', res.newStatus);
                        } else {
                            console.error('Cập nhật thất bại: ' + res.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        let message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                        alert('Đã xảy ra lỗi: ' + message);
                        console.error('Error:', error);
                        console.error('XHR:', xhr);
                        console.error('Status:', xhr.status);
                        console.error('Response Text:', xhr.responseText);
                        console.error('Status Description:', status)
                    }
                });

            });
        }
    };

    $(document).ready(function () {
        HT.changeStt();
    });

})(jQuery);
