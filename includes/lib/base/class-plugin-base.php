<?php

/**
 * Description of PluginBase
 *
 * @author Ryan Haworth
 */
if (!class_exists('rift_slider_plugin_base')) {

    abstract class rift_slider_plugin_base extends rift_slider_installer {

        function activate() {

            $this->install_database_tables();

            $this->install_options();

            $this->plugin_installed_version();

            $this->mark_plugin_activated();
        }

        public abstract function install_database_tables();

        public abstract function install_options();

        public abstract function upgrade();

        public abstract function add_actions_and_filters();

        public abstract function add_admin_menu();

        public abstract function admin_scripts($hook);

        public abstract function frontend_scripts();

        public function deactivate() {

            $this->mark_plugin_deactivated();
        }

    }

}
?>