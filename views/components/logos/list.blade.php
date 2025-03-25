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

    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $swiperAutoplaySpeed = $block['data']['autoplay_speed'] * 1000 ?? 5000;

    $swiperLinear = $block['data']['linear_rotation'] ?? false;
    $swiperDirection = $block['data']['swiper_direction'] ?? 'left';
    $swiperRotationSpeed = [
        'super_slow' => 15000,
        'slow' => 10000,
        'normal' => 5000,
        'fast' => 3000,
        'super_fast' => 1000,
    ][$block['data']['rotation_speed']] ?? 5000;

    $randomId = 'logosSwiper-' . $randomNumber;
    $logoCount = count($logos);

    // Determine $gridStartClass based on $logoCount
    if ($logoCount === 1) {
        $gridStartClass = 'col-start-4';
    } elseif ($logoCount === 2) {
        $gridStartClass = 'col-start-3';
    } elseif ($logoCount === 3) {
        $gridStartClass = 'col-start-2';
    } else {
        $gridStartClass = '';
    }
@endphp

@if($block['data']['show_slider'])
    <div class="swiper-container block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($logos as $logo)
                    <div class="swiper-slide h-auto">
                        @include('components.logos.list-item')
                    </div>
                @endforeach
            </div>
            @if (!$swiperLinear)
                <div class="lg:hidden swiper-pagination"></div>
            @endif
        </div>
        @if (!$swiperLinear)
            <div class="swiper-navigation">
                <div class="swiper-button-next logos-button-next-{{ $randomNumber }}"></div>
                <div class="swiper-button-prev logos-button-prev-{{ $randomNumber }}"></div>
            </div>
        @endif
    </div>

@elseif($block['data']['alternative_row_layout'])
    <div class="logo-list hidden md:grid grid-cols-8 gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $index => $logo)
            <div class="col-span-2 {{ ($index + 1) % 7 === 5 ? 'col-start-2' : '' }} {{ $index === 0 ? $gridStartClass : '' }}">
                @include('components.logos.list-item')
            </div>
        @endforeach
    </div>

    <div class="logo-list grid md:hidden {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $logo)
            @include('components.logos.list-item')
        @endforeach
    </div>

@else
    <div class="logo-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $logo)
            @include('components.logos.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var logosSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            centeredSlides: false,

            @if ($swiperLinear)
                freeMode: true,
                allowTouchMove: false,
                speed: {{ $swiperRotationSpeed }},
            @endif

            @if ($swiperAutoplay)
                autoplay: {
                    delay: @if ($swiperLinear) 0 @else {{ $swiperAutoplaySpeed }} @endif,
                    disableOnInteraction: @if ($swiperLinear) true @else false @endif,
                    reverseDirection: {{ $swiperDirection === 'right' ? 'true' : 'false' }},
                },
            @endif
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: ".logos-button-next-{{ $randomNumber }}",
                prevEl: ".logos-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($logos) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ count($logos) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($logos) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ count($logos) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>

@if ($swiperLinear)
    <style>
        .logos-{{ $randomNumber }} .swiper-wrapper {
            transition-timing-function: linear !important;
        }
    </style>
@endif