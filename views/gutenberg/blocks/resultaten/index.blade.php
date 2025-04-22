@php
    // Content
    $title = $block['data']['title'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
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
    $textOrder = $textPosition === 'left' ? 'lg:order-1 left' : 'lg:order-2 right';
    $imageOrder = $textPosition === 'left' ? 'lg:order-2 right' : 'lg:order-1 left';

    $imageId = $block['data']['image'] ?? '';
    $imageAlt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
    $imageSize = $block['data']['image_size'] ?? '';
    $imageMaxHeight = $block['data']['image_max_height'] ?? '';
    $imageClass = '';
    $textClass = '';

    if ($imageSize === '33') {
        $imageClass = 'lg:w-1/3';
        $textClass = 'lg:w-2/3';
    } elseif ($imageSize === '50') {
        $imageClass = 'lg:w-1/2';
        $textClass = 'lg:w-1/2';
    } elseif ($imageSize === '66') {
        $imageClass = 'lg:w-2/3';
        $textClass = 'lg:w-1/3';
    }

    $verticalCentered = $block['data']['vertical_centered'] ?? false;


    // Resultaten
    $resultTitleColor = $block['data']['result_title_color'] ?? '';
    $resultTextColor = $block['data']['result_text_color'] ?? '';
    $resultBackgroundColor = $block['data']['result_background_color'] ?? '';

    $results = [];
    for ($i = 0; $i < 4; $i++) {
        $result_title_key = "results_{$i}_result_title";
        $result_text_key = "results_{$i}_result_text";

        if (isset($block['data'][$result_title_key]) && isset($block['data'][$result_text_key])) {
            $results[] = [
                'title' => $block['data'][$result_title_key],
                'text' => $block['data'][$result_text_key],
            ];
        }
    }


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
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
    $numberAnimation = $block['data']['number_animation'] ?? false;
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else resultaten @endif" class="block-resultaten relative resultaten-{{ $randomNumber }}-custom-padding resultaten-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            <div class="text-image flex flex-col lg:flex-row gap-8 xl:gap-20 @if ($verticalCentered) lg:items-center @endif">
                <div class="text {{ $textClass }} order-2 {{ $textOrder }}">
                    @if ($subTitle)
                        <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>
                    @endif
                    @if ($title)
                        <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                    @endif
                    @if ($text)
                        @include('components.content', [
                            'content' => apply_filters('the_content', $text),
                            'class' => 'mb-8 text-' . $textColor,
                        ])
                    @endif
                    @if (($button1Text) && ($button1Link))
                        <div class="buttons w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8">
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
                    <div class="results-list grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8 z-20 relative">
                        @foreach ($results as $result)
                            @php
                                preg_match('/(\d+)/', $result['title'], $titleMatches);
                                $numericTitle = $titleMatches[0] ?? '';
                                $isTitleNumber = !empty($numericTitle);

                                preg_match('/(\d+)/', $result['text'], $textMatches);
                                $numericText = $textMatches[0] ?? '';
                                $isTextNumber = !empty($numericText);
                            @endphp

                            <div class="result-item px-12 py-4 w-full bg-{{ $resultBackgroundColor }}">
                                <div class="result-title text-{{ $resultTitleColor }}">
                                    @if ($isTitleNumber && $numberAnimation)
                                        <span class="counter" data-target="{{ $numericTitle }}">0</span>{{ str_replace($numericTitle, '', $result['title']) }}
                                    @else
                                        {!! $result['title'] !!}
                                    @endif
                                </div>
                                <div class="result-text text-{{ $resultTextColor }}">
                                    @if ($isTextNumber && $numberAnimation)
                                        <span class="counter" data-target="{{ $numericText }}">0</span>{{ str_replace($numericText, '', $result['text']) }}
                                    @else
                                        {!! $result['text'] !!}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if ($imageId)
                    <div class="image image-{{ $randomNumber }} {{ $imageClass }} order-1 {{ $imageOrder }}">
                        @include('components.image', [
                            'image_id' => $imageId,
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'w-full object-cover rounded-' . $borderRadius,
                            'alt' => $imageAlt
                        ])
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    .image-{{ $randomNumber }} img {
        @if($imageMaxHeight) max-height: {{ $imageMaxHeight }}px; @endif
    }

    .resultaten-{{ $randomNumber }}-custom-padding {
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

    .resultaten-{{ $randomNumber }}-custom-margin {
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

@if ($numberAnimation)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.counter');
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observerCallback = (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = +counter.getAttribute('data-target');
                        const duration = 1000;
                        const frameRate = 60;
                        const updateInterval = 1000 / frameRate;
                        const totalSteps = duration / updateInterval;
                        const increment = target / totalSteps;

                        let count = 0;

                        const updateCounter = () => {
                            count += increment;
                            if (count < target) {
                                counter.innerText = Math.ceil(count);
                                setTimeout(updateCounter, updateInterval);
                            } else {
                                counter.innerText = target;
                            }
                        };

                        updateCounter();
                        observer.unobserve(counter);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);

            counters.forEach(counter => {
                observer.observe(counter);
            });
        });
    </script>
@endif