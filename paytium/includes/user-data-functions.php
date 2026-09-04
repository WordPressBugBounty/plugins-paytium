<?php

/**
 * Paytium Users
 *
 * @package     PT/Users
 * @author      David de Boer <david@davdeb.com>
 * @license     GPL-2.0+
 * @link        https://www.paytium.nl
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create/update WordPress user and store user data as user meta in WordPress
 *
 *
 * @since 2.1.0
 */
function paytium_user_data_processing( $payment_post_id ) {

	if ( is_object( $payment_post_id ) ) {
		$payment_post_id = $payment_post_id->id;
	}

	// Get payment post meta
	$payment_field_data = get_post_meta( $payment_post_id, null, true );

	// Check if there are user data fields in the payment
	if ( count( preg_grep( '~\b-user-data\b~', array_keys( $payment_field_data ) ) ) < 1 ) {
		return;
	}

	// Only continue if status is paid
	$status = $payment_field_data['_status'][0];
    $last_status = get_post_meta( $payment_post_id, '_pt_user_data_last_status', true );

	if ( ( $status != 'paid' ) || ($last_status == 'paid') ) {
		return;
	}

	// Start adding user data fields to user data array
	$user_data[ $payment_post_id ] = array ();

	// Store payment ID (a.k.a post ID) in payment data too
	$user_data[ 'payment_data' ]['paytium_payment_id'] = $payment_post_id;

	foreach ( $payment_field_data as $key => $value ) {

		// Get field group ID and use it as array key
		$group_id = preg_replace( '/[^0-9]+/', '', $key );

		if ( strstr( $key, '_pt-field-email' ) ) {
			$user_data['user-email'] = 'true';
		}

		// Add these elements to user data too
		$include_meta = array (
			'paytium_customer_id'        => '_pt-customer-id',
			'paytium_payment_id'         => 'payment_post_id',
			'paytium_mollie_transaction' => '_payment_id', // Mollie transaction ID
			'payment_amount'             => '_amount',
			'paytium_description'        => '_description',
			'paytium_payment_mode'       => '_payment_mode',
		);
		if ( in_array( $key, $include_meta ) ) {
			$user_data['payment_data'][ array_search($key, $include_meta) ] = $value[0];
		}

        if ( $key == '_pt-user-role' ) {
            $user_data['user_role'][] = $value[0];
        }

        // Signature written by pt_set_signed_user_role_meta(), re-verified below
        if ( $key == '_pt-user-role-sig' ) {
            $user_data['user_role_sig'][] = $value[0];
        }

		// Add user data fields to user data array (for user meta)
		if ( strstr( $key, '_pt-field-' ) ) {

			// Convert label to a valid key that can be used for user meta (and prefix with paytium_)
			$label = 'paytium_' . sanitize_key( str_replace( ' ', '_', $value[0] ) );

			if ( $group_id !== '' ) {

				if ( strstr( $key, 'mailchimp' ) == false &&  strstr( $key, 'mailpoet' ) == false && strstr( $key, 'activecampaign' ) == false ) {

					if ( strstr( $key, $group_id ) == $group_id ) {
						$user_data[ $group_id ]['key']   = $key;
						$user_data[ $group_id ]['value'] = $value[0];
					} elseif ( strstr( $key, $group_id ) == $group_id . '-label' ) {
						$user_data[ $group_id ]['label'] = $label;
					} elseif ( strstr( $key, $group_id ) == $group_id . '-user-data' ) {
						$user_data[ $group_id ]['user-data'] = $value[0];
					}
				}
			}
		}

	}

	// If there is no user data in an array, what's the point? Unset it!
	if ( count( preg_grep( '~\buser-email\b~', array_keys( $user_data ) ) ) < 1 ) {
		unset( $user_data );
	} else {
		unset( $user_data['user-email'] );
	}

	// Validate and clean user data array
	foreach ( $user_data as $key => $value ) {

		if( $key == 'payment_data' || $key == 'user_role' || $key == 'user_role_sig' ) {
			continue;
		};

		// If there is no user data in an array, what's the point? Unset it!
		if ( count( preg_grep( '~\buser-data\b~', array_keys( $user_data[ $key ] ) ) ) < 1 ) {
			unset( $user_data[ $key ] );
			continue;
		}

	}

	//
	// Process user data array and move to new user array
	//

	// Create a user array with all details
	$user = array ();

	foreach ( $user_data as $key => $value ) {

		if ( $key == 'payment_data' ) {
			$user['payment_data'] = $value;
			continue;
		}
		if ( $key == 'user_role' ) {
			$user['user_role'] = $value[0];
			continue;
		}
		if ( $key == 'user_role_sig' ) {
			$user['user_role_sig'] = $value[0];
			continue;
		}
		if ( preg_match( '/(?<label>_pt-field-email-)[0-9]+$/', $value['key'] )  ) {
			$user['email'] = $value['value'];
			continue;
		}

		if ( preg_match( '/(?<label>_pt-field-name-)[0-9]+$/', $value['key'] ) ) {
			$user['name'] = $value['value'];
			continue;
		}

		if ( preg_match( '/(?<label>_pt-field-firstname-)[0-9]+$/', $value['key'] ) ) {
			$user['firstname'] = $value['value'];
			continue;
		}

		if ( preg_match( '/(?<label>_pt-field-lastname-)[0-9]+$/', $value['key'] ) ) {
			$user['lastname'] = $value['value'];
			continue;
		}

		$user['user_meta'][ $key ] = $user_data[ $key ];

	}

	// Move payment data to bottom of user array
	$payment_data = $user['payment_data'];
	unset($user['payment_data']);
	$user['payment_data'] = $payment_data;

	//
	// Start creating WordPress user
	//

	// Check if there are any users with the billing email as username or email
	$email = email_exists( $user['email'] );

    $user_role = get_option('default_role');

    if (isset($user['user_role']) && $user['user_role'] != '') {

        $claimed_role = $user['user_role'];
        $stored_sig   = isset($user['user_role_sig']) ? $user['user_role_sig'] : '';

        // Re-verify the signature at the point of use. The role meta is only trustworthy
        // when it carries the signature generated by the [paytium_user_data] shortcode,
        // so meta injected through any other route cannot decide the role here.
        if ( $stored_sig === '' || ! hash_equals( wp_hash( 'pt_user_role|' . $claimed_role ), $stored_sig ) ) {

            paytium_logger( $payment_post_id . ' - ' . 'Refused unsigned user role "' . $claimed_role . '", using the site default role instead (possible privilege-escalation attempt).',__FILE__,__LINE__);

        } elseif ( ! paytium_are_roles_assignable( $claimed_role ) ) {

            paytium_logger( $payment_post_id . ' - ' . 'Refused privileged user role "' . $claimed_role . '", using the site default role instead.',__FILE__,__LINE__);

        } else {

            $user_role = str_replace(" ","",$claimed_role);
            if (strstr($user_role, ',')) {
                $user_role = array_map( 'pt_resolve_role_slug', explode(',', $user_role) );
            } else {
                $user_role = pt_resolve_role_slug( $user_role );
            }
        }
    }

	if (is_array($user_role)) {
		$user_roles = $user_role;
		$user_role = '';
	}

	// Create a user if email is null or false
	if ( $email === false ) {

		// Random password with 12 chars
		$random_password = wp_generate_password();

        // Create a display name based on available data
		if ( isset($user['firstname']) && isset($user['lastname'])) {
			$user['name'] = $user['firstname'] . ' ' . $user['lastname'];
		}

		if ( isset($user['firstname']) && ! isset($user['lastname'])) {
			$user['name'] = $user['firstname'];
		}

		if ( ! isset($user['firstname']) && isset($user['lastname'])) {
			$user['name'] = $user['lastname'];
		}

		if (!empty($user_role)) {
			paytium_add_user_role($user_role);
		}

		// Create new user with email as username & newly created pw
		$user_id = wp_insert_user( array (
			'user_login'   => $user['email'],
			'display_name' => isset($user['name']) ? $user['name'] : '',
			'first_name'   => isset($user['firstname']) ? $user['firstname'] : '',
			'last_name'    => isset($user['lastname']) ? $user['lastname'] : '',
			'user_pass'    => $random_password,
			'user_email'   => $user['email'],
			'role'         => $user_role
		) );

        if (isset($user_roles)) {
            $current_user = get_userdata( $user_id );
            foreach ($user_roles as $role) {
				paytium_add_user_role($role);
                $current_user->add_role( $role );
            }
        }

		if( is_wp_error( $user_id) ) {
            paytium_logger( $payment_post_id . ' - ' . 'Creating a new user failed: ' . $user_id->get_error_message(),__FILE__,__LINE__);
		} else {
			wp_new_user_notification( $user_id, null, 'both' );
		}

	} else {
		$user_id = email_exists( $user['email'] );
		$current_user = get_userdata( $user_id );

			if (isset($user_roles)) {
				foreach ($user_roles as $role) {
					paytium_add_user_role($role);
					$current_user->add_role( $role );
				}
			}
			else {
				paytium_add_user_role($user_role);
				$current_user->add_role($user_role);
			}

	}

	wp_update_post(  array(
		'ID' => $payment_post_id,
		'post_author' => $user_id,
	) );

    if (isset($payment_field_data['_subscription_id']) && !empty($payment_field_data['_subscription_id'][0])) {
		wp_update_post(  array( // user profile
			'ID' => $payment_field_data['_subscription_id'][0],
			'post_author' => $user_id,
		) );
	}

	// Get WordPress user data
	$wp_user_data = get_userdata( $user_id );

	// Add form data as user meta
	foreach ( $user['user_meta'] as $key => $val ) {

		update_user_meta( $wp_user_data->ID, $val['label'], $val['value'] );

	}

	// Add payment data as user meta
	foreach ( $user['payment_data'] as $key => $val ) {

		update_user_meta( $wp_user_data->ID, $key, $val );

	}

    if ( ! add_post_meta( $payment_post_id, '_pt_user_data_last_status', 'paid', true ) ) {
        update_post_meta( $payment_post_id, '_pt_user_data_last_status', 'paid' );
    }

	// Get latest payment details with the updated payment status
	$payment_latest = pt_get_payment( $payment_post_id );

	// Add hook after user data processing
	do_action( 'paytium_after_paytium_user_data_processing', $payment_latest );


}

