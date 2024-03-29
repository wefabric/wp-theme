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


    // Paddings & margins
    $randomNumber = rand(0, 1000);

    $mobilePaddingTop = $block['data']['padding_mobile_padding_top'] ?? '';
    $mobilePaddingRight = $block['data']['padding_mobile_padding_right'] ?? '';
    $mobilePaddingBottom = $block['data']['padding_mobile_padding_bottom'] ?? '';
    $mobilePaddingLeft = $block['data']['padding_mobile_padding_left'] ?? '';
    $tabletPaddingTop = $block['data']['padding_tablet_padding_top'] ?? '';
    $tabletPaddingRight = $block['data']['padding_tablet_padding_right'] ?? '';
    $tabletPaddingBottom = $block['data']['padding_tablet_padding_bottom'] ?? '';
    $tabletPaddingLeft = $block['data']['padding_tablet_padding_left'] ?? '';
    $desktopPaddingTop = $block['data']['padding_desktop_padding_top'] ?? '';
    $desktopPaddingRight = $block['data']['padding_desktop_padding_right'] ?? '';
    $desktopPaddingBottom = $block['data']['padding_desktop_padding_bottom'] ?? '';
    $desktopPaddingLeft = $block['data']['padding_desktop_padding_left'] ?? '';

    $mobileMarginTop = $block['data']['margin_mobile_margin_top'] ?? '';
    $mobileMarginRight = $block['data']['margin_mobile_margin_right'] ?? '';
    $mobileMarginBottom = $block['data']['margin_mobile_margin_bottom'] ?? '';
    $mobileMarginLeft = $block['data']['margin_mobile_margin_left'] ?? '';
    $tabletMarginTop = $block['data']['margin_tablet_margin_top'] ?? '';
    $tabletMarginRight = $block['data']['margin_tablet_margin_right'] ?? '';
    $tabletMarginBottom = $block['data']['margin_tablet_margin_bottom'] ?? '';
    $tabletMarginLeft = $block['data']['margin_tablet_margin_left'] ?? '';
    $desktopMarginTop = $block['data']['margin_desktop_margin_top'] ?? '';
    $desktopMarginRight = $block['data']['margin_desktop_margin_right'] ?? '';
    $desktopMarginBottom = $block['data']['margin_desktop_margin_bottom'] ?? '';
    $desktopMarginLeft = $block['data']['margin_desktop_margin_left'] ?? '';
@endphp

<section id="afbeelding" class="block-afbeelding afbeelding-{{ $randomNumber }}-custom-padding afbeelding-{{ $randomNumber }}-custom-margin relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
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

<style>
    .afbeelding-{{ $randomNumber }}-custom-padding {
    @media only screen and (min-width: 0px) {
        padding-top: {{ $mobilePaddingTop }}px;
        padding-right: {{ $mobilePaddingRight }}px;
        padding-bottom: {{ $mobilePaddingBottom }}px;
        padding-left: {{ $mobilePaddingLeft }}px;
    }

    @media only screen and (min-width: 768px) {
        padding-top: {{ $tabletPaddingTop }}px;
        padding-right: {{ $tabletPaddingRight }}px;
        padding-bottom: {{ $tabletPaddingBottom }}px;
        padding-left: {{ $tabletPaddingLeft }}px;
    }

    @media only screen and (min-width: 1024px) {
        padding-top: {{ $desktopPaddingTop }}px;
        padding-right: {{ $desktopPaddingRight }}px;
        padding-bottom: {{ $desktopPaddingBottom }}px;
        padding-left: {{ $desktopPaddingLeft }}px;
    }
    }

    .afbeelding-{{ $randomNumber }}-custom-margin {
    @media only screen and (min-width: 0px) {
        margin-top: {{ $mobileMarginTop }}px;
        margin-right: {{ $mobileMarginRight }}px;
        margin-bottom: {{ $mobileMarginBottom }}px;
        margin-left: {{ $mobileMarginLeft }}px;
    }

    @media only screen and (min-width: 768px) {
        margin-top: {{ $tabletMarginTop }}px;
        margin-right: {{ $tabletMarginRight }}px;
        margin-bottom: {{ $tabletMarginBottom }}px;
        margin-left: {{ $tabletMarginLeft }}px;
    }

    @media only screen and (min-width: 1024px) {
        margin-top: {{ $desktopMarginTop }}px;
        margin-right: {{ $desktopMarginRight }}px;
        margin-bottom: {{ $desktopMarginBottom }}px;
        margin-left: {{ $desktopMarginLeft }}px;
    }
    }
</style>