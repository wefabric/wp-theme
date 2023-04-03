<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		
		<?php woocommerce_product_loop_start(); ?>
            <?php
                echo view('components.slider.slider', [
                    'items' => $related_products,
                    'arrows' => false,
                    'dots' => false,
                    'card_type' => 'single-product-related',
                    'breakPoints' => [
                        640 => [ // when window width is >= 6400px
                            'slidesPerView' => 1,
                            'spaceBetween' => 20
                        ],
                        768 => [ // when window width is >= 768px
                            'slidesPerView' => 2,
                            'spaceBetween' => 20
                        ],
                        1024 => [ // when window width is >= 1024px
                            'slidesPerView' => 3,
                            'spaceBetween' => 20
                        ],
                        1350 => [ // when window width is >= 1350px
                            'slidesPerView' => 4,
                            'spaceBetween' => 20
                       ],
                    ],
                ]);
            ?>
		<?php woocommerce_product_loop_end(); ?>


	</section>
	<?php
endif;

wp_reset_postdata();

