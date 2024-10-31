<?php

if (!function_exists('rift_slider_init_meta_boxes')) {

    function rift_slider_init_meta_boxes() {
        if (!class_exists('rift_slider_custom_meta_box')) {
            require_once( 'lib/metaboxes/class-custom-meta-box.php' );
        }
    }

    add_action('init', 'rift_slider_init_meta_boxes', 9999);
}

if (!function_exists('rift_slider_metaboxes')) {

    function rift_slider_metaboxes($meta_boxes) {

        $prefix = SYNTH_RIFT_SLIDER_META; // Prefix for all fields
        $prefix_global = SYNTH_RIFT_SLIDER_OPT;

        $max_angle = get_option($prefix_global . 'max_angle');
        $max_scale = get_option($prefix_global . 'max_scale');

        $meta_boxes[] = array(
            'id' => 'slider_text_styling_metabox',
            'title' => 'Slide Text Styling',
            'pages' => array('rift_slide'), // post type
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => true, // Show field names on the left
            'fields' => array(
                array(
                    'name' => 'Title Text Size',
                    'desc' => __('Choose the font size for the title.'),
                    'id' => $prefix . 'title_font_size',
                    'type' => 'select',
                    'std' => '100%',
                    'options' => array(
                        array('name' => '130%', 'value' => '130%'),
                        array('name' => '120%', 'value' => '120%'),
                        array('name' => '110%', 'value' => '110%'),
                        array('name' => '100%', 'value' => '100%'),
                        array('name' => '80%', 'value' => '80%'),
                        array('name' => '60%', 'value' => '60%'),
                        array('name' => '40%', 'value' => '40%'),
                        array('name' => '20%', 'value' => '20%'),
                    )
                ),
                array(
                    'name' => 'Title Text Color',
                    'desc' => __('Choose a color for the title.'),
                    'id' => $prefix . 'title_color',
                    'type' => 'colorpicker'
                ),
                array(
                    'name' => 'Title Background Color',
                    'desc' => __('Choose a color for the title background.'),
                    'id' => $prefix . 'title_bg_color',
                    'type' => 'colorpicker'
                ),
                array(
                    'name' => 'Title Transparent Overlay',
                    'desc' => __('Choose an overlay for the title background.'),
                    'id' => $prefix . 'title_trans_overlay',
                    'type' => 'radio-list',
                    'std' => 'none',
                    'display' => 'block',
                    'options' => array(
                        array('name' => $prefix . 'title_trans_overlay', 'value' => 'none', 'text' => 'No Overlay'),
                        array('name' => $prefix . 'title_trans_overlay', 'value' => 'black', 'text' => 'Black Overlay'),
                        array('name' => $prefix . 'title_trans_overlay', 'value' => 'white', 'text' => 'White Overlay')
                    )
                ),
                array(
                    'name' => 'Excerpt Text Size',
                    'desc' => __('Choose the font size for the excerpt.'),
                    'id' => $prefix . 'excerpt_font_size',
                    'type' => 'select',
                    'std' => '100%',
                    'options' => array(
                        array('name' => '130%', 'value' => '130%'),
                        array('name' => '120%', 'value' => '120%'),
                        array('name' => '110%', 'value' => '110%'),
                        array('name' => '100%', 'value' => '100%'),
                        array('name' => '80%', 'value' => '80%'),
                        array('name' => '60%', 'value' => '60%'),
                        array('name' => '40%', 'value' => '40%'),
                        array('name' => '20%', 'value' => '20%'),
                    )
                ),
                array(
                    'name' => 'Excerpt Text Color',
                    'desc' => __('Choose a color for the excerpt.'),
                    'id' => $prefix . 'excerpt_color',
                    'type' => 'colorpicker',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        )
                    )
                ),
                array(
                    'name' => 'Excerpt Background Color',
                    'desc' => __('Choose a color for the excerpt background.'),
                    'id' => $prefix . 'excerpt_bg_color',
                    'type' => 'colorpicker'
                ),
                array(
                    'name' => 'Excerpt Transparent Overlay',
                    'desc' => __('Choose an overlay for the excerpt background.'),
                    'id' => $prefix . 'excerpt_trans_overlay',
                    'type' => 'radio-list',
                    'std' => 'none',
                    'display' => 'block',
                    'options' => array(
                        array('name' => $prefix . 'excerpt_trans_overlay', 'value' => 'none', 'text' => 'No Overlay'),
                        array('name' => $prefix . 'excerpt_trans_overlay', 'value' => 'black', 'text' => 'Black Overlay'),
                        array('name' => $prefix . 'excerpt_trans_overlay', 'value' => 'white', 'text' => 'White Overlay')
                    )
                )
            )
        );

        $meta_boxes[] = array(
            'id' => 'slider_text_positioning_metabox',
            'title' => 'Slide Text Positioning',
            'pages' => array('rift_slide'), // post type
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => true, // Show field names on the left
            'fields' => array(
                array(
                    'name' => 'Slider Layouts',
                    'desc' => __('Choose a layout position for the slider text.'),
                    'id' => $prefix . 'text_positioning',
                    'type' => 'image-radio',
                    'std' => 'top-left',
                    'display' => 'inline',
                    'options' => array(
                        array('name' => $prefix . 'text_positioning', 'value' => 'top-left', 'url' => plugins_url('images/top-left.png', dirname(__FILE__))),
                        array('name' => $prefix . 'text_positioning', 'value' => 'top-right', 'url' => plugins_url('images/top-right.png', dirname(__FILE__))),
                        array('name' => $prefix . 'text_positioning', 'value' => 'center', 'url' => plugins_url('images/center.png', dirname(__FILE__))),
                        array('name' => $prefix . 'text_positioning', 'value' => 'bottom-left', 'url' => plugins_url('images/bottom-left.png', dirname(__FILE__))),
                        array('name' => $prefix . 'text_positioning', 'value' => 'bottom-right', 'url' => plugins_url('images/bottom-right.png', dirname(__FILE__))),
                    )
                )
            )
        );

        $meta_boxes[] = array(
            'id' => 'slide_transformation_metabox',
            'title' => 'Slide Transformations',
            'pages' => array('rift_slide'), // post type
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => true, // Show field names on the left
            'fields' => array(
                array(
                    'name' => 'Slice Orientation',
                    'desc' => __('Choose the direction of slicing the slide.'),
                    'id' => $prefix . 'orientation',
                    'type' => 'select',
                    'options' => array(
                        array('name' => 'Vertical', 'value' => 'vertical'),
                        array('name' => 'Horizontal', 'value' => 'horizontal')
                    ),
                ),
                array(
                    'name' => 'Slice 1 Rotation',
                    'desc' => __('Set the first slice rotation degree.'),
                    'id' => $prefix . 'rotation_1',
                    'std' => '-25',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => $max_angle
                        )
                    )
                ),
                array(
                    'name' => 'Slice 2 Rotation',
                    'desc' => __('Set the second slice rotation degree.'),
                    'id' => $prefix . 'rotation_2',
                    'std' => '25',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => $max_angle
                        )
                    )
                ),
                array(
                    'name' => 'Slice 1 Scale',
                    'desc' => __('Set the first slice scale factor.'),
                    'id' => $prefix . 'scale_1',
                    'std' => '2',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => $max_scale
                        )
                    )
                ),
                array(
                    'name' => 'Slice 2 Scale',
                    'desc' => __('Set the second slice scale factor.'),
                    'id' => $prefix . 'scale_2',
                    'std' => '2',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => $max_scale
                        )
                    )
                )
            )
        );

        return $meta_boxes;
    }

    add_filter('synth_meta_boxes', 'rift_slider_metaboxes');
}
?>