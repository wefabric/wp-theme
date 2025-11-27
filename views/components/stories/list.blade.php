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
    $randomId = 'storySwiper-' . $randomNumber;
@endphp

@if($block['data']['show_slider'])
    <div class="block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper">
                @foreach ($stories as $story)
                    <div class="swiper-slide h-auto">
                        @include('components.stories.list-item')
                    </div>
                @endforeach
            </div>
            <div class="lg:hidden swiper-pagination"></div>
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next story-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev story-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="story-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} gap-y-16 gap-x-4 lg:gap-x-8 py-8">
        @foreach ($stories as $story)
            @include('components.stories.list-item')
        @endforeach
    </div>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var storiesSwiper = new Swiper(".{{ $randomId }}", {
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
                nextEl: ".story-button-next-{{ $randomNumber }}",
                prevEl: ".story-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{count($stories) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ count($stories) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ count($stories) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });
    });
</script>