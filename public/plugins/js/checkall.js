(function($) {

    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');




    HT.checkall = () => {
        // Lắng nghe sự kiện click trên checkbox "Check All"
        $(document).on('click', '#checkallus', function() {
            let checkall = $(this).prop('checked');
            console.log('Check All:', checkall); // Kiểm tra giá trị của checkbox

            // Cập nhật tất cả checkbox có class "checkBoxItem"
            $('.checkBoxItem').prop('checked', checkall);

            // Cập nhật lớp CSS cho các hàng trong bảng
            if (checkall) {
                $('tbody tr').addClass('active-check');
                console.log('Added class to rows');
            } else {
                $('tbody tr').removeClass('active-check');
                console.log('Removed class from rows');
            }
        });

        // Lắng nghe sự kiện thay đổi trạng thái của các checkbox trong "checkBoxItem"
        $(document).on('change', '.checkBoxItem', function() {
            let allChecked = $('.checkBoxItem').length === $('.checkBoxItem:checked').length;
            $('#checkallus').prop('checked', allChecked);

            // Cập nhật lớp CSS cho các hàng trong bảng dựa trên trạng thái checkbox
            if (allChecked) {
                $('tbody tr').addClass('active-check');
                console.log('Added class to rows');
            } else {
                $('tbody tr').removeClass('active-check');
                console.log('Removed class from rows');
            }
        });
    };


    //thay doi trang thai nhieu tai khoan da chon
    HT.changeall = () => {
        if ($('.activeAll').length) {
            var token = $('meta[name="csrf-token"]').attr('content');

            $(document).on('click', '.activeAll', function() {
            let _this = $(this)
            let id = [];
            $('.checkBoxItem').each(function(){
                let checkbox = $(this)
                if (checkbox.prop('checked')) {
                    id.push(checkbox.attr('data-id'))
                }
            })


            let option = {
                'id':id,
                'dk': _this.attr('data-dk'),
                '_token': token
            }

            $.ajax({
                    type: 'POST',
                    url: 'ajax/changeActiveAll', // URL của máy chủ xử lý yêu cầu
                    data: option, // Dữ liệu gửi đến máy chủ
                    dataType: 'json', // Loại dữ liệu nhận lại từ máy chủ
                    success: function(res) {

                        // Sau đó chuyển hướng
                        window.location.href = '/user'; // Thay đổi URL nếu cần thiết

                        // Hiển thị phản hồi từ máy chủ
                        //$('#result').html('Server Response: ' + response.message);
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi
                        console.log('Error: ' + error);
                    }
                });

        });
        }
    }



    $(document).ready(function() {
        HT.checkall();
        HT.changeall();
    });

})(jQuery);
