@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;
    $desktopXlLayout = $block['data']['layout_desktop_xl'] ?? 4;

    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $swiperAutoplaySpeed = max((int)($block['data']['autoplay_speed'] ?? 0) * 1000, 5000);
    $swiperLoop = $block['data']['loop_slides'] ?? true;
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $paginationStyle = $block['data']['pagination_style'] ?? 'bullets';
    $randomId = 'photoSliderSwiper-' . $randomNumber;

    $spaceBetween = $block['data']['space_between'] ?? 20;
@endphp

<div class="slider block relative">
    <div class="swiper {{ $randomId }} pt-8 pb-10">
        <div class="swiper-wrapper">
            @foreach ($imagesData as $image)
                <div class="swiper-slide h-auto">
                    @include('components.photo-slider.list-item')
                </div>
            @endforeach
        </div>
        @if ($paginationStyle != 'none')
            <div class="swiper-pagination"></div>
        @endif
    </div>
    <div class="swiper-navigation">
        <div class="swiper-button-next photoslider-button-next-{{ $randomNumber }}"></div>
        <div class="swiper-button-prev photoslider-button-prev-{{ $randomNumber }}"></div>
    </div>
</div>

@if ($swiperOutContainer)
    <style>
        .photoSliderSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var photoSliderSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: {{ $spaceBetween }},
            @if ($swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($swiperAutoplay)
                autoplay: {
                    delay: {{ $swiperAutoplaySpeed }},
                    disableOnInteraction: true,
                },
            @endif
            @if ($paginationStyle != 'none')
                pagination: {
                    el: '.swiper-pagination',
                    @if ($paginationStyle == 'progress_bar')
                        type: 'progressbar',
                    @elseif ($paginationStyle == 'bullets')
                        clickable: true,
                    @endif
                },
            @endif
            navigation: {
                nextEl: ".photoslider-button-next-{{ $randomNumber }}",
                prevEl: ".photoslider-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($imagesData) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ $swiperLoop && count($imagesData) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($imagesData) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($imagesData) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>