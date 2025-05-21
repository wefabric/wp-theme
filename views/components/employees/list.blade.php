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
    $swiperAutoplaySpeed = $block['data']['autoplay_speed'] * 1000 ?? 5000;
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $randomId = 'employeeSwiper-' . $randomNumber;
@endphp

@if($block['data']['show_slider'])
    <div class="slider block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($employees as $employee)
                    <div class="swiper-slide h-auto">
                        @include('components.employees.list-item')
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next employee-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev employee-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="employee-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($employees as $employee)
            @include('components.employees.list-item')
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .employeeSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var employeeSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            @if ($swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($swiperAutoplay)
                autoplay: {
                    delay: {{ $swiperAutoplaySpeed }},
                    disableOnInteraction: false,
                },
            @endif
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: ".employee-button-next-{{ $randomNumber }}",
                prevEl: ".employee-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($employees) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ count($employees) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($employees) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ count($employees) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
    });
</script>