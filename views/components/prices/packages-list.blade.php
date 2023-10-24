@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $showSliderMobile = count($packages) > $mobileLayout && $block['data']['show_slider'] == true;
    $showSliderTablet = count($packages) > $tabletLayout && $block['data']['show_slider'] == true;
    $showSliderDesktop = count($packages) > $desktopLayout && $block['data']['show_slider'] == true;

    $swiperAutoplay = isset($block['data']['autoplay']) ? ($block['data']['autoplay'] ? 'true' : 'false') : 'false';
@endphp

{{--Mobile--}}
<div class="mobile block sm:hidden relative">
    @if($showSliderMobile)
        <div class="swiper pakkettenSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($packages as $package)
                    <div class="swiper-slide h-full">
                        @include('components.prices.packages-list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next package-button-next"></div>
            <div class="swiper-button-prev package-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 py-8">
            @foreach ($packages as $package)
                @include('components.prices.packages-list-item')
            @endforeach
        </div>
    @endif
</div>

{{--Tablet--}}
<div class="tablet hidden sm:block lg:hidden relative">
    @if($showSliderTablet)
        <div class="swiper pakkettenSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($packages as $package)
                    <div class="swiper-slide h-full">
                        @include('components.prices.packages-list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next package-button-next"></div>
            <div class="swiper-button-prev package-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 py-8">
            @foreach ($packages as $package)
                @include('components.prices.packages-list-item')
            @endforeach
        </div>
    @endif
</div>

{{--Desktop--}}
<div class="desktop hidden lg:block relative">
    @if($showSliderDesktop)
        <div class="swiper pakkettenSwiper py-8">
            <div class="swiper-wrapper">
                @foreach ($packages as $package)
                    <div class="swiper-slide h-full">
                        @include('components.prices.packages-list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next package-button-next"></div>
            <div class="swiper-button-prev package-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 py-8">
            @foreach ($packages as $package)
                @include('components.prices.packages-list-item')
            @endforeach
        </div>
    @endif
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var packagesSwiper = new Swiper(".pakkettenSwiper", {
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
                nextEl: ".package-button-next",
                prevEl: ".package-button-prev",
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