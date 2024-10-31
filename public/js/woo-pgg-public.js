/* global wwpgg_checkout */

/* 1.1.1 - Added display toggle manual mode */
jQuery( function( $ ) {

	var wwpgg_checkout = {
		$order_review: $( '#order_review' ),
		$checkout_form: $( 'form.checkout' ),
		init: function() {
			// Payment methods
			$( document ).ajaxComplete(function () {
				var active_group_id = $( '.toggle .woopgg_payment_has_group input[type=radio]:first-child:checked').parent().attr('group-id');
				$( '#'+active_group_id).addClass('active');

				$( '.toggle .woopgg_payment_has_group').hide();
				$( '.toggle .'+active_group_id).show();
				
				//alert('ajaxComplete');
			});
			// Set active
			this.$checkout_form.on( 'click', 'input[name="payment_method"]', this.set_active );
			// Show payments
			this.$checkout_form.on( 'click', '.toggle.auto .woopgg-group-label', this.payment_method_selected );
			this.$checkout_form.on( 'click', '.toggle.manual .woopgg-group-label', this.payment_method_selected_manual );

			if ( $( document.body ).hasClass( 'woocommerce-order-pay' ) ) {
				this.$order_review.on( 'click', '.toggle.auto .woopgg-group-label', this.payment_method_selected );
				this.$order_review.on( 'click', '.toggle.manual .woopgg-group-label', this.payment_method_selected_manual );
			}			
		},
		payment_method_selected: function( e ) {
			e.stopPropagation();
			var target_group = $(this).attr('id');
			var display_mode = '.toggle.auto';
			if ( ! $( this ).hasClass('show-groups') ){
				$( display_mode+' .woopgg_payment_has_group').slideUp( 230 );
				$( display_mode+' .'+target_group).slideDown( 230 );				
				$( display_mode+' .woopgg-group-label').removeClass('show-groups');
				$( this ).addClass('show-groups');
				if ( $( display_mode+' .'+target_group+' input[type=radio]:first-child:checked').length){
					$( display_mode+' .woopgg-group-label').removeClass('active');
					$( this ).addClass('active');
				}
			}
		},
		payment_method_selected_manual: function( e ) {
			e.stopPropagation();
			var target_group = $(this).attr('id');
			var display_mode = '.toggle.manual';
			if ( ! $( this ).hasClass('show-groups') ){
				$( display_mode+' .'+target_group).slideDown( 230 );				
				$( this ).addClass('show-groups');
				if ( $( display_mode+' .'+target_group+' input[type=radio]:first-child:checked').length){
					$( display_mode+' .woopgg-group-label').removeClass('active');
					$( this ).addClass('active');
				}
			} else if ( $( this ).hasClass('show-groups') ){
				$( display_mode+' .'+target_group+'.wc_payment_method').slideUp( 230 );
				$( display_mode+' .'+target_group+'.woopgg-group-label').removeClass('show-groups');
			}
		},
		set_active: function( e ) {
		var active_group_id = $( this).parent().attr('group-id');
			$( '.toggle .woopgg-group-label').removeClass('active');
			$( '.toggle #'+active_group_id).addClass('active');
			$( '.toggle #'+active_group_id).addClass('show-groups');
		},
	}
	wwpgg_checkout.init();
});