<?php

use Themosis\Core\Application;

/*
|--------------------------------------------------------------------------
| Bootstrap Theme
|--------------------------------------------------------------------------
|
| We bootstrap the theme. The following code is loading your theme
| configuration files and register theme images sizes, menus, sidebars,
| theme support features and templates.
|
*/
$theme = (Application::getInstance())->loadTheme(__DIR__, 'config');

/*
|--------------------------------------------------------------------------
| Theme i18n | l10n
|--------------------------------------------------------------------------
|
| Registers the "languages" directory for storing the theme translations.
|
| The "THEME_TD" constant is defined during bootstrap and its value is
| set based on the "style.css" [Text Domain] property located into
| the file header.
|
*/
load_theme_textdomain(
    THEME_TD,
    $theme->getPath($theme->getHeader('domain_path'))
);

/*
|--------------------------------------------------------------------------
| Theme assets locations
|--------------------------------------------------------------------------
|
| You can define your theme assets paths and URLs. You can add as many
| locations as you want. The key is your asset directory path and
| the value is its public URL.
|
*/
$theme->assets([
    $theme->getPath('dist') => $theme->getUrl('dist')
]);

/*
|--------------------------------------------------------------------------
| Theme Views
|--------------------------------------------------------------------------
|
| Register theme view paths. By default, the theme is registering
| the "views" directory but you can add as many directories as you want
| from the theme.php configuration file.
|
*/
$theme->views($theme->config('theme.views', []));

/*
|--------------------------------------------------------------------------
| Theme Service Providers
|--------------------------------------------------------------------------
|
| Register theme service providers. You can manage the list of
| services providers through the theme.php configuration file.
|
*/
$theme->providers($theme->config('theme.providers', []));

/*
|--------------------------------------------------------------------------
| Theme includes
|--------------------------------------------------------------------------
|
| Auto includes files by providing one or more paths. By default, we setup
| an "inc" directory within the theme. Use that "inc" directory to extend
| your theme features. Nested files are also included.
|
*/
$theme->includes([
    $theme->getPath('inc')
]);

/*
|--------------------------------------------------------------------------
| Theme Image Sizes
|--------------------------------------------------------------------------
|
| Register theme image sizes. Image sizes are configured in your theme
| images.php configuration file.
|
*/
$theme->images($theme->config('images'));

/*
|--------------------------------------------------------------------------
| Theme Menu Locations
|--------------------------------------------------------------------------
|
| Register theme menu locations. Menu locations are configured in your theme
| menus.php configuration file.
|
*/
$theme->menus($theme->config('menus'));

/*
|--------------------------------------------------------------------------
| Theme Sidebars
|--------------------------------------------------------------------------
|
| Register theme sidebars. Sidebars are configured in your theme
| sidebars.php configuration file.
|
*/
$theme->sidebars($theme->config('sidebars'));

/*
|--------------------------------------------------------------------------
| Theme Support
|--------------------------------------------------------------------------
|
| Register theme support. Support features are configured in your theme
| support.php configuration file.
|
*/
$theme->support($theme->config('support', []));

/*
|--------------------------------------------------------------------------
| Theme Templates
|--------------------------------------------------------------------------
|
| Register theme templates. Templates are configured in your theme
| templates.php configuration file.
|
*/
$theme->templates($theme->config('templates', []));

//Woocommerce actions

add_theme_support( 'post-thumbnails' );


//add_action( 'woocommerce_before_shop_loop', function () {
//	$terms = get_terms( 'product_cat', [
//		'parent' => get_queried_object_id(),
//		'exclude' => [
//			'24', //term id of 'uncategorized'
//		],
//	]);
//
//	if ($terms) {
//		echo view('components.slider.grid', [
//			'items' => $terms,
//			'card_type' => 'category',
//			'grid_class' => 'product-cats w-full',
//		])->render();
//
//		echo '<h2 id="products-start" class="text-36 font-head mt-4 lg:mt-0 lg:pt-20 lg:pb-12">Alle producten</h2>';
//	}
//}, 50);

add_filter( 'loop_shop_per_page', function ($number_of_posts) {
	return 12; //products per page
}, 20);
add_filter('loop_shop_columns', function () {
	return 3; //product-columns per page
}, 1); //DOESNT work, see the _product_archive.scss styling for .products as temp fix.

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
add_filter('woocommerce_product_loop_title_classes', function ($class) {
	return $class .' h5 text-black pb-6';
});

