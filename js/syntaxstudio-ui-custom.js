
jQuery(document).ready(function() {

    jQuery('#select_carousel').change(onCarouselSelectionChanged);
    
    jQuery("#synth_rift_slider_global_form").validate();
   
});

function onCarouselSelectionChanged() {

    $taxonomy_id = jQuery('#select_carousel option:selected').val();

    jQuery.ajax({
        type: 'POST',
        url: synth_ajax_vars.ajax_url,
        data: {
            action: 'synth_rift_slider_get_carousel_settings',
            taxonomy_id: $taxonomy_id
        },
        success: function(data) {

            jQuery('.carousel-settings').html(data);
        },
        error: function() {

        }
    });
}


