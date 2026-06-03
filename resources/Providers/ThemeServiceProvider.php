<?php

namespace Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Theme\Migration\ThemeMigration;
use Wefabric\WPSupport\DynamicContent\DynamicContent;

class ThemeServiceProvider extends ServiceProvider
{

    public function register()
    {
        // Eenmalige datamigrat ie — draait automatisch zodra een admin de
        // WP-backend opent na een theme-update. Daarna nooit meer.
        add_action('admin_init', function () {
            ThemeMigration::run();
        });

        $dynamicContent = new DynamicContent();
        $dynamicContent->addAction('theme_modal', function () {
            $options = get_fields('option');

            // Nieuwe structuur: custom_modal zit in de 'meldingen' group.
            // Fallback naar flat pad voor sites die nog niet gemigreerd zijn.
            $customModal = $options['meldingen']['custom_modal']
                ?? $options['custom_modal']
                ?? null;

            if (empty($customModal) || empty($customModal['active'])) {
                return '';
            }

            return view('components.theme-modal', ['custom_modal' => $customModal])->render();
        });
    }

}
