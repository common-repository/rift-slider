<?php

/**
 * Description of tiny-mce-manager-class
 *
 * @author Ryan Haworth
 */
if (!class_exists('rift_slider_tiny_mce_manager')) {

    class rift_slider_tiny_mce_manager {

        public function __construct() {

            add_action('admin_init', array(&$this, 'enqueue_scripts'));

            add_action('init', array(&$this, 'tinymce_init'));
        }

        public function enqueue_scripts() {

            wp_enqueue_script('tmce-rift-slider-plugin', plugins_url('tmce-rift-slider-plugin.js', __FILE__), array('jquery', 'tinymce'));
        }

        public function tinymce_init() {

            if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
                return;

            if (get_user_option('rich_editing') == 'true') {
                add_filter('mce_external_plugins', array(&$this, 'tinymce_plugins'));
                add_filter('mce_buttons', array(&$this, 'tinymce_buttons'));
            }
        }

        function tinymce_plugins($plugin_array) {

            $plugin_array['riftslider_button'] = plugins_url('tmce-rift-slider-plugin.js', __FILE__);
            return $plugin_array;
        }

        function tinymce_buttons($buttons) {

            array_push($buttons, "|", 'add_carousel_button');
            return $buttons;
        }

    }

}
?>
