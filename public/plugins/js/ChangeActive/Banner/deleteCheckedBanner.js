(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    HT.deleteall = () => {
        if ($('.deleteAll').length) {
            $(document).on('click', '.deleteAll', function (e) {
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
                $.ajax({
                    type: 'DELETE',
                    url: '/banner/ajax/deleteCheckedBanner',
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        if (res.totalCountAfter > 0) {
                            if (res.status) {
                                swalSuccessAd(res.message);
                                id.forEach(function (deletedId) {
                                    $('input[data-id="' + deletedId + '"]').closest('tr').remove();
                                });
                                $('.countTrash').html('('+res.trashedCount+')');
                                HT.recalculateSTT();
                            }else{
                                swalErrorAd(res.message);
                            }
                        }else{
                            swalSuccessAd(res.message);
                            $('#checkAllTable').prop('checked', false);
                            $('.null_Table').html('<tr><td valign="top" colspan="8" class="dataTables_empty">Không tìm thấy dòng nào phù hợp</td></tr>');
                            $('.countTrash').html('('+res.trashedCount+')');
                        }
                    },
                    error: function (xhr, status, error) {
                        let message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                        alert('Đã xảy ra lỗi: ' + message);
                    }
                });
                e.preventDefault();
            });
        }
    }

    HT.recalculateSTT = () => {
        $('#bootstrap-data-table tbody tr').each(function (index) {
            $(this).find('td').eq(1).text(index + 1);
        });
    }

    $(document).ready(function () {
        HT.deleteall();
    });

})(jQuery);
