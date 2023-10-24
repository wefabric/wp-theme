@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $swiperAutoplay = isset($block['data']['autoplay']) ? ($block['data']['autoplay'] ? 'true' : 'false') : 'false';
@endphp

{{--Mobile--}}
<div class="mobile block sm:hidden relative">
    <div class="swiper fotoSliderSwiper py-8">
        <div class="swiper-wrapper">
            @foreach ($imagesData as $image)
                <div class="swiper-slide h-full">
                    @include('components.photo-slider.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
    </div>
    <div class="swiper-navigation">
        <div class="swiper-button-next photoslider-button-next"></div>
        <div class="swiper-button-prev photoslider-button-prev"></div>
    </div>
</div>

{{--Tablet--}}
<div class="tablet hidden sm:block lg:hidden relative">
    <div class="swiper fotoSliderSwiper py-8">
        <div class="swiper-wrapper">
            @foreach ($imagesData as $image)
                <div class="swiper-slide h-full">
                    @include('components.photo-slider.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
    </div>
    <div class="swiper-navigation">
        <div class="swiper-button-next photoslider-button-next"></div>
        <div class="swiper-button-prev photoslider-button-prev"></div>
    </div>
</div>

{{--Desktop--}}
<div class="desktop hidden lg:block relative">
    <div class="swiper fotoSliderSwiper py-8">
        <div class="swiper-wrapper">
            @foreach ($imagesData as $image)
                <div class="swiper-slide h-full">
                    @include('components.photo-slider.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
    </div>
    <div class="swiper-navigation">
        <div class="swiper-button-next photoslider-button-next"></div>
        <div class="swiper-button-prev photoslider-button-prev"></div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var fotoSliderSwiper = new Swiper(".fotoSliderSwiper", {
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
                nextEl: ".photoslider-button-next",
                prevEl: ".photoslider-button-prev",
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