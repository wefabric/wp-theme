@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;
    $desktopXlLayout = $block['data']['layout_desktop_xl'] ?? 4;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'xl:grid-cols-' . $desktopLayout,
        'desktop-xl' => '2xl:grid-cols-' . $desktopXlLayout,
    ];

    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $swiperAutoplaySpeed = max((int)($block['data']['autoplay_speed'] ?? 0) * 1000, 5000);
    $swiperLoop = $block['data']['loop_slides'] ?? true;
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;

    $swiperLinear = $block['data']['linear_rotation'] ?? false;
    $swiperDirection = $block['data']['swiper_direction'] ?? 'left';
    $swiperRotationPxPerSec = [
        'super_slow' => 20,
        'slow' => 40,
        'normal' => 70,
        'fast' => 120,
        'super_fast' => 220,
    ][$block['data']['rotation_speed']] ?? 70;

    $paginationStyle = $block['data']['pagination_style'] ?? 'bullets';
    $randomId = 'logosSwiper-' . $randomNumber;
    $spaceBetween = $block['data']['space_between'] ?? 20;

    $logoCount = count($logos);

    // Determine $gridStartClass based on $logoCount
    if ($logoCount === 1) {
        $gridStartClass = 'col-start-4';
    } elseif ($logoCount === 2) {
        $gridStartClass = 'col-start-3';
    } elseif ($logoCount === 3) {
        $gridStartClass = 'col-start-2';
    } else {
        $gridStartClass = '';
    }
@endphp

@if($block['data']['show_slider'])
    <div class="slider swiper-container block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($logos as $logo)
                    <div class="swiper-slide h-auto">
                        @include('components.logos.list-item')
                    </div>
                @endforeach
                @if ($swiperLinear)
                    @foreach (range(1, 2) as $duplicatePass)
                        @foreach ($logos as $logo)
                            <div class="swiper-slide h-auto" aria-hidden="true">
                                @include('components.logos.list-item')
                            </div>
                        @endforeach
                    @endforeach
                @endif
            </div>
            @if (!$swiperLinear && ($paginationStyle != 'none'))
                <div class="swiper-pagination"></div>
            @endif
        </div>
        @if (!$swiperLinear)
            <div class="swiper-navigation">
                <div class="swiper-button-next logos-button-next-{{ $randomNumber }}"></div>
                <div class="swiper-button-prev logos-button-prev-{{ $randomNumber }}"></div>
            </div>
        @endif
    </div>

@elseif($block['data']['alternative_row_layout'])
    <div class="logo-list hidden md:grid grid-cols-8 gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $index => $logo)
            <div class="col-span-2 {{ ($index + 1) % 7 === 5 ? 'col-start-2' : '' }} {{ $index === 0 ? $gridStartClass : '' }}">
                @include('components.logos.list-item')
            </div>
        @endforeach
    </div>

    <div class="logo-list grid md:hidden {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $logo)
            @include('components.logos.list-item')
        @endforeach
    </div>

@else
    <div class="logo-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $logo)
            @include('components.logos.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var logosSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: {{ $spaceBetween }},
            @if ($swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($swiperLinear)
                freeMode: {
                    enabled: true,
                    momentum: false,
                },
            @endif
            @if ($swiperAutoplay && !$swiperLinear)
                autoplay: {
                    delay: {{ $swiperAutoplaySpeed }},
                    disableOnInteraction: false,
                },
            @endif
            @if (!$swiperLinear)
                @if ($paginationStyle != 'none')
                    pagination: {
                        el: '.swiper-pagination',
                        @if ($paginationStyle == 'progress_bar')
                            type: 'progressbar',
                        @elseif ($paginationStyle == 'bullets')
                            clickable: true,
                       @endif
                    },
               @endif
                navigation: {
                    nextEl: ".logos-button-next-{{ $randomNumber }}",
                    prevEl: ".logos-button-prev-{{ $randomNumber }}",
                },
            @endif
            breakpoints: {
                0: {
                    loop: {{ !$swiperLinear && $swiperLoop && count($logos) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ !$swiperLinear && $swiperLoop && count($logos) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ !$swiperLinear && $swiperLoop && count($logos) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ !$swiperLinear && $swiperLoop && count($logos) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
        @if ($swiperAutoplay && $swiperLinear)
            document.querySelector(".{{ $randomId }}").addEventListener('dragstart', function (e) {
                e.preventDefault();
            });

            (function () {
                var direction = {{ $swiperDirection === 'right' ? '1' : '-1' }};
                var pxPerSec = {{ $swiperRotationPxPerSec }};
                var wrapperEl = document.querySelector(".{{ $randomId }} .swiper-wrapper");
                var animationName = "logos-marquee-{{ $randomNumber }}";
                var styleEl = document.createElement('style');
                document.head.appendChild(styleEl);

                wrapperEl.style.willChange = 'transform';

                function currentVisualTranslateX() {
                    var matrix = new DOMMatrixReadOnly(getComputedStyle(wrapperEl).transform);
                    return matrix.m41;
                }

                function passDistance() {
                    // The wrapper now contains the logos three times (see markup
                    // above), so a third of its width is exactly one seamless pass.
                    return logosSwiper.virtualSize / 3;
                }

                function startMarquee(fromTranslate) {
                    var distance = passDistance();
                    var toTranslate = fromTranslate + direction * distance;
                    var durationSec = distance / pxPerSec;

                    styleEl.textContent =
                        '@keyframes ' + animationName + ' {' +
                        'from { transform: translate3d(' + fromTranslate + 'px, 0, 0); }' +
                        'to { transform: translate3d(' + toTranslate + 'px, 0, 0); }' +
                        '}';

                    wrapperEl.style.animation = 'none';
                    void wrapperEl.offsetWidth; // force reflow so the animation restarts cleanly
                    wrapperEl.style.animation = animationName + ' ' + durationSec + 's linear infinite';
                }

                function stopMarquee() {
                    var current = currentVisualTranslateX();
                    wrapperEl.style.animation = 'none';
                    logosSwiper.setTransition(0);
                    logosSwiper.setTranslate(current);
                }

                function recenterToMiddleCopy() {
                    var distance = passDistance();
                    var current = logosSwiper.translate;

                    if (current > -distance) {
                        current -= distance;
                    } else if (current < -2 * distance) {
                        current += distance;
                    }

                    logosSwiper.setTransition(0);
                    logosSwiper.setTranslate(current);
                    return current;
                }

                startMarquee(-passDistance());

                logosSwiper.on('touchStart', function () {
                    stopMarquee();
                });
                logosSwiper.on('touchEnd', function () {
                    startMarquee(recenterToMiddleCopy());
                });
            })();
        @endif
    });
</script>

@if ($swiperOutContainer)
    <style>
        .logosSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

@if ($swiperLinear)
    <style>
        .logos-{{ $randomNumber }} .swiper-wrapper {
            transition-timing-function: linear !important;
        }
    </style>
@endif