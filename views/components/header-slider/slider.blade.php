@php
    $randomNumber = rand(0, 1000);
    $randomId = "{$sliderId}-{$randomNumber}";
@endphp

<div class="header-{{ $sliderId }} block relative overflow-hidden h-full">
    <div class="swiper {{ $randomId }}">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
                <div class="swiper-slide h-auto">
                    @include('components.image', [
                        'image_id' => $image['id'],
                        'size' => 'full',
                        'object_fit' => 'cover',
                        'img_class' => 'h-full w-full rounded-' . $borderRadius,
                        'alt' => $image['alt']
                    ])
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var {{ $sliderId }}Swiper = new Swiper(".{{ $randomId }}", {
            slidesPerView: 2,
            direction: '{{ $direction }}',
            speed: 14000,
            freeMode: true,
            allowTouchMove: false,
            spaceBetween: 30,
            centeredSlides: true,
            loop: true,
            autoplay: {
                disableOnInteraction: true,
                delay: 0,
                reverseDirection: {{ $reverse ? 'true' : 'false' }},
            },
        });
    });
</script>

<style>
    .header-{{ $sliderId }} .swiper-wrapper {
        transition-timing-function: linear;
    }

    .vertical-sliders .swiper-wrapper {
        height: 800px;
    }

    .horizontal-slider {
        height: 100%;
    }

    .horizontal-slider .swiper-slide img {
        height: 200px;
    }

    .horizontal-slider .swiper {
        overflow: visible;
    }

    .header-headerHorizontalSwiper1 {
        overflow: visible;
    }
</style>