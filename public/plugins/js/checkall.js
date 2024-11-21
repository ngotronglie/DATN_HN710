(function ($) {
    "use strict";
    var HT = {};

    HT.checkAll = () => {
        // Lắng nghe sự kiện click trên checkbox "Check All"
        $(document).on('click', '#checkAllTable', function () {
            let checkAll = $(this).prop('checked');

            // Cập nhật tất cả checkbox có class "checkBoxItem"
            $('.checkBoxItem').prop('checked', checkAll);

            // Cập nhật lớp CSS cho các hàng trong bảng
            if (checkAll) {
                $('tbody tr').addClass('active-check');
            } else {
                $('tbody tr').removeClass('active-check');
            }
        });

        // Lắng nghe sự kiện thay đổi trạng thái của các checkbox trong "checkBoxItem"
        $(document).on('change', '.checkBoxItem', function () {
            let allChecked = $('.checkBoxItem').length === $('.checkBoxItem:checked').length;
            $('#checkAllTable').prop('checked', allChecked);

            // Cập nhật lớp CSS cho các hàng trong bảng dựa trên trạng thái checkbox
            if (allChecked) {
                $('tbody tr').addClass('active-check');
            } else {
                $('tbody tr').removeClass('active-check');
            }
        });
    };

    $(document).ready(function () {
        HT.checkAll();
    });

})(jQuery);
