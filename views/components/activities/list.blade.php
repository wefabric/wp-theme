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

<div class="mobile block sm:hidden">
    @if($showSliderMobile)
        <div class="swiper activiteitenSwiper activiteitenSwiperMobile">
            <div class="swiper-wrapper">
                @foreach ($activities as $activity)
                    <div class="swiper-slide h-full">
                        @include('components.activities.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($activities as $activity)
                @include('components.activities.list-item')
            @endforeach
        </div>
    @endif
</div>

<div class="tablet hidden sm:block lg:hidden">
    @if($showSliderTablet)
        <div class="swiper activiteitenSwiper activiteitenSwiperTablet">
            <div class="swiper-wrapper">
                @foreach ($activities as $activity)
                    <div class="swiper-slide h-full">
                        @include('components.activities.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($activities as $activity)
                @include('components.activities.list-item')
            @endforeach
        </div>
    @endif
</div>

<div class="desktop hidden lg:block">
    @if($showSliderDesktop)
        <div class="swiper activiteitenSwiper activiteitenSwiperDesktop">
            <div class="swiper-wrapper">
                @foreach ($activities as $activity)
                    <div class="swiper-slide h-full">
                        @include('components.activities.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($activities as $activity)
                @include('components.activities.list-item')
            @endforeach
        </div>
    @endif
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
            var uspSwiper = new Swiper(".activiteitenSwiper", {
            spaceBetween: 20,
            loop: true,
            autoplay: {{ $swiperAutoplay }},
            pagination: {
                el: ".swiper-pagination",
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
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