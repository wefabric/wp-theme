@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;
    $desktopXlLayout = $block['data']['layout_desktop_xl'] ?? 4;

     $layoutClasses = [
         'mobile' => 'grid-cols-' . $mobileLayout,
         'tablet' => 'sm:grid-cols-' . $tabletLayout,
         'desktop' => 'lg:grid-cols-' . $desktopLayout,
         'desktop-xl' => '2xl:grid-cols-' . $desktopXlLayout,
     ];

    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $swiperAutoplaySpeed = ($block['data']['autoplay_speed'] ?? 5) * 1000;
    $swiperLoop = $block['data']['loop_slides'] ?? true;
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $paginationStyle = $block['data']['pagination_style'] ?? 'bullets';
    $randomId = 'klantcaseSwiper-' . $randomNumber;

    $spaceBetween = $block['data']['space_between'] ?? 20;
@endphp

@if ($block['data']['show_slider'])
    <div class="slider block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($cases as $case)
                    <div class="swiper-slide h-auto">
                        @if ($layoutVersion == 'featured_layout')
                            @include('components.cases.featured-list-item')
                        @endif
                        @if ($layoutVersion == 'overview_layout')
                            @include('components.cases.overview-list-item')
                        @endif
                    </div>
                @endforeach
            </div>
            @if ($paginationStyle != 'none')
                <div class="swiper-pagination"></div>
            @endif
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next klantcase-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev klantcase-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-8 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($cases as $case)
            @if ($layoutVersion == 'featured_layout')
                @include('components.cases.featured-list-item')
            @endif
            @if ($layoutVersion == 'overview_layout')
                @include('components.cases.overview-list-item')
            @endif
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .klantcaseSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var klantcaseSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: {{ $spaceBetween }},
{{--            @if($swiperDirection == 'vertical')--}}
{{--                direction: 'vertical',--}}
{{--            @endif--}}
            @if ($swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($swiperAutoplay)
                autoplay: {
                    delay: {{ $swiperAutoplaySpeed }},
                    disableOnInteraction: false,
                },
            @endif
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
                nextEl: ".klantcase-button-next-{{ $randomNumber }}",
                prevEl: ".klantcase-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($cases) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ $swiperLoop && count($cases) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($cases) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($cases) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>

@if ($swiperAutoplay)
    <style>
        .{{ $randomId }} .swiper-pagination-bullet-active::after {
            animation: cases-bullet-progress {{ $swiperAutoplaySpeed }}ms linear forwards !important;
        }

        @keyframes cases-bullet-progress {
            from {
                width: 0%;
            }
            to {
                width: 100%;
            }
        }
    </style>
@endif