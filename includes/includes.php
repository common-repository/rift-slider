<?php

global $rift_slider_config;

/**
 * Initialize of base
 */
require_once($rift_slider_config->plugin_path . '/includes/lib/base/class-core.php');
require_once($rift_slider_config->plugin_path . '/includes/lib/base/class-installer.php');
require_once($rift_slider_config->plugin_path . '/includes/lib/base/class-plugin-base.php');
require_once($rift_slider_config->plugin_path . '/includes/lib/base/class-shortcode-loader.php');
require_once($rift_slider_config->plugin_path . '/includes/lib/base/class-shortcode-script-loader.php');
require_once($rift_slider_config->plugin_path . '/includes/lib/base/class-wp-autoupdate.php');

/**
 * Initialize of helpers
 */
require_once($rift_slider_config->plugin_path . '/includes/lib/helpers/class-admin-notifications.php');
require_once($rift_slider_config->plugin_path . '/includes/lib/helpers/class-custom-tag-checklist.php');
require_once($rift_slider_config->plugin_path . '/includes/lib/helpers/class-fields-generator.php');
require_once($rift_slider_config->plugin_path . '/includes/lib/helpers/class-options-generator.php');

/**
 * Initialize of tinymce
 */
require_once($rift_slider_config->plugin_path . '/includes/lib/tinymce/class-tinymce-manager.php');

/**
 * Initialize of types
 */
require_once($rift_slider_config->plugin_path . '/includes/lib/types/class-custom-post-type-list-columns.php');

/**
 * Initialize of includes
 */
require_once($rift_slider_config->plugin_path . '/includes/rift-slider-admin-menu-pages.php');
require_once($rift_slider_config->plugin_path . '/includes/rift-slider-post-tinymce.php');
require_once($rift_slider_config->plugin_path . '/includes/rift-slider-post-types.php');
require_once($rift_slider_config->plugin_path . '/includes/rift-slider-post-metaboxes.php');
require_once($rift_slider_config->plugin_path . '/includes/rift-slider-shortcodes.php');
?>
