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
    $randomId = 'logosSwiper-' . $randomNumber;

    $logoCount = count($logos);

    // Determine $gridStartClass based on $logoCount
    if ($logoCount === 1) {
        $gridStartClass = 'col-start-4';
    } elseif ($logoCount === 2) {
        $gridStartClass = 'col-start-3';
    } elseif ($logoCount === 3) {
        $gridStartClass = 'col-start-2';
    } else {
        $gridStartClass = '';
    }
@endphp

@if($block['data']['show_slider'])
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($logos as $logo)
                    <div class="swiper-slide h-auto">
                        @include('components.logos.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next logos-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev logos-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>

@elseif($block['data']['alternative_row_layout'])
    <div class="logo-list hidden md:grid grid-cols-8 gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $index => $logo)
            <div class="col-span-2 {{ ($index + 1) % 7 === 5 ? 'col-start-2' : '' }} {{ $index === 0 ? $gridStartClass : '' }}">
                @include('components.logos.list-item')
            </div>
        @endforeach
    </div>

    <div class="logo-list grid md:hidden {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $logo)
            @include('components.logos.list-item')
        @endforeach
    </div>

@else
    <div class="logo-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-4 gap-x-4 py-8">
        @foreach ($logos as $logo)
            @include('components.logos.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var logosSwiper = new Swiper(".{{ $randomId }}", {
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
                nextEl: ".logos-button-next-{{ $randomNumber }}",
                prevEl: ".logos-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($logos) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ count($logos) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($logos) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>