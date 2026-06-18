<?php
/**
 * Editor styles — adds link styling to TinyMCE (ACF WYSIWYG) and the Gutenberg
 * inline RichText editor. The primary colour is read from ACF options so it stays
 * in sync with the frontend without requiring a CSS build step.
 */

add_action('after_setup_theme', function () {
    add_theme_support('editor-styles');
});

/**
 * Return the primary colour hex from ACF options, with a safe fallback.
 */
function wf_get_editor_primary_color(): string
{
    if (!function_exists('get_field')) {
        return '#ffb700';
    }
    return get_field('primary_color', 'option') ?: '#ffb700';
}

/**
 * Inject link styles into TinyMCE / ACF WYSIWYG fields via the mce_css filter.
 * A data: URI avoids the need for a separate compiled CSS file.
 */
add_filter('mce_css', function (string $mce_css): string {
    $primary = esc_attr(wf_get_editor_primary_color());

    $css = "a { color: {$primary}; text-decoration: underline; font-weight: 700; } "
         . "a:hover { text-decoration: none; }";

    $uri = 'data:text/css;charset=utf-8,' . rawurlencode($css);

    return $mce_css ? "{$mce_css},{$uri}" : $uri;
});

/**
 * Inject link styles into the Gutenberg block editor (inline RichText editing).
 */
add_action('enqueue_block_editor_assets', function () {
    $primary = esc_attr(wf_get_editor_primary_color());

    wp_add_inline_style('wp-edit-blocks', "
        .editor-styles-wrapper a,
        .block-editor-rich-text__editable a {
            color: {$primary} !important;
            text-decoration: underline !important;
            font-weight: 700 !important;
        }
        .editor-styles-wrapper a:hover,
        .block-editor-rich-text__editable a:hover {
            text-decoration: none !important;
        }
    ");
});
