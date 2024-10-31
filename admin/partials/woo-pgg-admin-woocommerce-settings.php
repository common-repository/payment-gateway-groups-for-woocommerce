<?php

if ( !class_exists( 'Woo_Payment_Gateway_Groups_Settings', false ) ) {
    /**
     * Woo_Payment_Gateway_Groups_Settings class
     */
    class Woo_Payment_Gateway_Groups_Settings extends WC_Settings_Page
    {
        /**
         * Constructor.
         */
        public function __construct()
        {
            $this->id = 'woopgg';
            $this->label = _x( 'Payment Gateway Groups', 'woopgg' );
            parent::__construct();
        }
        
        /**
         * Get sections.
         *
         * @return array
         */
        public function get_sections()
        {
            $sections = array(
                ''                  => __( 'Payment Gateways', 'woopgg' ),
                'advanced_settings' => __( 'Advanced Settings', 'woopgg' ),
            );
            return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
        }
        
        /**
         * Get settings array.
         *
         * @return array
         */
        public function get_settings( $current_section = '' )
        {
            
            if ( '' === $current_section ) {
                //checkout
                $gateways_pre = array( 'default' );
                $gateways_ids = WC()->payment_gateways->get_payment_gateway_ids();
                $gateways_ids = array_merge( $gateways_pre, $gateways_ids );
                $gateways = WC()->payment_gateways->payment_gateways();
                $discounts = array( array(
                    'type' => 'sectionend',
                    'id'   => 'checkout_options',
                ), array(
                    'title' => __( 'List of payment gateways', 'woopgg' ),
                    'type'  => 'title',
                    'desc'  => __( 'Choose group for each payment gateway.', 'woopgg' ),
                    'id'    => 'checkout_options_title',
                ) );
                $groups = array(
                    'none'                   => 'None',
                    'woopgg_payment_group_1' => 'Group 1',
                    'woopgg_payment_group_2' => 'Group 2',
                    'woopgg_payment_group_3' => 'Group 3',
                    'woopgg_payment_group_4' => 'Group 4',
                    'woopgg_payment_group_5' => 'Group 5',
                );
                foreach ( $gateways as $gateway ) {
                    
                    if ( $gateway->enabled == 'yes' ) {
                        $title = esc_attr( $gateway->title );
                        $id = esc_attr( $gateway->id );
                        $discount = array( array(
                            'title'    => __( $title, 'woopgg' ),
                            'desc'     => __( 'Payment discount in %', 'woopgg' ),
                            'id'       => 'woopgg_checkout_payment_gateway_' . $id,
                            'options'  => $groups,
                            'type'     => 'select',
                            'default'  => '0',
                            'desc_tip' => true,
                        ) );
                        $discounts = array_merge( $discounts, $discount );
                    }
                
                }
                $account_settings = array(
                    array(
                        'title' => 'Groups',
                        'type'  => 'title',
                        'desc'  => __( 'Main settings of your checkout page.' ),
                        'id'    => 'woopgg_main',
                    ),
                    /**
                     *	Groups
                     */
                    // group 1
                    /*array(
                    			'title'         => __( 'Group 1', 'woopgg' ),
                    			'desc'          => __( 'Apply', 'woopgg' ),
                    			'id'            => 'woopgg_on',
                    			'default'       => 'no',
                    			'type'          => 'checkbox',
                    			'autoload'      => false,
                    		),*/
                    array(
                        'title'    => __( 'Group 1 Title', 'woopgg' ),
                        'desc'     => __( 'Title for your 1 payment group.', 'woopgg' ),
                        'id'       => 'woopgg_payment_group_1',
                        'type'     => 'text',
                        'default'  => '',
                        'desc_tip' => true,
                    ),
                    // group 2
                    array(
                        'title'    => __( 'Group 2 Title', 'woopgg' ),
                        'desc'     => __( 'Title for your 2 payment group.', 'woopgg' ),
                        'id'       => 'woopgg_payment_group_2',
                        'type'     => 'text',
                        'default'  => '',
                        'desc_tip' => true,
                    ),
                    // group 3
                    array(
                        'title'    => __( 'Group 3 Title', 'woopgg' ),
                        'desc'     => __( 'Title for your 3 payment group.', 'woopgg' ),
                        'id'       => 'woopgg_payment_group_3',
                        'type'     => 'text',
                        'default'  => '',
                        'desc_tip' => true,
                    ),
                    // group 4
                    array(
                        'title'    => __( 'Group 4 Title', 'woopgg' ),
                        'desc'     => __( 'Title for your 4 payment group.', 'woopgg' ),
                        'id'       => 'woopgg_payment_group_4',
                        'type'     => 'text',
                        'default'  => '',
                        'desc_tip' => true,
                    ),
                    // group 5
                    array(
                        'title'    => __( 'Group 5 Title', 'woopgg' ),
                        'desc'     => __( 'Title for your 5 payment group.', 'woopgg' ),
                        'id'       => 'woopgg_payment_group_5',
                        'type'     => 'text',
                        'default'  => '',
                        'desc_tip' => true,
                    ),
                );
                $sectioned = array( array(
                    'type' => 'sectionend',
                    'id'   => 'personal_data_retention',
                ) );
                $pro_info = array( array(
                    'type' => 'sectionend',
                    'id'   => 'pro_info',
                ), array(
                    'title' => __( 'More options', 'woopgg' ),
                    'type'  => 'title',
                    'desc'  => __( '<div class="woopgg-info-box"><p><ul>
								<li>Drag and Drop</li>
								<li>Infinite Groups</li>
								<li>Subgroups</li>
								<li>Image titles</li></p>
								</ul>
								<p class="btn-p"><a class="btn" href="' . esc_url( admin_url( 'admin.php?page=wc-settings-pricing' ) ) . '">Upgrade Now</a></p>
								</div>', 'woopgg' ),
                    'id'    => 'checkout_options_title',
                ) );
                $account_settings = array_merge( $account_settings, $pro_info );
                $account_settings = array_merge( $account_settings, $discounts );
                $account_settings = array_merge( $account_settings, $sectioned );
            } elseif ( 'advanced_settings' == $current_section ) {
                //cart
                $account_settings = '';
                $html_tags = array(
                    'p'    => 'p',
                    'span' => 'span',
                    'h1'   => 'h1',
                    'h2'   => 'h2',
                    'h3'   => 'h3',
                    'h4'   => 'h4',
                    'h5'   => 'h5',
                    'h6'   => 'h6',
                );
                $account_settings = array(
                    array(
                    'title' => 'Advanced Settings',
                    'type'  => 'title',
                    'desc'  => __( 'Advanced settings of your Groups.', 'woopgg' ),
                    'id'    => 'woopgg_advanced_settings',
                ),
                    array(
                    'title'    => __( 'HTML tag for the group title', 'woopgg' ),
                    'desc'     => __( '', 'woopgg' ),
                    'id'       => 'woopgg_html_tag',
                    'default'  => 'h3',
                    'options'  => $html_tags,
                    'type'     => 'select',
                    'autoload' => false,
                    'class'    => 'wc-enhanced-select',
                ),
                    array(
                    'title'    => __( 'Display', 'woopgg' ),
                    'desc'     => __( 'Choose display type.', 'woopgg' ),
                    'id'       => 'woopgg_display',
                    'default'  => 'toggle',
                    'options'  => array(
                    'toggle'        => 'Toggle (auto collapse/expand)',
                    'toggle_manual' => 'Toggle (manual collapse/expand)',
                    'headers'       => 'Only Headers',
                ),
                    'type'     => 'select',
                    'autoload' => false,
                    'class'    => 'wc-enhanced-select',
                ),
                    array(
                    'title'    => __( 'Active Color', 'woopgg' ),
                    'desc'     => __( 'Choose color for active payment group.', 'woopgg' ),
                    'id'       => 'woopgg_active_color',
                    'default'  => '#0f834d',
                    'type'     => 'color',
                    'css'      => 'width:6em;',
                    'autoload' => false,
                ),
                    array(
                    'type' => 'sectionend',
                    'id'   => 'woopgg_cart_end',
                ),
                    array(
                    'type' => 'sectionend',
                    'id'   => 'woopgg_cart_discount_end',
                )
                );
            }
            
            $settings = apply_filters( 'woopgg_' . $this->id . '_settings', $account_settings );
            return apply_filters( 'woopgg_get_settings_' . $this->id, $settings, $current_section );
        }
        
        /**
         * Output the settings.
         */
        public function output()
        {
            global  $current_section ;
            $settings = $this->get_settings( $current_section );
            WC_Admin_Settings::output_fields( $settings );
        }
        
        /**
         * Save settings.
         */
        public function save()
        {
            global  $current_section ;
            $settings = $this->get_settings( $current_section );
            WC_Admin_Settings::save_fields( $settings );
            if ( $current_section ) {
                do_action( 'woocommerce_update_options_' . $this->id . '_' . $current_section );
            }
        }
    
    }
}
if ( class_exists( 'Woo_Payment_Gateway_Groups_Settings', false ) ) {
    return new Woo_Payment_Gateway_Groups_Settings();
}