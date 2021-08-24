<?php

namespace Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Themosis\Core\ThemeManager;
use Themosis\Support\Facades\Asset;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Theme Assets
     *
     * Here we define the loaded assets from our previously defined
     * "dist" directory. Assets sources are located under the root "assets"
     * directory and are then compiled, thanks to Laravel Mix, to the "dist"
     * folder.
     *
     * @see https://laravel-mix.com/
     */
    public function register()
    {
        /** @var ThemeManager $theme */
        $theme = $this->app->make('wp.theme');

        /** For cache busting **/
        $version = $theme->getHeader('version');
        if(App::environment() !== 'production') {
            $version = substr(md5($theme->getUrl().microtime()), 0, 8);
        }
        
        Asset::add('theme_styles', 'css/app.css', [], $version)->to('front');
        Asset::add('theme_woo', 'css/woocommerce.css', ['theme_styles'], $version)->to('front');
        Asset::add('theme_js', 'js/app.js', [], $version)->to('front');
    }
}
