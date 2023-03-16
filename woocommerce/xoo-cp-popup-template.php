<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
    return;
}

?>

<div class="xoo-cp-opac"></div>
<div class="xoo-cp-modal">

    <div class="xoo-cp-container p-6">
        <div class="flex justify-end">
            <i class="xoo-cp-close fa fa-close text-xl text-gray hover:text-primary transition-colors ease-in-out cursor-pointer"></i>
        </div>



        <div class="xoo-cp-outer">
            <div class="xoo-cp-cont-opac"></div>
            <span class="xoo-cp-preloader xoo-cp-icon-spinner"></span>
        </div>
        <span class="xoo-cp-close"></span>

        <div class="xoo-cp-content"></div>

        <div class="xoo-cp-btns flex flex-col gap-4 w-full lg:w-3/4">
            <a class="xoo-cp-btn-ch btn btn-secondary text-sm" href="<?php echo wc_get_checkout_url(); ?>"><?php _e('Afrekenen','added-to-cart-popup-woocommerce'); ?></a>
            <a class="xoo-cp-btn-vc btn btn-black text-sm" href="<?php echo wc_get_cart_url(); ?>"><?php _e('Bekijk winkelwagen','added-to-cart-popup-woocommerce'); ?></a>
            <div class="text-sm">of</div>
            <a class="xoo-cp-close text-primary text-sm cursor-pointer hover:underline"><?php _e('Verder winkelen','added-to-cart-popup-woocommerce'); ?></a>
        </div>

        <?php do_action('xoo_cp_before_btns'); ?>

        <?php do_action('xoo_cp_after_btns'); ?>
    </div>
</div>


<div class="xoo-cp-notice-box" style="display: none;">
    <div>
        <span class="xoo-cp-notice"></span>
    </div>
</div>