// See content-single-product.php # 49
add_action('woocommerce_single_product_summary', function() {
	global $product;
	echo '<span class="h5 pb-2">'. $product->get_attribute('brand') .'</span>';
}, 3);






add_action('woocommerce_single_product_summary', function() {
    global $product;
	echo view('woocommerce.single-product.additional-summary', ['product' => $product])->render();
}, 8);
//add_action('woocommerce_single_product_summary', function() {
//	global $product;
//	echo '<div class="text-xs font-bold pt-2 pb-8">'. wc_price(wc_get_price_excluding_tax($product)) .' excl. BTW</div>';
//}, 11);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', function() {
    global $product;
    echo view('woocommerce.single-product.technical-sheet', ['product' => $product])->render();
}, 20);


add_action('woocommerce_single_product_summary', function() {
    global $product;
    echo view('woocommerce.single-product.quote', ['product' => $product])->render();
}, 60);

add_filter('woocommerce_product_single_add_to_cart_text', function () {
	return 'In winkelwagen';
});

add_filter( 'woocommerce_page_title', function ( $page_title ) {
	$page_title = str_replace('&ldquo;', '"', $page_title);
	$page_title = str_replace('&rdquo;', '"', $page_title);
	return $page_title;
}, 10, 2 ); //Fix quotes on search page title. Would otherwise show the literal strings.

//Move the description tabs from <after the summary> to <after the thumbnails>
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_product_data_tabs', 99 );

// Align the 'add to cart' button on the right
add_action('woocommerce_before_add_to_cart_form', function() {
	echo '<div class="flex justify-end">';
});
add_action('woocommerce_after_add_to_cart_form', function() {
	echo '</div>';
});

add_action('woocommerce_before_cart_table', function() {
	echo '<h2 class="cart-title">'. __('Cart', 'woocommerce') .'</h2>';
});
add_action('woocommerce_cart_is_empty', function() {
	echo '<h2 class="cart-title">'. __('Cart', 'woocommerce') .'</h2>';
}, 1);

add_action('woocommerce_before_add_to_cart_button', function() {
	echo '<input type="hidden" name="_token" value="'. csrf_token() .'">';
});

add_filter('woocommerce_dropdown_variation_attribute_options_args',function ( $args)
{
    if(count($args['options']) === 1) { //Check the count of available options in dropdown
        $args['selected'] = $args['options'][0];
    }
    return $args;
},10,1);


