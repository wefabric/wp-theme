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

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
/**
 * @var WC_Product $product
 */
if (empty($product) || !$product->is_visible()) {
    return;
}
?>

<div <?php wc_product_class('card group flex flex-col justify-between p-5 bg-white ', $product); ?> >
    <div class="wrapper relative h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">

        <?php //min-h-[488px] lg:min-h-[465px]      pb-32 relative
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>

        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action('woocommerce_before_shop_loop_item_title');
        ?>

        <div class="overflow-hidden overlay-wrapper w-full relative">
            <a href="<?php echo $product->get_permalink(); ?>" aria-label="Ga naar productpagina"
               class="overlay absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
            <?php
            echo view('components.image', [
                'image_id' => $product->get_image_id(),
                'size' => 'product_card',
                'class' => ' flex justify-center object-cover w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 ',
                'img_class' => '',
            ])->render();
            ?>
        </div>


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
            do_action('woocommerce_shop_loop_item_title');


            /**
             * Hook: woocommerce_after_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            ?>
            <?php
            $bouwjaar = $product->get_attribute('bouwjaar');

            // Check if the attribute has a value
            if (!empty($bouwjaar)) {
                // Display the attribute value
                echo '<div class="product-bouwjaar">' . esc_html__('Bouwjaar:', 'text-domain') . ' ' . $bouwjaar . '</div>';
            }
            ?>
            <div class="flex flex-row space-x-4 button-wrapper">
                <?php echo view('components.buttons.default', [
                    'href' => $product->get_permalink(),
                    'text' => 'Meer info',
                    'colors' => 'info-button btn-black text-white'
                ])->render(); ?>

                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item.
                 *
                 * @hooked woocommerce_template_loop_product_link_close - 5
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action('woocommerce_after_shop_loop_item');
                ?>
            </div>
        </div>
    </div>

</div>