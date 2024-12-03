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

        $('#addressForm').submit(function (event) {
            let isValid = true;

            $('.error-message').text('');

            if ($('.userName').val() == '') {
                $('.userName').next('.error-message').html('Vui lòng nhập tên người nhận.');
                isValid = false;
            }

            if ($('.nameUser').val() == '') {
                $('.nameUser').next('.error-message').html('Vui lòng nhập tên người dùng.');
                isValid = false;
            }

            if ($('.userEmail').val() == '') {
                $('.userEmail').next('.error-message').html('Vui lòng nhập email.');
                isValid = false;
            }else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test($('.userEmail').val())) {
                $('.userEmail').next('.error-message').html('Vui lòng nhập email hợp lệ.');
                isValid = false;
            }

            if ($('.userPhone').val() == '') {
                $('.userPhone').next('.error-message').html('Vui lòng nhập số điện thoại.');
                isValid = false;
            }

            if ($('.userAvt').val() == '') {
                $('.userAvt').next('.error-message').html('Vui lòng chọn ảnh đại diện.');
                isValid = false;
            }

            if ($('.userPass').val() == '') {
                $('.passErr').html('Vui lòng nhập mật khẩu.');
                isValid = false;
            } else {
                const userPassValue = $('.userPass').val();

                if (userPassValue && userPassValue.split('').length < 8) {
                    $('.passErr').text('Mật khẩu phải có ít nhất 8 ký tự.');
                    isValid = false;
                }

                if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/.test(userPassValue)) {
                    $('.passErr').text('Mật khẩu phải chứa ít nhất một chữ cái in hoa, một chữ cái in thường và một số.');
                    isValid = false;
                }
            }

            let birthDate = new Date($('.userBirth').val());
            let age = new Date().getFullYear() - birthDate.getFullYear();
            if ($('.userBirth').val() == '') {
                $('.userBirth').next('.error-message').html('Vui lòng chọn ngày sinh và người dùng phải đủ 18 tuổi.');
                isValid = false;
            } else if (age < 18) {
                $('.userBirth').next('.error-message').html('Bạn phải đủ 18 tuổi.');
                isValid = false;
            }

            if ($('.province').val() == '') {
                $('.error-message-province').html('Vui lòng chọn tỉnh/thành phố.');
                isValid = false;
            }

            if ($('.districts').val() == '') {
                $('.error-message-districts').html('Vui lòng chọn quận/huyện.');
                isValid = false;
            }

            if ($('.wards').val() == '') {
                $('.error-message-wards').html('Vui lòng chọn phường/xã.');
                isValid = false;
            }

            if ($('.input_address').val() == '') {
                $('.input_address').next('.error-message').html('Vui lòng nhập tên đường/tòa nhà/số nhà.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });

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
            $('.input_address').next('.error-message').html('');
        });

        $('.userName').on('input', function () {
            $('.userName').next('.error-message').html('');
        });

        $('.nameUser').on('input', function () {
            $('.nameUser').next('.error-message').html('');
        });

        $('.userEmail').on('input', function () {
            $('.userEmail').next('.error-message').html('');
        });

        $('.userPhone').on('input', function () {
            $('.userPhone').next('.error-message').html('');
        });

        $('.userAvt').on('input', function () {
            $('.userAvt').next('.error-message').html('');
        });

        $('.userPass').on('input', function () {
            $('.passErr').html('');
        });

        $('.userBirth').on('input', function () {
            $('.userBirth').next('.error-message').html('');
        });
    });

    $(document).ready(function () {
        HT.district();
        HT.ward();
    })

})(jQuery)
