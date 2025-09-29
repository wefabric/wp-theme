@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;
    $desktopXlLayout = $block['data']['layout_desktop_xl'] ?? 4;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
        'desktop-xl' => '2xl:grid-cols-' . $desktopXlLayout,
    ];

    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $swiperAutoplaySpeed = max((int)($block['data']['autoplay_speed'] ?? 0) * 1000, 5000);
    $swiperLoop = $block['data']['loop_slides'] ?? true;
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $paginationStyle = $block['data']['pagination_style'] ?? 'bullets';
    $randomId = 'productsSwiper-' . $randomNumber;

    $spaceBetween = $block['data']['space_between'] ?? 20;
@endphp

@if($block['data']['show_slider'])
    <div class="slider block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($products as $product)
                    <div class="swiper-slide h-auto">
                        @include('components.products.list-item')
                    </div>
                @endforeach
            </div>
            @if ($paginationStyle != 'none')
                <div class="swiper-pagination"></div>
            @endif
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next products-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev products-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="product-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($products as $product)
            @include('components.products.list-item')
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .productsSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var productsSwiper = new Swiper(".{{ $randomId }}", {
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
                nextEl: ".products-button-next-{{ $randomNumber }}",
                prevEl: ".products-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($products) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ $swiperLoop && count($products) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($products) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($products) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>