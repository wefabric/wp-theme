@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $showSliderMobile = count($activities) > $mobileLayout && $block['data']['show_slider'] == true;
    $showSliderTablet = count($activities) > $tabletLayout && $block['data']['show_slider'] == true;
    $showSliderDesktop = count($activities) > $desktopLayout && $block['data']['show_slider'] == true;

    $swiperAutoplay = isset($block['data']['autoplay']) ? ($block['data']['autoplay'] ? 'true' : 'false') : 'false';
@endphp

{{--Mobile--}}
<div class="mobile block sm:hidden relative">
    @if($showSliderMobile)
        <div class="swiper activiteitenSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($activities as $activity)
                    <div class="swiper-slide h-full">
                        @include('components.activities.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next activity-button-next"></div>
            <div class="swiper-button-prev activity-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 py-8">
            @foreach ($activities as $activity)
                @include('components.activities.list-item')
            @endforeach
        </div>
    @endif
</div>

{{--Tablet--}}
<div class="tablet hidden sm:block lg:hidden relative">
    @if($showSliderTablet)
        <div class="swiper activiteitenSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($activities as $activity)
                    <div class="swiper-slide h-full">
                        @include('components.activities.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next activity-button-next"></div>
            <div class="swiper-button-prev activity-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 py-8">
            @foreach ($activities as $activity)
                @include('components.activities.list-item')
            @endforeach
        </div>
    @endif
</div>

{{--Desktop--}}
<div class="desktop hidden lg:block relative">
    @if($showSliderDesktop)
        <div class="swiper activiteitenSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($activities as $activity)
                    <div class="swiper-slide h-full">
                        @include('components.activities.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next activity-button-next"></div>
            <div class="swiper-button-prev activity-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 py-8">
            @foreach ($activities as $activity)
                @include('components.activities.list-item')
            @endforeach
        </div>
    @endif
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var activiteitenSwiper = new Swiper(".activiteitenSwiper", {
            spaceBetween: 20,
            loop: true,
            @if ($swiperAutoplay)
            autoplay: {
                disableOnInteraction: false,
            },
            @endif
            pagination: {
                el: ".swiper-pagination",
            },
            navigation: {
                nextEl: ".activity-button-next",
                prevEl: ".activity-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    slidesPerView: {{ $desktopLayout }},
                }
            }
        });
    });
</script>