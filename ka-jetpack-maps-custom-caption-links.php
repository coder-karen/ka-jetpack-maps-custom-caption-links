<?php
/*
Plugin Name: KA Jetpack Maps Custom Caption Links
Description: Extends the Jetpack Map block with custom caption links.
Author: Karen Attfield
Version: 1.0
*/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'KA_JETPACK_MAPS_CUSTOM_CAPTION_LINKS_VERSION', '1.0.0' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ka-jetpack-maps-custom-caption-links.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ka_jetpack_maps_custom_caption_links() {

	$plugin = new KA_Jetpack_Maps_Custom_Caption_Links();
	$plugin->run();

}


run_ka_jetpack_maps_custom_caption_links();