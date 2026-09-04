<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * @var PT_Payment $payment
 */

$files = pt_unserialize_to_array(get_post_meta($payment->id, '_pt-uploaded-files', true));
$i = 1;
?>

<div class="pt-files">
    <?php foreach($files as $name => $url) : ?>
        <p>
            <span>#<?php echo esc_attr( $i ) ?></span>
            <a href="<?php echo esc_url( $url ); ?>" class="pt-uploaded-file" target="_blank"><?php echo esc_html( $name ); ?></a>
        </p>
    <?php $i++; endforeach; ?>
</div>

