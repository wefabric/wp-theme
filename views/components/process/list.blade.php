@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    if (!isset($randomNumber)) { if (!isset($randomNumber)) { \Theme\Views\Components\BlockComponent::$blockCounter++; $randomNumber = \Theme\Views\Components\BlockComponent::$blockCounter; } }
    $randomId = 'process-' . $randomNumber;

    $spaceBetween = $block['data']['space_between'] ?? 40;
@endphp

<div class="block relative h-full">
    <div class="swiper {{ $randomId }} pt-32 md:pt-44 pb-16">
        <div class="swiper-wrapper process-swiper">
            @foreach ($processSteps as $index => $processStep)
                <div class="swiper-slide h-auto">
                    @include('components.process.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
    </div>
    <div class="swiper-navigation">
        <div class="swiper-button-next process-button-next-{{ $randomNumber }}"></div>
        <div class="swiper-button-prev process-button-prev-{{ $randomNumber }}"></div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var processSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: {{ $spaceBetween }},
            centeredSlides: false,
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
                nextEl: ".process-button-next-{{ $randomNumber }}",
                prevEl: ".process-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($processSteps) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ count($processSteps) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($processSteps) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>