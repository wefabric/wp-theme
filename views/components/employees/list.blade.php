@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $showSliderMobile = count($employees) > $mobileLayout && $block['data']['show_slider'] == true;
    $showSliderTablet = count($employees) > $tabletLayout && $block['data']['show_slider'] == true;
    $showSliderDesktop = count($employees) > $desktopLayout && $block['data']['show_slider'] == true;

    $swiperAutoplay = $block['data']['autoplay'] ? 'true' : 'false';
    $swiperAutoplay = $swiperAutoplay ?? 'false';
@endphp

<div class="mobile block sm:hidden">
    @if($showSliderMobile)
        <div class="swiper werknemerSwiper">
            <div class="swiper-wrapper">
                @foreach ($employees as $employee)
                    <div class="swiper-slide">
                        @include('components.employees.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($employees as $employee)
                @include('components.employees.list-item')
            @endforeach
        </div>
    @endif
</div>

<div class="tablet hidden sm:block lg:hidden">
    @if($showSliderTablet)
        <div class="swiper werknemerSwiper">
            <div class="swiper-wrapper">
                @foreach ($employees as $employee)
                    <div class="swiper-slide">
                        @include('components.employees.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($employees as $employee)
                @include('components.employees.list-item')
            @endforeach
        </div>
    @endif
</div>

<div class="desktop hidden lg:block">
    @if($showSliderDesktop)
        <div class="swiper werknemerSwiper">
            <div class="swiper-wrapper">
                @foreach ($employees as $employee)
                    <div class="swiper-slide">
                        @include('components.employees.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($employees as $employee)
                @include('components.employees.list-item')
            @endforeach
        </div>
    @endif
</div>


<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var uspSwiper = new Swiper(".werknemerSwiper", {
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