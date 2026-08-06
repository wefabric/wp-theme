@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 1;
    $desktopLayout = $block['data']['layout_desktop'] ?? 1;
    $desktopXlLayout = $block['data']['layout_desktop_xl'] ?? 1;

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
    $randomId = 'employeeStoriesSwiper-' . $randomNumber;

    // CTA tussen medewerkersverhalen (zowel in de grid- als de slider-weergave)
    $showCta = $block['data']['show_cta'] ?? false;
    $ctaPositionType = $block['data']['cta_position_type'] ?? 'end';
    $ctaPositionAfter = (int) ($block['data']['cta_position_after'] ?? 0);

    $gridItems = array_map(fn ($storyId) => ['type' => 'story', 'story' => $storyId], $employeeStories);

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
                            @include('components.employee-stories.cta-item')
                        @else
                            @php($employeeStory = $gridItem['story'])
                            @include('components.employee-stories.list-item')
                        @endif
                    </div>
                @endforeach
            </div>
            @if ($paginationStyle != 'none')
                <div class="swiper-pagination"></div>
            @endif
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next employee-story-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev employee-story-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="employee-story-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($gridItems as $gridItem)
            @if ($gridItem['type'] === 'cta')
                @include('components.employee-stories.cta-item')
            @else
                @php($employeeStory = $gridItem['story'])
                @include('components.employee-stories.list-item')
            @endif
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .employeeStoriesSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var employeeStoriesSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
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
                nextEl: ".employee-story-button-next-{{ $randomNumber }}",
                prevEl: ".employee-story-button-prev-{{ $randomNumber }}",
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