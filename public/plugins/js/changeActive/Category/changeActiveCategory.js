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
                    url: 'categories/ajax/changeActiveCategory', // URL của máy chủ xử lý yêu cầu
                    data: option, // Dữ liệu gửi đến máy chủ
                    dataType: 'json', // Loại dữ liệu nhận lại từ máy chủ
                    success: function (res) {
                        if (res.status) {
                            // Cập nhật lại data-model
                            _this.attr('data-model', res.newStatus);
                        } else {
                            // In ra thông báo lỗi vào console
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