add_action( 'paytium_after_full_payment_saved', 'paytium_user_data_processing', 10, 3 );
add_action( 'paytium_after_pt_payment_update_webhook', 'paytium_user_data_processing', 10, 3 );
add_action( 'paytium_after_update_payment_from_admin', 'paytium_user_data_processing', 10, 3);

function paytium_add_user_role($role) {

	// Use the real slug when the role already exists, so a role added by another
	// plugin is never shadowed by a lowercase duplicate created here
	$role = pt_resolve_role_slug( $role );

	if ( ! wp_roles()->is_role( $role ) ) {
		$role = sanitize_key( $role );
	}

	if ( $role === '' || ! paytium_is_role_assignable( $role ) ) {
		return;
	}

	if (!wp_roles()->is_role( $role )) {
		add_role(
			$role,
			ucfirst($role),
			array(
				'read'  => true,
			)
		);

		paytium_logger('New user role "'.$role.'" has been added',__FILE__,__LINE__);
	}
}

/**
 * Capabilities that amount to full or near full control of the site.
 *
 * A role holding any of these is not handed out by a payment unless the site owner
 * says otherwise, see paytium_get_allowed_user_roles().
 *
 * @since 5.0.4
 */
function paytium_privileged_role_capabilities() {

	return apply_filters( 'paytium_privileged_role_capabilities', array(
		'manage_options',
		'edit_users',
		'create_users',
		'promote_users',
		'delete_users',
		'install_plugins',
		'activate_plugins',
		'edit_plugins',
		'install_themes',
		'edit_themes',
		'edit_files',
		'unfiltered_upload',
	) );
}

