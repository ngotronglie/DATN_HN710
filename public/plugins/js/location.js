(function ($) {
    "use strict";
    var HT = {};

    HT.district = () => {
        $(document).on('change', '.province', function () {
            let _this = $(this)
            let province_id = _this.val()

            $('.districts').html('<option value="">[Chọn Quận/Huyện]</option>');
            $('.wards').html('<option value="">[Chọn Phường/Xã]</option>');
            $('.input_address').val('');

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

            $('.input_address').val('');

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

    $(document).on('change', '.wards', function () {
        $('.input_address').val('');
    })

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

        $('.province').change(function () {
            $('.error-message-province').html('');
        });

        $('.districts').change(function () {
            $('.error-message-districts').html('');
        });

        $('.wards').change(function () {
            $('.error-message-wards').html('');
        });

        $('.input_address').on('input', function () {
            $('.error-address').html('');
        });

        $('#addressForm').submit(function (event) {
            let isValid = true;

            $('.error-message').text('');

            if ($('.province').val() == '') {
                $('.error-message-province').html('Vui lòng chọn tỉnh/thành phố.');
                isValid = false;
            }

            if ($('.districts').val() == '' || $('.districts').val() == 0) {
                $('.error-message-districts').html('Vui lòng chọn quận/huyện.');
                isValid = false;
            }

            if ($('.wards').val() == '') {
                $('.error-message-wards').html('Vui lòng chọn phường/xã.');
                isValid = false;
            }

            if ($('.input_address').val() == '') {
                $('.error-address').html('Vui lòng nhập tên đường/tòa nhà/số nhà.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });

    });

    $(document).ready(function () {
        HT.district();
        HT.ward();
    })

})(jQuery)
