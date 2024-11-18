<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    KA_Jetpack_Maps_Custom_Caption_Links
 * @subpackage KA_Jetpack_Maps_Custom_Caption_Links/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and a hook to
 * enqueue the admin-specific JavaScript, plus functionality to check
 * if the required Jetpack plugin is active.
 *
 * @package    KA_Jetpack_Maps_Custom_Caption_Links
 * @subpackage KA_Jetpack_Maps_Custom_Caption_Links/admin
 * @author     Karen Attfield
 */
class KA_Jetpack_Maps_Custom_Caption_Links_Admin {

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
	 * Also ensure we don't activate the plugin if Jetpack is not active.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'admin_init', array( $this, 'require_jetpack_maps_plugin' ) );

	}


	/**
	 * Check if Jetpack is active and display an admin notice if it is not.
	 *
	 * @since    1.0.0
	 */
	public function require_jetpack_maps_plugin() {
		if ( 
			is_admin() && 
			current_user_can( 'activate_plugins' ) && 
			! is_plugin_active( 'jetpack/jetpack.php' ) && 
			! is_plugin_active( 'jetpack-dev/jetpack.php' ) 
		) {
			add_action( 'admin_notices', array( $this, 'ka_jetpack_maps_plugin_notice'), 10 );

			deactivate_plugins( 'ka-jetpack-maps-custom-caption-links/ka-jetpack-maps-custom-caption-links.php' ); 

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}

	/**
	 * Display an admin error notice if Jetpack is not active.
	 *
	 * @since    1.0.0
	 */
	public function ka_jetpack_maps_plugin_notice() {
		// Display an admin error notice if Jetpack is not active
		?>
		<div class="error">
			<p><?php echo esc_html__( 'KA Jetpack Maps Custom Caption Links requires the Jetpack plugin to be installed and active.', 'ka-jetpack-maps-custom-caption-links' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ka-jetpack-maps-custom-caption-links-admin.js', array(), $this->version, false );

	}
}
