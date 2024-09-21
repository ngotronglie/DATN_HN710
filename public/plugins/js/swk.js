(function($) {
    "use strict";
    var HT = {};

    HT.swcr = () => {
        $('.js-switch').each(function() {
            var switchery = new Switchery(this, { color: '#1AB394' });
        });
    };
    

    $(document).ready(function () {
        HT.swcr();
    });

})(jQuery);
