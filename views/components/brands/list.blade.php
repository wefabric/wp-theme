@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'xl:grid-cols-' . $desktopLayout,
    ];

    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    if (!isset($randomNumber)) { if (!isset($randomNumber)) { \Theme\Views\Components\BlockComponent::$blockCounter++; $randomNumber = \Theme\Views\Components\BlockComponent::$blockCounter; } }
    $randomId = 'brandsSwiper-' . $randomNumber;

    $brandsCount = count($brands);

    // Determine $gridStartClass based on $brandsCount
    if ($brandsCount === 1) {
        $gridStartClass = 'col-start-1';
    } elseif ($brandsCount === 2) {
        $gridStartClass = 'col-start-3';
    } elseif ($brandsCount === 3) {
        $gridStartClass = 'col-start-2';
    } else {
        $gridStartClass = '';
    }
@endphp

@if($block['data']['show_slider'])
    <div class="brands-list block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($brands as $brand)
                    <div class="swiper-slide h-auto">
                        @include('components.brands.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next brands-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev brands-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>

@elseif($block['data']['alternative_row_layout'])
    <div class="brand-list hidden md:grid grid-cols-8 gap-y-4 gap-x-4 py-8">
        @foreach ($brands as $index => $brand)
            <div class="col-span-2 {{ ($index + 1) % 7 === 5 ? 'col-start-2' : '' }} {{ $index === 0 ? $gridStartClass : '' }}">
                @include('components.brands.list-item')
            </div>
        @endforeach
    </div>

    <div class="brand-list grid md:hidden {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-4 gap-x-4 py-8">
        @foreach ($brands as $brand)
            @include('components.brands.list-item')
        @endforeach
    </div>

@else
    <div class="brand-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-4 gap-x-4 py-8">
        @foreach ($brands as $brand)
            @include('components.brands.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var brandsSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 0,
            centeredSlides: false,
            loop: true,
            @if ($swiperAutoplay)
            autoplay: {
                disableOnInteraction: true,
            },
            @endif
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: ".brands-button-next-{{ $randomNumber }}",
                prevEl: ".brands-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($brands) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ count($brands) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($brands) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>