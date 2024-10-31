<?php

/**
 * Description of Installer
 *
 * @author Ryan Haworth
 */
if (!class_exists('rift_slider_installer')) {

    class rift_slider_installer {

        public $pluginName;
        public $pluginTextDomain;
        public $pluginOptionPrefix;
        public $pluginVersion;

        /**
         * The Installer constructor.
         */
        public function __construct() {

            $this->pluginName = null;
            $this->pluginTextDomain = null;
            $this->pluginOptionPrefix = null;
            $this->pluginVersion = null;
        }

        /**
         * Check if the plugin is already installed and return true
         * if it is.
         * @return $installed
         */
        public function is_installed() {

            $installed = get_option($this->pluginOptionPrefix . 'activated');

            return $installed;
        }

        /**
         * Get the plugin installed version.
         * @return $version
         */
        public function plugin_installed_version() {

            $version = get_option($this->pluginOptionPrefix . 'version');

            return $version;
        }

        /**
         * When the plugin has been activated, mark as activated.  Also the
         * plugin version is updated.
         */
        public function mark_plugin_activated() {

            update_option($this->pluginOptionPrefix . 'activated', true);
            update_option($this->pluginOptionPrefix . 'version', $this->pluginVersion);
        }

        /**
         * When the plugin is deactivated mark as deactivated.
         */
        public function mark_plugin_deactivated() {

            update_option($this->pluginOptionPrefix . 'activated', false);
        }

    }

}
?>