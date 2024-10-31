<?php
if (!function_exists('rift_slider_settings_page')) {

    function rift_slider_settings_page() {

        $prefix = SYNTH_RIFT_SLIDER_OPT;

        $options = array(
            'id' => 'slider_transformation_metabox',
            'title' => 'Slider Transformations',
            'pages' => array('rift_slide'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
            'page' => 'rift-slider-settings',
            'action' => 'update',
            'fields' => array(
                array(
                    'name' => 'Transition Speed',
                    'desc' => 'The slider transition speed between each slide.',
                    'id' => $prefix . 'transition_speed',
                    'std' => '2000',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => '10000'
                        )
                    )
                ),
                array(
                    'name' => 'Slice Opacity',
                    'desc' => 'If true the slides will animate a transparency effect.',
                    'id' => $prefix . 'slice_opacity',
                    'std' => 'false',
                    'type' => 'select',
                    'options' => array(
                        array('name' => 'Yes', 'value' => 'true'),
                        array('name' => 'No', 'value' => 'false'),
                    ),
                ),
                array(
                    'name' => 'Translation Factor',
                    'desc' => 'The amount in (%) to translate both slides around the angle.',
                    'id' => $prefix . 'translation_factor',
                    'std' => '230',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => '360'
                        )
                    )
                ),
                array(
                    'name' => 'Maximum Angle',
                    'desc' => 'The maximum translation factor value.',
                    'id' => $prefix . 'max_angle',
                    'std' => '25',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => '25'
                        )
                    )
                ),
                array(
                    'name' => 'Maximum Scale',
                    'desc' => 'The maximum scale factor value.',
                    'id' => $prefix . 'max_scale',
                    'std' => '2',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => '5'
                        )
                    )
                ),
                array(
                    'name' => 'Autoplay',
                    'desc' => 'Set to yes to autoplay the slideshow.',
                    'id' => $prefix . 'autoplay',
                    'std' => 'false',
                    'type' => 'select',
                    'options' => array(
                        array('name' => 'Yes', 'value' => 'true'),
                        array('name' => 'No', 'value' => 'false'),
                    )
                ),
                array(
                    'name' => 'Keyboard Navigation',
                    'desc' => 'Set to yes to use keyboard navigation.',
                    'id' => $prefix . 'keyboard_navigation',
                    'std' => 'false',
                    'type' => 'select',
                    'options' => array(
                        array('name' => 'Yes', 'value' => 'true'),
                        array('name' => 'No', 'value' => 'false'),
                    )
                ),
                array(
                    'name' => 'Slider Time Interval',
                    'desc' => 'The interval time between the slide transitions.',
                    'id' => $prefix . 'time_interval',
                    'std' => '4000',
                    'type' => 'text',
                    'validations' => array(
                        array(
                            'type' => 'required'
                        ),
                        array(
                            'type' => 'number',
                            'min' => '0',
                            'max' => '10000'
                        )
                    )
                )
            )
        );

        update_option($prefix, $options);

        $rift_slider_settings = new rift_slider_options_generator($prefix, 'synth_rift_slider_global_form', $options);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $page = $_POST['page'];
            $action = $_POST['action'];

            if (!empty($_POST['page']) && !empty($_POST['action']) && $_POST['page'] == 'rift-slider-settings' && $_POST['action'] == 'update') {

                $rift_slider_settings->save_options();

                echo '<div class="updated fade">' .
                __('Your settings have been saved.', SYNTH_RIFT_SLIDER_DOMAIN) .
                '</div>';
            }
        }
        ?>
        <div class="wrap">
            <div id="icon-tools" class="icon32"></div>
            <h2>Rift Slider Settings</h2>
            <p>
                The following settings are global settings for the Rift Slider.  These will help set any
                initial default settings for the slider control.
            </p>
            <h3 class="title">
                Global Rift Slider Settings
            </h3>
            <?php $rift_slider_settings->render($options) ?>
        </div>

        <?php
    }

}
?>
