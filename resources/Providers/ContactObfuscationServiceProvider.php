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
    }

    public function startOutputBuffer(): void
    {
        if (! $this->shouldObfuscate()) {
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
        if (! $this->shouldObfuscate()) {
            return;
        }

        $decoder = file_get_contents(get_template_directory() . '/assets/js/contact-obfuscation.js');

        echo "<script nowprocket data-no-optimize=\"1\">{$decoder}</script>";
    }

    protected function shouldObfuscate(): bool
    {
        if (is_admin()) {
            return false;
        }

        if (is_feed()) {
            return false;
        }

        if (is_customize_preview()) {
            return false;
        }

        return (bool) apply_filters('wefabric/contact_obfuscation/enabled', true);
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
