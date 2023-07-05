@php
    $layout = $block['data']['layout'] ?? 1;
    $layoutClass = '';
    if ($layout == 1) {
        $layoutClass = 'grid-cols-1';
    } elseif ($layout == 2) {
        $layoutClass = 'grid-cols-2';
    } elseif ($layout == 3) {
        $layoutClass = 'grid-cols-3 w-full mx-auto lg:w-3/4 xl:w-2/3';
    } elseif ($layout == 4) {
        $layoutClass = 'grid-cols-4 w-full mx-auto lg:w-3/4 xl:w-2/3';
    } elseif ($layout >= 5) {
        $layoutClass = 'grid-cols-5 w-full mx-auto lg:w-3/4 xl:w-2/3';
    }

    $uspsCount = $block['data']['usps'];
    $showSlider = false;
    if ($uspsCount > $layout && $block['data']['show_slider'] == true) {
        $showSlider = true;
    }
@endphp


@if($showSlider)
    <div class="swiper uspSwiper">
        <div class="swiper-wrapper">
            @foreach ($usps as $usp)
                <div class="swiper-slide h-full">
                    @include('components.usps.list-item')
                </div>
            @endforeach
        </div>
        <div class="lg:hidden swiper-pagination"></div>
        <div class="text-primary hidden lg:block swiper-button-next"></div>
        <div class="text-primary hidden lg:block swiper-button-prev"></div>
    </div>
@else
    <div class=" grid {{ $layoutClass }} gap-y-8 gap-x-4 lg:gap-x-8 justify-center ">
        @foreach ($usps as $usp)
            @include('components.usps.list-item')
        @endforeach
    </div>
@endif


<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var uspSwiper = new Swiper(".uspSwiper", {
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