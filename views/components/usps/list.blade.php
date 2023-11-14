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
    $randomNumber = rand(0, 1000);
    $randomId = 'uspSwiper-' . $randomNumber;
@endphp

@if($block['data']['show_slider'])
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($usps as $usp)
                    <div class="swiper-slide h-full">
                        @include('components.usps.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next usps-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev usps-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-8 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($usps as $usp)
            @include('components.usps.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var uspSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 120,
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
                nextEl: ".usps-button-next-{{ $randomNumber }}",
                prevEl: ".usps-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($usps) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ count($usps) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($usps) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>