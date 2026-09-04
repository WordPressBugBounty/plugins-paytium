<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( trim( $payment->get_field_data_html() ) == false ) {
	esc_html_e( 'No customer details registered.', 'paytium' );

	return;
}

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_field_data_html() returns built markup; both dynamic parts (label and value) are esc_html()'d inside it, see PT_Payment::get_field_data_html().
echo $payment->get_field_data_html();