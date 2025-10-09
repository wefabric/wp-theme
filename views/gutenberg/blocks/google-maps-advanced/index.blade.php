@php

if(empty(config('app.google_maps_api_key'))) {
    echo "Undefined google maps API key.";
    return;
}
        // Content
        $titleColor = $block['data']['title_color'] ?? '';
        $subTitle = $block['data']['subtitle'] ?? '';
        $subTitleColor = $block['data']['subtitle_color'] ?? '';
        $text = $block['data']['text'] ?? '';
        $textColor = $block['data']['text_color'] ?? '';

            // Buttons
            $button1Text = $block['data']['button_button_1']['title'] ?? '';
            $button1Link = $block['data']['button_button_1']['url'] ?? '';
            $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
            $button1Color = $block['data']['button_button_1_color'] ?? '';
            $button1Style = $block['data']['button_button_1_style'] ?? '';
            $button1Download = $block['data']['button_button_1_download'] ?? false;
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

            $textPosition = $block['data']['text_position'] ?? '';
            $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
            $textClass = $textClassMap[$textPosition] ?? '';





        // Block settings
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
        $customBlockId = $block['data']['custom_block_id'] ?? '';
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

        if($block['data']['establishment']) {
            $establishmentData = get_fields($block['data']['establishment']);
            $block['data']['maps_city'] = $establishmentData['city'] ?? '';
            $block['data']['maps_street'] = $establishmentData['street'] ?? '';
            $block['data']['maps_house_number'] = $establishmentData['house_number'] ?? '';
            $block['data']['maps_house_addition'] = $establishmentData['house_number_addition'];
            $block['data']['maps_zip_code'] = $establishmentData['postcode'] ?? '';
            $block['data']['maps_phone_number'] = $establishmentData['common_phone'] ?? '';
            $block['data']['maps_email'] = $establishmentData['common_email'] ?? '';

            $block['data']['latitude']  = $establishmentData['coordinates']['latitude'] ?? '';
            $block['data']['longitude'] = $establishmentData['coordinates']['longitude'] ?? '';
        }
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'google-maps' }}@endif"
         class="block-google-maps relative google-maps-{{ $randomNumber }}-custom-padding google-maps-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="mx-auto {{ $blockClass }}">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $subTitleColor }} {{ $textClass }}">{!! $subTitle !!}</span>
            @endif
            @if ($title)
                <h2 class="title mb-4 text-{{ $titleColor }} {{ $textClass }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'mb-8 text-' . $textColor . ' ' . $textClass . ($blockWidth == 'fullscreen' ? ' ' : '')
                ])
            @endif
            {{--load google maps options--}}
            {!! (new \Theme\Helpers\GoogleMapsObject($block['data']))->render() !!}
        </div>
    </div>
</section>

<style>
    And .google-maps-{{ $randomNumber }}-custom-padding {
        @media only screen and (min-width: 0px) {
            @if($mobilePaddingTop)  padding-top: {{ $mobilePaddingTop }}px;
            @endif
                       @if($mobilePaddingRight)  padding-right: {{ $mobilePaddingRight }}px;
            @endif
                       @if($mobilePaddingBottom)  padding-bottom: {{ $mobilePaddingBottom }}px;
            @endif
                       @if($mobilePaddingLeft)  padding-left: {{ $mobilePaddingLeft }}px; @endif

        }
        @media only screen and (min-width: 768px) {
            @if($tabletPaddingTop)  padding-top: {{ $tabletPaddingTop }}px;
            @endif
                       @if($tabletPaddingRight)  padding-right: {{ $tabletPaddingRight }}px;
            @endif
                       @if($tabletPaddingBottom)  padding-bottom: {{ $tabletPaddingBottom }}px;
            @endif
                       @if($tabletPaddingLeft)  padding-left: {{ $tabletPaddingLeft }}px; @endif

        }
        @media only screen and (min-width: 1024px) {
            @if($desktopPaddingTop)  padding-top: {{ $desktopPaddingTop }}px;
            @endif
                       @if($desktopPaddingRight)  padding-right: {{ $desktopPaddingRight }}px;
            @endif
                       @if($desktopPaddingBottom)  padding-bottom: {{ $desktopPaddingBottom }}px;
            @endif
                       @if($desktopPaddingLeft)  padding-left: {{ $desktopPaddingLeft }}px; @endif

        }
    }

    .google-maps-{{ $randomNumber }}-custom-margin {
        @media only screen and (min-width: 0px) {
            @if($mobileMarginTop)  margin-top: {{ $mobileMarginTop }}px;
            @endif
                       @if($mobileMarginRight)  margin-right: {{ $mobileMarginRight }}px;
            @endif
                       @if($mobileMarginBottom)  margin-bottom: {{ $mobileMarginBottom }}px;
            @endif
                       @if($mobileMarginLeft)  margin-left: {{ $mobileMarginLeft }}px; @endif

        }
        @media only screen and (min-width: 768px) {
            @if($tabletMarginTop)  margin-top: {{ $tabletMarginTop }}px;
            @endif
                       @if($tabletMarginRight)  margin-right: {{ $tabletMarginRight }}px;
            @endif
                       @if($tabletMarginBottom)  margin-bottom: {{ $tabletMarginBottom }}px;
            @endif
                       @if($tabletMarginLeft)  margin-left: {{ $tabletMarginLeft }}px; @endif

        }
        @media only screen and (min-width: 1024px) {
            @if($desktopMarginTop)  margin-top: {{ $desktopMarginTop }}px;
            @endif
                       @if($desktopMarginRight)  margin-right: {{ $desktopMarginRight }}px;
            @endif
                       @if($desktopMarginBottom)  margin-bottom: {{ $desktopMarginBottom }}px;
            @endif
                       @if($desktopMarginLeft)  margin-left: {{ $desktopMarginLeft }}px; @endif

        }
    }
</style>