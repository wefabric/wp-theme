<?php

namespace Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Wefabric\WPSupport\DynamicContent\DynamicContent;

class ThemeServiceProvider extends ServiceProvider
{

    public function register()
    {
        $dynamicContent = new DynamicContent();
        $dynamicContent->addAction('theme_modal', function () {
            $options = get_fields('option');
            if(!$options['custom_modal']['active'])
                return '';
            return view('components.theme-modal', ['custom_modal' => $options['custom_modal']])->render();
        });
    }

}