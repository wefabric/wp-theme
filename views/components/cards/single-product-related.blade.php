@php
    if(! isset($related_product)) {
        $related_product = $item;
    }

    $post_object = get_post( $related_product->get_id() );

    setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

    wc_get_template_part( 'content', 'product' ); // includes the file: woocommerce/content-product.php

@endphp
