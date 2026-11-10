@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $subtitleIcon = $block['data']['subtitle_icon'] ?? '';
    $subtitleIcon = $subtitleIcon ? json_decode($subtitleIcon, true) : null;
    $subtitleIconColor = $block['data']['subtitle_icon_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    // Button
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

    // Tijdlijn
    $items = [];
    foreach (\Theme\Helpers\AcfRepeater::parse($block['data'], 'timeline') as $row) {
        $items[] = [
            'image' => $row['image'] ?? '',
            'year' => $row['year'] ?? '',
            'text' => $row['text'] ?? '',
        ];
    }

    // Layout & slider-instellingen
    $perView = [
        'mobile' => (float) ($block['data']['layout_mobile'] ?? 1.25),
        'tablet' => (float) ($block['data']['layout_tablet'] ?? 2.25),
        'desktop' => (float) ($block['data']['layout_desktop'] ?? 3),
        'desktopXl' => (float) ($block['data']['layout_desktop_xl'] ?? 3),
    ];
    $spaceBetween = (int) ($block['data']['space_between'] ?? 0);
    $autoplay = ! empty($block['data']['autoplay']);
    $autoplaySpeed = max(1, (float) ($block['data']['autoplay_speed'] ?? 5)) * 1000;
    $centeredSlides = ! empty($block['data']['centered_slides']);
    $loopSlides = ! empty($block['data']['loop_slides']);
    $outsideContainer = array_key_exists('slider_outside_container', $block['data']) ? ! empty($block['data']['slider_outside_container']) : true;
    $showNavigation = array_key_exists('show_navigation', $block['data']) ? ! empty($block['data']['show_navigation']) : true;
    $paginationStyle = $block['data']['pagination_style'] ?? 'none';

    $sliderConfig = [
        'perView' => $perView,
        'spaceBetween' => $spaceBetween,
        'autoplay' => $autoplay,
        'autoplaySpeed' => $autoplaySpeed,
        'centered' => $centeredSlides,
        'loop' => $loopSlides,
        'pagination' => $paginationStyle,
        'count' => count($items),
    ];

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

    $hasHeader = $title || $subTitle || $text || ($button1Text && $button1Link);
@endphp

@if ($items || $hasHeader)
<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'historie-slider' }}@endif"
         class="block-historie-slider block-{{ $randomNumber }} relative overflow-hidden historie-slider-{{ $randomNumber }}-custom-padding historie-slider-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         @if ($backgroundImageId)
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax) background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}"
         @endif>
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }} px-8">
        <div class="{{ $blockClass }} mx-auto">
            <div class="historie-slider-header flex items-start justify-between gap-6 pb-6 lg:pb-8">
                <div class="text">
                    @if ($subTitle)
                        <span class="subtitle block mb-2 text-{{ $subTitleColor }} @if ($titleAnimation) title-animation @endif @if ($flyInAnimation) flyin-animation @endif">
                            @if ($subtitleIcon)
                                <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                            @endif
                            {!! $subTitle !!}
                        </span>
                    @endif
                    @if ($title)
                        <h2 class="title text-{{ $titleColor }} @if ($titleAnimation) title-animation @endif @if ($flyInAnimation) flyin-animation @endif">{!! $title !!}</h2>
                    @endif
                    @if ($text)
                        @include('components.content', [
                            'content' => apply_filters('the_content', $text),
                            'class' => 'mt-4 text-' . $textColor . ($flyInAnimation ? ' flyin-animation' : ''),
                        ])
                    @endif
                    @if (($button1Text) && ($button1Link))
                        <div class="buttons w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 @if ($flyInAnimation) flyin-animation @endif">
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
                @if (count($items) > 1 && $showNavigation)
                    <div class="historie-slider-nav flex shrink-0 gap-2">
                        <button type="button" class="historie-slider-prev" aria-label="Vorige">
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M8.5 1.5 2 8l6.5 6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="historie-slider-next" aria-label="Volgende">
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M1.5 1.5 8 8l-6.5 6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                @endif
            </div>
            <div class="historie-slider-line"></div>

            @if ($items)
                <div class="historie-slider-viewport @if ($outsideContainer) is-outside-container @endif">
                    <div class="slider historie-swiper swiper" data-config='@json($sliderConfig)'>
                        <div class="swiper-wrapper">
                            @foreach ($items as $item)
                                <div class="swiper-slide historie-slide">
                                    @if ($item['image'])
                                        <div class="historie-slide-image">
                                            {!! wp_get_attachment_image($item['image'], 'medium_large', false, ['loading' => 'lazy', 'alt' => get_post_meta($item['image'], '_wp_attachment_image_alt', true)]) !!}
                                        </div>
                                    @endif
                                    <div class="historie-slide-info">
                                        <div class="historie-slide-card">
                                            @if ($item['year'])
                                                <h3 class="historie-slide-year">{{ $item['year'] }}</h3>
                                            @endif
                                            @if ($item['text'])
                                                <p class="historie-slide-text">{!! nl2br(e($item['text'])) !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if ($paginationStyle !== 'none')
                        <div class="historie-slider-pagination swiper-pagination"></div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .historie-slider-{{ $randomNumber }}-custom-padding {
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

    .historie-slider-{{ $randomNumber }}-custom-margin {
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
@if ($items)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const root = document.querySelector('.block-{{ $randomNumber }}');
            const el = root ? root.querySelector('.historie-swiper') : null;
            if (!el || typeof window.Swiper === 'undefined') return;

            const cfg = JSON.parse(el.dataset.config || '{}');
            const per = cfg.perView || {};
            const canLoop = (n) => cfg.loop && cfg.count > Math.ceil(n);
            const bp = (n) => ({ slidesPerView: n, loop: canLoop(n), rewind: !cfg.loop && cfg.autoplay });

            const options = {
                spaceBetween: cfg.spaceBetween || 0,
                speed: 600,
                grabCursor: true,
                centeredSlides: !!cfg.centered,
                watchOverflow: true,
                navigation: {
                    prevEl: root.querySelector('.historie-slider-prev'),
                    nextEl: root.querySelector('.historie-slider-next'),
                    disabledClass: 'is-disabled',
                },
                breakpoints: {
                    0: bp(per.mobile || 1),
                    640: bp(per.tablet || 2),
                    1280: bp(per.desktop || 3),
                    1536: bp(per.desktopXl || per.desktop || 3),
                },
            };

            if (cfg.autoplay) {
                options.autoplay = {
                    delay: cfg.autoplaySpeed || 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                };
            }

            if (cfg.pagination && cfg.pagination !== 'none') {
                options.pagination = {
                    el: root.querySelector('.historie-slider-pagination'),
                    clickable: cfg.pagination === 'bullets',
                    type: cfg.pagination === 'progress_bar' ? 'progressbar' : 'bullets',
                };
            }

            new window.Swiper(el, options);
        });
    </script>
@endif
@endif
