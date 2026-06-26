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

        $buttonCardText = $block['data']['card_button_button_text'] ?? '';
        $buttonCardColor = $block['data']['card_button_button_color'] ?? '';
        $buttonCardStyle = $block['data']['card_button_button_style'] ?? '';
        $buttonCardIcon = $block['data']['card_button_button_icon'] ?? '';
        if (!empty($buttonCardIcon)) {
            $iconData = json_decode($buttonCardIcon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $buttonCardIcon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }

        $textPosition = $block['data']['text_position'] ?? '';
        $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
        $textClass = $textClassMap[$textPosition] ?? '';


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = $block['data']['background_image'] ?? '';
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


    // Countdown
    $countdownTime = $block['data']['time'] ?? '';
    $countdownDisplay = $block['data']['timer_display'] ?? [];
    $countdownValueColor = $block['data']['countdown_value_color'] ?? '';
    $countdownLabelColor = $block['data']['countdown_label_color'] ?? '';
    $countdownItemBgColor = $block['data']['countdown_item_background_color'] ?? '';

    // Animaties
    $flyinEffect = $block['data']['flyin_effect'] ?? false;
    $confetti = $block['data']['confetti'] ?? false;
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'countdown' }}@endif" class="block-countdown relative countdown-{{ $randomNumber }}-custom-padding countdown-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax) background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="custom-styling {{ $blockClass }} mx-auto">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $subTitleColor }} {{ $textClass }}">
                    @if ($subtitleIcon)
                        <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                    @endif
                    {!! $subTitle !!}
                </span>
            @endif
            @if ($title)
                <h2 class="title mb-4 text-{{ $titleColor }} {{ $textClass }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'mb-8 text-' . $textColor . ' ' .  $textClass . ($blockWidth == 'fullscreen' ? ' ' : '')
                ])
            @endif

            @if ($countdownTime)
                @php
                    $countdownUnits = [];
                    if(in_array('days',    $countdownDisplay)) $countdownUnits[] = ['id'=>'days',    'label'=>'Dagen'];
                    if(in_array('hours',   $countdownDisplay)) $countdownUnits[] = ['id'=>'hours',   'label'=>'Uren'];
                    if(in_array('minutes', $countdownDisplay)) $countdownUnits[] = ['id'=>'minutes', 'label'=>'Minuten'];
                    if(in_array('seconds', $countdownDisplay)) $countdownUnits[] = ['id'=>'seconds', 'label'=>'Seconden'];
                @endphp
                <div class="countdown-timer countdown-{{ $randomNumber }} mt-6 {{ $textClass }}">
                    <div class="countdown-wrap">
                        @foreach($countdownUnits as $i => $unit)
                            @if($i > 0)
                                <div class="countdown-sep-wrap">
                                    <span class="countdown-sep @if($countdownLabelColor) text-{{ $countdownLabelColor }} @endif">:</span>
                                </div>
                            @endif
                            <div class="countdown-unit @if($flyinEffect) countdown-item-hidden @endif"
                                 style="--unit-delay: {{ $i * 200 }}ms">
                                <div class="countdown-card @if($countdownItemBgColor) bg-{{ $countdownItemBgColor }} @endif" id="{{ $unit['id'] }}-{{ $randomNumber }}">
                                    <span class="countdown-number @if($countdownValueColor) text-{{ $countdownValueColor }} @endif">00</span>
                                    <span class="countdown-label @if($countdownLabelColor) text-{{ $countdownLabelColor }} @endif">
                                        {{ $unit['label'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (($button1Text) && ($button1Link))
                <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $textClass }} container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif">
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
    .countdown-{{ $randomNumber }}-custom-padding {
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

    .countdown-{{ $randomNumber }}-custom-margin {
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

    /* Countdown */
    .countdown-wrap {
        display: flex;
        align-items: stretch;
        gap: 12px;
        width: 100%;
    }

    .countdown-unit {
        flex: 1;
        min-width: 0;
    }

    .countdown-card {
        width: 100%;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        gap: 8px;
        @if(!$countdownItemBgColor) background: #1e293b; @endif
    }

    .countdown-number {
        font-size: clamp(2rem, 5vw, 5rem);
        display: block;
        @if(!$countdownValueColor) color: #ffffff; @endif
    }

    .countdown-label {
        font-size: clamp(0.45rem, 1vw, 0.8rem);
        white-space: nowrap;
        @if(!$countdownLabelColor) color: #ffffff; @endif
    }

    .countdown-sep-wrap {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .countdown-sep {
        font-size: clamp(1rem, 2.5vw, 2rem);
        @if(!$countdownLabelColor) color: currentColor; @endif
    }

    @media (max-width: 640px) {
        .countdown-sep-wrap { display: none; }
    }

    .countdown-number-exit {
        animation: numSlideOut 0.2s ease-in forwards;
    }
    .countdown-number-enter {
        animation: numSlideIn 0.2s ease-out forwards;
    }

    @keyframes numSlideOut {
        from { transform: translateY(0);   opacity: 1; }
        to   { transform: translateY(60%); opacity: 0; }
    }
    @keyframes numSlideIn {
        from { transform: translateY(-60%); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }

    /* Fly-in */
    .countdown-item-hidden {
        opacity: 0;
        transform: translateY(30px);
    }
    .countdown-item-visible {
        animation: unitFlyIn 0.5s ease-out forwards;
    }

    @keyframes unitFlyIn {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

@if ($countdownTime)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var countdownDate = {{ $countdownTime ? strtotime($countdownTime) * 1000 : 0 }};
        var countdownDisplay = @json($countdownDisplay);
        var confettiEnabled = {{ (int) $confetti }};
        var flyinEnabled = {{ (int) $flyinEffect }};
        var rn = {{ $randomNumber }};

        // --- Nummer updaten met slide-animatie ---
        function setUnit(unitId, value) {
            var card = document.getElementById(unitId + '-' + rn);
            if (!card) return;
            var numEl = card.querySelector('.countdown-number');
            if (!numEl) return;
            var padded = String(value).padStart(2, '0');
            if (numEl.textContent === padded) return;

            numEl.classList.add('countdown-number-exit');
            setTimeout(function() {
                numEl.textContent = padded;
                numEl.classList.remove('countdown-number-exit');
                numEl.classList.add('countdown-number-enter');
                setTimeout(function() {
                    numEl.classList.remove('countdown-number-enter');
                }, 200);
            }, 200);
        }

        // --- Fly-in ---
        if (flyinEnabled) {
            var units = Array.from(document.querySelectorAll('.countdown-' + rn + ' .countdown-item-hidden'));
            var obs = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var el = entry.target;
                        var delay = parseInt(el.style.getPropertyValue('--unit-delay')) || 0;
                        observer.unobserve(el);
                        setTimeout(function() {
                            el.classList.remove('countdown-item-hidden');
                            el.classList.add('countdown-item-visible');
                        }, delay);
                    }
                });
            }, { root: null, rootMargin: '0px', threshold: 0 });
            units.forEach(function(el) { obs.observe(el); });
        }

        // --- Countdown loop ---
        function tick() {
            var now = new Date().getTime();
            var distance = countdownDate - now;
            var total = Math.max(Math.floor(distance / 1000), 0);
            var days = 0, hours = 0, minutes = 0, seconds = 0;

            if (countdownDisplay.includes('days')) {
                days = Math.floor(total / 86400);
                total -= days * 86400;
            }
            if (countdownDisplay.includes('hours')) {
                hours = Math.floor(total / 3600);
                total -= hours * 3600;
            }
            if (countdownDisplay.includes('minutes')) {
                minutes = Math.floor(total / 60);
                total -= minutes * 60;
            }
            if (countdownDisplay.includes('seconds')) {
                seconds = total;
            }

            if (countdownDisplay.includes('days'))    setUnit('days',    days);
            if (countdownDisplay.includes('hours'))   setUnit('hours',   hours);
            if (countdownDisplay.includes('minutes')) setUnit('minutes', minutes);
            if (countdownDisplay.includes('seconds')) setUnit('seconds', seconds);

            if (distance <= 0) {
                clearInterval(timer);
                if (confettiEnabled) {
                    if (typeof confetti === 'function') {
                        startConfetti();
                    }
                }
            }
        }

        var timer = setInterval(tick, 1000);
        tick(); // direct eerste waarde tonen

        function startConfetti() {
            var duration = 10000;
            var end = Date.now() + duration;
            var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 9999 };
            function rnd(min, max) { return Math.random() * (max - min) + min; }
            var iv = setInterval(function() {
                var left = end - Date.now();
                if (left <= 0) { return clearInterval(iv); }
                var n = 50 * (left / duration);
                confetti(Object.assign({}, defaults, { particleCount: n, origin: { x: rnd(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount: n, origin: { x: rnd(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@endif
