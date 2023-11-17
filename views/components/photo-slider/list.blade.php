@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $swiperAutoplay =  $block['data']['autoplay'] ?? false;
    $randomNumber = rand(0, 1000);
    $randomId = 'photoSliderSwiper-' . $randomNumber;
@endphp

<div class="block relative">
    <div class="swiper {{ $randomId }} py-8">
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
        <div class="swiper-button-next photoslider-button-next-{{ $randomNumber }}"></div>
        <div class="swiper-button-prev photoslider-button-prev-{{ $randomNumber }}"></div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var photoSliderSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            centeredSlides: false,
            @if ($swiperAutoplay)
            autoplay: {
                disableOnInteraction: false,
            },
            @endif
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: ".photoslider-button-next-{{ $randomNumber }}",
                prevEl: ".photoslider-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($imagesData) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ count($imagesData) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($imagesData) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>