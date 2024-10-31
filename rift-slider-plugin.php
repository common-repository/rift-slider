<?php

require_once('includes/lib/base/class-plugin-base.php');
require_once('includes/rift-slider-admin-menu-pages.php');


/**
 * Description of Plugin
 *
 * @author Ryan Haworth
 * @
 */
if (!class_exists('rift_slider_plugin')) {

    class rift_slider_plugin extends rift_slider_plugin_base {

        /**
         * The plugin constructor goes here.
         * 
         * @param type $plugin_name
         * @param type $plugin_text_domain
         * @param type $plugin_option_prefix
         * @param type $plugin_version
         * @return void
         */
        public function __construct($plugin_name, $plugin_text_domain, $plugin_option_prefix, $plugin_version) {

            $this->pluginName = $plugin_name;
            $this->pluginTextDomain = $plugin_text_domain;
            $this->pluginOptionPrefix = $plugin_option_prefix;
            $this->pluginVersion = $plugin_version;
            
            add_action('admin_menu', array(&$this, 'add_admin_menu'));
        }

        /**
         * Use this function to install the database tables for the
         * plugin.  
         * @return void
         */
        public function install_database_tables() {
            
        }

        /**
         * Use this function to install default options for the plugin.
         * @return void
         */
        public function install_options() {

            $prefix = SYNTH_RIFT_SLIDER_OPT;

            update_option($prefix . 'transition_speed', '800');
            update_option($prefix . 'slice_opacity', 'false');
            update_option($prefix . 'translation_factor', '230');
            update_option($prefix . 'max_angle', '25');
            update_option($prefix . 'max_scale', '2');
            update_option($prefix . 'autoplay', 'false');
            update_option($prefix . 'keyboard_navigation', 'false');
            update_option($prefix . 'time_interval', '4000');
        }

        /**
         * This function will be called when the plugin is upgraded.
         * @return void
         */
        public function upgrade() {
            
        }

        /**
         * Add any action and filters which need to be registered for the
         * plugin here.  This function will be run for each user request.
         * @return void
         */
        public function add_actions_and_filters() {

            if ($this->is_installed()) {

                // Add Actions & Filters
                add_action('admin_enqueue_scripts', array(&$this, 'admin_scripts'));
                add_action('wp_enqueue_scripts', array(&$this, 'frontend_scripts'));

                add_image_size('slider-large-thumbnail', 1024, 600);
                add_image_size('slider-small-thumbnail', 512, 300);

                require_once('includes/rift-slider-post-types.php');
                require_once('includes/rift-slider-post-metaboxes.php');
                require_once('includes/rift-slider-post-tinymce.php');

                // Register short codes
                include_once('includes/rift-slider-shortcodes.php');
            }
        }

        /**
         * Add the admin menus.
         * @return void
         */
        public function add_admin_menu() {

            add_submenu_page('edit.php?post_type=rift_slide', __('Slider Settings', SYNTH_RIFT_SLIDER_DOMAIN), __('Slider Settings', SYNTH_RIFT_SLIDER_DOMAIN), 'manage_options', 'rift-slider-settings', 'rift_slider_settings_page');
        }

        /**
         * Add any script files for the admin section here.
         * 
         * @global type $wp_version
         * @global type $post
         * @param type $hook
         * @return void
         */
        public function admin_scripts($hook) {

            global $wp_version;
            global $post;

            wp_register_script('jquery-validation', plugins_url('includes/lib/validation/js/jquery.validate.min.js', __FILE__), array('jquery'), null, true);

            if ($hook === 'post.php' || $hook === 'post-new.php' && $post->post_type === 'rift_slide') {

                $script_array = array('jquery');

                if (3.6 <= $wp_version) {
                    $script_array[] = 'wp-color-picker';
                    $style_array[] = 'wp-color-picker';
                } else {
                    // otherwise use the older 'farbtastic'
                    $script_array[] = 'farbtastic';
                    $style_array[] = 'farbtastic';
                }

                wp_enqueue_style('rift-slider-admin-style', plugins_url('/css/admin-style.css', __FILE__), $style_array);

                wp_enqueue_script('jquery-validation');
                wp_enqueue_script('syntaxthemes-rift-slider-post', plugins_url('/js/syntaxthemes-rift-slider-post.js', __FILE__), $script_array, null, true);
            }

            //Example adding a script & style just for the options administration page
            if ($hook === 'rift_slide_page_rift-slider-settings' && $hook === 'post-new.php' && $post->post_type === 'rift_slide') {

                wp_enqueue_script('jquery-validation');
                wp_enqueue_script('syntaxstudio-ui-custom', plugins_url('/js/syntaxstudio-ui-custom.js', __FILE__), array('jquery'), null, true);

                $translation_array = array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                );

                wp_localize_script('syntaxstudio-ui-custom', 'synth_ajax_vars', $translation_array);
            }
        }

        /**
         * Add any script files required for the website frontend here.
         * @return void
         */
        public function frontend_scripts() {

            // Adding scripts & styles to all pages on the frontend
            wp_enqueue_style('rift-slider-style', plugins_url('/css/style.css', __FILE__));
        }

    }

}
?>