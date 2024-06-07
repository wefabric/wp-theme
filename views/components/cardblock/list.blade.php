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
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $randomId = 'kaartenBlockSwiper-' . $randomNumber;
@endphp

@if ($showSlider)
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($pagesData as $page)
                    <div class="swiper-slide h-auto">
                        @include('components.cardblock.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next cardblock-button-next-{{$randomNumber}}"></div>
            <div class="swiper-button-prev cardblock-button-prev-{{$randomNumber}}"></div>
        </div>
    </div>
@else
    <div class="card-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-4 gap-x-4 lg:gap-x-8 lg:gap-y-8 py-8">
        @foreach ($pagesData as $page)
            @include('components.cardblock.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var kaartBlockSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            @if ($swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($swiperAutoplay)
            autoplay: {
                disableOnInteraction: false,
            },
            @endif
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: ".cardblock-button-next-{{ $randomNumber }}",
                prevEl: ".cardblock-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($pagesData) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ count($pagesData) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($pagesData) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>