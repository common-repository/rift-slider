<?php

/**
 * The idea is you have a shortcode that needs a script loaded, but you only
 * want to load it if the shortcode is actually called.
 * @abstract
 */
if (!class_exists('rift_slider_shortcode_script_loader')) {

    abstract class rift_slider_shortcode_script_loader extends rift_slider_shortcode_loader {

        var $doAddScript;

        public function register($shortcodeName) {

            $this->register_shortcode_to_function($shortcodeName, 'handle_shortcode_wrapper');

            // It will be too late to enqueue the script in the header,
            // but can add them to the footer
            add_action('wp_footer', array($this, 'add_script_wrapper'));
        }

        public function handle_shortcode_wrapper($atts, $content = null) {
            // Flag that we need to add the script
            $this->doAddScript = true;
            return $this->handle_shortcode($atts, $content = null);
        }

        public function add_script_wrapper() {
            // Only add the script if the shortcode was actually called
            if ($this->doAddScript) {
                $this->add_script();
            }
        }

        /**
         * @abstract override this function with calls to insert scripts needed by your shortcode in the footer
         * Example:
         *   wp_register_script('my-script', plugins_url('js/my-script.js', __FILE__), array('jquery'), '1.0', true);
         *   wp_print_scripts('my-script');
         * @return void
         */
        public abstract function add_script();
    }

}