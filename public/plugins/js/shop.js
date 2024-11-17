(function ($) {
    "use strict";

    $(document).ready(function () {
        $("#toggleCategories").on("click", function () {
            var isHidden = $(".hidden-category").is(":hidden");

            if (isHidden) {
                $(".hidden-category").slideDown();
                $(this).text("Ẩn bớt");
            } else {
                $(".hidden-category").slideUp();
                $(this).text("Xem thêm");
            }
        });
    });

    function formatCurrency(value) {
        if (isNaN(value)) return "0đ";
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " đ";
    }

    $(function () {
        let max_price = $('.maxPrice').attr('data-maxPrice');

        let pro = $('.maxPrice').attr('data-filpro');

        function getParameterByName(name) {
            let url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        let filMax_price = getParameterByName('max_price');
        let filMin_price = getParameterByName('min_price');

        var initialMaxPrice = max_price ? parseInt(max_price) : 0;

        var minPrice = filMin_price ? parseInt(filMin_price) : 0;
        var maxPrice = filMax_price ? parseInt(filMax_price) : initialMaxPrice;


        if (typeof pro === 'undefined') {
            minPrice = filMin_price;
            maxPrice = filMax_price;
        }

        $("#slider-range").slider({
            range: true,
            min: 0,
            max: initialMaxPrice,
            values: [minPrice, maxPrice],
            slide: function (event, ui) {
                $("#amount").val(formatCurrency(ui.values[0]) + " - " + formatCurrency(ui.values[1]));
                $("#min-price").val(ui.values[0]);
                $("#max-price").val(ui.values[1]);
            }
        });

        $("#amount").val(formatCurrency($("#slider-range").slider("values", 0)) + " - " + formatCurrency($("#slider-range").slider("values", 1)));
        $("#min-price").val($("#slider-range").slider("values", 0));
        $("#max-price").val($("#slider-range").slider("values", 1));
    });

})(jQuery);
