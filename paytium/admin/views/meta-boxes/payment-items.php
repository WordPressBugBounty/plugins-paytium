<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * @var PT_Payment $payment
 */

?><div class="payment-items-meta-box">
    <table class="widefat payment-items-table" style="width: 100%">
    <thead>
    <tr>
        <th><?php _e( 'Item', 'paytium' ); ?></th>
        <th><?php _e( 'Amount', 'paytium' ); ?></th>
        <?php if ( $payment->get_tax_total() ) : ?>
            <th><?php _e( 'Taxes', 'paytium' ); ?></th>
        <?php endif; ?>
        <th><?php _e( 'Total', 'paytium' ); ?></th>
    </tr>
    </thead>



    <tbody><?php
foreach ($payment->get_items() as $item) :
	if ($item->get_amount() != 0) : ?>
        <tr>
        <td style="width: 50%; padding-right: 30px;"><?php echo esc_html($item->get_label()) . ' ' .  esc_html($item->get_value()); ?></td>
        <td><?php echo esc_html(pt_float_amount_to_currency($item->get_amount(), $payment->currency)); ?></td><?php
		if ($item->get_tax_amount()) :
			?>
            <td><?php echo esc_html(pt_float_amount_to_currency($item->get_tax_amount(), $payment->currency)); ?>
            <small class="muted">(<?php echo esc_html(absint($item->get_tax_percentage())); ?>%)</small></td><?php
		endif;
		?>
        <td><?php echo esc_html(pt_float_amount_to_currency($item->get_total_amount(), $payment->currency)); ?></td>
        </tr><?php
	endif;
endforeach;
if ($payment->is_discount()) : ?>
    <tr>
        <td>Discount (<?php echo $payment->get_discount_value() ?>)</td>
        <td></td>
        <td></td>
<!--        <td style="color:darkred;text-align:left">-->
<!--			--><?php //if ( $payment->get_tax_total() ) :
//				echo esc_html(pt_float_amount_to_currency( $payment->discount_tax_calculate($payment->get_tax_total())['tax_discount'] - $payment->get_discount_amount(), $payment->currency));
//			endif; ?>
<!--        </td>-->
<!--		--><?php
//		if ( $payment->get_tax_total() ) :
//			?><!--<td style="color:darkred;text-align:left">--><?php //echo esc_html(pt_float_amount_to_currency( - $payment->discount_tax_calculate($payment->get_tax_total())['tax_discount'], $payment->currency )); ?><!--</td>--><?php
//		endif;
//		?>
        <td style="color:darkred;text-align:left"><?php echo esc_html(pt_float_amount_to_currency( -(float)$payment->get_discount_amount(), $payment->currency )); ?></td>
    </tr>
<?php endif; ?>
    </tbody>
    </table>