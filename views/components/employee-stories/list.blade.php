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
    if (!isset($randomNumber)) { if (!isset($randomNumber)) { \Theme\Views\Components\BlockComponent::$blockCounter++; $randomNumber = \Theme\Views\Components\BlockComponent::$blockCounter; } }
    $paginationStyle = $block['data']['pagination_style'] ?? 'bullets';
    $randomId = 'employeeStoriesSwiper-' . $randomNumber;
@endphp

@if($block['data']['show_slider'])
    <div class="slider block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($employeeStories as $employeeStory)
                    <div class="swiper-slide h-auto">
                        @include('components.employee-stories.list-item')
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
        @foreach ($employeeStories as $employeeStory)
            @include('components.employee-stories.list-item')
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
                    loop: {{ $swiperLoop && count($employeeStories) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ $swiperLoop && count($employeeStories) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($employeeStories) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($employeeStories) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>