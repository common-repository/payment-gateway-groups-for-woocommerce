<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://businessupwebsite.com
 * @since             1.0.0
 * @package           Woo_Pgg
 *
 * @wordpress-plugin
 * Plugin Name: Payment Gateway Groups for WooCommerce
 * Plugin URI:  https://wordpress.org/plugins/payment-gateway-groups-for-woocommerce
 * Description: Allows you to create groups for payment gateways on the checkout page.
 * Author: Ivan Chernyakov
 * Author URI: https://businessupwebsite.com
 * Version: 1.1.3
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: payment-gateway-groups-for-woocommerce
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( function_exists( 'wp_fs' ) ) {
    wp_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'wp_fs' ) ) {
        // Create a helper function for easy SDK access.
        
        if ( !function_exists( 'wp_fs' ) ) {
            // Create a helper function for easy SDK access.
            function wp_fs()
            {
                global  $wp_fs ;
                
                if ( !isset( $wp_fs ) ) {
                    // Include Freemius SDK.
                    require_once dirname( __FILE__ ) . '/freemius/start.php';
                    $wp_fs = fs_dynamic_init( array(
                        'id'             => '4519',
                        'slug'           => 'woo-pgg',
                        'type'           => 'plugin',
                        'public_key'     => 'pk_235370654653c12b6f788d49418ff',
                        'is_premium'     => false,
                        'premium_suffix' => 'Pro',
                        'has_addons'     => false,
                        'has_paid_plans' => true,
                        'menu'           => array(
                        'slug'           => 'wc-settings',
                        'override_exact' => true,
                        'support'        => false,
                        'parent'         => array(
                        'slug' => 'woocommerce',
                    ),
                    ),
                        'is_live'        => true,
                    ) );
                }
                
                return $wp_fs;
            }
            
            // Init Freemius.
            wp_fs();
            // Signal that SDK was initiated.
            do_action( 'wp_fs_loaded' );
            function wp_fs_settings_url()
            {
                return admin_url( 'admin.php?page=wc-settings&tab=woopgg' );
            }
            
            wp_fs()->add_filter( 'connect_url', 'wp_fs_settings_url' );
            wp_fs()->add_filter( 'after_skip_url', 'wp_fs_settings_url' );
            wp_fs()->add_filter( 'after_connect_url', 'wp_fs_settings_url' );
            wp_fs()->add_filter( 'after_pending_connect_url', 'wp_fs_settings_url' );
        }
        
        // Init Freemius.
        wp_fs();
        // Signal that SDK was initiated.
        do_action( 'wp_fs_loaded' );
    }
    
    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    define( 'WOO_PGG_VERSION', '1.1.3' );
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-woo-pgg-activator.php
     */
    function activate_woo_pgg()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-pgg-activator.php';
        Woo_Pgg_Activator::activate();
    }
    
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-woo-pgg-deactivator.php
     */
    function deactivate_woo_pgg()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-pgg-deactivator.php';
        Woo_Pgg_Deactivator::deactivate();
    }
    
    register_activation_hook( __FILE__, 'activate_woo_pgg' );
    register_deactivation_hook( __FILE__, 'deactivate_woo_pgg' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-woo-pgg.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_woo_pgg()
    {
        $plugin = new Woo_Pgg();
        $plugin->run();
    }
    
    run_woo_pgg();
}
