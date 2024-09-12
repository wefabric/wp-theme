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

    // Countdown
    $countdownTime = $block['data']['time'] ?? '';
    $countdownDisplay = $block['data']['timer_display'] ?? '';
    $confetti = $block['data']['confetti'] ?? false;

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

    if ($textPosition === 'left') {
        $textPositionClass = 'justify-start text-left';
        $textWidthClass = ($headerHeight == 3) ? 'w-full' : 'w-full md:w-2/3 xl:w-2/3';
    } elseif ($textPosition === 'center') {
        $textPositionClass = 'justify-center text-center items-center';
           $textWidthClass = ($headerHeight == 3) ? 'w-full' : 'w-full xl:w-3/4';
    } elseif ($textPosition === 'right') {
        $textPositionClass = 'justify-end text-left';
           $textWidthClass = ($headerHeight == 3) ? 'w-full md:w-2/3' : 'w-full md:w-1/2 xl:w-1/3';
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

<section id="header-countdown" class="block-header-countdown relative header-countdown-{{ $randomNumber }}-custom-padding header-countdown-{{ $randomNumber }}-custom-margin bg-{{ $headerBackgroundColor }} {{ $headerName }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }} max-w-[2800px] mx-auto">
    <div class="custom-styling bg-cover bg-center {{ $headerClass }}"
         style="background-image: url('{{ $backgroundImageId ? wp_get_attachment_image_url($backgroundImageId, 'full') : ($featuredImage ? $featuredImage : '') }}'); {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId ?: $featuredImageId) }}">
        @if ($backgroundVideoURL)
            <div class="video-wrapper absolute h-full">
                <video autoplay muted loop playsinline class="video-background absolute inset-0 w-full h-full object-cover">
                    <source src="{{ esc_url($backgroundVideoURL) }}" type="video/mp4">
                </video>
            </div>
        @endif
        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="custom-width relative container mx-auto px-8 h-full flex items-center z-30 {{ $textPositionClass }} @if ($fullHeightContentImage && $textPosition === 'right') justify-end @endif ">
            <div class="header-info z-30 flex flex-col {{ $textWidthClass }} @if ($textPosition === 'left') order-1 @elseif ($textPosition === 'right') order-2 pl-8 @endif">
                @if ($showTitle)
                    @if ($subTitle)
                        <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>
                    @endif
                    <h1 class="title text-{{ $titleColor }}">{!! $title !!}</h1>
                @endif
                @if ($text)
                    @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 text-lg mb-4 text-' . $textColor])
                @endif
                @if ($countdownTime)
                    <div class="countdown-timer mt-6">
                        <div class="time py-4 flex w-fit text-center @if($textPosition === 'left') mr-auto @elseif($textPosition === 'center') mx-auto @elseif ($textPosition === 'right') @endif">
                            @if(in_array('days', $countdownDisplay))
                                <div class="time-section flex flex-col items-center px-4">
                                    <span id="days" class="time-value font-bold">0</span>
                                    <span class="time-text">Dagen</span>
                                </div>
                            @endif
                            @if(in_array('hours', $countdownDisplay))
                                <div class="time-section flex flex-col items-center px-4">
                                    <span id="hours" class="time-value font-bold">0</span>
                                    <span class="time-text">Uren</span>
                                </div>
                            @endif
                            @if(in_array('minutes', $countdownDisplay))
                                <div class="time-section flex flex-col items-center px-4">
                                    <span id="minutes" class="time-value font-bold">0</span>
                                    <span class="time-text">Min</span>
                                </div>
                            @endif
                            @if(in_array('seconds', $countdownDisplay))
                                <div class="time-section flex flex-col items-center px-4">
                                    <span id="seconds" class="time-value font-bold">0</span>
                                    <span class="time-text">Sec</span>
                                </div>
                            @endif
                        </div>
                    </div>
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
        </div>
    </div>
</section>

@if ($customBlockClasses) <div class="breadcrumbs-{{ $customBlockClasses }}"> @endif
    @if ($breadcrumbsEnabled && $breadcrumbsLocation === 'underneath' && !is_front_page() && get_the_ID())
        @include('components.breadcrumbs.index')
    @endif
@if ($customBlockClasses) </div> @endif


<style>
    .header-countdown-{{ $randomNumber }}-custom-padding {
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

    .header-countdown-{{ $randomNumber }}-custom-margin {
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Server-side confetti waarde doorgeven aan JavaScript
        let confettiEnabled = @json($confetti);
        let countdownDate = new Date("{{ $countdownTime }}").getTime();
        let countdownDisplay = @json($countdownDisplay);

        // Interval voor de countdown
        x = setInterval(function() {
            let now = new Date().getTime();
            let distance = countdownDate - now;
            let totalSeconds = Math.floor(distance / 1000);
            let days = 0, hours = 0, minutes = 0, seconds = 0;

            if (distance > 0) {
                // Bepaal de grootste eenheid om weer te geven
                if (countdownDisplay.includes('days')) {
                    days = Math.floor(totalSeconds / (3600 * 24));
                    totalSeconds -= days * 3600 * 24;
                }
                if (countdownDisplay.includes('hours')) {
                    hours = Math.floor(totalSeconds / 3600);
                    totalSeconds -= hours * 3600;
                }
                if (countdownDisplay.includes('minutes')) {
                    minutes = Math.floor(totalSeconds / 60);
                    totalSeconds -= minutes * 60;
                }
                if (countdownDisplay.includes('seconds')) {
                    seconds = totalSeconds;
                }
            }

            // Zorg ervoor dat de tijdwaarden niet negatief worden
            days = Math.max(days, 0);
            hours = Math.max(hours, 0);
            minutes = Math.max(minutes, 0);
            seconds = Math.max(seconds, 0);

            // Toon de resultaten
            if (countdownDisplay.includes('days')) {
                document.getElementById("days").innerText = days;
            }
            if (countdownDisplay.includes('hours')) {
                document.getElementById("hours").innerText = hours;
            }
            if (countdownDisplay.includes('minutes')) {
                document.getElementById("minutes").innerText = minutes;
            }
            if (countdownDisplay.includes('seconds')) {
                document.getElementById("seconds").innerText = seconds;
            }

            // Als de countdown is afgelopen
            if (distance <= 0) {
                clearInterval(x);
                // Zorg ervoor dat alle tijdseenheden op nul blijven staan
                if (countdownDisplay.includes('days')) {
                    document.getElementById("days").innerText = 0;
                }
                if (countdownDisplay.includes('hours')) {
                    document.getElementById("hours").innerText = 0;
                }
                if (countdownDisplay.includes('minutes')) {
                    document.getElementById("minutes").innerText = 0;
                }
                if (countdownDisplay.includes('seconds')) {
                    document.getElementById("seconds").innerText = 0;
                }

                let oneDay = 24 * 60 * 60 * 1000; // 1 dag in milliseconden
                let isWithinOneDay = now <= (countdownDate + oneDay);

                if (isWithinOneDay) {
                    if(confettiEnabled) {
                        startFireworks();
                    }
                }
            }
        }, 1000);
    });

    function startFireworks() {
        const duration = 10 * 1000;
        const animationEnd = Date.now() + duration;
        const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        const interval = setInterval(function() {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            const particleCount = 50 * (timeLeft / duration);

            // Eerste confetti-lading
            confetti(
                Object.assign({}, defaults, {
                    particleCount,
                    origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
                })
            );

            // Tweede confetti-lading
            confetti(
                Object.assign({}, defaults, {
                    particleCount,
                    origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
                })
            );
        }, 250);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
