<?php

require_once('includes/includes.php');
require_once('rift-slider-plugin.php');

/**
 * Initialize class.
 */
if (!class_exists('rift_slider_initialize')) {

    class rift_slider_initialize {

        private $_core;
        private $_plugin;

        /**
         * The Initialize constructor.
         * 
         * @param type $plugin_name
         * @param type $plugin_text_domain
         * @param type $plugin_option_prefix
         * @param type $plugin_version
         */
        public function __construct($plugin_name, $plugin_text_domain, $plugin_option_prefix, $plugin_version) {

            $this->_core = new rift_slider_core();
            $this->_plugin = new rift_slider_plugin($plugin_name, $plugin_text_domain, $plugin_option_prefix, $plugin_version);
        }

        /**
         * The activate function is called when the plugin is activated.
         * @return void
         */
        public function activate() {

            global $rift_slider_config;

            $dir = ABSPATH . 'wp-content/plugins/rift-slider';
            //$this->delete_lite_version($dir);
            // Next, run the version check.
            // If it is successful, continue with initialization for this plugin
            if ($this->_core->php_version_check()) {

                if (!$this->_plugin->is_installed()) {
                    $this->_plugin->activate();
                } else {
                    // Perform any version-upgrade activities prior to activation (e.g. database changes)
                    $this->_plugin->upgrade();
                }
            } else {
                $this->_plugin->deactivate();
            }
        }

        /**
         * The deactivate function is called when the plugin is deactivated.
         * @return void
         */
        public function deactivate() {

            $this->_plugin->deactivate();
        }

        function check_auto_update() {

            $plugin_current_version = $this->_plugin->pluginVersion;
            $plugin_remote_path = 'http://www.syntaxthemes.co.uk/synth-server/synth-rift-slider-update.php';
            $plugin_slug = $this->_plugin->pluginName;

            new rift_slider_wp_autoupdate($plugin_current_version, $plugin_remote_path, $plugin_slug);
        }

        function delete_lite_version($dir) {

            if (!file_exists($dir)) {
                return true;
            }

            if (!is_dir($dir) || is_link($dir)) {
                return unlink($dir);
            }

            foreach (scandir($dir) as $item) {

                if ($item == '.' || $item == '..')
                    continue;

                if (!$this->delete_lite_version($dir . "/" . $item)) {
                    chmod($dir . "/" . $item, 0777);

                    if (!$this->delete_lite_version($dir . "/" . $item))
                        return false;
                };
            }
            return rmdir($dir);
        }

        /**
         * This function will run on every web request.  Keep this function
         * as slim-lined as possible for effecient execution.
         * @return void
         */
        public function run() {

            //check if the plugin is installed before running
            if ($this->_plugin->is_installed()) {

                $this->check_auto_update();

                //initialize any scripts
                $this->_plugin->frontend_scripts();

                //add callbacks to hooks            
                $this->_plugin->add_actions_and_filters();
            }
        }

    }

}
?>