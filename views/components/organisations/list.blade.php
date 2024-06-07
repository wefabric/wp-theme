@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 2;
    $desktopLayout = $block['data']['layout_desktop'] ?? 3;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'lg:grid-cols-' . $desktopLayout,
    ];

    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $randomNumber = rand(0, 1000);
    $randomId = 'organisationsSwiper-' . $randomNumber;
@endphp

@if($block['data']['show_slider'])
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($organisations as $organisation)
                    <div class="swiper-slide h-auto">
                        @include('components.organisations.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next organisations-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev organisations-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>

@else
    <div class="organisation-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-12 gap-x-4 py-8">
        @foreach ($organisations as $organisation)
            @include('components.organisations.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var organisationsSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            centeredSlides: false,
            @if ($swiperAutoplay)
            autoplay: {
                disableOnInteraction: false,
            },
            @endif
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: ".organisations-button-next-{{ $randomNumber }}",
                prevEl: ".organisations-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($organisations) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                768: {
                    loop: {{ count($organisations) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($organisations) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>