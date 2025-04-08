<?php
/**
 * Plugin Name: Easy Digital Downloads - Software Licensing Shortcodes
 * Description: Add additional shortcodes to Software Licensing.
 * Version: 1.0.1
 * Author: Daan from Daan.dev
 * Author URI: https://daan.dev
 * GitHub Plugin URI: Dan0sz/edd-sl-shortcodes
 * Primary Branch: master
 * License: MIT
 */

define( 'EDD_SL_SHORTCODES_PLUGIN_FILE', trailingslashit( __FILE__ ) );

require_once __DIR__ . '/vendor/autoload.php';

$daan_edd_sl_shortcodes = new \Daan\EDD\SoftwareLicensing\Shortcodes();