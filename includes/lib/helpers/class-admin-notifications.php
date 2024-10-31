<?php

/**
 * Description of admin-notifications-class
 *
 * @author Ryan
 */
if (!class_exists('rift_slider_admin_notifications')) {

    class rift_slider_admin_notifications {

        public function add_message($content) {

            echo '<div class="updated fade">' .
            __('Error: plugin "syntaxstudio" requires a newer version of PHP to be running.', 'syntaxstudio') .
            '<br/>' . __('Minimal version of PHP required: ', 'syntaxstudio') . '<strong>' . $this->minimalRequiredPhpVersion . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'syntaxstudio') . '<strong>' . phpversion() . '</strong>' .
            '</div>';
        }

    }

}
?>
