<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );

class SH_Walker_TaxonomyDropdown extends Walker_CategoryDropdown {

    function start_el(&$output, $category, $depth, $args) {

        $pad = str_repeat('&nbsp;', $depth * 2);
        $cat_name = apply_filters('list_cats', $category->name, $category);

        if (!isset($args['value'])) {
            $args['value'] = ( $category->taxonomy != 'category' ? 'slug' : 'id' );
        }

        $value = ($args['value'] == 'slug' ? $category->slug : $category->term_id );

        $output .= "\t<option class=\"level-$depth\" data-filter-value=\"$value\"";

        if ($value === (string) $args['selected']) {
            $output .= ' selected="selected"';
        }

        $output .= '>';
        $output .= $pad . $cat_name;

        if ($args['show_count'])
            $output .= '&nbsp;&nbsp;(' . $category->count . ')';

        $output .= "</option>\n";
    }

}
?>
<table class="form-table">
    <tbody>
        <tr>
            <th style="width: 18%">
                <label><span><?php _e('Choose a carousel'); ?></span></label>   
            </th>
            <td>
                <?php
                $args = array(
                    'id' => 'carousel_selector',
                    'walker' => new SH_Walker_TaxonomyDropdown(),
                    'orderby' => 'name',
                    'taxonomy' => 'carousel',
                    'value' => 'slug'
                );
                wp_dropdown_categories($args);
                ?>  
            </td>
        </tr>        
        <tr>
            <th style="width: 18%">
                <label><span><?php _e('Speed'); ?></span></label>  
            </th>
            <td>
                <input id="ctl_speed" type="text"/>
            </td>
        </tr>
        <tr>
            <th style="width: 18%">
                <label><span><?php _e('Slider Width'); ?></span></label> 
            </th>
            <td>
                <input id="ctl_width" type="text"/>  
            </td>
        </tr>
        <tr>
            <th style="width: 18%">
                <label><span><?php _e('Slider Height'); ?></span></label>  
            </th>
            <td>
                <input id="ctl_height" type="text"/>  
            </td>
        </tr>
        <tr>
            <th style="width: 18%">
                <label><span><?php _e('Opacity'); ?></span></label>   
            </th>
            <td>
                <select id="opacity_selector">
                    <option value="false" selected>No</option>
                    <option value="true">Yes</option>
                </select> 
            </td>
        </tr>
        <tr>
            <th style="width: 18%">
                <label><span><?php _e('Autoplay'); ?></span></label>  
            </th>
            <td>
                <select id="autoplay_selector">
                    <option value="false" selected>No</option>
                    <option value="true">Yes</option>
                </select> 
            </td>
        </tr>
        <tr>
            <th style="width: 18%">
            </th>
            <td>
                <input id="submit_button" class="button-primary" type="submit" value="Insert Shortcode"/> 
            </td>
        </tr>  
    </tbody>    
</table>
<script type="text/javascript">
    jQuery(document).ready(function() {

        jQuery('#submit_button').click(function() {

            var carousel = jQuery('#carousel_selector :selected').data('filter-value');
            var speed = jQuery('#ctl_speed').val();
            var autoplay = jQuery('#autoplay_selector :selected').val();
            var opacity = jQuery('#opacity_selector :selected').val();
            var width = jQuery('#ctl_width').val();
            var height = jQuery('#ctl_height').val();

            var content = '[rift_slider carousel="' + carousel + '" ';

            if (speed !== '')
                content += 'speed="' + speed + '" ';

            if (opacity !== '')
                content += 'opacity="' + opacity + '" ';

            if (autoplay !== '')
                content += 'autoplay="' + autoplay + '" ';

            if (width !== '')
                content += 'width="' + width + '" ';

            if (height !== '')
                content += 'height="' + height + '" ';

            content += ']';

            if (window.tinyMCE) {
                window.tinyMCE.activeEditor.selection.setContent(content);
            }
            jQuery('.colorpicker').remove();
            //jQuery('.ui-dialog-titlebar-close').click();
            tb_remove();
        });
    });
</script>

