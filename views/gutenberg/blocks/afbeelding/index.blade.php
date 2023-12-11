@php
    // Content
    $imageID = $block['data']['image'];
    $imageAlt = get_post_meta($imageID, '_wp_attachment_image_alt', true);
    $fullScreen = $block['data']['full_screen_image'] ?? false;

    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [33 => 'w-full lg:w-1/3', 50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto px-8' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = $block['data']['background_image'] ?? '';
    $backgroundOverlayEnabled = $block['data']['overlay_background_image'] ?? false;
    $backgroundOverlayColor = $block['data']['background_overlay_color'] ?? '';
    $backgroundOverlayOpacity = $block['data']['background_overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';
@endphp

<section id="afbeelding" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($backgroundOverlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $backgroundOverlayColor }} opacity-{{ $backgroundOverlayOpacity }}"></div>
    @endif
    <div class="relative z-10 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto relative">
            @if ($imageID)
                @include('components.image', [
                   'image_id' => $imageID,
                   'size' => 'full',
                   'object_fit' => 'cover',
                   'img_class' => 'w-full max-h-[400px] md:max-h-[600px] object-cover rounded-' . $borderRadius,
                   'alt' => $imageAlt
               ])
                @if ($overlayEnabled)
                    <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }} rounded-{{ $borderRadius }}"></div>
                @endif
            @endif
        </div>
    </div>
</section>