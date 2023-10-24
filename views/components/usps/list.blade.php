@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $uspsCount = $block['data']['usps'];
    $showSliderMobile = $uspsCount > $mobileLayout && $block['data']['show_slider'] == true;
    $showSliderTablet = $uspsCount > $tabletLayout && $block['data']['show_slider'] == true;
    $showSliderDesktop = $uspsCount > $desktopLayout && $block['data']['show_slider'] == true;

    $swiperAutoplay = $block['data']['autoplay'] ?? false;
@endphp

{{--Mobile--}}
<div class="mobile block sm:hidden relative">
    @if($showSliderMobile)
        <div class="swiper uspSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($usps as $usp)
                    <div class="swiper-slide h-full">
                        @include('components.usps.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation w-full top-1/2 absolute">
            <div class="swiper-button-next usps-button-next text-secondary hidden lg:block"></div>
            <div class="swiper-button-prev usps-button-prev text-secondary hidden lg:block"></div>
        </div>
    @else
        <div class=" grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 justify-center py-8">
            @foreach ($usps as $usp)
                @include('components.usps.list-item')
            @endforeach
        </div>
    @endif
</div>

{{--Tablet--}}
<div class="tablet hidden sm:block lg:hidden relative">
    @if($showSliderTablet)
        <div class="swiper uspSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($usps as $usp)
                    <div class="swiper-slide h-full">
                        @include('components.usps.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation w-full top-1/2 absolute">
            <div class="swiper-button-next usps-button-next text-secondary hidden lg:block"></div>
            <div class="swiper-button-prev usps-button-prev text-secondary hidden lg:block"></div>
        </div>
    @else
        <div class=" grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 justify-center py-8">
            @foreach ($usps as $usp)
                @include('components.usps.list-item')
            @endforeach
        </div>
    @endif
</div>

{{--Desktop--}}
<div class="desktop hidden lg:block relative">
    @if($showSliderDesktop)
        <div class="swiper uspSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($usps as $usp)
                    <div class="swiper-slide h-full">
                        @include('components.usps.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation w-full top-1/2 absolute">
            <div class="swiper-button-next usps-button-next text-secondary hidden lg:block"></div>
            <div class="swiper-button-prev usps-button-prev text-secondary hidden lg:block"></div>
        </div>
    @else
        <div class=" grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 justify-center py-8">
            @foreach ($usps as $usp)
                @include('components.usps.list-item')
            @endforeach
        </div>
    @endif
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var uspSwiper = new Swiper(".uspSwiper", {
            spaceBetween: 20,
            loop: true,
            @if ($swiperAutoplay)
            autoplay: {
                disableOnInteraction: false,
            },
            @endif
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".usps-button-next",
                prevEl: ".usps-button-prev",
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
