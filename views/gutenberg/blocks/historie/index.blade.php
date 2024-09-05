@php
    // Content
    $title = $block['data']['title'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    // Buttons
        $buttonText = $block['data']['button_button']['title'] ?? '';
        $buttonLink = $block['data']['button_button']['url'] ?? '';
        $buttonTarget = $block['data']['button_button']['target'] ?? '_self';
        $buttonColor = $block['data']['button_button_color'] ?? '';
        $buttonStyle = $block['data']['button_button_style'] ?? '';

        $textPosition = $block['data']['text_position'] ?? '';
        $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
        $textClass = $titleClassMap[$textPosition] ?? '';

    $timelineLineColor = $block['data']['timeline_line_color'] ?? '';
    $timelineYearTextColor = $block['data']['timeline_year_text_color'] ?? '';
    $timelineTextColor = $block['data']['timeline_text_color'] ?? '';
    $timelineBlockBackgroundColor = $block['data']['timeline_block_background_color'] ?? '';

    // Show timeline items
    $timelineData = [];
    $numTimelineItems = intval($block['data']['timeline']);

    for ($i = 0; $i < $numTimelineItems; $i++) {
        $imageKey = "timeline_{$i}_image";
        $yearKey = "timeline_{$i}_year";
        $textKey = "timeline_{$i}_text";
        $displayKey = "timeline_{$i}_image_display";

        $imageID = $block['data'][$imageKey] ?? '';
        $display = $block['data'][$displayKey] ?? 'cover';

        $year = $block['data'][$yearKey] ?? '';
        $text = $block['data'][$textKey] ?? '';

        $imageAlt = get_post_meta($imageID, '_wp_attachment_image_alt', true);

        $timelineData[] = [
            'imageId' => $imageID,
            'year' => $year,
            'text' => $text,
            'alt' => $imageAlt,
            'display' => $display,
        ];
    }


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
    $hideBlock = $block['data']['hide_block'] ?? false;


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

<section id="historie" class="block-historie relative historie-{{ $randomNumber }}-custom-padding historie-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto {{ $textClass }}">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>
            @endif
            @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'mb-8 text-' . $textColor . ($blockWidth == 'fullscreen' ? ' ' : '')
                ])
            @endif

            <div class="mt-8 lg:mt-16 relative h-full">
                <div class="history-vertical-line w-[4px] bg-{{ $timelineLineColor }} h-full absolute lg:left-1/2 -translate-x-1/2">
                    <div class="w-[12px] h-[12px] bg-{{ $timelineLineColor }} rounded-full absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="w-[12px] h-[12px] bg-{{ $timelineLineColor }} rounded-full absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2"></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2">
                    @foreach ($timelineData as $index => $item)
                        @php
                            $isOdd = $index % 2 !== 0;
                            $cardClass = $isOdd ? 'right-card' : 'left-card';
                            $marginLeftClass = $isOdd ? 'lg:pl-16 mt-8 lg:mt-20' : 'lg:pl-0 lg:pr-16 mt-8 lg:mt-0';
                            $timelineLinePosition = $isOdd ? 'top-1/2' : 'lg:left-auto lg:right-0 top-1/2';
                            $roundedFullPosition = $isOdd ? 'right-0 top-1/2 translate-x-1/2 -translate-y-1/2' : 'left-auto right-0 lg:right-auto lg:left-0 top-1/2 translate-x-1/2 lg:-translate-x-1/2 -translate-y-1/2';
                        @endphp

                        <div class="{{ $cardClass }} timeline-card relative h-fit pl-10 {{ $marginLeftClass }}">
                            <div class="history-horizontal-line w-[20px] lg:w-[30px] h-[4px] bg-{{ $timelineLineColor }} absolute left-0 {{ $timelineLinePosition }}">
                                <div class="w-[12px] h-[12px] bg-{{ $timelineLineColor }} rounded-full absolute {{ $roundedFullPosition }}"></div>
                            </div>
                            <div class="flex flex-col">
                                @if($item['imageId'])
                                    <div class="history-image relative h-[170px]">
                                        @include('components.image', [
                                            'image_id' => $item['imageId'],
                                            'size' => 'full',
                                            'object_fit' => $item['display'],
                                            'img_class' => 'h-[170px] w-full',
                                            'alt' => $item['alt']
                                        ])
                                    </div>
                                @endif
                                <div class="history-data relative p-4 lg:p-8 bg-{{ $timelineBlockBackgroundColor }}">
                                    @if($item['year'])
                                        <p class="h3 text-{{ $timelineYearTextColor }}">{{ $item['year'] }}</p>
                                    @endif
                                    @if($item['text'])
                                        @include('components.content', ['content' => apply_filters('the_content', $item['text']), 'class' => 'text-' . $timelineTextColor])
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if (($buttonText) && ($buttonLink))
                <div class="{{ $textClass }} buttons w-full flex flex-wrap gap-4 mt-4 md:mt-8">
                    @include('components.buttons.default', [
                       'text' => $buttonText,
                       'href' => $buttonLink,
                       'alt' => $buttonText,
                       'colors' => 'btn-' . $buttonColor . ' btn-' . $buttonStyle,
                       'class' => 'rounded-lg',
                       'target' => $buttonTarget,
                   ])
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .historie-{{ $randomNumber }}-custom-padding {
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

    .historie-{{ $randomNumber }}-custom-margin {
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