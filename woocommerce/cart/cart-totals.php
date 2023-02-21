<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
    <div class="p-8">
	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h3 class="mb-6"><?php esc_html_e( 'Cart totals', 'woocommerce' ); ?></h3>

    <div class="cart-subtotal flex mb-6"">
        <div class="grow font-bold"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
        <div><?php wc_cart_totals_subtotal_html(); ?></div>
    </div>

    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <div class="cart-discount flex coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <div class="grow"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
            <div class=""><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
        </div>
    <?php endforeach; ?>

    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

        <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

        <?php wc_cart_totals_shipping_html(); ?>

        <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

    <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

        <div class="shipping flex>
            <div class="grow"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></div>
            <div class=""><?php woocommerce_shipping_calculator(); ?></div>
        </div>

    <?php endif; ?>
    </div>
        <div class="coupon py-8">
            <div class="px-8">
                <div class="flex items-center">
                    <div class="cursor-pointer text-primary show-cart-coupon-totals-toggle">Waardeboncode invoeren </div>
                    <div class="text-black pl-1 grow">(niet verplicht)</div>
                    <div class="cursor-pointer fa-solid fa-chevron-down show-cart-coupon-totals-toggle"></div>
                </div>

                <div class="show-cart-coupon-totals-wrapper flex lg:flex-row flex-col mt-4 gap-1 hidden">
                    <input type="text" name="coupon_code_totals" class="grow rounded-md" placeholder="Vul waardebon in"/>
                    <button class="button apply_coupon_code_totals float-right">Toepassen</button>
                </div>
            </div>
        </div>
    <div class="p-8">

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <div class="fee flex mb-6">
                <div class="grow font-bold"><?php echo esc_html( $fee->name ); ?></div>
                <div class=""><?php wc_cart_totals_fee_html( $fee ); ?></div>
            </div>
        <?php endforeach; ?>

        <?php
        if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';

            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                /* translators: %s location. */
                $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
            }

            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                    ?>
                    <div class="tax-rate flex mb-6 tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <div class="grow font-bold"><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                        <div class=""><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="tax-total flex mb-6">
                    <div class="grow font-bold "><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                    <div class=""><?php wc_cart_totals_taxes_total_html(); ?></div>
                </div>
                <?php
            }
        }
        ?>

        <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

        <div class="order-total order_total_price flex mb-8 pt-4">
            <div class="grow font-bold"><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
            <div class=""><?php wc_cart_totals_order_total_html(); ?></div>
        </div>

        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
    </div>
</div>



