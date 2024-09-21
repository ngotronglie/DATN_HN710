(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    HT.changeStt = () => {

        //ket hop swk de thay doi tt tai khoan
        if ($('.active').length) {
            $(document).on('change', '.active', function () {
                let _this = $(this)

                if (!confirm('Bạn có chắc muốn thay đổi trạng thái tài khoản này?')) {
                    _this.prop('checked', !_this.prop(
                    'checked')); // Hoàn tác trạng thái checkbox nếu người dùng nhấn "Cancel"
                    return;
                }


                let option = {
                    'id': _this.attr('data-modelId'),
                    'model': _this.attr('data-model'),
                    '_token': token
                }

                console.log(option);

                $.ajax({
                    type: 'POST',
                    url: 'ajax/changeActiveCategoryBlog', // URL của máy chủ xử lý yêu cầu
                    data: option, // Dữ liệu gửi đến máy chủ
                    dataType: 'json', // Loại dữ liệu nhận lại từ máy chủ
                    success: function (res) {
                        console.log(res);

                        // Hiển thị phản hồi từ máy chủ
                        //$('#result').html('Server Response: ' + response.message);
                    },
                    error: function (xhr, status, error) {
                        // Xử lý lỗi
                        console.log('Error: ' + error);
                    }
                });

            });
        }


    };



    //thay doi tt tai khoan
    HT.changeall = () => {
        $(document).on('click', '.activeAll', function () {
            let _this = $(this)
            let id = [];
            $('.checkBoxItem').each(function () {
                if (checkbox.prop('checked')) {
                    id.push($(this).val())
                }
            })
            console.log(id);

            let option = {
                'model': _this.attr('data-model'),
                '_token': token
            }
        });
    }

    $(document).ready(function () {
        HT.changeStt();
        // HT.checkall();
    });

})(jQuery);
