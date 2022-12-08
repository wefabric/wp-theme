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


add_action( 'woocommerce_before_shop_loop', function () {
	$terms = get_terms( 'product_cat', [
		'parent' => get_queried_object_id(),
		'exclude' => [
			'24', //term id of 'uncategorized'
		],
	]);

	if ($terms) {
		echo view('components.slider.grid', [
			'items' => $terms,
			'card_type' => 'category',
			'grid_class' => 'product-cats w-full',
		])->render();

		echo '<h2 class="text-36 font-head lg:pt-20 lg:pb-12">Alle producten</h2>';
	}
}, 50);

add_filter( 'loop_shop_per_page', function ($number_of_posts) {
	return 9; //products per page
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
	echo '<h5 class="pb-2">'. $product->get_attribute('brand') .'</h5>';
}, 3);
add_action('woocommerce_single_product_summary', function() {
    global $product;
	echo view('woocommerce.single-product.additional-summary', ['product' => $product])->render();
}, 8);
add_action('woocommerce_single_product_summary', function() {
	global $product;
	echo '<div class="text-xs font-bold pt-2 pb-8">'. wc_price(wc_get_price_excluding_tax($product)) .' excl. BTW</div>';
}, 11);
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

    if(count($args['options']) === 1) //Check the count of available options in dropdown
        $args['selected'] = $args['options'][0];
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

add_action('wp', function () {
	remove_theme_support( 'wc-product-gallery-zoom' ); //also removes zoom icon on main image.
}, 99 );

// https://woocommerce.com/document/custom-tracking-code-for-the-thanks-page/ ?
