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
    $randomId = 'projectSwiper-' . $randomNumber;

    $spaceBetween = $block['data']['space_between'] ?? 20;
@endphp

@if($block['data']['show_slider'])
    <div class="slider block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($projects as $project)
                    <div class="swiper-slide h-auto">
                        @include('components.projects.list-item')
                    </div>
                @endforeach
            </div>
            @if ($paginationStyle != 'none')
                <div class="swiper-pagination"></div>
            @endif
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next project-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev project-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="project-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($projects as $project)
            @include('components.projects.list-item')
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .projectSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var projectSwiper = new Swiper(".{{ $randomId }}", {
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
                nextEl: ".project-button-next-{{ $randomNumber }}",
                prevEl: ".project-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($projects) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ $swiperLoop && count($projects) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($projects) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($projects) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>