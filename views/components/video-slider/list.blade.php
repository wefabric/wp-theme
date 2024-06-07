@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $showSlider = $block['data']['show_slider'] ?? false;
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $randomNumber = rand(0, 1000);
    $randomId = 'videoSliderSwiper-' . $randomNumber;
@endphp

@if ($showSlider)
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper items-center">
                @foreach ($videosData as $video)
                    <div class="swiper-slide h-auto">
                        @include('components.video-slider.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next videoslider-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev videoslider-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-4 gap-x-4 lg:gap-x-8 lg:gap-y-8 py-8">
        @foreach ($videosData as $video)
            @include('components.video-slider.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var videoSliderSwiper = new Swiper(".{{ $randomId }}", {
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
                nextEl: ".videoslider-button-next-{{ $randomNumber }}",
                prevEl: ".videoslider-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($videosData) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ count($videosData) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($videosData) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>