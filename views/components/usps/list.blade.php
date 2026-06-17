@php
    $randomNumber = rand(0, 1000);
    $randomId = 'uspSwiper-' . $randomNumber;

    $layoutClasses = [
        'mobile'     => 'grid-cols-' . $uspBlock->mobileLayout,
        'tablet'     => 'sm:grid-cols-' . $uspBlock->tabletLayout,
        'desktop'    => 'xl:grid-cols-' . $uspBlock->desktopLayout,
        'desktop-xl' => '2xl:grid-cols-' . $uspBlock->desktopXlLayout,
    ];
@endphp

@if($uspBlock->showSlider)
    <div class="slider usp-swiper block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($usps as $usp)
                    <div class="swiper-slide h-auto">
                        @include('components.usps.list-item')
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next usps-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev usps-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="usp-grid grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-8 lg:gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($usps as $usp)
            @include('components.usps.list-item')
        @endforeach
    </div>
@endif

@if ($uspBlock->swiperOutContainer)
    <style>
        .uspSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var uspSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            @if ($uspBlock->swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($uspBlock->swiperAutoplay)
                autoplay: {
                    delay: {{ $uspBlock->swiperAutoplaySpeed }},
                    disableOnInteraction: true,
                },
            @endif
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: ".usps-button-next-{{ $randomNumber }}",
                prevEl: ".usps-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $uspBlock->swiperLoop && count($usps) > $uspBlock->mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $uspBlock->mobileLayout }},
                },
                640: {
                    loop: {{ $uspBlock->swiperLoop && count($usps) > $uspBlock->tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $uspBlock->tabletLayout }},
                },
                1280: {
                    loop: {{ $uspBlock->swiperLoop && count($usps) > $uspBlock->desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $uspBlock->desktopLayout }},
                },
                1536: {
                    loop: {{ $uspBlock->swiperLoop && count($usps) > $uspBlock->desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $uspBlock->desktopXlLayout }},
                },
            }
        });
    });
</script>
