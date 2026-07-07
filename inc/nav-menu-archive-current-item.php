<?php

/**
 * Fix "current-menu-item" for Pages that share a URL with a post type archive.
 *
 * When a CPT is registered with `has_archive` set to the same slug as an
 * existing Page (e.g. a "Projecten" Page and a `project` post type with
 * has_archive slug "projecten"), WordPress's rewrite rules for post type
 * archives take priority over the generic page rule. Visiting that URL
 * then queries the archive (`is_post_type_archive()`), not the Page —
 * so WordPress's own current-menu-item detection never matches a menu
 * item that links to the Page, because it's comparing against the wrong
 * queried object.
 *
 * This detects the collision generically (by comparing the menu item's
 * URL to the current post type's archive URL) instead of hardcoding a
 * menu item ID, post type, or site — so it keeps working as new CPTs
 * and menus are added across sites built on this theme.
 */
add_filter('wp_nav_menu_objects', function (array $items, $args) {
    $queried_object = get_queried_object();

    if (!($queried_object instanceof WP_Post_Type) || empty($queried_object->has_archive)) {
        return $items;
    }

    $archive_url = get_post_type_archive_link($queried_object->name);

    if (!$archive_url) {
        return $items;
    }

    $archive_url = untrailingslashit($archive_url);
    $current_ids = [];

    foreach ($items as $item) {
        if ($item->object === 'page' && untrailingslashit($item->url) === $archive_url) {
            $item->classes[] = 'current-menu-item';
            $item->classes[] = 'current_page_item';
            $item->current = true;
            $current_ids[] = (int) $item->menu_item_parent;
        }
    }

    if (empty($current_ids)) {
        return $items;
    }

    // Mark ancestor menu items too, matching WordPress's own behaviour
    // for a "current" item nested under a parent menu item.
    while (!empty($current_ids)) {
        $parent_id = array_shift($current_ids);

        foreach ($items as $item) {
            if ((int) $item->ID !== $parent_id) {
                continue;
            }

            $item->classes[] = 'current-menu-ancestor';
            $item->classes[] = 'current_page_ancestor';
            $current_ids[] = (int) $item->menu_item_parent;
        }
    }

    return $items;
}, 10, 2);
