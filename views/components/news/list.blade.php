@php
    $layout = $block['data']['layout'] ?? 1;
    $layoutClass = '';
    if ($layout == 1) {
        $layoutClass = 'grid-cols-1';
    } elseif ($layout == 2) {
        $layoutClass = 'grid-cols-2';
    } elseif ($layout == 3) {
        $layoutClass = 'grid-cols-3';
    } elseif ($layout == 4) {
        $layoutClass = 'grid-cols-4';
    } elseif ($layout >= 5) {
        $layoutClass = 'grid-cols-5';
    }

    $showSlider = false;
    if (count($posts) > $layout && $block['data']['show_slider'] == true) {
        $showSlider = true;
    }
@endphp


@if($showSlider)
    <div class="swiper nieuwsSwiper">
        <div class="swiper-wrapper">
            @foreach ($posts as $post)
                <div class="swiper-slide h-full">
                    @include('components.news.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
        <div class="text-primary hidden lg:block swiper-button-next"></div>
        <div class="text-primary hidden lg:block swiper-button-prev"></div>
    </div>
@else
    <div class="grid {{ $layoutClass }} gap-y-8 gap-x-4 lg:gap-x-8">
        @foreach ($posts as $post)
            @include('components.news.list-item')
        @endforeach
    </div>
@endif


<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var uspSwiper = new Swiper(".nieuwsSwiper", {
            slidesPerView: 'auto',
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: {{ $layout - 1 }},
                },
                768: {
                    slidesPerView: {{ $layout }},
                },
                1280: {
                    slidesPerView: {{ $layout }},
                }
            }
        });
    });
</script>