/**
 * Roles the site owner explicitly allows Paytium to assign.
 *
 * Only needed for roles that carry site administration capabilities, every other
 * role (including custom roles added by other plugins) is allowed already.
 *
 * @since 5.0.4
 */
function paytium_get_allowed_user_roles() {

	$allowed = get_option( 'paytium_allowed_user_roles', '' );

	if ( ! is_array( $allowed ) ) {
		$allowed = explode( ',', (string) $allowed );
	}

	$allowed = array_filter( array_map( 'sanitize_key', array_map( 'trim', $allowed ) ) );

	return apply_filters( 'paytium_allowed_user_roles', $allowed );
}

/**
 * All role slugs registered on this site, slug => display name.
 *
 * @since 5.0.4
 */
function pt_get_site_role_names() {

	if ( ! function_exists( 'wp_roles' ) ) {
		return array();
	}

	return wp_roles()->get_names();
}

/**
 * Resolve a role slug against the roles registered on this site.
 *
 * Roles added by other plugins do not always use a lowercase slug, so match case
 * insensitively and return the real slug when one is found. Returns the trimmed
 * input unchanged when the role does not exist (yet).
 *
 * @since 5.0.4
 */
function pt_resolve_role_slug($role) {

	$role = trim( $role );

	if ( $role === '' ) {
		return '';
	}

	$role_names = pt_get_site_role_names();

	if ( isset( $role_names[ $role ] ) ) {
		return $role;
	}

	foreach ( array_keys( $role_names ) as $slug ) {
		if ( strcasecmp( $slug, $role ) === 0 ) {
			return $slug;
		}
	}

	return $role;
}