add_action('init', function () {
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
});
add_filter( 'woocommerce_breadcrumb_defaults', function () {
	return array(
		'delimiter'   => '<span class="breadcrumb-separator">/</span>',
		'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	);
});
add_action('woocommerce_archive_description', function() {
	woocommerce_breadcrumb();
}, 1);

add_action('woocommerce_before_single_product', function() {
    echo view('woocommerce.single-product.breadcrumbs')->render();
}, 1);

add_action('wp', function () {
	remove_theme_support( 'wc-product-gallery-zoom' ); //also removes zoom icon on main image.
}, 99 );

add_filter( 'woocommerce_checkout_fields' , function ( $fields ) {

    unset($fields['billing']['billing_address_2']);
    unset($fields['shipping']['shipping_address_2']);
    return $fields;

//    unset($fields['billing']['billing_first_name']);
//    unset($fields['billing']['billing_last_name']);
//    unset($fields['billing']['billing_company']);
//    unset($fields['billing']['billing_address_1']);
//
//    unset($fields['billing']['billing_city']);
//    unset($fields['billing']['billing_postcode']);
//    unset($fields['billing']['billing_country']);
//    unset($fields['billing']['billing_state']);
//    unset($fields['billing']['billing_phone']);
//    unset($fields['order']['order_comments']);
//    unset($fields['billing']['billing_email']);
//    unset($fields['account']['account_username']);
//    unset($fields['account']['account_password']);
//    unset($fields['account']['account_password-2']);
} );

add_filter( 'woocommerce_reset_variations_link', function ($html){
    return '<a class="reset_variations" href="#">' . esc_html__( 'Selectie wissen', 'woocommerce' ) . '</a>';
});

add_filter( 'woocommerce_ajax_variation_threshold', function() { return 200; } );

add_action('woocommerce_before_cart', function (){
   echo sprintf('<a href="%s" class="no-underline text-sm hover:text-primary mb-4 inline-block"><i class="fa-solid fa-chevron-left pr-2 text-xs"></i> Verder winkelen</a>', get_permalink( wc_get_page_id( 'shop' ) ));
});

// Fix for redirection adding two slashes in front of redirect.
add_action('redirection_url_target', function ($url){
   if(str_starts_with($url, '//')) {
       return str_replace(substr($url, 0, 2), '/', $url);
   }
   return $url;
}, 999);

// Always show sku of product in mail
add_filter( 'woocommerce_email_order_items_args', function ($args){
    $args['show_sku'] = true;
    return $args;
}, 10, 2 );

/**
 * @snippet       Show SKU @ WooCommerce Cart
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

// First, let's write the function that returns a given product SKU
function renderSku( $product ) {
    $sku = $product->get_sku();
    if ( ! empty( $sku ) ) {
        return '<span class="inline-block pl-2"> - ' . $sku . '</span>';
    } else {
        return '';
    }
}

// This adds the SKU under cart/checkout item name
add_filter( 'woocommerce_cart_item_name', 'sku_cart_checkout_pages', 9999, 3 );

function sku_cart_checkout_pages( $item_name, $cart_item, $cart_item_key  ) {
    $product = $cart_item['data'];
    $item_name .= renderSku( $product );
    return $item_name;
}

add_filter('woocommerce_product_variation_get_sku', function ($sku){
    preg_match_all('/\.(.*)/m', $sku, $matches, PREG_SET_ORDER, 0);
    if(isset($matches[0], $matches[0][1])) {
        return $matches[0][1];
    }
    return $sku;
});

function hideFlatRateWhenFreeIsAvailable( $rates ) : array
{
    $shipmentRateKey = '';
    $removeOtherShipmentMethod = false;
    foreach ( $rates as $rateId => $rate ) {
        if ( 'free_shipping' === $rate->get_method_id() ) {
            $removeOtherShipmentMethod = true;
            continue;
        }
        if ( 'flat_rate' === $rate->get_method_id() ) {
            $shipmentRateKey = $rateId;
        }

    }

    if(true === $removeOtherShipmentMethod && $shipmentRateKey) {
        unset($rates[$shipmentRateKey]);
    }

    return $rates;
}
add_filter( 'woocommerce_package_rates', 'hideFlatRateWhenFreeIsAvailable', 100 );


//if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
//    function wc_get_page_id() {
//        return '';
//    }
//}

// Enable the login form by default for unlogged users
add_action( 'woocommerce_before_checkout_form', 'force_checkout_login_for_unlogged_customers', 4 );
function force_checkout_login_for_unlogged_customers() {
    if( ! is_user_logged_in() ) {
        remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
    }
}

remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

add_filter('woocommerce_cart_shipping_method_full_label', function ($label, WC_Shipping_Rate $method){
    if($method->get_method_id() === 'local_pickup' || $method->get_method_id() === 'free_shipping') {
        $label .= '<span class="woocommerce-Price-amount amount"><bdi>Gratis</bdi></span>';
    }

    return $label;
}, 5, 2);

/**
 * Accepts a zone name and returns its threshold for free shipping.
 *
 * @param $zone_name The name of the zone to get the threshold of. Case-sensitive.
 * @return int The threshold corresponding to the zone, if there is any. If there is no such zone, or no free shipping method, null will be returned.
 */
function get_free_shipping_minimum($zone_name = 'Netherlands') {
    if ( ! isset( $zone_name ) ) return null;

    $result = null;
    $zone = null;

    $zones = WC_Shipping_Zones::get_zones();
    foreach ( $zones as $z ) {
        if ( $z['zone_name'] == $zone_name ) {
            $zone = $z;
        }
    }

    if ( $zone ) {
        $shipping_methods_nl = $zone['shipping_methods'];

        $free_shipping_method = null;
        foreach ( $shipping_methods_nl as $method ) {
            if ( $method->id == 'free_shipping' ) {
                $free_shipping_method = $method;
                break;
            }
        }
        if ( $free_shipping_method ) {
            $result = $free_shipping_method->min_amount;
        }
    }

    return $result;
}

// Disable WP rocket comments in files
define ('WP_ROCKET_WHITE_LABEL_FOOTPRINT', false);


/**
 * Set 'with_front' to false for the 'experts' post type.
 */
add_filter( 'register_post_type_args', function( $args, $post_type )
{
    if( 'experts' === $post_type && is_array( $args ) ) {
        $args['rewrite'] = [
            'with_front' => false,
        ];
    }


    return $args;
}, 99, 2 );

add_filter('rank_math/frontend/breadcrumb/html', function ($html){
    return str_replace(['Home', 'home', 'HOME'], '', $html);
});


/** *
 * Allow editing the robots.txt & htaccess data. *
 * @param bool Can edit the robots & htaccess data.
 */
add_filter( 'rank_math/can_edit_file', '__return_true' );


// Hide Wordpress version
remove_action('wp_head', 'wp_generator');


function add_excerpt_to_pages() {
    add_post_type_support('page', 'excerpt');
}
add_action('init', 'add_excerpt_to_pages');



// Add custom class to the body_class
function add_sitename_to_body_class( $classes ) {
    $sitename = sanitize_title( get_bloginfo( 'name' ) );
    $classes[] = $sitename;

    return $classes;
}
add_filter( 'body_class', 'add_sitename_to_body_class' );





// Remove WordPress Meta Data

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Remove WordPress version from RSS feeds
add_filter('the_generator', '__return_empty_string');

function remove_wp_meta_tags() {
    remove_action('wp_head', 'rsd_link'); // Really Simple Discovery link
    remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer manifest link
    remove_action('wp_head', 'wp_shortlink_wp_head'); // Shortlink
    remove_action('wp_head', 'feed_links_extra', 3); // Extra RSS feeds
    remove_action('wp_head', 'feed_links', 2); // RSS feed links
    remove_action('wp_head', 'rest_output_link_wp_head'); // REST API link
    remove_action('wp_head', 'wp_oembed_add_discovery_links'); // oEmbed links
    remove_action('wp_head', 'wp_oembed_add_host_js'); // oEmbed JavaScript
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Previous/Next post links
}
add_action('init', 'remove_wp_meta_tags');

function remove_version_from_assets($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'remove_version_from_assets', 9999);
add_filter('script_loader_src', 'remove_version_from_assets', 9999);


function disable_wp_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'disable_wp_emojis');



