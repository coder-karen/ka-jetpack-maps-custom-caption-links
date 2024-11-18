<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @package    KA_Jetpack_Maps_Custom_Caption_Links
 * @subpackage KA_Jetpack_Maps_Custom_Caption_Links/includes
 */

/**
 * The public-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and a hook to
 * enqueue the public-specific JavaScript. Also adds a filter to the block
 * to add the caption link color attribute.
 *
 * @since      1.0.0
 * @package    KA_Jetpack_Maps_Custom_Caption_Links
 * @subpackage KA_Jetpack_Maps_Custom_Caption_Links/includes
 * @author     Karen Attfield
 */
class KA_Jetpack_Maps_Custom_Caption_Links_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;


	}

	/**
	 * Adds a filter to the block to add the caption link color attribute.
	 *
	 * @since    1.0.0
	 */
	public function add_caption_link_filter() {
		add_filter( 'render_block', array( $this, 'add_caption_link_color_to_block' ), 10, 2 );
	}

	/**
	 * Adds the caption link color attribute to the block.
	 *
	 * @since    1.0.0
	 * @param    string    $block_content    The block content.
	 * @param    array     $block            The block attributes.
	 * @return   string                      The block content with the caption link color attribute added.
	 */
	public function add_caption_link_color_to_block( $block_content, $block ) {
		// Check if this is the correct block type
		if ( 'jetpack/map' !== $block['blockName'] ) {
			return $block_content;
		}
	
		// Retrieve the caption link color attribute or set a default
		$caption_link_color = isset( $block['attrs']['captionLinkColor'] ) ? $block['attrs']['captionLinkColor'] : '#000000';
	
		$data_attribute = ' data-caption-link-color="' . esc_attr( $caption_link_color ) . '"';

		$block_content = preg_replace(
			'/(data-map-style)/',
			$data_attribute . ' $1',
			$block_content,
			1
		);
		return $block_content;

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ka-jetpack-maps-custom-caption-links-public.js', array(), $this->version, false );

	}
}
