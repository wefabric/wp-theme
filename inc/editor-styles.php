<?php
/**
 * Editor styles — injects link colour into the Gutenberg block editor.
 */

function wf_get_editor_primary_color(): string
{
    if (!function_exists('get_field')) {
        return '#ffb700';
    }
    return get_field('primary_color', 'option') ?: '#ffb700';
}

/**
 * Remove app.css from TinyMCE WYSIWYG fields only.
 *
 * The mce_css filter targets exclusively TinyMCE's content_css setting.
 * It does not affect the Gutenberg block editor, which receives app.css
 * separately via add_editor_style() in BlockEditorHook.
 */
add_filter('mce_css', function (string $mce_css): string {
    if (empty($mce_css)) {
        return $mce_css;
    }

    $styles = explode(',', $mce_css);
    $styles = array_filter($styles, fn (string $url): bool => ! str_contains($url, 'app.css'));

    return implode(',', $styles);
});

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
