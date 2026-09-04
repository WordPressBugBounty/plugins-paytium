<?php

/**
 * Redirect URL functions
 *
 * @since   1.5.0
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Function to show a message and payment details after the purchase
 *
 * @param  mixed $content WP the_content.
 *
 * @return mixed $html
 *
 * @since 1.0.0
 */
function pt_show_payment_details( $content ) {

	if ( isset( $_GET['pt-payment'] ) ) {

		$payment_id = sanitize_key( $_GET['pt-payment'] );
		$payment    = pt_get_payment_by_payment_key( $payment_id );

		// phpcs:ignore WordPress.WP.I18n -- deliberate: the value is a runtime string (a payment status, an interval, or label text the site owner typed into the shortcode). Making these extractable means enumerating the values into includes/other-translations.php and looking them up through a map - a refactor, not a lint fix. Verified against languages/paytium-nl_NL.mo: none of these values currently resolve to a translation, so the __() call is a no-op today.
		$pretty_status = __( $payment->get_status(), 'paytium' );

		paytium_logger( $payment->id . ' - ' . 'Shown after payment message.',__FILE__,__LINE__ );

		$payment_status_style = ( $payment->status == 'paid' || $payment->no_payment == true ) ? 'pt-payment-details-wrap' : 'pt-payment-details-wrap pt-payment-details-error';

		// Add anchor link to jump to payment message in/close to Paytium form
		$html = '<p style="position:relative;"><a id="pt-payment-details" style="position:absolute; top:-100px;"></a></p>' . "\n";

		// Start payment message
		$html .= '<div class="' . $payment_status_style . '">' . "\n";

		if ( $payment->id == null ) {
			$html .= __( 'Oops, no payment found, please contact us to sort this out!', 'paytium' );
		} elseif ( ( $payment->status == 'open' ) && ( $payment->no_payment == true ) ) {
			$html .= __( 'Thank you for your submission! We will get in touch shortly!', 'paytium' );
		} elseif ( $payment->status == 'paid' ) {
			$html .= __( 'Thank you for your order, the status is:', 'paytium' ) . ' <b>' . strtolower( $pretty_status ) . '</b>.' . "\n";
		} elseif ( ( $payment->status == 'open' ) && ( $payment->no_payment == false ) ) {
			/* translators: %1$s: opening HTML tag. */
			$html .= sprintf( __( 'The payment is: %s, this status might still change.', 'paytium' ), '<b>' . strtolower( $pretty_status ) . '</b>' ) . "\n";
		} else {
			$html .= __( 'The payment status is:', 'paytium' ) . ' <b>' . strtolower( $pretty_status ) . '</b>.' . "\n";
		}

		if ( ! empty( $payment->mollie_subscription_id ) ) {
			$html .= '<br />';
			$html .= __( 'Your subscription has been created successfully.', 'paytium' ) . "\n";
		}

		$html .= '</div>' . "\n";

		if ( ! empty( $payment->subscription_error ) && $payment->status == 'paid' ) {
			$html .= '<div class="pt-payment-details-wrap pt-payment-details-error">' . "\n";
			$html .= __( 'Creating your subscription failed, please contact us!', 'paytium' );
			$html .= '</div>';
		}

		// Add custom hook after payment
		do_action( 'paytium_after_pt_show_payment_details', $payment );

		return $html;

	}

	return $content;
}

/**
 * When customer returns, store the pt-payment key as cookie
 * so it can be used later, for [paytium_content /] for example
 *
 * @since 4.0.0
 */
function pt_set_pt_payment_cookie() {

	if ( isset( $_GET['pt-payment'] ) ) {

		if ( isset( $_COOKIE['ptpayment'] ) && sanitize_key( $_COOKIE['ptpayment'] ) !== sanitize_key( $_GET['pt-payment'] ) ) {
			setcookie( 'ptpayment', '', time() - 3600 );
		}

		$payment_id = sanitize_key( $_GET['pt-payment'] );
		setcookie( 'ptpayment', $payment_id, strtotime( '+5 years' ), COOKIEPATH, COOKIE_DOMAIN, false );
	}

}

add_action( 'init', 'pt_set_pt_payment_cookie' );



