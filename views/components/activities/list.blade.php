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
    $swiperAutoplaySpeed = max((int)($block['data']['autoplay_speed'] ?? 0) * 1000, 5000);
    $swiperLoop = $block['data']['loop_slides'] ?? true;
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $randomId = 'activiteitenSwiper-' . $randomNumber;
@endphp

@if ($block['data']['show_slider'])
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($activities as $activity)
                    <div class="swiper-slide h-auto">
                        @include('components.activities.list-item')
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next activity-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev activity-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="activity-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($activities as $activity)
            @include('components.activities.list-item')
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .activiteitenSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif


<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var activiteitenSwiper = new Swiper(".{{ $randomId }}", {
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
                nextEl: ".activity-button-next-{{ $randomNumber }}",
                prevEl: ".activity-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($activities) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ $swiperLoop && count($activities) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($activities) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($activities) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>