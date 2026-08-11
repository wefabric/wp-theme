<?php

namespace Theme\Helpers;

class ContactObfuscator
{
    public static function email(string $email, ?string $label = null): string
    {
        return self::obfuscate('mailto:' . $email, $label ?? $email);
    }

    public static function phone(string $phone, ?string $label = null): string
    {
        return self::obfuscate('tel:' . $phone, $label ?? $phone);
    }

    public static function whatsapp(string $number, string $message = '', ?string $label = null): string
    {
        $number = preg_replace('/\D/', '', $number);
        $url = 'https://wa.me/' . $number;
        if ($message) {
            $url .= '?text=' . rawurlencode($message);
        }

        return self::obfuscate($url, $label ?? $number, true);
    }

    /**
     * Returns the base64-encoded URL for use in Blade template data-href attributes.
     * Use when you need to keep the existing link markup (link.opening / buttons.icon)
     * but want the href obfuscated:
     *
     *   'href' => '#',
     *   'class' => '... wf-obfuscated',
     *   'attributes' => ['data-href' => ContactObfuscator::encode('mailto:info@example.com')],
     */
    public static function encode(string $url): string
    {
        return base64_encode($url);
    }

    private static function obfuscate(string $url, string $label, bool $newTab = false): string
    {
        $extra = $newTab ? ' data-target="_blank"' : '';

        return sprintf(
            '<a href="#" class="wf-obfuscated" data-href="%s"%s>%s</a>',
            esc_attr(base64_encode($url)),
            $extra,
            esc_html($label)
        );
    }
}
