<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="md:px-8">
    <div class="shop_table woocommerce-checkout-review-order-table">

        <div class="flex gap-2 font-bold">
            <div class=" product-name w-2/3"><?php esc_html_e( 'Product', 'woocommerce' ); ?></div>
            <div class="product-quantity w-1/6 "><?php esc_html_e( 'Aantal', 'woocommerce' ); ?></div>
            <div class="product-total w-1/6 text-right grow"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
        </div>


        <?php
        do_action( 'woocommerce_review_order_before_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                ?>
                <div class="flex gap-2 pt-4 pb-4 border-b-2 border-black <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <div class="product-name w-2/3" >
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
                        <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                    <div class="product-quantity w-1/6">
                        <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                    <div class="product-total w-1/6 grow text-right">
                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                </div>
                <?php
            }
        }

        do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>
    </div>


    <div class="cart_totals">
        <div class="cart-subtotal flex mt-12 mb-6">
            <div class="grow font-bold"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
            <div><?php wc_cart_totals_subtotal_html(); ?></div>
        </div>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <div class="cart-discount flex mb-6 coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <div class="grow font-bold"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
                <div><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
            </div>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

            <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

            <?php wc_cart_totals_shipping_html(); ?>

            <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <div class="fee flex mb-6">
                <div class="grow font-bold"><?php echo esc_html( $fee->name ); ?></div>
                <div><?php wc_cart_totals_fee_html( $fee ); ?></div>
            </div>
        <?php endforeach; ?>

        <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
            <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                    <div class="tax-rate flex mb-6 mt-6 tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <div class="grow font-bold"><?php echo esc_html( $tax->label ); ?></div>
                        <div><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="tax-total flex mb-6">
                    <div class="grow font-bold"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
                    <div><?php wc_cart_totals_taxes_total_html(); ?></div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
    </div>
</div>

    <div class="coupon py-8">
        <div class="px-8">
            <div class="flex items-center">
                <div class="cursor-pointer text-primary show-cart-coupon-totals-toggle">Waardeboncode invoeren </div>
                <div class="text-black pl-1 grow">(niet verplicht)</div>
                <div class="cursor-pointer fa-solid fa-chevron-down show-cart-coupon-totals-toggle rotate-chevron"></div>
            </div>

            <div class="show-cart-coupon-totals-wrapper flex lg:flex-row flex-col mt-4 gap-1 hidden">
                <input type="text" name="coupon_code_totals" class="grow rounded-md" placeholder="Vul waardebon in"/>
                <button class="button apply_coupon_code_totals float-right">Toepassen</button>
            </div>
        </div>
    </div>

    <div class="md:px-8 py-6">
        <div class="order-total order_total_price flex">
            <div class="grow font-bold"><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
            <div><?php wc_cart_totals_order_total_html(); ?></div>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>


