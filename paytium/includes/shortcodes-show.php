<?php
/**
 * Plugin shortcode functions for [paytium_show /]
 *
 * @package   PT
 * @author    David de Boer <david@davdeb.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Function to process the [paytium_show /] shortcode
 *
 * @since   1.0.0
 */
function pt_paytium_show_shortcode( $attr, $content = null ) {

	extract( shortcode_atts( array (
		'quantity' => '',
		'amount'   => '',
		'type'     => '',
		'id'       => '',
		'cache'    => '',
	), $attr, 'paytium' ) );

	$show_id  = sanitize_text_field( $id );
	$type     = sanitize_text_field( $type );
	$quantity = sanitize_text_field( ( ! empty( $attr[0] ) ) ? $attr[0] : '' );
	$amount   = sanitize_text_field( ( ! empty( $attr[0] ) ) ? $attr[0] : '' );

	$html = '';

	$transient = get_transient( 'pt_show_' . hash( 'md5', $type . '_' . $amount . '_' . $show_id ) );

	if ( ! isset( $_GET['pt-payment'] ) && $transient !== false ) {
		$html = $transient;

		return $html;
	}

	// Check first if in live or test mode.
	if ( get_option( 'paytium_enable_live_key', false ) == 1 ) {
		$current_mode = 'live';
	} else {
		$current_mode = 'test';
	}

	$args = array (
		'post_type'   => 'pt_payment',
		'post_status' => 'publish',

		'meta_query' => array (
			array (
				'key'     => '_mode',
				'value'   => $current_mode,
				'compare' => '='
			),
			array (
				'key'     => '_status',
				'value'   => 'paid',
				'compare' => '='
			)
		),

		'fields'         => 'ids',
		'posts_per_page' => - 1,
	);

	if ( $type == 'crowdfunding' ) {

		$args['meta_query'][] = array (
			'key'     => '_crowdfunding_id',
			'value'   => $show_id,
			'compare' => '='
		);

	}

	if ( $type == 'source' ) {

		$args['meta_query'][] = array (
			'key'     => '_source_id',
			'value'   => $show_id,
			'compare' => '='
		);

	}
	if ( $type == 'description' ) {

		$args['meta_query'][] = array (
			'key'     => '_description',
			'value'   => $show_id,
			'compare' => 'LIKE'
		);

	}


	$args = wp_parse_args( $args );


	$payments = new WP_Query( $args );

	if ( $amount === 'amount' ) {

		$total_amount = array();
		$currencies = array();
		$default_currency = 'EUR';

		foreach ( $payments->posts as $id ) {
			$post_meta = get_post_meta( $id );
			$currency = isset($post_meta['_currency']) && $post_meta['_currency'] ? $post_meta['_currency'][0] : $default_currency;
			foreach ( $post_meta as $key => $value ) {
				if ( strstr( $key, '-total-amount' ) ) {
					$total_amount[$currency] = isset($total_amount[$currency]) ? $total_amount[$currency] + $value[0] : $value[0];
				}
				if ( strstr($key,'_currency') && !in_array($value[0], $currencies)) {
					$currencies[] = $value[0];
				}
			}
		}

		$html = '<div class="paytium-show-section">';
		if ($currencies > 1) {
			foreach ($total_amount as $key => $value) {
				$html .= '<div class="paytium-show-item paytium-show-currency-'.strtolower($key).'">'.$key.': '.pt_float_amount_to_currency( $value, $key ).'</div>';
			}
		}
		else {
			$html .= pt_float_amount_to_currency( $total_amount[$currencies[0]], $currencies[0] );
		}
		$html .= '</div>';

	}

	if ( $quantity === 'quantity' ) {

		$total_quantity = 0;

		foreach ( $payments->posts as $id ) {
			$total_quantity ++;
		}

		$html = $total_quantity;

	}

	$cache_duration = pt_parse_cache_duration( $attr['cache'] ?? '5 hours' );
	if ( $cache_duration > 0 ) {
		set_transient( 'pt_show_' . hash( 'md5', $type . '_' . $amount . '_' . $show_id ), $html, $cache_duration );
	}

	$html .= do_shortcode( $content );

	return $html;

}

add_shortcode( 'paytium_show', 'pt_paytium_show_shortcode' );

/**
 * Parse a human-readable cache duration string into seconds.
 *
 * Supports: "30 minutes", "1 hour", "2 hours", "1 day", "0", "false", "none"
 * Returns 0 to disable caching, or seconds as integer.
 */
function pt_parse_cache_duration( string $input ): int {
	$input = strtolower( trim( $input ) );

	// Disable caching
	if ( in_array( $input, [ '0', 'false', 'none', 'off', 'no' ], true ) ) {
		return 0;
	}

	$units = [
		'second'  => 1,
		'seconds' => 1,
		'sec'     => 1,
		's'       => 1,
		'minute'  => MINUTE_IN_SECONDS,
		'minutes' => MINUTE_IN_SECONDS,
		'min'     => MINUTE_IN_SECONDS,
		'm'       => MINUTE_IN_SECONDS,
		'hour'    => HOUR_IN_SECONDS,
		'hours'   => HOUR_IN_SECONDS,
		'hr'      => HOUR_IN_SECONDS,
		'h'       => HOUR_IN_SECONDS,
		'day'     => DAY_IN_SECONDS,
		'days'    => DAY_IN_SECONDS,
		'd'       => DAY_IN_SECONDS,
		'week'    => WEEK_IN_SECONDS,
		'weeks'   => WEEK_IN_SECONDS,
		'w'       => WEEK_IN_SECONDS,
	];

	// Match "30 minutes", "1hour", "2 h", etc.
	if ( preg_match( '/^(\d+)\s*([a-z]+)$/', $input, $matches ) ) {
		$value = (int) $matches[1];
		$unit  = $matches[2];

		if ( isset( $units[ $unit ] ) ) {
			return $value * $units[ $unit ];
		}
	}

	// Plain integer — treat as seconds
	if ( ctype_digit( $input ) ) {
		return (int) $input;
	}

	// Unrecognized — fall back to plugin default
	return 5 * HOUR_IN_SECONDS;
}
