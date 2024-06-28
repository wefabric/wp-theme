{{--@php--}}
{{--    // Content--}}
{{--    $title = $block['data']['title'] ?? '';--}}
{{--    $subTitle = $block['data']['subtitle'] ?? '';--}}
{{--    $titleColor = $block['data']['title_color'] ?? '';--}}
{{--    $text = $block['data']['text'] ?? '';--}}
{{--    $textColor = $block['data']['text_color'] ?? '';--}}


{{--     // Buttons--}}
{{--        $button1Text = $block['data']['button_button_1']['title'] ?? '';--}}
{{--        $button1Link = $block['data']['button_button_1']['url'] ?? '';--}}
{{--        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';--}}
{{--        $button1Color = $block['data']['button_button_1_color'] ?? '';--}}
{{--        $button1Style = $block['data']['button_button_1_style'] ?? '';--}}
{{--        $button2Text = $block['data']['button_button_2']['title'] ?? '';--}}
{{--        $button2Link = $block['data']['button_button_2']['url'] ?? '';--}}
{{--        $button2Target = $block['data']['button_button_2']['target'] ?? '_self';--}}
{{--        $button2Color = $block['data']['button_button_2_color'] ?? '';--}}
{{--        $button2Style = $block['data']['button_button_2_style'] ?? '';--}}

{{--        $textPosition = $block['data']['text_position'] ?? '';--}}
{{--        $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];--}}
{{--        $textClass = $titleClassMap[$textPosition] ?? '';--}}


{{--//    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];--}}
{{--//    $titleClass = $titleClassMap[$titlePosition] ?? '';--}}

{{--    // Show images--}}
{{--    $imagesData = [];--}}
{{--    $numImages = intval($block['data']['images']);--}}

{{--    for ($i = 0; $i < $numImages; $i++) {--}}
{{--    $imageKey = "images_{$i}_image";--}}
{{--    $captionKey = "images_{$i}_caption";--}}
{{--    $linkKey = "images_{$i}_link";--}}

{{--    $imageID = $block['data'][$imageKey] ?? '';--}}
{{--    $caption = $block['data'][$captionKey] ?? '';--}}
{{--    $imageLink = $block['data'][$linkKey] ?? '';--}}

{{--        if ($imageID) {--}}
{{--            $imageInfo = wp_get_attachment_image_src($imageID, 'full');--}}
{{--            if ($imageInfo) {--}}
{{--                $alt = get_post_meta($imageID, '_wp_attachment_image_alt', true);--}}
{{--                $alt = $alt ? $alt : "image_$i";--}}

{{--                $linkTitle = $imageLink['title'] ?? '';--}}
{{--                $linkUrl = $imageLink['url'] ?? '';--}}
{{--                $linkTarget = $imageLink['target'] ?? '';--}}

{{--                $imagesData[] = [--}}
{{--                    'id' => $imageID,--}}
{{--                    'url' => $imageInfo[0],--}}
{{--                    'caption' => $caption,--}}
{{--                    'alt' => $alt,--}}
{{--                    'link' => [--}}
{{--                        'title' => $linkTitle,--}}
{{--                        'url' => $linkUrl,--}}
{{--                        'target' => $linkTarget--}}
{{--                    ]--}}
{{--                ];--}}
{{--            }--}}
{{--        }--}}
{{--    }--}}

{{--    // Blokinstellingen--}}
{{--    $blockWidth = $block['data']['block_width'] ?? 100;--}}
{{--    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];--}}
{{--    $blockClass = $blockClassMap[$blockWidth] ?? '';--}}

{{--//    todo: dit kan weg--}}
{{--//    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';--}}

{{--    if ($blockWidth !== 'fullscreen') {--}}
{{--        $customContainer = $block['data']['custom_container'] ?? 'full-container';--}}
{{--        $containerClassMap = ['full-container' => 'container mx-auto', 'left-container' => 'left-container', 'right-container' => 'right-container'];--}}
{{--        $containerClass = $containerClassMap[$customContainer] ?? '';--}}
{{--    }--}}
{{--    else {--}}
{{--        $containerClass = '';--}}
{{--    }--}}

{{--    $backgroundColor = $block['data']['background_color'] ?? 'default-color';--}}
{{--    $imageId = ($block['data']['background_image']) ?? '';--}}
{{--    $overlayEnabled = $block['data']['overlay_image'] ?? false;--}}
{{--    $overlayColor = $block['data']['overlay_color'] ?? '';--}}
{{--    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';--}}

{{--    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';--}}

{{--    // Theme settings--}}
{{--    $options = get_fields('option');--}}
{{--    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';--}}


{{--    // Paddings & margins--}}
{{--    $randomNumber = rand(0, 1000);--}}

{{--    $mobilePaddingTop = $block['data']['padding_mobile_padding_top'] ?? '';--}}
{{--    $mobilePaddingRight = $block['data']['padding_mobile_padding_right'] ?? '';--}}
{{--    $mobilePaddingBottom = $block['data']['padding_mobile_padding_bottom'] ?? '';--}}
{{--    $mobilePaddingLeft = $block['data']['padding_mobile_padding_left'] ?? '';--}}
{{--    $tabletPaddingTop = $block['data']['padding_tablet_padding_top'] ?? '';--}}
{{--    $tabletPaddingRight = $block['data']['padding_tablet_padding_right'] ?? '';--}}
{{--    $tabletPaddingBottom = $block['data']['padding_tablet_padding_bottom'] ?? '';--}}
{{--    $tabletPaddingLeft = $block['data']['padding_tablet_padding_left'] ?? '';--}}
{{--    $desktopPaddingTop = $block['data']['padding_desktop_padding_top'] ?? '';--}}
{{--    $desktopPaddingRight = $block['data']['padding_desktop_padding_right'] ?? '';--}}
{{--    $desktopPaddingBottom = $block['data']['padding_desktop_padding_bottom'] ?? '';--}}
{{--    $desktopPaddingLeft = $block['data']['padding_desktop_padding_left'] ?? '';--}}

{{--    $mobileMarginTop = $block['data']['margin_mobile_margin_top'] ?? '';--}}
{{--    $mobileMarginRight = $block['data']['margin_mobile_margin_right'] ?? '';--}}
{{--    $mobileMarginBottom = $block['data']['margin_mobile_margin_bottom'] ?? '';--}}
{{--    $mobileMarginLeft = $block['data']['margin_mobile_margin_left'] ?? '';--}}
{{--    $tabletMarginTop = $block['data']['margin_tablet_margin_top'] ?? '';--}}
{{--    $tabletMarginRight = $block['data']['margin_tablet_margin_right'] ?? '';--}}
{{--    $tabletMarginBottom = $block['data']['margin_tablet_margin_bottom'] ?? '';--}}
{{--    $tabletMarginLeft = $block['data']['margin_tablet_margin_left'] ?? '';--}}
{{--    $desktopMarginTop = $block['data']['margin_desktop_margin_top'] ?? '';--}}
{{--    $desktopMarginRight = $block['data']['margin_desktop_margin_right'] ?? '';--}}
{{--    $desktopMarginBottom = $block['data']['margin_desktop_margin_bottom'] ?? '';--}}
{{--    $desktopMarginLeft = $block['data']['margin_desktop_margin_left'] ?? '';--}}
{{--@endphp--}}

{{--<section id="foto-slider" class="block-foto-slider relative foto-slider-{{ $randomNumber }}-custom-padding foto-slider-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }}"--}}
{{--         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">--}}
{{--    @if ($overlayEnabled)--}}
{{--        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>--}}
{{--    @endif--}}
{{--    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $containerClass }}">--}}
{{--        <div class="{{ $blockClass }} {{ $textClass }} mx-auto">--}}
{{--            @if ($subTitle)--}}
{{--                <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>--}}
{{--            @endif--}}
{{--            @if ($title)--}}
{{--                <h2 class="lg:mb-4 text-{{ $titleColor }}  @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{!! $title !!}</h2>--}}
{{--            @endif--}}
{{--            @if ($text)--}}
{{--                @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'text-' . $textColor])--}}
{{--            @endif--}}
{{--            @include('components.photo-slider.list')--}}
{{--            @if (($button1Text) && ($button1Link))--}}
{{--                <div class="{{ $textClass }} w-full flex sm:flex-row gap-4 mt-4 md:mt-8">--}}
{{--                    @include('components.buttons.default', [--}}
{{--                        'text' => $button1Text,--}}
{{--                        'href' => $button1Link,--}}
{{--                        'alt' => $button1Text,--}}
{{--                        'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,--}}
{{--                        'class' => 'rounded-lg',--}}
{{--                        'target' => $button1Target,--}}
{{--                    ])--}}
{{--                    @if (($button2Text) && ($button2Link))--}}
{{--                        @include('components.buttons.default', [--}}
{{--                            'text' => $button2Text,--}}
{{--                            'href' => $button2Link,--}}
{{--                            'alt' => $button2Text,--}}
{{--                            'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,--}}
{{--                            'class' => 'rounded-lg',--}}
{{--                            'target' => $button2Target,--}}
{{--                        ])--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}

{{--<style>--}}
{{--    .foto-slider-{{ $randomNumber }}-custom-padding {--}}
{{--    @media only screen and (min-width: 0px) {--}}
{{--        @if($mobilePaddingTop) padding-top: {{ $mobilePaddingTop }}px; @endif--}}
{{--            @if($mobilePaddingRight) padding-right: {{ $mobilePaddingRight }}px; @endif--}}
{{--            @if($mobilePaddingBottom) padding-bottom: {{ $mobilePaddingBottom }}px; @endif--}}
{{--            @if($mobilePaddingLeft) padding-left: {{ $mobilePaddingLeft }}px; @endif--}}
{{--        }--}}
{{--    @media only screen and (min-width: 768px) {--}}
{{--        @if($tabletPaddingTop) padding-top: {{ $tabletPaddingTop }}px; @endif--}}
{{--            @if($tabletPaddingRight) padding-right: {{ $tabletPaddingRight }}px; @endif--}}
{{--            @if($tabletPaddingBottom) padding-bottom: {{ $tabletPaddingBottom }}px; @endif--}}
{{--            @if($tabletPaddingLeft) padding-left: {{ $tabletPaddingLeft }}px; @endif--}}
{{--        }--}}
{{--    @media only screen and (min-width: 1024px) {--}}
{{--        @if($desktopPaddingTop) padding-top: {{ $desktopPaddingTop }}px; @endif--}}
{{--            @if($desktopPaddingRight) padding-right: {{ $desktopPaddingRight }}px; @endif--}}
{{--            @if($desktopPaddingBottom) padding-bottom: {{ $desktopPaddingBottom }}px; @endif--}}
{{--            @if($desktopPaddingLeft) padding-left: {{ $desktopPaddingLeft }}px; @endif--}}
{{--        }--}}
{{--    }--}}

{{--    .foto-slider-{{ $randomNumber }}-custom-margin {--}}
{{--    @media only screen and (min-width: 0px) {--}}
{{--        @if($mobileMarginTop) margin-top: {{ $mobileMarginTop }}px; @endif--}}
{{--            @if($mobileMarginRight) margin-right: {{ $mobileMarginRight }}px; @endif--}}
{{--            @if($mobileMarginBottom) margin-bottom: {{ $mobileMarginBottom }}px; @endif--}}
{{--            @if($mobileMarginLeft) margin-left: {{ $mobileMarginLeft }}px; @endif--}}
{{--        }--}}
{{--    @media only screen and (min-width: 768px) {--}}
{{--        @if($tabletMarginTop) margin-top: {{ $tabletMarginTop }}px; @endif--}}
{{--            @if($tabletMarginRight) margin-right: {{ $tabletMarginRight }}px; @endif--}}
{{--            @if($tabletMarginBottom) margin-bottom: {{ $tabletMarginBottom }}px; @endif--}}
{{--            @if($tabletMarginLeft) margin-left: {{ $tabletMarginLeft }}px; @endif--}}
{{--        }--}}
{{--    @media only screen and (min-width: 1024px) {--}}
{{--        @if($desktopMarginTop) margin-top: {{ $desktopMarginTop }}px; @endif--}}
{{--            @if($desktopMarginRight) margin-right: {{ $desktopMarginRight }}px; @endif--}}
{{--            @if($desktopMarginBottom) margin-bottom: {{ $desktopMarginBottom }}px; @endif--}}
{{--            @if($desktopMarginLeft) margin-left: {{ $desktopMarginLeft }}px; @endif--}}
{{--        }--}}
{{--    }--}}
{{--</style>--}}