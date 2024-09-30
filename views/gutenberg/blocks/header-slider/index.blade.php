@php
    // Header style
    $headerHeight = $block['data']['header_height'] ?? '';
    $heightClasses = [
        1 => 'h-[400px] sm:h-[500px] md:h-[500px] lg:h-[500px] xl:h-[500px] 2xl:h-[800px]',
        2 => 'h-[200px] md:h-[400px] 2xl:h-[500px]',
        3 => 'h-[120px] md:h-[200px]',
    ];
    $headerClass = $heightClasses[$headerHeight] ?? '';

    $headerNames = [
        1 => 'big-header',
        2 => 'medium-header',
        3 => 'small-header',
    ];
    $headerName = $headerNames[$headerHeight] ?? '';

    // Content
    $title = !empty($block['data']['title']) ? $block['data']['title'] : get_the_title();
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $showTitle = $block['data']['show_title'] ?? true;
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

        // Buttons
        $button1Text = $block['data']['button_button_1']['title'] ?? '';
        $button1Link = $block['data']['button_button_1']['url'] ?? '';
        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
        $button1Color = $block['data']['button_button_1_color'] ?? '';
        $button1Style = $block['data']['button_button_1_style'] ?? '';
        $button2Text = $block['data']['button_button_2']['title'] ?? '';
        $button2Link = $block['data']['button_button_2']['url'] ?? '';
        $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
        $button2Color = $block['data']['button_button_2_color'] ?? '';
        $button2Style = $block['data']['button_button_2_style'] ?? '';

        $textPosition = $block['data']['text_position'] ?? '';
        $textPositionClass = '';
        $textWidthClass = '';



    // Number of images in the slider
    $numImages = $block['data']['slider_1_images'] ?? 0;
    $imagesSlider1Data = [];

       // Fetch images and their details
    for ($i = 0; $i < $numImages; $i++) {
        $imageKey = "slider_1_images_{$i}_image";
        $imageId = $block['data'][$imageKey] ?? '';

        if ($imageId) {
            $imageInfo = wp_get_attachment_image_src($imageId, 'full');
            if ($imageInfo) {
                $alt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
                $alt = $alt ? $alt : "image_$i";

                $imagesSlider1Data[] = [
                    'id' => $imageId,
                    'url' => $imageInfo[0],
                    'alt' => $alt
                ];
            }
        }
    }

    // Number of images in slider 2
    $numImagesSlider2 = $block['data']['slider_2_images'] ?? 0;
    $imagesSlider2Data = [];

    // Fetch images and their details for slider 2
    for ($i = 0; $i < $numImagesSlider2; $i++) {
        $imageKey = "slider_2_images_{$i}_image";
        $imageId = $block['data'][$imageKey] ?? '';

        if ($imageId) {
            $imageInfo = wp_get_attachment_image_src($imageId, 'full');
            if ($imageInfo) {
                $alt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
                $alt = $alt ? $alt : "image_$i";

                $imagesSlider2Data[] = [
                    'id' => $imageId,
                    'url' => $imageInfo[0],
                    'alt' => $alt
                ];
            }
        }
    }


    // Breadcrumbs
    $breadcrumbsEnabled = $block['data']['show_breadcrumbs'] ?? false;
    $breadcrumbsBackgroundColor = $block['data']['breadcrumbs_background_color'] ?? '';
    $breadcrumbsTextColor = $block['data']['breadcrumbs_text_color'] ?? '';
    $breadcrumbsLocation = $block['data']['breadcrumbs_location'] ?? 'underneath';


    // Blokinstellingen
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $showFeaturedImage = $block['data']['show_featured_image'] ?? false;
    $featuredImage = $showFeaturedImage ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '';
    $featuredImageId = $featuredImage ? attachment_url_to_postid($featuredImage) : '';
    $backgroundVideoID = $block['data']['background_video'] ?? '';
    $backgroundVideoURL = $backgroundVideoID ? wp_get_attachment_url($backgroundVideoID) : '';

    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $headerBackgroundColor = $block['data']['background_color'] ?? '';
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
@endphp

