<?php

/**
 * Misc plugin functions
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set Mollie API key from options.
 *
 * @param string $mode
 * @since 1.0.0
 */
function pt_set_paytium_key( $mode = 'live' ) {
	global $pt_mollie;

	$key = '';

	// Check first if in live or test mode.
	if ( ( $mode == 'live' && get_option( 'paytium_enable_live_key', false ) == 1 ) ) {
		$key = get_option( 'paytium_live_api_key', '' );
	} else {
		$key = get_option( 'paytium_test_api_key', '' );
	}

	if ( $key != '' ) {
		delete_option( 'paytium_no_api_keys' );
		$pt_mollie->setApiKey( $key );
	} else {
		add_option( 'paytium_no_api_keys', 1 );
	}

}

/**
 * Get the Mollie API key.
 *
 * @since 1.5.0
 *
 * @param string $mode
 * @return mixed
 */
function pt_get_api_key( $mode = 'live' ) {
	// Check if in test mode or live mode
	if ( get_option( 'paytium_enable_live_key', false ) == 1 && $mode === 'live' ) {
		$data_key = get_option( 'paytium_live_api_key', '' );
	} else {
		$data_key = get_option( 'paytium_test_api_key', '' );
	}
	return $data_key;
}

/**
 * Log error messages for Paytium into /wp-content/plugins/paytium/logs.txt
 *
 * @since   2.2.0
 * @param $message
 * @param string $file
 * @param string $line
 */
