<?php

namespace Theme\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Theme\Views\Blocks\TextBlock;
use Theme\Views\Blocks\TextImageBlock;
use Theme\Views\Blocks\TitleTextBlock;
use Theme\Views\Components\Content;
use Theme\Views\Components\Section;
use Theme\Views\Components\TitleComponent;
use Wefabric\WPSupport\DynamicContent\DynamicContent;

class ThemeServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap your package's services.
     */
    public function boot(): void
    {
        // Map all Block component classes under Theme\Views\Blocks to the wefabric: prefix
        // e.g., Theme\Views\Blocks\TextImageBlock => <x-wefabric:text-image-block>
        Blade::componentNamespace('Theme\\Views\\Blocks', 'wefabric');

        // Explicit registrations (kept for BC and clarity)
        Blade::component('wefabric:section', Section::class);
        Blade::component('wefabric:title', TitleComponent::class);
        Blade::component('wefabric:text-block', TextBlock::class);
        Blade::component('wefabric:text-image-block', TextImageBlock::class);
        Blade::component('wefabric:title-text-block', TitleTextBlock::class);
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
