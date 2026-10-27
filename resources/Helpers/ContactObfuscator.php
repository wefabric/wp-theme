<?php

namespace Theme\Helpers;

class ContactObfuscator
{
    private static string $sensitiveHrefPattern = '/^(?:mailto:|tel:|sms:|whatsapp:|https?:\/\/(?:wa\.me|api\.whatsapp\.com|web\.whatsapp\.com|signal\.me|t\.me|telegram\.me)\/)/i';

    private static string $sensitiveTextPattern = '/
        (?<whatsapp>(?:https?:\/\/)?(?:wa\.me|api\.whatsapp\.com)\/[^\s<"\']+)
        |(?<email>(?<![\w.%+\x80-\xFF-])[A-Za-z0-9._%+\x80-\xFF-]+@[A-Za-z0-9-]+(?:\.[A-Za-z0-9-]+)*\.[A-Za-z]{2,}(?![\w-]))
        |(?<phone>(?<![\w+\/=.-])(?:(?:\+|00)\d{2}[ .-]?(?:\(0\)[ .-]?)?\d(?:[ .-]?\d){7,10}|0\d(?:[ .-]?\d){8})(?![\w]))
    /x';

    /*
     * Regions that are never touched: the head (meta tags, Rank Math JSON-LD), scripts
     * (JSON-LD in the body, inline config), styles and form values. Structured data
     * deliberately stays readable so it matches the Google Business Profile.
     */
    private static string $documentPattern = '/(<head\b.*?<\/head>|<script\b.*?<\/script>|<style\b.*?<\/style>|<textarea\b.*?<\/textarea>|<!--.*?-->|<[^>]*>)/is';

    public static function email(string $email, ?string $label = null): string
    {
        return self::link("mailto:{$email}", $label ?? $email);
    }

    public static function phone(string $phone, ?string $label = null): string
    {
        $number = preg_replace('/[^\d+]/', '', $phone);

        return self::link("tel:{$number}", $label ?? $phone);
    }

    public static function whatsapp(string $number, string $message = '', ?string $label = null): string
    {
        $number = preg_replace('/\D/', '', $number);

        $url = "https://wa.me/{$number}";

        if ($message !== '') {
            $url .= '?text=' . rawurlencode($message);
        }

        return self::link($url, $label ?? "+{$number}");
    }

    public static function link(string $url, string $label): string
    {
        return sprintf(
            '<a data-wfo-href="%s">%s</a>',
            esc_attr(self::encode($url)),
            self::protectText(esc_html($label)),
        );
    }

    public static function protectHtml(string $html): string
    {
        $parts = preg_split(self::$documentPattern, $html, -1, PREG_SPLIT_DELIM_CAPTURE);

        if ($parts === false) {
            return $html;
        }

        $protectedParts = array_map(function (string $part): string {
            if (! str_starts_with($part, '<')) {
                return self::protectText($part);
            }

            if (preg_match('/^<a\s/i', $part)) {
                $part = self::protectLinkTag($part);
            }

            return self::protectAttributes($part);
        }, $parts);

        return implode('', $protectedParts);
    }

    public static function protectText(string $text): string
    {
        if (! preg_match('/[@\d]|wa\.me|whatsapp/i', $text)) {
            return $text;
        }

        return preg_replace_callback(
            self::$sensitiveTextPattern,
            fn (array $matches): string => self::protectedSpan($matches[0]),
            $text,
        ) ?? $text;
    }

    public static function protectLinkTag(string $tag): string
    {
        return preg_replace_callback(
            '/\shref\s*=\s*(["\'])(.*?)\1/is',
            function (array $matches): string {
                $href = html_entity_decode($matches[2], ENT_QUOTES | ENT_HTML5);

                if (! preg_match(self::$sensitiveHrefPattern, trim($href))) {
                    return $matches[0];
                }

                return sprintf(' data-wfo-href="%s"', esc_attr(self::encode(trim($href))));
            },
            $tag,
        ) ?? $tag;
    }

    /*
     * Labels such as aria-label="Bel naar 0612345678" are moved to data-wfo-aria-label
     * and restored by the decoder, so screen readers still get the full label.
     */
    public static function protectAttributes(string $tag): string
    {
        return preg_replace_callback(
            '/\s(aria-label|title|alt)\s*=\s*(["\'])(.*?)\2/is',
            function (array $matches): string {
                $value = html_entity_decode($matches[3], ENT_QUOTES | ENT_HTML5);

                if (! preg_match(self::$sensitiveTextPattern, $value)) {
                    return $matches[0];
                }

                return sprintf(' data-wfo-%s="%s"', strtolower($matches[1]), esc_attr(self::encode($value)));
            },
            $tag,
        ) ?? $tag;
    }

    /*
     * XOR with a random key per value, so the same address never produces the same
     * payload twice and scrapers cannot simply base64-decode data attributes.
     */
    public static function encode(string $value): string
    {
        $key = random_int(1, 255);

        $encoded = chr($key);

        foreach (str_split($value) as $index => $character) {
            $encoded .= chr(ord($character) ^ (($key + $index) % 256));
        }

        return base64_encode($encoded);
    }

    public static function fallback(string $value): string
    {
        if (str_contains($value, '@')) {
            return str_replace(['@', '.'], [' [at] ', ' [punt] '], $value);
        }

        if (preg_match('/wa\.me|whatsapp/i', $value)) {
            return 'WhatsApp';
        }

        $groups = preg_split('/[^\d+]+/', $value, -1, PREG_SPLIT_NO_EMPTY);

        $chunks = array_merge(...array_map(
            fn (string $group): array => match (true) {
                strlen($group) === 10 => [substr($group, 0, 4), substr($group, 4, 3), substr($group, 7)],
                strlen($group) > 4 => str_split($group, 3),
                default => [$group],
            },
            $groups,
        ));

        return implode(' · ', $chunks);
    }

    protected static function protectedSpan(string $value): string
    {
        $decodedValue = html_entity_decode($value, ENT_QUOTES | ENT_HTML5);

        return sprintf(
            '<span class="wfo" data-wfo="%s">%s</span>',
            esc_attr(self::encode($decodedValue)),
            esc_html(self::fallback($decodedValue)),
        );
    }
}
