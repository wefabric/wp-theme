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
}