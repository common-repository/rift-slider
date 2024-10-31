<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!class_exists('rift_slider_shortcode')) {

    class rift_slider_shortcode extends rift_slider_shortcode_script_loader {

        static $added_already = false;

        public function handle_shortcode($atts, $content = null) {

            $html = '';
            $nav_items = '';
            $prefix_opt = SYNTH_RIFT_SLIDER_OPT;

            $global_speed = get_option($prefix_opt . 'transition_speed');
            $global_opacity = get_option($prefix_opt . 'slice_opacity');
            $global_autoplay = get_option($prefix_opt . 'autoplay');

            $data = shortcode_atts(array(
                'carousel' => 'undefined',
                'speed' => $global_speed,
                'opacity' => $global_opacity,
                'autoplay' => $global_autoplay,
                'width' => 'auto',
                'height' => '400'
                    ), $atts);

            $index = 0;
            $prefix = SYNTH_RIFT_SLIDER_META;
            $carousel = $data['carousel'];

            $speed = $data['speed'];
            $width = $data['width'];
            $height = $data['height'];
            $opacity = $data['opacity'];
            $autoplay = $data['autoplay'];

            $html .= '<div class="synth-rift-slider" data-width="' . $width . '" data-height="' . $height . '" data-speed="' . $speed . '" data-opacity="' . $opacity . '" data-autoplay="' . $autoplay . '">';

            $query = array(
                'post_type' => 'rift_slide',
                'carousel' => $carousel
            );

            $wp_query = new WP_Query();
            $wp_query->query($query);

            if ($wp_query->have_posts()) {

                while ($wp_query->have_posts()) {
                    $wp_query->the_post();

                    $slider_image_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID(), 'slider-large-thumbnail'));

                    //slide styling
                    $title_font_size = get_post_meta(get_the_ID(), $prefix . 'title_font_size', true);
                    $title_color = get_post_meta(get_the_ID(), $prefix . 'title_color', true);
                    $title_bg_color = get_post_meta(get_the_ID(), $prefix . 'title_bg_color', true);
                    $title_overlay = get_post_meta(get_the_ID(), $prefix . 'title_trans_overlay', true);

                    $excerpt_font_size = get_post_meta(get_the_ID(), $prefix . 'excerpt_font_size', true);
                    $excerpt_color = get_post_meta(get_the_ID(), $prefix . 'excerpt_color', true);
                    $excerpt_bg_color = get_post_meta(get_the_ID(), $prefix . 'excerpt_bg_color', true);
                    $excerpt_overlay = get_post_meta(get_the_ID(), $prefix . 'excerpt_trans_overlay', true);

                    //slide text positioning
                    $text_positioning = get_post_meta(get_the_ID(), $prefix . 'text_positioning', true);

                    //slide transformations
                    $rift_orientation = get_post_meta(get_the_ID(), $prefix . 'orientation', true);
                    $rift_rotation_1 = get_post_meta(get_the_ID(), $prefix . 'rotation_1', true);
                    $rift_rotation_2 = get_post_meta(get_the_ID(), $prefix . 'rotation_2', true);
                    $rift_scale_1 = get_post_meta(get_the_ID(), $prefix . 'scale_1', true);
                    $rift_scale_2 = get_post_meta(get_the_ID(), $prefix . 'scale_2', true);

                    $title_class = ($title_overlay !== '') ? (' ' . $title_overlay . '-overlay') : '';
                    $excerpt_class = ($excerpt_overlay !== '') ? (' ' . $excerpt_overlay . '-overlay') : '';

                    $title_padding = '';
                    $excerpt_padding = '';

                    if (strlen($title_bg_color) > 1) {
                        $title_padding = 'padding: 2.4% 1.2%;';
                    }
                    if (strlen($excerpt_bg_color) > 1) {
                        $excerpt_padding = 'padding: 0.6% 1.2%;';
                    }

                    $title_style = sprintf('style="font-size: %1$s; color: %2$s; background-color: %3$s; %4$s"', $title_font_size, $title_color, $title_bg_color, $title_padding);
                    $excerpt_style = sprintf('style="font-size: %1$s; color: %2$s; background-color: %3$s; %4$s"', $excerpt_font_size, $excerpt_color, $excerpt_bg_color, $excerpt_padding);

                    //create the slide items
                    $html .= '<div class="sl-slider">

                                <div class="sl-slide" data-orientation="' . $rift_orientation . '" data-slice1-rotation="' . $rift_rotation_1 . '" data-slice2-rotation="' . $rift_rotation_2 . '" data-slice1-scale="' . $rift_scale_1 . '" data-slice2-scale="' . $rift_scale_2 . '">
                                        <div class="sl-slide-inner">
                                                <div class="bg-img bg-img-1" style="background-image: url(' . $slider_image_url . ')"></div>
                                                <div class="sl-slide-inner-content ' . $text_positioning . '">                                                    
                                                    <div>
                                                        <h2 class="slide-title' . $title_class . '" ' . $title_style . '>
                                                            <a href="' . get_permalink() . '">' . get_the_title() . '</a>
                                                        </h2>
                                                    </div>
                                                    <div class="slide-content ' . $excerpt_class . '">                                                 
                                                        <p ' . $excerpt_style . '">' . get_the_excerpt() . '</p>
                                                        <cite class="slide-cite">' . get_the_author() . '</cite>                                                
                                                    </div>
                                                </div>
                                        </div>
                                </div>
                                
                        </div><!-- /sl-slider -->';
                                        
                    if ($index === 0) {
                        $nav_items .= '<span class="nav-dot-current"></span>';
                    } else {
                        $nav_items .= '<span></span>';
                    }
                    $index++;
                }
            }
            //reset the query so the the posts are not output by other templates.
            //wp_reset_query();

            $html .= '<nav class="nav-dots">' . $nav_items . '</nav>
                  </div><!-- /slider-wrapper -->';

            return $html;
        }

        public function add_script() {

            if (!$this->added_already) {

                $this->added_already = true;

                wp_register_script('modernizr', plugins_url('/js/modernizr.custom.79639.js', dirname(__FILE__)), array('jquery'), false, true);
                wp_enqueue_script('modernizr');

                wp_register_script('jquery-ba-cond-min', plugins_url('/js/jquery.ba-cond.min.js', dirname(__FILE__)), array('jquery'), false, true);
                wp_enqueue_script('jquery-ba-cond-min');

                wp_register_script('jquery-slitslider', plugins_url('/js/jquery.slitslider.js', dirname(__FILE__)), array('jquery'), false, true);
                wp_enqueue_script('jquery-slitslider');

                wp_register_script('syntaxstudio-ui-slit-slider', plugins_url('/js/syntaxstudio-ui-slit-slider.js', dirname(__FILE__)), array('jquery'), false, true);
                wp_enqueue_script('syntaxstudio-ui-slit-slider');

                $prefix = SYNTH_RIFT_SLIDER_OPT;
                $transition_speed = get_option($prefix . 'transition_speed');
                $slider_opacity = get_option($prefix . 'slice_opacity');
                $translation_factor = get_option($prefix . 'translation_factor');
                $max_angle = get_option($prefix . 'max_angle');
                $max_scale = get_option($prefix . 'max_scale');
                $autoplay = get_option($prefix . 'autoplay');
                $keyboard_navigation = get_option($prefix . 'keyboard_navigation');
                $time_interval = get_option($prefix . 'time_interval');

                $translation_array = array(
                    'speed' => $transition_speed,
                    'opacity' => $slider_opacity,
                    'translate_factor' => $translation_factor,
                    'max_angle' => $max_angle,
                    'max_scale' => $max_scale,
                    'autoplay' => $autoplay,
                    'keyboard' => $keyboard_navigation,
                    'interval' => $time_interval
                );

                wp_localize_script('syntaxstudio-ui-slit-slider', 'rift_js_vars', $translation_array);
            }
        }

    }

    $rift_slider_sc = new rift_slider_shortcode();
    $rift_slider_sc->register('rift_slider');
}
?>