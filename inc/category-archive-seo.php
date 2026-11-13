<?php

/**
 * SEO voor categoriearchieven (bijv. /nieuws-categorie/evenementen/).
 *
 * Categoriearchieven renderen de content van de nieuwspagina (page_for_posts),
 * inclusief het header-blok met een vaste H1 ("Actueel"). Daardoor kregen alle
 * categoriepagina's dezelfde H1 en meta description. Hier krijgt elke categorie
 * een eigen H1 en meta description.
 */

/**
 * H1 van het header-blok vervangen door de categorienaam op categoriearchieven.
 */
add_filter('render_block_data', function ($parsedBlock) {
    if (! is_category() || is_admin()) {
        return $parsedBlock;
    }

    $headerBlocks = ['wefabric/header', 'wefabric/header-slider', 'wefabric/header-countdown', 'wefabric/header-project'];

    if (! in_array($parsedBlock['blockName'] ?? '', $headerBlocks, true)) {
        return $parsedBlock;
    }

    $term = get_queried_object();

    if (! $term instanceof WP_Term) {
        return $parsedBlock;
    }

    $parsedBlock['attrs']['data']['title'] = $term->name;

    return $parsedBlock;
});

/**
 * Meta description: termbeschrijving, anders een nette fallback.
 */
add_filter('rank_math/frontend/description', function ($description) {
    if (! is_category()) {
        return $description;
    }

    $term = get_queried_object();

    if (! $term instanceof WP_Term) {
        return $description;
    }

    // Eigen Rank Math-omschrijving voor deze term gaat voor
    if (! empty($description)) {
        return $description;
    }

    $termDescription = trim(wp_strip_all_tags(term_description($term->term_id)));

    if ($termDescription !== '') {
        return $termDescription;
    }

    return sprintf(
        /* translators: 1: categorienaam, 2: sitenaam */
        __('Alle berichten in de categorie %1$s van %2$s.', 'themosis'),
        $term->name,
        get_bloginfo('name')
    );
});
