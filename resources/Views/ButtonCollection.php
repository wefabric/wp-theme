<?php

namespace Theme\Views;

use Illuminate\Support\Collection;
use Theme\Views\Components\Button;

class ButtonCollection extends Collection
{

    public int $amount = 2;

    public static function fromBlockData(array $block, int $amount = 2): self
    {
        $collection = new self();
        $data = $block['data'] ?? [];

        // Load global options for default button values
        $options = function_exists('get_fields') ? \get_fields('option') : [];
        $globalColorRaw = $options['global_button_color'] ?? '';
        $globalStyleRaw = $options['global_button_style'] ?? '';
        $globalIconRaw = $options['global_button_icon'] ?? '';
        $globalColor = self::normalizeColor($globalColorRaw);
        $globalStyle = is_string($globalStyleRaw) ? trim((string)$globalStyleRaw) : '';
        // Treat '0' and 'standard' as unset for globals
        if ($globalStyle === '0' || strtolower($globalStyle) === 'standard') { $globalStyle = ''; }
        $globalIcon = self::normalizeIcon($globalIconRaw);

        // Helper to apply globals when local value is unset or set to standard ('0' or 'standard')
        $applyGlobals = function (&$color, &$style, &$icon) use ($globalColor, $globalStyle, $globalIcon) {
            $color = is_string($color) ? trim($color) : '';
            if ($color === '' || $color === '0' || strtolower($color) === 'standard') { $color = $globalColor; }

            $style = is_string($style) ? trim($style) : '';
            if ($style === '' || $style === '0' || strtolower($style) === 'standard') { $style = $globalStyle; }

            $icon = is_string($icon) ? trim($icon) : '';
            if ($icon === '' || $icon === '0' || strtolower($icon) === 'standard') { $icon = $globalIcon; }
        };

        // 0) Legacy group has PRIORITY if it contains any filled button
        $legacyLink1 = $data['button_button_1'] ?? null;
        $legacyLink2 = $data['button_button_2'] ?? null;
        $legacyHas1 = is_array($legacyLink1) && (!empty($legacyLink1['title']) || !empty($legacyLink1['url']));
        $legacyHas2 = is_array($legacyLink2) && (!empty($legacyLink2['title']) || !empty($legacyLink2['url']));
        if ($legacyHas1 || $legacyHas2) {
            for ($i = 1; $i <= $amount; $i++) {
                $link = $data['button_button_'.$i] ?? [];
                if (!is_array($link)) continue;
                $title = (string)($link['title'] ?? '');
                $url = (string)($link['url'] ?? '');
                $target = (string)($link['target'] ?? '_self');
                $color = self::normalizeColor($data['button_button_'.$i.'_color'] ?? '');
                $style = (string)($data['button_button_'.$i.'_style'] ?? '');
                $download = (bool)($data['button_button_'.$i.'_download'] ?? false);
                $icon = self::normalizeIcon($data['button_button_'.$i.'_icon'] ?? '');
                $iconBefore = self::normalizeIconPosition($data['button_button_'.$i.'_icon_position'] ?? ($data['button_button_'.$i.'_iconPosition'] ?? true));
                // Apply global fallbacks when local values are unset/standard
                $applyGlobals($color, $style, $icon);
                // push rows even if one of title/url is empty; template guards will skip rendering empties
                $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon, $iconBefore));
            }
            return $collection;
        }

        // 1) New repeater (renamed) `buttons` - nested rows as array
        if (isset($data['buttons']) && is_array($data['buttons'])) {
            $rows = $data['buttons'];
            $hasAssocRows = isset($rows[0]) && is_array($rows[0]) && (array_key_exists('button', $rows[0]) || array_key_exists('button_color', $rows[0]));
            if ($hasAssocRows) {
                foreach ($rows as $row) {
                    $link = is_array($row['button'] ?? null) ? $row['button'] : [];
                    $title = (string)($link['title'] ?? '');
                    $url = (string)($link['url'] ?? '');
                    $target = (string)($link['target'] ?? '_self');
                    $color = self::normalizeColor($row['button_color'] ?? '');
                    $style = (string)($row['button_style'] ?? '');
                    $download = (bool)($row['button_download'] ?? false);
                    $icon = self::normalizeIcon($row['button_icon'] ?? '');
                    $iconBefore = self::normalizeIconPosition($row['button_icon_position'] ?? ($row['icon_position'] ?? ($row['button_iconPosition'] ?? ($row['iconPosition'] ?? true))));
                    // Apply global fallbacks when local values are unset/standard
                    $applyGlobals($color, $style, $icon);
                    $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon, $iconBefore));
                }
                return $collection;
            }
        }

        // 2) New repeater (renamed) `buttons` - flattened keys like buttons_0_button
        if (isset($data['buttons']) && !is_array($data['buttons'])) {
            $count = (int)$data['buttons'];
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $link = $data["buttons_{$i}_button"] ?? [];
                    $title = is_array($link) ? (string)($link['title'] ?? '') : '';
                    $url = is_array($link) ? (string)($link['url'] ?? '') : '';
                    $target = is_array($link) ? (string)($link['target'] ?? '_self') : '_self';
                    $color = self::normalizeColor($data["buttons_{$i}_button_color"] ?? ($data["buttons_{$i}_color"] ?? ''));
                    $style = (string)($data["buttons_{$i}_button_style"] ?? ($data["buttons_{$i}_style"] ?? ''));
                    $download = (bool)($data["buttons_{$i}_button_download"] ?? false);
                    $icon = self::normalizeIcon($data["buttons_{$i}_button_icon"] ?? ($data["buttons_{$i}_icon"] ?? ''));
                    $iconBefore = self::normalizeIconPosition($data["buttons_{$i}_button_icon_position"] ?? ($data["buttons_{$i}_icon_position"] ?? ($data["buttons_{$i}_button_iconPosition"] ?? ($data["buttons_{$i}_iconPosition"] ?? true))));
                    // Apply global fallbacks when local values are unset/standard
                    $applyGlobals($color, $style, $icon);
                    $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon, $iconBefore));
                }
                return $collection;
            }
        }

        // 3) Backward compatibility: previous field name `button_repeater` (nested rows as array)
        if (isset($data['button_repeater']) && is_array($data['button_repeater'])) {
            $rows = $data['button_repeater'];
            $hasAssocRows = isset($rows[0]) && is_array($rows[0]) && (array_key_exists('button', $rows[0]) || array_key_exists('button_color', $rows[0]));
            if ($hasAssocRows) {
                foreach ($rows as $row) {
                    $link = is_array($row['button'] ?? null) ? $row['button'] : [];
                    $title = (string)($link['title'] ?? '');
                    $url = (string)($link['url'] ?? '');
                    $target = (string)($link['target'] ?? '_self');
                    $color = self::normalizeColor($row['button_color'] ?? '');
                    $style = (string)($row['button_style'] ?? '');
                    $download = (bool)($row['button_download'] ?? false);
                    $icon = self::normalizeIcon($row['button_icon'] ?? '');
                    $iconBefore = self::normalizeIconPosition($row['button_icon_position'] ?? ($row['icon_position'] ?? ($row['button_iconPosition'] ?? ($row['iconPosition'] ?? true))));
                    // Apply global fallbacks when local values are unset/standard
                    $applyGlobals($color, $style, $icon);
                    $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon, $iconBefore));
                }
                return $collection;
            }
        }

        // 4) Backward compatibility: `button_repeater` (flattened keys like button_repeater_0_button)
        if (isset($data['button_repeater']) && !is_array($data['button_repeater'])) {
            $count = (int)$data['button_repeater'];
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $link = $data["button_repeater_{$i}_button"] ?? [];
                    $title = is_array($link) ? (string)($link['title'] ?? '') : '';
                    $url = is_array($link) ? (string)($link['url'] ?? '') : '';
                    $target = is_array($link) ? (string)($link['target'] ?? '_self') : '_self';
                    $color = self::normalizeColor($data["button_repeater_{$i}_button_color"] ?? ($data["button_repeater_{$i}_color"] ?? ''));
                    $style = (string)($data["button_repeater_{$i}_button_style"] ?? ($data["button_repeater_{$i}_style"] ?? ''));
                    $download = (bool)($data["button_repeater_{$i}_button_download"] ?? false);
                    $icon = self::normalizeIcon($data["button_repeater_{$i}_button_icon"] ?? ($data["button_repeater_{$i}_icon"] ?? ''));
                    $iconBefore = self::normalizeIconPosition($data["button_repeater_{$i}_button_icon_position"] ?? ($data["button_repeater_{$i}_icon_position"] ?? ($data["button_repeater_{$i}_button_iconPosition"] ?? ($data["button_repeater_{$i}_iconPosition"] ?? true))));
                    // Apply global fallbacks when local values are unset/standard
                    $applyGlobals($color, $style, $icon);
                    $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon, $iconBefore));
                }
                return $collection;
            }
        }

        // 5) Nothing found
        return $collection;
    }

    private static function normalizeColor(mixed $value): string
    {
        // Extract a scalar string from possible array/object shapes returned by the Theme Color field
        $extract = function ($val): string {
            if (is_array($val)) {
                // common shapes: ['value' => 'primary-color'] or ['slug' => 'primary-color'] or ['name' => 'primary-color']
                $v = $val['value'] ?? ($val['slug'] ?? ($val['name'] ?? ''));
                return is_scalar($v) ? (string)$v : '';
            }
            if (is_object($val)) {
                $arr = (array)$val;
                $v = $arr['value'] ?? ($arr['slug'] ?? ($arr['name'] ?? ''));
                return is_scalar($v) ? (string)$v : '';
            }
            return is_scalar($val) ? (string)$val : '';
        };

        $str = trim($extract($value));

        // Treat '0' (or empty) as unset so we don't output classes like btn-0 or bg-0
        if ($str === '' || $str === '0' || $str === 'null' || $str === '-') {
            return '';
        }

        // If the value accidentally includes a utility prefix, strip it
        if (strpos($str, 'bg-') === 0) {
            $str = substr($str, 3);
        } elseif (strpos($str, 'text-') === 0) {
            $str = substr($str, 5);
        }

        return $str;
    }

    private static function normalizeIcon(mixed $icon): string
    {
        // Helper to extract classes from an HTML element string
        $extractClassesFromHtml = function (string $html): string {
            if (strpos($html, 'class=') === false) {
                return '';
            }
            if (preg_match('/class\s*=\s*\"([^\"]+)\"/i', $html, $m)) {
                return trim($m[1]);
            }
            if (preg_match("/class\s*=\s*\'([^\']+)\'/i", $html, $m)) {
                return trim($m[1]);
            }
            return '';
        };

        // Map FA prefix to style suffix
        $faPrefixToStyle = function (string $prefix): string {
            $map = [
                'fa-solid' => 'solid', 'fas' => 'solid',
                'fa-regular' => 'regular', 'far' => 'regular',
                'fa-light' => 'light', 'fal' => 'light',
                'fa-thin' => 'thin', 'fat' => 'thin',
                'fa-duotone' => 'duotone_solid', 'fad' => 'duotone_solid',
                'fa-brands' => 'brands', 'fab' => 'brands',
            ];
            return $map[$prefix] ?? '';
        };

        // Normalize from different possible shapes ACF Font Awesome may return
        if (is_string($icon)) {
            $trim = trim($icon);
            if ($trim === '') return '';

            // If it's an HTML element string (save_format = element)
            if (str_contains($trim, '<') && str_contains($trim, 'class')) {
                $classes = $extractClassesFromHtml($trim);
                return $classes !== '' ? $classes : '';
            }

            // Try to decode possible JSON (save_format variants)
            $decoded = json_decode($trim, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // Common JSON shape: { style: 'solid', id: 'arrow-right' }
                $style = $decoded['style'] ?? '';
                $id = $decoded['id'] ?? '';
                if ($style && $id) {
                    return 'fa-' . $style . ' fa-' . $id;
                }
                // Alternative FA v6 format: { prefix: 'fas', iconName: 'arrow-right' }
                $prefix = $decoded['prefix'] ?? '';
                $iconName = $decoded['iconName'] ?? '';
                if ($prefix && $iconName) {
                    $style = $faPrefixToStyle($prefix) ?: $prefix;
                    // Try to ensure we always return FA classes
                    $styleClass = str_starts_with($style, 'fa-') ? $style : ('fa-' . $style);
                    return $styleClass . ' fa-' . $iconName;
                }
                // Sometimes the JSON may contain an 'element' string
                if (isset($decoded['element']) && is_string($decoded['element'])) {
                    $classes = $extractClassesFromHtml($decoded['element']);
                    if ($classes !== '') return $classes;
                }
            }

            // Otherwise assume it's already a class string like "fa-solid fa-arrow-right"
            return $trim;
        }

        if (is_array($icon)) {
            // Direct style/id
            $style = $icon['style'] ?? '';
            $id = $icon['id'] ?? '';
            if ($style && $id) {
                return 'fa-' . $style . ' fa-' . $id;
            }
            // HTML element provided
            if (isset($icon['element']) && is_string($icon['element'])) {
                $classes = $extractClassesFromHtml($icon['element']);
                if ($classes !== '') return $classes;
            }
            // Pre-extracted classes
            foreach (['class', 'classes', 'className'] as $k) {
                if (!empty($icon[$k]) && is_string($icon[$k])) {
                    return trim($icon[$k]);
                }
            }
            // FA v6 prefix/iconName style
            if (isset($icon['prefix']) && isset($icon['iconName'])) {
                $style = $faPrefixToStyle((string)$icon['prefix']) ?: (string)$icon['prefix'];
                $styleClass = str_starts_with($style, 'fa-') ? $style : ('fa-' . $style);
                return $styleClass . ' fa-' . (string)$icon['iconName'];
            }
            // Nested icon object
            if (isset($icon['icon']) && is_array($icon['icon'])) {
                $inner = $icon['icon'];
                if (isset($inner['prefix'], $inner['iconName'])) {
                    $style = $faPrefixToStyle((string)$inner['prefix']) ?: (string)$inner['prefix'];
                    $styleClass = str_starts_with($style, 'fa-') ? $style : ('fa-' . $style);
                    return $styleClass . ' fa-' . (string)$inner['iconName'];
                }
                if (isset($inner['style'], $inner['id']) && $inner['style'] && $inner['id']) {
                    return 'fa-' . $inner['style'] . ' fa-' . $inner['id'];
                }
                if (isset($inner['element']) && is_string($inner['element'])) {
                    $classes = $extractClassesFromHtml($inner['element']);
                    if ($classes !== '') return $classes;
                }
            }
        }

        return '';
    }

    private static function normalizeIconPosition(mixed $value): bool
    {
        // Default: true (icon before text)
        if (is_bool($value)) return $value;
        if (is_numeric($value)) return ((int)$value) !== 0;
        if (is_string($value)) {
            $v = strtolower(trim($value));
            if ($v === '') return true;
            if (in_array($v, ['1','true','yes','y','on','before'], true)) return true;
            if (in_array($v, ['0','false','no','n','off','after'], true)) return false;
        }
        return true;
    }
}