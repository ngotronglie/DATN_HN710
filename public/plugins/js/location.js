(function($) {
    "use strict";
    var HT = {};

    HT.province = () =>{
        $(document).on('change', '.province', function(){
            let _this = $(this)
            let province_id = _this.val()
            $.ajax({
                type: 'get',
                url: 'ajax/location/getlocation', // URL của máy chủ xử lý yêu cầu
                data: {
                    'province_id' : province_id
                }, // Dữ liệu gửi đến máy chủ
                dataType: 'json', // Loại dữ liệu nhận lại từ máy chủ
                success: function(res) {
                    console.log(res);

                    $('.districts').html(res.html)

                    // Hiển thị phản hồi từ máy chủ
                    //$('#result').html('Server Response: ' + response.message);
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi
                    console.log('Error: ' + error);
                }
            });

        })
    }

    HT.ward = () =>{
        $(document).on('change', '.districts', function(){
            let _this = $(this)
            let district_id = _this.val()
            console.log(district_id);

            $.ajax({
                type: 'get',
                url: 'ajax/location/getward', // URL của máy chủ xử lý yêu cầu
                data: {
                    'district_id' : district_id
                }, // Dữ liệu gửi đến máy chủ
                dataType: 'json', // Loại dữ liệu nhận lại từ máy chủ
                success: function(res) {
                    console.log(res);

                    $('.wards').html(res.html)

                    // Hiển thị phản hồi từ máy chủ
                    //$('#result').html('Server Response: ' + response.message);
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi
                    console.log('Error: ' + error);
                }
            });

        })
    }



    $(document).ready(function () {
        HT.province();
        HT.ward();

    })

}
)(jQuery)
