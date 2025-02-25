@php
    // Content
    $imageId = $block['data']['image'];
    $imageAlt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
    $maxHeight = $block['data']['max_height'] ?? '';
    $maxWidth = $block['data']['max_width'] ?? '';
    $imageStyle = $block['data']['image_style'] ?? 'cover';

    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [33 => 'w-full lg:w-1/3', 50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto px-8' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $backgroundOverlayEnabled = $block['data']['overlay_background_image'] ?? false;
    $backgroundOverlayColor = $block['data']['background_overlay_color'] ?? '';
    $backgroundOverlayOpacity = $block['data']['background_overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


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


    // Animaties
    $imageParallax = $block['data']['image_parallax'] ?? false;
    $parallaxStrength = $block['data']['parallax_strength'] ?? 'normal';
@endphp

<section id="afbeelding" class="block-afbeelding block-{{ $randomNumber }} afbeelding-{{ $randomNumber }} afbeelding-{{ $randomNumber }}-custom-padding afbeelding-{{ $randomNumber }}-custom-margin relative bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($backgroundOverlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $backgroundOverlayColor }} opacity-{{ $backgroundOverlayOpacity }}"></div>
    @endif
    <div class="relative z-10 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto relative @if ($imageParallax) parallax-image @endif">
            @if ($imageId)
                @include('components.image', [
                   'image_id' => $imageId,
                   'size' => 'full',
                   'object_fit' => $imageStyle,
                   'img_class' => 'w-full ' . ' rounded-' . $borderRadius,
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
    .afbeelding-{{ $randomNumber }} img {
        @if($maxHeight) max-height: {{ $maxHeight }}px; @endif
        @if($maxWidth) max-width: {{ $maxWidth }}px; @endif
    }

    .afbeelding-{{ $randomNumber }}-custom-padding {
        @media only screen and (min-width: 0px) {
            @if($mobilePaddingTop) padding-top: {{ $mobilePaddingTop }}px; @endif
            @if($mobilePaddingRight) padding-right: {{ $mobilePaddingRight }}px; @endif
            @if($mobilePaddingBottom) padding-bottom: {{ $mobilePaddingBottom }}px; @endif
            @if($mobilePaddingLeft) padding-left: {{ $mobilePaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletPaddingTop) padding-top: {{ $tabletPaddingTop }}px; @endif
            @if($tabletPaddingRight) padding-right: {{ $tabletPaddingRight }}px; @endif
            @if($tabletPaddingBottom) padding-bottom: {{ $tabletPaddingBottom }}px; @endif
            @if($tabletPaddingLeft) padding-left: {{ $tabletPaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopPaddingTop) padding-top: {{ $desktopPaddingTop }}px; @endif
            @if($desktopPaddingRight) padding-right: {{ $desktopPaddingRight }}px; @endif
            @if($desktopPaddingBottom) padding-bottom: {{ $desktopPaddingBottom }}px; @endif
            @if($desktopPaddingLeft) padding-left: {{ $desktopPaddingLeft }}px; @endif
        }
    }

    .afbeelding-{{ $randomNumber }}-custom-margin {
        @media only screen and (min-width: 0px) {
            @if($mobileMarginTop) margin-top: {{ $mobileMarginTop }}px; @endif
            @if($mobileMarginRight) margin-right: {{ $mobileMarginRight }}px; @endif
            @if($mobileMarginBottom) margin-bottom: {{ $mobileMarginBottom }}px; @endif
            @if($mobileMarginLeft) margin-left: {{ $mobileMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletMarginTop) margin-top: {{ $tabletMarginTop }}px; @endif
            @if($tabletMarginRight) margin-right: {{ $tabletMarginRight }}px; @endif
            @if($tabletMarginBottom) margin-bottom: {{ $tabletMarginBottom }}px; @endif
            @if($tabletMarginLeft) margin-left: {{ $tabletMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopMarginTop) margin-top: {{ $desktopMarginTop }}px; @endif
            @if($desktopMarginRight) margin-right: {{ $desktopMarginRight }}px; @endif
            @if($desktopMarginBottom) margin-bottom: {{ $desktopMarginBottom }}px; @endif
            @if($desktopMarginLeft) margin-left: {{ $desktopMarginLeft }}px; @endif
        }
    }
</style>

<!-- Parallax effect -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const parallaxBlock = document.querySelector('.block-{{ $randomNumber }}');
        const parallaxImage = parallaxBlock.querySelector('.parallax-image');

        if (!parallaxBlock || !parallaxImage) return;

        // Get the parallax strength as a string from PHP
        const parallaxStrength = "{{ $parallaxStrength }}";

        // Set the parallax factor directly based on the strength
        let parallaxFactor = -0.4; // Default (normal)

        if (parallaxStrength === 'weak') {
            parallaxFactor = -0.2;
        } else if (parallaxStrength === 'strong') {
            parallaxFactor = -0.6;
        }

        console.log(parallaxStrength);

        function applyParallaxEffect() {
            const scrollPosition = window.scrollY;
            const blockRect = parallaxBlock.getBoundingClientRect();
            const blockTop = blockRect.top + window.scrollY;
            const blockHeight = blockRect.height;
            const viewportCenter = scrollPosition + window.innerHeight / 2;
            const blockCenter = blockTop + blockHeight / 2;
            const distanceFromCenter = viewportCenter - blockCenter;

            const translateY = distanceFromCenter * parallaxFactor;
            parallaxImage.style.transform = `translateY(${translateY}px)`;
        }

        window.addEventListener('scroll', applyParallaxEffect);
        applyParallaxEffect();
    });
</script>
