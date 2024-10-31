(function($, window, document, undefined) {

    $.fn.riftSlider = function() {

        return this.each(function() {

            var width = $(this).data('width');
            var height = $(this).data('height');

            var speed = $(this).data('speed');
            var translate_factor = $(this).data('translatefactor');
            var max_angle = $(this).data('maxangle');
            var max_scale = $(this).data('maxscale');
            var opacity = $(this).data('opacity');
            var autoplay = $(this).data('autoplay');
            var keyboard = $(this).data('keyboard');
            var interval = $(this).data('interval');

            $(this).css('width', width).css('height', height);

            if (typeof speed === 'undefined' || speed === "")
                speed = rift_js_vars.speed;

            if (typeof translate_factor === 'undefined' || translate_factor === "")
                translate_factor = rift_js_vars.translate_factor;

            if (typeof max_angle === 'undefined' || max_angle === "")
                max_angle = rift_js_vars.max_angle;

            if (typeof max_scale === 'undefined' || max_scale === "")
                max_scale = rift_js_vars.max_scale;

            if (typeof keyboard === 'undefined' || keyboard === "")
                keyboard = rift_js_vars.keyboard;

            if (typeof interval === 'undefined' || interval === "")
                interval = rift_js_vars.interval;

            var options = {
                speed: speed,
                translateFactor: translate_factor,
                optOpacity: opacity,
                autoplay: autoplay,
                keyboard: keyboard,
                interval: interval
            };

            var slitSlider = $(this).slitslider(options);

            //set the slider navigation
            var $nav = $(this).find('.nav-dots > span');

            $nav.each(function(i) {

                $(this).on('click', function(e) {

                    var $dot = $(this);

                    if (!slitSlider.isActive()) {

                        $nav.removeClass('nav-dot-current');
                        $dot.addClass('nav-dot-current');

                    }
                    slitSlider.jump(i + 1);
                    
                    e.preventDefault();
                });
            });
        });
    };

})(jQuery, window, document);

jQuery(document).ready(function() {

    jQuery('.synth-rift-slider').riftSlider();
});




