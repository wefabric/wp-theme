@php
    // Content
    $title = $block['data']['title'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

        $textPosition = $block['data']['text_position'] ?? '';
        $textClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
        $textClass = $textClassMap[$textPosition] ?? 'text-center';

    $flexClassMap = ['left' => 'justify-start', 'center' => 'justify-center', 'right' => 'justify-end',];
    $flexClass = $flexClassMap[$textPosition] ?? 'items-center';
    $ctaLayout = $block['data']['cta_layout'] ?? '';
    $flexDirection = ($ctaLayout === 'vertical') ? 'flex-col' : (($ctaLayout === 'horizontal') ? 'flex-row' : '');

    $ctaForm = $block['data']['form'] ?? '';
    $blockBackgroundColor = $block['data']['block_background_color'] ?? '';
    $blockBackgroundImage = $block['data']['block_background_image'] ?? '';
    $blockOverlayEnabled = $block['data']['block_overlay_image'] ?? false;
    $blockOverlayColor = $block['data']['block_overlay_color'] ?? '';
    $blockOverlayOpacity = $block['data']['block_overlay_opacity'] ?? '';

        // Buttons
        $button1Text = $block['data']['button_button_1']['title'] ?? '';
        $button1Link = $block['data']['button_button_1']['url'] ?? '';
        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
        $button1Color = $block['data']['button_button_1_color'] ?? '';
        $button1Style = $block['data']['button_button_1_style'] ?? '';
        $button1Download = $block['data']['button_button_1_download'] ?? false;
        $button1Icon = $block['data']['button_button_1_icon'] ?? '';
        $button1Icon = $block['data']['button_button_1_icon'] ?? '';
        if (!empty($button1Icon)) {
            $iconData = json_decode($button1Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $button1Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }
        $button2Text = $block['data']['button_button_2']['title'] ?? '';
        $button2Link = $block['data']['button_button_2']['url'] ?? '';
        $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
        $button2Color = $block['data']['button_button_2_color'] ?? '';
        $button2Style = $block['data']['button_button_2_style'] ?? '';
        $button2Download = $block['data']['button_button_2_download'] ?? false;
        $button2Icon = $block['data']['button_button_2_icon'] ?? '';
        if (!empty($button2Icon)) {
            $iconData = json_decode($button2Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $button2Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }


    // Employee
    $ctaEmployee = $block['data']['employee'] ?? '';
    $employeeImageId = $ctaEmployee ? get_field('image', $ctaEmployee) : '';
    $employeeImage = $employeeImageId ? wp_get_attachment_image_url($employeeImageId, 'full') : '';
    $employeeTitle = $ctaEmployee ? get_the_title($ctaEmployee) : '';


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';


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

<section id="cta-werknemer" class="block-cta-werknemer relative cta-werknemer-{{ $randomNumber }}-custom-padding cta-werknemer-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif

    <div class="cta-custom {{ $fullScreenClass }} @if ($employeeImage) pt-24 lg:pt-28 @else pt-8 lg:pt-16 xl:pt-20 @endif">

        {{-- Voor het uitlijnen naar rechts --}}
        <div class="custom-width background-container absolute top-0 right-0 h-full @if ($employeeImage) pt-24 lg:pt-28 @else pt-8 lg:pt-16 xl:pt-20 @endif">
            <div class="bg-{{ $blockBackgroundColor }} w-full h-full"></div>
        </div>

        @if ($employeeImage && $ctaLayout == 'vertical')
            <div class="employee-image overlay absolute z-30 left-1/2 -translate-x-1/2 -translate-y-1/2">
                @include('components.image', [
                 'image_id' => $employeeImageId,
                 'size' => 'full',
                 'object_fit' => 'cover',
                 'img_class' => 'w-[200px] lg:w-[300px] lg:h-[300px] aspect-square object-cover rounded-full',
                 'alt' => $employeeTitle,
             ])
            </div>
        @endif
        <div class="cta-block relative z-10 mx-auto {{ $blockClass }} relative @if($blockWidth !== 'fullscreen') md:px-8 @endif">
            <div class="px-8 py-16 bg-{{ $blockBackgroundColor }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif"
                 style="background-image: url('{{ wp_get_attachment_image_url($blockBackgroundImage, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($blockBackgroundImage) }}">
                @if ($blockOverlayEnabled)
                    <div class="absolute inset-0 @if($blockWidth !== 'fullscreen') md:mx-8 @endif bg-{{ $blockOverlayColor }} opacity-{{ $blockOverlayOpacity }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif"></div>
                @endif

                <div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full @endif relative z-10">
                    <div class="flex flex-col lg:{{ $flexDirection }} {{ $flexClass }} justify-center sm:px-8 lg:px-32 gap-y-4 gap-x-8 @if($employeeImage && $ctaLayout == 'vertical') mt-12 sm:mt-16 lg:mt-32 @endif">

                        <div class="@if ($ctaLayout == 'horizontal') order-2 lg:order-1 @else order-2 @endif @if($employeeImage) w-full lg:w-4/5 text-center lg:{{$textClass}} @else w-full lg:w-full {{ $textClass }} @endif">
                            @if ($subTitle)
                                <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>
                            @endif
                            @if ($title)
                                <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                            @endif
                            @if ($text)
                                @include('components.content', [
                                   'content' => apply_filters('the_content', $text),
                                   'class' => 'mt-4 text-' . $textColor,
                                ])
                            @endif
                            @if (($button1Text) && ($button1Link))
                                <div class="buttons flex gap-x-4 gap-y-2 w-full mt-4 md:mt-8 @if($employeeImage) justify-center @endif lg:{{ $flexClass }}">
                                    @include('components.buttons.default', [
                                        'text' => $button1Text,
                                        'href' => $button1Link,
                                        'alt' => $button1Text,
                                        'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                                        'class' => 'rounded-lg',
                                        'target' => $button1Target,
                                        'icon' => $button1Icon,
                                        'download' => $button1Download,
                                    ])
                                    @if (($button2Text) && ($button2Link))
                                        @include('components.buttons.default', [
                                            'text' => $button2Text,
                                            'href' => $button2Link,
                                            'alt' => $button2Text,
                                            'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                                            'class' => 'rounded-lg',
                                            'target' => $button2Target,
                                            'icon' => $button2Icon,
                                            'download' => $button2Download,
                                        ])
                                    @endif
                                </div>
                            @endif
                            @if ($ctaForm)
                                <div class="w-full @if($blockWidth == 'fullscreen') xl:w-1/2 @endif mx-auto mt-10 text-left text-white">
                                    {!! gravity_form($ctaForm, false) ; !!}
                                </div>
                            @endif
                        </div>

                        @if ($ctaLayout == 'horizontal' && $employeeImage)
                            <div class="@if($ctaLayout == 'horizontal') order-1 lg:order-2 @else order-1 @endif w-full lg:w-auto -mt-[150px]">
                                @include('components.image', [
                                    'image_id' => $employeeImageId,
                                    'size' => 'full',
                                    'object_fit' => 'cover',
                                    'img_class' => 'h-[200px] lg:h-auto w-auto lg:w-[350px] object-cover mx-auto rounded-full aspect-square',
                                    'alt' => $employeeTitle,
                                ])
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .cta-werknemer-{{ $randomNumber }}-custom-padding {
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

    .cta-werknemer-{{ $randomNumber }}-custom-margin {
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