<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.3
 * @since 1.0.1 - Fixed error when the last group doesn't shows.
 * @since 1.1.1 - Added new toggle mode
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
if ( get_option('woopgg_display') ){
	$display_type = get_option('woopgg_display');
	switch ($display_type) {
		case 'toggle':
		$toggle = " toggle auto";
		break;
		case 'toggle_manual':
		$toggle = " toggle manual";
		break;
		case 'headers':
		$toggle = " simple";
		break;
		default:
		$toggle = " toggle";
	}
}
?>
<div id="payment" class="woocommerce-checkout-payment <?php echo esc_attr( $toggle ); ?>">
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
			if ( ! empty( $available_gateways ) ) {
				$woopgg_has_group = array();				

				// create array with groups
				for ($i=1; $i<=5; $i++) {					
					$current_group = get_option('woopgg_payment_group_'.$i);
					if ( $current_group != '' ) {
						$current_has_group = array();
						foreach ( $available_gateways as $gateway ) {
							$id = $gateway->id;
							$current_gateway_group = get_option( 'woopgg_checkout_payment_gateway_'.$id );
							if ( $current_gateway_group == 'woopgg_payment_group_'.$i  ){
								array_push( $current_has_group, $gateway->id );
							}
						}
						$woopgg_defined_groups[ 'woopgg_payment_group_'.$i ] = array(
							'title' 	=> $current_group,
							'gateways' 	=> $current_has_group,
						);
					};
				};
				/*echo '<pre>';
				print_r($woopgg_defined_groups);
				echo '</pre>';*/
				if ( isset($woopgg_defined_groups ) ){
					// get options					
					$html_tag = get_option('woopgg_html_tag');
					$active_color = get_option('woopgg_active_color');
					if ( $active_color == '' ) $active_color = '#0f834d';
					//apply active color
					echo '
					<style>
					.woopgg-group-label.toggle.active{
						background-color:'.esc_attr( $active_color ).';
						border-color:'.esc_attr( $active_color).';
						}
					</style>';
					foreach ($woopgg_defined_groups as $key => $woopgg_defined_group) {	
						if ( ! empty($woopgg_defined_group['gateways']) ){
							?>
							<<?php echo esc_attr( $html_tag ); ?> id="<?php echo esc_attr( $key ); ?>" class="woopgg-group-label <?php echo esc_attr( $key ); ?>" >
							<?php echo esc_html( $woopgg_defined_group['title'] ); ?> 			
							</<?php echo esc_attr( $html_tag ); ?>>
							<?php					
							foreach ( $available_gateways as $gateway ) {
								if ( in_array($gateway->id,$woopgg_defined_group['gateways']) ){
									?>
									<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id.'  woopgg_payment_has_group '.$key ); ?>" group-id="<?php echo esc_attr( $key ); ?>">
										<?php
										wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
										array_push( $woopgg_has_group, $gateway->id );
										?>							
									</li>
									<?php
								}								
							}	
							?>
							<div class="woopgg-sectioned"></div>
							<?php
						}				
					}
				}

				foreach ( $available_gateways as $gateway ) {
					if (! in_array($gateway->id, $woopgg_has_group )){
						?>
						<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id );  ?>">
							<?php
							wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
							?>							
						</li>
						<?php
					}
				}
			} else {
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
			}
			?>
		</ul>
	<?php endif; ?>
	<div class="form-row place-order">
		<noscript>
			<?php
			/* translators: $1 and $2 opening and closing emphasis tags respectively */
			printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
			?>
			<br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		</noscript>

		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
