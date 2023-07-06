@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $showSliderMobile = count($posts) > $mobileLayout && $block['data']['show_slider'] == true;
    $showSliderTablet = count($posts) > $tabletLayout && $block['data']['show_slider'] == true;
    $showSliderDesktop = count($posts) > $desktopLayout && $block['data']['show_slider'] == true;

    $swiperAutoplay = $block['data']['autoplay'] ? 'true' : 'false';
@endphp

<div class="mobile block sm:hidden">
    @if($showSliderMobile)
        <div class="swiper nieuwsSwiper nieuwsSwiperMobile">
            <div class="swiper-wrapper">
                @foreach ($posts as $post)
                    <div class="swiper-slide h-full">
                        @include('components.news.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($posts as $post)
                @include('components.news.list-item')
            @endforeach
        </div>
    @endif
</div>

<div class="tablet hidden sm:block lg:hidden">
    @if($showSliderTablet)
        <div class="swiper nieuwsSwiper nieuwsSwiperTablet">
            <div class="swiper-wrapper">
                @foreach ($posts as $post)
                    <div class="swiper-slide h-full">
                        @include('components.news.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($posts as $post)
                @include('components.news.list-item')
            @endforeach
        </div>
    @endif
</div>

<div class="desktop hidden lg:block">
    @if($showSliderDesktop)
        <div class="swiper nieuwsSwiper nieuwsSwiperDesktop">
            <div class="swiper-wrapper">
                @foreach ($posts as $post)
                    <div class="swiper-slide h-full">
                        @include('components.news.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
            <div class="text-primary hidden lg:block swiper-button-next"></div>
            <div class="text-primary hidden lg:block swiper-button-prev"></div>
        </div>
    @else
        <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8">
            @foreach ($posts as $post)
                @include('components.news.list-item')
            @endforeach
        </div>
    @endif
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
            var uspSwiper = new Swiper(".nieuwsSwiper", {
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