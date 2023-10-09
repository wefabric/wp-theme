@php
    // Content
    $imageID = $block['data']['image'];
    $imageAlt = get_post_meta($imageID, '_wp_attachment_image_alt', true);
    $imagePosition = $block['data']['image_position'] ?? '';
    $fullScreen = $block['data']['full_screen_image'] ?? false;
    $imageSize = $block['data']['image_size'] ?? '';

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [33 => 'w-full lg:w-1/3', 50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto px-8' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strenght'] ?? '' : 'rounded-none';
@endphp

<section id="afbeelding" class="relative bg-{{ $backgroundColor }} py-16 lg:py-0"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if($block['data']['image'])
                {!! wp_get_attachment_image($imageID, 'full', false, [
                    'class' => 'w-full object-cover rounded-' . $borderRadius,
                    'alt' => $imageAlt
                ]) !!}
            @endif
        </div>
    </div>
</section>