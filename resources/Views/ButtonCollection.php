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
                // push rows even if one of title/url is empty; template guards will skip rendering empties
                $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon));
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
                    $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon));
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
                    $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon));
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
                    $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon));
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
                    $collection->push(new Button($title, $url, $target, $color, $style, $download, $icon));
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
        // Accept already formatted class string or JSON from font-awesome field
        if (is_string($icon)) {
            $trim = trim($icon);
            if ($trim === '') return '';
            // Try to decode possible JSON
            $decoded = json_decode($trim, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $style = $decoded['style'] ?? '';
                $id = $decoded['id'] ?? '';
                if ($style && $id) {
                    return 'fa-' . $style . ' fa-' . $id;
                }
            }
            return $trim;
        }
        if (is_array($icon)) {
            $style = $icon['style'] ?? '';
            $id = $icon['id'] ?? '';
            if ($style && $id) {
                return 'fa-' . $style . ' fa-' . $id;
            }
        }
        return '';
    }
}