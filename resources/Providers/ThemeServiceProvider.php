<?php

namespace Theme\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Theme\Views\Components\Content;
use Theme\Views\Components\Section;
use Theme\Views\Components\TextBlock;
use Theme\Views\Components\TitleComponent;
use Wefabric\WPSupport\DynamicContent\DynamicContent;

class ThemeServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap your package's services.
     */
    public function boot(): void
    {
        Blade::component('wefabric:section', Section::class);
        Blade::component('wefabric:title', TitleComponent::class);
        Blade::component('wefabric:text-block', TextBlock::class);
        Blade::component('wefabric:content', Content::class);
    }

    public function register()
    {
        $dynamicContent = new DynamicContent();
        $dynamicContent->addAction('theme_modal', function () {
            $options = get_fields('option');
            if(empty($options['custom_modal']) || !$options['custom_modal']['active']) {
                return '';
            }
            return view('components.theme-modal', ['custom_modal' => $options['custom_modal']])->render();
        });
    }

}
