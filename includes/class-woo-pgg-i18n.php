<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://businessupwebsite.com
 * @since      1.0.0
 *
 * @package    Woo_Pgg
 * @subpackage Woo_Pgg/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_Pgg
 * @subpackage Woo_Pgg/includes
 * @author     Ivan Chernyakov <admin@businessupwebsite.com>
 */
class Woo_Pgg_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-pgg',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