/**
 * Calculate the estimated reading time of a post by counting words in Gutenberg blocks.
 *
 * @param WP_Post|int $post The post object or post ID.
 * @param int $words_per_minute The average reading speed. Default is 238 words per minute.
 *
 * @return int Estimated reading time in minutes.
 */

function getReadingTime($post, $words_per_minute = 238) {
    if (is_numeric($post)) {
        $post = get_post($post);
    }

    if (! $post instanceof WP_Post) {
        return 0;
    }

    $content = apply_filters('the_content', $post->post_content);

    if (empty($content)) {
        return 0;
    }

    // Strip alle HTML tags weg
    $text_content = wp_strip_all_tags($content);

    // Haal extra whitespace weg
    $text_content = trim(preg_replace('/\s+/', ' ', $text_content));

    // Tel de woorden
    $word_count = str_word_count($text_content);

    // Bereken de leestijd
    $reading_time = ceil($word_count / $words_per_minute);

    return max(1, $reading_time);
}


add_filter('acf/load_field/name=cardblock_post_type', 'acf_load_cardblock_post_types');
function acf_load_cardblock_post_types($field) {
    // Haal alle publieke custom post types op (geen ingebouwde zoals post/page)
    $args = [
        'public'   => true,
        '_builtin' => false
    ];
    $post_types = get_post_types($args, 'objects');

    // Voeg optioneel 'post' en 'page' toe als je die ook wil tonen:
    $post_types['post'] = get_post_type_object('post');
    $post_types['page'] = get_post_type_object('page');

    // Reset keuzes
    $field['choices'] = [];

    // Voeg CPT’s toe aan het selectveld
    foreach ($post_types as $post_type) {
        $field['choices'][$post_type->name] = $post_type->labels->singular_name;
    }

    return $field;
}

load_theme_textdomain('themosis', WP_CONTENT_DIR . '/languages');
