(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');

    let idFavorite = null;

    HT.deleleFavorite = () => {
        $('.deleteFavorite').click(function () {

            let id = $(this).attr('data-id');
            idFavorite = id;

            let option = {
                'id': id,
                '_token': token
            }
            $.ajax({
                type: 'DELETE',
                url: '/ajax/deleteToFavorite',
                data: option,
                dataType: 'json',
                success: function (res) {
                    console.log(res);

                    if (res.favoriteItems && res.favoriteItems.length > 0) {
                        $('#cart-' + idFavorite).empty();

                        $('span[data-id="' + id + '"]').closest('tr').remove();

                    } else {

                        $('.remove-favorite').empty();

                        $('#favoriteNull').append('<td colspan="6"><p>Mục yêu thích của bạn hiện đang trống.</p></td>');
                    }
                    swal({
                        content: {
                            element: "span",
                            attributes: {
                                innerHTML: `<h1 style='font-size: 1.3rem;margin-top: 33px'>${res.message}</h1>`,
                            },
                        },
                        text: "",
                        icon: "success",
                        button: "Đóng",
                    });

                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });

        })
    }

    $(document).ready(function () {
        HT.deleleFavorite();
    });
})(jQuery);
