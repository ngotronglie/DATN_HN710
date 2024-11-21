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
                    alert('Vui lòng chọn ít nhất một mục');
                    return;
                }

                let option = {
                    'id': id,
                    '_token': token
                };
                console.log(option);


                $.ajax({
                    type: 'DELETE',
                    url: '/notification/ajax/deleteNoti', // URL cần khớp với route
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        
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

    $(document).ready(function () {
        HT.deleteall();
    });

})(jQuery);
