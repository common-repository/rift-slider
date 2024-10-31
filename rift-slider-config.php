<?php

/**
 * Description of rift-slider-config
 *
 * @author Ryan Haworth
 */
if (!class_exists('rift_slider_config')) {

    class rift_slider_config {

        public $version;
        public $php_version;
        public $plugin_name;
        public $plugin_url;
        public $plugin_path;
        public $text_domain;
        public $plugin_prefix;
        public $short_prefix;
        public $class_prefix;

        public function __construct() {

            $this->version = '1.1.19';
            $this->php_version = '5.3';
            $this->wordpress_version = '3.5';
            $this->plugin_name = 'rift_slider';
            $this->plugin_url = plugins_url(__FILE__);
            $this->plugin_path = plugin_dir_path(__FILE__);
            $this->text_domain = 'synth_rift_slider_textdomain_';
            $this->plugin_prefix = 'rift_slider_';
            $this->short_prefix = 'synth_';
            $this->class_prefix = 'synth-';
        }

    }

    /**
     * Initialize the recruitment plugin config.
     */
    $GLOBALS['rift_slider_config'] = new rift_slider_config();
}
?>
