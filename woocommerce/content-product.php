<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
/**
 * @var WC_Product $product
 */
if(empty($product) || !$product->is_visible()) {
	return;
}
?>

<div <?php wc_product_class( 'card flex flex-col justify-between p-5 bg-white ', $product );  ?> >
	<?php //min-h-[488px] lg:min-h-[465px]      pb-32 relative
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>
	
	<h3 class="h5 py-2">
		<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
		
		echo view('components.image', [
			'image_id' => $product->get_image_id(),
			'size' => 'product_card',
			'class' => ' flex justify-center',
			'img_class' => '',
		])->render();
		
		?>
	</h3>
	
	<div class="pt-2.5 pb-5">
		<div class="card-category-title w-full pb-2">
			<?php echo $product->get_attribute('brand'); ?>
		</div>
		
		<?php //absolute bottom-0
		/**
		* Hook: woocommerce_shop_loop_item_title.
		*
		* @hooked woocommerce_template_loop_product_title - 10
		*/
		do_action( 'woocommerce_shop_loop_item_title' );
	
		/**
		* Hook: woocommerce_after_shop_loop_item_title.
		*
		* @hooked woocommerce_template_loop_rating - 5
		* @hooked woocommerce_template_loop_price - 10
		*/
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		
		<div class="flex flex-row">
			<?php echo view('components.buttons.default', [
				'href' => $product->get_permalink(),
				'text' => 'Meer info',
				'colors' => 'btn-black text-white'
			])->render(); ?>
			
			<div class="flex grow"></div>
			
			<?php
			/**
			 * Hook: woocommerce_after_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
		</div>
	</div>

</div>