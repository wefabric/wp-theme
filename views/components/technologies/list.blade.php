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
    $randomNumber = rand(0, 1000);
    $randomId = 'technologiesSwiper-' . $randomNumber;
@endphp

@if($block['data']['show_slider'])
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($technologies as $technology)
                    <div class="swiper-slide h-auto">
                        @include('components.technologies.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next technology-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev technology-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="technology-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($technologies as $technology)
            @include('components.technologies.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var technologiesSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
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
                nextEl: ".technology-button-next-{{ $randomNumber }}",
                prevEl: ".technology-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($technologies) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ count($technologies) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($technologies) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>