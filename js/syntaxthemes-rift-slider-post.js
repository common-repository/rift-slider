/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function() {

    /**
     * Initialize image radio buttons
     */
    image_radio_configuration();

    /**
     * Initialize color picker
     */
    if (typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function') {
        jQuery('input:text.synth-colorpicker').wpColorPicker();
    } else {
        jQuery('input:text.synth-colorpicker').each(function(i) {
            jQuery(this).after('<div id="picker-' + i + '" style="z-index: 1000; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>');
            jQuery('#picker-' + i).hide().farbtastic(jQuery(this));
        })
                .focus(function() {
            jQuery(this).next().show();
        })
                .blur(function() {
            jQuery(this).next().hide();
        });
    }

    /**
     * Rift Slider post handler
     */
    var post_form = jQuery('#post');
    post_form.validate();
    jQuery('#publish').click(function() {

        if (!post_form.valid()) {

            //remove the spinner 
            jQuery('#publishing-action .spinner').css('display', 'none');
            jQuery('#publishing-action #publish').removeClass('button-primary-disabled');
        }
    });
});

function image_radio_configuration(){

    jQuery('.synth-image-radio-inline img').live('click', function(){   
        
        jQuery('.synth-image-radio-inline img').each(function() {
            
            jQuery(this).removeClass('selected');
        });
            
        jQuery(this).addClass('selected');
    });
}


