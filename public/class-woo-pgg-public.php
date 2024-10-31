<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://businessupwebsite.com
 * @since      1.0.0
 *
 * @package    Woo_Pgg
 * @subpackage Woo_Pgg/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Pgg
 * @subpackage Woo_Pgg/public
 * @author     Ivan Chernyakov <admin@businessupwebsite.com>
 */
class Woo_Pgg_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/woo-pgg-public.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/woo-pgg-public.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    /**
     * Filter the payment template path to use our payment-method.php template instead of the theme's
     *
     * @since    1.0.0
     */
    public function woopgg_locate_template_payment( $template, $template_name, $template_path )
    {
        $basename = basename( $template );
        if ( $basename == 'payment.php' ) {
            $template = plugin_dir_path( __FILE__ ) . 'partials/woo-pgg-public-display-payment.php';
        }
        return $template;
    }
    
    /**
     * Filter the payment template path to use our payment-method.php template instead of the theme's
     *
     * @since    1.0.0
     */
    public function woopgg_locate_template_payment_method( $template, $template_name, $template_path )
    {
        $basename = basename( $template );
        if ( $basename == 'payment-method.php' ) {
            $template = plugin_dir_path( __FILE__ ) . 'partials/woo-pgg-public-display-payment-method.php';
        }
        return $template;
    }

}