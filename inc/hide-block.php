<?php

/**
 * Blokken met de optie "Blok verbergen?" (ACF-veld `hide_block`) worden op de
 * frontend helemaal niet gerenderd, zodat ze niet in de DOM terechtkomen.
 *
 * In de editor (admin / REST-preview) blijft het blok gewoon zichtbaar, zodat
 * het nog bewerkt kan worden.
 */
add_filter('render_block', function ($blockContent, array $block) {
    if (is_admin() || wp_is_serving_rest_request()) {
        return $blockContent;
    }

    $name = $block['blockName'] ?? '';
    if (strpos($name, 'wefabric/') !== 0 && strpos($name, 'acf/') !== 0) {
        return $blockContent;
    }

    if (!empty($block['attrs']['data']['hide_block'])) {
        return '';
    }

    return $blockContent;
}, 10, 2);
