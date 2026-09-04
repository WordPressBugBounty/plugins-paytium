<?php
// Prevent direct file access; this file is only meaningful when loaded by WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="pt-alert pt-alert-danger pt-no-account-details-restart-wizard" style="display: none;">
	<?php echo esc_html__('No Mollie username or password found!', 'paytium' )  ?>
    <a href="javascript:void(0);" class="tab-button"
       data-target="connect-mollie"><?php echo esc_html__( 'Go back to step 1', 'paytium' ); ?> &rarr;</a>
</div>

<div id="pt-setup-payment-test-box" style="display: none;">
    <h3><?php esc_html_e( 'Do a test payment', 'paytium' ); ?></h3>
    <p class="payment-test-intro"><?php esc_html_e( 'You can use this payment button to make a test payment via the Mollie test mode. This is not a real payment. The test mode allows you to place as many payments as you want, for free, to test your payments and see how different payment methods work.', 'paytium' ); ?></p>

    <p class="payment-test-intro"><?php esc_html_e( 'After the test payment, you can validate the test payment and continue to the next step.', 'paytium' ); ?></p>

    <div class="ajax-response-payment-test"></div>

    <div class="boxed payment-test payment-test-button"><?php
		echo do_shortcode( '[paytium name="Webwinkel XYZ" description="Test betaling" amount="49.95" button_label="' . __( 'Start test payment', 'paytium' ) . '"][/paytium]' );
		?></div>

    <div style="text-align: center; margin-top: 10px;">
        <a href="javascript:void(0);" class="button button-primary"
           id="check-payment"><?php esc_html_e( 'Validate test payment', 'paytium' ); ?></a>&nbsp;
        <a href="javascript:void(0);" class="button button-primary continue-button tab-button"
           id="check-payment-continue-button" style="display: none;"
           data-target="first-product"><?php esc_html_e( 'Continue to next step', 'paytium' ); ?> &rarr;</a>
    </div>
</div>
