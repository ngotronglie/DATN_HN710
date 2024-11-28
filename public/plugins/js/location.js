(function($) {
    "use strict";
    var HT = {};

    HT.district = () =>{
        $(document).on('change', '.province', function(){
            let _this = $(this)
            let province_id = _this.val()

            $.ajax({
                type: 'get',
                url: 'ajax/location/getDistrics',
                data: {
                    'province_id' : province_id
                },
                dataType: 'json',
                success: function(res) {
                    $('.districts').html(res.html);
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

            $.ajax({
                type: 'get',
                url: 'ajax/location/getWards',
                data: {
                    'district_id' : district_id
                },
                dataType: 'json',
                success: function(res) {
                    $('.wards').html(res.html);
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });

        })
    }

    $(document).ready(function () {
        HT.district();
        HT.ward();
    })

})(jQuery)
