<?php

/**
 * Sidebar portion of the administration dashboard view.
 *
 * @package    PT
 * @subpackage views
 * @author     David de Boer <david@davdeb.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!-- BASIC -->

<div class="sidebar-container metabox-holder">
    <div class="postbox">
        <h3 class="wp-ui-primary"><span><?php esc_html_e( 'iDEAL payments - the easy way', 'paytium' ); ?></span></h3>

        <div class="inside">
            <div class="main">

                <ul>
                    <li>
                        <div class="dashicons dashicons-yes"></div>
                         <a href="https://www.paytium.nl/bestelformulier-wordpress-woocommerce/" target="_blank">
                             <?php esc_html_e( 'Accept payments on your website', 'paytium' ); ?>
                         </a>
                    </li>

                    <li>
                        <div class="dashicons dashicons-yes"></div>
                        <a href="https://www.paytium.nl/handleiding/recurring-payments/" target="_blank">
                            <?php esc_html_e( 'Recurring payments for subscriptions', 'paytium' ); ?>
                        </a>
                    </li>
                    <li>
                        <div class="dashicons dashicons-yes"></div>
                         <a href="https://www.paytium.nl/handleiding/donatie-knoppen-en-formulieren/" target="_blank">
                             <?php esc_html_e( 'Collect donations with open amounts', 'paytium' ); ?>
                         </a>
                    </li>
                    <li>
                        <div class="dashicons dashicons-yes"></div> <?php esc_html_e( 'For iDEAL, Bancontact and more', 'paytium' ); ?>
                    </li>
                </ul>

                <hr/>
                <ul>
                    <li>
                        <div class="dashicons dashicons-arrow-right-alt2"></div>
                        <a href="https://www.paytium.nl/handleiding/"
                           target="_blank">
							<?php esc_html_e( 'Manual', 'paytium' ); ?></a>
                    </li>
                    <li>
                        <div class="dashicons dashicons-arrow-right-alt2"></div>
                        <a href="mailto:support@paytium.nl" target="_blank">
						<?php esc_html_e( 'Email support', 'paytium' ); ?>

							</a>
                    </li>
                    <li>
                        <div class="dashicons dashicons-arrow-right-alt2"></div>
                        <a href="https://my.mollie.com/dashboard/signup/335035" target="_blank">
							<?php esc_html_e( 'Mollie.com', 'paytium' ); ?></a>
                    </li>
                    <li>
                        <div class="dashicons dashicons-arrow-right-alt2"></div>
                        <a href="https://www.paytium.nl/prijzen/" target="_blank" style="">
			                <?php esc_html_e( 'Pro versions', 'paytium' ); ?></a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
