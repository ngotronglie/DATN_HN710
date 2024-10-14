(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    var alertTimeout;

    // Thay đổi trạng thái danh mục đã chọn
    HT.changeall = () => {
        if ($('.activeAll').length) {

            $(document).on('click', '.activeAll', function (e) {
                e.preventDefault();

                let _this = $(this);
                let id = [];
                $('.checkBoxItem').each(function () {
                    let checkbox = $(this);
                    if (checkbox.prop('checked')) {
                        id.push(checkbox.attr('data-id'));
                    }
                });

                if (id.length == 0) {
                    // Thông báo cho người dùng rằng họ chưa chọn mục nào
                    alert('Vui lòng chọn ít nhất một mục');
                    return;
                }

                let option = {
                    'id': id,
                    'is_active': _this.attr('data-is_active'), // Trạng thái muốn thay đổi
                    '_token': token
                };

                $.ajax({
                    type: 'POST',
                    url: 'categories/ajax/changeAllActiveCategory', // URL xử lý yêu cầu
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        if (res.status) {
                            id.forEach(function (itemId) {
                                let switchInput = $('input[data-modelId="' + itemId + '"]');
                                let switcheryElement = switchInput[0].switchery;  // Lấy đối tượng Switchery hiện tại

                                // Cập nhật trạng thái mới cho checkbox
                                if (res.newStatus == 1) {
                                    switchInput.prop('checked', true);  // Kích hoạt checkbox
                                } else {
                                    switchInput.prop('checked', false); // Hủy kích hoạt checkbox
                                }

                                //Cập nhật lại data-model
                                switchInput.attr('data-model', res.newStatus);

                                // Cập nhật giao diện của Switchery
                                switcheryElement.setPosition();  // Cập nhật vị trí của nút gạt
                                // switcheryElement.handleOnchange();  // Gọi hàm để cập nhật giao diện và xử lý sự kiện
                            });
                            showAlert('Cập nhật trạng thái '+res.updatedCount+' danh mục thành công!', 'success');
                        } else {
                            alert('Cập nhật thất bại: ' + res.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        let message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                        alert('Đã xảy ra lỗi: ' + message);
                        console.error('Error:', error);
                        console.error('XHR:', xhr);
                        console.error('Status:', xhr.status);
                        console.error('Response Text:', xhr.responseText);
                        console.error('Status Description:', status);
                    }
                });

            });
        }
    }

    function showAlert(message, type) {
        let alertContainer = $('#alert-container');

        if (alertTimeout) {
            clearTimeout(alertTimeout);
        }

        alertContainer.removeClass('d-none alert-success alert-danger');
        alertContainer.addClass('alert-' + type);
        alertContainer.html(message);

        alertTimeout = setTimeout(function () {
            alertContainer.addClass('d-none');
        }, 5000);
    }

    $(document).ready(function () {
        HT.changeall();
    });

})(jQuery);
