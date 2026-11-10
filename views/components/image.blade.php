@if($image_id)
    @php
        /*
         * Optioneel: 'crop_ratio' (breedte / hoogte) waarop de afbeelding via object-cover wordt bijgesneden,
         * bijv. 1 voor aspect-square. De browser kiest een srcset-kandidaat op basis van de breedte, maar bij
         * het bijsnijden van een liggende foto naar een vierkant is de hoogte bepalend. Zonder correctie
         * kiest de browser dan een te klein bestand en wordt de foto opgerekt (wazig). Daarom schalen we de
         * w-descriptors naar de breedte die na het bijsnijden overblijft.
         */
        $srcsetFilter = null;
        if (!empty($crop_ratio)) {
            $srcsetFilter = function ($sources, $size_array, $image_src, $image_meta) use ($crop_ratio) {
                $width = (int) ($image_meta['width'] ?? 0);
                $height = (int) ($image_meta['height'] ?? 0);
                if (!$width || !$height) {
                    return $sources;
                }
                $factor = min(1, ((float) $crop_ratio * $height) / $width);
                if ($factor >= 1) {
                    return $sources;
                }
                $adjusted = [];
                foreach ($sources as $source) {
                    if (($source['descriptor'] ?? '') !== 'w') {
                        return $sources;
                    }
                    $source['value'] = max(1, (int) round($source['value'] * $factor));
                    $adjusted[$source['value']] = $source;
                }
                return $adjusted;
            };
            add_filter('wp_calculate_image_srcset', $srcsetFilter, 10, 4);
        }

        $imageHtml = wp_get_attachment_image($image_id, $size ?? 'full', 'false', [
            'class' => 'object-'. ($object_fit ?? 'cover') .' '. ($img_class ?? ''). ' ',
            'alt' => $alt ?? '',
        ]);

        if ($srcsetFilter) {
            remove_filter('wp_calculate_image_srcset', $srcsetFilter, 10);
        }
    @endphp
    <span class="image {{ $class ?? '' }}" {!! $attributes ?? '' !!}>
        {!! $imageHtml !!}
    </span>
@endif
