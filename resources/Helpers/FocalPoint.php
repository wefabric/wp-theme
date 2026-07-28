<?php

namespace Theme\Helpers;

class FocalPoint
{
    public static function getBackgroundPosition($attachment): string
    {
        if (is_int($attachment)) {
            return 'background-position: ' . get_post_meta($attachment, 'bg_pos_desktop', true);
        } elseif (is_string($attachment)) {
            // Handle background position for string URLs (e.g., $featuredImage)
            // You might need to implement logic based on your specific requirements
            return ''; // Default behavior is an empty string, adjust as needed
        }

        return '';
    }

    /**
     * Hetzelfde brandpunt, maar voor een <img> in plaats van een CSS-achtergrond.
     *
     * Bewust een aparte methode: getBackgroundPosition() bakt de CSS-property in de
     * teruggegeven string, dus die is niet te hergebruiken. Zonder ingesteld brandpunt geeft
     * die bovendien 'background-position: ' terug, ongeldige CSS die de browser negeert
     * waarna Tailwind's bg-center het overneemt. Een <img> heeft dat vangnet niet, dus hier
     * staat 'center' expliciet als terugval.
     */
    public static function getObjectPosition($attachment): string
    {
        $position = is_int($attachment)
            ? trim((string) get_post_meta($attachment, 'bg_pos_desktop', true))
            : '';

        return 'object-position: ' . ($position !== '' ? $position : 'center') . ';';
    }
}