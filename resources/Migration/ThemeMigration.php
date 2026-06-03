<?php

namespace Theme\Migration;

/**
 * ThemeMigration
 *
 * Voert eenmalige datamigrat ies uit wanneer de ACF-veldstructuur verandert.
 * Elke migratie heeft een versienummer. Als dat versienummer al in de database
 * staat, wordt de migratie overgeslagen.
 *
 * Gebruik:
 *   ThemeMigration::run();  // vanuit admin_init hook
 *
 * Nieuwe migratie toevoegen:
 *   1. Verhoog CURRENT_VERSION
 *   2. Voeg een private static methode toe: migrate_X_Y_Z()
 *   3. Roep die methode aan in run() achter de bestaande migrat ies
 */
class ThemeMigration
{
    /**
     * Verhoog dit versienummer elke keer dat je een nieuwe migratie toevoegt.
     * Format: major.minor.patch — komt overeen met het thema-versienummer.
     */
    const CURRENT_VERSION = '2.1.0';

    /**
     * Sleutel in wp_options waarmee we bijhouden tot welke versie gemigreerd is.
     */
    const OPTION_KEY = 'theme_migration_version';

    /**
     * Entrypoint — aanroepen via admin_init.
     * Controleert of migratie nodig is en voert alle openstaande stappen uit.
     */
    public static function run(): void
    {
        // ACF moet beschikbaar zijn
        if (!function_exists('update_field') || !function_exists('get_option')) {
            return;
        }

        // Al up-to-date?
        if (get_option(self::OPTION_KEY) === self::CURRENT_VERSION) {
            return;
        }

        // ----------------------------------------------------------------
        // Voer alle migrat ies uit in volgorde
        // ----------------------------------------------------------------
        self::migrate_2_0_0_nav_group();
        self::migrate_2_0_0_meldingen_group();
        self::migrate_2_1_0_nav_new_fields();

        // Sla nieuwe versie op — migratie wordt niet opnieuw uitgevoerd
        update_option(self::OPTION_KEY, self::CURRENT_VERSION);
    }

    // ====================================================================
    // Migratie 2.0.0
    // Achtergrond: navigatieinstellingen en modal zijn samengevoegd in
    // settings-site.json. De velden zijn tevens gewrapped in ACF-groups
    // ('nav' en 'meldingen') voor sub-tab ondersteuning in de admin.
    // Bestaande sites hebben de data nog opgeslagen als losse wp_options.
    // ====================================================================

    /**
     * Migreert losse navigatieopties naar de ACF group 'nav'.
     *
     * Vóór:  wp_options → show_menu, navigation_logo, etc. (flat)
     * Na:    wp_options → nav (geserialiseerde array met alle sub-velden)
     */
    private static function migrate_2_0_0_nav_group(): void
    {
        // ACF options page slaat velden op met het prefix 'options_'.
        // Sla over als de nav group al gevuld is (eerder gemigreerd).
        if (!empty(get_option('options_nav'))) {
            return;
        }

        // Sla over als er ook geen oude vlakke ACF-opties zijn (verse installatie).
        if (get_option('options_navigation_logo') === false && get_option('options_show_menu') === false) {
            return;
        }

        $navData = [
            // ── Desktop menu ──────────────────────────────────────────
            'desktop_show_home_icon'                    => self::old('desktop_show_home_icon', 1),
            'navigation_logo'                           => self::old('navigation_logo', 'logo_1'),
            'menu_background_color'                     => self::old('menu_background_color', ''),
            'menu_text_color'                           => self::old('menu_text_color', 'white'),
            'menu_active_text_color'                    => self::old('menu_active_text_color', 'primary-color'),

            // ── Gedrag (nieuw — geen oude data, gebruik defaults) ─────
            'nav_sticky'                                => 0,
            'nav_transparent'                           => 0,
            'nav_scrolled_bg_color'                     => '',
            'nav_scrolled_logo'                         => '',
            'nav_scrolled_text_color'                   => '',
            'nav_scrolled_active_text_color'            => '',

            // ── Topbalk ───────────────────────────────────────────────
            'show_secondary_menu'                       => self::old('show_secondary_menu', 0),
            'secondary_menu_background_color'           => self::old('secondary_menu_background_color', 'primary-color'),
            'secondary_menu_text_color'                 => self::old('secondary_menu_text_color', ''),
            'secondary_menu_text'                       => self::old('secondary_menu_text', ''),
            'secondary_menu_show_elements'              => self::old('secondary_menu_show_elements', []),
            'secondary_menu_navigation_text'            => self::old('secondary_menu_navigation_text', ''),
            'whatsapp_link'                             => self::old('whatsapp_link', ''),
            'whatsapp_text'                             => self::old('whatsapp_text', ''),
            'secondary_menu_active_text_color'          => '',
            'secondary_menu_scrolled_bg_color'          => '',
            'secondary_menu_scrolled_text_color'        => '',
            'secondary_menu_scrolled_active_text_color' => '',

            // ── Mobiele menu ──────────────────────────────────────────
            'mobile_menu_type'                          => self::old('mobile_menu_type', 'desktop_menu'),
            'mobile_navigation_logo'                    => self::old('mobile_navigation_logo', 'logo_1'),
            'mobile_menu_background_color'              => self::old('mobile_menu_background_color', 'primary-color'),
            'mobile_menu_text_color'                    => 'white-color',
            'mobile_menu_active_text_color'             => 'cta-color',
        ];

        // ACF slaat de group op via de field key — dit garandeert het juiste formaat
        update_field('field_6900nav_group', $navData, 'option');
    }

