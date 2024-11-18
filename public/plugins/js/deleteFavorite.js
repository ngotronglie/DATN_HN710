(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr('content');
    let mes ='';
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

                    if (res.favoriteItems && res.favoriteItems.length > 0) {
                        $('#cart-' + idFavorite).empty();

                        $('span[data-id="' + id + '"]').closest('tr').remove();

                    } else {

                        $('.remove-favorite').empty();

                        $('#favoriteNull').append('<td colspan="6"><p>Mục yêu thích của bạn hiện đang trống.</p></td>');
                    }
                    mes = res.message;
                    swalSuccess(mes);
                },
                error: function (xhr, status, error) {
                    let hasShownErrorMessage = false;
                    $(document).ajaxError(function (event, xhr) {
                        if (!hasShownErrorMessage && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMessages = xhr.responseJSON.errors;
                            for (let key in errorMessages) {
                                if (errorMessages.hasOwnProperty(key)) {
                                    swalError(errorMessages[key][0]);
                                }
                            }
                            hasShownErrorMessage = true;
                        }
                    });
                }
            });
        })
    }

    $(document).ready(function () {
        HT.deleleFavorite();
    });
})(jQuery);
