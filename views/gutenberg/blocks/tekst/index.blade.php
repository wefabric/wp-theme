@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
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
        $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
        $textClass = $titleClassMap[$textPosition] ?? '';


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';


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

<section id="tekst" class="block-tekst relative tekst-{{ $randomNumber }}-custom-padding tekst-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }};">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} {{ $textClass }} mx-auto">
            @if ($title)
                <h2 class="mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'text-' . $textColor])
            @endif
            @if (($button1Text) && ($button1Link))
                <div class="{{ $textClass }} w-full flex sm:flex-row gap-4 mt-4 md:mt-8">
                    @include('components.buttons.default', [
                       'text' => $button1Text,
                       'href' => $button1Link,
                       'alt' => $button1Text,
                       'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                       'class' => 'rounded-lg',
                       'target' => $button1Target,
                   ])
                    @if (($button2Text) && ($button2Link))
                            @include('components.buttons.default', [
                               'text' => $button2Text,
                               'href' => $button2Link,
                               'alt' => $button2Text,
                               'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                               'class' => 'rounded-lg',
                               'target' => $button2Target,
                           ])
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .tekst-{{ $randomNumber }}-custom-padding {
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

    .tekst-{{ $randomNumber }}-custom-margin {
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