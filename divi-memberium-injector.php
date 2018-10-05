<?php
/*
Plugin Name: Divi Memberium Injector
Plugin URI:  http://elephunkie.com
Description: A plugin
Version:     1.0.0
Author:      Elephunkie
Author URI:  http://elephunkie.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: divi-memb-inject
Domain Path: /languages
*/


if ( ! function_exists( 'mdm_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function dmi_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/DiviMemberiumInjector.php';
}
add_action( 'divi_extensions_init', 'dmi_initialize_extension' );
endif;