function paytium_logger( $message, $file = '', $line = '' ) {


	$pt_log_dir =  PT_PATH . 'logs/';
	$file = $file ? $file : __FILE__;
	$line = $line ? $line : __LINE__;

	if ( wp_mkdir_p($pt_log_dir) && ! file_exists(  $pt_log_dir . '.htaccess' ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions -- the debug logger APPENDS single lines and is deliberately best-effort; WP_Filesystem may not be initialised this early, can prompt for FTP credentials, and offers no append mode.
		$fh = @fopen(  $pt_log_dir  . '.htaccess', 'w' );
		if ( $fh ) {
			// phpcs:ignore WordPress.WP.AlternativeFunctions -- the debug logger APPENDS single lines and is deliberately best-effort; WP_Filesystem may not be initialised this early, can prompt for FTP credentials, and offers no append mode.
			fwrite( $fh, 'deny from all' );
			// phpcs:ignore WordPress.WP.AlternativeFunctions -- the debug logger APPENDS single lines and is deliberately best-effort; WP_Filesystem may not be initialised this early, can prompt for FTP credentials, and offers no append mode.
			fclose( $fh );
		}
	}

    $date = gmdate('d/m/y h:i:s', time());
    $newfile = $pt_log_dir . 'paytium-' . gmdate('Y-m-d') . '.txt';
    $text = '[' . $date . ' UTC]['.$file.':'.$line.'] '. $message . PHP_EOL;

    // Append to the day's log file, creating it when it does not exist yet.
	// Silently skipped when the file cannot be opened (unwritable directory for example).
	// phpcs:ignore WordPress.WP.AlternativeFunctions -- the debug logger APPENDS single lines and is deliberately best-effort; WP_Filesystem may not be initialised this early, can prompt for FTP credentials, and offers no append mode.
	$fh = @fopen( $newfile, 'a' );

	if ( $fh !== false ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions -- the debug logger APPENDS single lines and is deliberately best-effort; WP_Filesystem may not be initialised this early, can prompt for FTP credentials, and offers no append mode.
		fwrite( $fh, $text );
		// phpcs:ignore WordPress.WP.AlternativeFunctions -- the debug logger APPENDS single lines and is deliberately best-effort; WP_Filesystem may not be initialised this early, can prompt for FTP credentials, and offers no append mode.
		fclose( $fh );
	}
}


/**
 * Convert amount to float.
 *
 * Convert a amount to a valid float amount. Used for storing in the DB for example.
 *
 *
 * @since 1.5.0
 *
 * @param string|float $amount
 * @return float Converted amount.
 */
function pt_user_amount_to_float( $amount ) {
	$decimals = apply_filters( 'paytium_amount_decimals', 2 );
	// Cast first: this is called with null in places, and str_replace() with a null
	// subject is deprecated on PHP 8.1+. (string) null is '' and floatval('') is 0.0,
	// so the result is unchanged.
	$amount = floatval( str_replace( ',', '.', (string) $amount ) );
	$amount = round( $amount, $decimals );

	return $amount;
}


/**
 * Currency formatted amount.
 *
 * Get the passed amount as a currency formatted amount.
 *
 * @since 1.5.0
 *
 * @param float $amount Amount to format.
 * @param string $currency
 * @param bool $add_currency_symbol
 *
 * @return string Formatted amount.
 */
function pt_float_amount_to_currency( $amount, $currency = 'EUR', $add_currency_symbol = true  ) {

	$currency = $currency ? $currency : 'EUR';
	$currency_symbol = get_paytium_currency_symbol($currency);
	if ( strpos( $amount, $currency_symbol ) !== false ) {
		return $amount;
	}

	$decimals = apply_filters( 'paytium_amount_decimals', 2 );
	$thousands_separator = apply_filters( 'paytium_thousands_separator', '.' );
	$decimal_separator = apply_filters( 'paytium_decimal_separator', ',' );

	$amount = pt_user_amount_to_float( $amount );
	$amount = number_format( $amount, $decimals, $decimal_separator, $thousands_separator );

	$currency_symbol_first = $currency == 'EUR' || $currency == 'USD' || $currency == 'GBP';

	if ( $add_currency_symbol == true) {
		$amount = $currency_symbol_first ? $currency_symbol . ' ' . $amount
										 : $amount . ' ' . $currency_symbol;
	}

	return $amount;
}


/**
 * Get Paytium currency symbol
 *
 * @param $currency_code
 * @return mixed
 * @since 4.3.0
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals -- renaming a registered hook callback is a silent breaking change for customer sites that remove_action() it; deferred to a major version.
function get_paytium_currency_symbol($currency_code) {

	$currency_symbols = array(
		'EUR' => '€',
		'USD' => '$',
		'GBP' => '£',
		'CHF' => 'fr.',
		'NOK' => 'NOK',
		'SEK' => 'SEK',
	);

	$currency_symbol = isset($currency_symbols[$currency_code]) ? $currency_symbols[$currency_code] : $currency_symbols[get_option('paytium_currency', 'EUR')];

	return $currency_symbol;
}


/**
 * Google Analytics campaign URL.
 *
 * @since   1.0.0
 *
 * @param  string $base_url Plain URL to navigate to
 * @param  string $source   GA "source" tracking value
 * @param  string $medium   GA "medium" tracking value
 * @param  string $campaign GA "campaign" tracking value
 *
 * @return string $url      Full Google Analytics campaign URL
 */
function pt_ga_campaign_url( $base_url, $source, $medium, $campaign ) {

	// $medium examples: 'sidebar_link', 'banner_image'

	$url = esc_url( add_query_arg( array (
		'utm_source'   => $source,
		'utm_medium'   => $medium,
		'utm_campaign' => $campaign
	), $base_url ) );

	return $url;

}

/**
 * Filters the content to remove any extra paragraph or break tags
 * caused by shortcodes.
 *
 * @since 1.0.0
 *
 * @param  string $content String of HTML content.
 *
 * @return string $content Amended string of HTML content.
 *
 * REF: https://thomasgriffin.io/remove-empty-paragraph-tags-shortcodes-wordpress/
 */
function pt_shortcode_fix( $content ) {

	$array = array (
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']'
	);

	return strtr( $content, $array );

}


add_filter( 'the_content', 'pt_shortcode_fix' );

/**
 * Is WordPress currently on localhost?
 *
 * @since   1.0.0
 * @author  David de Boer
 */
function pt_is_localhost() {

	$whitelist = array ( '127.0.0.1', '::1' );
	if ( in_array( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '', $whitelist, true ) ) {
		return true;
	}

}

/**
 * Prefill email field if user is logged in
 *
 * @since   1.1.0
 * @author  David de Boer
 */

function pt_prefill_email() {

	if ( is_user_logged_in() ) {
		$prefill = get_userdata( get_current_user_id() )->user_email;
	} else {
		$prefill = '';
	}

	return $prefill;
}

/**
 * Prefill name field if user is logged in
 *
 * @since   1.5.0
 * @author  David de Boer
 */

function pt_prefill_name() {

	if ( is_user_logged_in() ) {
		$prefill = get_userdata( get_current_user_id() )->user_firstname . ' ' . get_userdata( get_current_user_id() )->user_lastname;
	} else {
		$prefill = '';
	}

	return $prefill;
}

/**
 * Prefill first name field if user is logged in
 *
 * @since   1.5.0
 * @author  David de Boer
 */

function pt_prefill_first_name() {

	if ( is_user_logged_in() ) {
		$prefill = get_userdata( get_current_user_id() )->user_firstname;
	} else {
		$prefill = '';
	}

	return $prefill;
}

/**
 * Prefill last name field if user is logged in
 *
 * @since   1.5.0
 * @author  David de Boer
 */

function pt_prefill_last_name() {

	if ( is_user_logged_in() ) {
		$prefill = get_userdata( get_current_user_id() )->user_lastname;
	} else {
		$prefill = '';
	}

	return $prefill;
}

/**
 * Show a warning to editors and administrators about prefilled fields (so we get less requests about this)
 *
 * @since   2.1.0
 * @author  David de Boer
 */

function pt_prefill_warning( $counter ) {

	if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
		$html = '<span class="pt-field-prefill-warning pt-field-prefill-warning-hint" data-pt-prefill-warning-counter="' . $counter . '">' . __( 'Why do I see my own name/email?', 'paytium' ) . '</span>';
		$html .= '<span class="pt-field-prefill-warning pt-field-prefill-warning-explanation" id="pt-prefill-warning-counter-' . $counter . '">' . __( 'If a user is logged in to WordPress (like you are now), the above field will automatically fill in the name/email of that user. Others will not see your name/email, only their own, and only if they are logged in. This text is only shown to editors and administrators.', 'paytium' ) . '</span>';

		return $html;
	}

}

