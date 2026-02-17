@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 3;
    $tabletLayout = $block['data']['layout_tablet'] ?? 3;
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
    if (!isset($randomNumber)) { if (!isset($randomNumber)) { \Theme\Views\Components\BlockComponent::$blockCounter++; $randomNumber = \Theme\Views\Components\BlockComponent::$blockCounter; } }
    $randomId = 'uspSwiper-' . $randomNumber;
@endphp

@if($block['data']['show_slider'])
    <div class="slider usp-swiper block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($usps as $usp)
                    <div class="swiper-slide h-auto">
                        @include('components.usps.list-item')
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next usps-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev usps-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="usp-grid grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-8 lg:gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($usps as $usp)
            @include('components.usps.list-item')
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .uspSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var uspSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            @if ($swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($swiperAutoplay)
                autoplay: {
                    delay: {{ $swiperAutoplaySpeed }},
                    disableOnInteraction: true,
                },
            @endif
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: ".usps-button-next-{{ $randomNumber }}",
                prevEl: ".usps-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($usps) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ $swiperLoop && count($usps) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($usps) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($usps) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>