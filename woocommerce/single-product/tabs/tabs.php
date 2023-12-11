<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
	
	<div style="clear:both">
		
		<div class="faq-drawer lg:px-0">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<div class="faq-drawer__block <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<input class="faq-drawer__trigger" id="faq-drawer-<?php echo esc_attr( $key ); ?>" type="checkbox" />
					<label class="faq-drawer__title p-6" for="faq-drawer-<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></label>
					
					<div class="faq-drawer__content-wrapper">
						<div class="faq-drawer__content z-20 p-6">
							<?php
							if ( isset( $product_tab['callback'] ) ) {
								call_user_func( $product_tab['callback'], $key, $product_tab );
							}
							?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		
		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	
	</div>


<?php endif; ?>
