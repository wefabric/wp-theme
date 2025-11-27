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
    $swiperAutoplaySpeed = max((int)($block['data']['autoplay_speed'] ?? 0) * 1000, 5000);
    $randomNumber = rand(0, 1000);
    $randomId = 'privateEventSwiper-' . $randomNumber;
@endphp

@if($block['data']['show_slider'])
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($privateEvents as $privateEvent)
                    <div class="swiper-slide h-auto">
                        @include('components.private-events.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next private-event-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev private-event-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="private-event-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($privateEvents as $privateEvent)
            @include('components.private-events.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var privateEventSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            centeredSlides: false,
            @if ($swiperAutoplay)
            autoplay: {
                delay: {{ $swiperAutoplaySpeed }},
                disableOnInteraction: true,
            },
            @endif
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: ".private-event-button-next-{{ $randomNumber }}",
                prevEl: ".private-event-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($privateEvents) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ count($privateEvents) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($privateEvents) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>