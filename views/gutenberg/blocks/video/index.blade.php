@php
    // Content
    $title = $block['data']['title'] ?? '';
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


    // Video
    $videoFile = $block['data']['video_file'] ?? '';
    $videoUrl = $block['data']['video_url'] ?? '';
    $videoFileUrl = is_numeric($videoFile) ? wp_get_attachment_url($videoFile) : $videoFile;


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
    $customBlockId = $block['data']['custom_block_id'] ?? '';
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


    // Animaties
    $titleAnimation = $block['data']['title_animation'] ?? false;
    $flyInAnimation = $block['data']['flyin_animation'] ?? false;
    $textFadeDirection = $block['data']['flyin_direction'] ?? 'bottom';
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'video' }}@endif" class="block-video block-{{ $randomNumber }} relative video-{{ $randomNumber }}-custom-padding video-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto {{ $textClass }}">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $subTitleColor }} @if ($titleAnimation) title-animation @endif @if ($flyInAnimation) flyin-animation @endif">{!! $subTitle !!}</span>
            @endif
            @if ($title)
                <h2 class="title mb-4 text-{{ $titleColor }} @if ($titleAnimation) title-animation @endif @if ($flyInAnimation) flyin-animation @endif">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'mb-8 text-' . $textColor . ($flyInAnimation ? ' flyin-animation' : ''),
                ])
            @endif

            @if ($videoUrl)
                <div class="video-embed-wrapper">
                    {!! apply_filters('the_content', '[embed]' . $videoUrl . '[/embed]') !!}
                </div>
            @elseif ($videoFileUrl)
                <video class="w-full" controls>
                    <source src="{{ $videoFileUrl }}">
                    Your browser does not support the video tag.
                </video>
            @endif

            @if (($button1Text) && ($button1Link))
                <div class="{{ $textClass }} buttons w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 @if ($flyInAnimation) flyin-animation @endif">
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
        </div>
    </div>
</section>

<style>
    .video-{{ $randomNumber }}-custom-padding {
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

    .video-{{ $randomNumber }}-custom-margin {
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

    .video-embed-wrapper {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 ratio */
        height: 0;
    }

    .video-embed-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }
</style>

@if ($titleAnimation)
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            gsap.registerPlugin(ScrollTrigger);

            document.querySelectorAll('.title-animation').forEach(element => {
                let typeSplit = new SplitType(element, {
                    types: 'lines, words, chars',
                    tagName: 'span'
                });

                gsap.from(element.querySelectorAll('.word'), {
                    y: '100%',
                    opacity: 0,
                    duration: 0.5,
                    ease: 'back',
                    stagger: 0.1,
                    scrollTrigger: {
                        trigger: element, // The current element that triggers the animation
                        start: 'top 70%', // When the trigger element is 70% from the top of the viewport
                        end: 'top 50%', // Animation end point
                        scrub: true, // If set to false, the animation will not synchronize with the scrollbar
                        once: false, // Ensures the animation triggers only once
                        markers: false // Disable markers for production
                    }
                });
            });
        });
    </script>
@endif

@if ($flyInAnimation)
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            gsap.registerPlugin(ScrollTrigger);

            const randomNumber = @json($randomNumber);
            const block = document.querySelector(`.block-${randomNumber}`);

            if (block) {
                block.querySelectorAll('.flyin-animation').forEach(element => {
                    let typeSplit = new SplitType(element, {
                        types: 'lines',
                        tagName: 'span'
                    });

                    var fadeDirection = @json($textFadeDirection);
                    let xValue, yValue;

                    if (fadeDirection === "left") {
                        xValue = '-20%';
                    } else if (fadeDirection === "right") {
                        xValue = '20%';
                    } else {
                        xValue = '0%';
                    }

                    if (fadeDirection === "top") {
                        yValue = '-20%';
                    } else if (fadeDirection === "bottom") {
                        yValue = '20%';
                    } else {
                        yValue = '0%';
                    }

                    gsap.from(element.querySelectorAll('.line'), {
                        x: xValue,
                        y: yValue,
                        opacity: 0,
                        duration: 1.5,
                        ease: 'power4.out',
                        stagger: 0,
                        scrollTrigger: {
                            trigger: element, // The current element that triggers the animation
                            start: 'top 65%', // When the trigger element is 60% from the top of the viewport
                            end: 'top 50%', // Animation end point
                            scrub: false, // If set to false, the animation will not synchronize with the scrollbar
                            once: true, // Ensures the animation triggers only once
                            markers: false // Disable markers for production
                        }
                    });
                });
            }
        });
    </script>
@endif