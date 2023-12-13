<?php

namespace Theme\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;


class WPRocketServiceProvider extends ServiceProvider
{
    public function register()
    {

        if(is_plugin_active('wp-rocket/wp-rocket.php') && App::environment() !== 'production') {
            $this->disablePageCaching();
        }

    }

    private function disablePageCaching()
    {
        /**
         * Disable page caching in WP Rocket.
         *
         * @link http://docs.wp-rocket.me/article/61-disable-page-caching
         */
        add_filter( 'do_rocket_generate_caching_files', '__return_false' );
    }
}