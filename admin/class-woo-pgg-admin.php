<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://businessupwebsite.com
 * @since      1.0.0
 *
 * @package    Woo_Pgg
 * @subpackage Woo_Pgg/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Pgg
 * @subpackage Woo_Pgg/admin
 * @author     Ivan Chernyakov <admin@businessupwebsite.com>
 */
class Woo_Pgg_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Pgg_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Pgg_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-pgg-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Pgg_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Pgg_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-pgg-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Adds woocommerce settings
	 *
	 * @since    1.0.0
	 */
	public function woo_pgg_init_after($settings) {
		$settings[] = include_once plugin_dir_path( __FILE__ ) . 'partials/woo-pgg-admin-woocommerce-settings.php';
		return $settings;
	}

	/**
	 * Check WooCommerce activation function
	 *
	 * @since    1.0.0
	 */
	public function woopgg_woocommerce_active() {
		if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			add_action( 'admin_notices', array( $this, 'woopgg_error' ) );

			deactivate_plugins( plugin_basename( __FILE__ ) ); 

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}

}

