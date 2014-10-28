jQuery(function($) {

    function resize() {
        var windowHeight = $(window).height();
        $('.full-height, .full iframe').each(function(){
            var $this = $(this);
            $this.height(windowHeight - $this.offset().top - 100);
        });
    }

    resize();

    // Setup events
    $(window).resize(resize);

    $('[data-toggle=tab]').on('shown', resize);
});