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
    (function() {
        function initSwiper() {
            var el = document.querySelector(".{{ $randomId }}");
            if (!el) return;

            // Prevent double init; update if already initialized
            if (el.classList.contains('swiper-initialized')) {
                if (el.swiper) {
                    el.swiper.update();
                    if (el.swiper.autoplay && !el.swiper.autoplay.running) {
                        el.swiper.autoplay.start();
                    }
                }
                return;
            }

            var instance = new Swiper(el, {
                slidesPerView: 2,
                direction: '{{ $direction }}',
                speed: 14000,
                freeMode: true,
                allowTouchMove: false,
                spaceBetween: 30,
                centeredSlides: true,
                loop: true,
                autoplay: {
                    disableOnInteraction: false,
                    delay: 0,
                    reverseDirection: {{ $reverse ? 'true' : 'false' }},
                    pauseOnMouseEnter: false,
                },
                // Make Swiper resilient to late size changes
                observer: true,
                observeParents: true,
                on: {
                    init: function(swiper) {
                        if (swiper.autoplay && !swiper.autoplay.running) {
                            swiper.autoplay.start();
                        }
                    },
                    imagesReady: function(swiper) {
                        swiper.update();
                        if (swiper.autoplay && !swiper.autoplay.running) {
                            swiper.autoplay.start();
                        }
                    }
                }
            });

            // After first frame, ensure measurements are correct and autoplay is running
            requestAnimationFrame(function() {
                if (el && el.swiper) {
                    el.swiper.update();
                    if (el.swiper.autoplay && !el.swiper.autoplay.running) {
                        el.swiper.autoplay.start();
                    }
                }
            });

            // If native lazy images load later, update/start when they finish
            var imgs = el.querySelectorAll('img');
            imgs.forEach(function(img) {
                if (!img.complete) {
                    img.addEventListener('load', function() {
                        if (el && el.swiper) {
                            el.swiper.update();
                            if (el.swiper.autoplay && !el.swiper.autoplay.running) {
                                el.swiper.autoplay.start();
                            }
                        }
                    }, { once: true });
                }
            });
        }

        function safeUpdate() {
            var el = document.querySelector(".{{ $randomId }}");
            if (el && el.swiper) {
                requestAnimationFrame(function() {
                    el.swiper.update();
                    if (el.swiper.autoplay && !el.swiper.autoplay.running) {
                        el.swiper.autoplay.start();
                    }
                });
            }
        }

        if (document.readyState === 'complete') {
            // Page already loaded
            initSwiper();
        } else {
            // Wait for full load to ensure layout/images are ready
            window.addEventListener('load', initSwiper);
        }

        // Update on resize and when tab becomes active
        window.addEventListener('resize', safeUpdate);
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) { safeUpdate(); }
        });
    })();
</script>

<style>
    .header-{{ $sliderId }} .swiper-wrapper {
        transition-timing-function: linear;
    }

    .vertical-sliders .swiper-wrapper {
        height: 800px;
    }

    .horizontal-slider {
        overflow: hidden;
    }

    .horizontal-slider .swiper-slide img {
        height: 200px;
    }

    .horizontal-slider .swiper {
        overflow: hidden;
    }

    .header-headerHorizontalSwiper1 {
        overflow: hidden;
    }
</style>