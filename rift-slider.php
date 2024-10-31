<?php

/*
  Plugin Name: Rift Slider
  Plugin URI: http://www.syntaxthemes.co.uk/rift-slider
  Version: 1.1.19
  Author: Ryan Haworth
  Description: Check out this cool slider, watch your slider rift and split, awesome effects and fully web responsive. Documentation can be found at http://www.syntaxthemes.co.uk/rift-slider/how-to-use-rift-slider/
  Text Domain: synth_rift_slider_textdomain
  License: GPLv3
 */

//error_reporting(E_ALL);

require_once('rift-slider-config.php');

global $rift_slider_config;

require_once('class-initialize.php');

//set the plugin definitions
define('SYNTH_RIFT_SLIDER_DOMAIN', 'synth_rift_slider_textdomain');
define('SYNTH_RIFT_SLIDER_OPT', '_synth_rift_slider_opt_');
define('SYNTH_RIFT_SLIDER_META', 'synth_rift_slider_meta_');

//////////////////////////////////
// initialization
//////////////////////////////////
$rift_slider_initialize = new rift_slider_initialize(plugin_basename(__FILE__), SYNTH_RIFT_SLIDER_DOMAIN, SYNTH_RIFT_SLIDER_OPT, $rift_slider_config->version);

// Register the Plugin Activation Hook
register_activation_hook(__FILE__, array(&$rift_slider_initialize, 'activate'));

// Register the Plugin Deactivation Hook
register_deactivation_hook(__FILE__, array(&$rift_slider_initialize, 'deactivate'));

//////////////////////////////////
// Run the plugin
//////////////////////////////////
add_action('init', array(&$rift_slider_initialize, 'run'));

