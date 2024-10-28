(function ($) {
    //    "use strict";


    /*  Data Table
    -------------*/


    // $('#bootstrap-data-table').DataTable({
    //     lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
    // });


    $(document).ready(function () {
        // Khởi tạo DataTable
        var table = $('#bootstrap-data-table').DataTable({
            lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
            stateSave: true,
            columnDefs: [
                { orderable: false, targets: 0 } // Vô hiệu hóa sắp xếp cho cột đầu tiên (checkbox)
            ],
            language: {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Hiển thị _MENU_ mục",
                "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
                "sInfo":         "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Hiển thị 0 đến 0 của 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "Tìm kiếm:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "Trước",
                    "sNext":     "Tiếp",
                    "sLast":     "Cuối"
                }
            },

            // Sự kiện khi DataTable được vẽ lại (ví dụ khi phân trang)
            drawCallback: function () {
                // Lấy tất cả các phần tử checkbox có class .js-switch
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                // Khởi tạo Switchery cho từng checkbox
                elems.forEach(function (html) {
                    // Kiểm tra nếu Switchery chưa được khởi tạo
                    if (!html.switchery) {
                        html.switchery = new Switchery(html, { color: '#1AB394' });
                    }
                });
                $('.checkBoxItem').prop('checked', false);
                $('#checkAllTable').prop('checked', false);
                $('tbody tr').removeClass('active-check');
            }
        });

        // Khởi tạo Switchery khi trang đầu tiên tải
        document.addEventListener('DOMContentLoaded', function () {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function (html) {
                new Switchery(html, { color: '#1AB394' });
            });
        });
    });




    $('#bootstrap-data-table-export').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $('#row-select').DataTable({
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });






})(jQuery);