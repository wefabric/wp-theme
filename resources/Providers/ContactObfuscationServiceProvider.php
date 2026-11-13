<?php

namespace Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Theme\Helpers\ContactObfuscator;

class ContactObfuscationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        add_action('template_redirect', [$this, 'startOutputBuffer'], PHP_INT_MAX);

        add_action('wp_footer', [$this, 'printDecoder'], 1);

        // For front-end pages that render their own layout without wp_footer (e.g. business cards).
        add_action('wefabric/contact_obfuscation/print_decoder', [$this, 'printDecoder']);

        foreach ([
            'rank_math/frontend/description',
            'rank_math/opengraph/facebook/og_description',
            'rank_math/opengraph/twitter/twitter_description',
        ] as $descriptionFilter) {
            add_filter($descriptionFilter, [$this, 'stripContactDetails'], PHP_INT_MAX);
        }
    }

    public function stripContactDetails(mixed $description): mixed
    {
        if (! is_string($description)) {
            return $description;
        }

        if (! ContactObfuscator::isEnabled()) {
            return $description;
        }

        return ContactObfuscator::stripContactDetails($description);
    }

    public function startOutputBuffer(): void
    {
        if (! ContactObfuscator::isEnabled()) {
            return;
        }

        ob_start(function (string $html): string {
            if (! $this->isHtmlResponse()) {
                return $html;
            }

            return ContactObfuscator::protectHtml($html);
        });
    }

    /*
     * Printed inline instead of bundled in app.js, so it runs before first paint and is
     * not held back by WP Rocket's "delay JavaScript execution" (nowprocket).
     */
    public function printDecoder(): void
    {
        if (! ContactObfuscator::isEnabled()) {
            return;
        }

        $decoder = file_get_contents(get_template_directory() . '/assets/js/contact-obfuscation.js');

        echo "<script nowprocket data-no-optimize=\"1\">{$decoder}</script>";
    }

    protected function isHtmlResponse(): bool
    {
        foreach (headers_list() as $header) {
            if (stripos($header, 'content-type:') === 0) {
                return stripos($header, 'text/html') !== false;
            }
        }

        return true;
    }
}