/**
 * Get a list of payments.
 *
 * Get a list with payments from the database.
 *
 * @since 1.0.0
 *
 * @param  array $args List of WP_Query arguments.
 *
 * @return array       WP_Query result.
 */
function pt_get_payments( $args = array () ) {

	$payment_args = wp_parse_args( $args, array (
		'post_type'     => 'pt_payment',
		'post_status'   => 'publish',
		'posts_per_page' => -1,
		'fields'        => 'ids',
	) );

	$posts         = new WP_Query( $payment_args );
	$payment_posts = $posts->posts;

	return $payment_posts;

}

/**
 * Check if site has live payments.
 *
 * @since 1.5.0
 *
 * @param  array $args List of WP_Query arguments.
 *
 * @return bool       true or false
 */
function pt_has_live_payments( $args = array () ) {

	$payment_args = wp_parse_args( $args, array (
		'post_type'   => 'pt_payment',
		'post_status' => 'publish',
		'orderby' => 'id',
		'order'   => 'DESC',

		'meta_query' => array (
			array (
				'key'     => '_mode',
				'value'   => 'live',
				'compare' => '='
			)
		),

		'fields'        => 'ids',
		'posts_per_page' => 1,
	) );

	$posts = new WP_Query( $payment_args );

	return $posts->have_posts();

}



/**
 * Unserialize a stored value and guarantee an array back.
 *
 * Paytium stores several options and meta values DOUBLE-serialized, because it
 * calls serialize() itself before handing the value to update_option() /
 * update_post_meta(), and WordPress' maybe_serialize() then serializes the
 * already-serialized string a second time. get_option() / get_post_meta() peel one
 * layer on read, so the second has to be peeled here. Affected values include
 * '_payments', 'paytium_item_limits', 'paytium_notifications',
 * 'paytium_payment_sources', '_pt_email_attachments' and '_pt-uploaded-files'.
 *
 * Call sites used to use unserialize() directly. On PHP 8 that is a fatal
 * TypeError the moment the stored value is not a serialized string - an array from
 * a single-serialized row, or false / '' when the option does not exist yet - and
 * the callers then run array_key_exists(), foreach or [] on the result, which
 * fatals in turn. Always returning an array makes all of those safe.
 *
 * Storage format is deliberately left alone: every existing row in every install
 * is double-serialized and changing the writer would need a data migration.
 *
 * @since 5.0.4
 *
 * @param  mixed $value Raw value from get_option() or get_post_meta().
 * @return array        Always an array; empty when there is nothing stored.
 */
function pt_unserialize_to_array( $value ) {

	$data = maybe_unserialize( $value );

	if ( is_array( $data ) ) {
		return $data;
	}

	if ( '' === $data || null === $data || false === $data ) {
		return array();
	}

	// A single bare value was stored instead of a list.
	return array( $data );

}