    /**
     * Migreert out_of_office en custom_modal naar de ACF group 'meldingen'.
     *
     * Vóór:  wp_options → out_of_office (array), custom_modal (array)
     * Na:    wp_options → meldingen['out_of_office'], meldingen['custom_modal']
     */
    private static function migrate_2_0_0_meldingen_group(): void
    {
        // Sla over als nieuwe group al gevuld is
        if (!empty(get_option('options_meldingen'))) {
            return;
        }

        $oldOutOfOffice = get_option('options_out_of_office');
        $oldCustomModal = get_option('options_custom_modal');

        // Geen oude data → verse installatie, niks te migreren
        if ($oldOutOfOffice === false && $oldCustomModal === false) {
            return;
        }

        $meldingenData = [
            'out_of_office' => is_array($oldOutOfOffice) ? $oldOutOfOffice : [],
            'custom_modal'  => is_array($oldCustomModal)  ? $oldCustomModal  : [],
        ];

        update_field('field_6900meld_group', $meldingenData, 'option');
    }

    // ====================================================================
    // Migratie 2.1.0
    // Achtergrond: nieuwe nav-velden toegevoegd aan de 'nav' group:
    //   - nav_scrolled_active_text_color        (actieve kleur na scrollen)
    //   - secondary_menu_active_text_color       (topbalk hover kleur)
    //   - secondary_menu_scrolled_bg_color       (topbalk bg na scrollen)
    //   - secondary_menu_scrolled_text_color     (topbalk tekst na scrollen)
    //   - secondary_menu_scrolled_active_text_color (topbalk hover na scrollen)
    //   - mobile_menu_text_color                 (mobiel menu tekst kleur)
    //   - mobile_menu_active_text_color          (mobiel menu actief kleur)
    //
    // Sites die 2.0.0 al gedraaid hebben, hebben deze sleutels niet in hun
    // nav group. Deze migratie voegt ze toe met veilige defaults.
    // ====================================================================

    /**
     * Voegt ontbrekende nav-velden toe aan een bestaande nav group.
     * Sleutels die al aanwezig zijn worden nooit overschreven.
     */
    private static function migrate_2_1_0_nav_new_fields(): void
    {
        // ACF slaat de group op als 'options_nav' — niet als 'nav'.
        $navData = get_option('options_nav');

        // Geen nav group → 2.0.0 is nog niet gerund of verse installatie.
        // In beide gevallen hoeft er hier niets te gebeuren.
        if (!is_array($navData)) {
            return;
        }

        // Nieuwe velden met hun standaardwaarden.
        // Lege string = "niet ingesteld" (JS/PHP vallen terug op bestaande kleur).
        $defaults = [
            'nav_scrolled_active_text_color'            => '',
            'secondary_menu_active_text_color'          => '',
            'secondary_menu_scrolled_bg_color'          => '',
            'secondary_menu_scrolled_text_color'        => '',
            'secondary_menu_scrolled_active_text_color' => '',
            'mobile_menu_text_color'                    => 'white-color',
            'mobile_menu_active_text_color'             => 'cta-color',
        ];

        $changed = false;
        foreach ($defaults as $key => $default) {
            if (!array_key_exists($key, $navData)) {
                $navData[$key] = $default;
                $changed       = true;
            }
        }

        if ($changed) {
            update_field('field_6900nav_group', $navData, 'option');
        }
    }

    // ====================================================================
    // Helper
    // ====================================================================

    /**
     * Leest een oude ACF options-page waarde.
     * ACF slaat options-page velden op als 'options_{fieldname}' in wp_options.
     * Geeft $default terug als de optie niet bestaat.
     */
    private static function old(string $key, $default = null)
    {
        $value = get_option('options_' . $key);
        return ($value !== false) ? $value : $default;
    }
}
