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

<div class="mobile block sm:hidden">
    <div class="swiper fotoSliderSwiper">
        <div class="swiper-wrapper">
            @foreach ($imagesData as $image)
                <div class="swiper-slide h-full">
                    @include('components.foto-slider.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
        <div class="text-primary hidden lg:block swiper-button-next"></div>
        <div class="text-primary hidden lg:block swiper-button-prev"></div>
    </div>
</div>

<div class="tablet hidden sm:block lg:hidden">
    <div class="swiper fotoSliderSwiper">
        <div class="swiper-wrapper">
            @foreach ($imagesData as $image)
                <div class="swiper-slide h-full">
                    @include('components.foto-slider.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
        <div class="text-primary hidden lg:block swiper-button-next"></div>
        <div class="text-primary hidden lg:block swiper-button-prev"></div>
    </div>
</div>

<div class="desktop hidden lg:block">
    <div class="swiper fotoSliderSwiper">
        <div class="swiper-wrapper">
            @foreach ($imagesData as $image)
                <div class="swiper-slide h-full">
                    @include('components.foto-slider.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
        <div class="text-primary hidden lg:block swiper-button-next"></div>
        <div class="text-primary hidden lg:block swiper-button-prev"></div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var uspSwiper = new Swiper(".fotoSliderSwiper", {
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