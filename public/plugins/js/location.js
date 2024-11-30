(function ($) {
    "use strict";
    var HT = {};

    HT.district = () => {
        $(document).on('change', '.province', function () {
            let _this = $(this)
            let province_id = _this.val()

            $('.districts').html('<option value="">[Chọn Quận/Huyện]</option>');
            $('.wards').html('<option value="">[Chọn Phường/Xã]</option>');

            $.ajax({
                type: 'get',
                url: 'ajax/location/getDistrics',
                data: {
                    'province_id': province_id
                },
                dataType: 'json',
                success: function (res) {
                    $('.districts').html(res.html);
                },
                error: function (xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });

        })
    }

    HT.ward = () => {
        $(document).on('change', '.districts', function () {
            let _this = $(this)
            let district_id = _this.val()

            $.ajax({
                type: 'get',
                url: 'ajax/location/getWards',
                data: {
                    'district_id': district_id
                },
                dataType: 'json',
                success: function (res) {
                    $('.wards').html(res.html);
                },
                error: function (xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });

        })
    }

    $(document).ready(function () {
        let selectedCity = $('.province').attr('data-id');
        let selectedDistrict = $('.districts').attr('data-id');

        if (selectedCity) {
            loadDistricts(selectedCity, selectedDistrict);
        }

        $('.province').on('change', function () {
            let cityCode = $(this).val();
            loadDistricts(cityCode, null);
        });

        function loadDistricts(cityCode, selectedDistrict = null) {
            if (!cityCode) {
                $('.districts').html('<option value="">[Chọn Quận/Huyện]</option>');
                return;
            }

            $.ajax({
                url: '/api/districts',
                type: 'GET',
                data: { city_code: cityCode },
                success: function (data) {
                    let options = '<option value="">[Chọn Quận/Huyện]</option>';
                    data.forEach(function (district) {

                        options += `<option value="${district.code}" ${selectedDistrict == district.code ? 'selected' : ''}>
                                        ${district.full_name}
                                    </option>`;
                    });
                    $('.districts').html(options);
                },
                error: function () {
                    alert('Không thể tải danh sách Quận/Huyện.');
                },
            });
        }
    });

    $(document).ready(function () {
        let selectedDistricts = $('.districts').attr('data-id');
        let selectedWards = $('.wards').attr('data-id');

        if (selectedDistricts) {
            loadDistricts(selectedDistricts, selectedWards);
        }

        $('.districts').on('change', function () {
            let districtsCode = $(this).val();
            loadDistricts(districtsCode, null);
        });

        function loadDistricts(districtsCode, selectedWards = null) {
            if (!districtsCode) {
                $('.wards').html('<option value="">[Chọn Phường/Xã]</option>');
                return;
            }

            $.ajax({
                url: '/api/wards',
                type: 'GET',
                data: { districtsCode: districtsCode },
                success: function (data) {
                    let options = '<option value="">[Chọn Phường/Xã]</option>';
                    data.forEach(function (wards) {

                        options += `<option value="${wards.code}" ${selectedWards == wards.code ? 'selected' : ''}>
                                        ${wards.full_name}
                                    </option>`;
                    });
                    $('.wards').html(options);
                },
                error: function () {
                    alert('Không thể tải danh sách Phường/Xã');
                },
            });
        }
    });


    $(document).ready(function () {
        HT.district();
        HT.ward();
    })

})(jQuery)
