@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;
    $desktopXlLayout = $block['data']['layout_desktop_xl'] ?? 4;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'xl:grid-cols-' . $desktopLayout,
        'desktop-xl' => '2xl:grid-cols-' . $desktopXlLayout,
    ];

    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $swiperAutoplaySpeed = max((int)($block['data']['autoplay_speed'] ?? 0) * 1000, 5000);
    $swiperLoop = $block['data']['loop_slides'] ?? true;
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $paginationStyle = $block['data']['pagination_style'] ?? 'bullets';
    $randomId = 'kaartenBlockSwiper-' . $randomNumber;

    $spaceBetween = $block['data']['space_between'] ?? 20;

    // CTA tussen kaarten (zowel in de grid- als de slider-weergave)
    $showCta = $block['data']['show_cta'] ?? false;
    $ctaPositionType = $block['data']['cta_position_type'] ?? 'end';
    $ctaPositionAfter = (int) ($block['data']['cta_position_after'] ?? 0);

    $gridItems = array_map(fn ($pageItem) => ['type' => 'page', 'page' => $pageItem], $pagesData);

    if ($showCta) {
        $ctaInsertAt = $ctaPositionType === 'after_item'
            ? min(max($ctaPositionAfter, 0), count($gridItems))
            : count($gridItems);

        array_splice($gridItems, $ctaInsertAt, 0, [['type' => 'cta']]);
    }
@endphp

@if($block['data']['show_slider'])
    <div class="slider block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($gridItems as $gridItem)
                    <div class="swiper-slide h-auto">
                        @if ($gridItem['type'] === 'cta')
                            @include('components.cardblock.cta-item')
                        @else
                            @php($page = $gridItem['page'])
                            @include('components.cardblock.list-item')
                        @endif
                    </div>
                @endforeach
            </div>
            @if ($paginationStyle != 'none')
                <div class="swiper-pagination"></div>
            @endif
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next cardblock-button-next-{{$randomNumber}}"></div>
            <div class="swiper-button-prev cardblock-button-prev-{{$randomNumber}}"></div>
        </div>
    </div>
@else
    <div class="card-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-4 gap-x-4 lg:gap-x-8 lg:gap-y-8 py-8">
        @foreach ($gridItems as $gridItem)
            @if ($gridItem['type'] === 'cta')
                @include('components.cardblock.cta-item')
            @else
                @php($page = $gridItem['page'])
                @include('components.cardblock.list-item')
            @endif
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .kaartenBlockSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var kaartBlockSwiper = new Swiper(".{{ $randomId }}", {
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
                nextEl: ".cardblock-button-next-{{ $randomNumber }}",
                prevEl: ".cardblock-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($gridItems) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ $swiperLoop && count($gridItems) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($gridItems) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($gridItems) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>