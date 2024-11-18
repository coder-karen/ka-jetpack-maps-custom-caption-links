<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 *
 * @package    KA_Jetpack_Maps_Custom_Caption_Links
 * @subpackage KA_Jetpack_Maps_Custom_Caption_Links/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    KA_Jetpack_Maps_Custom_Caption_Links
 * @subpackage KA_Jetpack_Maps_Custom_Caption_Links/includes
 * @author     Karen Attfield
 */
class KA_Jetpack_Maps_Custom_Caption_Links_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ka-jetpack-maps-custom-caption-links',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
