<?php

/**
 * Custom walker for mega menu items.
 *
 * Top-level items with the CSS class "has-mega-menu" get a different
 * sub-menu structure:
 *
 *   <div class="mega-menu">           ← full-width background wrapper
 *     <div class="mega-menu__inner container mx-auto flex">
 *       <div class="mega-menu__column">   ← one per level-2 item
 *         <a>Heading</a>
 *         <ul>
 *           <li><a>Link</a></li>
 *         </ul>
 *       </div>
 *     </div>
 *   </div>
 *
 * Normal sub-menus are rendered by the default walker logic.
 */
class Wefabric_Mega_Menu_Walker extends Walker_Nav_Menu
{
    /** Tracks whether we are currently inside a mega menu sub-tree. */
    private bool $in_mega = false;

    /** Tracks whether we are currently rendering the inner container. */
    private bool $in_mega_inner = false;

    public function start_lvl(&$output, $depth = 0, $args = null): void
    {
        if ($depth === 0 && $this->in_mega) {
            // Replace the default <ul class="sub-menu"> with our structure.
            $output .= '<div class="mega-menu"><div class="mega-menu__inner">';
            $this->in_mega_inner = true;
            return;
        }

        if ($depth === 1 && $this->in_mega) {
            // Level-2 sub-menu becomes a plain <ul> inside the column.
            $output .= '<ul class="mega-menu__links">';
            return;
        }

        parent::start_lvl($output, $depth, $args);
    }

    public function end_lvl(&$output, $depth = 0, $args = null): void
    {
        if ($depth === 0 && $this->in_mega) {
            $output .= '</div></div>'; // close inner + mega-menu div
            $this->in_mega_inner = false;
            return;
        }

        if ($depth === 1 && $this->in_mega) {
            $output .= '</ul>';
            return;
        }

        parent::end_lvl($output, $depth, $args);
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0): void
    {
        if ($depth === 0) {
            $this->in_mega = in_array('has-mega-menu', $item->classes, true);
        }

        if ($depth === 1 && $this->in_mega) {
            // Each level-2 item becomes a column wrapper.
            $output .= '<div class="mega-menu__column">';
            $output .= '<a href="' . esc_url($item->url) . '" class="mega-menu__heading">'
                . esc_html($item->title)
                . '</a>';
            return;
        }

        if ($depth === 2 && $this->in_mega) {
            $classes = implode(' ', array_filter($item->classes));
            $output .= '<li class="' . esc_attr($classes) . '">';
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
            return;
        }

        parent::start_el($output, $item, $depth, $args, $id);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null): void
    {
        if ($depth === 1 && $this->in_mega) {
            $output .= '</div>'; // close mega-menu__column
            return;
        }

        if ($depth === 2 && $this->in_mega) {
            $output .= '</li>';
            return;
        }

        parent::end_el($output, $item, $depth, $args);
    }
}

/**
 * Inject the mega menu walker for the main navigation menu.
 * Child themes can override this filter to disable or swap the walker.
 */
add_filter('wp_nav_menu_args', function (array $args): array {
    if (($args['theme_location'] ?? '') === 'menu-1' && empty($args['disable_mega_menu'])) {
        $args['walker'] = new Wefabric_Mega_Menu_Walker();
    }
    return $args;
});
