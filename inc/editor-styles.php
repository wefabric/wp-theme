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

/**
 * Fly-in animations in the block editor.
 *
 * Blocks hide their items with a `*-hidden` class (opacity: 0) and reveal them
 * via an IntersectionObserver script. That script does not run in the editor
 * preview, so the items would never become visible. Force them visible and
 * disable the fly-in animation there.
 *
 * Added through block_editor_settings_all so it also reaches the (iframed)
 * editor canvas.
 */
add_filter('block_editor_settings_all', function (array $settings): array {
    $hiddenClasses = [
        'accordion', 'activity', 'album', 'card', 'case', 'countdown-item', 'dienst',
        'employee', 'employee-story', 'establishment', 'event', 'faq', 'history', 'image',
        'klantencase', 'logo', 'news', 'organisation', 'page', 'planning', 'private-event',
        'product', 'project', 'quote', 'step', 'testimonial', 'text-image', 'usp', 'vacancy',
    ];

    $selectors = implode(',', array_map(
        fn (string $name): string => ".editor-styles-wrapper .{$name}-hidden",
        $hiddenClasses
    ));

    $settings['styles'][] = [
        'css' => "
            {$selectors} {
                opacity: 1 !important;
                transform: none !important;
                animation: none !important;
                visibility: visible !important;
            }

        ",
    ];

    return $settings;
});

/**
 * Make the inline block scripts work in the editor iframe.
 *
 * Nearly every block initialises Swiper & co. inside
 * window.addEventListener('DOMContentLoaded', ...). In the editor, blocks are
 * rendered after the iframe has already loaded (late blocks, a block you just
 * added or edited), so that event never fires again and sliders stay
 * un-initialised. Run such listeners right away when the document is already
 * loaded.
 */
add_action('enqueue_block_assets', function () {
    if (!is_admin()) {
        return;
    }

    wp_register_script('wf-editor-domready-shim', false, [], null, false);
    wp_enqueue_script('wf-editor-domready-shim');
    wp_add_inline_script('wf-editor-domready-shim', "
        (function () {
            // Run late-registered 'DOMContentLoaded' (window or document) and
            // window 'load' listeners right away when that point has passed.
            function patch(target) {
                var original = target.addEventListener;
                target.addEventListener = function (type, listener, options) {
                    var late = (type === 'DOMContentLoaded' && document.readyState !== 'loading')
                        || (type === 'load' && target === window && document.readyState === 'complete');
                    if (late && typeof listener === 'function') {
                        setTimeout(function () { listener.call(target, new Event(type)); }, 0);
                        return;
                    }
                    return original.apply(this, arguments);
                };
            }
            patch(window);
            patch(document);
        })();
    ");
});

/**
 * Disable GSAP "from" animations (title / fly-in text) in the editor.
 *
 * Because late DOMContentLoaded listeners now run in the editor (see above),
 * the blocks' scroll-driven gsap.from() animations would start there too and
 * leave text hidden / shifted until it is scrolled into view. The editor
 * should simply show the final state, so make gsap.from() a no-op there.
 * Runs after app.js, which exposes window.gsap.
 */
add_action('enqueue_block_assets', function () {
    if (!is_admin() || !wp_script_is('dinkla-editor-iframe-scripts', 'registered')) {
        return;
    }

    wp_add_inline_script('dinkla-editor-iframe-scripts', "
        if (window.gsap) {
            window.gsap.from = function () { return window.gsap.timeline(); };
        }
    ");
}, 20);

/**
 * Sticky bar block: hidden by default (and shown by JS while scrolling on the
 * frontend). In the editor, show it in the normal flow instead of fixed to the
 * bottom of the canvas, so it can be seen and edited.
 */
add_filter('block_editor_settings_all', function (array $settings): array {
    $settings['styles'][] = [
        'css' => '
            .editor-styles-wrapper .block-sticky-balk:not(.hidden) {
                position: relative !important;
                transform: none !important;
                opacity: 1 !important;
                pointer-events: auto !important;
            }
        ',
    ];

    return $settings;
});