/**
 * Check whether a role may be handed out by a payment.
 *
 * Custom roles added by other plugins are assignable: the check is capability
 * based, not a list of known role names. Only roles that could take over the site
 * are refused, so a form (or a bug in the meta pipeline) cannot turn a payment
 * into an administrator account. Site owners can allow such a role anyway through
 * the Allowed User Roles setting, developers through the
 * paytium_allow_privileged_user_role filter.
 *
 * @since 5.0.4
 */
function paytium_is_role_assignable($role) {

	$role = pt_resolve_role_slug( $role );

	if ( $role === '' ) {
		return false;
	}

	// Explicitly allowed by the site owner, no further questions
	if ( in_array( strtolower( $role ), paytium_get_allowed_user_roles(), true ) ) {
		return apply_filters( 'paytium_allow_privileged_user_role', true, $role );
	}

	$role_object = get_role( $role );

	if ( $role_object ) {

		// An existing role, from WordPress or from any other plugin. Judge it on what
		// it can actually do, so custom roles keep working without any configuration.
		foreach ( paytium_privileged_role_capabilities() as $cap ) {
			if ( ! empty( $role_object->capabilities[ $cap ] ) ) {
				return apply_filters( 'paytium_allow_privileged_user_role', false, $role );
			}
		}

		return true;
	}

	// The role does not exist yet, so paytium_add_user_role() will create it with the
	// 'read' capability only and it cannot be privileged. Refuse the well known
	// administrator names anyway, they should never be created here.
	if ( in_array( strtolower( $role ), array( 'administrator', 'superadmin', 'super-admin', 'super_admin' ), true ) ) {
		return apply_filters( 'paytium_allow_privileged_user_role', false, $role );
	}

	return true;
}

/**
 * Check a (possibly comma separated) list of roles with paytium_is_role_assignable().
 *
 * @since 5.0.4
 */
function paytium_are_roles_assignable($roles) {

	foreach ( explode( ',', str_replace( ' ', '', $roles ) ) as $role ) {

		if ( $role === '' ) {
			continue;
		}

		if ( ! paytium_is_role_assignable( $role ) ) {
			return false;
		}
	}

	return true;
}