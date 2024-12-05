(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    HT.deleteall = () => {
        if ($('.deleteAll').length) {
            $(document).on('click', '.deleteAll', function (e) {
                e.preventDefault();

                let id = [];
                $('.checkBoxItem').each(function () {
                    let checkbox = $(this);
                    if (checkbox.prop('checked')) {
                        id.push(checkbox.attr('data-id'));
                    }
                });

                if (id.length === 0) {
                    swalErrorAd('Vui lòng chọn ít nhất một mục');
                    return;
                }

                let option = {
                    'id': id,
                    '_token': token
                };

                $.ajax({
                    type: 'DELETE',
                    url: '/notification/ajax/deleteNoti', // URL cần khớp với route
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        swalSuccessAd(res.message);
                        $('.coutNotiUnRead').html(res.count);
                        id.forEach(function (deletedId) {
                            $('#removeTr-' + deletedId).empty();
                        });
                    },
                    error: function (xhr, status, error) {
                        let message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                        alert('Đã xảy ra lỗi: ' + message);
                    }
                });
            });
        }
    }

    HT.deleteNotiChecked = () => {
        $(document).on('click', '.deleteNotiRead', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Bạn có chắc chắn',
                text: "Hành động này sẽ xóa tất cả các thông báo đã đọc",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "http://datn_hn710.test/admin/deleteNoticationRead";
                }
            });
        });
    }


    HT.deleteNotiAll = () => {
        $(document).on('click', '.deleteNotiAll', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Bạn có chắc chắn',
                text: "Hành động này sẽ xóa tất cả thông báo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "http://datn_hn710.test/admin/deleteAllNoti";
                }
            });
        });

    }

    $(document).ready(function () {
        HT.deleteall();
        HT.deleteNotiChecked();
        HT.deleteNotiAll();
    });

})(jQuery);
