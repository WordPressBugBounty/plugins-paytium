<?php
// Prevent direct file access; this file is only meaningful when loaded by WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="pt-alert pt-alert-danger pt-no-account-details-restart-wizard" style="display: none;">
	<?php echo esc_html__( 'No Mollie username or password found!', 'paytium' ) ?>
    <a target="_blank" href="javascript:void(0);" class="tab-button"
       data-target="connect-mollie"><?php echo esc_html__( 'Go back to step 1', 'paytium' ); ?> &rarr;</a>
</div>

<div id="pt-setup-first-payment-form-box" style="display: none;">

    <h3><?php esc_html_e( 'Create your first payment form', 'paytium' ); ?></h3>

    <p><?php esc_html_e( 'Now  Mollie account is set up, you can add a payment form to a page on your website. WordPress has it\'s own default "editor" called the "Classic editor". But, it\'s possible you might be using the "Block editor" or a page builder like Divi, Elementor or Beaver Builder.', 'paytium' ); ?></p>

    <p><?php printf(
        /* translators: %1$s: opening link tag, %2$s: closing link tag. */
        wp_kses_post( __( 'Click on the below tabs to see how you can add a payment form in your situation. If you have questions about this, just send me a %1$smessage%2$s and I will assist you.', 'paytium' ) ),
        '<a target="_blank" href="https://www.paytium.nl/contact/">',
        '</a>'
    ); ?></p>

    <div class="tabs-panels-wrap">
        <div class="tabs" id="first-product-tabs">
            <ul>
                <li class="active">
                    <a href="javascript:void(0);" data-target="classic"><?php esc_html_e( 'Classic editor', 'paytium' ); ?></a>
                </li>
                <li class="">
                    <a href="javascript:void(0);" data-target="block"><?php esc_html_e( 'Block editor', 'paytium' ); ?></a>
                </li>

                <li class="">
                    <a href="javascript:void(0);" data-target="divi"><?php esc_html_e( 'Divi', 'paytium' ); ?></a>
                </li>
                <li class="">
                    <a href="javascript:void(0);" data-target="elementor"><?php esc_html_e( 'Elementor', 'paytium' ); ?></a>
                </li>
                <li class="">
                    <a href="javascript:void(0);" data-target="other"><?php esc_html_e( 'Others', 'paytium' ); ?></a>
                </li>
            </ul>
        </div>

        <div class="panels" id="first-product-panels">

            <div id="classic" class="panel" style="inline">

                <p><?php esc_html_e( 'In the Classic editor you will find a small iDEAL icon with which you can add an example payment form to a page on your website. Experiment with adding one or multiple forms to see the differences. It\'s easy to remove a form if you don\'t need it. When you are done experimenting, choose the form that comes closest to your needs and customize it further.', 'paytium' ); ?></p>


                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'To add or edit fields in a form, view the "%1$sExtra fields%2$s" manual.', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/extra-velden/">',
                    '</a>'
                ); ?></p>

                <img class="editor-image" src="<?php echo esc_url( PT_URL . 'admin/img/setup-wizard/classic-editor.png' ); ?>"/>

                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'If this is your first time  working with shortcodes in WordPress, consider reading the manual "%1$sShortcodes for starters%2$s".', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/shortcodes-voor-beginners/">',
                    '</a>'
                ); ?></p>
                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag, %3$s: opening link tag, %4$s: closing link tag, %5$s: opening link tag, %6$s: closing link tag, %7$s: opening link tag, %8$s: closing link tag. */
                    wp_kses_post( __( 'Detailed instructions can be found in the %1$smanual%2$s, for example about %3$sdonations in WordPress%4$s or %5$srecurring payments%6$s. Or view %7$sall examples%8$s, from where you can copy and paste forms to your website.', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/donatie-knoppen-en-formulieren/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/recurring-payments">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/voorbeelden">',
                    '</a>'
                ); ?></p>
            </div>

            <div id="block" class="panel" style="display: none;">
                <div class="pt-alert pt-alert-info pt-alert-small"><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'If you don\'t like the Block editor, consider installing the %1$sClassic editor%2$s.', 'paytium' ) ),
                    '<a href="https://wordpress.org/plugins/classic-editor/" target="_blank"
                            rel="noopener noreferrer">',
                    '</a>'
                ); ?>
                </div>
                <p><?php printf(
                    /* translators: %1$s: replacement value, %2$s: replacement value. */
                    wp_kses_post( __( 'In the Block editor you can use the Paytium block. It can be added by typing %1$s/paytium%2$s. You can also add it by using the "Add block" button (a circle with a + in it) in the top left of the block editor.', 'paytium' ) ),
                    '<code>',
                    '</code>'
                ); ?></p>

                <p><?php esc_html_e( 'When adding a Paytium block, you can choose between a few example Paytium forms. You can add as many Paytium blocks as you want,  and also easily delete them. Feel free to add multiple blocks to experiment with the different forms.', 'paytium' ); ?></p>

                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'When you are done experimenting, choose the form that comes closest to your needs and edit it further. To add or edit fields in a form, view the manual "%1$sExtra
                        fields%2$s".', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/extra-velden/">',
                    '</a>'
                ); ?></p>

                <img class="editor-image" src="<?php echo esc_url( PT_URL . 'admin/img/setup-wizard/block-editor.png' ); ?>"/>
                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'If this is your first time  working with shortcodes in WordPress, consider reading the manual "%1$sShortcodes for starters%2$s".', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/shortcodes-voor-beginners/">',
                    '</a>'
                ); ?></p>
                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag, %3$s: opening link tag, %4$s: closing link tag, %5$s: opening link tag, %6$s: closing link tag, %7$s: opening link tag, %8$s: closing link tag. */
                    wp_kses_post( __( 'Detailed instructions can be found in the %1$smanual%2$s, for example about %3$sdonations in WordPress%4$s or %5$srecurring payments%6$s. Or view %7$sall examples%8$s, from where you can copy and paste forms to your website.', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/donatie-knoppen-en-formulieren/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/recurring-payments">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/voorbeelden">',
                    '</a>'
                ); ?></p>
            </div>

            <div id="divi" class="panel" style="display: none;">
                <p><?php esc_html_e( 'Divi uses modules to build a page. There are lot\'s of modules, for example to add text and buttons. A Paytium form van be added with module "Shortcode".', 'paytium' ); ?></p>

                <p><?php esc_html_e( 'To use Divi with Paytium, go to the page where you want to add a Paytium form. Open Divi and add a new module of type "Code". In the area "Content" add the Paytium shortcode.', 'paytium' ); ?></p>

                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag, %3$s: opening link tag, %4$s: closing link tag. */
                    wp_kses_post( __( 'You can copy and paste the Paytium shortcode from the manual "%1$sAll examples%2$s". Choose a form that comes closest to your needs and edit it further. To add or edit fields in a form, view the manual "%3$sExtra
                        fields%4$s".', 'paytium' ) ),
                    '<a
                            target="_blank" href="https://www.paytium.nl/handleiding/voorbeelden">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/extra-velden/">',
                    '</a>'
                ); ?></p>

                <img class="editor-image" src="<?php echo esc_url( PT_URL . 'admin/img/setup-wizard/divi-code-module.png' ); ?>"/>
                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'If this is your first time  working with shortcodes in WordPress, consider reading the manual "%1$sShortcodes for starters%2$s".', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/shortcodes-voor-beginners/">',
                    '</a>'
                ); ?></p>
                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag, %3$s: opening link tag, %4$s: closing link tag, %5$s: opening link tag, %6$s: closing link tag. */
                    wp_kses_post( __( 'Detailed instructions can be found in the %1$smanual%2$s, for example about %3$sdonations in WordPress%4$s or %5$srecurring payments%6$s.', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/donatie-knoppen-en-formulieren/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/recurring-payments">',
                    '</a>'
                ); ?></p>
            </div>

            <div id="elementor" class="panel" style="display: none;">
                <p><?php esc_html_e( 'Elementor uses widgets to build a page. There are lot\'s of widget, for example to add text and buttons. A Paytium form van be added with widget "Shortcode".', 'paytium' ); ?></p>

                <p><?php esc_html_e( 'To use Elementor with Paytium, go to the page where you want to add a Paytium form. Open Elementor and add a new widget of type "Shortcode". Use search
                    (1) to find the widget, drag the widget (2) to the area (3) where you want to use it. In the area beneath "Insert your shortcode here" add the Paytium form.', 'paytium' ); ?></p>

                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag, %3$s: opening link tag, %4$s: closing link tag. */
                    wp_kses_post( __( 'You can copy and paste the Paytium shortcode from the manual "%1$sAll examples%2$s". Choose a form that comes closest to your needs and edit it further. To add or edit fields in a form, view the manual "%3$sExtra
                        fields%4$s".', 'paytium' ) ),
                    '<a
                            target="_blank" href="https://www.paytium.nl/handleiding/voorbeelden">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/extra-velden/">',
                    '</a>'
                ); ?></p>

                <img class="editor-image"
                     src="<?php echo esc_url( PT_URL . 'admin/img/setup-wizard/elementor-shortcode-widget.png' ); ?>"/>
                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'If this is your first time  working with shortcodes in WordPress, consider reading the manual "%1$sShortcodes for starters%2$s".', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/shortcodes-voor-beginners/">',
                    '</a>'
                ); ?></p>
                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag, %3$s: opening link tag, %4$s: closing link tag, %5$s: opening link tag, %6$s: closing link tag. */
                    wp_kses_post( __( 'Detailed instructions can be found in the %1$smanual%2$s, for example about %3$sdonations in WordPress%4$s or %5$srecurring payments%6$s.', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/donatie-knoppen-en-formulieren/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/recurring-payments">',
                    '</a>'
                ); ?></p>
            </div>

            <div id="other" class="panel" style="display: none;">
                <p><?php esc_html_e( 'Unfortunatly I can\'t add an explanation for all WordPress page builders and editors. Luckily they all kind of work the same way. View the tabs for Divi or Elementor to get a general idea.', 'paytium' ); ?></p>

                <p><?php esc_html_e( 'In most cases you need to add a block that allows you to insert a shortcode in the page. Such a block could be called a module, block or widget. A "Text" block can sometimes be used for displaying a shortcode, but you\'ll probably need to search for a block named "Code", "HTML" or "Shortcode". The developer or documentation of your page builder can probably help (and otherwise a Google search). ', 'paytium' ); ?></p>

                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'If you have questions about this, just send me a %1$smessage%2$s and I will assist you.', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/contact/">',
                    '</a>'
                ); ?></p>


                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag, %3$s: opening link tag, %4$s: closing link tag. */
                    wp_kses_post( __( 'You can copy and paste the Paytium shortcode from the manual "%1$sAll examples%2$s". Choose a form that comes closest to your needs and edit it further. To add or edit fields in a form, view the manual "%3$sExtra
                        fields%4$s".', 'paytium' ) ),
                    '<a
                            target="_blank" href="https://www.paytium.nl/handleiding/voorbeelden">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/extra-velden/">',
                    '</a>'
                ); ?></p>

                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag. */
                    wp_kses_post( __( 'If this is your first time  working with shortcodes in WordPress, consider reading the manual "%1$sShortcodes for starters%2$s".', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/shortcodes-voor-beginners/">',
                    '</a>'
                ); ?></p>
                <p><?php printf(
                    /* translators: %1$s: opening link tag, %2$s: closing link tag, %3$s: opening link tag, %4$s: closing link tag, %5$s: opening link tag, %6$s: closing link tag. */
                    wp_kses_post( __( 'Detailed instructions can be found in the %1$smanual%2$s, for example about %3$sdonations in WordPress%4$s or %5$srecurring payments%6$s.', 'paytium' ) ),
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/donatie-knoppen-en-formulieren/">',
                    '</a>',
                    '<a target="_blank" href="https://www.paytium.nl/handleiding/recurring-payments">',
                    '</a>'
                ); ?></p>
            </div>


            <div class="clear"></div>
        </div>

    </div>