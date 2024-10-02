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
                    alert('Vui lòng chọn ít nhất một mục');
                    return;
                }

                let option = {
                    'id': id,
                    '_token': token
                };

                $.ajax({
                    type: 'DELETE',
                    url: '/admin/categoryBlogs/ajax/deleteAllCategoryBlog',
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        if (res.status) {
                            alert(res.message);

                            id.forEach(function (deletedId) {
                                $('input[data-id="' + deletedId + '"]').closest('tr').remove();
                            });

                            $.ajax({
                                type: 'GET',
                                url: '/admin/categoryBlogs/ajax/trashedCount',
                                dataType: 'json',
                                success: function (res) {
                                    if (res.trashedCount !== undefined) {
                                        // Cập nhật số lượng trong nút "Thùng rác"
                                        $('.countTrash').html('<i class="fa fa-trash"></i> Thùng rác (' + res.trashedCount + ')');
                                    }
                                    return false;
                                },
                                error: function (xhr, status, error) {
                                    alert('Đã xảy ra lỗi khi cập nhật số lượng thùng rác.');
                                    return false;

                                }
                            });

                            //cập nhật lại key(số thứ tự)
                            HT.recalculateSTT();
                        } else {
                            alert('Xóa không thành công.');
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

    //cập nhật lại key(số thứ tự)
    HT.recalculateSTT = () => {
        $('#bootstrap-data-table tbody tr').each(function (index) {
            $(this).find('td').eq(1).text(index + 1); // Cập nhật lại STT (index bắt đầu từ 0, nên +1)
        });
    }

    $(document).ready(function () {
        HT.deleteall();
    });

})(jQuery);
