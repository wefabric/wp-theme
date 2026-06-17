<?php

namespace Theme\Helpers;

class AcfRepeater
{
    /**
     * Parse an ACF repeater field from $block['data'] regardless of context.
     *
     * - Frontend / first editor load: $data[$fieldName] is an integer count,
     *   sub-fields live as flat keys "{fieldName}_{i}_{subFieldName}".
     * - Editor re-render: $data[$fieldName] is an array of rows keyed by ACF
     *   row ID, each row's sub-fields are keyed by ACF field keys (field_xxx).
     *
     * Always returns an array of normalised associative rows keyed by field name.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function parse(array $data, string $fieldName): array
    {
        $raw = $data[$fieldName] ?? 0;

        if (is_array($raw)) {
            return array_values(array_map(
                fn(array $row) => self::resolveRow($row),
                $raw
            ));
        }

        $count = (int) $raw;
        $rows = [];
        $prefix = "{$fieldName}_";

        for ($i = 0; $i < $count; $i++) {
            $row = [];
            $rowPrefix = "{$prefix}{$i}_";
            foreach ($data as $key => $value) {
                if (str_starts_with((string) $key, $rowPrefix)) {
                    $row[substr($key, strlen($rowPrefix))] = $value;
                }
            }
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Resolve ACF field_* keys in an editor row to their registered field names.
     *
     * @param  array<string, mixed> $row
     * @return array<string, mixed>
     */
    private static function resolveRow(array $row): array
    {
        $resolved = [];
        foreach ($row as $key => $value) {
            if (str_starts_with((string) $key, 'field_') && function_exists('acf_get_field')) {
                $field = acf_get_field($key);
                $key = $field['name'] ?? $key;
            }
            $resolved[$key] = $value;
        }
        return $resolved;
    }
}