<section id="header-slider" class="block-header-slider relative header-slider-{{ $randomNumber }}-custom-padding header-slider-{{ $randomNumber }}-custom-margin bg-{{ $headerBackgroundColor }} {{ $headerName }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }} max-w-[2800px] mx-auto">
    <div class="custom-styling bg-cover bg-center {{ $headerClass }}"
         style="background-image: url('{{ $backgroundImageId ? wp_get_attachment_image_url($backgroundImageId, 'full') : ($featuredImage ? $featuredImage : '') }}'); {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId ?: $featuredImageId) }}">
        @if ($backgroundVideoURL)
            <video autoplay muted loop playsinline class="video-background absolute inset-0 w-full h-full object-cover" poster="one-does-not-simply.jpg">
                <source src="{{ esc_url($backgroundVideoURL) }}" type="video/mp4">
            </video>
        @endif
        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="custom-width relative container mx-auto px-8 h-full flex flex-col lg:flex-row gap-y-8 gap-x-16 items-center z-30 {{ $textPositionClass }}">

            <div class="header-info w-full lg:w-1/2 z-30 flex flex-col order-2 lg:order-1 {{ $textWidthClass }}">
                @if ($showTitle)
                    @if ($subTitle)
                        <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>
                    @endif
                    <h1 class="title text-{{ $titleColor }}">{!! $title !!}</h1>
                @endif
                @if ($text)
                    @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 text-lg mb-4 text-' . $textColor])
                @endif
                @if (($button1Text) && ($button1Link))
                    <div class="buttons w-full flex flex-wrap gap-y-2 gap-x-6 mt-4 @if ($textPosition === 'center') justify-center items-center @endif">
                        @include('components.buttons.default', [
                           'text' => $button1Text,
                           'href' => $button1Link,
                           'alt' => $button1Text,
                           'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                           'class' => 'rounded-lg w-fit',
                           'target' => $button1Target,
                        ])
                        @if (($button2Text) && ($button2Link))
                            @include('components.buttons.default', [
                               'text' => $button2Text,
                               'href' => $button2Link,
                               'alt' => $button2Text,
                               'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                               'class' => 'rounded-lg w-fit',
                               'target' => $button2Target,
                            ])
                        @endif
                    </div>
                @endif
                @if ($breadcrumbsEnabled && $breadcrumbsLocation === 'inside' &&!is_front_page() && get_the_ID())
                    @include('components.breadcrumbs.index')
                @endif
            </div>

            <div class="sliders order-1 lg:order-2 w-full lg:w-1/2">
                <div class="horizontal-slider block lg:hidden gap-x-8">
                    @include('components.header-slider.slider', ['images' => array_merge($imagesSlider1Data, $imagesSlider2Data), 'direction' => 'horizontal', 'sliderId' => 'headerHorizontalSwiper1'])
                </div>
                <div class="vertical-sliders hidden lg:flex gap-x-8">
                    <div class="slider-1 @if($imagesSlider2Data) w-1/2 @endif h-full">
                        @include('components.header-slider.slider', ['images' => $imagesSlider1Data, 'direction' => 'vertical', 'sliderId' => 'headerSwiper1'])
                    </div>
                    @if($imagesSlider2Data)
                        <div class="slider-2 w-1/2 h-full">
                            @include('components.header-slider.slider', ['images' => $imagesSlider2Data, 'direction' => 'vertical', 'sliderId' => 'headerSwiper2', 'reverse' => true])
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@if ($customBlockClasses) <div class="breadcrumbs-{{ $customBlockClasses }}"> @endif
    @if ($breadcrumbsEnabled && $breadcrumbsLocation === 'underneath' && !is_front_page() && get_the_ID())
        @include('components.breadcrumbs.index')
    @endif
@if ($customBlockClasses) </div> @endif


<style>
    .header-slider-{{ $randomNumber }}-custom-padding {
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

    .header-slider-{{ $randomNumber }}-custom-margin {
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