<?php

/**
 * SEO voor termarchieven (categorieën, tags en taxonomieën van CPT's,
 * bijv. /nieuws-categorie/evenementen/ of een project-categorie).
 *
 * Termarchieven renderen de content van de archiefpagina van het bijbehorende
 * post type (bij berichten de page_for_posts), inclusief het header-blok met
 * een vaste H1 ("Actueel"). Daardoor kregen alle termpagina's dezelfde H1 en
 * meta description. Hier krijgt elke term een eigen H1 en meta description.
 */

function wefabric_is_term_archive(): bool
{
    return is_category() || is_tag() || is_tax();
}

/**
 * H1 van het header-blok vervangen door de termnaam op termarchieven.
 */
add_filter('render_block_data', function ($parsedBlock) {
    if (! wefabric_is_term_archive() || is_admin()) {
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
    if (! wefabric_is_term_archive()) {
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

    $termDescription = trim(wp_strip_all_tags(term_description($term->term_id, $term->taxonomy)));

    if ($termDescription !== '') {
        return $termDescription;
    }

    return sprintf(
        /* translators: 1: categorienaam, 2: sitenaam */
        __('Overzicht van %1$s bij %2$s.', 'themosis'),
        $term->name,
        get_bloginfo('name')
    );
});
