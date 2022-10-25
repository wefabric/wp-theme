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

/*
add_filter('woocommerce_gallery_thumbnail_size', function($size) {
	return 'woocommerce_gallery_thumbnail';
});
add_filter('single_product_archive_thumbnail_size', function($size) {
	return 'woocommerce_product_thumbnail';
});
add_filter('subcategory_archive_thumbnail_size', function($size) {
	return 'woocommerce_product_thumbnail';
});
add_filter('woocommerce_gallery_image_size', function($size) {
	return 'woocommerce_single';
});
*/


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
			'grid_class' => 'product-cats hidden md:grid md:grid-cols-3 w-full',
//			'grid_spacing' => 'gap-12',
		])->render();

		echo '<h2 class="text-36 font-head lg:pt-20 lg:pb-12">Alle producten</h2>';
	}
}, 50);

add_filter( 'loop_shop_per_page', function ($number_of_posts) {
	return 9; //products per page
}, 20);
add_filter('loop_shop_columns', function () {
	return 3; //product-columns per page
}, 1); //DOESNT work, see the _webshop.scss styling for .produccts as temp fix.

//Doesnt work > homepage is Shop / Shop...
//add_filter( 'woocommerce_breadcrumb_defaults', function ( $defaults ) {
//	$defaults['home'] = 'Shop';
//	return $defaults;
//});
add_filter( 'woocommerce_breadcrumb_home_url', function () {
	return get_permalink(wc_get_page_id('shop'));
});

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
add_filter('woocommerce_product_loop_title_classes', function ($class) {
	return $class .' h5 text-black pb-6';
});

add_filter('woocommerce_product_class', function ($class) {
	return $class .' lg:pt-24 ';
});

add_action('woocommerce_single_product_summary', function() {
	echo '<h5 class="pb-2">Brand/Merk</h5>';
}, 3);
add_action('woocommerce_single_product_summary', function() {
	echo '<div class="text-base pt-3 pb-8"><span class="font-bold">Artikelnummer:</span> 123456</div>';
}, 8);

// https://woocommerce.com/document/custom-tracking-code-for-the-thanks-page/ ?

/*
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', '_dequeue_styles' );
function _dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}
// Or just remove them all in one line
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
*/
