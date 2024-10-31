<?php

/**
 * The Core class.
 */
if (!class_exists('rift_slider_core')) {

    class rift_slider_core {

        /**
         * If the PHP version is wrong then display this message.
         */
        public function notice_php_version_wrong() {

            global $rift_slider_config;

            echo '<div id="message" class="updated">
                    <p>' .
            __('Error: plugin "syntaxstudio" requires a newer version of PHP to be running.', SYNTH_RIFT_SLIDER_DOMAIN) .
            '<br/>' . __('Minimal version of PHP required: ', 'syntaxstudio') . '<strong>' . $rift_slider_config->php_version . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'syntaxstudio') . '<strong>' . phpversion() . '</strong>' .
            '</p>
                </div>';
        }

        /**
         * Check the PHP version, if the version is wrong then display an
         * error message.
         * @return boolean
         */
        public function php_version_check() {

            global $rift_slider_config;

            if (version_compare(phpversion(), $rift_slider_config->php_version) < 0) {
                //add_action('admin_notices', array(&$this, 'notice_php_version_wrong'));
                return false;
            }
            return true;
        }

    }

}

if (!function_exists('rift_slider_notice_php_version_wrong')) {

    function rift_slider_notice_php_version_wrong() {

        global $rift_slider_config;

        if (version_compare(phpversion(), $rift_slider_config->php_version) < 0) {

            echo '<div id="message" class="updated">
                    <p>' .
            __('Error: plugin "syntaxstudio" requires a newer version of PHP to be running.', SYNTH_RIFT_SLIDER_DOMAIN) .
            '<br/>' . __('Minimal version of PHP required: ', 'syntaxstudio') . '<strong>' . $rift_slider_config->php_version . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'syntaxstudio') . '<strong>' . phpversion() . '</strong>' .
            '</p>
                </div>';
        }
    }

    add_action('admin_notices', 'rift_slider_notice_php_version_wrong');
}


if (!function_exists('rift_slider_wordpress_version')) {

    function rift_slider_wordpress_version() {

        global $wp_version;
        global $rift_slider_config;

        if (!version_compare($wp_version, $rift_slider_config->wordpress_version, '>=')) {

            echo '<div id="message" class="updated">
                    <p>' .
            __('Error: ' . $rift_slider_config->plugin_name . ' requires a newer version of WordPress to be running.', SYNTH_RIFT_SLIDER_DOMAIN) .
            '<br/>' . __('Minimal version of WordPress required: ', 'syntaxstudio') . '<strong>' . $rift_slider_config->wordpress_version . '</strong>' .
            '</p>
                </div>';
        }
        return true;
    }

    add_action('admin_notices', 'rift_slider_wordpress_version');
}
?>