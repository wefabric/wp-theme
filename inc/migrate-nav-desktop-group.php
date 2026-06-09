<?php
/**
 * Eenmalig migratiescript: desktop nav-velden verplaatsen naar de nieuwe sub-group.
 *
 * Draait automatisch bij de eerste page load na de herstructurering.
 * Wordt overgeslagen zodra de vlag 'wefabric_nav_desktop_migration_v1' in de DB staat.
 */

add_action('init', function (): void {
    // Al gedraaid? Stop.
    if (get_option('wefabric_nav_desktop_migration_v1')) {
        return;
    }

    $desktop_fields = [
        'desktop_show_home_icon',
        'navigation_logo',
        'menu_background_color',
        'menu_text_color',
        'menu_active_text_color',
        'submenu_background_color',
        'submenu_text_color',
        'submenu_active_text_color',
        'show_secondary_menu',
        'secondary_menu_background_color',
        'secondary_menu_text_color',
        'secondary_menu_active_text_color',
        'secondary_menu_scrolled_bg_color',
        'secondary_menu_scrolled_text_color',
        'secondary_menu_scrolled_active_text_color',
        'secondary_menu_text',
        'secondary_menu_show_elements',
        'secondary_menu_navigation_text',
        'whatsapp_link',
        'whatsapp_text',
        'nav_sticky',
        'nav_transparent',
        'nav_scrolled_logo',
        'nav_scrolled_bg_color',
        'nav_scrolled_text_color',
        'nav_scrolled_active_text_color',
    ];

    foreach ($desktop_fields as $field_name) {
        $old_key = 'options_nav_' . $field_name;
        $new_key = 'options_nav_desktop_' . $field_name;

        // Waarde migreren (alleen als de nieuwe sleutel nog niet bestaat)
        $value = get_option($old_key, '__NOT_SET__');
        if ($value !== '__NOT_SET__') {
            update_option($new_key, $value);
            delete_option($old_key);
        }

        // ACF field-key pointer migreren
        $old_pointer = '_options_nav_' . $field_name;
        $new_pointer = '_options_nav_desktop_' . $field_name;

        $ptr = get_option($old_pointer, '__NOT_SET__');
        if ($ptr !== '__NOT_SET__') {
            update_option($new_pointer, $ptr);
            delete_option($old_pointer);
        }
    }

    // Vlag zetten zodat dit niet nog een keer draait
    update_option('wefabric_nav_desktop_migration_v1', true);
});
